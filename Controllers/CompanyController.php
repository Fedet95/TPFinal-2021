<?php
namespace Controllers;
//require_once(VIEWS_PATH . "checkLoggedUser.php");
use DAO\UserRolDAO;
use Models\SessionHelper;
SessionHelper::checkUserSession();


use DAO\AppointmentDAO;
use DAO\CityDAO;
use DAO\CompanyDAO;
use DAO\CountryDAO;
use DAO\IndustryDAO;
use DAO\JobOfferDAO;
use DAO\LogoDAO;
use DAO\UserDAO;
use Models\City;
use Models\Company;
use Models\Country;
use Models\Industry;
use Models\Logo;
use Models\User;



class CompanyController
{
    private $companyDAO;
    private $countryDAO;
    private $cityDAO;
    private $industryDAO;
    private $logoDAO;
    private $userDAO;
    private $loggedUser;


    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->countryDAO = new CountryDAO();
        $this->cityDAO = new CityDAO();
        $this->industryDAO = new IndustryDAO();
        $this->logoDAO= new LogoDAO();
        $this->userDAO = new UserDAO();
        $this->loggedUser = $this->loggedUserValidation();
    }
 /**
     * Call the "createCompany" view
     * @param string $message
     */
    public function showCreateCompanyView($message = "")
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        try {
            $allIndustrys = $this->industryDAO->getAll();
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $allCountrys = $this->countryDAO->getAll();
        }
        catch (\Exception $ex)
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
        //require_once(VIEWS_PATH . "checkLoggedUser.php");
        SessionHelper::checkUserSession();

        try {
            $allCompanys = $this->companyDAO->getAll();

        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        $searchedCompany = $this->searchCompanyFiltre($allCompanys, $valueToSearch, $back);
        if($this->loggedUser->getRol()->getUserRolId()==1)
        {
            require_once(VIEWS_PATH . "companyManagement.php");
        }
        else if($this->loggedUser->getRol()->getUserRolId()==2)
        {
            if(is_object($allCompanys))
            { $company= $allCompanys;
                $allCompanys= array();
                array_push($allCompanys, $company);
            }

            require_once(VIEWS_PATH . "companyList.php");
        }
    }


    /**
     * Call the extend view of a company
     * @param $id
     */
    public function showCompanyViewMore($id)
    {
        //require_once(VIEWS_PATH . "checkLoggedUser.php");
        SessionHelper::checkUserSession();

        try {
            $company = $this->companyDAO->getCompany($id);
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        if($this->loggedUser->getRol()->getUserRolId()==1)
        {
            require_once(VIEWS_PATH . "companyViewMore.php");
        }
        else if($this->loggedUser->getRol()->getUserRolId()==2)
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
        //require_once(VIEWS_PATH . "checkLoggedUser.php");
        SessionHelper::checkUserSession();
        require_once(VIEWS_PATH . "editCompany.php");
    }



    /**
     * Add a new company to the system
     */
    public function addCompany($name, $cuit, $companyLink, $email, $country, $city, $industry, $active, $foundationDate, $aboutUs, $image)
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

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



        $uniqueEmail= $this->uniqueEmail($email);
        if ($uniqueEmail == 1) {
            $message = "Error, the company with email " . $email . " is already in the system";
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

                $userCompany= new User();
                $rolDao= new UserRolDAO();
                try {
                    $rol= $rolDao->getRolIdByRolName("company");
                }
                catch (\Exception $ex)
                {
                    echo $ex->getMessage();
                }

                if($rol!=null)
                {
                    $userCompany->setRol($rol);
                    $userCompany->setEmail($email);
                    $userCompany->setActive($active);
                    $pass= $this->randomPassword();
                    $sub="UTN's Job Search Register"; ///Send email with Password before encrypt it
                    $text="Registration for company: ".$name." successfull. Username: " . $email . ". Password: " . $pass . ". You can change your password once you login";

                    $this->sendEmail($email,$sub,$text);
                    $this->sendEmail("juanpayetta@gmail.com",$sub,$text);

                    $message= "Company created succesfully. User data sent to email " . $email . ".";
                    $encrypted_password=password_hash($pass,PASSWORD_DEFAULT);
                    $userCompany->setPassword($encrypted_password);
                    $this->showCompanyManagement(null,null,$message);

                }

                try {
                    $this->companyDAO->add($company);
                    $this->userDAO->add($userCompany);


                }
                catch (\Exception $ex)
                {
                   echo $ex->getMessage();
                }
            }
    }


    /**
     * Send a mail from the system to the inserted email
     * @param $email
     * @param $sub
     * @param $text
     */
    public function sendEmail ($email, $sub, $text)
    {
        $to = $email;
        $subject = $sub;
        $message = $text;
        $headers = 'From: tpfinalutn2021@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        if (mail($to, $subject, $message, $headers))
            echo "Email sent";
        else
            echo "Email sending failed";
    }



    /**
     * Validate if an industry is already in the system
     * @param $industry
     * @param $company
     * @return mixed|null
     */
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
                    catch(\Exception $ex)
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
            catch(\Exception $ex)
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
            catch (\Exception $ex)
            {
                $company=null;
                echo $ex->getMessage();
            }
        }

        return $company;
    }


    /**
     * Validate if a country is already in the system
     * @param $country
     * @param $company
     * @return mixed|null
     */
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
                    catch(\Exception $ex)
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
            catch (\Exception $ex)
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
            catch (\Exception $ex)
            {
                $company=null;
                echo $ex->getMessage();
            }
        }

        return $company;
    }


    /**
     * Validate if a city is already in the system
     * @param $city
     * @param $company
     * @return mixed|null
     */
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
                catch(\Exception $ex)
                {
                    echo $ex->getMessage();
                    $company=null;
                }

            } else
            {
                $company->setCity($searchedCity);
            }
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
            $company=null;
        }

        return $company;
    }


    /**
     * Validate if an image is already is loaded correctly
     * @param $company
     * @return mixed|null
     */
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
                        catch (\Exception $ex)
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
                catch (\Exception $ex)
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


    /**
     * Validate if an administrator exist in the system
     * @param $company
     * @return mixed|null
     */
    public function validateAdmin($company)
    {
        try {
            $searchedAdmin = $this->userDAO->getUser($this->loggedUser->getUserId());
            if ($searchedAdmin!=null) {
                $company->setCreationAdmin($searchedAdmin);
            }
            else
            {
                $company=null;
            }
        }
        catch (\Exception $ex)
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
        else if(isset($_SESSION['loggedcompany'])) {
            $loggedUser = $_SESSION['loggedcompany'];
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


    /**
     * Validate if there is only one company with determinated cuit in the system
     * @param $cuit
     * @param null $id
     * @return int
     */
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
                    catch (\Exception $ex)
                    {
                        $flag=1;
                        echo $ex->getMessage();
                    }
                }
            }
        }
        catch (\Exception $ex)
        {
            $flag=1;
            echo $ex->getMessage();
        }

        return $flag;
    }


    /**
     * Validates if there is only one company with a determinated name in the system
     * @param $name
     * @param null $id
     * @return int
     */
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
                    catch (\Exception $ex)
                    {
                        $flag=1;
                        echo $ex->getMessage();
                    }
                }
            }
        }
        catch (\Exception $ex)
        {
            $flag=1;
            echo $ex->getMessage();
        }
        return $flag;
    }


    /**
     * Validates if there is only one company with a determinated email in the system
     * @param $email
     * @param null $id
     * @return int
     */
    public function uniqueEmail($email, $id=null)
    {
        $flag=0;
        try {
            $companyEmailSearch = $this->companyDAO->searchEmailValidation($email);
            if ($companyEmailSearch ==1) {
                $flag = 1;

                if($id!=null)
                {
                    try {
                        $companySearch= $this->companyDAO->getCompany($id);
                        if($companySearch!=null)
                        {
                            if($companySearch->getEmail()==$email)
                            {
                                $flag=0;
                            }
                        }
                    }
                    catch (\Exception $ex)
                    {
                        $flag=1;
                        echo $ex->getMessage();
                    }
                }
            }
        }
        catch (\Exception $ex)
        {
            $flag=1;
            echo $ex->getMessage();
        }
        return $flag;
    }






    /**
     * Remove a company from the system
     */
    public function Remove($id)
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        try {
            $offerDAO= new JobOfferDAO();
            $allOffers= $offerDAO->getAll();



            if($allOffers!=null)
            {

                $activeOffers= array();
                $inactiveOffers= array();

                if(is_object($allOffers))
                { $offer= $allOffers;
                    $allOffers= array();
                    array_push($allOffers, $offer);
                }

                foreach ($allOffers as $value)
                {

                    if($value->getCompany()->getCompanyId()==$id)
                    {
                        if($value->getActive()=='true' && strtotime($value->getEndDate()) >= strtotime(date("Y-m-d")))
                        {
                            array_push($activeOffers, $value);
                        }
                        else
                        {
                            array_push($inactiveOffers, $value);
                        }
                    }
                }

                try {

                    if (!empty($activeOffers)) {
                        $appointmentDAO = new AppointmentDAO();
                        $allAppointments = $appointmentDAO->getAll();
                        $searchedAppointments = array();

                        if(is_object($allAppointments))
                        { $appointment= $allAppointments;
                            $allAppointments= array();
                            array_push($allAppointments, $appointment);
                        }



                        $flag=0;
                        if ($allAppointments != null)
                        {
                            foreach ($allAppointments as $appointment)
                            {

                                foreach ($activeOffers as $offers)
                                {

                                    if (strcmp($appointment->getJobOffer()->getJobOfferId(),$offers->getJobOfferId()) ==0)
                                    {
                                        $flag=1; //no se elimina, se inactiva la empresa

                                    }
                                }
                            }

                            if($flag==0)
                            {

                                $company = $this->companyDAO->getCompany($id);
                                $userCompany = $this->userDAO->getUserByEmail($company->getEmail());
                                $this->userDAO->remove($userCompany->getUserId());

                                $this->companyDAO->remove($id);
                                $this->showCompanyManagement(null, null, "Company removed successfully");
                                //no tiene ninguna oferta de trabajo activa con postulaciones
                            }
                            else
                            {

                                try { //el user company ya no podra loguearse hasta tanto la company vuelva a estar activa
                                    $company= $this->companyDAO->getCompany($id);

                                    if($company->getActive()=='true')
                                    {
                                        $company->setActive("false");
                                        $message= "Company status changed to 'Inactive' due to existing active job offer with appointments. Remove after expiration date.";
                                    }
                                    else
                                    {
                                        $message= "Company current status is 'Inactive' due to existing active job offer with appointments and previous remove operation.";
                                    }

                                }catch (\Exception $ex)
                                {
                                    echo $ex->getMessage();
                                }



                                $this->companyDAO->update($company);
                                $this->showCompanyManagement(null, null, $message);

                            }
                        }
                        else
                        {
                            $company = $this->companyDAO->getCompany($id);
                            $userCompany = $this->userDAO->getUserByEmail($company->getEmail());
                            $this->userDAO->remove($userCompany->getUserId());

                            $this->companyDAO->remove($id);
                            $this->showCompanyManagement(null, null, "Company removed successfully");
                        }   //no hay postulaciones
                    }
                    else{

                        if(!empty($inactiveOffers))
                        {
                            $company = $this->companyDAO->getCompany($id);
                            $userCompany = $this->userDAO->getUserByEmail($company->getEmail());
                            $this->userDAO->remove($userCompany->getUserId());

                            $this->companyDAO->remove($id);
                            $this->showCompanyManagement(null, null, "Company removed successfully");
                            //$message="Se elimina porque esta compañia no tiene ninguna oferta de trabajo";
                        }
                        else
                        {
                            $company = $this->companyDAO->getCompany($id);
                            $userCompany = $this->userDAO->getUserByEmail($company->getEmail());
                            $this->userDAO->remove($userCompany->getUserId());

                            $this->companyDAO->remove($id);
                            $this->showCompanyManagement(null, null, "Company removed successfully");
                            //$message="Se elimina porque esta compañia no tiene ninguna oferta de trabajo activa (tiene inactivas)";
                        }

                    }
                }catch (\Exception $ex)
                {
                    echo $ex->getMessage();
                }


            }
            else
            {
                $company = $this->companyDAO->getCompany($id);
                $userCompany = $this->userDAO->getUserByEmail($company->getEmail());
                $this->userDAO->remove($userCompany->getUserId());

                $this->companyDAO->remove($id);
                $this->showCompanyManagement(null, null, "Company removed successfully");
                //company with no job offers

            }
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }
    }


    /**
     * Edit information of a company from the system
     */
    public function Edit($id, $message=null)
    {
        SessionHelper::checkUserSession();
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {

            $allIndustrys = $this->industryDAO->getAll();
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $allCountrys = $this->countryDAO->getAll();
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $company = $this->companyDAO->getCompany($id);
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

         $this->showEditCompany($company, $allIndustrys, $allCountrys, $message);
    }


    /**
     * Edit information of a company from the system by a user company
     */
    public function editUserCompany()
    {
        SessionHelper::checkCompanySession();

        try {
            $allCompanies = $this->companyDAO->getAll();
        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        $id=null;
        if($allCompanies!=null)
        {
            foreach ($allCompanies as $company)
            {
                if($company->getEmail()==$this->loggedUser->getEmail())
                {
                  $id=$company->getCompanyId();
                }
            }
        }


        if($id!=null)
        {
            $this->Edit($id, null);
        }

        else
        {
            $message="There is an error verifying your account";
            $this->Index($message);
        }

    }


    /**
     * Update the information of a company from the system
     */
    public function UpdateCompany($name, $cuit, $companyLink, $email, $country, $city, $industry, $active, $foundationDate, $aboutUs, $id, $image)
    {
        SessionHelper::checkUserSession();
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");


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
                    catch (\Exception $ex)
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

        $uniqueEmail=$this->uniqueEmail($email, $id);
        if ($uniqueEmail == 1) {
            $message = "Error, the company with name " . $email . " is already in the system";
            $flag = 1;
            $this->Edit($id, $message);
        }



        //END EXTRA VALIDATION
        //UPDATE
        if ($flag == 0)
        {

            try {
                $searchedOriginalCompany= $this->companyDAO->getCompany($id);


                if($searchedOriginalCompany!=null)
                {
                    $originalEmail=null;
                    if($searchedOriginalCompany->getEmail()!=$email) //email ingresado en el update
                    {
                        $originalEmail=$searchedOriginalCompany->getEmail();

                    }
                }

            }
            catch (\Exception $ex)
            {
                echo $ex;
            }


            if($originalEmail!=null) //si ingreso un mail nuevo para la compañia, se actualiza el mail del user
            {

                $searchedUser= $this->userDAO->getUserByEmail($originalEmail); //busco el usuario con el email original

                if($searchedUser!=null)
                {

                    $searchedUser->setEmail($email);
                    try {
                        $cant=$this->userDAO->updateEmail($searchedUser); //PROBAR SI FUNCIONA
                        $_SESSION['loggedcompany'] = $searchedUser;

                        if($cant>0)
                        {
                            if($this->loggedUser->getRol()->getUserRolId()==1)
                            {
                                $sub="UTN's Job Search Email Change";
                                $text="Your username email was changed bye the administrator. New username email: ".$email.". Thank you.";
                                $this->sendEmail($originalEmail, $sub, $text);
                                $this->sendEmail("juanpayetta@gmail.com", $sub, $text);

                            }
                        }
                    }
                    catch (\Exception $ex)
                    {
                        echo $ex->getMessage();
                    }
                }

            }

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


                if($this->loggedUser->getRol()->getUserRolId()==1)
                {
                    $this->showCompanyManagement();
                }
                else if($this->loggedUser->getRol()->getUserRolId()==3)
                {
                    $this->showCompanyControlPanelView($email,"Company information modify successfully");
                }

            }
            catch (\Exception $ex)
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
           if($allCompanys!=null)
           {
               if(is_object($allCompanys))
               { $company= $allCompanys;
                   $allCompanys= array();
                   array_push($allCompanys, $company);
               }

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


    /**
     * Returns a random default password for the new company user
     */
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }



}
