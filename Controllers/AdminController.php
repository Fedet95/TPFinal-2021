<?php

namespace Controllers;

use DAO\AdministratorDAO;

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