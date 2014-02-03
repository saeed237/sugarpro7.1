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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once("include/OutboundEmail/OutboundEmail.php");

class UsersController extends SugarController
{
	protected function action_login()
	{
		if (isset($_REQUEST['mobile']) && $_REQUEST['mobile'] == 1) {
			$_SESSION['isMobile'] = true;
			$this->view = 'wirelesslogin';
		}
		else{
			$this->view = 'login';
		}
	}

	protected function action_authenticate()
	{
	    $this->view = 'authenticate';
	}

	protected function action_default()
	{
		if (isset($_REQUEST['mobile']) && $_REQUEST['mobile'] == 1){
			$_SESSION['isMobile'] = true;
			$this->view = 'wirelesslogin';
		}
		else{
			$this->view = 'classic';
		}
	}

    /**
     * Triggers reset preferences for a given user.
     *
     * If the user is resetting his own preferences, make sure he logs out to
     * have full refresh settings coming up (he was warned already).
     * If an admin is resetting other user's preferences, redirect him back to
     * that user's detail view.
     */
    protected function action_resetPreferences()
    {
        if (!($_REQUEST['record'] == $GLOBALS['current_user']->id || ($GLOBALS['current_user']->isAdminForModule('Users')))) {
            return;
        }

        $user = BeanFactory::getBean('Users', $_REQUEST['record']);
        $user->resetPreferences();

        if ($user->id !== $GLOBALS['current_user']->id) {
            SugarApplication::redirect("index.php?module=Users&record=" . $_REQUEST['record'] . "&action=DetailView"); //bug 48170]
        }
        echo '<script>parent.SUGAR.App.router.navigate("logout/?clear=1", {trigger: true});</script>';
    }

	protected function action_delete()
	{
	    if($_REQUEST['record'] != $GLOBALS['current_user']->id && ($GLOBALS['current_user']->isAdminForModule('Users')
            ))
        {
            $u = BeanFactory::getBean('Users', $_REQUEST['record']);
            $u->status = 'Inactive';
            $u->deleted = 1;
            $u->employee_status = 'Terminated';
            $u->save();
            $GLOBALS['log']->info("User id: {$GLOBALS['current_user']->id} deleted user record: {$_REQUEST['record']}");

            $eapm = BeanFactory::getBean('EAPM');
            $eapm->delete_user_accounts($_REQUEST['record']);
            $GLOBALS['log']->info("Removing user's External Accounts");

            if($u->portal_only == '0'){
                SugarApplication::redirect("index.php?module=Users&action=reassignUserRecords&record={$u->id}");
            }
            else{
                SugarApplication::redirect("index.php?module=Users&action=index");
            }
        }
        else
            sugar_die("Unauthorized access to administration.");
	}
	/**
	 * Clear the reassign user records session variables.
	 *
	 */
	protected function action_clearreassignrecords()
	{
        if( $GLOBALS['current_user']->isAdminForModule('Users'))
            unset($_SESSION['reassignRecords']);
        else
	       sugar_die("You cannot access this page.");
	}

	protected function action_wirelessmain()
	{
		$this->view = 'wirelessmain';
	}
	protected function action_wizard()
	{
		$this->view = 'wizard';
	}

	protected function action_saveuserwizard()
	{
	    global $current_user, $sugar_config;

	    // set all of these default parameters since the Users save action will undo the defaults otherwise
	    $_POST['record'] = $current_user->id;
	    $_POST['is_admin'] = ( $current_user->is_admin ? 'on' : '' );
	    $_POST['use_real_names'] = true;
	    $_POST['reminder_checked'] = '1';
	    $_POST['reminder_time'] = 1800;
        $_POST['mailmerge_on'] = 'on';
        $_POST['receive_notifications'] = $current_user->receive_notifications;
        $_POST['user_theme'] = (string) SugarThemeRegistry::getDefault();

	    // save and redirect to new view
	    $_REQUEST['return_module'] = 'Home';
	    $_REQUEST['return_action'] = 'index';
		require('modules/Users/Save.php');
	}

    protected function action_saveftsmodules()
    {
        $this->view = 'fts';
        $GLOBALS['current_user']->setPreference('fts_disabled_modules', $_REQUEST['disabled_modules']);
    }
}
?>
