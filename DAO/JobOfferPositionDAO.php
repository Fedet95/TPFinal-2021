<?php

namespace DAO;

use Models\JobOfferPosition;

class JobOfferPositionDAO implements IJobOfferPosition
{

    private $connection;
    private $tableName= "jobOffers_jobPositions";

    function add(JobOfferPosition $jobOfferPosition)
    {
        try
        {
            $query= "INSERT INTO ".$this->tableName."(jobPositionIdOp,jobOfferIdOp) VALUES (:jobPositionIdOp,:jobOfferIdOp)";

            $parameters['jobPositionIdOp']=$jobOfferPosition->getJobPositionId();
            $parameters['jobOfferIdOp']=$jobOfferPosition->getJoOfferId();

            $this->connection =Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters); //el executeNonquery no retorna array, sino la cantidad de datos modificados
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }

    function update(JobOfferPosition $jobOfferPosition)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET jobPositionIdOp = :jobPositionIdOp ,jobOfferIdOp = :jobOfferIdOp WHERE (jobOffers_jobPositions_id = :jobOffers_jobPositions_id)";

            $parameters["jobPositionIdOp"] = $jobOfferPosition->getJobPositionId();
            $parameters["jobOfferIdOp"] = $jobOfferPosition->getJoOfferId();
            $parameters["jobOffers_jobPositions_id"] = $jobPosition->getDescription();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    /**
     * Remove job offer position from Data base
     * @param $companyId
     */
    function remove($id)
    {
        try
        {
            $query = "DELETE FROM ".$this->tableName." WHERE (jobOfferIdOp = :jobOfferIdOp)";

            $parameters["jobOfferIdOp"] =  $id;

            $this->connection = Connection::GetInstance();

            return $count=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }




/*
    /**
     * Returns a job offer position from Data base
     * @return array

    public function getJobOfferPosition(JobOfferPosition $offerPosition)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." WHERE (jobPositionIdOp= :jobPositionIdOp) AND (jobOfferIdOp = :jobOfferIdOp)";

            $parameters['jobPositionIdOp']=$offerPosition->getJobPositionId();
            $parameters['jobOfferIdOp']=$offerPosition->getJoOfferId();


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
*/





    function getAll()
    {
        // TODO: Implement getAll() method.
    }



    public function mapear ($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($value){

            $jobOfferPosition = new JobOfferPosition();

            $jobOfferPosition->setJobOfferPositionId($value["jobOffers_jobPositions_id"]);
            $jobOfferPosition->setJobPositionId($value["jobPositionIdOp"]);
            $jobOfferPosition->setJoOfferId($value["jobOfferIdOp"]);

            return $jobOfferPosition;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }







}