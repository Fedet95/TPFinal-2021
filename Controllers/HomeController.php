<?php

namespace Controllers;


use DAO\OriginCareerDAO;
use DAO\OriginStudentDAO;
use DAO\CareerDAO;
use DAO\UserDAO;
use DAO\UserRolDAO;
use Models\Student;
use Models\User;

/**
 *
 */
class HomeController
{
    private $userDAO;
    private $userRolDAO;
    private $Sorigin; //api student
    private $studentsOrigin; //students array



    public function __construct()
    {
        $this->userRolDAO= new UserRolDAO();
        $this->userDAO = new UserDAO();
        $this->Sorigin=new OriginStudentDAO();
    }

    public function Index($message = "")
    {
        require_once(VIEWS_PATH."welcome.php");
    }


    public function welcome($message = "")
    {
        //$this->Logout();
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

                if ($searchedUser->getPassword() == $password) //verifico la pass, si esta mal no verifico el resto
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

              $user->setPassword($password1);
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




}

?>