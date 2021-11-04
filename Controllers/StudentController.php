<?php

namespace Controllers;

use DAO\OriginStudentDAO;
use DAO\StudentDAO;


require_once(VIEWS_PATH . "checkLoggedUser.php");


class StudentController
{
    private $studentDAO;
    private $loggedUser;

    public function __construct()
    {
        $this->studentDAO = new StudentDAO();
        $this->loggedUser = $this->loggedUserValidation();
    }

    /**
     * * Send to student control panel view
     * @param string $message
     */
    public function showStudentControlPanelView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedStudent.php");
        require_once(VIEWS_PATH . "studentControlPanel.php");
    }


    public function showStudentListView($valueToSearch = null, $back = null, $message = "")
    {

        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {
            $allStudents = $this->studentDAO->getAll();
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }
        $searchedStudent = $this->searchStudentFiltreASD($allStudents, $valueToSearch, $back);
        require_once(VIEWS_PATH . "studentList.php");

    }

    public function showMoreStudentView($studentId)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $studentMore = null;
        $studentsOrigin = new OriginStudentDAO();

        $students = $studentsOrigin->start($studentsOrigin); //trae de la api


        if ($students != null) {
            foreach ($students as $value) {

                if ($value->getStudentId() == $studentId) {
                    $studentMore = $value;
                }
            }
        }

        require_once(VIEWS_PATH . "studentListViewMore.php");
    }


    public function searchStudentFiltreASD($allStudents, $valueToSearch)
    {
        $searchedStudent = array();

        if ($valueToSearch != null) {

            foreach ($allStudents as $value) {
                $dniValueReplace= str_replace("-", "", $value->getDni());
                if ($dniValueReplace== $valueToSearch) {
                    array_push($searchedStudent, $value);
                }
            }
        } else {
            $searchedStudent = $allStudents;
        }

        if ($valueToSearch == 'Show only registered') {
            $searchedStudent = $this->studentDAO->getOnlyRegistered();
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


}