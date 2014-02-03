<?PHP
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


class OAuthTokensController extends SugarController
{
	protected function action_delete()
	{
	    global $current_user;
		//do any pre delete processing
		//if there is some custom logic for deletion.
		if(!empty($_REQUEST['record'])){
			if(!is_admin($current_user) && $this->bean->assigned_user_id != $current_user->id) {
                ACLController::displayNoAccess(true);
                sugar_cleanup(true);
			}
			$this->bean->mark_deleted($_REQUEST['record']);
        }else{
			sugar_die("A record number must be specified to delete");
		}
	}

	protected function post_delete()
	{
        if(!empty($_REQUEST['return_url'])){
            $_REQUEST['return_url'] =urldecode($_REQUEST['return_url']);
            $this->redirect_url = $_REQUEST['return_url'];
        } else {
            parent::post_delete();
        }
	}
}