<?php
namespace DAO;
use Models\Administrator;

class AdministratorRepository implements lAdministratorRepository
{

    private $administratorList = array();
    private $fileName;


    public function __construct()
    {
        $this->fileName=ROOT."/Data/administrators.json";
    }

    /**
     * Returns all values from Json file
     * @return array
     */
    function getAll()
    {
        $this->retrieveData();
        return $this->administratorList;
    }


    /**
     * Search an administrator by email, returning the administrator or null
     * @param $email
     * @return mixed|null
     */
    function searchByEmail($email)
    {
        $this->retrieveData();

        $administrator=null;
        foreach ($this->administratorList as $value)
        {
            if($value->getEmail()==$email)
            {
                $administrator=$value;
            }
        }
        return $administrator;
    }

    public function searchById($id)
    {
        $this->retrieveData();
        $admin=null;

        foreach ($this->administratorList as $value)
        {
            if($value->getAdministratorId()==$id)
            {
                $admin=$value;
            }
        }

        return $admin;
    }

    /**
     *Saves all administrators in a Json file
     */
    private function saveData()
    {
        $arrayToEncode= array();

        foreach ($this->administratorList as $value)
        {
            $arrayValue['active']=$value->getActive();
            $arrayValue['firstName']=$value->getFirstName();
            $arrayValue['lastName']=$value->getLastName();
            $arrayValue['email']=$value->getEmail();
            $arrayValue['administratorId']=$value->getAdministratorId();
            $arrayValue['employeeNumber']=$value->getEmployeeNumber();

            array_push($arrayToEncode, $arrayValue);
        }
        $jsonContent= json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }


    /**
     * Retrieves all administrators from Json file to an array
     */
    private function retrieveData()
    {
        $this->administratorList= array();

        if(file_exists($this->fileName))
        {
            $jsonContent= file_get_contents($this->fileName);
            $arraytoDecode= ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arraytoDecode as $value)
            {
                $administrator= new Administrator();
                $administrator->setActive($value['active']);
                $administrator->setFirstName($value['firstName']);
                $administrator->setLastName($value['lastName']);
                $administrator->setEmail($value['email']);
                $administrator->setAdministratorId($value['administratorId']);
                $administrator->setEmployeeNumber($value['employeeNumber']);

                array_push($this->administratorList, $administrator);
            }
        }
    }


}