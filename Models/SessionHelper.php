<?php

namespace Models;

class SessionHelper
{

    static public function checkAdminSession()
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");
    }

    static public function checkStudentSession()
    {
        require_once(VIEWS_PATH . "checkLoggedStudent.php");

    }

    static public function checkCompanySession()
    {
        require_once(VIEWS_PATH . "checkLoggedCompany.php");

    }

    static public function checkUserSession()
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");
    }
}