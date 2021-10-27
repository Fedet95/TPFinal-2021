<?php

namespace DAO;

use Models\JobOfferPosition;

interface IJobOfferPosition
{
   function add(JobOfferPosition $jobOfferPosition);
   function getAll();

}