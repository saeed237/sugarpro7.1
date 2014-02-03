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


if (isset($_SESSION['authenticated_user_id']))
{
    ob_clean();
    header('Location: ' . $GLOBALS['app']->getLoginRedirect());
    sugar_cleanup(true);
    return;
}

// display the logged out screen
$smarty = new Sugar_Smarty();
$smarty->assign(array(
    'LOGIN_URL'  => 'index.php?action=Login&module=Users',
    'STYLESHEET' => getJSPath('modules/Users/login.css'),
));
$smarty->display('modules/Users/LoggedOut.tpl');
