<?php
namespace DAO;
use Models\City;

interface lCityDAO
{
    function add(City $city);
    function getAll();


}