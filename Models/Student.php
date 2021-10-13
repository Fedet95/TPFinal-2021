<?php
namespace Models;

class Student extends User
{
    private $studentId;
    private $careerId;
    private $firstName;
    private $lastName;
    private $dni;
    private $fileNumber; //legajo
    private $gender;
    private $birthDate;
    private $phoneNumber;


    public function getStudentId()
    {
        return $this->studentId;

    }

    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }


    public function getCareerId()
    {
        return $this->careerId;
    }


    public function setCareerId($careerId)
    {
        $this->careerId = $careerId;
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


    public function getDni()
    {
        return $this->dni;
    }


    public function setDni($dni)
    {
        $this->dni = $dni;
    }


    public function getFileNumber()
    {
        return $this->fileNumber;
    }


    public function setFileNumber($fileNumber)
    {
        $this->fileNumber = $fileNumber;
    }


    public function getGender()
    {
        return $this->gender;
    }


    public function setGender($gender)
    {
        $this->gender = $gender;
    }


    public function getBirthDate()
    {
        return $this->birthDate;
    }


    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }


    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }





}