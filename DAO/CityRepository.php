<?php
namespace DAO;

use Models\City;


class CityRepository implements lCityRepository
{
    private $cityList = array();
    private $fileName;

    public function __construct()
    {
        $this->fileName = ROOT . "/Data/citys.json";
    }


    /**
     * Add a city to a Json file
     * @param City $city
     */
    function add(City $city)
    {
        $this->RetrieveData();
        array_push($this->cityList, $city);
        $this->SaveData();
    }

    /**
     * Get all citys from Json file
     * @return array
     */
    function getAll()
    {
        $this->RetrieveData();
        return $this->cityList;
    }

    /**
     * Remove a city by ID from Json file
     * @param $id
     */
    function remove($id)
    {
        $this->retrieveData();

        $this->cityList=array_filter($this->cityList, function ($city) use($id){
            return $city->getId()!=$id; //si se cumple guarda el dato en this->cityList

        });
        $this->saveData();
    }

    /**
     *Saves all citys in a Json file
     */

    public function searchByName($name)
    {
        $this->retrieveData();
        $city=null;

        foreach ($this->cityList as $value)
        {
            if(strcasecmp($value->getName(),$name) == 0)
            {
                $city=$value;
            }
        }

        return $city;
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->cityList as $city)
        {
            $valuesArray["name"] = $city->getName();
            $valuesArray["id"] = $city->getId();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);

    }

    /**
     *Retrieves all citys from Json file to an array
     */
    private function RetrieveData()
    {
        $this->cityList = array();

        if (file_exists($this->fileName))
        {
            $jsonContent = file_get_contents($this->fileName);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {
                $city = new City();
                $city->setName($valuesArray["name"]);
                $city->setId($valuesArray["id"]);

                array_push($this->cityList, $city);
            }
        }
    }

}