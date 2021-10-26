<?php

namespace DAO;

use DAO\Connection;
use Models\Career;
use \Exception as Exception;


class CareerDAO implements lCareerDAO
{
    private $connection;
    private $tableName= "careers";

    function add(Career $career)
    {
        try
        {
            $query= "INSERT INTO ".$this->tableName."(careerId, description) VALUES (:careerId, :description)";

            $parameters["careerId"] =  $career->getCareerId();
            $parameters["description"] = $career->getDescription();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


    function getAll()
    {
        $careerList = array ();
        try
        {
            $query= "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, array());

        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }

        $mapedArray=null;
        if(!empty($resultSet))
        {
            $mapedArray= $this->mapear($resultSet);
        }
        return $mapedArray; //si todo esta ok devuelve el array mapeado, y sino NULL
    }


    function remove($id)
    {
        // TODO: Implement remove() method.
    }



    function update(Career $career)
    {
        try
        {
            $query= "UPDATE ".$this->tableName." SET description = :description WHERE (careerId = :careerId)";

            //"UPDATE ".$this->tableName." SET content = '$udcontent', title = '$udtitle' WHERE id = $id");

            $parameters["careerId"] =  $career->getCareerId();
            $parameters["description"] = $career->getDescription();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }



    public function mapear ($array)
    {
        $array = is_array($array) ? $array : []; //si lo que viene como parametro es un array lo deja como viene, sino lo guarda como array vacio

        $resultado = array_map(function ($dato){

            $career= new Career();
            $career->setCareerId($dato['careerId']);
            $career->setDescription($dato['description']);

            return $career;

        }, $array);

        return count($resultado) > 1 ? $resultado : $resultado['0']; //devuelve un array si es mas de 1 dato, O un objeto si es 1 solo dato y sino NULL

    }


    /**
     * Add/update careers data base from origin
     */
    public function getCareersOrigin($careers)
    {

        $careerDao= new CareerDAO();

        $allCareesDAO= $careerDao->getAll(); //carreras base de dato

        if($allCareesDAO!=null)
        {
            foreach ($careers as $originValue)
            {
                $flag=0;
                foreach ($allCareesDAO as $DAOvalue)
                {
                    if($DAOvalue->getCareerId()==$originValue->getCareerId())
                    {
                        $flag=1;
                        if($DAOvalue!=$originValue)
                        {
                            $careerDao->update($originValue);
                        }
                    }
                }

                if($flag==0)
                {
                    $careerDao->add($originValue);
                }
            }
        }
        else
        {
            foreach ($careers as $value)
            {
                $careerDao->add($value);
            }
        }
    }





    /*
    function add(Career $career)
    {
        try
        {
            $query = "CALL Careers_Add (:careerId, :description, :active)";

            $parameters["careerId"] =  $career->getCareerId();
            $parameters["description"] = $career->getDescription();
            $parameters["active"] = $career->getActive();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }

    */


}