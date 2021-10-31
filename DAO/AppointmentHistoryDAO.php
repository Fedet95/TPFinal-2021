<?php

namespace DAO;

use Models\AppointmentHistory;

class AppointmentHistoryDAO implements IAppointmentHistoryDAO
{
    private $connection;
    private $tablename = "appointmentHistory";
    private $historyId;
    private $jobOfferTittle;
    private $jobOfferCompanyName;
    private $jobOfferCompanyCuit;
    private $historyCareerId;
    private $historyStudentId;
    public function add(AppointmentHistory $appointmentHistory)
    {
        try
        {
            $query = "INSERT INTO " . $this->tablename . " (jobOfferTittle, jobOfferCompanyName, jobOfferCompanyCuit, historyCareerId, historyStudentId) VALUES (:jobOfferTittle, :jobOfferCompanyName, :jobofferCompanyCuit, :historyCareedId, :historyStudentId)";

            $parameters['jobOfferTittle'] = $appointmentHistory->getJobOfferTittle();
            $parameters['jobOfferCompanyName'] = $appointmentHistory->getJobOfferCompanyName();
            $parameters['jobOfferCompanyCuit'] = $appointmentHistory->getJobOfferCompanyCuit();
            $parameters['historyCareerId'] = $appointmentHistory->getHistoryCareedId();
            $parameters['historyStudentId'] = $appointmentHistory->getHistoryStudentId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters);

        }catch (\PDOException $ex)
        {
            throw $ex;
        }
    }
}