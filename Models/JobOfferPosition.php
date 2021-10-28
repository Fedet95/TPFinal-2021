<?php

namespace Models;

class JobOfferPosition
{

    private $jobOfferPositionId;
    private $joOfferId;
    private $jobPositionId;



    public function getJobOfferPositionId()
    {
        return $this->jobOfferPositionId;
    }


    public function setJobOfferPositionId($jobOfferPositionId)
    {
        $this->jobOfferPositionId = $jobOfferPositionId;
    }

    public function getJoOfferId()
    {
        return $this->joOfferId;
    }


    public function setJoOfferId($joOfferId)
    {
        $this->joOfferId = $joOfferId;
    }


    public function getJobPositionId()
    {
        return $this->jobPositionId;
    }


    public function setJobPositionId($jobPositionId)
    {
        $this->jobPositionId = $jobPositionId;
    }



}