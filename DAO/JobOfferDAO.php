<?php

namespace DAO;

use Models\Administrator;
use Models\Career;
use Models\Company;
use Models\JobOffer;
use Models\JobOfferPosition;
use Models\JobPosition;
use Models\User;
use Models\UserRol;

class JobOfferDAO implements IJobOfferDAO
{
    private $connection;
    private $tableName= "jobOffers";
    private $tableName2= "jobOffers_jobPositions";
    private $tableName3 ="companies";
    private $tableName4 ="users";
    private $allCarrers;
    private $allJobPositions;




    function add(JobOffer $jobOffer)
    {
        try
        {
            $query= "INSERT INTO ".$this->tableName."(activeJobOffer , remote, publishDate, endDate, title, dedication, descriptionOffer, salary, creationAdmin, companyId, careerIdOffer, emailSent, maxApply, flyer) VALUES (:activeJobOffer , :remote, :publishDate, :endDate, :title, :dedication, :descriptionOffer, :salary, :creationAdmin, :companyId, :careerIdOffer, :emailSent, :maxApply, :flyer)";

            $parameters['activeJobOffer']=$jobOffer->getActive();
            $parameters['remote']=$jobOffer->getRemote();
            $parameters['publishDate']=$jobOffer->getPublishDate();
            $parameters['endDate']=$jobOffer->getEndDate();
            $parameters['title']=$jobOffer->getTitle();
            $parameters['dedication']=$jobOffer->getDedication();
            $parameters['descriptionOffer']=$jobOffer->getDescription();
            $parameters['salary']=$jobOffer->getSalary();
            $parameters['creationAdmin']=$jobOffer->getCreationAdmin()->getUserId();
            $parameters['companyId']=$jobOffer->getCompany()->getCompanyId();
            $parameters['careerIdOffer']=$jobOffer->getCareer()->getCareerId();
            $parameters['emailSent']=$jobOffer->getEmailSent();
            $parameters['maxApply']=$jobOffer->getMaxApply();
            $parameters["flyer"]=$jobOffer->getFlyer();


            $this->connection =Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
            return $this->connection->lastId();
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }

    function getAll()
    {
        try {

            $query= "SELECT * FROM ".$this->tableName." o INNER JOIN ".$this->tableName2." op ON o.jobOfferId= op.jobOfferIdOp
            INNER JOIN ".$this->tableName3." co ON o.companyId= co.companyId 
            INNER JOIN ".$this->tableName4." u ON o.creationAdmin= u.userId";




            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)

                if(is_object($mapedArray))
                { $com= $mapedArray;
                    $mapedArray= array();
                    array_push($mapedArray, $com);
                }

            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        }
        catch (\Exception $ex)
        {
            throw $ex;
        }
    }

    function getJobOffer($jobOfferId)
    {
        try {

            $query= "SELECT * FROM ".$this->tableName." o INNER JOIN ".$this->tableName2." op ON o.jobOfferId= op.jobOfferIdOp
            INNER JOIN ".$this->tableName3." co ON o.companyId= co.companyId 
            INNER JOIN ".$this->tableName4." u ON o.creationAdmin= u.userId WHERE (op.jobOfferIdOp= :jobOfferId)";

            $parameters['jobOfferId']=$jobOfferId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result);

            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        }
        catch (\Exception $ex)
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
        catch(\Exception $ex)
        {
            throw $ex;
        }

    }


    function update(JobOffer $jobOffer)
    {

        try
        {
            $query= "UPDATE ".$this->tableName." SET activeJobOffer = :activeJobOffer , remote = :remote, publishDate = :publishDate, endDate = :endDate, title = :title, dedication = :dedication, descriptionOffer = :descriptionOffer, salary = :salary, creationAdmin = :creationAdmin, companyId = :companyId, careerIdOffer = :careerIdOffer, maxApply= :maxApply, flyer = :flyer, emailSent=:emailSent
            WHERE (jobOfferId = :jobOfferId)";

                $parameters["activeJobOffer"] =  $jobOffer->getActive();
                $parameters["remote"] = $jobOffer->getRemote();
                $parameters["publishDate"] =  $jobOffer->getPublishDate();
                $parameters["endDate"] = $jobOffer->getEndDate();
                $parameters["title"] =  $jobOffer->getTitle();
                $parameters["dedication"] = $jobOffer->getDedication();
                $parameters["descriptionOffer"] = $jobOffer->getDescription();
               $parameters["salary"] = $jobOffer->getSalary();
               $parameters["creationAdmin"] = $jobOffer->getCreationAdmin()->getUserId();
               $parameters["companyId"] = $jobOffer->getCompany()->getCompanyId();
               $parameters["careerIdOffer"] = $jobOffer->getCareer()->getCareerId();
               $parameters["jobOfferId"] = $jobOffer->getJobOfferId();
               $parameters['maxApply']=$jobOffer->getMaxApply();
               $parameters['emailSent']=$jobOffer->getEmailSent();
               $parameters["flyer"]=$jobOffer->getFlyer();





            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\Exception $ex)
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
        catch (\Exception $ex)
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
            $jobOffer->setMaxApply($value["maxApply"]);
            $jobOffer->setEmailSent($value["emailSent"]);
            $jobOffer->setFlyer($value["flyer"]);


            if(isset($value['companyId']))
            {
                $company = new Company();
                $company->setCompanyId($value["companyId"]);
                $company->setName($value["name"]);
                $company->setEmail($value["emailCompany"]);
                $company->setCompanyLink($value['companyLink']);
                $jobOffer->setCompany($company);
            }


            $careerid= $value['careerIdOffer']; //hasta aca bien
            //var_dump($careerid);
            $this->getOriginCareers();
            foreach ($this->allCarrers as $career)
            {
                if($career->getCareerId()==$careerid)
                {
                    $jobOffer->setCareer($career);
                }
            }


            $admin= new User();
            $admin->setEmail($value['email']);
            $rol= new UserRol();
            $rol->setUserRolId($value['rolId']);
            $admin->setRol($rol);
            $admin->setUserId($value['userId']);
            $jobOffer->setCreationAdmin($admin);



            $positionId=$value["jobPositionIdOp"];
            $this->getOriginJobPositions();
            foreach ($this->allJobPositions as $value)
            {
                if($value->getJobPositionId()==$positionId)
                {
                    $jobOffer->setJobPosition($value);
                }
            }

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
            $cant=count($offer); //cuento la cantidad de job offers que me llegan

            $i=0;
            for ($x=0; $x<$cant; $x++) //recorro la cantidad de job offers que tengo
            {
                $subArray=array();
                $positionArray= array();
                $pos=null;
                foreach ($offer as $value) //recorro las job offers
                {
                    $id = $offer[$i]->getJobOfferId(); //tomo el id de la primer job offer (y asi seguidamente con el contador)

                    if ($value->getJobOfferId() == $id) //busco todas las job offers con esa ID
                    {
                        $pos=$value->getJobOfferId(); //guardo la posicion
                        array_push($subArray, $value);//job offers con misma id
                    }
                }

                $flag=0;
                foreach ($finalArray as $value) //una de las job offer
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
                        array_push($positionArray, $values->getJobPosition()); //array con 3 objetos, guardo las job position de cada job offer
                    }

                    $finalOffer= $subArray[0];
                    $finalOffer->setJobPosition($positionArray); //tomo una de las job offers y le almaceno el array con todas las posiciones

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

    public function getOriginCareers()
    {
        if ($this->allCarrers == null) {
            $careerOrigin = new OriginCareerDAO();
            $this->allCarrers = $careerOrigin->start($careerOrigin);
        }
    }

    public function getOriginJobPositions()
    {
        if ($this->allJobPositions == null) {
            $jobPositionsOrigin = new OriginJobPositionDAO();
            $this->allJobPositions = $jobPositionsOrigin->start($jobPositionsOrigin);
        }
    }



}