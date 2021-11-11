<?php

namespace DAO;

use Models\Industry;

class IndustryDAO implements lIndustryDAO
{

    private $connection;
    private $tableName = "industries";


    /**
     * Add a industry to a Data base
     * @param Industry $industry
     */
    public function add(Industry $industry)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . "(type) VALUES (:type)";

            $parameters['type'] = $industry->getType();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados
            return $this->connection->lastId();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Get all industrys from Data base
     * @return array
     */
    function getAll()
    {
        try {
            $query = "SELECT * FROM " . $this->tableName;

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


    public function searchById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE (idIndustry= :idIndustry)";

            $parameters['idIndustry'] = $id;

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



    private function update($industry)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET type = :type, idIndustry = :idIndustry WHERE (idIndustry = :idIndustry)";


            $parameters['type'] = $industry->getType();
            $parameters['idIndustry'] = $industry->getId();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function searchByName($name)
    {
        try
        {
            $query = "SELECT * FROM " . $this->tableName . " WHERE (type= :type)";

            $parameters["type"] = $name;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,$parameters);

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray;
        }
        catch (\Exception $ex)
        {
            throw $ex;
        }

    }

    public function mapear($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($dato) {

            $industry = new Industry();
            $industry->setId($dato['idIndustry']);
            $industry->setType($dato['type']);

            return $industry;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL
    }
}