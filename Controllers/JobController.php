<?php

namespace Controllers;
use Models\SessionHelper;
//require_once(VIEWS_PATH . "checkLoggedUser.php");
SessionHelper::checkUserSession();


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
use Models\Appointment;


class JobController
{

    private $companyDAO;
    private $countryDAO;
    private $careersOrigin;
    private $allCareers;
    private $jobPositionsOrigin;
    private $allPositions;
    private $loggedUser;
    private $jobOfferDAO;
    private $jobOfferPositionDAO;
    private $allAppointments;

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
        $this->appointmentDAO = new AppointmentDAO();
    }




    /**
     * Call the "createJobOffer" view
     * @param string $message
     */
    public function showCreateJobOfferView($message = "", $careerId = null, $values = null)
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkUserSession();

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
        //require_once(VIEWS_PATH . "checkLoggedUser.php");
        SessionHelper::checkUserSession();

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


    public function showFlyerView($flyer)
    {
        SessionHelper::checkUserSession();
        require_once (VIEWS_PATH."viewFlyer.php");
    }

    /**
     * Call the "job offer management" view
     * @param string $message
     */
    public function showJobOfferManagementView($valueToSearch=null, $message = "",  $back=null)
    {
        //require_once(VIEWS_PATH . "checkLoggedUser.php");
        SessionHelper::checkUserSession();

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

        if($this->loggedUser->getRol()->getUserRolId()==3)
        {
            $allOffers=$this->userCompanyOffers($allOffers);
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

        try {
            $allAppointments= $this->appointmentDAO->getAll();
        }
        catch (\Exception $ex)
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


       if($this->loggedUser->getRol()->getUserRolId()==2 && isset($searchedValue) && $searchedValue!=null)
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
               $validateMessage=1;
               $message= "No job offers with these characteristics were found";
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
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

        require_once(VIEWS_PATH . "jobOffersManagement.php");
    }



    /**
     * Call the "remove job offer" view
     */
    public function showRemoveJobOfferView($jobOffer, $cant=null, $company=null, $text=null, $finalMessage=null)
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();
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
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

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
        //require_once(VIEWS_PATH . "checkLoggedUser.php");
        SessionHelper::checkUserSession();

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

        SessionHelper::checkUserSession();
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
    public function addJobOfferSecondPart($title, $position, $remote, $dedication, $description, $salary, $max, $active, $values, $flyer)
    {
        $postvalue = unserialize(base64_decode($values));


        if ($values == '') {
            $message = "Error, complete all fields";
            $this->showCreateJobOfferView($message, $postvalue['career'], $postvalue);
        }

        $positiveNumber=$this->validateNegativeNumber($max);
        if($positiveNumber==null) {
            $message = "Error, the entered maximun of applies value must be a positive number";
            $this->showCreateJobOfferView($message, $postvalue['career'], $postvalue);
           } else
            {
                $titleValidation = $this->validateUniqueTitle($title, $postvalue['company']);
                if ($titleValidation == 1) {
                    $message = "Error, the entered Job Offer Title is already in use by the offering company";
                    $this->showCreateJobOfferView($message, $postvalue['career'], $postvalue);
                }

                $newJobOffer = new JobOffer();

                $searchedCompany= $this->companyDAO->getCompany($postvalue['company']);
                $flyerValidation=$this->validateFlyer($newJobOffer, $searchedCompany->getName()); //si esta todo ok, ya le setea el flyer
                if($flyerValidation==null)
                {
                    $message = "Error, enter a valid flyer (jpg,png,jpeg)";
                    $this->showCreateJobOfferView($message, $postvalue['career'], $postvalue);
                }
                else {
                    $newJobOffer->setDescription($description);
                    $newJobOffer->setActive($this->validateActive($postvalue['publishDate'], $active));
                    $newJobOffer->setDedication($dedication);
                    $newJobOffer->setEndDate($postvalue['endDate']);
                    $newJobOffer->setPublishDate($postvalue['publishDate']);
                    $newJobOffer->setRemote($remote);
                    $newJobOffer->setSalary($salary);
                    $newJobOffer->setTitle($title);
                    $newJobOffer->setEmailSent("false");
                    $newJobOffer->setMaxApply($max);

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


    }


    public function validateNegativeNumber($number)
    {
        $validate = null;

        if ($number>0){
            $validate=1;
        }

        return $validate;
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
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();


        try {
            $jobOffer = $this->jobOfferDAO->getJobOffer($jobOfferId);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }


        if($jobOffer!=null)
        {
            $flag=0;
            try {
                $offerDao= new AppointmentDAO();
                $allAppointments = $offerDao->getAppointmentFromOffers($jobOfferId);
                if($allAppointments!=null)
                {
                    $flag=1; //no puede editar

                }
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }


      if($flag==0)
      {

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
      else
      {
          $message="The job offer have appointments and cannot be edited";
            $this->showJobOfferManagementView(null, $message);
      }

    }


    /**
     * Start the update of a job offer, adding to data base
     */
    public function editJobOfferFirstPart($company, $career, $publishDate, $endDate, $jobOfferId)
    {
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();

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
    public function editJobOfferSecondPart($title, $position, $remote, $dedication, $description, $salary, $max, $active, $values, $flyer)
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
        else
        {
            $positiveNumber=$this->validateNegativeNumber($max);
            if($positiveNumber==null)
            {
                $message = "Error, the entered maximun of applies value must be a positive number";
                $this->editJobOffer($postvalue['jobOfferId'], $postvalue['career'], $message, $postvalue);
            }
            else
            {
                $flagg=0;
               $allAppointments= $this->appointmentDAO->getAppointmentFromOffers($postvalue['jobOfferId']);
               if($allAppointments!=null)
               {
                   $flagg=0;
                   $cant=count($allAppointments);
                   if($max<$cant)
                   {
                       $message = "Error, the entered maximun of applies value must be equal or superior to the actual number of appointmets (".$cant.")";
                       $flagg=1;
                       $this->editJobOffer($postvalue['jobOfferId'], $postvalue['career'], $message, $postvalue);
                   }
               }

                $newJobOffer = new JobOffer();
               if($flyer['name']=='') //validamos que el array que contiene el flyer esté vacio
               {
                   var_dump($searchedOffer->getFlyer());
                   $newJobOffer->setFlyer($searchedOffer->getFlyer());
               }
               else
               {
                   $this->removeFlyer($searchedOffer); //eliminamos el flyer viejo
                   try{
                       $searchedCompany= $this->companyDAO->getCompany($postvalue['company']);
                   }catch (\Exception $ex)
                   {
                       echo $ex->getMessage();
                   }

                   $flyerValidation=$this->validateFlyer($newJobOffer, $searchedCompany->getName()); //si esta todo ok, ya le setea el flyer
                   if($flyerValidation==null)
                   {
                       $flagg=1;
                       $message = "Error, enter a valid flyer (jpg,png,jpeg)";
                       $this->editJobOffer($postvalue['jobOfferId'], $postvalue['career'], $message, $postvalue);
                   }
               }


                   if($flagg==0)
                   {

                       $newJobOffer->setDescription($description);
                       $newJobOffer->setActive($this->validateActive($postvalue['publishDate'], $active));
                       $newJobOffer->setDedication($dedication);
                       $newJobOffer->setEndDate($postvalue['endDate']);
                       $newJobOffer->setPublishDate($postvalue['publishDate']);
                       $newJobOffer->setRemote($remote);
                       $newJobOffer->setSalary($salary);
                       $newJobOffer->setTitle($title);
                       $newJobOffer->setJobOfferId($postvalue['jobOfferId']);
                       $newJobOffer->setMaxApply($max);

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
        //require_once(VIEWS_PATH . "checkLoggedAdmin.php");
        SessionHelper::checkAdminSession();
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
                            $this->removeFlyer($searchedOffer);
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
                $this->removeFlyer($searchedOffer);

                if($searchedOffer->getEmailSent()==0) //para cuando aun NO se le agradecio a los postulantes por email
                {
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

                }
                else //no se envia email xq ya se les agradecio a los potulantes x email antes
                {
                    $finalMessage="Job offer was successfully removed";
                    $this->showRemoveJobOfferView($searchedOffer, null, null, null, $finalMessage );
                }


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


    public function removeFlyer($jobOffer)
    {
        $path = "uploads/";
        $file_pattern = $path . $jobOffer->getFlyer();
        $result = array_map("unlink", glob($file_pattern));
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


    public function userCompanyOffers($allOffers)
    {
        $offerArray= array();
        if($allOffers!=null)
        {
            foreach ($allOffers as $offer)
            {
                if($offer->getCompany()->getEmail()==$this->loggedUser->getEmail())
                {
                    array_push($offerArray, $offer);
                }
            }
        }

        return $offerArray;
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
        else if(isset($_SESSION['loggedcompany']))
        {
            $loggedUser = $_SESSION['loggedcompany'];
        }

        return $loggedUser;
    }


    //---------------------------------------TRABAJANDO FLYER-----------------------------------------------------


    /**
     * Validate if a flyer is correctly loaded
     * @param $jobOffer, $companyName
     * @return mixed|null
     */
    public function validateFlyer($jobOffer, $companyName)
    {
        $statusMsg = '';
        // File upload path
        $targetDir = "uploads/";
        $randomNumber= rand(1, 999);
        $companyName= $companyName.$randomNumber; //le agregamos al nombre de la compañia, la palabra flyer, para que no se mezcle con el nombre de ningun logo

        $temp = explode(".", $_FILES["flyer"]["name"]); //tomo la extension
        $newfilename = $companyName . '.' . end($temp); //le doy nuevo nombre y le concateno la extension

        $targetFilePath = $targetDir . $newfilename;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $flag = 0;
        if (!empty($_FILES["flyer"]["name"])) {
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg');
            if (!file_exists($targetFilePath)) { //image already exist in the folder
                if (in_array($fileType, $allowTypes)) {

                    // Upload file to server
                    if (move_uploaded_file($_FILES["flyer"]["tmp_name"], $targetFilePath)) { //image doesn't exist in the folder, add it (si no funciona, sacar el . $newfilename)

                        // Insert image file name into database
                        $jobOffer->setFlyer($newfilename); //---->antes era $filename y lo cambie por $newfilename

                    } else {
                        /* $statusMsg = "Sorry, there was an error uploading your file";*/
                        $flag = 1;
                    }
                } else {
                    /*$statusMsg = "Sorry, only PDF, DOC files are allowed to upload.";*/
                    $flag = 1;
                }
            } else {
                /* $statusMsg = "The file <b>".$fileName. "</b> is already exist";*/


                $path = 'uploads/';
                $files = scandir($path);

                $flag = 1;
                foreach ($files as $value) {
                    if ($value == $newfilename) //--->antes era $filename y lo camnbie por newfilename
                    {
                        $jobOffer->setFlyer($newfilename);
                        $flag = 0;
                    }
                }
            }
        } else {
            /*$statusMsg = 'Please select a file to upload';*/
            $flag = 1;
        }
        // Display status message
        if ($flag == 1) {
            return null;
        } else {
            return $jobOffer;
        }
    }


    public function showFlyer($jobOfferId)
    {
        try {
            $offer = $this->jobOfferDAO->getJobOffer($jobOfferId);
            $this->showFlyerView($offer->getFlyer());

        }
        catch (\Exception $ex)
        {
            echo $ex->getMessage();
        }

    }





}
