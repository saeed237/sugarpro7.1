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





class SubPanelViewNotes {
	
var $notes_list = null;
var $hideNewButton = false;
var $focus;

function setFocus(&$value){
	$this->focus =(object) $value;		
}


function setNotesList(&$value){
	$this->notes_list =$value;		
}

function setHideNewButton($value){
	$this->hideNewButton = $value;	
}

function SubPanelViewNotes(){
	global $theme;
}

function getHeaderText($action, $currentModule){
	global $app_strings;
	$button  = "<table cellspacing='0' cellpadding='0' border='0'><form border='0' action='index.php' method='post' name='form' id='form'>\n";
	$button .= "<input type='hidden' name='module' value='Notes'>\n";
	if ($currentModule == 'Products') {
		$button .= "<input type='hidden' name='contact_id' value='".$this->focus->contact_id."'>\n";
		$button .= "<input type='hidden' name='contact_name' value='".$this->focus->contact_name."'>\n";
		$button .= "<input type='hidden' name='parent_id' value='".$this->focus->id."'>\n";
		$button .= "<input type='hidden' name='parent_type' value='Products'>\n";
		$button .= "<input type='hidden' name='parent_name' value='".$this->focus->name."'>\n";
		$button .= "<input type='hidden' name='return_module' value='".$currentModule."'>\n";
		$button .= "<input type='hidden' name='return_action' value='".$action."'>\n";
		$button .= "<input type='hidden' name='return_id' value='".$this->focus->id."'>\n";
		$button .= "<input type='hidden' name='action'>\n";
		$button .= "<tr>";
	}
	if(!$this->hideNewButton){
		$button .= "<td><input title='".$app_strings['LBL_NEW_BUTTON_TITLE']."' class='button' onclick=\"this.form.action.value='EditView'\" type='submit' name='button' value='  ".$app_strings['LBL_NEW_BUTTON_LABEL']."  '></td>\n";
	}
	$button .= "</tr></form></table>\n";
	return $button;
}

function ProcessSubPanelListView($xTemplatePath, &$mod_strings,$action, $curModule=''){
	global $currentModule,$app_strings;
	if(empty($curModule))
		$curModule = $currentModule;
	$ListView = new ListView();
	global $current_user;
$header_text = '';
if(is_admin($current_user) && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])){	
		$header_text = "&nbsp;<a href='index.php?action=index&module=DynamicLayout&from_action=SubPanelView&from_module=Notes&record=". $this->focus->id."'>".SugarThemeRegistry::current()->getImage("EditLayout","border='0' align='bottom'",null,null,'.gif',$mod_strings['LBL_EDITLAYOUT'])."</a>";
}
	$ListView->initNewXTemplate($xTemplatePath,$mod_strings);
	$ListView->xTemplateAssign("RETURN_URL", "&return_module=".$curModule."&return_action=DetailView&return_id=".$this->focus->id);
	$ListView->xTemplateAssign("DELETE_INLINE_PNG",  SugarThemeRegistry::current()->getImage('delete_inline','align="absmiddle" border="0"',null,null,'.gif',$app_strings['LNK_DELETE']));
	$ListView->xTemplateAssign("EDIT_INLINE_PNG",  SugarThemeRegistry::current()->getImage('edit_inline','align="absmiddle"  border="0"',null,null,'.gif',$app_strings['LNK_EDIT']));
	$ListView->xTemplateAssign("RECORD_ID",  $this->focus->id);
	$ListView->setHeaderTitle($mod_strings['LBL_MODULE_NAME']. $header_text);
	$ListView->setHeaderText($this->getHeaderText($action, $curModule));
	$ListView->processListView($this->notes_list, "notes", "NOTE");
}

}
?>