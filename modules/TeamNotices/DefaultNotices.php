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




$notices = array(
);


foreach($notices as $notice){
	$teamNotice = BeanFactory::getBean('TeamNotices');
	$teamNotice->name = $notice['name'];
	$teamNotice->description = $notice['description'];
	if(!empty($notice['url'])){
		$teamNotice->url = $notice['url'];
		$teamNotice->url_title = 'View '.$notice['name'];
	}
	$teamNotice->date_start = $timedate->nowDate();
	$teamNotice->date_end = $timedate->asUserDate($timedate->getNow()->get('+1 week'));
	$teamNotice->status = 'Visible';
	$teamNotice->save(false);
}

?>
