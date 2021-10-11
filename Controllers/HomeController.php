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

        public function login($email)
        {

            $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // invalid emailaddress
            }

            if (filter_var($emailB, FILTER_VALIDATE_EMAIL) === false ||
                $emailB != $email
            ) {
                echo "This email adress isn't valid!";
                exit(0);
            }


            //VALIDAR QUE EL EMAIL SEA VALIDO, Y QUE EL AULUMNO ESTE ACTIVE
            $students = $this->getApiStudents();

        }

        public function getApiStudents()
        {

            $api = new APIStudentDAO();
            $students = $api->start($api);
            return $students;
        }


        public function hola11()
        {
           echo "pablo probando git";
        }

        public function hola22()
        {
            echo "pablo probando git version 2 ";
        }

        public function hola33()
        {
            echo "pablo probando git version  holaaaaaa";

        }


    }






?>