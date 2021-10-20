<?php
namespace Controllers;
require_once(VIEWS_PATH . "checkLoggedUser.php");

use DAO\CityRepository;
use DAO\CompanyRepository;
use DAO\CountryRepository;
use DAO\IndustryRepository;
use DAO\AdministratorRepository;
use DAO\StudentRepository;
use Models\City;
use Models\Company;
use Models\Country;
use Models\Industry;
use Models\Administrator;
use Models\Student;


class CompanyController
{
    private $companyRepository;
    private $countryRepository;
    private $cityRepository;
    private $industryRepository;
    private $adminRepository;
    private $studentRepository;
    private $loggedUser;
    private $loggedAdmin;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
        $this->countryRepository = new CountryRepository();
        $this->cityRepository = new CityRepository();
        $this->industryRepository = new IndustryRepository();
        $this->adminRepository = new AdministratorRepository();
        $this->studentRepository= new StudentRepository();
        $this->loggedUser = $this->loggedUserValidation();
        $this->loggedAdmin=$this->loggedAdminValidation();
    }


    /**
     * Call the "createCompany" view
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
     * Call the "companyManagement" view
     * @param string $message
     */
    public function showCompanyManagement($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");
        $allCompanys = $this->companyRepository->getAll();
        $searchedCompany = $this->searchCompanyFiltre($allCompanys);

        if($this->loggedUser instanceof Administrator)
        {
            require_once(VIEWS_PATH . "companyManagement.php");
        }
        else if($this->loggedUser instanceof Student)
        {
            require_once(VIEWS_PATH . "companyList.php");
        }
    }


    /**
     * Call the extend view of a company
     * @param string $message
     */
    public function showCompanyViewMore($id)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        $company = $this->companyRepository->getCompany($id);
        if($this->loggedUser instanceof Administrator)
        {
            require_once(VIEWS_PATH . "companyViewMore.php");
        }
        else if($this->loggedUser instanceof Student)
        {
            require_once(VIEWS_PATH."companyViewMoreStudent.php");
        }
    }


    /**
     * Call the "editCompany" view
     * @param string $message
     */
    public function showEditCompany($company, $allIndustrys, $allCountrys, $message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        require_once(VIEWS_PATH . "editCompany.php");
    }


    /**
     * Add a new company to the system
     * @param $name
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
    public function addCompany($name, $cuit, $companyLink, $email, $country, $city, $industry, $active, $foundationDate, $aboutUs, $image)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

            $company = new Company();

            //Paso los ID/Nombres al Objeto de cada uno y los agrego a Company


             $searchedCountryName=null;
             if(!is_numeric($country))
             {
                 $searchedCountry=$this->countryRepository->searchByName($country);
                 if($searchedCountry==null)
                 {
                     $maxIdCountry=$this->countryRepository->searchMaxId();
                     $countryObj= new Country();
                     $countryObj->setId($maxIdCountry);
                     $countryObj->setName($country);
                     $company->setCountry($countryObj);
                     $this->countryRepository->add($countryObj);
                 }
                 else
                 {
                     $company->setCountry($searchedCountry);
                 }
             }
             else
             {
                 $searchedCountry = $this->countryRepository->searchById($country);
                 if ($searchedCountry != null) {
                     $company->setCountry($searchedCountry);
                 }
             }



            $searchedCity = $this->cityRepository->searchByName($city);
            if ($searchedCity != null) {
                $company->setCity($searchedCity);
            } else {
                $company->setCity($this->newCity($city));
            }

            $searchedIndustry = $this->industryRepository->searchById($industry);
            if ($searchedIndustry != null) {
                $company->setIndustry($searchedIndustry);
            }

            $searchedAdmin = $this->adminRepository->searchById($this->loggedAdmin->getAdministratorId());
            if ($searchedAdmin != null) {
                $company->setCreationAdmin($searchedAdmin);
            }


            $allCompanys = $this->companyRepository->getAll();
            $newMaxId = $this->newId($allCompanys);

            $flag = 0;
            $imagen = $this->image($image);
            if ($imagen == null) {
                $message = "Error, enter a valid image file (jpg, jpeg, png)";
                $flag = 1;
                $this->showCreateCompanyView($message);
            }

            $validCuit = $this->validateCuit($cuit);
            if ($validCuit == false) {
                $message = "Error, enter a valid Cuit";
                $flag = 1;
                $this->showCreateCompanyView($message);
            }

            $validLink = $this->validateLink($companyLink);
            if ($validLink == false) {
                $message = "Error, enter a valid URL link";
                $flag = 1;
                $this->showCreateCompanyView($message);
            }

            $validEmail = $this->validateEmail($email);
            if ($validEmail == false) {
                $message = "Error, enter a valid email";
                $flag = 1;
                $this->showCreateCompanyView($message);
            }

            $founDate = $this->validateFoundationDate($foundationDate);
            if ($founDate == false) {
                $message = "Error, enter a valid foundation date";
                $flag = 1;
                $this->showCreateCompanyView($message);
            }

            if ($flag == 0) {
                //Seteo los atributos simples de Company
                $company->setName($name);
                $company->setCompanyId($newMaxId);//generado con el metodo de nuevoID (solo para el json, con base auto_increment)
                $company->setFoundationDate($foundationDate); //date
                $company->setCuit($cuit);
                $company->setAboutUs($aboutUs);
                $company->setCompanyLink($companyLink);
                $company->setEmail($email);
                $company->setLogo($imagen); //la que viene del metodo validado
                $company->setActive($active);


                $companyCuitSearch = $this->companyRepository->searchCuit($cuit);
                if ($companyCuitSearch == null) {
                    $this->companyRepository->add($company);
                    $this->showCompanyManagement();
                } else {
                    $message = "Error, the company with Cuit " . $cuit . " is alredy in the system"; //unique cuit!
                    $this->showCreateCompanyView($message);
                }
            }
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


    /**
     * Validate if the entered cuit is valid
     * @return mixed|null
     */
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

    /**
     * Validate if the entered company url is valid
     * @return mixed|null
     */
    public function validateLink($companyLink)
    {
        $validate = false;

        if (filter_var($companyLink, FILTER_VALIDATE_URL) !== false) {
            $validate = true;
        }

        return $validate;

    }


    /**
     * Validate if the admin/stundent has logged in the system correctly
     * @return mixed|null
     */
    public function loggedUserValidation()
    {
        $loggedUser = null;

        if (isset($_SESSION['loggedadmin'])) {
            $loggedUser = $_SESSION['loggedadmin'];
        }
        else if(isset($_SESSION['loggedstudent'])) {
            $loggedUser = $_SESSION['loggedstudent'];
        }

        return  $loggedUser;
    }

    /**
     * Validate if the admin has logged in the system correctly
     * @return mixed|null
     */
    public function loggedAdminValidation()
    {
        $loggedAdmin = null;

        if (isset($_SESSION['loggedadmin'])) {
            $loggedAdmin = $_SESSION['loggedadmin'];
        }

        return  $loggedAdmin;
    }



    /**
     * Validate if the entered email is valid
     * @return mixed|null
     */
    public function validateEmail($email)
    {
        $validate = false;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validate = true;
        }
        return $validate;
    }

    /**
     * Validate if the entered email is valid
     * @return mixed|null
     */
    public function image()
    {
        $image = null;

        if(isset($_FILES['image']) && isset($_POST['button']))
        {
            if (file_exists($_FILES['image']['tmp_name']))
            {
                if (getimagesize($_FILES['image']['tmp_name']) == false) {
                    $image = null;
                } else {

                    $filename = $_FILES['image']['name'];
                    $fileExt = explode('.', $filename);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowedExt = array('jpg', 'jpeg', 'png');
                    if (in_array($fileActualExt, $allowedExt)) {
                        $image = addslashes($_FILES['image']['tmp_name']);
                        $image = file_get_contents($image);
                        $image = base64_encode($image);
                    }
                }
            }
        }
        return $image;
    }

    /**
     * Validate if the entered foundation date is valid
     * @return mixed|null
     */
    public function validateFoundationDate($date)
    {
        $validate = false;
        if (strtotime($date) < time()) {
            $validate = true;
        }
        return $validate;
    }

    /**
     * Generate a new city id
     */
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


    /**
     * Generate a new city instance
     */
    public function newCity($city)
    {
        $allCitys = $this->cityRepository->getAll();

        $newId = $this->newCityId($allCitys);
        $anotherCity = new City();
        $anotherCity->setName($city);
        $anotherCity->setId($newId);
        $this->cityRepository->add($anotherCity);


        return $anotherCity;
    }

    /**
     * Generate a new industry id
     */
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

    /**
     * Generate a new industry instance
     */
    public function newIndustry($industry)
    {
        $allIndustrys = $this->industryRepository->getAll();

        $newId = $this->newIndustryId($allIndustrys);
        $anotherIndustry = new Industry();
        $anotherIndustry->setType($industry);
        $anotherIndustry->setId($newId);
        $this->industryRepository->add($anotherIndustry);

        return $anotherIndustry;
    }

    /**
     * Remove a company from the system
     * @return mixed|null
     */
    public function Remove($id)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

            $this->companyRepository->remove($id);
            $this->showCompanyManagement();
    }


    /**
     * Edit information of a company from the system
     * @return mixed|null
     */
    public function Edit($id)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

         $allIndustrys = $this->industryRepository->getAll();
         $allCountrys = $this->countryRepository->getAll();

         $company = $this->companyRepository->getCompany($id);

         $this->showEditCompany($company, $allIndustrys, $allCountrys);
    }

    /**
     * Update the information of a company from the system
     * @return mixed|null
     */
    public function UpdateCompany($name, $cuit, $companyLink, $email, $country, $city, $industry, $active, $foundationDate, $aboutUs, $id, $image)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

            $allCountrys = $this->countryRepository->getAll();
            $allIndustrys = $this->industryRepository->getAll();

            $company = $this->companyRepository->getCompany($id);

            $searchedCountry = $this->countryRepository->searchById($country);
            if ($searchedCountry != null) {
                $company->setCountry($searchedCountry);
            }

            $searchedCity = $this->cityRepository->searchByName($city);
            if ($searchedCity != null) {
                $company->setCity($searchedCity);
            } else {
                $company->setCity($this->newCity($city));
            }

            $searchedIndustry = $this->industryRepository->searchById($industry);
            if ($searchedIndustry != null) {
                $company->setIndustry($searchedIndustry);
            }

            $searchedAdmin = $this->adminRepository->searchById($this->loggedUser->getAdministratorId());
            if ($searchedAdmin != null) {
                $company->setCreationAdmin($searchedAdmin);
            }


            $allCompanys = $this->companyRepository->getAll();
            $newMaxId = $this->newId($allCompanys);

            $flag = 0;
            $imagen = $this->image($image);
            if ($imagen == null) {
                $flag = 1;
                $message = "Error, enter a valid image file";
                $this->showCreateCompanyView($message);
            }

            $validCuit = $this->validateCuit($cuit);
            if ($validCuit == false) {
                $flag = 1;
                $message = "Error, enter a valid Cuit";
                $this->showCreateCompanyView($message);
            }

            $validLink = $this->validateLink($companyLink);
            if ($validLink == false) {
                $flag = 1;
                $message = "Error, enter a valid URL link";
                $this->showCreateCompanyView($message);
            }

            $validEmail = $this->validateEmail($email);
            if ($validEmail == false) {
                $flag = 1;
                $message = "Error, enter a valid email";
                $this->showCreateCompanyView($message);
            }

            $founDate = $this->validateFoundationDate($foundationDate);
            if ($founDate == false) {
                $flag = 1;
                $message = "Error, enter a valid foundation date";
                $this->showCreateCompanyView($message);
            }


        if ($flag == 0) {
            //Seteo los atributos simples de Company
            $company->setName($name);
            $company->setFoundationDate($foundationDate); //date
            $company->setCuit($cuit);
            $company->setAboutUs($aboutUs);
            $company->setCompanyLink($companyLink);
            $company->setEmail($email);
            $company->setLogo($imagen); //la que viene del metodo validado
            $company->setActive($active);


            $this->companyRepository->update($company);

            /*$this->newCity($city); CORROBORAR CITYS PARA CREAR NUEVAS
            $this->newIndustry($industry); CORROBORAR INDUSTRYS PARA CREAR NUEVAS*/

            $this->showCompanyManagement();
        }

    }



    /**
     * Returns a searched company or all companies otherwise
     * @param $allCompanys
     * @return array|mixed
     */
    public function searchCompanyFiltre($allCompanys)
    {
        $searchedCompany = array();
        if (isset($_POST['search'])) //click boton de filtrado
        {
            if (isset($_POST['valueToSearch'])) {
                $valueToSearch = $_POST['valueToSearch']; //nombre de la empresa a buscar

                foreach ($allCompanys as $value) {
                    if (strcasecmp($value->getName(), $valueToSearch) == 0) //no es case sensitive
                    {
                        array_push($searchedCompany, $value);
                    }
                }
            } else {
                $searchedCompany = $allCompanys;
            }
        } else {
            $searchedCompany = $allCompanys;
        }
        return $searchedCompany;
    }


}
