<?php
namespace DAO;
use Models\Company;


class CompanyRepository implements lCompanyRepository
{
    private $companytList = array();
    private $fileName;


    public function __construct()
    {
        $this->fileName = ROOT . "/Data/company.json";
    }

    /**
     * add a Company to Json file
     * @param Company $company
     */
    function add(Company $company)
    {
        $this->RetrieveData();

        array_push($this->companytList, $company);

        $this->SaveData();
    }

    /**
     * Get all companys from Json file
     * @return array
     */
    function getAll()
    {
        $this->RetrieveData();
        return $this->companytList;
    }

    /**
     * Remove company from Json file
     * @param $companyId
     */
    function remove($companyId)
    {
        $this->retrieveData();
        $i=0;

        foreach ($this->companytList as $value)
        {
            if($value->getCompanyId()==$companyId)
            {
                unset($this->companytList[$i]);
            }
            $i++;
        }
        $this->saveData();
    }

    /**
     * Get company from Json file
     * @param $companyId
     */

    function getCompany($companyId)
    {
        $this->RetrieveData();

        $company = null;
        foreach($this->companytList as $key => $value)
        {
            if($value->getCompanyId()==$companyId)
            {
                $company = $this->companytList[$key];
            }
        }
        return $company;
    }

    function searchCuit($cuit)
    {
        $this->RetrieveData();

        $company = null;
        foreach($this->companytList as $key => $value)
        {
            if($value->getCuit()==$cuit)
            {
                $company = $this->companytList[$key];
            }
        }
        return $company;
    }

    /**
     * Update company values
     * @param Company $company
     */
    function update(Company $company)
    {
        $this->RetrieveData();

        foreach ($this->companytList as $key => $value)
        {
            if($value->getCompanyId()==$company->getCompanyId())
            {
                $this->companytList[$key]=$company;
            }
        }
        $this->SaveData();

    }

    /**
     *Saves all companys in a Json file
     */
    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->companytList as $company) {
            $valuesArray["active"] = $company->getActive();
            $valuesArray["email"] = $company->getEmail();
            $valuesArray["name"] = $company->getName();
            $valuesArray["aboutUs"] = $company->getAboutUs();
            $valuesArray["city"] = $company->getCity();
            $valuesArray["companyId"] = $company->getCompanyId();
            $valuesArray["companyLink"] = $company->getCompanyLink();
            $valuesArray["country"] = $company->getCountry();
            $valuesArray["creationAdmin"] = $company->getCreationAdminId();
            $valuesArray["cuit"] = $company->getCuit();
            $valuesArray["foundationDate"] = $company->getFoundationDate();
            $valuesArray["industry"] = $company->getIndustry();
            $valuesArray["nacionality"] = $company->getNacionality();
            $valuesArray["logo"] = $company->getLogo();

            array_push($arrayToEncode, $valuesArray);
        }

        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $jsonContent);

    }

    /**
     *Retrieves all companys from Json file to an array
     */
    private function RetrieveData()
    {
        $this->companytList = array();

        if (file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $valuesArray) {
                $company = new Company();
                $company->setActive($valuesArray["active"]);
                $company->setEmail($valuesArray["email"]);
                $company->setName($valuesArray["name"]);
                $company->setAboutUs($valuesArray["aboutUs"]);
                $company->setCity($valuesArray["city"]);
                $company->setCompanyId($valuesArray["companyId"]);
                $company->setCompanyLink($valuesArray["companyLink"]);
                $company->setCountry($valuesArray["country"]);
                $company->setCreationAdminId($valuesArray["creationAdmin"]);
                $company->setCuit($valuesArray["cuit"]);
                $company->setFoundationDate($valuesArray["foundationDate"]);
                $company->setIndustry($valuesArray["industry"]);
                $company->setNacionality($valuesArray["nacionality"]);
                $company->setLogo($valuesArray["logo"]);

                array_push($this->companytList, $company);
            }
        }
    }


}