<?php
namespace DAO;
use Models\Student;

interface lStudentDAO
{
   function add(Student $student);
   function getAll();
   function remove($studentId);
   function update(Student $student);

}