<?php
namespace DAO;
use Models\City;

interface lCityRepository
{
    function add(City $city);
    function getAll();
    function remove($id);

}