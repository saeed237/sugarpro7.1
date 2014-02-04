<?php
// created: 2012-05-21 17:10:30
$dictionary["rt_companies_employees"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => false,
  'relationships' => 
  array (
    'rt_companies_employees' => 
    array (
		'lhs_module'=> 'rt_companies',
		'lhs_table'=> 'rt_companies',
		'lhs_key' => 'id',
		'rhs_module'=> 'rt_employees',
		'rhs_table'=> 'rt_employees',
		'rhs_key' => 'rt_companies_id',
		'relationship_type'=>'one-to-many'
    ),
  ),
);