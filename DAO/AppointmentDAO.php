<?php

namespace DAO;

use Models\Appointment;
use Models\Career;
use Models\Company;
use Models\JobOffer;
use Models\User;

class AppointmentDAO implements IAppointmentDAO
{

    private $connection;
    private $tableName = "appointment";
    private $tableName2 = "jobOffers";
    private $tableName3 = "users";
    private $tableName4= "companies";


    public function add(Appointment $appointment)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . "(jobOfferAppointmentId, studentAppointmentId, dateAppointment, message, cv) VALUES (:jobOfferAppointmentId, :studentAppointmentId, :dateAppointment, :message, :cv)";

            $parameters['jobOfferAppointmentId'] = $appointment->getJobOffer()->getJobOfferId();
            $parameters['studentAppointmentId'] = $appointment->getStudent()->getUserId();
            $parameters['dateAppointment'] = $appointment->getDate();
            $parameters['message'] = $appointment->getMessage();
            $parameters['cv'] = $appointment->getCv();

            $this->connection = Connection::GetInstance();
          return $count= $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    function getAll()
    {

        try {


            $query = "SELECT * FROM " . $this->tableName . " c INNER JOIN " . $this->tableName2 . " co ON c.jobOfferAppointmentId= co.jobOfferId";


            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result);
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    function remove($studentId)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE (studentAppointmentId = :studentAppointmentId)";

            $parameters["studentAppointmentId"] = $studentId;

            $this->connection = Connection::GetInstance();

            return $count = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    function getAppointment($studentId) //lo utilizamos para comprobar si ya hay un apoinment del usuario
    {
        try {

            $query = "SELECT * FROM " . $this->tableName . " a INNER JOIN " . $this->tableName2 . " j ON a.jobOfferAppointmentId= j.jobOfferId
            INNER JOIN " . $this->tableName4 . " co ON j.companyId= co.companyId WHERE (a.studentAppointmentId= :studentAppointmentId)";

            $parameters['studentAppointmentId'] = $studentId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\Exception $ex) {
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


            $jobOffer = new JobOffer();
            $jobOffer->setJobOfferId($value['jobOfferAppointmentId']);
            if(isset($value['title'])) //for Get all (inner join with job offer table) // for getAppointment  (inner join with job offer table)
            {
                $jobOffer->setTitle($value['title']);
                $jobOffer->setRemote($value["remote"]);
                $jobOffer->setPublishDate($value["publishDate"]);
                $jobOffer->setEndDate($value["endDate"]);
                $jobOffer->setDedication($value['dedication']);
                $jobOffer->setDescription($value["descriptionOffer"]);
                $jobOffer->setEmailSent($value["emailSent"]);
                $company= new Company();
                $company->setCompanyId($value['companyId']);
                $career= new Career();
                $career->setCareerId($value['careerIdOffer']);
                $jobOffer->setCareer($career);
            }

            if(isset($value['name'])) //for getAppointment  (inner join with companies table)
            {
                $company->setName($value['name']);
                $company->setEmail($value['emailCompany']);
                $company->setCompanyLink($value['companyLink']);
            }

            $jobOffer->setCompany($company);
            $appointment->setJobOffer($jobOffer);


            $student = new User();
            $student->setUserId($value["studentAppointmentId"]);
            $userdao= new UserDAO();

            try {
                $searchedStudent=$userdao->getUser($value["studentAppointmentId"]);
                $appointment->setStudent($searchedStudent);
            }catch (\Exception $ex)
            {
                echo $ex->getMessage();
            }

            return $appointment;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }


}
