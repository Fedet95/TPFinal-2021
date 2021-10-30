<?php

namespace Controllers;

use DAO\AdministratorDAO;
use Models\Administrator;

require_once(VIEWS_PATH . "checkLoggedUser.php");


class AdminController
{

    private $adminDAO;
    private $loggedUser;

    public function __construct()
    {
        $this->adminDAO = new AdministratorDAO();
        $this->loggedUser = $this->loggedUserValidation();
    }

    public function showAdminListView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allAdmins = $this->adminDAO->getAll();

        require_once(VIEWS_PATH . "adminListView.php");

    }

    public function showAdminCreateView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        require_once(VIEWS_PATH . "createAdmin.php");

    }

    public function addAdmin($firstName, $lastName, $employeeNumber, $email, $password, $active)
    {

        $allAdmins = $this->adminDAO->getAll();

        $flag = 0;


        if ($allAdmins != null) {
            foreach ($allAdmins as $value) {
                if (strcasecmp($value->getEmployeeNumber(), $employeeNumber) == 0) {
                    $flag = 1;
                    $message = "The employee number " . $employeeNumber . " is already registered";
                    break;
                } else if (strcasecmp($value->getEmail(), $email) == 0) {
                    $flag = 1;
                    $message = "The emaail " . $email . "is already registered";
                    break;
                }

            }
            if ($flag == 1) {
                $this->showAdminCreateView($message);
            } else {
                $adminAux = new Administrator();
                $adminAux->setFirstName($firstName);
                $adminAux->setLastName($lastName);
                $adminAux->setEmployeeNumber($employeeNumber);
                $adminAux->setEmail($email);
                $adminAux->setPassword($password);
                if($active=='true')
                {
                    $adminAux->setActive(1);
                }
                else
                {
                    $adminAux->setActive(0);
                }


                try {

                    $this->adminDAO->add($adminAux);
                    $this->showAdminListView("Admin succesfullly created");

                } catch (\PDOException $ex) {

                    echo $ex->getMessage();
                }
            }
        }
        else
        {
            $adminAux = new Administrator();
            $adminAux->setLastName($firstName);
            $adminAux->setLastName($lastName);
            $adminAux->setEmployeeNumber($employeeNumber);
            $adminAux->setEmail($email);
            $adminAux->setPassword($password);
            $adminAux->setActive($active);

            try {

                $this->adminDAO->add($adminAux);
                $this->showAdminListView("Admin succesfullly created");

            } catch (\PDOException $ex) {

                echo $ex->getMessage();
            }
        }

    }

    public function Remove($id)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {
            $this->adminDAO->remove($id);
            $this->showAdminListView();
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function loggedUserValidation()
    {
        $loggedUser = null;

        if (isset($_SESSION['loggedadmin'])) {
            $loggedUser = $_SESSION['loggedadmin'];
        } else {
            require_once VIEWS_PATH . "welcome.php";
        }

        return $loggedUser;
    }


}