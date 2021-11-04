<?php

namespace Controllers;

use DAO\AdministratorDAO;
use DAO\OriginCareerDAO;
use DAO\OriginStudentDAO;
use DAO\CareerDAO;
use DAO\StudentDAO;

/**
 *
 */
class HomeController
{
    private $administratorDAO;
    private $studentDAO;
    private $Sorigin; //api student
    private $studentsOrigin; //students array
    private $careerDAO;
    private $careersOrigin; //api careers



    public function __construct()
    {
        $this->administratorDAO = new AdministratorDAO();
        $this->studentDAO = new StudentDAO();
        $this->Sorigin=new OriginStudentDAO();
        $this->careerDAO=new CareerDAO();
        $this->careersOrigin= new OriginCareerDAO();

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
        require_once(VIEWS_PATH."checkLoggedStudent.php");
        require_once(VIEWS_PATH."studentControlPanel.php"); //panel de control
    }

    /**
     * * Send to administrator control panel view
     * @param string $message
     */
    public function showAdministratorControlPanelView($message = "")
    {
        require_once(VIEWS_PATH."checkLoggedAdmin.php");
        require_once(VIEWS_PATH."administratorControlPanel.php"); //panel de control
    }


    public function showContactUsView($message= "")
    {
        require_once(VIEWS_PATH."checkLoggedStudent.php");
        require_once (VIEWS_PATH."contactUs.php");
    }


    /**
     * Validate login, sending to the correspondent view
     * @param $email
     */
    public function login($email, $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // invalid emailaddress
        {
            $message = 'Error, enter a valid email';
            $this->welcome($message);
        } else
        {
            $searchedStudent = $this->searchStudentEmail($email); //busca email del student, retorna student o null

            if ($searchedStudent) //If is not NULL
            {
                    if ($searchedStudent->getActive()) //if is TRUE
                    {

                        try {
                            $studentFromDao= $this->studentDAO->getStudent($searchedStudent->getStudentId());
                        }
                        catch (\PDOException $ex){
                            echo $ex->getMessage();
                        }

                        if($studentFromDao==null)
                        {
                            $this->studentDAO->updateStudentFile($searchedStudent);
                        }

                        if($studentFromDao!=null && $studentFromDao->getPassword()==$password)
                        {
                            $careers= $this->careersOrigin->start($this->careersOrigin);
                            $this->careerDAO->getCareersOrigin($careers);
                            $this->studentDAO->updateStudentFile($searchedStudent);
                            $_SESSION['loggedstudent']=$searchedStudent;
                            $this->showStudentControlPanelView();
                        }
                        else if($studentFromDao->getPassword()==null)
                        {
                            $message = 'You are not registered, please sign up';
                            $this->showsignUpView(null, $message);
                        }
                        else
                        {
                            $message = 'Incorrect Password';
                            $this->welcome($message);
                        }
                    }
                    else
                    {
                        $this->studentDAO->updateStudentFile($searchedStudent);
                        $message = 'Your account is not active, please get in contact with the university';
                        $this->welcome($message);
                    }

            }
            else
            {
                try {
                    $administrator= $this->administratorDAO->searchByEmail($email); //retorna el administrador o null
                }
                catch(\PDOException $ex)
                {
                    echo $ex->getMessage();
                }

                 if($administrator)
                 {
                     if($administrator->getActive())
                     {
                         if($administrator->getPassword()==$password)
                         {
                             $careers= $this->careersOrigin->start($this->careersOrigin);
                             $this->careerDAO->getCareersOrigin($careers);
                             $this->studentDAO->updateStudentFile(null, $this->studentsOrigin);
                             $_SESSION['loggedadmin']=$administrator;
                             $this->showAdministratorControlPanelView();
                         }
                         else{
                             $message = 'Incorrect Password';
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
                     $message = 'Error, enter a valid email';
                     $this->welcome($message);
                 }
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
        $students = $this->Sorigin->start($this->Sorigin);
        $this->studentsOrigin=$students;
        $searchedStudent = null;

        foreach ($students as $value) {
            if ($value->getEmail() == $email) {
                $searchedStudent = $value;
            }
        }
        return $searchedStudent;
    }


    public function signUp($email, $dni)
    {
        $searchedStudent= $this->searchStudentEmail($email);
        $studentFromDao=null;

        try {
            $studentFromDao= $this->studentDAO->getStudent($searchedStudent->getStudentId());
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        if($searchedStudent!=null)
        {
            if($studentFromDao!=null  && $studentFromDao->getPassword()==null)
            {
                $dniValueReplace = str_replace("-", "", $searchedStudent->getDni());
                if ($dniValueReplace == $dni)
                {

                    $this->showsignUpView($searchedStudent);
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
            $message="Enter a valid email";
            $this->showsignUpView(null, $message);
        }
    }

    public function signUpPassword($password1, $password2, $email)
    {
        $searchedStudent=$this->searchStudentEmail($email);

         if($password1==$password2)
         {
              $searchedStudent->setPassword($password1);
              $this->studentDAO->updateStudentFile($searchedStudent);
              $this->welcome("Sign up successfully");
         }
         else
         {
             $message="Passwords do not match";
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




}

?>