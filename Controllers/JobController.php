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
use DAO\StudentDAO;
use Models\Administrator;
use Models\Appointment;
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
    private $allCareers;
    private $jobPositionsOrigin;
    private $loggedUser;
    private $jobOfferDAO;
    private $jobOfferPositionDAO;
    private $jobPositionDAO;


    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->countryDAO = new CountryDAO();
        $this->careersOrigin = new OriginCareerDAO();
        $this->jobPositionsOrigin = new OriginJobPositionDAO();
        $this->loggedUser = $this->loggedUserValidation();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobOfferPositionDAO = new JobOfferPositionDAO();
        $this->jobPositionDAO = new JobPositionDAO();
    }


    /**
     *
     * FALTA HACER EL SHOW EDIT Y REMOVE DE JOB OFFERS!!!!!
     *
     */




    /**
     * Call the "createJobOffer" view
     * @param string $message
     */
    public function showCreateJobOfferView($message = "", $careerId = null, $values = null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        try {
            $allCompanies = $this->companyDAO->getAll();
        }
        catch (\PDOException $ex)
        {
           echo  $ex->getMessage();
        }

        try {

            $allCountrys = $this->countryDAO->getAll();
        }
        catch (\PDOException $ex)
        {
           echo  $ex->getMessage();
        }

        try {
            if($this->allCareers==null)
            {
                $allCareers = $this->careersOrigin->start($this->careersOrigin);
            }
            else
            {
                $allCareers= $this->allCareers;
            }

        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }


        if ($careerId != null) {
            $allPositions = $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
            try {

                $this->jobPositionDAO->updateJobPositionFile(null, $allPositions);

                try {
                    $allPositions = $this->jobPositionDAO->getAll();
                } catch (\PDOException $ex) {
                    echo $ex->getMessage();
                }
            } catch (\PDOException $ex) {
                echo $ex->getMessage();
            }
        }

        require_once(VIEWS_PATH . "createJobOffer.php");
    }


    /**
     * Call the extend view of a JobOffer
     * @param $id
     */
    public function showJobOfferViewMore($id)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        try {
            $jobOffer = $this->jobOfferDAO->getJobOffer($id);

            try
            {
                $company= $this->companyDAO->getCompany($jobOffer->getCompany()->getCompanyId());
            }
            catch (\PDOException $ex)
            {
                echo $ex->getMessage();
            }

        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }

        require_once(VIEWS_PATH . "jobOfferViewMore.php");
    }



    /**
     * Call the "job offer management" view
     * @param string $message
     */
    public function showJobOfferManagementView($valueToSearch=null, $message = "",  $back=null)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        $edit=null;
        $remove=null;


        try
        {
            $allCompanies = $this->companyDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        try
        {
            $allOffers = $this->jobOfferDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        try
        {
            if($this->allCareers==null)
            {
                $allCareers = $this->careersOrigin->start($this->careersOrigin);
            }
            else
            {
                $allCareers= $this->allCareers;
            }
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }


        $allPositions = $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
        $this->jobPositionDAO->updateJobPositionFile(null, $allPositions);

        try {
            $allPositions = $this->jobPositionDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        if($valueToSearch!=null)
        {
            if(is_numeric($valueToSearch))
            {
                $searchedValue = $this->searchJobFiltre($allOffers, $valueToSearch, $back);
            }
            else
            {
                $searchedValue = $this->searchJobCareerFiltre($allOffers, $valueToSearch, $back);
            }

        }


        require_once(VIEWS_PATH . "jobOffersManagement.php");
    }


    /**
     * Call the "edi job offer" view
     */
    public function showEditJobOfferView($allCompanies, $allCareers, $jobOfferEdit, $allPositions = null, $message = "", $careerId = null, $values = null)
    {
        $edit = 1;
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        require_once(VIEWS_PATH . "jobOffersManagement.php");
    }



    /**
     * Call the "remove job offer" view
     */
    public function showRemoveJobOfferView($jobOffer, $cant=null, $company=null, $text=null, $finalMessage=null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        $edit=null;
        $remove=1;
        require_once(VIEWS_PATH . "jobOffersManagement.php");
    }



//--------------------------------------------------------------------------------------------

    public function showJobPositionManagement($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        $allPositions = $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
        $this->jobPositionDAO->updateJobPositionFile(null, $allPositions);


        try {
            $allPositions = $this->jobPositionDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        require_once(VIEWS_PATH . "jobPositionManagment.php");
    }


    public function showCreateJobPositionView($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        if($this->allCareers==null)
        {
            $allCareers = $this->careersOrigin->start($this->careersOrigin);
        }
        else
        {
            $allCareers= $this->allCareers;
        }


        require_once(VIEWS_PATH . "createJobPosition.php");

    }

    public function showJobPositionViewMore($careerDescription, $message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        $careerToShow = $careerDescription;
        $allPositions = $this->jobPositionDAO->getAll();

        require_once(VIEWS_PATH . "jobPositionViewMore.php");

    }


    public function addJobPosition($careerId, $descriptionJob)
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        if($this->allCareers==null)
        {
            $allCareers = $this->careersOrigin->start($this->careersOrigin);
        }
        else
        {
            $allCareers= $this->allCareers;
        }

        $flag = 0;

        if ($careerId == null) {
            $this->showCreateJobPositionView("Please select a Career Reference");

        } else {
            if ($descriptionJob == null) {
                $this->showCreateJobPositionView("Please write a Description Job");
            } else {
                foreach ($allCareers as $value) {
                    if ($value->getCareerId() == $careerId) {
                        if (strcasecmp($value->getDescription(), $descriptionJob) == 0) {
                            $flag = 1;
                        }

                    }
                    if ($flag == 1) {
                        break;
                    }
                }
            }

        }
        if ($flag == 1) {
            $this->showCreateJobPositionView("This Job Position already exist");

        } else {
            $newJobPosition = new JobPosition();
            $newJobPosition->setJobPositionId(($this->jobPositionDAO->getMaxId()));
            $newJobPosition->setDescription($descriptionJob);

            $careerAux = new Career(); ///Pasar objeto tipo carrera o solo id?
            $careerAux->setCareerId($careerId);
            $newJobPosition->setCareer($careerAux);

            try {
                $this->jobPositionDAO->add($newJobPosition);
            }
            catch (\PDOException $ex)
            {
               echo  $ex->getMessage();
            }

            $this->showJobPositionManagement("Job Position succesfully created");
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
        } else {
            $values = array("company" => $company, "career" => $career, "publishDate" => $publishDate, "endDate" => $endDate);
            $this->showCreateJobOfferView("", $career, $values);
        }
    }


    /**
     * End the new job offer, adding to data base
     */
    public function addJobOfferSecondPart($title, $position, $remote, $dedication, $description, $salary, $active, $values)
    {
        $postvalue = unserialize(base64_decode($values));

        if ($values == '') {
            $message = "Error, complete all fields";
            $this->showCreateJobOfferView($message, $postvalue['career'], $postvalue);
        }


        $titleValidation = $this->validateUniqueTitle($title, $postvalue['company']);
        if ($titleValidation == 1) {
            $message = "Error, the entered Job Offer Title is already in use by the offering company";
            $this->showCreateJobOfferView($message, $postvalue['career'], $postvalue);
        } else {
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

                $message = "Job Offer successfully added";
                $this->showJobOfferManagementView(null,"$message", 1);

            } catch (\PDOException $ex) {
                if ($ex->getCode() == 23000) //unique constraint
                {
                    $message = "Error, the entered Job Offer Title is already in use by the offering company";
                    $this->showCreateJobOfferView($message, $postvalue['career'], $values);

                } else {
                    $message = "Error, try again";
                    $this->showCreateJobOfferView($message, $postvalue['career'], $values);
                }
            }
        }
    }


    /**
     * Validate if the entered job offer end date is valid
     */
    public function validateEndDate($date)
    {
        $validate = null;
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
        $validate = null;
        try {
            $JobOfferTitleSearch = $this->jobOfferDAO->searchTitleValidation($title, $id);
            if ($JobOfferTitleSearch == 1) //wrong
            {
                $validate = 1;
            }
        } catch (\PDOException $ex) {
            $validate = 1;
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


    public function editJobOffer($jobOfferId, $careerId = null, $message = "", $values = null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");


        try {
            $jobOffer = $this->jobOfferDAO->getJobOffer($jobOfferId);
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }

        try {
            $allCompanies = $this->companyDAO->getAll();
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }

        try {

            if($this->allCareers==null)
            {
                $allCareers = $this->careersOrigin->start($this->careersOrigin);
            }
            else
            {
                $allCareers= $this->allCareers;
            }

        } catch (\PDOException $ex) {
            echo $ex->getMessage();
        }


        if ($values != null) {
            try {
                $allPositions = $this->jobPositionDAO->getAll();
            } catch (\PDOException $ex) {
                echo $ex->getMessage();
            }

            $this->showEditJobOfferView($allCompanies, $allCareers, $jobOffer, $allPositions, $message, $careerId, $values);
        } else {
            $this->showEditJobOfferView($allCompanies, $allCareers, $jobOffer, null, $message);
        }

    }


    /**
     * Start the update of a job offer, adding to data base
     */
    public function editJobOfferFirstPart($company, $career, $publishDate, $endDate, $jobOfferId)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");


        $endDateValidation = $this->validateEndDate($endDate);
        if ($endDateValidation == null) {
            $message = "Error, enter a valid Job Offer End Date";

            $this->editJobOffer($jobOfferId, null, $message);
        } else {
            $values = array("company" => $company, "career" => $career, "publishDate" => $publishDate, "endDate" => $endDate, "jobOfferId" => $jobOfferId);
            $this->editJobOffer($jobOfferId, $career, null, $values);
        }
    }


    /**
     * End the update of a job offer, adding to data base
     */
    public function editJobOfferSecondPart($title, $position, $remote, $dedication, $description, $salary, $active, $values)
    {
        $postvalue = unserialize(base64_decode($values));

        if ($values == '') {
            $message = "Error, complete all fields";
            $this->showEditJobOfferView($message, $postvalue['career'], $postvalue);
        }


        try {
            $allOffers= $this->jobOfferDAO->getAll();
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $searchedOffer= $this->jobOfferDAO->getJobOffer($postvalue['jobOfferId']);
        }
        catch (\PDOException $ex)
        {
            echo $ex->getMessage();
        }


        $flag=0;
       if(is_array($allOffers))
       {
           foreach ($allOffers as $value)
           {
               if($value->getTitle()==$title)
               {
                   $flag=1;
                   if($value->getCompany()->getCompanyId()==$searchedOffer->getCompany()->getCompanyId())
                   {
                       $flag=2; //mal
                       if($value->getJobOfferId()==$searchedOffer->getJobOfferId())
                       {
                           $flag=3; //bien
                       }
                   }
               }
           }
       }else
       {
           if($allOffers->getTitle()==$title)
           {
               if($allOffers->getCompany()->getCompanyId()==$searchedOffer->getCompany()->getCompanyId())
               {
                   $flag=1;
               }
           }
       }

        if($flag==1 || $flag==2)
        {
            $message = "Error, the entered Job Offer Title is already in use by the offering company";
            $this->editJobOffer($postvalue['jobOfferId'], $postvalue['career'], $message, $postvalue);
        }
        else {
            $newJobOffer = new JobOffer();
            $newJobOffer->setDescription($description);
            $newJobOffer->setActive($active);
            $newJobOffer->setDedication($dedication);
            $newJobOffer->setEndDate($postvalue['endDate']);
            $newJobOffer->setPublishDate($postvalue['publishDate']);
            $newJobOffer->setRemote($remote);
            $newJobOffer->setSalary($salary);
            $newJobOffer->setTitle($title);
            $newJobOffer->setJobOfferId($postvalue['jobOfferId']);

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


            //buscar todos los jobOfferPosition que tienen como id esta jobOffer y borrarlos, y agregar los nuevos
            $this->jobOfferPositionDAO->remove($postvalue['jobOfferId']);
            $newJobOffer->setJobPosition($positionsArray);


            try {

                $this->jobOfferDAO->update($newJobOffer); //update job offer to JobOffer DAO

                foreach ($newJobOffer->getJobPosition() as $value) {
                    $op = new JobOfferPosition();
                    $op->setJobPositionId($value->getJobPositionId());
                    $op->setJoOfferId($postvalue['jobOfferId']);
                    $this->jobOfferPositionDAO->add($op); //add job OfferxPosition to JobOfferPosition DAO (N:M table) //luego de eliminar los anteriores
                }

                $message = "Job Offer successfully updated";
                $this->showJobOfferManagementView(null, "$message", 2); //for message

            } catch (\PDOException $ex) {
                $message= "Error, try again";
                if ($ex->getCode() == 23000) //unique constraint
                {
                    $this->editJobOffer($postvalue['jobOfferId'], $postvalue['career'], $message, $values);

                } else {
                    $this->editJobOffer($postvalue['jobOfferId'], $postvalue['career'], $message, $values);
                }
            }

        }
    }



    public function removeJobOffer($id, $accept=null, $sub = null, $text=null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        if($accept==null)
        {
            try
            {
                $searchedOffer= $this->jobOfferDAO->getJobOffer($id);
                if($searchedOffer!=null)
                {
                    $app= new Appointment();
                    $appointments= $searchedOffer->getAppointment();
                    array_push($appointments, $app);
                    if(!empty($appointments)) //ESTO TIENE QUE SER ! (NEGATIVO) ESTA ASI PARA VER LA PANTALLA <<-------------------------------
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
                        $finalMessage="The job offer had no applications and was successfully eliminated";
                        $this->showRemoveJobOfferView($searchedOffer, null, null, null, $finalMessage );
                    }
                }
            }
            catch (\PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }
        else if($accept!=null && $text==null)
        {
            if($accept=="true")
            {
                $searchedOffer= $this->jobOfferDAO->getJobOffer($id);
                $this->showRemoveJobOfferView($searchedOffer, null, null, null, "Empty");
            }
            else
            {
                $this->showJobOfferManagementView(null, "Remove operation aborted", 3);
            }

        }
        else if($text!=null)
        {

            $searchedOffer= $this->jobOfferDAO->getJobOffer($id);
            $appointments= $searchedOffer->getAppointment();
            $count=$this->jobOfferDAO->remove($id); //VER SI SE ELIMINA EN CASCADA

            if($count>0)
            {

                $studentsId= array();
                foreach ($appointments as $value)
                {
                    array_push($studentsId,$value->getStudent()->getStudentId());
                }

                $allStudents= new StudentDAO();
                $allStudents->getAll();
                $studentsEmails= array();
                foreach ($allStudents as $student)
                {
                    foreach ($studentsId as $id)
                    {
                        if($student->getStudentId()==$id)
                        {
                            array_push($studentsEmails, $student->getEmail());
                            $this->sendEmail($student->getEmail(), $sub, $text);
                        }
                    }
                }
                $finalMessage="Job offer was successfully removed and applicants were notified";
                $this->showRemoveJobOfferView($searchedOffer, null, null, null, $finalMessage );

                //$this->sendEmail("juanpayetta@gmail.com", $sub, $text);
                //$this->sendEmail("pablopayetta@gmail.com", $sub, $text);
                //$this->sendEmail("ftacchini95@gmail.com", $sub, $text);

            }
            else
            {
                $finalMessage="Job offer cannot be removed please try again";
                $this->showRemoveJobOfferView($searchedOffer, null, null, null, $finalMessage );
            }

        }

    }


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
     * Returns a searched job offer by position or all offers otherwise
     * @param $allOffers
     * @return array|mixed
     */
    public function searchJobFiltre($allOffers, $valueToSearch)
    {
        $searchedOffer = array();

        if($valueToSearch!=null)
        {

            foreach ($allOffers as $value)
            {
                $positions= $value->getJobPosition();

                foreach ($positions as $pos )
                {
                    //var_dump($pos->getJobPositionId());
                    if ($pos->getJobPositionId() == $valueToSearch) //no es case sensitive
                    {
                        array_push($searchedOffer, $value);
                    }
                }

            }
        }
        else
        {
            $searchedOffer = $allOffers;
        }

        if($valueToSearch=='Show all Offers' || $valueToSearch=='Back')
        {
            $searchedOffer = $allOffers;
        }

        return $searchedOffer;
    }


    /**
     * Returns a searched job offer by career or all offers otherwise
     * @param $allOffers
     * @return array|mixed
     */
    public function searchJobCareerFiltre($allOffers, $valueToSearch)
    {
        $searchedOffer = array();

        if($valueToSearch!=null)
        {

            foreach ($allOffers as $value)
            {
                    if ($value->getCareer()->getDescription() == $valueToSearch) //no es case sensitive
                    {
                        array_push($searchedOffer, $value);
                    }
            }
        }
        else
        {
            $searchedOffer = $allOffers;
        }

        if($valueToSearch=='Show all Offers' || $valueToSearch=='Back')
        {
            $searchedOffer = $allOffers;
        }

        return $searchedOffer;
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
        } else if (isset($_SESSION['loggedstudent'])) {
            $loggedUser = $_SESSION['loggedstudent'];
        }

        return $loggedUser;
    }


}
