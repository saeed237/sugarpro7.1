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


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/VarDefHandler/VarDefHandler.php');

class LeadsVarDefHandler extends VarDefHandler
{
    /**
     * Overriden to filter legacy pre-5.1 calls and meetings 
     * @see VarDefHandler::get_vardef_array()
     */
    public function get_vardef_array($use_singular=false, $remove_dups = false, $use_field_name = false, $use_field_label = false)
    {
        $options_array = parent::get_vardef_array($use_singular, $remove_dups, $use_field_name, $use_field_label);
        if ($this->meta_array_name == 'rel_filter')
            unset($options_array['oldcalls'], $options_array['oldmeetings']);
        return $options_array;
    }
}