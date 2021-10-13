<?php

namespace DAO;

use Models\Industry;

interface lIndustryRepository
{
    function add(Industry $industry);
    function getAll();
    function remove($id);

}