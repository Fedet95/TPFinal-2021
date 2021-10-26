<?php

namespace DAO;

use Models\Country;


class CountryDAO implements lCountryDAO
{
    private $connection;
    private $tableName= "countries";


    /**
     * Add a country to a DAO
     * @param Country $country
     */
    function add(Country $country)
    {
        try
        {
            $query= "INSERT INTO " . $this->tableName . "(nameCountry) VALUES (:nameCountry)";

            $parameters["nameCountry"] = $country->getName();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters);
            return $this->connection->lastId();

        }catch (\PDOException $ex)
        {
            throw $ex;
        }
    }

    /**
     * Get all the countrys from DAO
     * @return array
     */
    function getAll()
    {
        try
        {
            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array());

            $mappedArray = null;
            if(!empty($result))
            {
                $mappedArray=$this->mapear($result);
            }

            return $mappedArray;

        }catch(\PDOException $ex)
        {
            throw $ex;
        }
    }

    /**
     * Remove a country by ID from Data base file
     * @param $id
     */
    public function searchById($id)
    {
        try
        {
            $query = "SELECT * FROM " . $this->tableName . " WHERE (idCountry= :idCountry)";

            $parameters["idCountry"] = $id;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,$parameters);

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray;
        }
        catch (\PDOException $ex)
        {
            throw $ex;
        }
    }

    public function searchByName($name)
    {
        try
        {
            $query = "SELECT * FROM " . $this->tableName . " WHERE (nameCountry= :nameCountry)";

            $parameters["nameCountry"] = $name;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,$parameters);

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray;
        }
        catch (\PDOException $ex)
        {
            throw $ex;
        }

    }

    public function mapear ($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($value){

            $country = new Country();

            $country->setId($value["idCountry"]);
            $country->setName($value["nameCountry"]);

            return $country;


        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }


}

