<?php

namespace DAO;

use Models\JobOffer;

interface IJobOfferDAO
{
    function add(JobOffer $jobOffer);
    function getAll();
    function remove ($id);
    function update (JobOffer $jobOffer);


}