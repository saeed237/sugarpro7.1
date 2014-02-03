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


require_once('include/MVC/View/views/view.detail.php');

class LeadsViewDetail extends ViewDetail
{

    function display()
    {
        global $sugar_config;

        //If the convert lead action has been disabled for already converted leads, disable the action link.
        $disableConvert = ($this->bean->status == 'Converted' && !empty($sugar_config['disable_convert_lead'])) ? TRUE : FALSE;
        $this->ss->assign("DISABLE_CONVERT_ACTION", $disableConvert);
        parent::display();
    }
}
