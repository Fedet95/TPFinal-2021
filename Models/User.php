<?php
namespace Models;

class User
{
    private $userId;
    private $email; //no se valida con id, sino con email
    private $active;
    private $password;
    private $rol;



    public function getUserId()
    {
        return $this->userId;
    }


    public function setUserId($userId)
    {
        $this->userId = $userId;
    } //1= student / 0=administrator


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getActive()
    {
        return $this->active;
    }


    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getRol()
    {
        return $this->rol;
    }


    public function setRol(UserRol  $rol)
    {
        $this->rol = $rol;
        //1= student / 0=administrator
    }







}