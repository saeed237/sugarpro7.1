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


require_once('modules/DynamicFields/templates/Fields/TemplateRange.php');

class TemplateDate extends TemplateRange
{
	var $type = 'date';
	var $len = '';
	var $dateStrings;

function __construct() {
	parent::__construct();
	global $app_strings;
	$this->dateStrings = array(
			$app_strings['LBL_NONE']=>'',
            $app_strings['LBL_YESTERDAY']=> '-1 day',
            $app_strings['LBL_TODAY']=>'now',
            $app_strings['LBL_TOMORROW']=>'+1 day',
            $app_strings['LBL_NEXT_WEEK']=> '+1 week',
            $app_strings['LBL_NEXT_MONDAY']=>'next monday',
            $app_strings['LBL_NEXT_FRIDAY']=>'next friday',
            $app_strings['LBL_TWO_WEEKS']=> '+2 weeks',
            $app_strings['LBL_NEXT_MONTH']=> '+1 month',
            $app_strings['LBL_FIRST_DAY_OF_NEXT_MONTH']=> 'first day of next month', // must handle this non-GNU date string in SugarBean->populateDefaultValues; if we don't this will evaluate to 1969...
            $app_strings['LBL_THREE_MONTHS']=> '+3 months',  //kbrill Bug #17023
            $app_strings['LBL_SIXMONTHS']=> '+6 months',
            $app_strings['LBL_NEXT_YEAR']=> '+1 year',
        );
}


function get_db_default($modify=false){
		return '';
}

//BEGIN BACKWARDS COMPATABILITY
function get_xtpl_edit(){
		global $timedate;
		$name = $this->name;
		$returnXTPL = array();
		if(!empty($this->help)){
		    $returnXTPL[strtoupper($this->name . '_help')] = translate($this->help, $this->bean->module_dir);
		}
		$returnXTPL['USER_DATEFORMAT'] = $timedate->get_user_date_format();
		$returnXTPL['CALENDAR_DATEFORMAT'] = $timedate->get_cal_date_format();
		if(isset($this->bean->$name)){
			$returnXTPL[strtoupper($this->name)] = $this->bean->$name;
		}else{
		    if(empty($this->bean->id) && !empty($this->default_value) && !empty($this->dateStrings[$this->default_value])){
		        $returnXTPL[strtoupper($this->name)] = $timedate->asUserDate($timedate->getNow(true)->modify($this->dateStrings[$this->default_value]), false);
		    }
		}
		return $returnXTPL;
	}

function get_field_def(){
		$def = parent::get_field_def();
		if(!empty($def['default'])){
			$def['display_default'] = $def['default'];
			$def['default'] = '';
		}
		return $def;
	}
}
?>
