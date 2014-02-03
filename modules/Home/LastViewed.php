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

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



global $theme;
global $current_user;


// Create the head of the table.
?>
		<table cellpadding="2" cellspacing="0" border="0">
		
<?php
$current_row=1;
$tracker = BeanFactory::getBean('Trackers');
$history = $tracker->get_recently_viewed($current_user->id);

foreach($history as $row)
{
    $moduleImage = SugarThemeRegistry::current()->getImageURL("{$row['module_name']}.gif");
    echo <<<EOQ
        <tr>
          <td vAlign="top"><IMG width="20" alt="{$row['module_name']}" src="{$moduleImage}" border="0"></td>
          <td noWrap><A  href="index.php?module=$row[module_name]&action=DetailView&record=$row[item_id]">$row[item_summary]</A></td>
        </tr>
EOQ;
}
?>
</table>
