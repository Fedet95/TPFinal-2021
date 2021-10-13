<?php
namespace DAO;
use Models\Student;

interface lStudentRepository
{
   function add(Student $student);
   function getAll();
   function remove($studentId);

}