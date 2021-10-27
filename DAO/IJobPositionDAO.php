<?php

namespace DAO;

use Models\JobPosition;

interface IJobPositionDAO
{
    function add(JobPosition $jobPosition);
    function getAll();
    function remove($jobPositionId);
    function update(JobPosition $jobPosition);

}