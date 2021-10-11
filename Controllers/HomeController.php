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

        public function showControlPanelView()
        {
            require_once (VIEWS_PATH.'controlPanel.php');
        }


        public function login($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // invalid emailaddress
            {
                $message='Error, enter a valid email';
               $this->Index($message);
            }
            else
            {
                $searchedStudent=$this->searchEmail($email);
                if($searchedStudent)
                {
                    if($searchedStudent->getActive()) //si es true
                    {
                        $this->showControlPanelView();
                    }
                    else
                    {
                        $message='Your account is not active, please get in contact with the university';
                        $this->Index($message);
                    }
                }
                else
                {
                    $message='Error, enter a valid email';
                    $this->Index($message);
                }
            }


            //VALIDAR QUE EL EMAIL SEA VALIDO, Y QUE EL AULUMNO ESTE ACTIVE
            //GUARDAR EN SESSION EL USUARIO
            $students = $this->getApiStudents();

        }

        public function searchEmail($email)
        {
            $students = $this->getApiStudents();
            $searchedStudent=null;

            foreach ($students as $value)
            {
                if($value->getEmail()==$email)
                {
                    $searchedStudent=$value;
                }
            }
            return $searchedStudent;
        }



        public function getApiStudents()
        {

            $api = new APIStudentDAO();
            $students = $api->start($api);
            return $students;
        }


    }






?>