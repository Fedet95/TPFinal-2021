<?php

namespace Models;

class Logo
{
   private $id;
   private $name;
   private $file;


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;
    }


    public function getFile()
    {
        return $this->file;
    }


    public function setFile($file)
    {
        $this->file = $file;
    }



}