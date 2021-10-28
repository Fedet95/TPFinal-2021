<?php

namespace DAO;

use Models\Career;
use Models\Student;


class StudentDAO implements lStudentDAO
{

    private $connection;
    private $tableName= "students";
    private $tableName2= "careers";

    /**
     * Add an student to the Data base
     * @param Student $student
     */
    public function add(Student $student)
    {
        try
        {
            $query= "INSERT INTO ".$this->tableName."(studentId, career, firstName, lastName, dni, phoneNumber, email, password) VALUES (:studentId, :career, :firstName, :lastName, :dni, :phoneNumber, :email, :password)";

            $parameters['studentId']=$student->getStudentId(); //se le ingresa el id porque en este caso NO es auto_increment (ojo los demas DAO)
            $parameters['career']=$student->getCareer()->getCareerId();
            $parameters['firstName']=$student->getFirstName();
            $parameters['lastName']=$student->getLastName();
            $parameters['dni']=$student->getDni();
            $parameters['phoneNumber']=$student->getPhoneNumber();
            $parameters['email']=$student->getEmail();
            $parameters['password']=$student->getPassword();

            $this->connection =Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }



    /**
     * Search an student by id, and remove
     * @param $studentId
     */
    function remove($studentId)
    {
        try
        {
            $query = "DELETE FROM ".$this->tableName." WHERE (studentId = :studentId)";

            $parameters["studentId"] =  $studentId;

            $this->connection = Connection::GetInstance();

            return $count=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


    /**
     * Returns all values from Data base
     * @return array
     */
    function getAll()
    {

        try {
            $query= "SELECT * FROM ".$this->tableName." s INNER JOIN ".$this->tableName2." c ON s.career= c.careerId";

            //$query= "SELECT  b.beerType, b.code, b.name, bt.id FROM ".$this->secondTableName." b INNER JOIN ".$this->tableName." bt ON b.beerType = bt.id WHERE (bt.id = :id)";

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


    /**
     * Returns all values from Data base
     * @return array
     */
    public function getStudent($studentId)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." s INNER JOIN ".$this->tableName2." c ON s.career= c.careerId WHERE (s.studentId= :studentId)";

            $parameters['studentId']=$studentId;

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



/*

     * Get student by id from Json file
     * @param $companyId

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
*/

    function update(Student $student)
    {

        try
        {
            if($student->getPassword()==null)
            {
                $query= "UPDATE ".$this->tableName." SET studentId = :studentId, career = :career, firstName = :firstName, lastName = :lastName, dni = :dni, phoneNumber = :phoneNumber, email = :email
            WHERE (studentId = :studentId)";

                $parameters["studentId"] =  $student->getStudentId();
                $parameters["career"] = $student->getCareer()->getCareerId();
                $parameters["firstName"] =  $student->getFirstName();
                $parameters["lastName"] = $student->getLastName();
                $parameters["dni"] =  $student->getDni();
                $parameters["phoneNumber"] = $student->getPhoneNumber();
                $parameters["email"] = $student->getEmail();
            }
            else
            {
                $query= "UPDATE ".$this->tableName." SET  password = :password WHERE (studentId = :studentId)";
                $parameters["studentId"] =  $student->getStudentId();
                $parameters["password"] = $student->getPassword();

            }


            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


    /**
     * Update json student values with information from origin file (at student login)
     * @param $student
     */
    public function updateStudentFile($student =null, $studentsArray = null)
    {

        if($student!=null)
        {
            try
            {
                $searchedStudent=$this->getStudent($student->getStudentId());

                if($searchedStudent!=null)
                {
                    if($searchedStudent!=$student)
                    {
                        try{
                            $this->update($student);
                        }
                        catch(\PDOException $ex)
                        {
                            echo $ex->getMessage();
                        }
                    }
                }
                else
                {
                    try {
                        $this->add($student);
                    }
                    catch (\PDOException $ex)
                    {
                        echo $ex->getMessage();
                    }
                }
            }
            catch (\PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }
        else if($studentsArray!=null)
        {
            foreach ($studentsArray as $value)
            {
                try
                {
                    $searchedStudent=$this->getStudent($value->getStudentId());

                    if($searchedStudent!=null)
                    {
                        if($searchedStudent!=$value)
                        {
                            try{
                                $this->update($value);
                            }
                            catch(\PDOException $ex)
                            {
                                echo $ex->getMessage();
                            }
                        }
                    }
                    else
                    {
                        try {
                            $this->add($value);
                        }
                        catch (\PDOException $ex)
                        {
                            echo $ex->getMessage();
                        }
                    }
                }
                catch (\PDOException $ex)
                {
                    echo $ex->getMessage();
                }
            }
        }
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



    public function mapear ($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($value){

            $student = new Student();

            $student->setStudentId($value["studentId"]);

            $careerId=$value['careerId'];
            $careerDescription=$value['description'];
            $career= new Career();
            $career->setDescription($careerDescription);
            $career->setCareerId($careerId);
            $student->setCareer($career);

            $student->setFirstName($value["firstName"]);
            $student->setLastName($value["lastName"]);
            $student->setDni($value["dni"]);
            $student->setPhoneNumber($value["phoneNumber"]);
            $student->setEmail($value["email"]);
            $student->setPassword($value['password']);

            return $student;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0'];

    }




}

