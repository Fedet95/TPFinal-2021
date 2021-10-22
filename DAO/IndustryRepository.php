<?php
namespace DAO;
use Models\Industry;

class IndustryRepository implements lIndustryRepository
{

    private $industryList = array();
    private $fileName;


    public function __construct()
    {
        $this->fileName = ROOT . "/Data/industry.json";
    }

    /**
     * Add a industry to a Json file
     * @param Industry $industry
     */
    function add(Industry $industry)
    {
        $this->RetrieveData();
        array_push($this->industryList, $industry);
        $this->SaveData();
    }

    /**
     * Get all industrys from Json file
     * @return array
     */
    function getAll()
    {
        $this->RetrieveData();
        return $this->industryList;
    }


    public function searchMaxId()
    {
        $this->retrieveData();

        $maxid=1;
        if(count($this->industryList)>1)
        {
            $maxid=$this->industryList[0]->getId();

            foreach ($this->industryList as $value)
            {
                if($value->getId()>$maxid)
                {
                    $maxid=$value->getId();
                }
            }
            $maxid++;
        }
        else
        {
            $maxid++;
        }

        return $maxid;
    }


    public function searchByName($type)
    {
        $this->retrieveData();
        $industry=null;

        foreach ($this->industryList as $value)
        {
            if(strcasecmp($value->getType(), $type)==0)
            {
                $industry=$value;
            }
        }

        return $industry;
    }




    /**
     * Remove a industry by ID from Json file
     * @param $id
     */
    function remove($id)
    {
        $this->retrieveData();

        $this->industryList=array_filter($this->industryList, function ($industry) use($id){
            return $industry->getId()!=$id; //si se cumple guarda el dato en this->industry

        });

        $this->saveData();
    }

    public function searchById($id)
    {
        $this->retrieveData();
        $industry=null;

        foreach ($this->industryList as $value)
        {
            if($value->getId()==$id)
            {
                $industry=$value;
            }
        }

        return $industry;
    }

    /**
     *Saves all industrys in a Json file
     */
    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->industryList as $industry) {
            $valuesArray["type"] = $industry->getType();
            $valuesArray["id"] = $industry->getId();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }


    /**
     *Retrieves all industrys from Json file to an array
     */
    private function RetrieveData()
    {
        $this->industryList = array();

        if (file_exists($this->fileName))
        {
            $jsonContent = file_get_contents($this->fileName);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {

                $industry = new Industry();
                $industry->setType($valuesArray["type"]);
                $industry->setId($valuesArray["id"]);

                array_push($this->industryList, $industry);
            }
        }
    }

}