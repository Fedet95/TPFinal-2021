<?php
namespace Controllers;
require_once(VIEWS_PATH . "checkLoggedUser.php");
use DAO\JobOfferDAO;
use DAO\JobOfferPositionDAO;
use DAO\JobPositionDAO;
use DAO\OriginCareerDAO;
use DAO\CompanyDAO;
use DAO\CountryDAO;
use DAO\OriginJobPositionDAO;
use Models\Administrator;
use Models\Career;
use Models\Company;
use Models\JobOffer;
use Models\JobOfferPosition;
use Models\JobPosition;
use Models\Student;


/**
 *
 */
class JobController
{
    private $companyDAO;
    private $countryDAO;
    private $careersOrigin;
    private $jobPositionsOrigin;
    private $loggedUser;
    private $jobOfferDAO;
    private $jobOfferPositionDAO;
    private $jobPositionDAO;


    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->countryDAO = new CountryDAO();
        $this->careersOrigin= new OriginCareerDAO();
        $this->jobPositionsOrigin= new OriginJobPositionDAO();
        $this->loggedUser = $this->loggedUserValidation();
        $this->jobOfferDAO= new JobOfferDAO();
        $this->jobOfferPositionDAO= new JobOfferPositionDAO();
        $this->jobPositionDAO = new JobPositionDAO();

    }


    /**
     * Call the "createJobOffer" view
     * @param string $message
     */
    public function showCreateJobOfferView($message = "", $careerId= null, $values=null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allCompanies = $this->companyDAO->getAll();
        $allCountrys = $this->countryDAO->getAll();
        $allCareers= $this->careersOrigin->start($this->careersOrigin);

        if($careerId!=null)
        {
            $allPositions= $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
            try {

                $this->jobPositionDAO->updateJobPositionFile(null, $allPositions);

                try {
                    $allPositions= $this->jobPositionDAO->getAll();
                }
                catch (\PDOException $ex)
                {
                    echo $ex->getMessage();
                }
            }
            catch (\PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }

        require_once(VIEWS_PATH . "createJobOffer.php");
    }


    /**
     * Call the "createJobOffer" view
     * @param string $message
     */
    public function showJobOfferManagementView($message = "", $offer=null)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        //$allCompanies = $this->companyDAO->getAll();
        //$allCountrys = $this->countryDAO->getAll();

        require_once(VIEWS_PATH . "jobOffersManagement.php");
    }


    public function showJobPositionManagment($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allPositions= $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
        $this->jobPositionDAO->updateJobPositionFile(null, $allPositions);
        $allPositions = $this->jobPositionDAO->getAll();

        require_once(VIEWS_PATH . "jobPositionManagment.php");
    }

    public function showCreateJobPositionView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allCareers = $this->careersOrigin->start($this->careersOrigin);


        require_once(VIEWS_PATH . "createJobPosition.php");

    }




    /**
     * Start the new job offer creation, sending to the second part of the form
     */
    public function addJobOfferFirstPart($company, $career, $publishDate, $endDate)
    {
        $endDateValidation = $this->validateEndDate($endDate);
        if ($endDateValidation == null) {
            $message = "Error, enter a valid Job Offer End Date";
            $flag = 1;
            $this->showCreateJobOfferView($message);
        }
         else
        {
            $values= array("company"=>$company, "career"=>$career, "publishDate"=>$publishDate, "endDate"=>$endDate );
           $this->showCreateJobOfferView("", $career, $values);
        }
    }


    /**
     * End the new job offer, adding to data base
     */
    public function addJobOfferSecondPart($title, $position, $remote, $dedication, $description, $salary, $active, $values)
    {
        $postvalue = unserialize(base64_decode($values));

        $titleValidation = $this->validateUniqueTitle($title, $postvalue['company'] );
        if ($titleValidation == 1) {
            $message = "Error, the entered Job Offer Title is already in use by the offering company";
            //var_dump($postvalue['career']);
            $this->showCreateJobOfferView($message,$postvalue['career'], $postvalue );
        }
        else
        {
            $newJobOffer = new JobOffer();
            $newJobOffer->setDescription($description);
            $newJobOffer->setActive($active);
            $newJobOffer->setDedication($dedication);
            $newJobOffer->setEndDate($postvalue['endDate']);
            $newJobOffer->setPublishDate($postvalue['publishDate']);
            $newJobOffer->setRemote($remote);
            $newJobOffer->setSalary($salary);
            $newJobOffer->setTitle($title);

            $career = new Career();
            $career->setCareerId($postvalue['career']);
            $newJobOffer->setCareer($career);

            $company = new Company();
            $company->setCompanyId($postvalue['company']);
            $newJobOffer->setCompany($company);

            $admin = new Administrator();
            $admin->setAdministratorId($this->loggedUser->getAdministratorId());
            $newJobOffer->setCreationAdmin($admin);

            $positionsArray = array();
            foreach ($position as $value) {
                $newJobPosition = new JobPosition();
                $newJobPosition->setJobPositionId($value);
                array_push($positionsArray, $newJobPosition);
            }

            $newJobOffer->setJobPosition($positionsArray);

            try {

                $idOffer = $this->jobOfferDAO->add($newJobOffer);

                foreach ($newJobOffer->getJobPosition() as $value) {
                    $op = new JobOfferPosition();
                    $op->setJobPositionId($value->getJobPositionId());
                    $op->setJoOfferId($idOffer);
                    $this->jobOfferPositionDAO->add($op);
                }

                try {
                    $allOffers = $this->jobOfferDAO->getJobOffer($idOffer);
                    $offer=$this->unifyOffer($allOffers);
                    $this->showJobOfferManagementView("", $offer);
                    //var_dump($offer);
                }
                catch (\PDOException $ex)
                {
                    echo $ex->getMessage();
                }
            }
            catch (\PDOException $ex)
            {
                if ($ex->getCode() == 23000) //unique constraint
                {
                  $message = "Error, the entered Job Offer Title is already in use by the offering company";
                  $this->showCreateJobOfferView($message,$postvalue['career'], $values );

                }
                else
                {
                    $message = "Error, try again";
                    $this->showCreateJobOfferView($message,$postvalue['career'], $values );
                }
            }
        }



        //$this->showCreateJobOfferView("", $career);

    }

    /**
     * Validate if the entered job offer end date is valid
     */
    public function validateEndDate($date)
    {
        $validate =null;
        if (strtotime($date) >= time()) {
            $validate = 1;
        }
        return $validate;
    }

    /**
     * Validate if a job offer title is available for a company
     * @param $title
     * @param null $id
     * @return int
     */
    public function validateUniqueTitle($title, $id)
    {
        $validate =null;
        try {
            $JobOfferTitleSearch = $this->jobOfferDAO->searchTitleValidation($title, $id);
            if ($JobOfferTitleSearch ==1) //wrong
            {
                $validate=1;
            }
        }
        catch (\PDOException $ex)
        {
            $validate=1;
            echo $ex->getMessage();
        }
        return $validate;
    }


    /**
     * Makes a jobOffer object with all their positions
     * @param $offer
     * @return mixed|null
     */
    public function unifyOffer($offer)
    {
        $positionArray=array();
        $finalOffer=null;
        if(is_array($offer))
        {
            $finalOffer=$offer[0];

            foreach ($offer as $values)
            {
                $pos= new JobPosition();
                $pos->setJobPositionId($values->getJobPosition()->getJobPositionId());
                $pos->setDescription($values->getJobPosition()->getDescription());
                $pos->setCareer($values->getJobPosition()->getCareer());
                array_push($positionArray, $pos);
            }
            $finalOffer->setJobPosition($positionArray);
        }
        else if(is_object($offer))
        {
            $finalOffer=$offer;
        }

        return $finalOffer;

    }


    public function addJobPosition($careerId, $descriptionJob)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        var_dump($careerId);
        var_dump($descriptionJob);
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





}
