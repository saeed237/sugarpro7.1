<?php
//FILE SUGARCRM flav=pro
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


/**
 * UsersViewQuickEdit.php
 * @author Collin Lee
 *
 * This class is a view extension of the include/MVC/View/views/view.edit.php file.  We are overriding the ViewQuickEdit class because the
 * Users module quick edit treatment has some specialized behavior during the save operation.  In particular, if the user's status is set to
 * Inactive, this needs to trigger a dialog to reassign records.  The quick edit functionality was introduced into the Users module in the 6.4 release.
 *
 */
require_once('include/MVC/View/views/view.quickedit.php');
require_once('include/EditView/EditView2.php');

class UsersViewQuickedit extends ViewQuickEdit
{
    /**
     * @var footerTpl String variable of the Smarty template file used to render the footer portion.  Override here to allow for record reassignment.
     */
    protected $footerTpl = 'modules/Users/tpls/QuickEditFooter.tpl';


    /**
     * @var defaultButtons Array of default buttons assigned to the form (see function.sugar_button.php)
     * We will still take the DCMENUCANCEL and DCMENUFULLFORM buttons, but we inject our own Save button via the QuickEditFooter.tpl file
     */
    protected $defaultButtons = array('DCMENUCANCEL', 'DCMENUFULLFORM');

}