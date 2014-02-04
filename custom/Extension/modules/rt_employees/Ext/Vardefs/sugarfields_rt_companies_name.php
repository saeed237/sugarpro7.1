<?php
// created: 2012-05-21 17:10:30
$dictionary["rt_employees"]["fields"]["rt_companies_id"] = array (
  'name' => 'rt_companies_id',
  'type' => 'id',
 // 'relationship' => 'rt_companies_employees',
  'module'=>'rt_companies',
  'vname' => 'LBL_RT_COMPANIES_ID',
  'duplicate_merge' => 'disabled',
  'reportable' => true,
  'len' => 36,
  'size' => '20',
);
$dictionary["rt_employees"]["fields"]["rt_companies_name"] = array (
  'name' => 'rt_companies_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_RT_COMPANIES_NAME',
  'id_name' => 'rt_companies_id',
  'module' => 'rt_companies',
  'table' => 'rt_companies',
  'link' => 'rt_companies_employees',
  'studio' => 'visible',
);
$dictionary["rt_employees"]["fields"]["rt_companies_employees"] = array (
  'name' => 'rt_companies_employees',
  'type' => 'link',
  'relationship' => 'rt_companies_employees',
  'source' => 'non-db',
  'vname' => 'LBL_RT_COMPANIES',
);