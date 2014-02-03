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

 ********************************************************************************/

global $mod_strings;

if ($current_user->is_admin)
{
    require_once('modules/Currencies/ListCurrency.php');
    $lc = new ListCurrency();
    $lc->handleDelete();
    $lc->handleAdd();
    $lc->handleUpdate();
    echo $lc->getTable();
}
else
{
    echo $mod_strings['LBL_ADMIN_ONLY'];
}

?>
