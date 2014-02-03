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


class HolidaysViewEdit extends ViewEdit 
{
    /**
	 * @see SugarView::display()
	 */
	public function display() 
	{
		global $beanFiles, $mod_strings;
		
		// the user admin (MLA) cannot edit any administrator holidays
		global $current_user;
		if(isset($_REQUEST['record'])){
	 		$result = $GLOBALS['db']->query("SELECT is_admin FROM users WHERE id=(SELECT person_id FROM holidays WHERE id='$_REQUEST[record]')");
			$row = $GLOBALS['db']->fetchByAssoc($result);
			if(!is_admin($current_user)&& $current_user->isAdminForModule('Users')&& $row['is_admin']==1){
				sugar_die('Unauthorized access');
			}
		}
		
		$this->ev->process();
 		echo $this->ev->display();
 	}
}
