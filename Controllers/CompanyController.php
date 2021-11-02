<?php
namespace Controllers;
require_once(VIEWS_PATH . "checkLoggedUser.php");

use DAO\AdministratorDAO;
use DAO\CityDAO;
use DAO\CompanyDAO;
use DAO\CountryDAO;
use DAO\IndustryDAO;
use DAO\LogoDAO;
use Models\City;
use Models\Company;
use Models\Country;
use Models\Industry;
use Models\Administrator;
use Models\Logo;
use Models\Student;


class CompanyController
{
    private $companyDAO;
    private $countryDAO;
    private $cityDAO;
    private $industryDAO;
    private $logoDAO;
    private $adminDAO;
    private $loggedUser;


    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->countryDAO = new CountryDAO();
        $this->cityDAO = new CityDAO();
        $this->industryDAO = new IndustryDAO();
        $this->logoDAO= new LogoDAO();
        $this->adminDAO = new AdministratorDAO();
        $this->loggedUser = $this->loggedUserValidation();
    }
 /**
     * Call the "createCompany" view
     * @param string $message
     */
    public function showCreateCompanyView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {
            $allIndustrys = $this->industryDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $allCountrys = $this->countryDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        require_once(VIEWS_PATH . "createCompany.php");
    }

    /**
     * Call the "companyManagement" view
     * @param string $message
     */
    public function showCompanyManagement($valueToSearch = null, $back =null, $message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        try {
            $allCompanys = $this->companyDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        $searchedCompany = $this->searchCompanyFiltre($allCompanys, $valueToSearch, $back);
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
     * @param $id
     */
    public function showCompanyViewMore($id)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        try {
            $company = $this->companyDAO->getCompany($id);
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

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
        require_once(VIEWS_PATH . "checkLoggedUser.php");
        require_once(VIEWS_PATH . "editCompany.php");
    }


    /**
     * Add a new company to the system
     */
    public function addCompany($name, $cuit, $companyLink, $email, $country, $city, $industry, $active, $foundationDate, $aboutUs, $image)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

            $company = new Company();
            $flag = 0;

            //COUNTRY
        $company=$this->validateCountry($country, $company);
        if($company==null)
        {
            $message = "Error, enter a valid Country";
            $flag = 1;
            $this->showCreateCompanyView($message);
        }

        if($flag==0)
        {
            //INDUSTRY
            $company=$this->validateIndustry($industry, $company);
            if($company==null)
            {
                $message = "Error, enter a valid Industry";
                $flag = 1;
                $this->showCreateCompanyView($message);
            }

            if($flag==0)
            {
                //CITY
                $company=$this->validateCity($city, $company);
                if($company==null)
                {
                    $message = "Error, enter a valid City";
                    $flag = 1;
                    $this->showCreateCompanyView($message);
                }
            }

            if($flag==0)
            {
                //IMAGE
                $company=$this->validateImage($company);
                if($company==null)
                {
                    $message = "Error, enter a valid Logo image (.pgn, .jpg, .jpeg)";
                    $flag = 1;
                    $this->showCreateCompanyView($message);
                }
            }

            if($flag==0)
            {
                //ADMINISTRATOR
                $company=$this->validateAdmin($company);
                if($company==null)
                {
                    $message = "Error, try again. If the problem still persist, logout and try again.";
                    $flag = 1;
                    $this->showCreateCompanyView($message);
                }
            }
        }


        //EXTRA VALIDATIONS
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


            //UNQUE CUIT
           $uniqueCuit= $this->uniqueCuit($cuit);
          if ($uniqueCuit == 1) {
            $message = "Error, the company with Cuit " . $cuit . " is already in the system";
            $flag = 1;
            $this->showCreateCompanyView($message);
          }


           //UNIQUE NAME
        $uniqueName= $this->uniqueName($name);
        if ($uniqueName == 1) {
            $message = "Error, the company with name " . $name . " is already in the system";
            $flag = 1;
            $this->showCreateCompanyView($message);
        }

        //END EXTRA VALIDATION
            //ADD
            if ($flag == 0)
            {
                $company->setName($name);
                $company->setFoundationDate($foundationDate);
                $company->setCuit($cuit);
                $company->setAboutUs($aboutUs);
                $company->setCompanyLink($companyLink);
                $company->setEmail($email);
                $company->setActive($active);

                try {
                    $this->companyDAO->add($company);
                    $this->showCompanyManagement();
                }
                catch (\PDOException $ex)
                {
                   echo $ex->getMessage();
                }

            }
    }



    public function validateIndustry($industry, $company)
    {
        if(!is_numeric($industry))
        {
            try {
                $searchedIndustry=$this->industryDAO->searchByName($industry);
                if($searchedIndustry==null)
                {
                    $industryObj= new Industry();
                    $industryObj->setType($industry);
                    try {
                        $industryId=$this->industryDAO->add($industryObj);
                        if($industryId!=null)
                        {
                            $industryObj->setId($industryId);
                            $company->setIndustry($industryObj);
                        }
                        else
                        {
                            $company=null;
                        }
                    }
                    catch(\PDOException $ex)
                    {
                        $company=null;
                        echo $ex->getMessage();
                    }
                }
                else
                {
                    $company->setIndustry($searchedIndustry);
                }
            }
            catch(\PDOException $ex)
            {
                $company=null;
                echo $ex->getMessage();
            }
        }
        else //industry (seleccion o error)
        {
            try {
                $searchedIndustry = $this->industryDAO->searchById($industry);
                if ($searchedIndustry != null) {
                    $company->setIndustry($searchedIndustry);
                }
                else
                {
                    $company=null;
                }
            }
            catch (\PDOException $ex)
            {
                $company=null;
                echo $ex->getMessage();
            }
        }

        return $company;
    }


    public function validateCountry($country, $company)
    {
        $searchedCountryName=null;
        if(!is_numeric($country)) //para countrys agregados (palabra)
        {
            try {
                $searchedCountry=$this->countryDAO->searchByName($country);
                if($searchedCountry==null)
                {
                    $countryObj= new Country();
                    $countryObj->setName($country);

                    try {
                        $countryId=$this->countryDAO->add($countryObj);
                        if($countryId!=null)
                        {
                            $countryObj->setId($countryId);
                            $company->setCountry($countryObj);
                        }
                        else
                        {
                            $company=null;
                        }
                    }
                    catch(\PDOException $ex)
                    {
                        $company=null;
                        echo $ex->getMessage();
                    }
                }
                else
                {
                    $company->setCountry($searchedCountry);
                }
            }
            catch (\PDOException $ex)
            {
                $company=null;
                echo $ex->getMessage();
            }
        }
        else //country numerico (seleccion o error)
        {
            try {
                $searchedCountry = $this->countryDAO->searchById($country);
                if ($searchedCountry != null) {
                    $company->setCountry($searchedCountry);
                }
                else
                {
                    $company=null;
                }
            }
            catch (\PDOException $ex)
            {
                $company=null;
                echo $ex->getMessage();
            }
        }

        return $company;
    }


    public function validateCity($city, $company)
    {
        try {
            $searchedCity = $this->cityDAO->searchByName($city);
            if ($searchedCity == null)
            {
                $cityObj= new City();
                $cityObj->setName($city);
                try {
                    $cityId= $this->cityDAO->add($cityObj);

                    if($cityId!=null)
                    {
                        $cityObj->setId($cityId);
                        $company->setCity($cityObj);
                    }
                    else
                    {
                        $company=null;
                    }
                }
                catch(\PDOException $ex)
                {
                    echo $ex->getMessage();
                    $company=null;
                }

            } else
            {
                $company->setCity($searchedCity);
            }
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
            $company=null;
        }

        return $company;
    }


    public function validateImage($company)
    {
        $statusMsg = '';
        // File upload path
        $targetDir = "uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        $flag=0;
        if(!empty($_FILES["image"]["name"])){
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg');
            if (!file_exists($targetFilePath)) { //image already exist in the folder
                if(in_array($fileType, $allowTypes)){
                    // Upload file to server
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){ //image doesn't exist in the folder, add it
                        // Insert image file name into database

                        $logo= new Logo();
                        $logo->setFile($fileName);
                        try {
                            $logoId= $this->logoDAO->add($logo);

                            if($logoId!=null)
                            {
                                $logo->setId($logoId);
                                $company->setLogo($logo);

                            }else{
                                /*$statusMsg = "File upload failed, please try again";*/
                                $flag=1;
                            }
                        }
                        catch (\PDOException $ex)
                        {
                            echo $ex->getMessage();
                            $flag=1;
                        }

                    }else{
                        /* $statusMsg = "Sorry, there was an error uploading your file";*/
                        $flag=1;
                    }
                }else{
                    /*$statusMsg = "Sorry, only JPG, JPEG, PNG files are allowed to upload.";*/
                    $flag=1;
                }
            }else {
                /* $statusMsg = "The file <b>".$fileName. "</b> is already exist";*/

                try {
                    $logo= $this->logoDAO->searchLogo($fileName);

                    if($logo!=null)
                    {
                        $company->setLogo($logo);
                    }
                    else
                    {
                        $flag=1;
                    }
                }
                catch (\PDOException $ex)
                {
                    echo $ex->getMessage();
                    $flag=1;
                }
            }
        }else{
            /*$statusMsg = 'Please select a file to upload';*/
            $flag=1;
        }
        // Display status message
        if($flag==1)
        {
            return null;
        }
        else
        {
            return $company;
        }
    }


    public function validateAdmin($company)
    {
        try {
            $searchedAdmin = $this->adminDAO->searchById($this->loggedUser->getAdministratorId());
            if ($searchedAdmin!=null) {
                $company->setCreationAdmin($searchedAdmin);
            }
            else
            {
                $company=null;
            }
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
            $company=null;
        }
        return $company;
    }


    /**
     * Validate if the entered cuit is valid
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
     * Validate if the admin/student has logged in the system correctly
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
     * Validate if the entered foundation date is valid
     */
    public function validateFoundationDate($date)
    {
        $validate = false;
        if (strtotime($date) < time()) {
            $validate = true;
        }
        return $validate;
    }

    public function uniqueCuit($cuit, $id=null)
    {
        $flag=0;
        try {
            $companyCuitSearch = $this->companyDAO->searchCuit($cuit);
            if ($companyCuitSearch==1)
            {
                $flag=1;

                if($id!=null)
                {
                    try {
                        $companySearch= $this->companyDAO->getCompany($id);
                        if($companySearch!=null)
                        {
                            if($companySearch->getCuit()==$cuit)
                            {
                                $flag=0;
                            }
                        }
                    }
                    catch (\PDOException $ex)
                    {
                        $flag=1;
                        echo $ex->getMessage();
                    }
                }
            }
        }
        catch (\PDOException $ex)
        {
            $flag=1;
            echo $ex->getMessage();
        }

        return $flag;
    }

    public function uniqueName($name, $id=null)
    {
        $flag=0;
        try {
            $companyNameSearch = $this->companyDAO->searchNameValidation($name);
            if ($companyNameSearch ==1) {
                $flag = 1;

                if($id!=null)
                {
                    try {
                        $companySearch= $this->companyDAO->getCompany($id);
                        if($companySearch!=null)
                        {
                            if($companySearch->getName()==$name)
                            {
                                $flag=0;
                            }
                        }
                    }
                    catch (\PDOException $ex)
                    {
                        $flag=1;
                        echo $ex->getMessage();
                    }
                }
            }
        }
        catch (\PDOException $ex)
        {
            $flag=1;
            echo $ex->getMessage();
        }
        return $flag;
    }


    /**
     * Remove a company from the system
     */
    public function Remove($id, $accept=null, $sub = null, $text=null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {
            $company= $this->companyDAO->getCompany($id);
            $this->companyDAO->remove($id);
            $this->showCompanyManagement();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }


        if($accept==null)
        {
            try
            {

                $company= $this->companyDAO->getCompany($id);

                $searchedOffer= $this->jobOfferDAO->getJobOffer($id);

                if($searchedOffer!=null)
                {
                    $appointments=$this->getAppointmentArray($id);

                    if(!empty($appointments)) //ESTO TIENE QUE SER ! (NEGATIVO) ESTA ASI PARA VER LA PANTALLA <<---
                    {
                        $cant=count($appointments);

                        try {
                            $company= $this->companyDAO->getCompany($searchedOffer->getCompany()->getCompanyId());
                        }
                        catch (\PDOException $ex)
                        {
                            echo $ex->getMessage();
                        }

                        $this->showRemoveJobOfferView($searchedOffer, $cant, $company);
                    }
                    else
                    {
                        $count=$this->jobOfferDAO->remove($id); //VER SI SE ELIMINA EN CASCADA
                        if($count>0)
                        {
                            $finalMessage="The job offer had no applications and was successfully eliminated";
                            $this->showRemoveJobOfferView($searchedOffer, null, null, null, $finalMessage );
                        }
                        else
                        {
                            $finalMessage="Job offer cannot be removed please try again";
                            $this->showRemoveJobOfferView($searchedOffer, null, null, null, $finalMessage );
                        }

                    }
                }
            }
            catch (\PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }










    }


    /**
     * Edit information of a company from the system
     */
    public function Edit($id, $message=null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {

            $allIndustrys = $this->industryDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $allCountrys = $this->countryDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $company = $this->companyDAO->getCompany($id);
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

         $this->showEditCompany($company, $allIndustrys, $allCountrys, $message);
    }



    /**
     * Update the information of a company from the system
     */
    public function UpdateCompany($name, $cuit, $companyLink, $email, $country, $city, $industry, $active, $foundationDate, $aboutUs, $id, $image)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");


        $company = new Company();
        $flag = 0;

        //COUNTRY
        $company=$this->validateCountry($country, $company);
        if($company==null)
        {
            $message = "Error, enter a valid Country";
            $flag = 1;
            $this->Edit($id, $message);
        }

        if($flag==0)
        {
            //INDUSTRY
            $company=$this->validateIndustry($industry, $company);
            if($company==null)
            {
                $message = "Error, enter a valid Industry";
                $flag = 1;
                $this->Edit($id, $message);
            }

            if($flag==0)
            {
                //CITY
                $company=$this->validateCity($city, $company);
                if($company==null)
                {
                    $message = "Error, enter a valid City";
                    $flag = 1;
                    $this->Edit($id, $message);
                }
            }

            if($flag==0)
            {
                //IMAGE
                if($image['name']=="")
                {
                    try {
                        $searchedCompanyLogo=$this->companyDAO->getCompany($id);
                        if($searchedCompanyLogo!=null)
                        {
                            $company->setLogo($searchedCompanyLogo->getLogo());
                        }
                    }
                    catch (\PDOException $ex)
                    {
                        echo $ex->getMessage();
                    }
                }
                else
                {
                    $company=$this->validateImage($company);
                    if($company==null)
                    {
                        $message = "Error, enter a valid Logo image (.pgn, .jpg, .jpeg)";
                        $flag = 1;
                        $this->Edit($id, $message);
                    }
                }
            }

            if($flag==0)
            {
                //ADMINISTRATOR
                $company=$this->validateAdmin($company);
                if($company==null)
                {
                    $message = "Error, try again. If the problem still persist, logout and try again.";
                    $flag = 1;
                    $this->Edit($id, $message);
                }
            }
        }


        //EXTRA VALIDATIONS
        $validCuit = $this->validateCuit($cuit);
        if ($validCuit == false) {
            $message = "Error, enter a valid Cuit";
            $flag = 1;
            $this->Edit($id, $message);
        }

        $validLink = $this->validateLink($companyLink);
        if ($validLink == false) {
            $message = "Error, enter a valid URL link";
            $flag = 1;
            $this->Edit($id, $message);
        }

        $validEmail = $this->validateEmail($email);
        if ($validEmail == false) {
            $message = "Error, enter a valid email";
            $flag = 1;
            $this->Edit($id, $message);
        }

        $founDate = $this->validateFoundationDate($foundationDate);
        if ($founDate == false) {
            $message = "Error, enter a valid foundation date";
            $flag = 1;
            $this->Edit($id, $message);
        }


        //UNQUE CUIT
        $uniqueCuit= $this->uniqueCuit($cuit, $id);
        if ($uniqueCuit == 1) {
            $message = "Error, the company with Cuit " . $cuit . " is already in the system";
            $flag = 1;
            $this->Edit($id, $message);
        }


        //UNIQUE NAME
        $uniqueName= $this->uniqueName($name, $id);
        if ($uniqueName == 1) {
            $message = "Error, the company with name " . $name . " is already in the system";
            $flag = 1;
            $this->Edit($id, $message);
        }

        //END EXTRA VALIDATION
        //UPDATE
        if ($flag == 0)
        {
            $company->setCompanyId($id);
            $company->setName($name);
            $company->setFoundationDate($foundationDate); //date
            $company->setCuit($cuit);
            $company->setAboutUs($aboutUs);
            $company->setCompanyLink($companyLink);
            $company->setEmail($email);
            $company->setActive($active);


            try {
                $count=$this->companyDAO->update($company);
                $this->showCompanyManagement();
            }
            catch (\PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }
    }



    /**
     * Returns a searched company or all companies otherwise
     * @param $allCompanys
     * @return array|mixed
     */
    public function searchCompanyFiltre($allCompanys, $valueToSearch)
    {
        $searchedCompany = array();

        if($valueToSearch!=null)
        {
            foreach ($allCompanys as $value)
            {
                if (strcasecmp($value->getName(), $valueToSearch) == 0) //no es case sensitive
                {
                    array_push($searchedCompany, $value);
                }
            }
        }
        else
        {
            $searchedCompany = $allCompanys;
        }



        if($valueToSearch=='Show all companies' || $valueToSearch=='Back')
        {
            $searchedCompany = $allCompanys;
        }

        return $searchedCompany;
    }

}
