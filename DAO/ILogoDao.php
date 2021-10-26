<?php

namespace DAO;

use Models\Logo;

interface ILogoDao
{
    function add(Logo $logo);
    function getAll();
    function remove($logoId);
    function update(Logo $logo);

}