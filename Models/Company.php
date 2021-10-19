<?php
namespace Models;

class Company
{
    private $companyId;
    private $name;
    private $foundationDate;
    private $cuit;
    private $aboutUs;
    private $companyLink;
    private $email;
    private $logo;
    private $active;
    private $industry;
    private $city;
    private $country;
    private $creationAdminId;


    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


    public function getFoundationDate()
    {
        return $this->foundationDate;
    }


    public function setFoundationDate($foundationDate)
    {
        $this->foundationDate = $foundationDate;
    }


    public function getCuit()
    {
        return $this->cuit;
    }


    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    }


    public function getAboutUs()
    {
        return $this->aboutUs;
    }


    public function setAboutUs($aboutUs)
    {
        $this->aboutUs = $aboutUs;
    }


    public function getCompanyLink()
    {
        return $this->companyLink;
    }


    public function setCompanyLink($companyLink)
    {
        $this->companyLink = $companyLink;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getLogo()
    {
        return $this->logo;
    }


    public function setLogo($logo)
    {
        $this->logo = $logo;
    }


    public function getActive()
    {
        return $this->active;
    }


    public function setActive($active)
    {
        $this->active = $active;
    }


    public function getIndustry()
    {
        return $this->industry;
    }


    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }


    public function getCity()
    {
        return $this->city;
    }


    public function setCity($city)
    {
        $this->city = $city;
    }


    public function getCountry()
    {
        return $this->country;
    }


    public function setCountry($country)
    {
        $this->country = $country;
    }


    public function getCreationAdminId()
    {
        return $this->creationAdminId;
    }


    public function setCreationAdminId($creationAdminId)
    {
        $this->creationAdminId = $creationAdminId;
    }


}