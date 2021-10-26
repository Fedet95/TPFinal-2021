<?php

namespace DAO;

use Models\Logo;

class LogoDAO implements ILogoDao
{
    private $connection;
    private $tableName= "logos";

    function add(Logo $logo)
    {
        try
        {
            $query= "INSERT INTO ".$this->tableName."(nameLogo) VALUES (:nameLogo)";

            $parameters['nameLogo']=$logo->getFile();


            $this->connection =Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados
            return $this->connection->lastId();
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }

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

    function remove($logoId)
    {
        try
        {
            $query = "DELETE FROM ".$this->tableName." WHERE (idLogo = :idLogo)";

            $parameters["idLogo"] =  $logoId;

            $this->connection = Connection::GetInstance();

            return $count=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }

    }

    function update(Logo $logo)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET nameLogo = :nameLogo
            WHERE (idLogo = :idLogo)";

            $parameters['idLogo'] = $logo->getId();
            $parameters['nameLogo'] = $logo->getFile();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }

    }


    public function searchLogo($file)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." WHERE (nameLogo= :nameLogo)";

            $parameters['nameLogo']=$file;

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, $parameters);

            $mapedArray=null;
            if(!empty($result))
            {
                $mapedArray= $this->mapear($result); //lo mando a MAPEAR y lo retorno (ver video minuto 13:13 en adelante)
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
        }
        catch (\PDOException $ex)
        {
            throw $ex;
        }
    }


    public function mapear($array)
    {
        $array = is_array($array) ? $array : [];

        $resultado = array_map(function ($dato) {

            $logo = new Logo();
            $logo->setId($dato['idLogo']);
            $logo->setFile($dato['nameLogo']);
            return $logo;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0'];
    }

}