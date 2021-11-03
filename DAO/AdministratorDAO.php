<?php

namespace DAO;

use Models\Administrator;

class AdministratorDAO implements lAdministratorDAO
{
    private $connection;
    private $tableName = "administrators";


    /**
     * add a Company to Data base
     * @param Administrator $admin
     */


    function add(Administrator $administrator)
    {

        try {

            $query = "INSERT INTO " . $this->tableName . "(firstNameAdmin, lastNameAdmin, employeeNumber, emailAdmin, passwordAdmin, activeAdmin) VALUES (:firstNameAdmin, :lastNameAdmin, :employeeNumber, :emailAdmin, :passwordAdmin, :activeAdmin)";

            $parameters['firstNameAdmin'] = $administrator->getFirstName();
            $parameters['lastNameAdmin'] = $administrator->getLastName();
            $parameters['employeeNumber'] = $administrator->getEmployeeNumber();
            $parameters['emailAdmin'] = $administrator->getEmail();
            $parameters['passwordAdmin'] = $administrator->getPassword();
            $parameters['activeAdmin'] = $administrator->getActive();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Get admin from Data base
     * @param $administratorId
     */

    function getAdmin($administratorId)
    {

        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE (administratorId= :administratorId)";

            $parameters['administratorId'] = $administratorId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result);
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Returns all values from data Base
     * @return array
     */
    function getAll()
    {
        $adminList = array();
        try {
            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, array());

        } catch (\PDOException $ex) {
            throw $ex;
        }

        $mapedArray = null;
        if (!empty($resultSet)) {
            $mapedArray = $this->mapear($resultSet);
        }
        return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL

    }

    /**
     * Update admin values
     * @param Administrator $admin
     */
    function update(Administrator $admin)
    {
        try {
            $query = "UPDATE " . $this->tableName. " SET firstNameAdmin= :firstNameAdmin, lastNameAdmin = :lastNameAdmin , employeeNumber = :employeeNumber, emailAdmin = :emailAdmin, passwordAdmin = :passwordAdmin, activeAdmin = :activeAdmin
            WHERE (administratorId = :administratorId)";

            $parameters['firstNameAdmin'] = $admin->getFirstName();
            $parameters['lastNameAdmin'] = $admin->getLastName();
            $parameters['employeeNumber'] = $admin->getEmployeeNumber();
            $parameters['emailAdmin'] = $admin->getEmail();
            $parameters['passwordAdmin'] = $admin->getPassword();
            $parameters['activeAdmin'] = $admin->getActive();
            $parameters['administratorId'] = $admin->getAdministratorId();

            $this->connection = Connection::GetInstance();

            return $count = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Remove admin from Data base
     * @param $administratorId
     */
    function remove($administratorId)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE (administratorId = :administratorId)";

            $parameters["administratorId"] = $administratorId;

            $this->connection = Connection::GetInstance();

            return $count = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    /**
     * Search an administrator by email, returning the administrator or null
     * @param $email
     * @return mixed|null
     */
    function searchByEmail($email)
    {

        try {

            $query = "SELECT * FROM " . $this->tableName . " WHERE (emailAdmin= :emailAdmin)";

            $parameters['emailAdmin'] = $email;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

        } catch (\PDOException $ex) {
            throw $ex;
        }

        $mapedArray = null;
        if (!empty($result)) {
            $mapedArray = $this->mapear($result);
        }

        return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
    }


    public function searchById($administratorId)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE (administratorId= :administratorId)";

            $parameters['administratorId'] = $administratorId;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

        } catch (\PDOException $ex) {
            throw $ex;
        }

        $mapedArray = null;
        if (!empty($result)) {
            $mapedArray = $this->mapear($result);
        }

        return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
    }


    public function mapear($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($dato) {

            $administrator = new Administrator();
            $administrator->setActive($dato['activeAdmin']);
            $administrator->setAdministratorId($dato['administratorId']);
            $administrator->setFirstName($dato['firstNameAdmin']);
            $administrator->setLastName($dato['lastNameAdmin']);
            $administrator->setEmail($dato['emailAdmin']);
            $administrator->setEmployeeNumber($dato['employeeNumber']);
            $administrator->setPassword($dato['passwordAdmin']);

            return $administrator;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }

}