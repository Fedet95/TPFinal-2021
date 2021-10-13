<?php

namespace Models;

class Administrator extends User
{
    private $administratorId; //auto_increment
    private $firstName;
    private $lastName;
    private $employeeNumber; //no ponemos dni, porque con employeeNumber se obtiene el dato unico del administrador


    public function getAdministratorId()
    {
        return $this->administratorId;
    }


    public function setAdministratorId($administratorId)
    {
        $this->administratorId = $administratorId;
    }


    public function getFirstName()
    {
        return $this->firstName;
    }


    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }


    public function getLastName()
    {
        return $this->lastName;
    }


    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    public function getEmployeeNumber()
    {
        return $this->employeeNumber;
    }


    public function setEmployeeNumber($employeeNumber)
    {
        $this->employeeNumber = $employeeNumber;
    }



}