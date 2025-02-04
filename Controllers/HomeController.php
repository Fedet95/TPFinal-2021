<?php

namespace Controllers;


use DAO\AppointmentDAO;
use DAO\CompanyDAO;
use DAO\CountryDAO;
use DAO\IndustryDAO;
use DAO\JobOfferDAO;
use DAO\OriginStudentDAO;
use DAO\UserDAO;
use DAO\UserRolDAO;
use Models\SessionHelper;
use Models\User;
use Models\Company;

class HomeController
{
    private $userDAO;
    private $userRolDAO;
    private $Sorigin; //api student
    private $studentsOrigin; //students array
    private $loggedUser;



    public function __construct()
    {
        $this->userRolDAO= new UserRolDAO();
        $this->userDAO = new UserDAO();
        $this->Sorigin=new OriginStudentDAO();
        $this->loggedUser = $this->loggedUserValidation();
    }

    public function Index($message = "")
    {
        require_once(VIEWS_PATH."welcome.php");
    }


    public function welcome($message = "")
    {

        require_once(VIEWS_PATH."home.php");
    }



    public function showsignUpView($student=null, $message= "")
    {
        require_once (VIEWS_PATH."signUp.php");
    }

    /**
     * * Send to student control panel view
     * @param string $message
     */
    public function showStudentControlPanelView($message = "")
    {
        //requir
        SessionHelper::checkStudentSession();
        $this->verifyEndDate();
        require_once(VIEWS_PATH."studentControlPanel.php"); //panel de control
    }

    /**
     * * Send to administrator control panel view
     * @param string $message
     */
    public function showAdministratorControlPanelView($message = "")
    {

        SessionHelper::checkAdminSession();
        $finalArray= $this->adminPanelCards();
        $this->verifyEndDate();
        require_once(VIEWS_PATH."administratorControlPanel.php"); //panel de control
    }

    /**
     * * Send to company control panel view
     * @param string $message
     */
    public function showCompanyControlPanelView($email, $message = "")
    {
        SessionHelper::checkCompanySession();
        $this->verifyEndDate();


        $companyDao= new CompanyDAO();


        try {
            $company= $companyDao->getCompanyByEmail($email);
        }catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        require_once(VIEWS_PATH."companyControlPanel.php"); //panel de control
    }




    public function showContactUsView($message= "")
    {

        SessionHelper::checkStudentSession();
        require_once (VIEWS_PATH."contactUs.php");
    }


    /**
     * Validate login, sending to the correspondent view
     * @param $email
     * @param $password
     */
    public function login($email, $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // invalid emailaddress
        {
            $message = 'Error, enter a valid email';
            $this->welcome($message);
        } else {
            try {
                $searchedUser = $this->userDAO->searchByEmail($email); //retorna un usuario por email, verifico su pass y verifico su rol

            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }

            if ($searchedUser) //si encuentro a un user con ese email (student registrado o administrador)
            {


                if (password_verify( $password, $searchedUser->getPassword())) //verifico la pass, si esta mal no verifico el resto
                {

                    try {
                        $userRol = $this->userRolDAO->getRol($searchedUser->getRol()->getUserRolId()); //busco el rol del usuario enviandole el rol ID

                    } catch (\Exception $ex) {
                        echo $ex->getMessage();
                    }

                    if (strcasecmp($userRol->getRolName(), 'administrator') == 0) //administrador
                    {
                        $_SESSION['loggedadmin'] = $searchedUser;
                        $this->showAdministratorControlPanelView();

                    } else if (strcasecmp($userRol->getRolName(), 'student') == 0) //registered student
                    {
                        $searchedStudent = $this->searchStudentEmail($email); //search api student by email

                        //var_dump($searchedStudent); -->ACA ME MUESTRA BIEN EL USUARIO QUE TRAE DE LA API Y SOLO COMPARA LOS EMAIL
                        if ($searchedStudent != null) {
                            if ($searchedStudent->getActive()) {

                                $_SESSION['loggedstudent'] = $searchedUser;
                                $this->showStudentControlPanelView();
                            } else {
                                $message = 'Your account is not active, please get in contact with the university';
                                $this->welcome($message);
                            }
                        }

                    }
                    else if(strcasecmp($userRol->getRolName(), 'company') == 0)
                    {
                        $companyDao= new CompanyDAO();

                        try {
                            $searchedCompany= $companyDao->getCompanyByEmail($email);
                            if($searchedCompany!=null)
                            {
                                if($searchedCompany->getActive()=='true')
                                {
                                    $_SESSION['loggedcompany'] = $searchedUser;
                                    $this->showCompanyControlPanelView($email, null);
                                }
                                else
                                {
                                    $message = 'Your account is not active, please get in contact with the university';
                                    $this->welcome($message);
                                }
                            }
                        }
                        catch (\Exception $ex)
                        {
                            echo $ex->getMessage();
                        }

                    }
                } else {
                    $message = 'Incorrect Password';
                    $this->welcome($message);
                }

            } else {
                $message = 'Error, enter a valid email.';
                $this->welcome($message);
            }
        }

    }


    /**
     * Search the entered student email, returning the searched user or null
     * @param $email
     * @return mixed|null
     */
    public function searchStudentEmail($email)
    {
        $this->studentsFromOrigin();
        $searchedStudent = null;

        foreach ($this->studentsOrigin as $value) {
            if ($value->getEmail() == $email) {
                $searchedStudent = $value;
            }
        }
        return $searchedStudent;
    }

    /**
     * Returns students from origin
     * @param $email
     * @return mixed|null
     */
    public function studentsFromOrigin()
    {
        if($this->studentsOrigin==null) {
            $students = $this->Sorigin->start($this->Sorigin);
            $this->studentsOrigin = $students;
        }
    }


    /**
     * Validates signing up in the system
     */
    public function signUp($email, $dni)
    {
        $searchedStudent= $this->searchStudentEmail($email); //from origin
        $studentFromDao=null;

        if($searchedStudent!=null)
        {
           if($searchedStudent->getActive())
           {
               try {
                   $studentFromDao= $this->userDAO->searchByEmail($searchedStudent->getEmail()); //search registered student with entered email
               }
               catch (\Exception $ex)
               {
                   echo $ex->getMessage();
               }

               if($studentFromDao==null) //if is not registered
               {
                   $dniValueReplace = str_replace("-", "", $searchedStudent->getDni());
                   if ($dniValueReplace == $dni)
                   {
                       $this->showsignUpView($searchedStudent); //registre
                   }
                   else
                   {
                       $message="Enter a valid DNI";
                       $this->showsignUpView(null, $message);
                   }
               }
               else
               {
                   $message="You are currently registered";
                   $this->welcome($message);
               }
           }
           else
           {
               $message = 'Your account is not active, please get in contact with the university';
               $this->welcome($message);
           }
        }
        else
        {
            $message="Enter a valid email";
            $this->showsignUpView(null, $message);
        }
    }

    /**
     * Validates signing up password in the system
     */
    public function signUpPassword($password1, $password2, $email)
    {
         if($password1==$password2)
         {
              $user= new User();

             try
             {
                 $userRol = $this->userRolDAO->getAll();
             }catch (\Exception $ex)
             {
                 throw $ex;
             }

             $rol=null;
             if($userRol!=null)
             {
                 if(is_array($userRol))
                 {
                     foreach ($userRol as $value)
                     {
                         if($value->getRolName()=='student')
                         {
                             $rol=$value;
                         }
                     }
                 }
                 else
                 {
                     if($userRol->getRolName()=='student')
                     {
                         $rol=$userRol;
                     }
                 }
             }

             $encrypted_password=password_hash($password1,PASSWORD_DEFAULT);
             $user->setPassword($encrypted_password);
              $user->setRol($rol);
              $user->setEmail($email);
              $this->userDAO->add($user);
              $this->welcome("Sign up successfully");
         }
         else
         {
             $message="Passwords do not match";
             $searchedStudent= $this->searchStudentEmail($email);
             $this->showsignUpView($searchedStudent, $message);
         }
    }


    /**
     * Logout from system
     */
    public function Logout()
    {

        session_destroy();

        $this->Index();
    }


    /**
     * Send a mail from an student to the administration
     * @param $text
     * @param $name
     * @param $email
     * @param $sub
     */
    public function sendEmail ($text, $name, $email, $sub)
    {
        $to = 'juanpayetta@gmail.com';
        $subject = $sub;
        $message = $text;
        $headers = 'From: '.$email. ' '. "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        if (mail($to, $subject, $message, $headers))
            $this->showContactUsView("Thank you for contacting us, we will be responding as soon as possible!");

        else
            $this->showContactUsView("Error, please try again");

    }


    /**
     * Returns information to show on cards in admin control panel view
     */
    public function adminPanelCards()
    {
        $companydao = new CompanyDAO();
        $userdao = new UserDAO();
        $jobOfferdao = new JobOfferDAO();

        $allCompanies = $companydao->getAll();
        $allStudents = $userdao->getRol(2);
        $allOffers = $jobOfferdao->getAll();


        if ($allOffers == null) {
            $cantO = 0;
        }
        else {
            if(is_object($allOffers))
            { $offer= $allOffers;
                $allOffers= array();
                array_push($allOffers, $offer);
            }
            $cantO=count($allOffers);
        }

        if ($allCompanies == null) {
            $cantC = 0;
        }
        else
        {
            if (is_object($allCompanies)) {
                $com = $allCompanies;
                $allCompanies = array();
                array_push($allCompanies, $com);
            }


            $cantC= count($allCompanies);
        }

        if($allStudents==null)
        {
          $cantS=0;
        }
        else
        {

            if(is_object($allStudents))
            { $std= $allStudents;
                $allStudents= array();
                array_push($allStudents, $std);
            }
            $cantS= count($allStudents);
        }


        $finalArray= array("cantC"=>$cantC, "cantS"=>$cantS, "cantO"=>$cantO);

        return $finalArray;

    }


    public function verifyEndDate()
    {
        $offerDao= new JobOfferDAO();
        $allOffers= $offerDao->getAll();

        if($allOffers!=null)
        {
            foreach ($allOffers as $offer)
            {
                if(strtotime($offer->getEndDate()) < strtotime(date("Y-m-d")) && $offer->getEmailSent()!=1)  {
                    $offer->setActive("false"); //string
                    $offer->setEmailSent(1); //boolean
                    try {
                        $offerDao->update($offer);
                    } catch (\Exception $ex)
                    {
                        echo $ex->getMessage();
                    }

                    $appointmentDao= new AppointmentDAO();
                    $appointments= $appointmentDao->getAppointmentFromOffers($offer->getJobOfferId());

                    if($appointments!=null)
                    {
                        $studentsId= array();
                        foreach ($appointments as $value)
                        {
                            array_push($studentsId,$value->getStudent()->getUserId());
                        }

                        $allStudents= new User();

                        $userDAO= new UserDAO();
                        try {
                            $allStudents=$userDAO->getRol(2);
                        }catch (\Exception $ex)
                        {
                            echo $ex->getMessage();
                        }


                        $studentsEmails= array();
                        $sub="Appointment Expiration";
                        $text="UTN Job Search thanks you for applying to one of our job offers (id: ".$offer->getJobOfferId()."), which has reached its deadline. We wish you the best of luck!";

                        foreach ($allStudents as $student)
                        {
                            foreach ($studentsId as $id)
                            {
                                if($student->getUserId()==$id)
                                {
                                    array_push($studentsEmails, $student->getEmail());
                                    $this->sendEmailEndDate($student->getEmail(), $sub, $text);
                                    $this->sendEmailEndDate("juanpayetta@gmail.com", $sub, $text); //me auto envio mensaje para probar que funcione
                                }
                            }
                        }

                        /* ENVIO DE EMAIL A COMPAÑIA, BUSCAR EL EMAILD E LA COMPAÑIA CORRESPONDIENTE A ESTA JOB OFFER (mensaje que mire los postulantes)
                        $sub="Appointment Expiration";
                        $text="UTN Job Search thanks you for applying to one of our job offers, which has reached its deadline. We wish you the best of luck!";
                        $this->sendEmailEndDate($student->getEmail(), $sub, $text);
                        */

                    }
                }
            }
        }
    }

    /**
     * Send a mail from the system to the inserted email
     * @param $email
     * @param $sub
     * @param $text
     */
    public function sendEmailEndDate ($email, $sub, $text)
    {
        $to = $email;
        $subject = $sub;
        $message = $text;
        $headers = 'From: tpfinalutn2021@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        if (mail($to, $subject, $message, $headers))
            echo "Email sent";
        else
            echo "Email sending failed";
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
        }
        else if(isset($_SESSION['loggedstudent'])) {
            $loggedUser = $_SESSION['loggedstudent'];
        }
        else if(isset($_SESSION['loggedcompany'])) {
            $loggedUser = $_SESSION['loggedcompany'];
        }

        return  $loggedUser;
    }


    public function companyUserControlPanel()
    {
        if($this->loggedUser->getRol()->getUserRolId()==3)
        {
            $email= $this->loggedUser->getEmail();
            $this->showCompanyControlPanelView($email);
        }

    }



}

?>