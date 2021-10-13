<?php

namespace DAO;

use Models\Country;

interface lCountryRepository
{
    function add(Country $country);
    function getAll();
    function remove($id);

}