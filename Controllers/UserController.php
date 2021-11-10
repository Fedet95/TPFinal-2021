<?php

namespace Controllers;

use Models\SessionHelper;

SessionHelper::checkUserSession();

use DAO\OriginStudentDAO;
use DAO\UserDAO;
use DAO\UserRolDAO;
use Models\User;


//require_once(VIEWS_PATH . "checkLoggedUser.php");


class UserController
{

    private $userDAO;
    private $loggedUser;
    private $allStudents;
    private $studentsOrigin;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->loggedUser = $this->loggedUserValidation();
        $this->studentsOrigin = new OriginStudentDAO();
    }

    /**
     * Show the administrator list view
     * @param string $message
     */
    public function showAdminListView($message = "")
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        $userRol = $this->getRolId("administrator");

        if ($userRol != null) {
            try {
                $allAdmins = $this->userDAO->getRol($userRol->getUserRolId());
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }

            if (is_object($allAdmins)) {
                $admin = $allAdmins;
                $allAdmins = array();
                array_push($allAdmins, $admin);
            }

            require_once(VIEWS_PATH . "adminListView.php");
        }

    }

    /**
     * Show the administrator creation view
     * @param string $message
     */
    public function showAdminCreateView($message = "")
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        require_once(VIEWS_PATH . "createAdmin.php");

    }

    /**
     * Show the administrator edit view
     * @param $id
     * @param string $message
     */
    public function showAdminEditView($id,$confirmPassword = null, $validate = null, $message = "")
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        try {
            $admin = $this->userDAO->getUser($id);


        } catch (\Exception $ex) {
            throw $ex;
        }

        $confirmAccess=null;

        if($confirmPassword != null){
            if($validate!=null)
            {
                 if($confirmPassword ==  $admin->getPassword())
                 {
                     $confirmAccess = $confirmPassword;
                 }
                 else
                 {
                     $message = "Incorrect Password";
                 }
            }
            else
            {
                if(password_verify( $confirmPassword, $admin->getPassword()))
                {

                    $confirmAccess = $confirmPassword;
                }
                else
                {
                    $message = "Incorrect Password";
                }

            }

        }

        require_once(VIEWS_PATH . "editAdmin.php");
    }


    /**
     * * Send to student control panel view
     * @param string $message
     */
    public function showStudentControlPanelView($message = "")
    {
        //require_once(VIEWS_PATH . "checkLoggedStudent.php");
        SessionHelper::checkStudentSession();
        require_once(VIEWS_PATH . "studentControlPanel.php");
    }


    /**
     * Show the list of students view
     * @param null $valueToSearch
     * @param null $back
     * @param string $message
     */
    public function showStudentListView($valueToSearch = null, $back = null, $message = "")
    {

        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        $userRol = $this->getRolId("student");


        if ($userRol != null) {
            try {
                $allStudents = $this->userDAO->getRol($userRol->getUserRolId());
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }

            if (is_object($allStudents)) {
                $student = $allStudents;
                $allStudents = array();
                array_push($allStudents, $student);
            }

            $searchedStudent = $this->searchStudentFiltreASD($allStudents, $valueToSearch, $back);
            require_once(VIEWS_PATH . "studentList.php");
        }

    }

    /**
     * Show the extended list of students view
     * @param $studentId
     */
    public function showMoreStudentView($email) //antes era con id, pero como el id de la api y de la base son diferentes, puse email que es =
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        if ($this->allStudents == null) {
            $allStudents = $this->studentsOrigin->start($this->studentsOrigin);

        } else {
            $allStudents = $this->allStudents;
        }


        $studentMore = null;

        foreach ($allStudents as $value) {
            if ($value->getEmail() == $email) {
                $studentMore = $value;
            }
        }


        require_once(VIEWS_PATH . "studentListViewMore.php");
    }


    /**
     * Filter an student by DNI
     * @param $allStudents
     * @param $valueToSearch
     * @return array|mixed|\Models\User|\Models\User[]|null
     */
    public function searchStudentFiltreASD($allStudents, $valueToSearch)
    {
        $searchedStudent = array();

        if ($valueToSearch != null) {

            foreach ($allStudents as $value) {
                $dniValueReplace = str_replace("-", "", $value->getDni());
                if ($dniValueReplace == $valueToSearch) {
                    array_push($searchedStudent, $value);
                }
            }
        } else {
            $searchedStudent = $allStudents;
        }


        if ($valueToSearch == 'Show all students' || $valueToSearch == 'Back') {
            $searchedStudent = $allStudents;
        }

        return $searchedStudent;
    }

    /**
     * Validate if the admin/stundent has logged in the system correctly
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
     * Gets the user rol
     */
    public function getRolId($rolName)
    {
        try {
            $userRolDAO = new UserRolDAO();
            $userRol = $userRolDAO->getRolIdByRolName($rolName);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }

        return $userRol;
    }

    //---------------------------------------------------------------------------------------------------


    /**
     * Adds an administator to the system
     */
    public function addAdmin($email, $password)
    {
        SessionHelper::checkAdminSession();

        $userRol = $this->getRolId("administrator");

        if ($userRol != null) {
            try {
                $allAdmins = $this->userDAO->getRol($userRol->getUserRolId());
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }

            if (is_object($allAdmins)) {
                $admin = $allAdmins;
                $allAdmins = array();
                array_push($allAdmins, $admin);
            }


            $flag = 0;
            if ($allAdmins != null) {
                foreach ($allAdmins as $value) {
                    if (strcasecmp($value->getEmail(), $email) == 0) {
                        $flag = 1;
                        $message = "The Email " . $email . " is already registered";
                        break;
                    }
                }
                if ($flag == 1) {
                    $this->showAdminCreateView($message);
                } else {
                    $adminAux = new User();
                    $adminAux->setEmail($email);
                    $encrypted_password=password_hash($password,PASSWORD_DEFAULT);
                    $adminAux->setPassword($encrypted_password);
                    //$adminAux->setPassword($password);
                    $adminAux->setRol($userRol);


                    try {

                        $this->userDAO->add($adminAux);
                        $this->showAdminListView("Administrator succesfullly created");

                    } catch (\Exception $ex) {

                        echo $ex->getMessage();
                    }
                }
            } else {
                $adminAux = new User();
                $adminAux->setEmail($email);
                $encrypted_password=password_hash($password,PASSWORD_DEFAULT);
                $adminAux->setPassword($encrypted_password);
                //$adminAux->setPassword($password);
                $adminAux->setRol($userRol);

                try {

                    $this->userDAO->add($adminAux);
                    $this->showAdminListView("Administrator succesfullly created");

                } catch (\Exception $ex) {

                    echo $ex->getMessage();
                }
            }
        }

    }


    /**
     * Remove an administtator from the system
     * @param $id
     */
    public function Remove($id)
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        $userRol = $this->getRolId("administrator");

        if ($userRol != null) {

            $flag = 0;
            try {
                $allAdmins = $this->userDAO->getRol($userRol->getUserRolId());
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }

            if (is_object($allAdmins)) { //only one admin in the system
                $flag = 1;
            }
        }

        if ($flag == 0) {
            try {
                $count = $this->userDAO->remove($id);

                if ($count > 0) {
                    $message = "Administrator successfully removed";
                } else {
                    $message = "Error, try again";
                }
                $this->showAdminListView($message);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            $message = "The system currently only has one administrator and cannot be deleted";
            $this->showAdminListView($message);
        }
    }

    /**
     * Update the administator values
     */
    public function updateAdmin($id, $email, $newPassword, $confirmPassword)
    {
        SessionHelper::checkAdminSession();
        $userRol = $this->getRolId("administrator");

        if ($userRol != null) {

            try {
                $allAdmins = $this->userDAO->getRol($userRol->getUserRolId());
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }


        if (is_object($allAdmins)) {
            $admin = $allAdmins;
            $allAdmins = array();
            array_push($allAdmins, $admin);
        }

        $flag = 0;

        $validEmail = $this->validateEmail($email);
        if ($validEmail == false) {
            $message = "Error, enter a valid email";
            $flag = 1;
        }

        if ($flag == 0) {
            foreach ($allAdmins as $value) {
                if ($value->getUserId() != $id) {
                    if (strcasecmp($value->getEmail(), $email) == 0) {
                        $flag = 1;
                        $message = "The email " . $email . " is already registered";
                        var_dump($flag);
                        break;
                    }
                }
            }
        }

        /*AHORA YA NO VALIDAMOS LA PW CON EL DAO PORQUE SE VERIFICÓ ANTES DE ENTRAR A EDITAR. SOLO VERIFICAMOS QUE INGRESO CORRECTAMENTE LA NUEVA

        if ($flag == 0) {
            foreach ($allAdmins as $value) {
                if ($value->getUserId() == $id) {
                    if ($value->getPassword() != $actualPassword) {
                        $flag = 1;
                        $message = "Error, incorrect password";
                    }
                }
            }
        }*/

        /*if($newPassword != null && $confirmPassword != null) {

            if ($validPassword == false) {
                $flag = 1;
                if ($newPassword == null && $confirmPassword != null) {

                    $message = "Error. You must enter a password in both fields.";

                } else {
                    $message = "Error. Passwords do not match.";
                }
            }
        }*/

        if($flag==0)
        {
            if($newPassword != null)
            {
                if($confirmPassword!= null)
                {

                    $validPassword = $this->validatePassword($newPassword, $confirmPassword);

                    if($validPassword == false)
                    {
                        $message = "Error. Passwords do not match.";
                        $flag=1;
                    }
                }
                else
                {
                    $message = "Error. You must enter a password in both fields.";
                    $flag =1;
                }

            }
            else if($confirmPassword != null)
            {
                $message = "Error. You must enter a password in both fields.";
                $flag =1;
            }

        }



        if ($flag == 1) {
            var_dump($flag);
            $userAux = $this->userDAO->getUser($id);
            $validate=1;
            $this->showAdminEditView($id,$userAux->getPassword(), $validate, $message);
        } else {

            $adminAux = new User();
            $adminAux->setUserId($id);
            $adminAux->setEmail($email);
            if($newPassword != null && $confirmPassword != null)
            {
                $encrypted_password=password_hash($newPassword,PASSWORD_DEFAULT);

                $adminAux->setPassword($encrypted_password);
            }
            else
            {
                $userAux = $this->userDAO->getUser($id);
                $adminAux->setPassword($userAux->getPassword());
            }

            $adminAux->setRol($userRol);

            try {

                $cant = $this->userDAO->update($adminAux);

                $this->showAdminListView("Administrator succesfullly edited");

            } catch (\Exception $ex) {

                echo $ex->getMessage();
            }
        }

    }


    public function validatePassword($password, $confirmPassword)
    {

        $validate = false;

        if(strcasecmp($password,$confirmPassword) == 0){

            $validate = true;
        }

        return $validate;

    }



    /**
     * Validate if the entered email is valid
     */
    public function validateEmail($email)
    {
        $validate = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validate = true;
        }
        return $validate;
    }


}