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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
********************************************************************************/






global $app_strings;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;
$current_module_strings = return_module_language($current_language, 'ForecastSchedule');

global $currentModule;

global $theme;
global $action;




// focus_list is the means of passing data to a SubPanelView.
global $focus_list;
global $focus;

$button  = "<table cellspacing='0' cellpadding='1' border='0'><form border='0' action='index.php' method='post' name='subpanel' id='form'>\n";
$button .= "<input type='hidden' name='module' value='ForecastSchedule'>\n";
$button .= "<input type='hidden' name='timeperiod_id' value='$focus->id'>\n";
$button .= "<input type='hidden' name='timeperiod_name' value='$focus->name'>\n";
$button .= "<input type='hidden' name='start_date' value='$focus->start_date'>\n";
$button .= "<input type='hidden' name='end_date' value='$focus->end_date'>\n";
$button .= "<input type='hidden' name='return_module' value='ForecastSchedule'>\n";
$button .= "<input type='hidden' name='return_action' value='DetailView'>\n";
$button .= "<input type='hidden' name='return_id' value='".$focus->id."'>\n";
$button .= "<input type='hidden' name='action'>\n";
$button .= "<tr>";
$button .= "<td><input title='".$app_strings['LBL_NEW_BUTTON_TITLE']."'  class='button' onclick=\"this.form.action.value='EditView'\" type='submit' id='btn_save' name='button' value='".$app_strings['LBL_NEW_BUTTON_LABEL']."'></td>\n";
$button .= "</tr></form></table>\n";

// Stick the form header out there.
echo get_form_header($current_module_strings['LBL_SVFS_HEADER'], $button, false);


$return_url = "&return_action=DetailView&return_module=TimePeriods&return_id=".$focus->id;

$seeddata = BeanFactory::getBean('ForecastSchedule');
$ListView = new ListView();
$ListView->show_export_button=false;
$ListView->show_delete_button = false;
$ListView->show_select_menu = false;
$ListView->initNewXTemplate('modules/ForecastSchedule/SubPanelViewForecastSchedule.html',$current_module_strings);
$ListView->display_header_and_footer = false;
$ListView->setQuery(" timeperiod_id = '$focus->id'","","","");
$ListView->xTemplateAssign("RETURN_URL", $return_url);
$ListView->processListView($seeddata, "main", "SCHEDULE");

?>