<?php
namespace DAO;

use Models\Administrator;
use Models\Company;
use Models\City;
use Models\Country;
use Models\Industry;
use Models\Logo;
use Models\User;
use Models\UserRol;
use Mudels\SessionHelper;

class CompanyDAO implements lCompanyDAO
{
    private $connection;
    private $tableName ="companies";
    private $tableName2 ="countries";
    private $tableName3 ="cities";
    private $tableName4 ="industries";
    private $tableName5 ="logos";
    private $tableName6 ="users";



    /**
     * add a Company to Data base
     * @param Company $company
     */
    function add(Company $company)
    {
        try {


            $query= "INSERT INTO ".$this->tableName."(name, foundationDate, cuit, aboutUs, companyLink, emailCompany, logo, active, industry, city, country, creationAdmin) VALUES (:name, :foundationDate, :cuit, :aboutUs, :companyLink, :emailCompany, :logo, :active, :industry, :city, :country, :creationAdmin)";

            $parameters['name']=$company->getName();
            $parameters['foundationDate']=$company->getFoundationDate();
            $parameters['cuit']=$company->getCuit();
            $parameters['aboutUs']=$company->getAboutUs();
            $parameters['companyLink']=$company->getCompanyLink();
            $parameters['emailCompany']=$company->getEmail();
            $parameters['logo']=$company->getLogo()->getId();
            $parameters['active']=$company->getActive();
            $parameters['industry']=$company->getIndustry()->getId();
            $parameters['city']=$company->getCity()->getId();
            $parameters['country']=$company->getCountry()->getId();
            $parameters['creationAdmin']=$company->getCreationAdmin()->getUserId();

            $this->connection =Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados

        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


    /**
     * Get all companys from Data base
     * @return array
     */
    function getAll()
    {
        try {

            $query= "SELECT * FROM ".$this->tableName." c INNER JOIN ".$this->tableName2." co ON c.country= co.idCountry
            INNER JOIN ".$this->tableName3." ci ON c.city= ci.idCity 
            INNER JOIN ".$this->tableName4." ind ON c.industry= ind.idIndustry
            INNER JOIN ".$this->tableName5." lo ON c.logo= lo.idLogo
            INNER JOIN ".$this->tableName6." u ON c.creationAdmin= u.userId";


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
        catch (\PDOException $ex)
        {
            throw $ex;
        }
    }


    /**
     * Remove company from Data base
     * @param $companyId
     */
    function remove($companyId)
    {
        try
        {
            $query = "DELETE FROM ".$this->tableName." WHERE (companyId = :companyId)";

            $parameters["companyId"] =  $companyId;

            $this->connection = Connection::GetInstance();

            return $count=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


    /**
     * Get company from Data base
     * @param $companyId
     */

    function getCompany($companyId)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." c INNER JOIN ".$this->tableName2." co ON c.country= co.idCountry
            INNER JOIN ".$this->tableName3." ci ON c.city= ci.idCity 
            INNER JOIN ".$this->tableName4." ind ON c.industry= ind.idIndustry
            INNER JOIN ".$this->tableName5." lo ON c.logo= lo.idLogo
            INNER JOIN ".$this->tableName6." u ON c.creationAdmin= u.userId WHERE (companyId= :companyId)";

            $parameters['companyId']=$companyId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

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

    /**
     * Validate if a cuit number is available
     * @param $cuit
     */
    public function searchCuit($cuit)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." WHERE (cuit= :cuit)";

            $parameters['cuit']=$cuit;

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

    /**
     * Validate if a company name is available
     * @param $name
     */
    public function searchNameValidation($name)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." WHERE (name= :name)";

            $parameters['name']=$name;

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


    /**
     * Validate if a company email is available
     * @param $name
     */
    public function searchEmailValidation($email)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." WHERE (emailCompany= :emailCompany)";

            $parameters['emailCompany']=$email;

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



    /**
     * Update company values
     * @param Company $company
     */
    function update(Company $company)
    {
        try
        {
                $query= "UPDATE ".$this->tableName." SET name = :name, foundationDate = :foundationDate, cuit = :cuit, aboutUs = :aboutUs, companyLink = :companyLink, emailCompany = :emailCompany, logo = :logo, active= :active, industry=:industry, city=:city, country=:country, creationAdmin=:creationAdmin
            WHERE (companyId = :companyId)";

            $parameters['name']=$company->getName();
            $parameters['foundationDate']=$company->getFoundationDate();
            $parameters['cuit']=$company->getCuit();
            $parameters['aboutUs']=$company->getAboutUs();
            $parameters['companyLink']=$company->getCompanyLink();
            $parameters['emailCompany']=$company->getEmail();
            $parameters['logo']=$company->getLogo()->getId();
            $parameters['active']=$company->getActive();
            $parameters['industry']=$company->getIndustry()->getId();
            $parameters['city']=$company->getCity()->getId();
            $parameters['country']=$company->getCountry()->getId();
            $parameters['creationAdmin']=$company->getCreationAdmin()->getUserId();
            $parameters['companyId']=$company->getCompanyId();

            $this->connection = Connection::GetInstance();

            return $count= $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


    public function mapear ($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($value){

            $company = new Company();
            $company->setCompanyId($value["companyId"]);
            $company->setName($value["name"]);
            $company->setFoundationDate($value["foundationDate"]);
            $company->setCuit($value["cuit"]);
            $company->setAboutUs($value["aboutUs"]);
            $company->setEmail($value["emailCompany"]);
            $active=$value["active"];
            if($active==1)
            {
                $company->setActive('true');
            }
            else
            {
                $company->setActive('false');
            }

            $company->setCompanyLink($value['companyLink']);


            $countryId=$value['idCountry'];
            $countryName=$value['nameCountry'];
            $country= new Country();
            $country->setId($countryId);
            $country->setName($countryName);
            $company->setCountry($country);

            $cityId=$value['idCity'];
            $cityName=$value['nameCity'];
            $city= new City();
            $city->setId($cityId);
            $city->setName($cityName);
            $company->setCity($city);

            $industryId=$value['idIndustry'];
            $industryType=$value['type'];
            $industry= new Industry();
            $industry->setId($industryId);
            $industry->setType($industryType);
            $company->setIndustry($industry);


            $userId=$value['userId'];
            $userEmail=$value['email'];
            $userRolId=$value['rolId'];

            $admin= new User();
            $admin->setEmail($userEmail);
            $rol= new UserRol();
            $rol->setUserRolId($userRolId);
            $admin->setRol($rol);
            $admin->setUserId($userId);
            $company->setCreationAdmin($admin);


            $logoId=$value["idLogo"];
            $logoName=$value['nameLogo'];
            $logo= new Logo();
            $logo->setId($logoId);
            $logo->setFile($logoName);
            $company->setLogo($logo);

            return $company;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }



}