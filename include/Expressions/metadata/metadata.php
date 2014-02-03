<?php
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/

$dd_meta = array(

	'triggers'	=>	array(

		/* Dropdown to Dropdown */
		'trigger1' => array(
				'fields' => array(
					'country_select'
				),
				'condition'=>'contains($country_select, "United States")',
				'dependencies'=>array(
					'loadUSStates'=>array(
						'key'=>'loadUSStates'
					)
				),
				'triggeronload'=>true
		),

		'trigger2' => array(
				'fields'=>array(
					'country_select'
				),
				'condition'=>'contains($country_select, "Canada")',
				'dependencies'=>array(
					'loadCNStates'=>array(
						'key'=>'loadCNStates',
					)
				),
				'triggeronload'=>true
		),


		/* Dropdown to CF */
		'trigger3' => array(
				'fields' => array(
					'feet_select', 'inches_select', 'weight_select',
				),
				'dependencies'=>array(
					'calculateBMI'=>array('key'=>'calculateBMI')
				),
				'triggeronload'=>true
		),

		/* CF to Dropdown */
		'trigger4' => array(
				'fields' => array(
					'income_input',
				),
				'condition'	=> 'greaterThan($income_input, 100000)',
				'dependencies'=>array(
					'populateRich'=>array('key'=>'populateRich')
				),
				'triggeronload'=>true
		),
		'trigger5' => array(
				'fields' => array(
					'income_input',
				),
				'condition'	=> 'greaterThan(100000, $income_input)',
				'dependencies'=>array(
					'populateMedi'=>array('key'=>'populateMedi')
				),
				'triggeronload'=>true
		),
		'trigger6' => array(
				'fields' => array(
					'salary_input', 'tax_input',
				),
				'dependencies'=>array(
					'calculateIncome'=>array('key'=>'calculateIncome')
				),
				'triggeronload'=>true
		),



		/* Field to Style */
		'trigger7' => array(
				'fields' => array(
					'temperature_input',
				),
				'condition'	=> 'greaterThan($temperature_input, 100)',
				'dependencies'=>array(
					'makeHot'=>array('key'=>'makeHot')
				),
				'triggeronload'=>true
		),
		'trigger8' => array(
				'fields' => array(
					'temperature_input',
				),
				'condition'	=> 'greaterThan(100, $temperature_input)',
				'dependencies'=>array(
					'makeCold'=>array('key'=>'makeCold')
				),
				'triggeronload'=>true
		),

		/* Dropdown to Style */
		'trigger9' => array(
				'fields' => array(
					'color_input',
				),
				'dependencies'=>array(
					'changeStyle'=>array('key'=>'changeStyle')
				),
				'triggeronload'=>true
		),

	),

	'dependencies'=>array(

		/* Example 1 */
		'loadUSStates'=>array(
			'field'=>'state_select',
			'expression'=>'enum("New York", "Pennsylvania", "California", "Florida")',
			//'expression'=>'SugarEnum("usstatelist")',
		),
		'loadCNStates'=>array(
			'field'			=>	'state_select',
			'expression'	=>	'enum("Ontario", "Quebec", "British Columbia", "Manitoba")',
			//'expression'	=>	'SugarEnum("cnstatelist")',
		),


		/* Example 2 */
		'calculateBMI'=>array(
			'field'			=>	'bmi_output',
			'expression'	=>	'multiply(divide($weight_select,pow(add(multiply($feet_select, 12),$inches_select),2)),703)',
		),


		/* Example 3 */
		'calculateIncome'=>array(
			'field'			=>	'income_input',
			'expression'	=>	'subtract($salary_input, multiply($salary_input, divide($tax_input, 100)))',
		),
		'populateRich'=>array(
			'field'			=>	'interest_select',
			'expression'	=>	'enum("Equestrian", "Sailboating", "Golf", "Pool", "Billiards", "Curling")',
		),
		'populateMedi'=>array(
			'field'			=>	'interest_select',
			'expression'	=>	'enum("Basketball", "Football", "Tennis", "Lacrosse", "Waterpolo", "Swimming")',
		),


		/* Example 4 */
		'makeHot'=>array(
			'type'			=>	'style',
			'field'			=>	'heat_index',
			'expression'	=>	'{ backgroundColor: "#FF0022" }',
		),
		'makeCold'=>array(
			'type'			=>	'style',
			'field'			=>	'heat_index',
			'expression'	=>	'{ backgroundColor: "blue" }',
		),


		/* Example 5 */
		'changeStyle'=>array(
			'type'			=>	'style',
			'field'			=>	'color_index',
			'expression'	=>	'{ backgroundColor: { evaluate: \'concat($color_input, "")\' } }',
		),
	)
);



$dep_meta = array(
	'triggers'	=>	array(

		/* Dropdown to Dropdown */
		'trigger1' => array(
				'fields' => array(
					'lastname'
				),
				'condition'=>'contains($lastname, "Smith")',
				'dependencies'=>array(
					'met'=>array(
						'makeReq'=>array(
							'key'=>'makeReq'
						),
					),
					'unmet'=>array(
						'makeNReq'=>array(
							'key'=>'makeNReq'
						),
					),
				),
				'triggeronload'=>true
		),
	),

	'dependencies'=>array(

		/* Example 1 */
		'makeReq'=>array(
			'type'=>'require',
			'field'=>'number',
			'require'=>true,
			'label_id'=>'number_lbl',
		),


		/* Example 1 */
		'makeNReq'=>array(
			'type'=>'require',
			'field'=>'number',
			'require'=>false,
			'label_id'=>'number_lbl',
		),
	),
);

$val_meta = array(
	'myform'=>array(
		'firstname'	=> array(
			'required'	=>	true,
			'conditions'	=> array(
				'alpha'	=> array(
				),
				'binarydep'	=> array(
							'sibling' => 'number',
				),
			),
		),
		'lastname'	=> array(
			'required'	=>	true,
			'conditions'	=> array(
				'alpha'	=> array(
				),
				'binarydep'	=> array(
							'sibling' => 'number',
				),
			),
		),
		'email'		=> array(
			'required'	=>	true,
			'conditions'	=> array(
				'email'	=> array(
						'message' => 'default',
				),
			),
		),
		'phone'		=> array(
			'required'	=>	true,
			'conditions'	=> array(
				'phone'	=> array(

				),
			),
		),
		'date'		=> array(
			'conditions'	=> array(
				'date'	=> array(
				),
			),
		),
		'number'	=> array(
			'required'	=>	true,
			'conditions'	=> array(
				'number'	=> array(
				),
			),
		),
	)
);


require_once("./metatojs.php");

//echo getJSFromDDMeta($dd_meta);
echo getJSFromDDMeta($dep_meta);
echo getJSFromValidationMeta($val_meta);



// $GLOBALS['app_list_strings']['en_us']['usstatelist'] = array('NEW YORK'=>'NEW YORK', 'CALIFORNIA'=>'CALIFORNIA');
// multiply(divide($weight_pounds,pow(add(multiply($height_feet, 12),$height_inches),2)),703)


?>
