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

require_once('include/SugarFields/Fields/Datetime/SugarFieldDatetime.php');

class SugarFieldDate extends SugarFieldDatetime {

    /**
     * Handles export field sanitizing for field type
     *
     * @param $value string value to be sanitized
     * @param $vardef array representing the vardef definition
     * @param $focus SugarBean object
     * @param $row Array of a row of data to be exported
     *
     * @return string sanitized value
     */
    public function exportSanitize($value, $vardef, $focus, $row=array())
    {
        $timedate = TimeDate::getInstance();
        $db = DBManagerFactory::getInstance();
        //If it's in ISO format, convert it to db format
        if(preg_match('/(\d{4})\-?(\d{2})\-?(\d{2})T(\d{2}):?(\d{2}):?(\d{2})\.?\d*([Z+-]?)(\d{0,2}):?(\d{0,2})/i', $value)) {
           $value = $timedate->fromIso($value)->asDbDate(false);
        }

        return $timedate->to_display_date($db->fromConvert($value, 'date'), false);
    }

    /**
     * @param $value
     * @param $fieldName
     * @param SugarBean $bean
     * @param SugarQuery $q
     * @param SugarQuery_Builder_Where $where
     * @param $op
     * @return bool
     */
    public function fixForFilter(&$value, $fieldName, SugarBean $bean, SugarQuery $q, SugarQuery_Builder_Where $where, $op) {
        return true;
    }

    /**
     * pass value through
     * @param $value
     * @return string
     */
    public function apiUnformat($value) {
        return $value;
    }

}
