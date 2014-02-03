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





    global $json,$current_user;
    
    
    if ($_REQUEST['object_type'] == "Meeting")
    {
        $focus = BeanFactory::getBean('Meetings');
        $focus->id = $_REQUEST['object_id'];
        $test = $focus->set_accept_status($current_user, $_REQUEST['accept_status']);
    }
    else if ($_REQUEST['object_type'] == "Call")
    {
        $focus = BeanFactory::getBean('Calls');
        $focus->id = $_REQUEST['object_id'];
        $test = $focus->set_accept_status($current_user, $_REQUEST['accept_status']);
    }
    print 1;
    exit;
?>
