<?php

namespace DAO;

use Models\Career;

interface lCareerDAO
{
   function add(Career $career);
   function getAll();
   function update(Career $career);

}