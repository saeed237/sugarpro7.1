<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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




// load the correct demo data and main application language file depending upon the installer language selected; if
// it's not found fall back on en_us
if(file_exists("include/language/{$current_language}.lang.php")){
    require_once("include/language/{$current_language}.lang.php");
}
else {
    require_once("include/language/en_us.lang.php");
}
require_once('install/UserDemoData.php');
require_once('install/TeamDemoData.php');

global $sugar_demodata;
if(file_exists("install/demoData.{$current_language}.php")){
   require_once("install/demoData.{$current_language}.php");
}
else {
   require_once("install/demoData.en_us.php");
}

$last_name_count = count($sugar_demodata['last_name_array']);
$first_name_count = count($sugar_demodata['first_name_array']);
$company_name_count = count($sugar_demodata['company_name_array']);
$street_address_count = count($sugar_demodata['street_address_array']);
$city_array_count = count($sugar_demodata['city_array']);
//Turn disable_workflow to Yes so that we don't run workflow for any seed modules
$_SESSION['disable_workflow'] = "Yes";
global $app_list_strings;
global $sugar_config;
$_REQUEST['useEmailWidget'] = "true";
if(empty($app_list_strings)) {
	$app_list_strings = return_app_list_strings_language('en_us');
}
/*
 * Seed the random number generator with a fixed constant.  This will make all installs of the same code have the same
 * seed data.  This facilitates cross database testing..
 */
mt_srand(93285903);
$db = DBManagerFactory::getInstance();
$timedate = TimeDate::getInstance();
// Set the max time to one hour (helps Windows load the seed data)
ini_set("max_execution_time", "3600");

// ensure we have enough memory
$memory_needed  = 256;
// all version below 5.3.0, the memory usage needs to be 1 GIG for demo data
if(version_compare(PHP_VERSION, '5.3.0', '<'))
{
	$memory_needed = 1024;
}

$memory_limit   = ini_get('memory_limit');
if( $memory_limit != "" && $memory_limit != "-1" ){ // if memory_limit is set
    rtrim($memory_limit, 'M');
    $memory_limit_int = (int) $memory_limit;
    if( $memory_limit_int < $memory_needed ){
        ini_set("memory_limit", "$memory_needed" . "M");
    }
}
$large_scale_test = empty($sugar_config['large_scale_test']) ? false : $sugar_config['large_scale_test'];

$seed_user = new User();
$user_demo_data = new UserDemoData($seed_user, $large_scale_test);
$user_demo_data->create_demo_data();
$number_contacts = 200;
$number_companies = 50;
$number_leads = 200;
$number_cases = 5;
$large_scale_test = empty($sugar_config['large_scale_test']) ? false : $sugar_config['large_scale_test'];
// If large scale test is set to true, increase the seed data.
if($large_scale_test) {
	// increase the cuttoff time to 1 hour
	ini_set("max_execution_time", "3600");
	$number_contacts = 100000;
	$number_companies = 15000;
	$number_leads = 100000;
}

$seed_team = new Team();
$team_demo_data = new TeamDemoData($seed_team, $large_scale_test);
$team_demo_data->create_demo_data();

$possible_duration_hours_arr = array( 0, 1, 2, 3);
$possible_duration_minutes_arr = array('00' => '00','15' => '15', '30' => '30', '45' => '45');
$account_ids = Array();
$accounts = Array();

// Determine the assigned user for all demo data.  This is the default user if set, or admin
$assigned_user_name = "admin";
if(!empty($sugar_config['default_user_name']) &&
	!empty($sugar_config['create_default_user']) &&
	$sugar_config['create_default_user'])
{
	$assigned_user_name = $sugar_config['default_user_name'];
}

// Look up the user id for the assigned user
$seed_user = new User();
$assigned_user_id = $seed_user->retrieve_user_id($assigned_user_name);
$patterns[] = '/ /';
$patterns[] = '/\./';
$patterns[] = '/&/';
$patterns[] = '/\//';
$replacements[] = '';
$replacements[] = '';
$replacements[] = '';
$replacements[] = '';

//create timeperiods - pro only
require_once('modules/Forecasts/ForecastDirectReports.php');
require_once('modules/Forecasts/Common.php');
require_once('modules/TimePeriods/TimePeriodsSeedData.php');

$timedate = TimeDate::getInstance();
$timeperiods = TimePeriodsSeedData::populateSeedData();


///////////////////////////////////////////////////////////////////////////////
////	ACCOUNTS
for($i = 0; $i < $number_companies; $i++) {
	$account_name = $sugar_demodata['company_name_array'][mt_rand(0,$company_name_count-1)];
	// Create new accounts.
	$account = new Account();
	$account->name = $account_name;
	$account->phone_office = create_phone_number();
	$account->assigned_user_id = $assigned_user_id;
	$account->emailAddress->addAddress(createEmailAddress(), true);
	$account->emailAddress->addAddress(createEmailAddress());
	$account->website = createWebAddress();
	$account->billing_address_street = $sugar_demodata['street_address_array'][mt_rand(0,$street_address_count-1)];
	$account->billing_address_city = $sugar_demodata['city_array'][mt_rand(0,$city_array_count-1)];
	if($i % 3 == 1)	{
		$account->billing_address_state = "NY";
		$assigned_user_id = mt_rand(9,11);
		if($assigned_user_id == 9) {
			$account->assigned_user_name = "seed_will";
		} else if($assigned_user_id == 10) {
			$account->assigned_user_name = "seed_chris";
		} else {
            $account->assigned_user_name = "seed_jim";
        }

		$account->assigned_user_id = $account->assigned_user_name."_id";
	} else {
		$account->billing_address_state = "CA";
		$assigned_user_id = mt_rand(6,8);
		if($assigned_user_id == 6) {
			$account->assigned_user_name = "seed_sarah";
		} elseif($assigned_user_id == 7) {
			$account->assigned_user_name = "seed_sally";
		} else {
			$account->assigned_user_name = "seed_max";
		}

		$account->assigned_user_id = $account->assigned_user_name."_id";
	}

	// If this is a large scale test, switch to the bulk teams 90% of the time.
	if ($large_scale_test) {
		$assigned_team = $team_demo_data->get_random_team();
		$account->assigned_user_id = $account->team_id;
		$account->assigned_user_name = $assigned_team;
		if(mt_rand(0,100) < 90) {
		  $account->team_id = $assigned_team;
		  $account->team_set_id = $account->team_id;
		} else {
		  $account->team_id = $assigned_team;
		  $teams = $team_demo_data->get_random_teamset();
		  $account->load_relationship('teams');
		  $account->teams->add($teams);
		}
	} else if(mt_rand(0,100) < 50) {
		$account->team_id = $account->billing_address_state == "CA" ? "West" : "East";
		$teams = $team_demo_data->get_random_teamset();
		$account->load_relationship('teams');
		$account->teams->add($teams);
	} else {
		$account->team_id = $account->billing_address_state == "CA" ? "West" : "East";
		$account->team_set_id = $account->team_id;
	}
	$account->billing_address_postalcode = mt_rand(10000, 99999);
	$account->billing_address_country = 'USA';
	$account->shipping_address_street = $account->billing_address_street;
	$account->shipping_address_city = $account->billing_address_city;
	$account->shipping_address_state = $account->billing_address_state;
	$account->shipping_address_postalcode = $account->billing_address_postalcode;
	$account->shipping_address_country = $account->billing_address_country;
	$account->industry = array_rand($app_list_strings['industry_dom']);
	$account->account_type = "Customer";
	$account->save();
	$account_ids[] = $account->id;
	$accounts[] = $account;

    for($c = 0; $c < $number_cases; $c++) {
	// Create a case for the account
	$case = new aCase();
	$case->account_id = $account->id;
	$case->priority = array_rand($app_list_strings['case_priority_dom']);
	$case->status = array_rand($app_list_strings['case_status_dom']);
	$case->type = array_rand($app_list_strings['case_type_dom']);
	$case->name = $sugar_demodata['case_seed_names'][mt_rand(0,4)];
	$case->assigned_user_id = $account->assigned_user_id;
	$case->assigned_user_name = $account->assigned_user_name;
	$case->team_id = $account->team_id;
	$case->team_set_id = $account->team_set_id;
	$case->save();
    }
	// Create a bug for the account
	$bug = new Bug();
	$bug->account_id = $account->id;
	$bug->priority = array_rand($app_list_strings['bug_priority_dom']);
	$bug->status = array_rand($app_list_strings['bug_status_dom']);
	$bug->type = array_rand($app_list_strings['bug_type_dom']);
	$bug->name = $sugar_demodata['bug_seed_names'][mt_rand(0,4)];
	$bug->assigned_user_id = $account->assigned_user_id;
	$bug->assigned_user_name = $account->assigned_user_name;
	$bug->team_id = $account->team_id;
	$bug->team_set_id = $account->team_set_id;
	$bug->save();

	$note = new Note();
	$note->parent_type = 'Accounts';
	$note->parent_id = $account->id;
	$seed_data_index = mt_rand(0,3);
	$note->name = $sugar_demodata['note_seed_names_and_Descriptions'][$seed_data_index][0];
	$note->description = $sugar_demodata['note_seed_names_and_Descriptions'][$seed_data_index][1];
	$note->assigned_user_id = $account->assigned_user_id;
	$note->assigned_user_name = $account->assigned_user_name;
	$note->team_id = $account->team_id;
	$note->team_set_id = $account->team_set_id;
	$note->save();

	$call = new Call();
	$call->parent_type = 'Accounts';
	$call->parent_id = $account->id;
	$call->name = $sugar_demodata['call_seed_data_names'][mt_rand(0,3)];
	$call->assigned_user_id = $account->assigned_user_id;
	$call->assigned_user_name = $account->assigned_user_name;
	$call->direction='Outbound';
	$call->date_start = create_date(). ' ' . create_time();
	$call->duration_hours='0';
	$call->duration_minutes='30';
	$call->account_id =$account->id;
    if (key($app_list_strings['call_status_dom']) === null) {
        reset($app_list_strings['call_status_dom']);
    }
    $call->status = current($app_list_strings['call_status_dom']);
    next($app_list_strings['call_status_dom']);
	$call->team_id = $account->team_id;
	$call->team_set_id = $account->team_set_id;
	$call->save();

    //Set the user to accept the call
    $seed_user->id = $call->assigned_user_id;
    $call->set_accept_status($seed_user,'accept');
}

$titles = $sugar_demodata['titles'];
$account_max = count($account_ids) - 1;
$first_name_max = $first_name_count - 1;
$last_name_max = $last_name_count - 1;
$street_address_max = $street_address_count - 1;
$city_array_max = $city_array_count - 1;
$lead_source_max = count($app_list_strings['lead_source_dom']) - 1;
$lead_status_max = count($app_list_strings['lead_status_dom']) - 1;
$title_max = count($titles) - 1;
///////////////////////////////////////////////////////////////////////////////
////	DEMO CONTACTS

$contacts = array();
for($i=0; $i<$number_contacts; $i++) {
	$contact = new Contact();
	$contact->first_name = $sugar_demodata['first_name_array'][mt_rand(0,$first_name_max)];
	$contact->last_name = $sugar_demodata['last_name_array'][mt_rand(0,$last_name_max)];
	$contact->assigned_user_id = $account->assigned_user_id;
	$contact->primary_address_street = $sugar_demodata['street_address_array'][mt_rand(0,$street_address_max)];
	$contact->primary_address_city = $sugar_demodata['city_array'][mt_rand(0,$city_array_max)];
	$contact->lead_source = array_rand($app_list_strings['lead_source_dom']);
	$contact->title = $titles[mt_rand(0,$title_max)];
	$contact->emailAddress->addAddress(createEmailAddress(), true, true);
	$contact->emailAddress->addAddress(createEmailAddress(), false, false, false, true);
	$assignedUser = new User();
	$assignedUser->retrieve($contact->assigned_user_id);
/* comment out the non-pro code
for($i=0; $i<1000; $i++)
{
	$contact->assigned_user_id = $assigned_user_id;
	$contact->email1 = createEmailAddress();
	$key = array_rand($sugar_demodata['street_address_array']);
	$contact->primary_address_street = $sugar_demodata['street_address_array'][$key];
	$key = array_rand($sugar_demodata['city_array']);
	$contact->primary_address_city = $sugar_demodata['city_array'][$key];
	$contact->lead_source = array_rand($app_list_strings['lead_source_dom']);
	$contact->title = $titles[array_rand($titles)];

*/
	$contact->phone_work = create_phone_number();
	$contact->phone_home = create_phone_number();
	$contact->phone_mobile = create_phone_number();
	$account_number = mt_rand(0,$account_max);
	$account_id = $account_ids[$account_number];
	// Fill in a bogus address
	$contacts_account = $accounts[$account_number];
	$contact->primary_address_state = $contacts_account->billing_address_state;
	$contact->team_id = $contacts_account->team_id;
	$contact->team_set_id = $contacts_account->team_set_id;
	$contact->assigned_user_id = $contacts_account->assigned_user_id;
	$contact->assigned_user_name = $contacts_account->assigned_user_name;
	$contact->primary_address_postalcode = mt_rand(10000,99999);
	$contact->primary_address_country = 'USA';
	$contact->save();
    $contacts[] = $contact->id;
	// Create a linking table entry to assign an account to the contact.
	$contact->set_relationship('accounts_contacts', array('contact_id'=>$contact->id ,'account_id'=> $account_id), false);

	//Create new tasks
	$task = new Task();
	$key = array_rand($sugar_demodata['task_seed_data_names']);
	$task->name = $sugar_demodata['task_seed_data_names'][$key];
	//separate date and time field have been merged into one.
	$task->date_due = create_date() . ' ' . create_time();
	$task->date_due_flag = 0;
	$task->team_id = $contacts_account->team_id;
	$task->team_set_id = $contacts_account->team_set_id;
	$task->assigned_user_id = $contacts_account->assigned_user_id;
	$task->assigned_user_name = $contacts_account->assigned_user_name;
	$task->priority = array_rand($app_list_strings['task_priority_dom']);
	$task->status = array_rand($app_list_strings['task_status_dom']);
	$task->contact_id = $contact->id;
	if ($contact->primary_address_city == "San Mateo") {
		$task->parent_id = $account_id;
		$task->parent_type = 'Accounts';
	}
	$task->save();

	//Create new meetings
	$meeting = new Meeting();
	$key = array_rand($sugar_demodata['meeting_seed_data_names']);
	$meeting->name = $sugar_demodata['meeting_seed_data_names'][$key];
	$meeting->date_start = create_date(). ' ' . create_time();
	//$meeting->time_start = date("H:i",time());
	$meeting->duration_hours = array_rand($possible_duration_hours_arr);
	$meeting->duration_minutes = array_rand($possible_duration_minutes_arr);
	$meeting->assigned_user_id = $assigned_user_id;
	$meeting->team_id = $contacts_account->team_id;
	$meeting->team_set_id = $contacts_account->team_set_id;
	$meeting->assigned_user_id = $contacts_account->assigned_user_id;
	$meeting->assigned_user_name = $contacts_account->assigned_user_name;
	$meeting->description = $sugar_demodata['meeting_seed_data_descriptions'];
	$meeting->status = array_rand($app_list_strings['meeting_status_dom']);
	$meeting->contact_id = $contact->id;
	$meeting->parent_id = $account_id;
	$meeting->parent_type = 'Accounts';
    // dont update vcal
    $meeting->update_vcal  = false;
	$meeting->save();
	// leverage the seed user to set the acceptance status on the meeting.
	$seed_user->id = $meeting->assigned_user_id;
    $meeting->set_accept_status($seed_user,'accept');

	//Create new emails
	$email = new Email();
	$key = array_rand($sugar_demodata['email_seed_data_subjects']);
	$email->name = $sugar_demodata['email_seed_data_subjects'][$key];
	$email->date_start = create_date();
	$email->time_start = create_time();
	$email->duration_hours = array_rand($possible_duration_hours_arr);
	$email->duration_minutes = array_rand($possible_duration_minutes_arr);
	$email->assigned_user_id = $assigned_user_id;
	$email->team_id = $contacts_account->team_id;
	$email->team_set_id = $contacts_account->team_set_id;
	$email->assigned_user_id = $contacts_account->assigned_user_id;
	$email->assigned_user_name = $contacts_account->assigned_user_name;
	$email->description = $sugar_demodata['email_seed_data_descriptions'];
	$email->status = 'sent';
	$email->parent_id = $account_id;
	$email->parent_type = 'Accounts';
	$email->to_addrs = $contact->emailAddress->getPrimaryAddress($contact);
	$email->from_addr = $assignedUser->emailAddress->getPrimaryAddress($assignedUser);
	$email->from_addr_name = $email->from_addr;
	$email->to_addrs_names = $email->to_addrs;
    if (key($sugar_demodata['email_seed_data_types']) === null) {
        reset($sugar_demodata['email_seed_data_types']);
    }
    $email->type = current($sugar_demodata['email_seed_data_types']);
    next($sugar_demodata['email_seed_data_types']);
	$email->save();
	$email->load_relationship('contacts');
	$email->contacts->add($contact);
	$email->load_relationship('accounts');
	$email->accounts->add($contacts_account);
}

for($i=0; $i<$number_leads; $i++)
{
	$lead = new Lead();
	$lead->account_name = $sugar_demodata['company_name_array'][mt_rand(0,$company_name_count-1)];
	$lead->first_name = $sugar_demodata['first_name_array'][mt_rand(0,$first_name_max)];
	$lead->last_name = $sugar_demodata['last_name_array'][mt_rand(0,$last_name_max)];
	$lead->primary_address_street = $sugar_demodata['street_address_array'][mt_rand(0,$street_address_max)];
	$lead->primary_address_city = $sugar_demodata['city_array'][mt_rand(0,$city_array_max)];
	$lead->lead_source = array_rand($app_list_strings['lead_source_dom']);
	$lead->title = $sugar_demodata['titles'][mt_rand(0,$title_max)];
	$lead->phone_work = create_phone_number();
	$lead->phone_home = create_phone_number();
	$lead->phone_mobile = create_phone_number();
	$lead->emailAddress->addAddress(createEmailAddress(), true);
	// Fill in a bogus address
	$lead->primary_address_state = $sugar_demodata['primary_address_state'];
	$leads_account = $accounts[$account_number];
	$lead->primary_address_state = $leads_account->billing_address_state;
	$lead->status = array_rand($app_list_strings['lead_status_dom']);
	if ($lead->status === 'Converted') {
		$lead->converted = true;
	}
	$lead->lead_source = array_rand($app_list_strings['lead_source_dom']);
	if($i % 3 == 1)
	{
		$lead->billing_address_state = $sugar_demodata['billing_address_state']['east'];
			$assigned_user_id = mt_rand(9,10);
			if($assigned_user_id == 9)
			{
				$lead->assigned_user_name = "seed_will";
				$lead->assigned_user_id = $lead->assigned_user_name."_id";
			}
			else
			{
				$lead->assigned_user_name = "seed_chris";
				$lead->assigned_user_id = $lead->assigned_user_name."_id";
			}

			$lead->assigned_user_id = $lead->assigned_user_name."_id";
		}
		else
		{
			$lead->billing_address_state = $sugar_demodata['billing_address_state']['west'];
			$assigned_user_id = mt_rand(6,8);
			if($assigned_user_id == 6)
			{
				$lead->assigned_user_name = "seed_sarah";
			}
			else if($assigned_user_id == 7)
			{
				$lead->assigned_user_name = "seed_sally";
			}
			else
			{
				$lead->assigned_user_name = "seed_max";
			}

			$lead->assigned_user_id = $lead->assigned_user_name."_id";
		}


	// If this is a large scale test, switch to the bulk teams 90% of the time.
	if ($large_scale_test)
	{
		if(mt_rand(0,100) < 90) {
			$assigned_team = $team_demo_data->get_random_team();
			$lead->team_id = $assigned_team;
			$lead->assigned_user_id = $account->assigned_user_id;
			$lead->assigned_user_name = $assigned_team;
		}
        else {

			$teams = $team_demo_data->get_random_teamset();
			$lead->load_relationship('teams');
			$lead->teams->add($teams);
			$lead->assigned_user_id = $account->assigned_user_id;
		}
	}
    else {
    	if(mt_rand(0,100) < 50) {
    		$lead->team_id = $lead->billing_address_state == "CA" ? "West" : "East";
			$teams = $team_demo_data->get_random_teamset();
			$lead->load_relationship('teams');
			$lead->teams->add($teams);
    	} else {
			$lead->team_id = $lead->billing_address_state == "CA" ? "West" : "East";
			$lead->team_set_id = $lead->team_id;
    	}
	}
	$lead->primary_address_postalcode = mt_rand(10000,99999);
	$lead->primary_address_country = $sugar_demodata['primary_address_country'];
	$lead->save();
}


foreach($sugar_demodata['manufacturer_seed_data_names'] as $v){
	$manufacturer = new Manufacturer;
	$manufacturer->name = $v;
	$manufacturer->status = "Active";
	$manufacturer->list_order = "1";
	$manufacturer->save();
	$manufacturer_id_arr[] = $manufacturer->id;
}
$list_order = 1;
foreach($sugar_demodata['shipper_seed_data_names'] as $v){
	$shipper = new Shipper;
	$shipper->name = $v;
	$shipper->status = "Active";
	$shipper->list_order = $list_order;
	$list_order++;
	$shipper->save();
	$ship_id_arr[] = $shipper->id;
}

foreach($sugar_demodata['productcategory_seed_data_names'] as $v){
	$category = new ProductCategory;
	$category->name = $v;
	$category->list_order = "1";
    $key = array_rand($sugar_demodata['users']);
    $category->assigned_user_id = $sugar_demodata['users'][$key]['id'];
	$category->save();
	$productcategory_id_arr[] = $category->id;
}
$list_order = 1;
foreach($sugar_demodata['producttype_seed_data_names'] as $v){
	$type = new ProductType;
	$type->name = $v;
	$type->list_order = $list_order;
	$type->save();
	$producttype_id_arr[] = $type->id;
	$list_order++;
}
foreach($sugar_demodata['taxrate_seed_data'] as $v){
	$taxrate = new TaxRate;
	$taxrate->name = $v['name'];
	$taxrate->value = $v['value'];
	$taxrate->status = "Active";
	$taxrate->list_order = "1";
	$taxrate->disable_num_format = TRUE;
	$taxrate->save();
	$taxrate_id_arr[] = $taxrate->id;
};




foreach($sugar_demodata['currency_seed_data'] as $v){
	if ( $v['name'] == $_SESSION["default_currency_name"] )
		continue;
	$currency = new Currency;
	$currency->name = $v['name'];
	$currency->status = "Active";
	$currency->conversion_rate = $v['conversion_rate'];
	$currency->iso4217 = $v['iso4217'];
	$currency->symbol = $v['symbol'];
	$currency->save();
}
$dollar_id = '-99';
//$tekkyware_id = $manufacturer->id;
//$widgetworld_id = $manufacturer->id;
//$fedex_id = $shipper->id;
//$usps_id = $shipper->id;
//$desktops_id = $category->id;
//$laptops_id = $category->id;
//$stationary_id = $category->id;
//$wobbly_id = $category->id;
//$widgets_id = $type->id;
//$hardware_id = $type->id;
//$support_id = $type->id;
//$taxrate_id = $taxrate->id;
//$euro_id = $currency->id;
foreach($sugar_demodata['producttemplate_seed_data'] as $v){
	$manufacturer_id_max = count($manufacturer_id_arr) - 1;
	$productcategory_id_max = count($productcategory_id_arr) - 1;
	$producttype_id_max = count($producttype_id_arr) - 1;
	$template = new ProductTemplate;
	$template->manufacturer_id = $manufacturer_id_arr[mt_rand(0,$manufacturer_id_max)];
	$template->category_id = $productcategory_id_arr[mt_rand(0,$manufacturer_id_max)];
	$template->type_id = $producttype_id_arr[mt_rand(0,$manufacturer_id_max)];
	$template->currency_id = $dollar_id;
	$template->name = $v['name'];
	$template->tax_class = $v['tax_class'];
	$template->cost_price = $v['cost_price'];
	$template->cost_usdollar = $v['cost_usdollar'];
	$template->list_price = $v['list_price'];
	$template->list_usdollar = $v['list_usdollar'];
	$template->discount_price = $v['discount_price'];
	$template->discount_usdollar = $v['discount_usdollar'];
	$template->pricing_formula = $v['pricing_formula'];
	$template->mft_part_num = $v['mft_part_num'];
	$template->pricing_factor = $v['pricing_factor'];
	$template->status = $v['status'];
	$template->weight = $v['weight'];
	$template->date_available = $v['date_available'];
	$template->qty_in_stock = $v['qty_in_stock'];
	$template->save();
}
include_once('modules/TeamNotices/DefaultNotices.php');
///
/// SEED DATA FOR CONTRACTS
///
include_once('modules/Contracts/Contract.php');
foreach($sugar_demodata['contract_seed_data'] as $v){
	$contract = new Contract();
    $contract->currency_id = '-99';
	$contract->name = $v['name'];
	$contract->reference_code = $v['reference_code'];
	$contract->status = 'signed';
	$contract->account_id = $account->id;
	$contract->total_contract_value = $v['total_contract_value'];
	$contract->team_id = 1;
	$contract->assigned_user_id = 'seed_will_id';
	$contract->start_date = $v['start_date'];
	$contract->end_date = $v['end_date'];
	$contract->company_signed_date = $v['company_signed_date'];
	$contract->customer_signed_date = $v['customer_signed_date'];
	$contract->description = $v['description'];
	$contract->save();
}

///
/// SEED DATA FOR KNOWLEDGE BASE
///
$kbtags_hash = array();
foreach($sugar_demodata['kbdocument_seed_data_kbtags'] as $v){
    $kbtag = new KBTag;
    $kbtag->tag_name = $v;
    $id = $kbtag->save();
    $kbtags_hash[$id] = $v;
}

foreach($sugar_demodata['kbdocument_seed_data'] as $v){
	$kbdoc = new KBDocument();
	$kbdoc->kbdocument_name = $v['name'];
	$kbdoc->status_id = 'Published';
	$kbdoc->team_id = 1;
	$kbdoc->assigned_user_id = 'seed_will_id';
	$kbdoc->active_date = $v['start_date'];
	$kbdoc->exp_date = $v['exp_date'];
	$kbdoc->save();

	$kbdocRevision = new KBDocumentRevision;
	$kbdocRevision->change_log = translate('DEF_CREATE_LOG','KBDocuments');
	$kbdocRevision->revision = '1';
	$kbdocRevision->kbdocument_id = $kbdoc->id;
	$kbdocRevision->latest = true;
	$kbdocRevision->save();

	$docRevision = new DocumentRevision();
	$docRevision->filename = $kbdoc->kbdocument_name;
	$docRevision->save();

    $kbdocContent = new KBContent();
    $kbdocContent->document_revision_id = $docRevision->id;
    $kbdocContent->team_id = $kbdoc->team_id;
	$kbdocContent->kbdocument_body = $v['body'];
	$kbdocContent->save();

	$kbdocRevision->kbcontent_id = $kbdocContent->id;
    $kbdocRevision->document_revision_id = $docRevision->id;
    $kbdocRevision->save();

    $kbdoc->kbdocument_revision_id = $kbdocRevision->id;
	$kbdoc->save();

	foreach ($v['tags'] as $tag) {
	    $kbdocKBTag = new KBDocumentKBTag();
	    $kbdocKBTag->kbtag_id = array_search($tag,$kbtags_hash);
	    $kbdocKBTag->kbdocument_id = $kbdoc->id;
	    $kbdocKBTag->team_id = $kbdoc->team_id;
	    $kbdocKBTag->save();
	}
}


///
/// SEED DATA FOR EMAIL TEMPLATES
///
if(!empty($sugar_demodata['emailtemplates_seed_data'])) {
	foreach($sugar_demodata['emailtemplates_seed_data'] as $v){
	    $EmailTemp = new EmailTemplate();
	    $EmailTemp->name = $v['name'];
	    $EmailTemp->description = $v['description'];
	    $EmailTemp->subject = $v['subject'];
	    $EmailTemp->body = $v['text_body'];
	    $EmailTemp->body_html = $v['body'];
	    $EmailTemp->deleted = 0;
	    $EmailTemp->team_id = 1;
	    $EmailTemp->published = 'off';
	    $EmailTemp->text_only = 0;
	    $id =$EmailTemp->save();
	}
}


    include('install/seed_data/products_SeedData.php');
    include('install/seed_data/quotes_SeedData.php');
    //include('install/seed_data/opportunities_SeedData.php');

    //This is set to yes at the begininning of this file
	unset($_SESSION['disable_workflow']);

    require_once('modules/Opportunities/OpportunitiesSeedData.php');

    //$products = $account->build_related_list('SELECT id FROM revenue_line_items', new RevenueLineItem(), 0, 50);
    $opportunity_ids = OpportunitiesSeedData::populateSeedData($number_companies*3, $app_list_strings, $accounts, $sugar_demodata['users']);

    foreach($contacts as $id)
    {
        $contact->retrieve($id);
        // This assumes that there will be one opportunity per company in the seed data.
        $opportunity_key = array_rand($opportunity_ids);
        $contact->set_relationship('opportunities_contacts', array('contact_id'=>$contact->id ,'opportunity_id'=> $opportunity_ids[$opportunity_key], 'contact_role'=>$app_list_strings['opportunity_relationship_type_default_key']), false);
    }

    require_once('modules/Forecasts/ForecastsSeedData.php');
    ForecastsSeedData::populateSeedData($timeperiods);




    include('install/seed_data/ForecastTreeSeedData.php');
    ForecastTreeSeedData::populateUserSeedData();
