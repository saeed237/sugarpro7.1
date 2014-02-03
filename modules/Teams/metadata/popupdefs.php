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


$popupMeta = array('moduleMain' => 'Team',
						'varName' => 'TEAM',
						'orderBy' => 'teams.private, teams.name',
						'whereClauses' => 
							array('name' => 'teams.name', 'private' => 'teams.private'),
                        'whereStatement'=> "( teams.associated_user_id IS NULL OR teams.associated_user_id NOT IN ( SELECT id FROM users WHERE status = 'Inactive' OR portal_only = '1' ))",
						'searchInputs' =>
							array('name')
						);


?>
 
 