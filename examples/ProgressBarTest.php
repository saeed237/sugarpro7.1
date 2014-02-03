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

ob_start();
require_once('../include/utils/progress_bar_utils.php');
display_flow_bar('myflow', 1);

display_progress_bar('myprogress',0, 10);
for($i = 0; $i <= 10; $i++){
update_progress_bar('myprogress',$i, 10);
sleep(1);
}
destroy_flow_bar('myflow');
?>