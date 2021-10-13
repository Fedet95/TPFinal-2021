<?php

namespace DAO;

use Models\Country;


class CountryRepository implements lCountryRepository
{
    private $countryList = array();
    private $fileName;


    public function __construct()
    {
        $this->fileName = ROOT . "/Data/countrys.json";
    }

    /**
     * Add a country to a Json file
     * @param Country $country
     */
    function add(Country $country)
    {
        $this->RetrieveData();
        array_push($this->countryList, $country);
        $this->SaveData();
    }

    /**
     * Get all the countrys from Json file
     * @return array
     */
    function getAll()
    {
        $this->RetrieveData();
        return $this->countryList;
    }

    /**
     * Remove a country by ID from Json file
     * @param $id
     */
    function remove($id)
    {
        $this->retrieveData();
        $i=0;

        foreach ($this->countryList as $value)
        {
            if($value->getId()==$id)
            {
                unset($this->countryList[$i]);
            }
            $i++;
        }
        $this->saveData();
    }

    /**
     *Saves all countrys in a Json file
     */
    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->countryList as $country) {
            $valuesArray["name"] = $country->getName();
            $valuesArray["id"] = $country->getId();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);

    }

    /**
     *Retrieves all countrys from Json file to an array
     */
    private function RetrieveData()
    {
        $this->countryList = array();

        if (file_exists($this->fileName))
        {
            $jsonContent = file_get_contents($this->fileName);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {
                $country = new Country();
                $country->setName($valuesArray["name"]);
                $country->setId($valuesArray["id"]);

                array_push($this->countryList, $country);
            }
        }
    }
}