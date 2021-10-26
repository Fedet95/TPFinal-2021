<?php

namespace DAO;

use Models\Country;

interface lCountryDAO
{
    function add(Country $country);
    function getAll();

}