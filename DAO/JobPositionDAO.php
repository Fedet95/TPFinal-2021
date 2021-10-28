<?php

namespace DAO;

use Models\Career;
use Models\JobPosition;

class JobPositionDAO implements IJobPositionDAO
{
    private $connection;
    private $tableName = "jobPositions";
    private $tableName2 = "careers";

    function add(JobPosition $jobPosition)
    {

        try {
            $query = "INSERT INTO " . $this->tableName . "(jobPositionId, careerIdJob, descriptionJob) VALUES (:jobPositionId, :careerIdJob, :descriptionJob)";

            $parameters['jobPositionId'] = $jobPosition->getJobPositionId();
            $parameters['careerIdJob'] = $jobPosition->getCareer()->getCareerId();
            $parameters['descriptionJob'] = $jobPosition->getDescription();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    //CaeerIDJob
    //descriptionJob

    function getAll()
    {
        try {
            $query= "SELECT * FROM ".$this->tableName." s INNER JOIN ".$this->tableName2." c ON s.careerIdJob= c.careerId";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query, array());

            $mapedArray = null;

            if (!empty($result)) {

                $mapedArray = $this->mapear($result);
            }

            return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    function remove($jobPositionId)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE (jobPositionId = :jobPositionId)";

            $parameters["jobPositionId"] = $jobPositionId;

            $this->connection = Connection::GetInstance();

            return $count = $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    function update(JobPosition $jobPosition)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET jobPositionId = :jobPositionId, careerIdJob = :careerIdJob, descriptionJob = :descriptionJob WHERE (jobPositionId = :jobPositionId)";

            $parameters["jobPositionId"] = $jobPosition->getJobPositionId();
            $parameters["careerIdJob"] = $jobPosition->getCareer()->getCareerId();
            $parameters["descriptionJob"] = $jobPosition->getDescription();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function mapear($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($value) {

            $jobPosition = new JobPosition();

            $jobPosition->setJobPositionId($value["jobPositionId"]);

            $careerId = $value['careerIdJob'];
            $careerDescription=$value['description'];
            $career = new Career();
            $career->setCareerId($careerId);
            $career->setDescription($careerDescription);
            $jobPosition->setCareer($career);

            $jobPosition->setJobPositionId($value["jobPositionId"]);
            $jobPosition->setDescription($value["descriptionJob"]);

            return $jobPosition;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }


    /**
     * Update json student values with information from origin file (at student login)
     * @param $student
     */
    public function updateJobPositionFile($jobPosition =null, $jobPositionArray = null)
    {

        if($jobPosition!=null)
        {
            try
            {
                $searchedPosition=$this->getJobPosition($jobPosition->getJobPositionId());

                if($searchedPosition!=null)
                {
                    if($searchedPosition!=$jobPosition)
                    {
                        try{
                            $this->update($jobPosition);
                        }
                        catch(\PDOException $ex)
                        {
                            echo $ex->getMessage();
                        }
                    }
                }
                else
                {
                    try {
                        $this->add($jobPosition);
                    }
                    catch (\PDOException $ex)
                    {
                        echo $ex->getMessage();
                    }
                }
            }
            catch (\PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }
        else if($jobPositionArray!=null)
        {
            foreach ($jobPositionArray as $value)
            {
                try
                {
                    $searchedPosition=$this->getJobPosition($value->getJobPositionId());

                    if($searchedPosition!=null)
                    {
                        if($searchedPosition!=$value)
                        {
                            try{
                                $this->update($value);
                            }
                            catch(\PDOException $ex)
                            {
                                echo $ex->getMessage();
                            }
                        }
                    }
                    else
                    {
                        try {
                            $this->add($value);
                        }
                        catch (\PDOException $ex)
                        {
                            echo $ex->getMessage();
                        }
                    }
                }
                catch (\PDOException $ex)
                {
                    echo $ex->getMessage();
                }
            }
        }
    }

    /**
     * Returns max id from a Job Position
     * @return int
     */
    function getMaxId (){
        try
        {
            $query = "SELECT * FROM " . $this->tableName . " ORDER BY (jobPositionId) DESC LIMIT 0, 1";

            $this->connection = Connection::GetInstance();

            $result = $this->connection->Execute($query,array());
            return (int)($result[0][0])+1;

        }catch (\PDOException $ex){
            throw $ex;
        }

    }


    /**
     * Returns all values from Data base
     * @return array
     */
    public function getJobPosition($jobPositionId)
    {
        try
        {
            $query= "SELECT * FROM ".$this->tableName." s INNER JOIN ".$this->tableName2." c ON s.careerIdJob= c.careerId WHERE (s.jobPositionId= :jobPositionId)";

            $parameters['jobPositionId']=$jobPositionId;

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


}
