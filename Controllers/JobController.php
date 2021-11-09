<?php

namespace Controllers;
require_once(VIEWS_PATH . "checkLoggedUser.php");

use DAO\AppointmentDAO;
use DAO\JobOfferDAO;
use DAO\JobOfferPositionDAO;
use DAO\OriginCareerDAO;
use DAO\CompanyDAO;
use DAO\CountryDAO;
use DAO\OriginJobPositionDAO;
use DAO\UserDAO;
use DAO\UserRolDAO;
use Models\Career;
use Models\Company;
use Models\JobOffer;
use Models\JobOfferPosition;
use Models\JobPosition;
use Models\User;


/**
 *
 */
class JobController
{
    /**
     * @var CompanyDAO
     */
    private $companyDAO;
    private $countryDAO;
    private $careersOrigin;
    private $allCareers;
    private $jobPositionsOrigin;
    private $allPositions;
    private $loggedUser;
    private $jobOfferDAO;
    private $jobOfferPositionDAO;


    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
        $this->countryDAO = new CountryDAO();
        $this->careersOrigin = new OriginCareerDAO();
        $this->jobPositionsOrigin = new OriginJobPositionDAO();
        $this->allCareers=null;
        $this->allPositions=null;
        $this->loggedUser = $this->loggedUserValidation();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobOfferPositionDAO = new JobOfferPositionDAO();
    }




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
        catch (\Exception $ex)
        {
           echo  $ex->getMessage();
        }

        try {

            $allCountrys = $this->countryDAO->getAll();
        }
        catch (\Exception $ex)
        {
           echo  $ex->getMessage();
        }


            if($this->allCareers==null)
            {
                $allCareers = $this->careersOrigin->start($this->careersOrigin);
            }
            else
            {
                $allCareers= $this->allCareers;
            }


        if ($careerId != null) {

            if($this->allPositions==null)
            {
                $allPositions = $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
            }
            else
            {
                $allPositions= $this->allPositions;
            }

        }

        require_once(VIEWS_PATH . "createJobOffer.php");
    }


    /**
     * Call the extend view of a JobOffer
     * @param $id
     */
    public function showJobOfferViewMore($id, $message= "")
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        try {
            $jobOffer = $this->jobOfferDAO->getJobOffer($id);

            try
            {
                $company= $this->companyDAO->getCompany($jobOffer->getCompany()->getCompanyId());
            }
            catch (\Exception $ex)
            {
                echo $ex->getMessage();
            }

        } catch (\Exception $ex) {
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
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        try
        {
            $allOffers = $this->jobOfferDAO->getAll();

        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }


            if($this->allCareers==null)
            {
                $allCareers = $this->careersOrigin->start($this->careersOrigin);
            }
            else
            {
                $allCareers= $this->allCareers;
            }



        if($this->allPositions==null)
        {
            $allPositions = $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
        }
        else
        {
            $allPositions= $this->allPositions;
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


       if(isset($searchedValue) && $searchedValue!=null)
       {
           $flag=0;
           foreach ($searchedValue as $offer)
           {
               if($offer->getActive()=='true')
               {
                   $flag=1;
               }
           }

           if($flag==0)
           {
               $searchedValue=$allOffers;
               $message= "No job offers with these characteristics were found";
           }
       }


        var_dump($allOffers);
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




    /**
     * Show the job position management listing view
     * @param string $message
     */
    public function showJobPositionManagement($message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");

        if($this->allPositions==null)
        {
            $allPositions= $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
        }
        else
        {
            $allPositions= $this->allPositions;
        }

        if($this->allCareers==null)
        {
            $allCareers = $this->careersOrigin->start($this->careersOrigin);
        }
        else
        {
            $allCareers= $this->allCareers;
        }

        foreach ($allCareers as $career)
        {
            foreach ($allPositions as $position)
            {
                if($career->getCareerId()==$position->getCareer()->getCareerId())
                {
                    $position->setCareer($career);
                }
            }
        }

        require_once(VIEWS_PATH . "jobPositionManagment.php");
    }



    /**
     * Show the extended job position management listing view
     * @param $careerDescription
     * @param string $message
     */
    public function showJobPositionViewMore($careerDescription, $message = "")
    {
        require_once(VIEWS_PATH . "checkLoggedUser.php");

        $careerToShow = $careerDescription;
        if($this->allPositions==null)
        {
            $allPositions= $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
        }
        else
        {
            $allPositions= $this->allPositions;
        }

        if($this->allCareers==null)
        {
            $allCareers = $this->careersOrigin->start($this->careersOrigin);
        }
        else
        {
            $allCareers= $this->allCareers;
        }

        foreach ($allCareers as $career)
        {
            foreach ($allPositions as $position)
            {
                if($career->getCareerId()==$position->getCareer()->getCareerId())
                {
                    $position->setCareer($career);
                }
            }
        }

        require_once(VIEWS_PATH . "jobPositionViewMore.php");

    }


    /**
     * Start the new job offer creation, sending to the second part of the form
     */
    public function addJobOfferFirstPart($company, $career, $publishDate, $endDate)
    {

        $publishDateValidation=$this->validatePublishDate($publishDate);
        if ($publishDateValidation == null) {
            $message = "Error, enter a valid Job Offer Publish Date";
            $flag = 1;
            $this->showCreateJobOfferView($message);
        }
        else
        {
            $endDateValidation = $this->validateEndDate($endDate, $publishDate);
            if ($endDateValidation == null) {
                $message = "Error, enter a valid Job Offer End Date";
                $flag = 1;
                $this->showCreateJobOfferView($message);
            } else {
                $values = array("company" => $company, "career" => $career, "publishDate" => $publishDate, "endDate" => $endDate);
                $this->showCreateJobOfferView("", $career, $values);
            }
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
            $newJobOffer->setActive($this->validateActive($postvalue['publishDate'], $active));
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

            $admin = new User();
            $admin->setUserId($this->loggedUser->getUserId());
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

            } catch (\Exception $ex) {
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


    public function validateActive($publishDate, $active)
    {

            if (strtotime($publishDate) >time() && $active=='false')
            {
                $active = 'false';
            }
            else if(strtotime($publishDate) >time() && $active=='true')
            {
                $active = 'false';
            }
            else if(strtotime($publishDate) <= time() && $active=='false')
            {
                $active = 'false';
            }
            else if(strtotime($publishDate) <= time() && $active=='true')
            {
                $active = 'true';
            }

            return $active;
    }


    /**
     * Validate if the entered job offer end date is valid
     */
    public function validateEndDate($date, $publishDate)
    {
        $validate = null;

        if ($date>= date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d")))) && $date>$publishDate){
            $validate=1;
        }

        return $validate;
    }

    /**
     * Validate if the entered job offer publish date is valid
     */
    public function validatePublishDate($date)
    {

        $validate = null;

        if ($date>= date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))))) {
            $validate=1;
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
        } catch (\Exception $ex) {
            $validate = 1;
            echo $ex->getMessage();
        }
        return $validate;
    }


    /**
     * Edit a job Offer
     * @param $jobOfferId
     * @param null $careerId
     * @param string $message
     * @param null $values
     */
    public function editJobOffer($jobOfferId, $careerId = null, $message = "", $values = null)
    {
        require_once(VIEWS_PATH . "checkLoggedAdmin.php");


        try {
            $jobOffer = $this->jobOfferDAO->getJobOffer($jobOfferId);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }

        try {
            $allCompanies = $this->companyDAO->getAll();
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }


            if($this->allCareers==null)
            {
                $allCareers = $this->careersOrigin->start($this->careersOrigin);
            }
            else
            {
                $allCareers= $this->allCareers;
            }


        if ($values != null) {

                if($this->allPositions==null)
                {
                    $allPositions = $this->jobPositionsOrigin->start($this->jobPositionsOrigin);
                }
                else
                {
                    $allPositions= $this->allPositions;
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

        $publishDateValidation=$this->validatePublishDate($publishDate);
        if ($publishDateValidation == null) {
            $message = "Error, enter a valid Job Offer Publish Date";
            $flag = 1;
            $this->editJobOffer($jobOfferId, null, $message);
        }
        else
        {
            $endDateValidation = $this->validateEndDate($endDate, $publishDate);
            if ($endDateValidation == null) {
                $message = "Error, enter a valid Job Offer End Date";

                $this->editJobOffer($jobOfferId, null, $message);
            } else {
                $values = array("company" => $company, "career" => $career, "publishDate" => $publishDate, "endDate" => $endDate, "jobOfferId" => $jobOfferId);
                $this->editJobOffer($jobOfferId, $career, null, $values);
            }
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
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

        try {
            $searchedOffer= $this->jobOfferDAO->getJobOffer($postvalue['jobOfferId']);
        }
        catch (\Exception $ex)
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
                   $flag=3;
               }
               else
               {
                   $flag=2;
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
            $newJobOffer->setActive($this->validateActive($postvalue['publishDate'], $active));
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


            $admin = new User();
            $admin->setUserId($this->loggedUser->getUserId());
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

            } catch (\Exception $ex) {
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


    /**
     * Remove a job offer from the system and DB
     * @param $id
     * @param null $accept
     * @param null $sub
     * @param null $text
     */
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
                    $appointments=$this->getAppointmentArray($id);

                    if(!empty($appointments)) //ESTO TIENE QUE SER ! (NEGATIVO) ESTA ASI PARA VER LA PANTALLA <<---
                    {
                        $cant=count($appointments);

                        try {
                            $company= $this->companyDAO->getCompany($searchedOffer->getCompany()->getCompanyId());
                        }
                        catch (\Exception $ex)
                        {
                            echo $ex->getMessage();
                        }

                        $this->showRemoveJobOfferView($searchedOffer, $cant, $company);
                    }
                    else
                    {

                        try {
                            $count=$this->jobOfferDAO->remove($id);
                        } catch (\Exception $ex)
                        {
                            echo $ex->getMessage();
                        }

                        if($count>0)
                        {
                            $this->jobOfferPositionDAO->remove($id);
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
            catch (\Exception $ex)
            {
                echo $ex->getMessage();
            }
        }
        else if($accept!=null && $text==null)
        {
            if($accept=="true")
            {
                try {
                    $searchedOffer= $this->jobOfferDAO->getJobOffer($id);
                    $this->showRemoveJobOfferView($searchedOffer, null, null, null, "Empty");
                }
                catch (\Exception $ex)
                {
                    echo $ex->getMessage();
                }

            }
            else
            {
                $this->showJobOfferManagementView(null, "Remove operation aborted", 3);
            }

        }
        else if($text!=null)
        {

            $searchedOffer= $this->jobOfferDAO->getJobOffer($id);//esta searchedOffer no tiene los appointment
            $appointments=$this->getAppointmentArray($id);

            try {
                $count=$this->jobOfferDAO->remove($id);
            }
            catch (\Exception $ex)
            {
                echo $ex->getMessage();
            }


            if($count>0)
            {
                $this->jobOfferPositionDAO->remove($id);

                $studentsId= array();
                foreach ($appointments as $value)
                {
                    array_push($studentsId,$value->getStudent()->getUserId());
                }

                $allStudents= new User();
                $userRol= $this->getRolId("student");

                $userDAO= new UserDAO();
                try {
                    $allStudents=$userDAO->getRol($userRol->getUserRolId());
                }catch (\Exception $ex)
                {
                    echo $ex->getMessage();
                }


                $studentsEmails= array();
                foreach ($allStudents as $student)
                {
                    foreach ($studentsId as $id)
                    {
                        if($student->getUserId()==$id)
                        {
                            array_push($studentsEmails, $student->getEmail());
                            $this->sendEmail($student->getEmail(), $sub, $text);
                            $this->sendEmail("juanpayetta@gmail.com", $sub, $text); //me auto envio mensaje para probar que funcione
                        }
                    }
                }

                $finalMessage="Job offer was successfully removed and applicants were notified";
                $this->showRemoveJobOfferView($searchedOffer, null, null, null, $finalMessage );


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
     * Gets the user rol
     */
    public function getRolId($rolName)
    {
        try {
            $userRolDAO = new UserRolDAO();
            $userRol = $userRolDAO->getRolIdByRolName($rolName);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }

        return $userRol;
    }



    /**
     * Gets the appointment array from a job offer
     * @param $jobOfferId
     */
    public function getAppointmentArray($jobOfferId)
    {
        try {

            $appointmentDAO= new AppointmentDAO();
            $allAppointments= $appointmentDAO->getAll();

            if($allAppointments!=null)
            {
                //search appointments from this jobofferid
                $allAppointments=$this->searchAppointments($allAppointments, $jobOfferId); //valueToSearch = $jobOffer ID

                if($allAppointments!=null)
                {
                    try
                    {   //find the joboffer and set the appointment array
                        $searchedJobOffer= $this->jobOfferDAO->getJobOffer($jobOfferId); //search jobOffer llenar array
                        $searchedJobOffer->setAppointment($allAppointments);
                        $allAppointments= $searchedJobOffer->getAppointment();
                    }
                    catch (\Exception $ex)
                    {
                        echo $ex->getMessage();
                    }

                }
            }

        }catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }


        return $allAppointments;
    }


    /**
     * Search an appointment in a job offer
     * @param $allAppointments
     * @param $jobOfferId
     * @return array|null
     */
    public function searchAppointments($allAppointments, $jobOfferId)
    {
        $appointments= array();

        if(is_array($allAppointments)) {
            foreach ($allAppointments as $value) {
                if ($value->getJobOffer()->getJobOfferId() == $jobOfferId) {
                    array_push($appointments, $value);
                }
            }

        }
        else if(is_object($allAppointments))
        {
            if ($allAppointments->getJobOffer()->getJobOfferId() == $jobOfferId)
            {
                array_push($appointments, $allAppointments);
            }
        }
        if (empty($appointments)) {
            $appointments = null;
        }

        return $appointments;
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
            if(is_object($allOffers))
            { $offer= $allOffers;
                $allOffers= array();
                array_push($allOffers, $offer);
            }

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
            if($allOffers!=null)
            {
                if(is_object($allOffers))
                { $offer= $allOffers;
                    $allOffers= array();
                    array_push($allOffers, $offer);
                }

                foreach ($allOffers as $value)
                {
                    if (strcasecmp($value->getCareer()->getDescription(),$valueToSearch)==0) //no es case sensitive
                    {
                        array_push($searchedOffer, $value);
                    }
                }

            }
            else
            {
                $searchedOffer=null;
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
