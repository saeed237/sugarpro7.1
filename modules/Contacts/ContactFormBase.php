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

 * Description:  Base form for contact
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/SugarObjects/forms/PersonFormBase.php');

class ContactFormBase extends PersonFormBase {

var $moduleName = 'Contacts';
var $objectName = 'Contact';

/**
 * getDuplicateQuery
 *
 * This function returns the SQL String used for initial duplicate Contacts check
 *
 * @see checkForDuplicates (method), ContactFormBase.php, LeadFormBase.php, ProspectFormBase.php
 * @param $focus sugarbean
 * @param $prefix String value of prefix that may be present in $_POST variables
 * @return SQL String of the query that should be used for the initial duplicate lookup check
 */
public function getDuplicateQuery($focus, $prefix='')
{

	$query = 'SELECT contacts.id, contacts.first_name, contacts.last_name, contacts.title FROM contacts ';

    // Bug #46427 : Records from other Teams shown on Potential Duplicate Contacts screen during Lead Conversion
    // add team security
    if( !empty($focus) && !$focus->disable_row_level_security )
    {
        $focus->add_team_security_where_clause($query);
    }

    $query .= ' where contacts.deleted = 0 AND ';

	if(isset($_POST[$prefix.'first_name']) && strlen($_POST[$prefix.'first_name']) != 0 && isset($_POST[$prefix.'last_name']) && strlen($_POST[$prefix.'last_name']) != 0){
		$query .= " contacts.first_name LIKE '". $_POST[$prefix.'first_name'] . "%' AND contacts.last_name = '". $_POST[$prefix.'last_name'] ."'";
	} else {
		$query .= " contacts.last_name = '". $_POST[$prefix.'last_name'] ."'";
	}

	if(!empty($_POST[$prefix.'record'])) {
		$query .= " AND  contacts.id != '". $_POST[$prefix.'record'] ."'";
	}
    return $query;
}


function getWideFormBody($prefix, $mod='',$formname='',  $contact = '', $portal = true){

	if(!ACLController::checkAccess('Contacts', 'edit', true)){
		return '';
	}

	if(empty($contact)){
        $contact = $this->getContact();
	}

	global $mod_strings;
	$temp_strings = $mod_strings;
	if(!empty($mod)){
		global $current_language;
		$mod_strings = return_module_language($current_language, $mod);
	}
	global $app_strings;
	global $current_user;
	global $app_list_strings;
	$primary_address_country_options = get_select_options_with_id($app_list_strings['countries_dom'], $contact->primary_address_country);
	$lbl_required_symbol = $app_strings['LBL_REQUIRED_SYMBOL'];
	$lbl_first_name = $mod_strings['LBL_FIRST_NAME'];
	$lbl_last_name = $mod_strings['LBL_LAST_NAME'];
	$lbl_phone = $mod_strings['LBL_OFFICE_PHONE'];
	$lbl_address =  $mod_strings['LBL_PRIMARY_ADDRESS'];

	if (isset($contact->assigned_user_id)) {
		$user_id=$contact->assigned_user_id;
	} else {
		$user_id = $current_user->id;
	}
	if (isset($contact->team_id)) {
		$team_id=$contact->team_id;
	} else {
		$team_id=$current_user->default_team;
	}

	//Retrieve Email address and set email1, email2
	$sugarEmailAddress = BeanFactory::getBean('EmailAddresses');
	$sugarEmailAddress->handleLegacyRetrieve($contact);
  	if(!isset($contact->email1)){
    	$contact->email1 = '';
    }
    if(!isset($contact->email2)){
    	$contact->email2 = '';
    }
    if(!isset($contact->email_opt_out)){
    	$contact->email_opt_out = '';
    }
	$lbl_email_address = $mod_strings['LBL_EMAIL_ADDRESS'];
	$salutation_options=get_select_options_with_id($app_list_strings['salutation_dom'], $contact->salutation);

	if (isset($contact->lead_source)) {
		$lead_source_options=get_select_options_with_id($app_list_strings['lead_source_dom'], $contact->lead_source);
	} else {
		$lead_source_options=get_select_options_with_id($app_list_strings['lead_source_dom'], '');
	}

	$form="";
	$form .=  "<input type=hidden name=".$prefix."team_id value=".$team_id.">";



	if ($formname == 'ConvertProspect') {
		$lead_source_label = "<td scope='row'>&nbsp;</td>";
		$lead_source_field = "<td >&nbsp;</td>";
	} else {
		$lead_source_label = "<td scope='row' nowrap>${mod_strings['LBL_LEAD_SOURCE']}</td>";
		$lead_source_field = "<td ><select name='${prefix}lead_source'>$lead_source_options</select></td>";
	}


global $timedate;
$birthdate = '';
if(!empty($_REQUEST['birthdate'])){
    	$birthdate=$_REQUEST['birthdate'];
   }


$jsCalendarImage = SugarThemeRegistry::current()->getImageURL('jscalendar.gif');
$ntc_date_format = $timedate->get_user_date_format();
$cal_dateformat = $timedate->get_cal_date_format();
$lbl_required_symbol = $app_strings['LBL_REQUIRED_SYMBOL'];

$form .= <<<EOQ
		<input type="hidden" name="${prefix}record" value="">
		<input type="hidden" name="${prefix}assigned_user_id" value='${user_id}'>
		<table border='0' celpadding="0" cellspacing="0" width='100%'>
		<tr>
		<td nowrap scope='row'>$lbl_first_name</td>
		<td scope='row'>$lbl_last_name&nbsp;<span class="required">$lbl_required_symbol</span></td>
		<td scope='row' nowrap>${mod_strings['LBL_TITLE']}</td>
		<td scope='row' nowrap>${mod_strings['LBL_DEPARTMENT']}</td>
		</tr>
		<tr>
		<td ><select name='${prefix}salutation'>$salutation_options</select>&nbsp;<input name="${prefix}first_name" type="text" value="{$contact->first_name}"></td>
		<td ><input name='${prefix}last_name' type="text" value="{$contact->last_name}"></td>
		<td  nowrap><input name='${prefix}title' type="text" value="{$contact->title}"></td>
		<td  nowrap><input name='${prefix}department' type="text" value="{$contact->department}"></td>
		</tr>
		<tr>
		<td nowrap colspan='4' scope='row'>$lbl_address</td>
		</tr>

		<tr>
		<td nowrap colspan='4' ><textarea cols='80' rows='2' name='${prefix}primary_address_street'>{$contact->primary_address_street}</textarea></td>
		</tr>

		<tr>
		<td scope='row'>${mod_strings['LBL_CITY']}</td>
		<td scope='row'>${mod_strings['LBL_STATE']}</td>
		<td scope='row'>${mod_strings['LBL_POSTAL_CODE']}</td>
		<td scope='row'>${mod_strings['LBL_COUNTRY']}</td>
		</tr>

		<tr>
		<td ><input name='${prefix}primary_address_city'  maxlength='100' value='{$contact->primary_address_city}'></td>
		<td ><input name='${prefix}primary_address_state'  maxlength='100' value='{$contact->primary_address_state}'></td>
		<td ><input name='${prefix}primary_address_postalcode'  maxlength='100' value='{$contact->primary_address_postalcode}'></td>
		<td ><input name='${prefix}primary_address_country'  maxlength='100' value='{$contact->primary_address_country}'></td>
		</tr>


		<tr>
		<td nowrap scope='row'>$lbl_phone</td>
		<td nowrap scope='row'>${mod_strings['LBL_MOBILE_PHONE']}</td>
		<td nowrap scope='row'>${mod_strings['LBL_FAX_PHONE']}</td>
		<td nowrap scope='row'>${mod_strings['LBL_HOME_PHONE']}</td>
		</tr>

		<tr>
		<td nowrap ><input name='${prefix}phone_work' type="text" value="{$contact->phone_work}"></td>
		<td nowrap ><input name='${prefix}phone_mobile' type="text" value="{$contact->phone_mobile}"></td>
		<td nowrap ><input name='${prefix}phone_fax' type="text" value="{$contact->phone_fax}"></td>
		<td nowrap ><input name='${prefix}phone_home' type="text" value="{$contact->phone_home}"></td>
		</tr>

		<tr>
		<td scope='row' nowrap>${mod_strings['LBL_OTHER_PHONE']}</td>
		$lead_source_label

		<td scope="row">${mod_strings['LBL_BIRTHDATE']}&nbsp;</td>
		</tr>


		<tr>
		<td  nowrap><input name='${prefix}phone_other' type="text" value="{$contact->phone_other}"></td>
		$lead_source_field

		<td  nowrap>
			<input name='{$prefix}birthdate' onblur="parseDate(this, '$cal_dateformat');" size='12' maxlength='10' id='${prefix}jscal_field' type="text" value="{$birthdate}">&nbsp;
			<!--not_in_theme!--><img src="{$jsCalendarImage}" alt="{$app_strings['LBL_ENTER_DATE']}"  id="${prefix}jscal_trigger" align="absmiddle">
		</td>
		</tr>

EOQ;

$form .= $sugarEmailAddress->getEmailAddressWidgetEditView($contact->id, $_REQUEST['action']=='ConvertLead'?'Leads':'Contacts', false, 'include/SugarEmailAddress/templates/forWideFormBodyView.tpl');

require_once('include/SugarFields/Fields/Text/SugarFieldText.php');
$sugarfield = new SugarFieldText('Text');
$description_text = $sugarfield->getClassicEditView('description', $contact->description, $prefix, true);

$form .= <<<EOQ
		<tr>
		<td nowrap colspan='4' scope='row'>${mod_strings['LBL_DESCRIPTION']}</td>
		</tr>
		<tr>
		<td nowrap colspan='4' >{$description_text}</td>
		</tr>
EOQ;



	//carry forward custom lead fields common to contacts during Lead Conversion
    $tempContact = $this->getContact();

	if (method_exists($contact, 'convertCustomFieldsForm')) $contact->convertCustomFieldsForm($form, $tempContact, $prefix);
	unset($tempContact);

$form .= <<<EOQ
		</table>

		<input type='hidden' name='${prefix}alt_address_street'  value='{$contact->alt_address_street}'>
		<input type='hidden' name='${prefix}alt_address_city' value='{$contact->alt_address_city}'><input type='hidden' name='${prefix}alt_address_state'   value='{$contact->alt_address_state}'><input type='hidden' name='${prefix}alt_address_postalcode'   value='{$contact->alt_address_postalcode}'><input type='hidden' name='${prefix}alt_address_country'  value='{$contact->alt_address_country}'>
		<input type='hidden' name='${prefix}do_not_call'  value='{$contact->do_not_call}'>
		<input type='hidden' name='${prefix}email_opt_out'  value='{$contact->email_opt_out}'>
EOQ;

	if ($portal == true){
		if (isset($contact->portal_name)) {
			$form.="<input type='hidden' name='${prefix}portal_name'  value='{$contact->portal_name}'>";
		} else {
			$form.="<input type='hidden' name='${prefix}portal_name'  value=''>";
		}
		if (isset($contact->portal_app)) {
			$form.="<input type='hidden' name='${prefix}portal_app'  value='{$contact->portal_app}'>";
		} else {
			$form.="<input type='hidden' name='${prefix}portal_app'  value=''>";
		}


		if(!empty($contact->portal_name) && !empty($contact->portal_app)){
			$form .= "<input name='${prefix}portal_active' type='hidden' size='25'  value='1' >";
		}

	    if(isset($contact->portal_password)){
	        $form.="<input type='password' name='${prefix}portal_password1'  value='{$contact->portal_password}'>";
	        $form.="<input type='password' name='${prefix}portal_password'  value='{$contact->portal_password}'>";
	        $form .= "<input name='${prefix}old_portal_password' type='hidden' size='25'  value='{$contact->portal_password}' >";
	    }else{
	        $form.="<input type='password' name='${prefix}portal_password1'  value=''>";
	        $form.="<input type='password' name='${prefix}portal_password'  value=''>";
	        $form .= "<input name='${prefix}old_portal_password' type='hidden' size='25'  value='' >";
	    }
	}

$form .= <<<EOQ
			<script type="text/javascript">
				Calendar.setup ({
				inputField : "{$prefix}jscal_field", daFormat : "$cal_dateformat", ifFormat : "$cal_dateformat", showsTime : false, button : "{$prefix}jscal_trigger", singleClick : true, step : 1, weekNumbers:false
				});
			</script>
EOQ;



	$javascript = new javascript();
	$javascript->setFormName($formname);
	$javascript->setSugarBean($this->getContact());
	$javascript->addField('email1','false',$prefix);
	$javascript->addField('email2','false',$prefix);
	$javascript->addRequiredFields($prefix);

	$form .=$javascript->getScript();
	$mod_strings = $temp_strings;


	return $form;
}

function getFormBody($prefix, $mod='', $formname=''){
	if(!ACLController::checkAccess('Contacts', 'edit', true)){
		return '';
	}
global $mod_strings;
$temp_strings = $mod_strings;
if(!empty($mod)){
	global $current_language;
	$mod_strings = return_module_language($current_language, $mod);
}
		global $app_strings;
		global $current_user;
		$lbl_required_symbol = $app_strings['LBL_REQUIRED_SYMBOL'];
		$lbl_first_name = $mod_strings['LBL_FIRST_NAME'];
		$lbl_last_name = $mod_strings['LBL_LAST_NAME'];
		$lbl_phone = $mod_strings['LBL_PHONE'];
		$user_id = $current_user->id;
		$lbl_email_address = $mod_strings['LBL_EMAIL_ADDRESS'];
if ($formname == 'EmailEditView')
{
		$form = <<<EOQ
		<input type="hidden" name="${prefix}record" value="">
		<input type="hidden" name="${prefix}email2" value="">
		<input type="hidden" name="${prefix}phone_work" value="">
		<input type="hidden" name="${prefix}assigned_user_id" value='${user_id}'>
		$lbl_first_name<br>
		<input name="${prefix}first_name" type="text" value="" size=10><br>
		$lbl_last_name&nbsp;<span class="required">$lbl_required_symbol</span><br>
		<input name='${prefix}last_name' type="text" value="" size=10><br>
		$lbl_email_address&nbsp;<span class="required">$lbl_required_symbol</span><br>
		<input name='${prefix}email1' type="text" value=""><br><br>

EOQ;
}
else
{
		$form = <<<EOQ
		<input type="hidden" name="${prefix}record" value="">
		<input type="hidden" name="${prefix}email2" value="">
		<input type="hidden" name="${prefix}assigned_user_id" value='${user_id}'>
		$lbl_first_name<br>
		<input name="${prefix}first_name" type="text" value=""><br>
		$lbl_last_name&nbsp;<span class="required">$lbl_required_symbol</span><br>
		<input name='${prefix}last_name' type="text" value=""><br>
		$lbl_phone<br>
		<input name='${prefix}phone_work' type="text" value=""><br>
		$lbl_email_address<br>
		<input name='${prefix}email1' type="text" value=""><br><br>

EOQ;
}


$javascript = new javascript();
$javascript->setFormName($formname);
$javascript->setSugarBean($this->getContact());
$javascript->addField('email1','false',$prefix);
$javascript->addRequiredFields($prefix);

$form .=$javascript->getScript();
$mod_strings = $temp_strings;
return $form;

}
function getForm($prefix, $mod=''){
	if(!ACLController::checkAccess('Contacts', 'edit', true)){
		return '';
	}
if(!empty($mod)){
	global $current_language;
	$mod_strings = return_module_language($current_language, $mod);
}else global $mod_strings;
global $app_strings;

$lbl_save_button_title = $app_strings['LBL_SAVE_BUTTON_TITLE'];
$lbl_save_button_key = $app_strings['LBL_SAVE_BUTTON_KEY'];
$lbl_save_button_label = $app_strings['LBL_SAVE_BUTTON_LABEL'];


$the_form = get_left_form_header($mod_strings['LBL_NEW_FORM_TITLE']);
$the_form .= <<<EOQ

		<form name="${prefix}ContactSave" onSubmit="return check_form('${prefix}ContactSave')" method="POST" action="index.php">
			<input type="hidden" name="${prefix}module" value="Contacts">
			<input type="hidden" name="${prefix}action" value="Save">
EOQ;
$the_form .= $this->getFormBody($prefix,'Contacts', "${prefix}ContactSave");
$the_form .= <<<EOQ
		<input title="$lbl_save_button_title" accessKey="$lbl_save_button_key" class="button" type="submit" name="${prefix}button" value="  $lbl_save_button_label  " >
		</form>

EOQ;
$the_form .= get_left_form_footer();
$the_form .= get_validate_record_js();

return $the_form;


}

/**
 * @deprecated
 */
function handleSave($prefix, $redirect=true, $useRequired=false){
    global $log;
    $log->deprecated('This function handleSave() is no longer supported.');

    global $theme, $current_user;


	require_once('include/formbase.php');

	global $timedate;

	$focus = $this->getContact();

	if($useRequired &&  !checkRequired($prefix, array_keys($focus->required_fields))){
		return null;
	}

	if (!empty($_POST[$prefix.'new_reports_to_id'])) {
		$focus->retrieve($_POST[$prefix.'new_reports_to_id']);
		$focus->reports_to_id = $_POST[$prefix.'record'];
	} else {

        $focus = populateFromPost($prefix, $focus);
        $oldPassword = null;

        if (isset($focus->id)) {
            $contact = BeanFactory::getBean('Contacts', $focus->id);
            $oldPassword = $contact->portal_password;
        }

        // update password
        if (!empty($focus->portal_password) && $focus->portal_password != $oldPassword && $focus->portal_password != 'value_setvalue_setvalue_set') {
            $focus->portal_password = User::getPasswordHash($focus->portal_password);
        // clear password
        } elseif(empty($focus->portal_password)){
            $focus->portal_password = null;
        // keep existing password
        } else {
            $focus->portal_password = $oldPassword;
        }

		if (!isset($_POST[$prefix.'email_opt_out'])) $focus->email_opt_out = 0;
		if (!isset($_POST[$prefix.'do_not_call'])) $focus->do_not_call = 0;

	}
	if(!$focus->ACLAccess('Save')){
			ACLController::displayNoAccess(true);
			sugar_cleanup(true);
	}
	if($_REQUEST['action'] != 'BusinessCard' && $_REQUEST['action'] != 'ConvertLead' && $_REQUEST['action'] != 'ConvertProspect')
	{
		if (isset($_POST[$prefix.'sync_contact'])){
		    $focus->sync_contact = $_POST[$prefix.'sync_contact'];
		}
	}

	if (isset($GLOBALS['check_notify'])) {
		$check_notify = $GLOBALS['check_notify'];
	}
	else {
		$check_notify = false;
	}


	if (empty($_POST['record']) && empty($_POST['dup_checked'])) {

		$duplicateContacts = $this->checkForDuplicates($prefix);
		if(isset($duplicateContacts)){
			$location='module=Contacts&action=ShowDuplicates';
			$get = '';
			if(isset($_POST['inbound_email_id']) && !empty($_POST['inbound_email_id'])) {
				$get .= '&inbound_email_id='.$_POST['inbound_email_id'];
			}

			// Bug 25311 - Add special handling for when the form specifies many-to-many relationships
			if(isset($_POST['relate_to']) && !empty($_POST['relate_to'])) {
				$get .= '&Contactsrelate_to='.$_POST['relate_to'];
			}
			if(isset($_POST['relate_id']) && !empty($_POST['relate_id'])) {
				$get .= '&Contactsrelate_id='.$_POST['relate_id'];
			}

			//add all of the post fields to redirect get string
			foreach ($focus->column_fields as $field)
			{
				if (!empty($focus->$field) && !is_object($focus->$field))
				{
					$get .= "&Contacts$field=".urlencode($focus->$field);
				}
			}

			foreach ($focus->additional_column_fields as $field)
			{
				if (!empty($focus->$field))
				{
					$get .= "&Contacts$field=".urlencode($focus->$field);
				}
			}

			if($focus->hasCustomFields()) {
				foreach($focus->field_defs as $name=>$field) {
					if (!empty($field['source']) && $field['source'] == 'custom_fields')
					{
						$get .= "&Contacts$name=".urlencode($focus->$name);
					}
				}
			}


			$emailAddress = BeanFactory::getBean('EmailAddresses');
			$get .= $emailAddress->getFormBaseURL($focus);

			$get .= get_teams_url('Contacts');

			//create list of suspected duplicate contact id's in redirect get string
			$i=0;
			foreach ($duplicateContacts as $contact)
			{
				$get .= "&duplicate[$i]=".$contact['id'];
				$i++;
			}

			//add return_module, return_action, and return_id to redirect get string
			$get .= "&return_module=";
			if(!empty($_POST['return_module'])) $get .= $_POST['return_module'];
			else $get .= "Contacts";
			$get .= "&return_action=";
			if(!empty($_POST['return_action'])) $get .= $_POST['return_action'];
			//else $get .= "DetailView";
			if(!empty($_POST['return_id'])) $get .= "&return_id=".$_POST['return_id'];
			if(!empty($_POST['popup'])) $get .= '&popup='.$_POST['popup'];
			if(!empty($_POST['create'])) $get .= '&create='.$_POST['create'];

			// for InboundEmail flow
			if(!empty($_POST['start'])) $get .= '&start='.$_POST['start'];


            $_SESSION['SHOW_DUPLICATES'] = $get;
            //now redirect the post to modules/Contacts/ShowDuplicates.php
            if (!empty($_POST['is_ajax_call']) && $_POST['is_ajax_call'] == '1')
            {
            	ob_clean();
                $json = getJSONobj();
                echo $json->encode(array('status' => 'dupe', 'get' => $location));
            }
            else if(!empty($_REQUEST['ajax_load']))
            {
                echo "<script>SUGAR.ajaxUI.loadContent('index.php?$location');</script>";
            }
            else {
                if(!empty($_POST['to_pdf'])) $location .= '&to_pdf='.$_POST['to_pdf'];
                header("Location: index.php?$location");
            }
            return null;
		}
	}


	///////////////////////////////////////////////////////////////////////////////
	////	INBOUND EMAIL HANDLING
	///////////////////////////////////////////////////////////////////////////////
	if(isset($_REQUEST['inbound_email_id']) && !empty($_REQUEST['inbound_email_id'])) {
		// fake this case like it's already saved.
		$focus->save($check_notify);

		$email = BeanFactory::getBean('Emails', $_REQUEST['inbound_email_id']);
		$email->parent_type = 'Contacts';
		$email->parent_id = $focus->id;
		$email->assigned_user_id = $current_user->id;
		$email->status = 'read';
		$email->save();
		$email->load_relationship('contacts');
		$email->contacts->add($focus->id);

		header("Location: index.php?&module=Emails&action=EditView&type=out&inbound_email_id=".$_REQUEST['inbound_email_id']."&parent_id=".$email->parent_id."&parent_type=".$email->parent_type.'&start='.$_REQUEST['start'].'&assigned_user_id='.$current_user->id);
		exit();
	}
	////	END INBOUND EMAIL HANDLING
	///////////////////////////////////////////////////////////////////////////////

	$focus->save($check_notify);
	$return_id = $focus->id;

	$GLOBALS['log']->debug("Saved record with id of ".$return_id);

    if ($redirect && !empty($_POST['is_ajax_call']) && $_POST['is_ajax_call'] == '1') {
        $json = getJSONobj();
        echo $json->encode(array('status' => 'success',
                                 'get' => ''));
    	$trackerManager = TrackerManager::getInstance();
        $timeStamp = TimeDate::getInstance()->nowDb();
        if($monitor = $trackerManager->getMonitor('tracker')){
	        $monitor->setValue('team_id', $GLOBALS['current_user']->getPrivateTeamID());
	        $monitor->setValue('action', 'detailview');
	        $monitor->setValue('user_id', $GLOBALS['current_user']->id);
	        $monitor->setValue('module_name', 'Contacts');
	        $monitor->setValue('date_modified', $timeStamp);
	        $monitor->setValue('visible', 1);

	        if (!empty($this->bean->id)) {
	            $monitor->setValue('item_id', $return_id);
	            $monitor->setValue('item_summary', $focus->get_summary_text());
	        }
			$trackerManager->saveMonitor($monitor, true, true);
		}
        return null;
    }

	if($redirect && isset($_POST['popup']) && $_POST['popup'] == 'true') {
		$get = '&module=';
		if(!empty($_POST['return_module'])) $get .= $_POST['return_module'];
		else $get .= 'Contacts';
		$get .= '&action=';
		if(!empty($_POST['return_action'])) $get .= $_POST['return_action'];
		else $get .= 'Popup';
		if(!empty($_POST['return_id'])) $get .= '&return_id='.$_POST['return_id'];
		if(!empty($_POST['popup'])) $get .= '&popup='.$_POST['popup'];
		if(!empty($_POST['create'])) $get .= '&create='.$_POST['create'];
		if(!empty($_POST['to_pdf'])) $get .= '&to_pdf='.$_POST['to_pdf'];
		$get .= '&first_name=' . urlencode($focus->first_name);
		$get .= '&last_name=' . urlencode($focus->last_name);
		$get .= '&query=true';
		header("Location: index.php?$get");
		return;
	}

	if($redirect){
		$this->handleRedirect($return_id);
	}else{
		return $focus;
	}
}

function handleRedirect($return_id){
	if(isset($_POST['return_module']) && $_POST['return_module'] != "") {
		$return_module = $_POST['return_module'];
	}
	else {
		$return_module = "Contacts";
	}

	if(isset($_POST['return_action']) && $_POST['return_action'] != "") {
		if($_REQUEST['return_module'] == 'Emails') {
			$return_action = $_REQUEST['return_action'];
		}
		// if we create a new record "Save", we want to redirect to the DetailView
		elseif($_REQUEST['action'] == "Save" && $_REQUEST['return_module'] != "Home") {
			$return_action = 'DetailView';
		} else {
			// if we "Cancel", we go back to the list view.
			$return_action = $_REQUEST['return_action'];
		}
	}
	else {
		$return_action = "DetailView";
	}

	if(isset($_POST['return_id']) && $_POST['return_id'] != "") {
        $return_id = $_POST['return_id'];
	}

	//eggsurplus Bug 23816: maintain VCR after an edit/save. If it is a duplicate then don't worry about it. The offset is now worthless.
 	$redirect_url = "index.php?action=$return_action&module=$return_module&record=$return_id";
 	if(isset($_REQUEST['offset']) && empty($_REQUEST['duplicateSave'])) {
 	    $redirect_url .= "&offset=".$_REQUEST['offset'];
 	}

    if(!empty($_REQUEST['ajax_load'])){
        echo "<script>SUGAR.ajaxUI.loadContent('$redirect_url');</script>\n";
    }
    else {
        header("Location: ". $redirect_url);
    }
}

    /**
    * @return Contact
    */
    protected function getContact()
    {
        return BeanFactory::getBean('Contacts');
    }
}


?>
