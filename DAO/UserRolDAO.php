<?php

namespace DAO;

use Models\UserRol;

class UserRolDAO implements lUserRolDAO
{
    private $tableName= 'usersRol';

    function getRol($id)
    {
        try {

            $query = "SELECT * FROM " . $this->tableName . " WHERE userRolId = :userRolId";

            $parameters["userRolId"] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    function getAll()
    {
        try {
            $query ="SELECT * FROM " . $this->tableName;


            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    function getRolIdByRolName($rolName)
    {
        try {

            $query = "SELECT * FROM " . $this->tableName . " WHERE rolName= :rolName";

            $parameters["rolName"] = $rolName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray = null;
            if (!empty($result)) {
                $mapedArray = $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }



    public function mapear($array)
    {
        $array = is_array($array) ? $array : [];

        $resultado = array_map(function ($value) {

                $userRol = new UserRol();
                $userRol->setUserRolId($value["userRolId"]);
                $userRol->setRolName($value['rolName']);

            return $userRol;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0'];

    }

}