<?php

namespace DAO;

use Models\Administrator;
use Models\Student;
use Models\User;
use Models\UserRol;


class UserDAO implements lUserDAO
{

    private $connection;
    private $tableName = "users";
    private $tableName2 = "usersRol";
    private $careers;
    private $students;

    /**
     * Add an student to the Data base
     * @param User $user
     */
    public function add(User $user)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . "(email, password, rolId) VALUES (:email, :password, :rolId)";


            $parameters['email'] = $user->getEmail();
            $parameters['password'] = $user->getPassword();
            $parameters['rolId'] = $user->getRol()->getUserRolId();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Search an student by id, and remove
     * @param $studentId
     */
    function remove($userId)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE (userId = :userId)";

            $parameters["userId"] = $userId;

            $this->connection = Connection::GetInstance();

            return $count = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Returns all values from Data base
     * @return array
     */
    function getAll()
    {

        try {
            $query = "SELECT * FROM " . $this->tableName . " u INNER JOIN " . $this->tableName2 . " r ON u.rolId = r.userRolId";
            //hacemos el inner join solo para traer el "rol name"


            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Returns all values from a determinared rol id
     */
    function getRol($rolId) //Bring every user from 1 rol (student OR admin)
    {

        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE rolId = :rolId ";

            $parameters["rolId"] = $rolId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Returns all values from Data base
     * @return array
     */
    public function getUser($userId)
    {
        try {
            //ANTES TRAIAMOS LAS CAREERS DE LA BASE, AHORA HAY QUE TRAER DE LA API!!!
            $query = "SELECT * FROM " . $this->tableName . " u INNER JOIN " . $this->tableName2 . " r ON u.rolId=r.userRolId  WHERE  (u.userId= :userId)";


            $parameters['userId'] = $userId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /*
    public function getOnlyRegistered()
    {

        try {
            $query = "SELECT * FROM " . $this->tableName . " s INNER JOIN " . $this->tableName2 . " c ON s.career= c.careerId WHERE (s.password IS NOT NULL)";

            //$query= "SELECT  b.beerType, b.code, b.name, bt.id FROM ".$this->secondTableName." b INNER JOIN ".$this->tableName." bt ON b.beerType = bt.id WHERE (bt.id = :id)";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
    */

    /**
     * Update a value in data base
     * @return array
     */
    function update(User $user)
    {

        try {

            $query = "UPDATE " . $this->tableName . " SET  email = :email, password = :password
            WHERE (userId = :userId)";

            $parameters["userId"] = $user->getUserId();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Search an user by email, returning the user or null
     * @param $email
     * @return mixed|null
     */
    function searchByEmail($email)
    {

        try {

            $query = "SELECT * FROM " . $this->tableName . " WHERE (email= :email)";

            $parameters['email'] = $email;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

        } catch (\Exception $ex) {
            throw $ex;
        }

        $mapedArray = null;
        if (!empty($result)) {
            $mapedArray = $this->mapear($result);
        }

        return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
    }


/*
    /**
     * Update json student values with information from origin file (at student login)
     * @param $student

    public function updateStudentFile($student = null, $studentsArray = null)
    {

        if ($student != null)
        {
            try {
                $searchedStudent = $this->getUser($student->getUserId(), $student->getRol()->getUserRolId());

                if ($searchedStudent != null) {
                    if ($searchedStudent != $student) {
                        try {
                            $this->update($student);
                        } catch (\Exception $ex) {
                            echo $ex->getMessage();
                        }
                    }
                }

            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }

        } else if ($studentsArray != null) {
            foreach ($studentsArray as $value) {
                try {
                    $searchedStudent = $this->getUser($student->getUserId(), $student->getRol()->getUserRolId());

                    if ($searchedStudent != null) {
                        if ($searchedStudent != $value) {
                            try {
                                $this->update($value);
                            } catch (\Exception $ex) {
                                echo $ex->getMessage();
                            }
                        }
                    }

                } catch (\Exception $ex) {
                    echo $ex->getMessage();
                }
            }
        }
    }
    */


    public function mapear($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($value) {

            $user = null;
            $rol = $value['rolId'];

            if ($rol == 2) //students
            {
                $student = new Student();
                $student->setEmail($value["email"]);
                $student->setPassword($value['password']);
                $student->setUserId($value['userId']);
                $userRol = new UserRol();
                $userRol->setUserRolId($rol);
                $student->setRol($userRol);

                $this->getOriginCareers();
                $this->getOriginStudents();

                $searchedStudent = null;
                foreach ($this->students as $values) //busco el estudiante en la api mediante el ID que me devuelve la base
                {
                    if ($values->getUserId() == $student->getUserId()) {
                        $searchedStudent = $values;
                    }
                }

                $searchedCareer = null;
                foreach ($this->careers as $careers)  //busco las carreras en la api, y busco la carrera que corresponde al id de carrera del estudiante
                {
                    if ($careers->getCareerId() == $searchedStudent->getCareer()->getCareerId()) {
                        $searchedCareer = $careers;
                    }
                }

                $student->setCareer($searchedCareer); //seteo la carrera al estudiante

                $student->setFirstName($searchedStudent->getFirstName());
                $student->setLastName($searchedStudent->getLastName());
                $student->setDni($searchedStudent->getDni());
                $student->setPhoneNumber($searchedStudent->getPhoneNumber());
                $student->setFileNumber($searchedStudent->getFileNumber());
                $student->setBirthDate($searchedStudent->getBirthDate());
                $user = $student;

            } else if ($rol == 1) //admin
            {
                $administrator = new User();
                $administrator->setUserId($value['userId']);
                $administrator->setEmail($value['email']);
                $administrator->setPassword($value['password']);
                $userRol = new UserRol();
                $userRol->setUserRolId($rol);
                $administrator->setRol($userRol);

                $user = $administrator;
            }


            return $user;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0'];

    }

    public function getOriginCareers()
    {
        if ($this->careers == null) {
            $careerOrigin = new OriginCareerDAO();
            $this->careers = $careerOrigin->start($careerOrigin);
        }
    }

    public function getOriginStudents()
    {
        if ($this->students == null) {
            $studentOrigin = new OriginStudentDAO();
            $this->students = $studentOrigin->start($studentOrigin);
        }
    }


}

