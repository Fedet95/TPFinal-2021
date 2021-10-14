<?php

namespace Controllers;
require_once(VIEWS_PATH . "checkLoggedAdmin.php");

use DAO\CityRepository;
use DAO\CompanyRepository;
use DAO\CountryRepository;
use DAO\IndustryRepository;
use Models\City;
use Models\Company;
use Models\Industry;


class CompanyController
{
    private $companyRepository;
    private $countryRepository;
    private $cityRepository;
    private $industryRepository;
    private $loggedadmin;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
        $this->countryRepository = new CountryRepository();
        $this->cityRepository = new CityRepository();
        $this->industryRepository = new IndustryRepository();
        $this->loggedadmin = $this->loggedaminValidation();
    }


    /**
     * @param string $message
     */
    public function showCreateCompanyView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        $allIndustrys = $this->industryRepository->getAll();
        $allCountrys = $this->countryRepository->getAll();
        require_once(VIEWS_PATH . "createCompany.php");
    }

    /**
     * @param string $message
     */
    public function showCompanyManagement($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        $allCompanys = $this->companyRepository->getAll();
        require_once(VIEWS_PATH . "companyManagement.php");
    }


    /**
     * @param $name
     * @param $nacionality
     * @param $foundationDate
     * @param $cuit
     * @param $aboutUs
     * @param $companyLink
     * @param $email
     * @param $image
     * @param $active
     * @param $industry
     * @param $city
     * @param $country
     */
    public function addCompany($name, $cuit, $companyLink, $nacionality, $email, $country, $city, $industry, $active, $foundationDate, $aboutUs, $image)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allCompanys = $this->companyRepository->getAll();
        $newMaxId = $this->newId($allCompanys);

        $imagen = $this->image($image);
        if ($imagen == null) {
            $message = "Error, enter a valid image file";
            $this->showCreateCompanyView($message);
        }

        $validCuit = $this->validateCuit($cuit);
        if ($validCuit == false) {
            $message = "Error, enter a valid Cuit";
            $this->showCreateCompanyView($message);
        }

        $validLink = $this->validateLink($companyLink);
        if ($validLink == false) {
            $message = "Error, enter a valid URL link";
            $this->showCreateCompanyView($message);
        }

        $validEmail = $this->validateEmail($email);
        if ($validEmail == false) {
            $message = "Error, enter a valid email";
            $this->showCreateCompanyView($message);
        }

        $founDate = $this->validateFoundationDate($foundationDate);
        if ($founDate == false) {
            $message = "Error, enter a valid foundation date";
            $this->showCreateCompanyView($message);
        }


        $company = new Company();
        $company->setName($name);
        $company->setCompanyId($newMaxId); //generado con el metodo de nuevoID (solo para el json, con base auto_increment)
        $company->setNacionality($nacionality); //select con paises
        $company->setFoundationDate($foundationDate); //date
        $company->setCuit($cuit);
        $company->setAboutUs($aboutUs);
        $company->setCompanyLink($companyLink);
        $company->setEmail($email);
        $company->setLogo($imagen); //la que viene del metodo validado
        $company->setActive($active);
        $company->setIndustry($industry);
        $company->setCity($city);
        $company->setCountry($country); //name para json, (luego se guarda el id para base de datos)
        $company->setCreationAdminId($this->loggedadmin->getAdministratorId());

        $this->companyRepository->add($company);
        $this->newCity($city);
        $this->newIndustry($industry);

        $this->showCompanyManagement();

    }

    /**
     * Create a new company ID for Json file
     * @param $value
     * @return int|mixed
     */
    public function newId($value)//cuando se utilze base de datos se elimina este metodo ya que sera ID auto_increment
    {
        $maxId = 1;

        if (!empty($value)) //si no esta vacio(porque el json si esta vacio devuelve un array null)
        {
            $maxId = $value[0]->getCompanyId();

            foreach ($value as $company) {
                if ($company->getCompanyId() > $maxId) {
                    $maxId = $company->getCompanyId();
                }
            }

            $maxId++; //obtuve el maximo id actual, sumo 1, y sera el id del nuevo objeto
        }

        return $maxId;
    }


    public function validateCuit($cuit)
    {
        $valid = false;

        $numlength = strlen((string)$cuit);
        $num = (string)$cuit;

        if ($numlength != 11) {
            $valid = false;
        } else if (substr($num, 0, 1) != '3' || substr($num, 0, 2) != '30') {
            $valid = false;
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateLink($companyLink)
    {
        $validate = false;

        if (filter_var($companyLink, FILTER_VALIDATE_URL) !== false) {
            $validate = true;
        }

        return $validate;

    }

    public function loggedaminValidation()
    {
        $loggedadmin = null;
        if (isset($_SESSION['loggedadmin'])) {
            $loggedadmin = $_SESSION['loggedadmin'];
        }

        return $loggedadmin;
    }

    public function validateEmail($email)
    {
        $validate = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validate = true;
        }
        return $validate;
    }

    public function image()
    {
        $image = null;
        if (getimagesize($_FILES['image']['tmp_name']) == false)
        {
           $image=null;
        } else {
            $image = addslashes($_FILES['image']['tmp_name']);
            $image = file_get_contents($image);
            $image = base64_encode($image);
        }
        return $image;
    }

    public function validateFoundationDate($date)
    {
        $validate = false;
        if (strtotime($date) < time()) {
            $validate = true;
        }
        return $validate;
    }

    public function newCityId($value)//cuando se utilze base de datos se elimina este metodo ya que sera ID auto_increment
    {
        $maxId = 1;

        if (!empty($value)) {
            $maxId = $value[0]->getId();

            foreach ($value as $city) {
                if ($city->getId() > $maxId) {
                    $maxId = $city->getId();
                }
            }
            $maxId++; //obtuve el maximo id actual, sumo 1, y sera el id del nuevo objeto
        }
        return $maxId;
    }


    public function newCity($city)
    {
        $allCitys = $this->cityRepository->getAll();
        $newId = 0;
        $flag = 0;
        foreach ($allCitys as $citys) {
            if (strcasecmp($citys->getName(), $city) == 0) {
                $flag = 1;
            }
        }

        if ($flag == 0) {
            $newId = $this->newCityId($allCitys);
            $anotherCity = new City();
            $anotherCity->setName($city);
            $anotherCity->setId($newId);
            $this->cityRepository->add($anotherCity);
        }

    }

    public function newIndustryId($value)//cuando se utilze base de datos se elimina este metodo ya que sera ID auto_increment
    {
        $maxId = 1;

        if (!empty($value)) {
            $maxId = $value[0]->getId();

            foreach ($value as $industry) {
                if ($industry->getId() > $maxId) {
                    $maxId = $industry->getId();
                }
            }
            $maxId++; //obtuve el maximo id actual, sumo 1, y sera el id del nuevo objeto
        }
        return $maxId;
    }


    public function newIndustry($industry)
    {
        $allIndustrys = $this->industryRepository->getAll();
        $newId = 0;
        $flag = 0;
        foreach ($allIndustrys as $industrys) {
            if (strcasecmp($industrys->getType(), $industry) == 0) {
                $flag = 1;
            }
        }

        if ($flag == 0) {
            $newId = $this->newIndustryId($allIndustrys);
            $anotherIndustry = new Industry();
            $anotherIndustry->setType($industry);
            $anotherIndustry->setId($newId);
            $this->cityRepository->add($anotherIndustry);
        }

    }

    public function Remove($id)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $this->companyRepository->remove($id);

        $this->showCompanyManagement();
    }


}
