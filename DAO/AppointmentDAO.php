<?php

namespace DAO;
use Models\Appointment;

class AppointmentDAO implements IAppointmentDAO
{

    private $connection;
    private $tableName = "appointment";
    private $tableName2 = "jobOffers";
    private $tableName3 = "students";


    public function add(Appointment $appointment)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . "(appointmentId, jobOfferAppointmentId, studentAppointmentId, dateAppointment) VALUES (:appointmentId, :jobOfferAppointmentId, :studentAppointmentId, :dateAppointment)";

            $parameters['appointmentId'] = $appointment->getAppointmentId(); //se le ingresa el id porque en este caso NO es auto_increment (ojo los demas DAO)
            $parameters['jobOfferAppointmentId'] = $appointment->getJobOffer()->getJobOfferId();
            $parameters['studentAppointmentId'] = $appointment->getStudent()->getStudentId();
            $parameters['dateAppointment'] = $appointment->getDate();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    function getAll()
    {

        try {


            $query = "SELECT * FROM " . $this->tableName . " c INNER JOIN " . $this->tableName2 . " co ON c.jobOfferAppointmentId= co.jobOfferId
            INNER JOIN " . $this->tableName3 . " ci ON c.studentAppointmentId= ci.studentId";


            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result);
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

}


/*

 * Search an student by id, and remove
 * @param $studentId

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



 * Returns all values from Data base
 * @return array
 *
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



 * Update json student values with information from origin file (at student login)
 * @param $student
 *
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





 * Update json student values with information from API file (at student login)
 * @param $student
public function updateStudentFile($student =null, $studentsArray = null)
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
                    var_dump($ex);
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
                var_dump($ex);
            }
        }
    }
    catch (\PDOException $ex)
    {
        var_dump($ex);
    }







 * Search an Student by id, returning the student or null
 * @param $studentId
 * @return mixed|null
 *
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

    return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

}



 *
 */