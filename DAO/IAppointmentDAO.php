<?php

namespace DAO;

use Models\Appointment;

interface IAppointmentDAO
{
    public function add(Appointment $appointment);
    function getAll();
    function remove($appointmentID);
}