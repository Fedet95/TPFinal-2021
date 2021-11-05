<?php

namespace Models;

class UserRol
{
   private $userRolId;
   private $rolName;


    public function getUserRolId()
    {
        return $this->userRolId;
    }


    public function setUserRolId($userRolId)
    {
        $this->userRolId = $userRolId;
    }


    public function getRolName()
    {
        return $this->rolName;
    }


    public function setRolName($rolName)
    {
        $this->rolName = $rolName;
    }



}