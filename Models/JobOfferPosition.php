<?php

namespace Models;

class JobOfferPosition
{

    private $joOfferId;
    private $jobPositionId;


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