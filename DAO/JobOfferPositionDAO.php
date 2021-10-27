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

    function getAll()
    {
        // TODO: Implement getAll() method.
    }



}