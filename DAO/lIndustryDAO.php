<?php

namespace DAO;

use Models\Industry;

interface lIndustryDAO
{
    function add(Industry $industry);
    function getAll();


}