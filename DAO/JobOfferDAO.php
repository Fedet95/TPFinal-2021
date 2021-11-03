<?php

namespace DAO;

use Models\Administrator;
use Models\Career;
use Models\Company;
use Models\JobOffer;
use Models\JobOfferPosition;
use Models\JobPosition;

class JobOfferDAO implements IJobOfferDAO
{
    private $connection;
    private $tableName= "jobOffers";
    private $tableName2= "jobOffers_jobPositions";
    private $tableName3 ="companies";
    private $tableName4 ="administrators";
    private $tableName5 ="careers";
    private $tableName6= "jobPositions";


    function add(JobOffer $jobOffer)
    {
        try
        {
            $query= "INSERT INTO ".$this->tableName."(activeJobOffer , remote, publishDate, endDate, title, dedication, descriptionOffer, salary, creationAdminId, companyId, careerIdOffer) VALUES (:activeJobOffer , :remote, :publishDate, :endDate, :title, :dedication, :descriptionOffer, :salary, :creationAdminId, :companyId, :careerIdOffer)";

            $parameters['activeJobOffer']=$jobOffer->getActive();
            $parameters['remote']=$jobOffer->getRemote();
            $parameters['publishDate']=$jobOffer->getPublishDate();
            $parameters['endDate']=$jobOffer->getEndDate();
            $parameters['title']=$jobOffer->getTitle();
            $parameters['dedication']=$jobOffer->getDedication();
            $parameters['descriptionOffer']=$jobOffer->getDescription();
            $parameters['salary']=$jobOffer->getSalary();
            $parameters['creationAdminId']=$jobOffer->getCreationAdmin()->getAdministratorId();
            $parameters['companyId']=$jobOffer->getCompany()->getCompanyId();
            $parameters['careerIdOffer']=$jobOffer->getCareer()->getCareerId();


            $this->connection =Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return $this->connection->lastId();
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }

    function getAll()
    {
        try {

            $query= "SELECT * FROM ".$this->tableName." o INNER JOIN ".$this->tableName2." op ON o.jobOfferId= op.jobOfferIdOp
            INNER JOIN ".$this->tableName6." jp ON op.jobPositionIdOp = jp.jobPositionId 
            INNER JOIN ".$this->tableName3." co ON o.companyId= co.companyId 
            INNER JOIN ".$this->tableName4." ad ON o.creationAdminId= ad.administratorId
            INNER JOIN ".$this->tableName5." ca ON o.careerIdOffer= ca.careerId";


            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        }
        catch (\PDOException $ex)
        {
            throw $ex;
        }
    }

    function getJobOffer($jobOfferId)
    {
        try {

            $query= "SELECT * FROM ".$this->tableName." o INNER JOIN ".$this->tableName2." op ON o.jobOfferId= op.jobOfferIdOp
            INNER JOIN ".$this->tableName6." jp ON op.jobPositionIdOp = jp.jobPositionId 
            INNER JOIN ".$this->tableName3." co ON o.companyId= co.companyId 
            INNER JOIN ".$this->tableName4." ad ON o.creationAdminId= ad.administratorId
            INNER JOIN ".$this->tableName5." ca ON o.careerIdOffer= ca.careerId WHERE (op.jobOfferIdOp= :jobOfferId)";

            $parameters['jobOfferId']=$jobOfferId;

            //INNER JOIN ".$this->tableName6." jp ON op.jobPositionIdOp = jp.jobPositionId WHERE (op.jobOfferIdOp= :jobOfferId)

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result);
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        }
        catch (\PDOException $ex)
        {
            throw $ex;
        }
    }



    function remove($id)
    {
        try
        {
            $query = "DELETE FROM ".$this->tableName." WHERE (jobOfferId = :jobOfferId)";

            $parameters["jobOfferId"] =  $id;

            $this->connection = Connection::GetInstance();

            return $count=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }

    }


    function update(JobOffer $jobOffer)
    {

        try
        {


            $query= "UPDATE ".$this->tableName." SET activeJobOffer = :activeJobOffer , remote = :remote, publishDate = :publishDate, endDate = :endDate, title = :title, dedication = :dedication, descriptionOffer = :descriptionOffer, salary = :salary, creationAdminId = :creationAdminId, companyId = :companyId, careerIdOffer = :careerIdOffer
            WHERE (jobOfferId = :jobOfferId)";

                $parameters["activeJobOffer"] =  $jobOffer->getActive();
                $parameters["remote"] = $jobOffer->getRemote();
                $parameters["publishDate"] =  $jobOffer->getPublishDate();
                $parameters["endDate"] = $jobOffer->getEndDate();
                $parameters["title"] =  $jobOffer->getTitle();
                $parameters["dedication"] = $jobOffer->getDedication();
                $parameters["descriptionOffer"] = $jobOffer->getDescription();
               $parameters["salary"] = $jobOffer->getSalary();
               $parameters["creationAdminId"] = $jobOffer->getCreationAdmin()->getAdministratorId();
               $parameters["companyId"] = $jobOffer->getCompany()->getCompanyId();
               $parameters["careerIdOffer"] = $jobOffer->getCareer()->getCareerId();
            $parameters["jobOfferId"] = $jobOffer->getJobOfferId();



            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


    /**
     * Validate if a job offer title is available for a company
     * @param $title
     * @param $id
     */
    public function searchTitleValidation($title, $id)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." WHERE (title= :title) and (companyId= :companyId)";

            $parameters['title']=$title;
            $parameters['companyId']=$id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $flag=0;
            if(!empty($result))
            {
                $flag=1;
            }

            return $flag;
        }
        catch (\PDOException $ex)
        {
            throw $ex;
        }
    }



    public function mapear ($array)
    {
        $array = is_array($array) ? $array : [];

        $resultado = array_map(function ($value){


            $jobOffer = new JobOffer();

            $jobOffer->setJobOfferId($value["jobOfferId"]);
            $jobOffer->setActive($value["activeJobOffer"]);
            $jobOffer->setRemote($value["remote"]);
            $jobOffer->setPublishDate($value["publishDate"]);
            $jobOffer->setEndDate($value["endDate"]);
            $jobOffer->setTitle($value["title"]);
            $jobOffer->setDedication($value['dedication']);
            $jobOffer->setDescription($value["descriptionOffer"]);
            $jobOffer->setSalary($value["salary"]);

            $careerId=$value['careerId'];
            $careerDescription=$value['description'];
            $career= new Career();
            $career->setDescription($careerDescription);
            $career->setCareerId($careerId);
            $jobOffer->setCareer($career);

            $company = new Company();
            $company->setCompanyId($value["companyId"]); //SI SE ELIMINAN LOS ATRIBUTOS COMENTADOS, ELIMINAR EL JOIN CON "COMPANY" DEL GET ALL!!!!
            $company->setName($value["name"]);
            //$company->setFoundationDate($value["foundationDate"]);
            //$company->setCuit($value["cuit"]);
            //$company->setAboutUs($value["aboutUs"]);
            $company->setEmail($value["email"]);
            //$company->setActive($value["activeCompany"]);
            $company->setCompanyLink($value['companyLink']);
            $jobOffer->setCompany($company);


            $admin= new Administrator();
            $admin->setAdministratorId($value['administratorId']);
            //$admin->setActive($value['activeAdmin']);
            //$admin->setEmail($value['emailAdmin']);
            $admin->setEmployeeNumber($value['employeeNumber']);
            $admin->setFirstName($value['firstNameAdmin']);
            $admin->setLastName($value['lastNameAdmin']);
            $jobOffer->setCreationAdmin($admin);


            $jobPosition= new JobPosition();
            $jobPosition->setJobPositionId($value["jobPositionIdOp"]);

            if(isset($value['descriptionJob']))
            {
                $jobPosition->setDescription($value['descriptionJob']);
            }

            if(isset($value['careerIdJob']))
            {
                $career= new Career();
                $career->setCareerId($value['careerIdJob']);
                $jobPosition->setCareer($career);
            }
            $jobOffer->setJobPosition($jobPosition);



            return $jobOffer;

        }, $array);


        $finalOffers=$this->unifyAllOffer($resultado);

        return $finalOffers;

    }



    /**
     * Makes a jobOffer object with all their positions
     * @param $offer
     */
    public function unifyAllOffer($offer)
    {
        $finalArray=array();
        $subArray= array();
        $positionArray=array();
        $finalOffer=null;
        if(is_array($offer))
        {
            $cant=count($offer);

            $i=0;
            for ($x=0; $x<$cant; $x++)
            {
                $subArray=array();
                $positionArray= array();
                $pos=null;
                foreach ($offer as $value)
                {
                    $id = $offer[$i]->getJobOfferId();

                    if ($value->getJobOfferId() == $id)
                    {
                        $pos=$value->getJobOfferId();
                        array_push($subArray, $value);//job offers with same id
                    }
                }

                $flag=0;
                foreach ($finalArray as $value)
                {
                    if($value->getJobOfferId()==$pos)
                    {
                        $flag=1;
                    }
                }

                if($flag==0)
                {
                    foreach ($subArray as $values) //unify job position
                    {
                        //var_dump($values->getJobPosition()); //es un objeto
                        array_push($positionArray, $values->getJobPosition()); //array con 3 objetos
                    }

                    //var_dump($positionArray); //array con objetos

                    $finalOffer= $subArray[0];
                    $finalOffer->setJobPosition($positionArray);

                    array_push($finalArray, $finalOffer);
                    $positionArray=null;
                    $finalOffer=null;
                    $subArray=null;
                    $i++;
                }
                else
                {
                    $i++;
                }

            }

            if(count($finalArray)==1)
            {
                $offer= $finalArray[0];
                $finalArray=$offer;
            }

        }
        else if(is_object($offer))
        {
            $finalArray=$offer;
        }

        return $finalArray;

    }





}