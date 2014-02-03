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




global $app_strings;
global $app_list_strings;
global $mod_strings;
global $currentModule;
global $gridline;

echo getClassicModuleTitle('MigrateFields', array($mod_strings['LBL_EXTERNAL_DEV_TITLE']), true);

?>
<p>
<table cellspacing="<?php echo $gridline;?>" class="other view">
<tr>
	<td scope="row"><?php echo SugarThemeRegistry::current()->getImage('ImportCustomFields','align="absmiddle" border="0"',null,null,'.gif',$mod_strings['LBL_IMPORT_CUSTOM_FIELDS_TITLE']); ?>&nbsp;<a href="./index.php?module=Administration&action=ImportCustomFieldStructure" class="tabDetailViewDL2Link"><?php echo $mod_strings['LBL_IMPORT_CUSTOM_FIELDS_TITLE']; ?></a></td>
	<td> <?php echo $mod_strings['LBL_IMPORT_CUSTOM_FIELDS'] ; ?> </td>
</tr>
<tr>
	<td scope="row"><?php echo SugarThemeRegistry::current()->getImage('ExportCustomFields','align="absmiddle" border="0"',null,null,'.gif',$mod_strings['LBL_EXPORT_CUSTOM_FIELDS_TITLE']); ?>&nbsp;<a href="./index.php?module=Administration&action=ExportCustomFieldStructure" class="tabDetailViewDL2Link"><?php echo $mod_strings['LBL_EXPORT_CUSTOM_FIELDS_TITLE']; ?></a></td>
	<td> <?php echo $mod_strings['LBL_EXPORT_CUSTOM_FIELDS'] ; ?> </td>
</tr>

</table></p>


