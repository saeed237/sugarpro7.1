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

 
function create_default_roles() {
    
// Adding MLA Roles
$mlaRoles = array(
     'Sales Administrator'=>array(
         'Accounts'=>array('admin'=>100, 'access'=>89),
         'Contacts'=>array('admin'=>100, 'access'=>89),
         'Forecasts'=>array('admin'=>100, 'access'=>89),
         'ForecastSchedule'=>array('admin'=>100, 'access'=>89),
         'Leads'=>array('admin'=>100, 'access'=>89),
         'Quotes'=>array('admin'=>100, 'access'=>89),
         'Opportunities'=>array('admin'=>100, 'access'=>89),
     ),
     'Marketing Administrator'=>array(
         'Accounts'=>array('admin'=>100, 'access'=>89),
         'Contacts'=>array('admin'=>100, 'access'=>89),
         'Campaigns'=>array('admin'=>100, 'access'=>89),
         'ProspectLists'=>array('admin'=>100, 'access'=>89),
         'Leads'=>array('admin'=>100, 'access'=>89),
         'Prospects'=>array('admin'=>100, 'access'=>89),
     ),
     'Customer Support Administrator'=>array(
         'Accounts'=>array('admin'=>100, 'access'=>89),
         'Contacts'=>array('admin'=>100, 'access'=>89),
         'Bugs'=>array('admin'=>100, 'access'=>89),
         'Cases'=>array('admin'=>100, 'access'=>89),
         'KBDocuments'=>array('admin'=>100, 'access'=>89),
        )
);
global $db;
addDefaultRoles($mlaRoles);   
}
?>