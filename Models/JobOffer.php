<?php

namespace Models;

class JobOffer
{
 private $jobOfferId;
 private $active;
 private $remote;
 private $publishDate;
 private $endDate;
 private $title;
 private $dedication;
 private $description;
 private $salary;
 private $creationAdmin;
 private $company;
 private $jobPosition;
 private $career;



    public function getJobOfferId()
    {
        return $this->jobOfferId;
    }


    public function setJobOfferId($jobOfferId)
    {
        $this->jobOfferId = $jobOfferId;
    }


    public function getActive()
    {
        return $this->active;
    }


    public function setActive($active)
    {
        $this->active = $active;
    }


    public function getRemote()
    {
        return $this->remote;
    }


    public function setRemote($remote)
    {
        $this->remote = $remote;
    }


    public function getPublishDate()
    {
        return $this->publishDate;
    }


    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;
    }


    public function getEndDate()
    {
        return $this->endDate;
    }


    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }


    public function getDedication()
    {
        return $this->dedication;
    }


    public function setDedication($dedication)
    {
        $this->dedication = $dedication;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function getSalary()
    {
        return $this->salary;
    }


    public function setSalary($salary)
    {
        $this->salary = $salary;
    }


    public function getCreationAdmin()
    {
        return $this->creationAdmin;
    }


    public function setCreationAdmin($creationAdmin)
    {
        $this->creationAdmin = $creationAdmin;
    }


    public function getCompany()
    {
        return $this->company;
    }


    public function setCompany($company)
    {
        $this->company = $company;
    }


    public function getJobPosition()
    {
        return $this->jobPosition;
    }


    public function setJobPosition($jobPosition)
    {
        $this->jobPosition = $jobPosition;
    }


    public function getCareer()
    {
        return $this->career;
    }


    public function setCareer($career)
    {
        $this->career = $career;
    }






}