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




require_once('modules/Campaigns/utils.php');

if (!empty($_REQUEST['remove'])) clean_string($_REQUEST['remove'], "STANDARD");
if (!empty($_REQUEST['from'])) clean_string($_REQUEST['from'], "STANDARD");

if(!empty($_REQUEST['identifier'])) {
    global $beanFiles, $beanList, $current_user;

    //user is most likely not defined, retrieve admin user so that team queries are bypassed
    if(empty($current_user) || empty($current_user->id)){
            $current_user = BeanFactory::getBean('Users', '1');
    }

    $keys=log_campaign_activity($_REQUEST['identifier'],'removed');
    global $current_language;
    $mod_strings = return_module_language($current_language, 'Campaigns');


    if (!empty($keys) && $keys['target_type'] == 'Users'){
        //Users cannot opt out of receiving emails, print out warning message.
        echo $mod_strings['LBL_USERS_CANNOT_OPTOUT'];
     }elseif(!empty($keys) && isset($keys['campaign_id']) && !empty($keys['campaign_id'])){
        //we need to unsubscribe the user from this particular campaign
        $focus = BeanFactory::getBean($keys['target_type'], $keys['target_id']
        , array('disable_row_level_security' => true)
        );
        unsubscribe($keys['campaign_id'], $focus);

    }elseif(!empty($keys)){
		$id = $keys['target_id'];
		$db = DBManagerFactory::getInstance();
		$id = $db->quote($id);

		//no opt out for users.
		if(preg_match('/^[0-9A-Za-z\-]*$/', $id) && $module != 'Users'){
            //record this activity in the campaing log table..
			$query = "UPDATE email_addresses SET email_addresses.opt_out = 1 WHERE EXISTS(SELECT 1 FROM email_addr_bean_rel ear WHERE ear.bean_id = '$id' AND ear.deleted=0 AND email_addresses.id = ear.email_address_id)";
			$status=$db->query($query);
			if($status){
				echo "*";
			}
		}
    }
		//Print Confirmation Message.
		echo $mod_strings['LBL_ELECTED_TO_OPTOUT'];

}
sugar_cleanup();
?>
