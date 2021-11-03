<?php

namespace Controllers;

use DAO\AppointmentDAO;
use DAO\AppointmentHistoryDAO;
use DAO\CareerDAO;
use DAO\CompanyDAO;
use DAO\JobOfferDAO;
use DAO\OriginStudentDAO;
use DAO\StudentDAO;
use Models\Administrator;
use Models\Appointment;
use Models\AppointmentHistory;
use Models\Career;
use Models\Company;
use Models\JobOffer;
use Models\Student;

require_once(VIEWS_PATH . "checkLoggedUser.php");


class AppointmentController
{

    private $appointmentDAO;
    private $jobOfferDAO;
    private $loggedUser;

    public function __construct()
    {
        $this->appointmentDAO = new AppointmentDAO();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->loggedUser = $this->loggedUserValidation();
    }

    public function showApplyView($studentId, $jobOfferId, $message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedStudent.php");


        $flag = $this->validateActiveStudent($studentId);
        if ($flag == 1) {
            $validate = $this->uniqueAppointment($studentId);
            if ($validate == 1) {
                $this->showAppointmentList($valueToSearch = null, $back = null, "Only one active application is allowed");
            } else {
                require_once(VIEWS_PATH . "applyJobOffer.php");
            }

        } else {
            $this->showWelcomeView('Your account is not active, please get in contact with the university'); //in case the student is inactive at the moment of applying a job
        }

    }


    public function showAppointmentList($valueToSearch = null, $back = null, $message = "")
    {
        //valueToSearch = $jobOffer ID
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        if ($this->loggedUser instanceof Student) {
            try {
                $actualAppointment = $this->appointmentDAO->getAppointment($this->loggedUser->getStudentId());

            } catch (\PDOException $ex) {
                echo $ex->getMessage();
            }

            //esto solo funciona si actualappointment retorna algo, sino tira error
            if ($actualAppointment != null) {
                if (strtotime($actualAppointment->getJobOffer()->getEndDate()) < strtotime(date("Y-m-d"))) {

                    $message = $this->Remove($this->loggedUser->getStudentId(), 1);
                    $actualAppointment= null;
                }
                else
                {

                    try {
                        $career = new CareerDAO();
                        $searchCareer = $career->getCareer($actualAppointment->getJobOffer()->getCareer()->getCareerId());

                    } catch (\PDOException $ex) {
                        echo $ex->getMessage();
                    }
                }
            }

            $appointmentHistory = new AppointmentHistoryDAO();
            try {

                $historyAppointments = $appointmentHistory->getHistoryAppointments($this->loggedUser->getStudentId());

            } catch (\PDOException $ex) {
                echo $ex->getMessage();
            }

            require_once(VIEWS_PATH . "appointmentsList.php");

        } else if ($this->loggedUser instanceof Administrator) {
            try {

                $allAppointments = $this->appointmentDAO->getAll();

                if ($allAppointments != null) {
                    //search appointments from this jobofferid
                    $allAppointments = $this->searchAppointments($allAppointments, $valueToSearch); //valueToSearch = $jobOffer ID

                    if ($allAppointments != null) {
                        try {   //find the joboffer and set the appointment array
                            $searchedJobOffer = $this->jobOfferDAO->getJobOffer($valueToSearch); //search jobOffer llenar array
                            $searchedJobOffer->setAppointment($allAppointments);
                            $allAppointments = $searchedJobOffer->getAppointment();

                            try {
                                $career = new CareerDAO();
                                $searchCareer = $career->getCareer($allAppointments[0]->getJobOffer()->getCareer()->getCareerId());

                            } catch (\PDOException $ex) {
                                echo $ex->getMessage();
                            }
                        } catch (\PDOException $ex) {
                            echo $ex->getMessage();
                        }

                    } else {
                        $message = "There are currently no applications for the selected job offer ";
                    }
                } else {
                    $message = "There are currently no applications in the system";
                }


                require_once(VIEWS_PATH . "appointmentsList.php");

            } catch (\PDOException $ex) {
                echo $ex->getMessage();
            }
        }

    }


    public function uniqueAppointment($studentId)
    {
        try {

            $searchedAppointment = $this->appointmentDAO->getAppointment($studentId);
        }
        catch (\PDOException $ex)
        {
             echo $ex->getMessage();
        }

        $validate=0;
        if ($searchedAppointment != null)
        {
            if (strtotime($searchedAppointment->getJobOffer()->getEndDate()) < strtotime(date("Y-m-d"))) { //no more actual appointment
                $message = $this->Remove($this->loggedUser->getStudentId(), 1);
                $validate = 0;
            }
            else //actual appointment correct
            {
                $validate = 1;
            }

            if($validate==0)
            {
                $validate= $message;
            }

        }

        return $validate;
    }


        public function addAppointment($text, $studentId, $jobOfferId, $cv)
        {
            require_once(VIEWS_PATH . "checkLoggedStudent.php");


            $appointment = new Appointment();
            $appointment = $this->validateCv($appointment);

            if ($appointment != null) {
                $appointment->setMessage($text);
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($jobOfferId);
                $appointment->setJobOffer($jobOffer);
                $appointment->setDate((new \DateTime())->format('Y-m-d'));
                $student = new Student();
                $student->setStudentId($studentId);
                $appointment->setStudent($student);

                try {
                    $count = $this->appointmentDAO->add($appointment);

                    if ($count > 0) {
                        $searchOffer = $this->jobOfferDAO->getJobOffer($jobOfferId);
                        $history = new AppointmentHistory();
                        $offer = new JobOffer();
                        $offer->setTitle($searchOffer->getTitle());
                        $history->setJobOffer($offer);
                        $history->setAppointmentDate($appointment->getDate());
                        $career = new Career();
                        $career->setDescription($searchOffer->getCareer()->getDescription());
                        $history->setCareer($career);
                        $student = new Student();
                        $student->setStudentId($studentId);
                        $history->setStudent($student);
                        try {
                            $companyDao = new CompanyDAO();
                            $searchCompany = $companyDao->getCompany($searchOffer->getCompany()->getCompanyId());
                            $company = new Company();
                            $company->setName($searchCompany->getName());
                            $company->setCuit($searchCompany->getCuit());
                            $history->setCompany($company);
                        } catch (\PDOException $ex) {
                            echo $ex->getMessage();
                        }

                        $historyDAO = new AppointmentHistoryDAO();
                        try {
                            $historyDAO->add($history);
                        } catch (\PDOException $ex) {
                            echo $ex->getMessage();
                        }
                    }

                    $this->showAppointmentList($valueToSearch = null, $back = null, "Successfully added application");

                } catch (\PDOException $ex) {
                    echo $ex->getMessage();
                }
            } else {
                $this->showApplyView($studentId, $jobOfferId, "Please enter a validad curriculum file");
            }


        }

        //SIN USAR BORRAR!
        public function searchAppointmentFiltreASD($allAppointment, $valueToSearch)
        {
            $searchedAppointment = array();

            if ($valueToSearch != null) {
                foreach ($allAppointment as $value) {
                    if ($value->getAppointmentId() == $valueToSearch)  // ID == ID
                    {
                        array_push($searchedAppointment, $value);
                    }
                }
            } else {
                $searchedAppointment = $allAppointment;
            }

            if ($valueToSearch == 'Show all apointments' || $valueToSearch == 'Back') {
                $searchedAppointment = $allAppointment;
            }

            return $searchedAppointment;
        }


        public function Remove($studentId, $system = null)
        {
            require_once(VIEWS_PATH . "checkLoggedStudent.php");

            try {

                $count = $this->appointmentDAO->remove($studentId);
                if ($count > 0) {
                    $studentDAO = new StudentDAO();
                    try {
                        $student = $studentDAO->getStudent($studentId);
                        $path = "uploads/";
                        $file_pattern = $path . $student->getDni() . '*';
                        $result = array_map("unlink", glob($file_pattern));

                        $flag = 0;

                        if (!empty($result) && $system == null) {
                            $message = "Appointment dropped out successfully";
                            $this->showAppointmentList(null, null, $message);
                        } else if (!empty($result) && $system != null) {
                            $flag = 1;
                            $message = "Your current job appointment was terminated as result of reaching the job offer's end date";
                        }
                    } catch (\PDOException $ex) {
                        echo $ex->getMessage();
                    }
                } else {
                    $message = "Appointment cannot be dropped out, try again";
                    $this->showAppointmentList(null, null, $message);
                }

            } catch (\PDOException $ex) {
                echo $ex->getMessage();
            }

            if ($system != null && $flag == 1) {
                return $message;
            }
        }


        /**
         * Validate if an student is currently active
         * @param $studentId
         * @return int
         */
        public function validateActiveStudent($studentId)
        {
            $studentsOrigin = new OriginStudentDAO();
            $allStudents = $studentsOrigin->start($studentsOrigin);

            $flag = 0;
            foreach ($allStudents as $value) {
                if ($value->getStudentId() == $studentId) {
                    if ($value->getActive() == 'true') {
                        $flag = 1;
                    }
                }
            }

            return $flag;
        }

        public function showWelcomeView($message = "")
        {
            require_once(VIEWS_PATH . "welcome.php");
        }


        public function validateCv($appointment)
        {
            $statusMsg = '';
            // File upload path
            $targetDir = "uploads/";
            //$fileName = basename($_FILES["cv"]["name"]);

            $temp = explode(".", $_FILES["cv"]["name"]); //tomo la extension
            $newfilename = $this->loggedUser->getDni() . '.' . end($temp); //le doy nuevo nombre y le concateno la extension

            $targetFilePath = $targetDir . $newfilename;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $flag = 0;
            if (!empty($_FILES["cv"]["name"])) {
                // Allow certain file formats
                $allowTypes = array('pdf');
                if (!file_exists($targetFilePath)) { //image already exist in the folder
                    if (in_array($fileType, $allowTypes)) {

                        // Upload file to server
                        if (move_uploaded_file($_FILES["cv"]["tmp_name"], $targetFilePath)) { //image doesn't exist in the folder, add it (si no funciona, sacar el . $newfilename)

                            // Insert image file name into database
                            $appointment->setCv($newfilename); //---->antes era $filename y lo cambie por $newfilename

                        } else {
                            /* $statusMsg = "Sorry, there was an error uploading your file";*/
                            $flag = 1;
                        }
                    } else {
                        /*$statusMsg = "Sorry, only PDF, DOC files are allowed to upload.";*/
                        $flag = 1;
                    }
                } else {
                    /* $statusMsg = "The file <b>".$fileName. "</b> is already exist";*/


                    $path = 'uploads/';
                    $files = scandir($path);

                    $flag = 1;
                    foreach ($files as $value) {
                        if ($value == $newfilename) //--->antes era $filename y lo camnbie por newfilename
                        {
                            $appointment->setCv($newfilename); //--->antes era $filename y lo camnbie por newfilename
                            $flag = 0;
                        }
                    }
                }
            } else {
                /*$statusMsg = 'Please select a file to upload';*/
                $flag = 1;
            }
            // Display status message
            if ($flag == 1) {
                return null;
            } else {
                return $appointment;
            }
        }


        public function searchAppointments($allAppointments, $jobOfferId)
        {
            $appointments = array();

            if (is_array($allAppointments)) {
                foreach ($allAppointments as $value) {
                    if ($value->getJobOffer()->getJobOfferId() == $jobOfferId) {
                        array_push($appointments, $value);
                    }
                }

            } else if (is_object($allAppointments)) {
                if ($allAppointments->getJobOffer()->getJobOfferId() == $jobOfferId) {
                    array_push($appointments, $allAppointments);
                }
            }
            if (empty($appointments)) {
                $appointments = null;
            }

            return $appointments;
        }


        /**
         * Validate if the admin/student has logged in the system correctly
         * @return mixed|null
         */
        public function loggedUserValidation()
        {
            $loggedUser = null;

            if (isset($_SESSION['loggedadmin'])) {
                $loggedUser = $_SESSION['loggedadmin'];
            } else if (isset($_SESSION['loggedstudent'])) {
                $loggedUser = $_SESSION['loggedstudent'];
            }

            return $loggedUser;
        }


    /**
     * Show view to look pdf cv
     */
        public function viewCv($filename)
        {
            require_once(VIEWS_PATH . "viewCv.php");
        }


    }
