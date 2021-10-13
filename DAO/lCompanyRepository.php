<?php

namespace DAO;

use Models\Company;

interface lCompanyRepository
{
   function add(Company $company);
   function getAll();
   function remove($companyId);
   function update(Company $company);

}