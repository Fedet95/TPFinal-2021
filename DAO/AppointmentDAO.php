<?php

namespace DAO;

use Models\Appointment;
use Models\JobOffer;
use Models\Student;

class AppointmentDAO implements IAppointmentDAO
{

    private $connection;
    private $tableName = "appointment";
    private $tableName2 = "jobOffers";
    private $tableName3 = "students";


    public function add(Appointment $appointment)   ////AGREGAR LOS ATRIBUTOS FALTANTES AL APOINMENT!!!!!
    {
        try {
            $query = "INSERT INTO " . $this->tableName . "(appointmentId, jobOfferAppointmentId, studentAppointmentId, dateAppointment, message, cv) VALUES (:appointmentId, :jobOfferAppointmentId, :studentAppointmentId, :dateAppointment, :message, :cv)";

            $parameters['appointmentId'] = $appointment->getAppointmentId(); //se le ingresa el id porque en este caso NO es auto_increment (ojo los demas DAO)
            $parameters['jobOfferAppointmentId'] = $appointment->getJobOffer()->getJobOfferId();
            $parameters['studentAppointmentId'] = $appointment->getStudent()->getStudentId();
            $parameters['dateAppointment'] = $appointment->getDate();
            $parameters['message'] = $appointment->getMessage();
            $parameters['cv'] = $appointment->getCv();

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

    function remove($studentId)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE (studentId = :studentId)";

            $parameters["studentId"] = $studentId;

            $this->connection = Connection::GetInstance();

            return $count = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    function getAppointment($studentId) //lo utilizamos para comprobar si ya hay un apoinment del usuario
    {
        try {

            $query = "SELECT * FROM " . $this->tableName . " WHERE (studentId= :studentId)";

            ///EL WHERE MUY IMPORTANTE PARA SOLO LEVANTAR UN REGISTRO DE LA TABLA


            $parameters['studentId'] = $studentId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function mapear($array)
    {
        $array = is_array($array) ? $array : [];

        $resultado = array_map(function ($value) {

            $appointment = new Appointment();

            $appointment->setAppointmentId($value["appointmentId"]);
            $appointment->setDate($value["dateAppointment"]);
            $appointment->setMessage($value["message"]);
            $appointment->setCv($value["cv"]);

            $jobOfferId = $value['jobOfferId'];
            $title = $value['title'];
            $company = $value['company'];

            $jobOffer = new JobOffer();
            $jobOffer->setTitle($title);
            $jobOffer->setJobOfferId($jobOfferId);
            $jobOffer->setCompany($company);

            $appointment->setJobOffer($jobOffer);

            $studentId = $value["studentId"];
            $firstName = $value["firstName"];
            $lastName = $value["lastName"];
            $dni = $value["dni"];
            $phoneNumber = $value["phoneNumber"];

            $student = new Student();
            $student->setStudentId($studentId);
            $student->setFirstName($firstName);
            $student->setLastName($lastName);
            $student->setDni($dni);
            $student->setPhoneNumber($phoneNumber);

            $appointment->setStudent($student);

            return $appointment;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }


}
