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

/*********************************************************************************

 * Description: class for sanitizing field values
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/
require_once('modules/Import/sources/ImportFile.php');

class ImportFieldSanitize
{
    /**
     * properties set to handle locale formatting
     */
    public $dateformat;
    public $timeformat;
    public $timezone;
    public $currency_symbol;
    public $default_currency_significant_digits;
    public $num_grp_sep;
    public $dec_sep;
    public $default_locale_name_format;

    /**
     * array of modules/users_last_import ids pairs that are created in this class
     * needs to be reset after the row is imported
     */
    public static $createdBeans = array();

    /**
     * true if we will create related beans during the sanitize process
     */
    public $addRelatedBean = false;
    
    /**
     * Checks the SugarField defintion for an available santization method.
     *
     * @param  $value  string
     * @param  $vardef array
     * @param  $focus  object bean of the module we're importing into
     * @return string sanitized and validated value on success, bool false on failure
     */
    public function __call(
        $name,
        $params
        )
    {
        static $sfh;
        
        if(!isset($sfh)) {
            require_once('include/SugarFields/SugarFieldHandler.php');
            $sfh = new SugarFieldHandler();
        }
        $value = $params[0];
        $vardef = $params[1];
        if ( isset($params[2]) )
            $focus = $params[2];
        else
            $focus = null;
        if ( $name == 'relate' && !empty($params[3]) )
            $this->addRelatedBean = true;
        else
            $this->addRelatedBean = false;
        
        $field = $sfh->getSugarField(ucfirst($name));
        if ( $field instanceOf SugarFieldBase ) {
            $value = $field->importSanitize($value,$vardef,$focus,$this);
        }
        
        return $value;
    }

    /**
     * Validate date fields
     *
     * @param  $value  string
     * @param  $vardef array
     * @param  $focus  object bean of the module we're importing into
     * @return string sanitized and validated value on success, bool false on failure
     */
    public function date(
        $value,
        $vardef,
        &$focus
        )
    {
        global $timedate;

        $format = $this->dateformat;

        if ( !$timedate->check_matching_format($value, $format) )
            return false;

        if ( !$this->isValidTimeDate($value, $format) )
            return false;

        $value = $timedate->swap_formats(
            $value, $format, $timedate->get_date_format());

        return $value;
    }

    /**
     * Validate email fields
     *
     * @param  $value  string
     * @param  $vardef array
     * @param  $focus  object bean of the module we're importing into
     * @return string sanitized and validated value on success, bool false on failure
     */
    public function email(
        $value,
        $vardef
        )
    {
        
        if ( !empty($value) && !SugarEmailAddress::isValidEmail($value) ) {
            return false;
        }

        return $value;
    }

    /**
     * Validate sync_to_outlook field
     *
     * @param  $value     string
     * @param  $vardef    array
     * @param  $bad_names array used to return list of bad users/teams in $value
     * @return string sanitized and validated value on success, bool false on failure
     */
    public function synctooutlook(
        $value,
        $vardef,
        &$bad_names
        )
    {
        static $focus_user;

        // cache this object since we'll be reusing it a bunch
        if ( !($focus_user instanceof User) ) {

            $focus_user = BeanFactory::getBean('Users');
        }

        static $focus_team;

        // cache this object since we'll be reusing it a bunch
        if ( !($focus_team instanceof Team) ) {

            $focus_team = BeanFactory::getBean('Teams');
        }

        if ( !empty($value) && strtolower($value) != "all" ) {
            $theList   = explode(",",$value);
            $isValid   = true;
            $bad_names = array();
            foreach ($theList as $eachItem) {
                if ( $focus_user->retrieve_user_id($eachItem)
                        || $focus_user->retrieve($eachItem)
                        || $focus_team->retrieve($eachItem)
                        || $focus_team->retrieve_team_id($eachItem)
                ) {
                    // all good
                }
                else {
                    $isValid     = false;
                    $bad_names[] = $eachItem;
                    continue;
                }
            }
            if(!$isValid) {
                return false;
            }
        }

        return $value;
    }

    /**
     * Validate time fields
     *
     * @param  $value    string
     * @param  $vardef   array
     * @param  $focus  object bean of the module we're importing into
     * @return string sanitized and validated value on success, bool false on failure
     */
    public function time(
        $value,
        $vardef,
        $focus
        )
    {
        global $timedate;

        $format = $this->timeformat;

        if ( !$timedate->check_matching_format($value, $format) )
            return false;

        if ( !$this->isValidTimeDate($value, $format) )
            return false;

        $value = $timedate->swap_formats(
            $value, $format, $timedate->get_time_format());
        $value = $timedate->handle_offset(
            $value, $timedate->get_time_format(), false, $GLOBALS['current_user'], $this->timezone);
        $value = $timedate->handle_offset(
            $value, $timedate->get_time_format(), true);

        return $value;
    }

    /**
     * Added to handle Bug 24104, to make sure the date/time value is correct ( i.e. 20/20/2008 doesn't work )
     *
     * @param  $value  string
     * @param  $format string
     * @return string sanitized and validated value on success, bool false on failure
     */
    public function isValidTimeDate(
        $value,
        $format
        )
    {
        global $timedate;

        $dateparts = array();
        $reg = $timedate->get_regular_expression($format);
        preg_match('@'.$reg['format'].'@', $value, $dateparts);

        if ( empty($dateparts) )
            return false;
        if ( isset($reg['positions']['a'])
                && !in_array($dateparts[$reg['positions']['a']], array('am','pm')) )
            return false;
        if ( isset($reg['positions']['A'])
                && !in_array($dateparts[$reg['positions']['A']], array('AM','PM')) )
            return false;
        if ( isset($reg['positions']['h']) && (
                !is_numeric($dateparts[$reg['positions']['h']])
                || $dateparts[$reg['positions']['h']] < 1
                || $dateparts[$reg['positions']['h']] > 12 ) )
            return false;
        if ( isset($reg['positions']['H']) && (
                !is_numeric($dateparts[$reg['positions']['H']])
                || $dateparts[$reg['positions']['H']] < 0
                || $dateparts[$reg['positions']['H']] > 23 ) )
            return false;
        if ( isset($reg['positions']['i']) && (
                !is_numeric($dateparts[$reg['positions']['i']])
                || $dateparts[$reg['positions']['i']] < 0
                || $dateparts[$reg['positions']['i']] > 59 ) )
            return false;
        if ( isset($reg['positions']['s']) && (
                !is_numeric($dateparts[$reg['positions']['s']])
                || $dateparts[$reg['positions']['s']] < 0
                || $dateparts[$reg['positions']['s']] > 59 ) )
            return false;
        if ( isset($reg['positions']['d']) && (
                !is_numeric($dateparts[$reg['positions']['d']])
                || $dateparts[$reg['positions']['d']] < 1
                || $dateparts[$reg['positions']['d']] > 31 ) )
            return false;
        if ( isset($reg['positions']['m']) && (
                !is_numeric($dateparts[$reg['positions']['m']])
                || $dateparts[$reg['positions']['m']] < 1
                || $dateparts[$reg['positions']['m']] > 12 ) )
            return false;
        if ( isset($reg['positions']['Y']) &&
                !is_numeric($dateparts[$reg['positions']['Y']]) )
            return false;

        return true;
    }

}
