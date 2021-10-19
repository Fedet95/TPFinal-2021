<?php
namespace DAO;

use Models\Administrator;
use Models\Company;
use Models\City;
use Models\Country;
use Models\Industry;


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

            $cityArray = array();
            $cityArray["id"]=$company->getCity()->getId();
            $cityArray["name"]=$company->getCity()->getName();
            $valuesArray["city"] = $cityArray;

            $valuesArray["companyId"] = $company->getCompanyId();
            $valuesArray["companyLink"] = $company->getCompanyLink();

            $countryArray = array();
            $countryArray["id"] = $company->getCountry()->getId();
            $countryArray["name"] = $company->getCountry()->getName();
            $valuesArray["country"] = $countryArray;

            $adminArray = array();
            $adminArray["active"] = $company->getCreationAdmin()->getActive();
            $adminArray["firstName"] = $company->getCreationAdmin()->getFirstName();
            $adminArray["lastName"] = $company->getCreationAdmin()->getLastName();
            $adminArray["email"] = $company->getCreationAdmin()->getEmail();
            $adminArray["administratorId"] = $company->getCreationAdmin()->getAdministratorId();
            $adminArray["employeeNumber"] = $company->getCreationAdmin()->getEmployeeNumber();
            $valuesArray["creationAdmin"] = $adminArray;

            $valuesArray["cuit"] = $company->getCuit();
            $valuesArray["foundationDate"] = $company->getFoundationDate();

            $industryArray = array();
            $industryArray["id"] = $company->getIndustry()->getId();
            $industryArray["type"] = $company->getIndustry()->getType();
            $valuesArray["industry"] = $industryArray;

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

                $city = new City();
                $cityArray = (array) $valuesArray["city"];

                $idCity = $cityArray["id"];
                $nameCity = $cityArray["name"];

                $city->setId($idCity);
                $city->setName($nameCity);
                $company->setCity($city);

                $company->setCompanyId($valuesArray["companyId"]);
                $company->setCompanyLink($valuesArray["companyLink"]);

                $country = new Country();
                $countryArray = (array) $valuesArray["country"];

                $idCountry = $countryArray["id"];
                $nameCountry = $countryArray["name"];

                $country->setId($idCountry);
                $country->setName($nameCountry);
                $company->setCountry($country);

                $creationAdmin = new Administrator();
                $adminArray = (array) $valuesArray["creationAdmin"];

                $active = $adminArray["active"];
                $firstName = $adminArray["firstName"];
                $lastName = $adminArray["lastName"];
                $emailAdmin = $adminArray["email"];
                $administratorId = $adminArray["administratorId"];
                $employeeNumber = $adminArray["employeeNumber"];

                $creationAdmin->setActive($active);
                $creationAdmin->setFirstName($firstName);
                $creationAdmin->setLastName($lastName);
                $creationAdmin->setEmail($emailAdmin);
                $creationAdmin->setAdministratorId($administratorId);
                $creationAdmin->setEmployeeNumber($employeeNumber);
                $company->setCreationAdmin($creationAdmin);

                $company->setCuit($valuesArray["cuit"]);
                $company->setFoundationDate($valuesArray["foundationDate"]);

                $industry = new Industry();
                $industryArray = (array) $valuesArray["industry"];

                $idIndustry = $industryArray["id"];
                $type = $industryArray["type"];

                $industry->setId($idIndustry);
                $industry->setType($type);
                $company->setIndustry($industry);

                $company->setLogo($valuesArray["logo"]);

                array_push($this->companytList, $company);
            }
        }
    }


}