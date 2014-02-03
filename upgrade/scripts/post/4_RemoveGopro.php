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
 * Remove "go pro" dashlet for CE->PRO
 */
class SugarUpgradeRemoveGopro extends UpgradeScript
{
    public $order = 4000;
    public $type = self::UPGRADE_DB;

    public function run()
    {
        if(!($this->from_flavor == 'ce' && $this->toFlavor('pro'))) return;

		$result = $this->db->query("SELECT id, contents, assigned_user_id FROM user_preferences WHERE deleted = 0 AND category = 'Home'");
		if(empty($result)) {
		    return $this->fail("Unable to upgrade dashlets");
		}
		while ($row = $this->db->fetchByAssoc($result)) {
			$content = unserialize(base64_decode($row['contents']));
			$assigned_user_id = $row['assigned_user_id'];
			$record_id = $row['id'];

			$current_user = BeanFactory::getBean('Users', $row['assigned_user_id']);

			if(!empty($content['dashlets']) && !empty($content['pages'])){
				$originalDashlets = $content['dashlets'];
				foreach($originalDashlets as $key => $ds){
				    if(!empty($ds['options']['url']) && stristr($ds['options']['url'],'http://www.sugarcrm.com/crm/product/gopro')){
						unset($originalDashlets[$key]);
					}
				}
				$current_user->setPreference('dashlets', $originalDashlets, 0, 'Home');
			}
		}
    }
}
