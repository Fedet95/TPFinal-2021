<?php
namespace DAO;
use Models\User;

interface lUserDAO
{
   function add(User $student);
   function getAll();
   function remove($studentId, $rolId);
   function update(User $student);

}