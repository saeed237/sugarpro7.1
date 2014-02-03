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


echo getClassicModuleTitle('Customize Fields', array('Customize Fields'), false);

?>
<table cellspacing="<?php echo $gridline; ?>" class="other view">
<tr>
<td>
<form>
Module Name:
<select>
<?php
foreach($moduleList as $module)
{
   echo "<option>$module</option>";
}
?>
</select>
<input type="button" value="Edit" />
</form>
</td>
</tr>
</table>

