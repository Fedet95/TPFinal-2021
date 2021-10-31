<?php

namespace Controllers;

use DAO\AppointmentDAO;
use Models\Appointment;
use Models\JobOffer;
use Models\Student;

require_once(VIEWS_PATH . "checkLoggedUser.php");


class AppointmentController
{

    private $AppointmentDAO;

    public function __construct()
    {
        $this->AppointmentDAO = new AppointmentDAO();
        $this->JobOfferDAO = new JobOfferDAO();
    }

    public function showApplyView( $studentId, $jobOfferId, $message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedStudent.php");

        $flag=$this->validateActiveStudent($studentId);
        if($flag==1)
        {
            require_once(VIEWS_PATH . "applyJobOffer.php");
        }
        else
        {
            $this->showWelcomeView('Your account is not active, please get in contact with the university'); //in case the student is inactive at the moment of applying a job
        }
    }


    public function showAppointmentView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedStudent.php");


        require_once(VIEWS_PATH . "applyJobOffer.php"); //cambiarrrrrrrrrrrrrrrrrr

    }

    public function addAppointment($appointmentId,JobOffer $jobOffer, Student $student, $date, $message, $cv)
    {
        require_once(VIEWS_PATH . "checkLoggedStudent.php");

        if ($this->AppointmentDAO->getAppointment($studentId) != null) {

            $this->showAppointmentView("Only one active application is allowed");

        } else {

            $appointment = new Appointment();
            $appointment= $this->validateCv($appointment);

            if($appointment!=null)
            {
                $appointment->setMessage($text);
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($jobOfferId);
                $appointment->setJobOffer($jobOffer);
                $appointment->setDate((new \DateTime())->format('Y-m-d'));
                $student= new Student();
                $student->setStudentId($studentId);
                $appointment->setStudent($student);

                try {
                    $this->AppointmentDAO->add($appointment);
                    $this->showAppointmentView("Successfully added application");

                } catch (\PDOException $ex) {
                    echo $ex->getMessage();
                }
            }
            else
            {
                $this->showApplyView($studentId, $jobOfferId, "Please enter a validad curriculum file");
            }
        }
    }

    public function showAppointmentList($valueToSearch = null, $back = null, $message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {
            $allAppointment = $this->AppointmentDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }
        $searchedAppointment=$this->searchAppointmentFiltreASD($allAppointment, $valueToSearch, $back);
        /// require_once(VIEWS_PATH . *******AGREGAR VISTA ****);
    }

    public function searchAppointmentFiltreASD($allAppointment, $valueToSearch)
    {
        $searchedAppointment = array();

        if($valueToSearch!=null)
        {
            foreach ($allAppointment as $value)
            {
                if ($value-> getAppointmentId== $valueToSearch)  // ID == ID
                {
                    array_push($searchedAppointment, $value);
                }
            }
        }
        else
        {
            $searchedAppointment = $allAppointment;
        }

        if($valueToSearch=='Show all apointments' || $valueToSearch=='Back')
        {
            $searchedAppointment = $allAppointment;
        }

        return $searchedAppointment;
    }


    public function Remove($studentId)

    {
        require_once(VIEWS_PATH . "checkLoggedStudent.php");

        try {
            $this->AppointmentDAO->remove($studentId);
            /// $this-> ///*****LLAMAR A LA VISTA ***///();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    public function addArrayAppointment($jobOfferId)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        //C. Ver el alumno propuesto para una oferta laboral
        try
        {
            $searchedJobOffer = $this->JobOfferDAO->getJobOffer($jobOfferId);

        }catch(\PDOException $ex){

            throw $ex;
        }

        try
        {
            $arrayApointments = $this->AppointmentDAO->getStudentAppointment($jobOfferId);
        }catch (\PDOException $ex)
        {
            throw $ex;
        }

        if ($searchedJobOffer != null) {
            if ($arrayApointments != null) {

                $searchedJobOffer->setAppointment($arrayApointments);
                //MANDARLO A LA VISTA DE LAS APPOITMENTSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS

            }
            else{
                $message = "This Job Offers has no appointments yet";
                //DEFINIR A QUE VISTA LO MANDAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
            }
        }

    }

    public function validateActiveStudent($studentId)
    {
        $studentsOrigin= new OriginStudentDAO();
        $allStudents= $studentsOrigin->start($studentsOrigin);

        $flag=0;
        foreach ($allStudents as $value)
        {
            if($value->getStudentId()==$studentId)
            {
                if($value->getActive()=='true')
                {
                    $flag=1;
                }
            }
        }

        return $flag;
    }

    public function showWelcomeView($message= "")
    {
        require_once (VIEWS_PATH."welcome.php");
    }



    public function validateCv($appointment)
    {
        $statusMsg = '';
        // File upload path
        $targetDir = "uploads/";
        $fileName = basename($_FILES["cv"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        $flag=0;
        if(!empty($_FILES["cv"]["name"])){
            // Allow certain file formats
            $allowTypes = array('pdf','doc', 'docx');
            if (!file_exists($targetFilePath)) { //image already exist in the folder
                if(in_array($fileType, $allowTypes)){
                    // Upload file to server
                    if(move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFilePath)){ //image doesn't exist in the folder, add it
                        // Insert image file name into database

                        $appointment->setCv($fileName);

                    }else{
                        /* $statusMsg = "Sorry, there was an error uploading your file";*/
                        $flag=1;
                    }
                }else{
                    /*$statusMsg = "Sorry, only PDF, DOC files are allowed to upload.";*/
                    $flag=1;
                }
            }else {
                /* $statusMsg = "The file <b>".$fileName. "</b> is already exist";*/


                $path    = 'uploads/';
                $files = scandir($path);

                $flag=1;
                foreach($files as $value)
                {
                   if($value == $fileName)
                   {
                       $appointment->setCv($fileName);
                       $flag=0;
                   }
                }
            }
        }else{
            /*$statusMsg = 'Please select a file to upload';*/
            $flag=1;
        }
        // Display status message
        if($flag==1)
        {
            return null;
        }
        else
        {
            return $appointment;
        }
    }




}