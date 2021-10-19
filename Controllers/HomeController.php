<?php
    namespace Controllers;
    use DAO\APIStudentDAO;

    class HomeController
    {
        public function Index($message = "")
        {
            //require_once(VIEWS_PATH."controlPanel.php");
            require_once(VIEWS_PATH . "home.php");
        }


    /**
     * * Send to student control panel view
     * @param string $message
     */
    public function showStudentControlPanelView($message = "")
    {
        require_once(VIEWS_PATH."checkLoggedStudent.php");
        require_once(VIEWS_PATH . "studentControlPanel.php"); //panel de control
    }

    /**
     * * Send to administrator control panel view
     * @param string $message
     */
    public function showAdministratorControlPanelView($message = "")
    {
        require_once(VIEWS_PATH."checkLoggedAdmin.php");
        require_once(VIEWS_PATH . "administratorControlPanel.php"); //panel de control
    }


    /**
     * Validate login, sending to the correspondent view
     * @param $email
     */
    public function login($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // invalid emailaddress
        {
            $message = 'Error, enter a valid email';
            $this->Index($message);
        } else
        {
            $searchedStudent = $this->searchStudentEmail($email); //busca email del student, retorna student o null
            $administrator= $this->searchAdministratorEmail($email); //busca email del administrador, retorna administrador o null

            if ($searchedStudent) //If is not NULL
            {
                $this->getApiCareers();
                $searchCareer= $this->searchCareer($searchedStudent->getCareer()->getCareerId());

                if($searchCareer)
                {
                    $searchedStudent->getCareer()->setDescription($searchCareer->getDescription());
                    $searchedStudent->getCareer()->setActive($searchCareer->getActive());

                    if ($searchedStudent->getActive()) //if is TRUE
                    {
                        $this->updateJsonStudent($searchedStudent);
                        $_SESSION['loggedstudent']=$searchedStudent;
                        $this->showStudentControlPanelView();
                    }
                    else
                    {
                        $this->updateJsonStudent($searchedStudent);
                        $message = 'Your account is not active, please get in contact with the university';
                        $this->Index($message);
                    }
                }
                else
                {
                    $message = 'Your career is not active, please get in contact with the university';
                    $this->Index($message);
                }

            }
            else if($administrator)//if is not null
            {

                 if($administrator->getActive())
                 {
                     $this->getApiCareers();
                     $this->updateAllJsonStudents($this->apiStudents);
                     $_SESSION['loggedadmin']=$administrator;
                     $this->showAdministratorControlPanelView();
                 }
                 else
                 {
                     $message = 'Your account is not active, please get in contact with the university';
                     $this->Index($message);
                 }
            }
            else //if is null
            {
                $message = 'Error, enter a valid email';
                $this->Index($message);

            }
        }
    }

        public function searchEmail($email)
        {
            $students = $this->getApiStudents();
            $searchedStudent=null;

        foreach ($students as $value) {
            if ($value->getEmail() == $email) {
                $searchedStudent = $value;
            }
        }
        return $searchedStudent;
    }

    /**
     * Get all the students from Api
     * @return mixed
     */
    public function getApiStudents()
    {
        $students = $this->api->start($this->api);
        return $students;
    }


    /**
     *Update all students from Api to Json
     * @return mixed
     */
    public function updateAllJsonStudents($studentsArray)
    {

        foreach($studentsArray as $key => $value)
        {
                $searchCareer= $this->searchCareer($value->getCareer()->getCareerId());
                $career= $value->getCareer();
                $career->setDescription($searchCareer->getDescription());
                $career->setActive($searchCareer->getActive());
                $value->setCareer($career);
                $studentsArray[$key]=$value;
        }

            $this->studentRepository->updateAllStudentFiles($studentsArray);
    }


    /**
     * Update a student from Api to Json
     * @return mixed
     */
    public function updateJsonStudent( $student)
    {
        $this->studentRepository->updateStudentFile($student);
    }


    /**
     * Search an administrator by email, returning the administrator or null
     * @param $email
     * @return mixed|null
     */
    public function searchAdministratorEmail($email)
   {
      $administrator= $this->administratorRepository->searchByEmail($email); //retorna el administrador o null
      return $administrator;
   }


    /**
     * Get all careers from Api
     */
    public function getApiCareers()
    {
        $careers = $this->apiC->start($this->apiC);
        $this->apiCareers=$careers; //save apiCareers
    }

    /**
     * Search the student career ID in api, returning the searched career or null
     * @param $careerId
     * @return mixed|null
     */
    public function searchCareer($careerId)
    {
        $searchedCareer = null;
        foreach ($this->apiCareers as $value) {
            if ($value->getCareerId() == $careerId) {
                $searchedCareer = $value;
            }
        }
        return $searchedCareer;
    }



    /**
     * Logout from system
     */
    public function Logout()
    {
        session_destroy();

        $this->Index();
    }

}

?>