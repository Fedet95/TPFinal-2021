<?php
namespace Controllers;
use DAO\CompanyDAO;
use DAO\StudentDAO;
use DAO\StudentRepository;
use Models\Administrator;

require_once(VIEWS_PATH . "checkLoggedUser.php");


class StudentController
{
    private $studentDAO;
    private $loggedUser;

    public function __construct()
    {
        $this->studentDAO= new StudentDAO();
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


    public function showStudentListView()
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allStudents= $this->studentDAO->getAll();
        $searchedStudent=$this->searchStudentFiltre($allStudents);
        require_once(VIEWS_PATH . "studentList.php");

    }

    public function showMoreStudentView($studentId)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $searchedStudent=$this->studentDAO->getStudent($studentId);
        require_once(VIEWS_PATH . "studentListViewMore.php");
    }


    /**
     * Returns a searched student or all students otherwise
     * @param $allStudents
     * @return array|mixed
     */
    public function searchStudentFiltre($allStudents)
    {
        $searchedStudents = array();
        if (isset($_POST['search'])) //click boton de filtrado
        {
            if (isset($_POST['valueToSearch'])) {
                $valueToSearch = $_POST['valueToSearch']; //dni buscado

                $dniReplace= str_replace("-", "", $valueToSearch);

                foreach ($allStudents as $value) {
                    $dniValueReplace= str_replace("-", "", $value->getDni());
                    if($dniValueReplace==$dniReplace)
                    {
                        array_push($searchedStudents, $value);
                    }
                }
            } else {
                $searchedStudents = $allStudents;
            }
        } else {
            $searchedStudents = $allStudents;
        }
        return $searchedStudents;
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
        }
        else if(isset($_SESSION['loggedstudent'])) {
            $loggedUser = $_SESSION['loggedstudent'];
        }

        return  $loggedUser;
    }




}