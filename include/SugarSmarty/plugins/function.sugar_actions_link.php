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
 * smarty_function_sugar_actions_link
 * This is the constructor for the Smarty plugin.
 *
 * @param $params The runtime Smarty key/value arguments
 * @param $smarty The reference to the Smarty object used in this invocation
 */
function smarty_function_sugar_actions_link($params, &$smarty)
{
   if(empty($params['module'])) {
   	  $smarty->trigger_error("sugar_button: missing required param (module)");
   } else if(empty($params['id'])) {
   	  $smarty->trigger_error("sugar_button: missing required param (id)");
   } else if(empty($params['view'])) {
   	  $smarty->trigger_error("sugar_button: missing required param (view)");
   }

   $type = $params['id'];
   $location = (empty($params['location'])) ? "" : "_".$params['location'];

   if(!is_array($type)) {
   	  $module = $params['module'];
   	  $view = $params['view'];
   	  switch(strtoupper($type)) {
			case "SEARCH":
                // TODO review these SUGAR.ajaxUI.* methods
			return '<input tabindex="2" title="{$APP.LBL_SEARCH_BUTTON_TITLE}" accessKey="{$APP.LBL_SEARCH_BUTTON_KEY}" onclick="SUGAR.savedViews.setChooser(); SUGAR.ajaxUI.submitForm(this.form);" class="button" type="button" name="button" value="{$APP.LBL_SEARCH_BUTTON_LABEL}" id="search_form_submit"/>&nbsp;';
			break;

          case "CANCEL":
              $cancelButton = '{capture name="cancelReturnUrl" assign="cancelReturnUrl"}';
              $cancelButton .= '{if !empty($smarty.request.return_action) && $smarty.request.return_action == "DetailView" && !empty($fields.id.value)}';
              $cancelButton .= 'parent.SUGAR.App.router.buildRoute(\'{$smarty.request.return_module}\', \'{$fields.id.value}\', \'{$smarty.request.return_action}\')';
              $cancelButton .= '{elseif !empty($smarty.request.return_module) || !empty($smarty.request.return_action) || !empty($smarty.request.return_id)}';
              $cancelButton .= 'parent.SUGAR.App.router.buildRoute(\'{$smarty.request.return_module}\', \'{$smarty.request.return_id}\', \'{$smarty.request.return_action}\')';
              $cancelButton .= '{else}';
              $cancelButton .= "parent.SUGAR.App.router.buildRoute('$module')";
              $cancelButton .= '{/if}';
              $cancelButton .= '{/capture}';
              $cancelButton .= '<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="parent.SUGAR.App.router.navigate({$cancelReturnUrl}, {literal}{trigger: true}{/literal}); return false;" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" id="' . $type . $location . '"> ';
              return $cancelButton;
              break;

			case "DELETE":
			return '{if $bean->aclAccess("delete")}<a title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" onclick="$(\'#form\')[0].return_module.value=\'' . $module . '\'; $(\'#form\')[0].return_action.value=\'ListView\'; $(\'#form\')[0].action.value=\'Delete\'; if(confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\')){literal}{$(\'#form\').submit()}{/literal};" name="Delete" id="delete_button">{$APP.LBL_DELETE_BUTTON_LABEL}</a>{/if} ';
			break;

			case "DUPLICATE":
			return '{if $bean->aclAccess("edit")}<a title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" onclick="$(\'#form\')[0].return_module.value=\''. $module . '\'; $(\'#form\')[0].return_action.value=\'DetailView\'; $(\'#form\')[0].isDuplicate.value=true; $(\'#form\')[0].action.value=\'' . $view . '\'; $(\'#form\')[0].return_id.value=\'{$id}\';SUGAR.ajaxUI.submitForm($(\'#form\')[0]);" name="Duplicate" id="duplicate_button">{$APP.LBL_DUPLICATE_BUTTON_LABEL}</a>{/if} ';
			break;

			case "EDIT";
			return '{if $bean->aclAccess("edit")}<a title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" onclick="$(\'#form\')[0].return_module.value=\'' . $module . '\'; $(\'#form\')[0].return_action.value=\'DetailView\'; $(\'#form\')[0].return_id.value=\'{$id}\'; $(\'#form\')[0].action.value=\'EditView\';SUGAR.ajaxUI.submitForm($(\'#form\')[0]);" name="Edit" id="edit_button">{$APP.LBL_EDIT_BUTTON_LABEL}</a>{/if} ';
			break;

            case "EDIT2";
			return '{if $bean->aclAccess("edit")}<a title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" onclick="$(\'#form\')[0].return_module.value=\'' . $module . '\'; $(\'#form\')[0].return_action.value=\'DetailView\'; $(\'#form\')[0].return_id.value=\'{$id}\'; $(\'#form\')[0].action.value=\'EditView\';SUGAR.ajaxUI.submitForm($(\'#form\')[0]);" name="Edit">{$APP.LBL_EDIT_BUTTON_LABEL}</a>{/if} ';
			break;

			case "FIND_DUPLICATES":
			return '{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<a title="{$APP.LBL_DUP_MERGE}" accessKey="M" onclick="$(\'#form\')[0].return_module.value=\'' . $module . '\'; $(\'#form\')[0].return_action.value=\'DetailView\'; $(\'#form\')[0].return_id.value=\'{$id}\'; $(\'#form\')[0].action.value=\'Step1\'; $(\'#form\')[0].module.value=\'MergeRecords\';SUGAR.ajaxUI.submitForm($(\'#form\')[0]);" name="Merge"  id="merge_duplicate_button">{$APP.LBL_DUP_MERGE}</a>{/if} ';
			break;

			case "SAVE":
				$view = ($_REQUEST['action'] == 'EditView') ? 'EditView' : (($view == 'EditView') ? 'EditView' : $view);
				return '{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="{if $isDuplicate}this.form.return_id.value=\'\'; {/if}this.form.action.value=\'Save\'; if(check_form(\'' . $view . '\'))SUGAR.ajaxUI.submitForm(this.form);return false;" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="'.$type.$location.'">{/if} ';
			break;

			case "SUBPANELSAVE":
                if($view == 'QuickCreate' || (isset($_REQUEST['target_action']) && strtolower($_REQUEST['target_action'])) == 'quickcreate') $view =  "form_SubpanelQuickCreate_{$module}";
                return '{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="this.form.action.value=\'Save\';if(check_form(\''.$view.'\'))return SUGAR.subpanelUtils.inlineSave(this.form.id, \'' . $params['module'] . '_subpanel_save_button\');return false;" type="submit" name="' . $params['module'] . '_subpanel_save_button" id="' . $params['module'] . '_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if} ';
			case "SUBPANELCANCEL":
				return '<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr(\'id\'));return false;" type="submit" name="' . $params['module'] . '_subpanel_cancel_button" id="' . $params['module'] . '_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}"> ';
		    case "SUBPANELFULLFORM":
				$html = '<input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" accessKey="{$APP.LBL_FULL_FORM_BUTTON_KEY}" class="button" onclick="this.form.return_action.value=\'DetailView\'; this.form.action.value=\'EditView\'; if(typeof(this.form.to_pdf)!=\'undefined\') this.form.to_pdf.value=\'0\';" type="submit" name="' . $params['module'] . '_subpanel_full_form_button" id="' . $params['module'] . '_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> ';
				$html .= '<input type="hidden" name="full_form" value="full_form">';
		        return $html;
			case "POPUPSAVE":
				$view = $view == 'QuickCreate' ? "form_QuickCreate_{$module}" : $view;
				return '{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" '
					 . 'class="button primary" onclick="this.form.action.value=\'Popup\';'
					 . 'return check_form(\''.$view.'\')" type="submit" name="' . $params['module']
					 . '_popupcreate_save_button" id="' . $params['module']
					 . '_popupcreate_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if} ';
			case "POPUPCANCEL":
				return '<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" '
					 . 'class="button" onclick="toggleDisplay(\'addform\');return false;" '
					 . 'name="' . $params['module'] . '_popup_cancel_button" type="submit"'
					 . 'id="' . $params['module'] . '_popup_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}"> ';

			case "AUDIT":
	            $popup_request_data = array(
			        'call_back_function' => 'set_return',
			        'form_name' => 'EditView',
			        'field_to_name_array' => array(),
			    );
	            $json = getJSONobj();

	            require_once('include/SugarFields/Parsers/MetaParser.php');
	            $encoded_popup_request_data = MetaParser::parseDelimiters($json->encode($popup_request_data));
	 			$audit_link = '<a id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" onclick=\'open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=' . $params['module'] . '", true, false, ' . $encoded_popup_request_data . '); return false;\'>{$APP.LNK_VIEW_CHANGE_LOG}</a>';
				$view = '{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}'.$audit_link.'{/if}{/if}';
				return $view;

			//Button for the Connector intergration wizard
			case "CONNECTOR":
				require_once('include/connectors/utils/ConnectorUtils.php');
				require_once('include/connectors/sources/SourceFactory.php');
				$modules_sources = ConnectorUtils::getDisplayConfig();
				if(!is_null($modules_sources) && !empty($modules_sources))
				{
					foreach($modules_sources as $mod=>$entry) {
					    if($mod == $module && !empty($entry)) {
					    	foreach($entry as $source_id) {
					    		$source = SourceFactory::getSource($source_id);
					    		if($source->isEnabledInWizard()) {
					    			return '<a title="{$APP.LBL_MERGE_CONNECTORS}" accessKey="{$APP.LBL_MERGE_CONNECTORS_BUTTON_KEY}" onClick="document.location=\'index.php?module=Connectors&action=Step1&record={$fields.id.value}&merge_module={$module}\'" name="merge_connector">{$APP.LBL_MERGE_CONNECTORS}</a>';
					    		}
					    	}
					    }
					}
				}
				return '';


   	  } //switch

   } else if(is_array($type) && isset($type['customCode'])) {
   	  return $type['customCode'];
   }

}

?>
