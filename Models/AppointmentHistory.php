<?php

namespace Models;

class AppointmentHistory
{
    private $historyId;
    private $jobOfferTittle;
    private $company;
    private $career;
    private $student;
    private $appointmentDate;

    public function getHistoryId()
    {
        return $this->historyId;
    }

    public function setHistoryId($historyId)
    {
        $this->historyId = $historyId;
    }

    public function getJobOfferTittle()
    {
        return $this->jobOfferTittle;
    }

    public function setJobOfferTittle(JobOffer $jobOfferTittle)
    {
        $this->jobOfferTittle = $jobOfferTittle;
    }


    public function getCompany()
    {
        return $this->company;
    }


    public function setCompany($company)
    {
        $this->company = $company;
    }


    public function getCareer()
    {
        return $this->career;
    }


    public function setCareer($career)
    {
        $this->career = $career;
    }


    public function getStudent()
    {
        return $this->student;
    }


    public function setStudent($student)
    {
        $this->student = $student;
    }

    public function getAppointmentDate()
    {
        return $this->appointmentDate;
    }


    public function setAppointmentDate($appointmentDate)
    {
        $this->appointmentDate = $appointmentDate;
    }




}