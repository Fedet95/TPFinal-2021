<?php
namespace Controllers;
use DAO\CompanyRepository;
require_once(VIEWS_PATH . "checkLoggedStudent.php");




class StudentController
{
    private $companyRepository;
    private $loggedStudent;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
        $this->loggedStudent = $this->loggedStudentValidation();
    }

    /**
     * * Send to student control panel view
     * @param string $message
     */
    public function showStudentControlPanelView($message = "")
    {
        require_once(VIEWS_PATH."checkLoggedStudent.php");
        require_once(VIEWS_PATH . "studentControlPanel.php");
    }

    /**
     * * Send to student company list panel view
     * @param string $message
     */
    public function showCompanyListView($message = "")
    {
        require_once(VIEWS_PATH."checkLoggedStudent.php");
        $allCompanys = $this->companyRepository->getAll();
        $searchedCompany=$this->searchFiltre($allCompanys);
        require_once(VIEWS_PATH . "companyList.php");
    }


    /**
     * Returns a searched company or all companies otherwise
     * @param $allCompanys
     * @return array|mixed
     */
    public function searchFiltre($allCompanys)
    {
        $searchedCompany= array();
        if(isset($_POST['search'])) //click boton de filtrado
        {
            if(isset($_POST['valueToSearch']))
            {
                $valueToSearch = $_POST['valueToSearch']; //nombre de la empresa a buscar

                foreach ($allCompanys as $value)
                {
                    if(strcasecmp($value->getName(), $valueToSearch)==0) //no es case sensitive
                    {
                        array_push($searchedCompany, $value);
                    }
                }
            }
            else
            {
                $searchedCompany=$allCompanys;
            }
        }
        else
        {
            $searchedCompany=$allCompanys;
        }
        return $searchedCompany;
    }



    /**
     * Validate if the student has logged in the system correctly
     * @return mixed|null
     */
    public function loggedStudentValidation()
    {
        $loggedstudent = null;
        if (isset($_SESSION['loggedstudent'])) {
            $loggedstudent = $_SESSION['loggedstudent'];
        }

        return $loggedstudent;
    }






}