<?php

namespace Models;

class AppointmentHistory
{
    private $historyId;
    private $jobOfferTittle;
    private $jobOfferCompanyName;
    private $jobOfferCompanyCuit;
    private $historyCareerId;
    private $historyStudentId;

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

    public function getJobOfferCompanyName()
    {
        return $this->jobOfferCompanyName;
    }

    public function setJobOfferCompanyName(Company $jobOfferCompanyName)
    {
        $this->jobOfferCompanyName = $jobOfferCompanyName;
    }
    public function getJobOfferCompanyCuit()
    {
        return $this->jobOfferCompanyCuit;
    }

    public function setJobOfferCompanyCuit(Company $jobOfferCompanyCuit)
    {
        $this->jobOfferCompanyCuit = $jobOfferCompanyCuit;
    }

    public function getHistoryCareedId()
    {
        return $this->historyCareerId;
    }

    public function setHistoryCareedId(Career $historyCareerId)
    {
        $this->historyCareerId = $historyCareerId;
    }

    public function getHistoryStudentId()
    {
        return $this->historyStudentId;
    }

    public function setHistoryStudentId(Student $historyStudentId)
    {
        $this->historyStudentId = $historyStudentId;
    }
}