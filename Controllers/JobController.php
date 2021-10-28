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
     *
     * FALTA HACER EL SHOW EDIT Y REMOVE DE JOB OFFERS!!!!!
     *
     */


    /**
     * Call the extend view of a JobOffer
     * @param $id
     */
    public function showJobOfferViewMore($id)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        try {
            $jobOffer = $this->jobOfferDAO->getJobOffer($id);
        }catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        require_once(VIEWS_PATH."jobOfferViewMore.php");
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
     * Call the "job offer management" view
     * @param string $message
     */
    public function showJobOfferManagementView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        $allCompanies = $this->companyDAO->getAll();
        //$allCountrys = $this->countryDAO->getAll();
        $allOffers= $this->jobOfferDAO->getAll();
        //$allOffers= $this->unifyAllOffer($offers);

        require_once(VIEWS_PATH . "jobOffersManagement.php");
    }


    /**
     * Call the "edi job offer" view
     * @param string $message
     */
    public function showEditJobOfferView($allCompanies, $allCareers, $jobOfferEdit, $allPositions=null, $message = "")
    {
        $edit=1;
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        require_once(VIEWS_PATH . "jobOffersManagement.php");
    }



//--------------------------------------------------------------------------------------------

    public function showJobPositionManagment($message = "",$jobPosition = null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        if($jobPosition == null)
        {
            $allPositions= $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
            $this->jobPositionDAO->updateJobPositionFile(null, $allPositions);
        }
        else
        {
            $this->jobPositionDAO->updateJobPositionFile($jobPosition);
        }

        $allPositions = $this->jobPositionDAO->getAll();

        require_once(VIEWS_PATH . "jobPositionManagment.php");
    }


    public function showCreateJobPositionView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allCareers = $this->careersOrigin->start($this->careersOrigin);


        require_once(VIEWS_PATH . "createJobPosition.php");

    }


    public function addJobPosition($careerId, $descriptionJob)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        $allJobPositions = $this->jobPositionDAO->getAll();
        $allCareers = $this->careersOrigin->start($this->careersOrigin);
        $flag = 0;

        if($careerId == null)
        {
            $this->showCreateJobPositionView("Please select a Career Reference");

        }else
        {
            if($descriptionJob == null)
            {
                $this->showCreateJobPositionView("Please write a Description Job");
            }
            else
            {
                foreach ($allCareers as $value)
                {
                    if($value->getCareerId() == $careerId)
                    {
                        if(strcasecmp($value->getDescription(),$descriptionJob) == 0)
                        {
                            $flag = 1;
                        }

                    }
                    if($flag == 1)
                    {
                        break;
                    }
                }
            }

        }
        if($flag == 1)
        {
            $this->showCreateJobPositionView("This Job Position already exist");

        } else
        {
            $newJobPosition = new JobPosition();
            $newJobPosition->setJobPositionId(($this->jobPositionDAO->getMaxId()));
            $newJobPosition->setDescription($descriptionJob);

            $careerAux = new Career(); ///Pasar objeto tipo carrera o solo id?
            $careerAux->setCareerId($careerId);
            $newJobPosition->setCareer($careerAux);

            $this->jobPositionDAO->add($newJobPosition);
            $this->showJobPositionManagment("Job Position succesfully created", $newJobPosition);
        }

    }


    //--------------------------------------------------------------------








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

        if($values=='')
        {
            $message = "Error, complete all fields";
            var_dump($postvalue['career']);
            $this->showCreateJobOfferView($message,$postvalue['career'], $postvalue );
        }


        $titleValidation = $this->validateUniqueTitle($title, $postvalue['company'] );
        if ($titleValidation == 1) {
            $message = "Error, the entered Job Offer Title is already in use by the offering company";
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

                $idOffer = $this->jobOfferDAO->add($newJobOffer); //add job offer to JobOffer DAO

                foreach ($newJobOffer->getJobPosition() as $value) {
                    $op = new JobOfferPosition();
                    $op->setJobPositionId($value->getJobPositionId());
                    $op->setJoOfferId($idOffer);
                    $this->jobOfferPositionDAO->add($op); //add job OfferxPosition to JobOfferPosition DAO (N:M table)
                }

                   $message= "Job Offer successfully added";
                    $this->showJobOfferManagementView("$message");

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


/*
     * Makes one jobOffer object with all their positions
     * @param $offer
     * @return mixed|null
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

*/


   public function editJobOffer($jobOfferId, $careerId=null)
   {
       require_once(VIEWS_PATH . "checkLoggedAdmin.php");

       $jobOffer= $this->jobOfferDAO->getJobOffer($jobOfferId);
       $allCompanies = $this->companyDAO->getAll();
       $allCareers= $this->careersOrigin->start($this->careersOrigin);
       $this->showEditJobOfferView($allCompanies, $allCareers, $jobOffer, null, null);
   }


    public function editJobOfferFirstPart($company, $career, $publishDate, $endDate, $jobOfferId)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        //var_dump($company);
        //var_dump($career);
        //var_dump($publishDate);
        //var_dump($endDate);
        //var_dump($jobOfferId);

        //HACER DESDE ACA!!!
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






        //$jobOffer= $this->jobOfferDAO->getJobOffer($jobOfferId);
        //$allCompanies = $this->companyDAO->getAll();
        //$allCareers= $this->careersOrigin->start($this->careersOrigin);
        //$message=null;


        /*
        if($careerId!=null)
        {
            $allPositions= $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
            try {

                $this->jobPositionDAO->updateJobPositionFile(null, $allPositions);

                try {
                    $allPositions= $this->jobPositionDAO->getAll();
                    $this->showEditJobOfferView($allCompanies, $allCareers, $jobOffer, $allPositions, $message);
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
        */


            //$this->showEditJobOfferView($allCompanies, $allCareers, $jobOffer, null, $message);

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
