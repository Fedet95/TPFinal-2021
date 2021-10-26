<?php

namespace DAO;

use Models\Administrator;

class AdministratorDAO implements lAdministratorDAO
{
    private $connection;
    private $tableName = "administrators";


    /**
     * No hay metodo add ya que viene harcodeado desde la misma base de datos
     */


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


    private function update($value)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET activeAdmin = :activeAdmin, firstNameAdmin = :firstNameAdmin, lastNameAdmin = :lastNameAdmin, emailAdmin = :emailAdmin, administratorId = :administratorId, employeeNumber = :employeeNumber, passwordAdmin = :passwordAdmin
            WHERE (administratorId = :administratorId)";

            $parameters['activeAdmin'] = $value->getActive();
            $parameters['firstNameAdmin'] = $value->getFirstName();
            $parameters['lastNameAdmin'] = $value->getLastName();
            $parameters['emailAdmin'] = $value->getEmail();
            $parameters['administratorId'] = $value->getAdministratorId();
            $parameters['employeeNumber'] = $value->getEmployeeNumber();
            $parameters['passwordAdmin'] = $value->getPassword();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
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