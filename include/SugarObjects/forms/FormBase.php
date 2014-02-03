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


/**
 * FormBase.php
 *
 * @author Collin Lee
 *
 * This is an abstract class to provide common functionality across the form base code used in the application.
 *
 * @see LeadFormBase.php, ContactFormBase.php, MeetingFormBase, CallFormBase.php
 */

abstract class FormBase {


/**
 * isSaveFromDCMenu
 *
 * This is a function to help assist in determining if a save operation has been performed from the DCMenu (the shortcut bar
 * up top available for most themes).
 *
 * @return bool Boolean value indicating whether or not the save operation was triggered from DCMenu
 */
protected function isSaveFromDCMenu()
{
    return (isset($_POST['from_dcmenu']) && $_POST['from_dcmenu']);
}


/**
 * isEmptyReturnModuleAndAction
 *
 * This is a function to help assist in determining if a save operation has been performed without a return module and action specified.
 * This will likely be the case where we use AJAX to change the state of a record, but wish to keep the user remaining on the same view.
 * For example, this is true when closing Calls and Meetings from dashlets or from from subpanels.
 *
 * @return bool Boolean value indicating whether or not a return module and return action are specified in request
 */
protected function isEmptyReturnModuleAndAction()
{
    return empty($_POST['return_module']) && empty($_POST['return_action']);
}


}
 
