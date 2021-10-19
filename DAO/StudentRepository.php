<?php

namespace DAO;

use Models\Career;
use Models\Student;

class StudentRepository implements lStudentRepository
{
    private $studentList = array();
    private $fileName;


    public function __construct()
    {
        $this->fileName = ROOT . "/Data/students.json";
    }

    /**
     * add an studen to Json file
     * @param Student $student
     */
    public function add(Student $student)
    {
        $this->RetrieveData();
        array_push($this->studentList, $student);
        $this->SaveData();
    }

    /**
     * Search an student by id, and remove
     * @param $studentId
     */
    function remove($studentId)
    {
        $this->retrieveData();
        $i=0;

        foreach ($this->studentList as $value) //recorro mi userList
        {
            if($value->getStudentId()==$studentId) //compruebo que id sea el mismo
            {
                unset($this->studentList[$i]); //si es asi se elimina
            }
            $i++;
        }
        $this->saveData();
    }


    /**
     * Returns all values from Json file
     * @return array
     */
    public function getAll()
    {
        $this->RetrieveData();

        return $this->studentList;
    }

    /**
     * Get student by id from Json file
     * @param $companyId
     */

    function getStudent($studentId)
    {
        $this->RetrieveData();

        $student = null;
        foreach($this->studentList as $key => $value)
        {
            if($value->getStudentId()==$studentId)
            {
                $student = $this->studentList[$key];
            }
        }
        return $student;
    }


    /**
     * Update json student values with information from API file (at student login)
     * @param $studentAPI
     */
    public function updateStudentFile($studentAPI)
    {
        $this->RetrieveData();
        $flag=0;

        foreach ($this->studentList as $key => $value)
        {
            if($value->getStudentId()==$studentAPI->getStudentId())
            {
              $this->studentList[$key]=$studentAPI;
              $flag=1;
            }
        }

        if($flag==0) //en caso de que se agregue un nuevo estudiante a la api, el cual no estaba grabado en el json original
        {
            $this->add($studentAPI);
        }

        $this->SaveData();
    }


    /**
     * Update all json student values with information from API file, in case they are different (at administrator login)
     * @param $allStudentsAPI
     */
    public function updateAllStudentFiles($allStudentsAPI)
    {
        $this->RetrieveData();

        if($this->studentList!=$allStudentsAPI)
        {
            $this->studentList=$allStudentsAPI;
        }

        $this->SaveData();
    }



    /**
     * Search an Student by id, returning the student or null
     * @param $studentId
     * @return mixed|null
     */
    public function GetByStudentId($studentId)
    {
        $this->RetrieveData();
        $studentFounded = null;

        if (!empty($this->studentList)) {
            foreach ($this->studentList as $student) {
                if ($student->getStudentId() == $studentId) {
                    $studentFounded = $student;
                }
            }
        }

        return $studentFounded;
    }



    /**
     *Saves all Student in a Json file
     */
    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->studentList as $student) {
            $valuesArray["studentId"] = $student->getStudentId();
            $valuesArray["firstName"] = $student->getFirstName();
            $valuesArray["lastName"] = $student->getLastName();
            $valuesArray["dni"] = $student->getDni();
            $valuesArray["fileNumber"] = $student->getFileNumber();
            $valuesArray["gender"] = $student->getGender();
            $valuesArray["birthDate"] = $student->getBirthDate();
            $valuesArray["phoneNumber"] = $student->getPhoneNumber();
            $valuesArray["email"] = $student->getEmail();
            $valuesArray["active"] = $student->getActive();

            $carrerArray = array();
            $carrerArray["id"]=$student->getCareer()->getCareerId();
            $carrerArray["description"]=$student->getCareer()->getDescription();
            $carrerArray["active"]=$student->getCareer()->getActive();
            $valuesArray["career"] = $carrerArray;

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $jsonContent);

    }

    /**
     *Retrieves all students from Json file to an array
     */
    private function RetrieveData()
    {
        $this->studentList = array();

        if (file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {
                $student = new Student();
                $student->setStudentId($valuesArray["studentId"]);
                $student->setFirstName($valuesArray["firstName"]);
                $student->setLastName($valuesArray["lastName"]);
                $student->setDni($valuesArray["dni"]);
                $student->setFileNumber($valuesArray["fileNumber"]);
                $student->setGender($valuesArray["gender"]);
                $student->setBirthDate($valuesArray["birthDate"]);
                $student->setPhoneNumber($valuesArray["phoneNumber"]);
                $student->setEmail($valuesArray["email"]);
                $student->setActive($valuesArray["active"]);

                $career = new Career();
                $careerArray = (array) $valuesArray["career"];

                $careerId = $careerArray["id"];
                $descriptionCareer = $careerArray["description"];
                $activeCareer= $careerArray['active'];

                $career->setActive($activeCareer);
                $career->setDescription($descriptionCareer);
                $career->setCareerId($careerId);
                $student->setCareer($career);

                array_push($this->studentList, $student);
            }
        }
    }

}

