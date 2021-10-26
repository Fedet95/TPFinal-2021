<?php
namespace DAO;

use Models\City;


class CityDAO implements lCityDAO
{
    private $connection;
    private $tableName= "cities";


    /**
     * Add a city to a DB
     * @param City $city
     */
    public function add(City $city)
    {
        try
        {
            $query= "INSERT INTO " . $this->tableName . "(nameCity) VALUES (:nameCity)";

            $parameters["nameCity"] = $city->getName();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters);
            return $this->connection->lastId();

        }catch (\PDOException $ex)
        {
            throw $ex;
        }
    }

    /**
     * Get all citys from DB
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



    public function searchByName($name) ///Se usa en add Company. Ver si necesitamos buscar por ID
    {

        try
        {
            $query = "SELECT * FROM " . $this->tableName . " WHERE (nameCity= :nameCity)";

            $parameters["nameCity"] = $name;

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


    /**
     *Retrieves all citys from Json file to an array
     */


    public function mapear ($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($value){

            $city = new City();

            $city->setId($value["idCity"]);
            $city->setName($value["nameCity"]);

            return $city;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }

}