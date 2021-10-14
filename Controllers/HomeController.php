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
            else if($administrator)//if is not null
            {
                 if($administrator->getActive())
                 {
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

    public function updateAllJsonStudents($studentsArray)
    {
        $this->studentRepository->updateAllStudentFiles($studentsArray);
    }

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

    public function Logout()
    {
        session_destroy();

        $this->Index();
    }

}

?>