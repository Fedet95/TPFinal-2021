<?php

namespace Models;

use Models\City as City;
use Models\Industry as Industry;
use Models\Country as Country;
use Models\Administrator as Administrator;

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
    private $creationAdmin;


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


    public function setLogo($logo) ///Object tipo logo?
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


    public function setIndustry(Industry $industry)
    {
        $this->industry = $industry;
    }


    public function getCity()
    {
        return $this->city;
    }


    public function setCity(City $city)
    {
        $this->city = $city;
    }


    public function getCountry()
    {
        return $this->country;
    }


    public function setCountry(Country $country)
    {
        $this->country = $country;
    }


    public function getCreationAdmin()
    {
        return $this->creationAdmin;
    }


    public function setCreationAdmin(Administrator $creationAdmin)
    {
        $this->creationAdmin = $creationAdmin;
    }


}