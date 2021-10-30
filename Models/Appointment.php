<?php

namespace Models;

class Appointment
{
  private $appointmentId;
  private $jobOffer; // (objeto)
  private $student; // (objeto)
  private $date;
  private $message;
  private $cv;



    public function getAppointmentId()
    {
        return $this->appointmentId;
    }


    public function setAppointmentId($appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }

    public function getJobOffer()
    {
        return $this->jobOffer;
    }


    public function setJobOffer(jobOffer $jobOffer)
    {
        $this->jobOffer = $jobOffer;
    }


    public function getStudent()
    {
        return $this->student;
    }


    public function setStudent(student $student)
    {
        $this->student = $student;
    }


    public function getDate()
    {
        return $this->date;
    }


    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv)
    {
        $this->cv = $cv;
    }

}