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






class SugarWidgetSubPanelIcon extends SugarWidgetField
{
	function displayHeaderCell(&$layout_def)
	{
		return '&nbsp;';
	}

	function displayList(&$layout_def)
	{
		global $app_strings;
		global $app_list_strings;
		global $current_user;

		if(isset($layout_def['varname']))
		{
			$key = strtoupper($layout_def['varname']);
		}
		else
		{
			$key = $this->_get_column_alias($layout_def);
			$key = strtoupper($key);
		}
//add module image
		//add module image
		if(!empty($layout_def['target_module_key'])) {
			if (!empty($layout_def['fields'][strtoupper($layout_def['target_module_key'])])) {
				$module=$layout_def['fields'][strtoupper($layout_def['target_module_key'])];
			}
		}

        if (empty($module)) {
			if(empty($layout_def['target_module']))
			{
				$module = $layout_def['module'];
			}
		else
			{
				$module = $layout_def['target_module'];
			}
		}
		$action = 'DetailView';
		if(empty($layout_def['target_record_key']))
		{
			$record = $layout_def['fields']['ID'];
		}
		else
		{
			$record_key = strtoupper($layout_def['target_record_key']);
			$record = $layout_def['fields'][$record_key];
		}
		$action_access = false;
		if(!empty($record) &&
			($layout_def[$action] && !$layout_def['owner_module']
			||  $layout_def[$action] && !ACLController::moduleSupportsACL($layout_def['owner_module'])
			|| ACLController::checkAccess($layout_def['owner_module'], 'view', $layout_def['owner_id'] == $current_user->id))) {
			$action_access = true;
		}
		$icon_img_html = SugarThemeRegistry::current()->getImage( $module . '', 'border="0"',null,null,'.gif',$app_list_strings['moduleList'][$module]);
		if (!empty($layout_def['attachment_image_only']) && $layout_def['attachment_image_only'] == true) {
			$ret="";
		} else {
			if ($action_access) {
				$ret = '<a href="index.php?module=' . $module . '&action=' . $action . '&record=' . $record	. '" >' . $icon_img_html . "</a>";
			} else {
				$ret = $icon_img_html;
			}
		}

		if(!empty($layout_def['image2']) &&  !empty($layout_def['image2_ext_url_field'])){

			if (!empty($layout_def['fields'][strtoupper($layout_def['image2_ext_url_field'])])) {
				$link_url  = $layout_def['fields'][strtoupper($layout_def['image2_ext_url_field'])];
			}

            $imagePath = '';
            if ( $layout_def['image2'] == '__VARIABLE' ) {
                if ( !empty($layout_def['fields'][$key.'_ICON']) ) {
                    $imagePath = $layout_def['fields'][$key.'_ICON'];
                }
            } else {
                $imagePath = $layout_def['image2'];
            }

            if ( !empty($imagePath) ) {
                $icon_img_html = SugarThemeRegistry::current()->getImage( $imagePath . '', 'border="0"',null,null,'.gif',$imagePath);
                $ret.= (empty($link_url)) ? '' : '&nbsp;<a href="' . $link_url. '" TARGET = "_blank">' . "$icon_img_html</a>";
            }
        }
//if requested, add attachment icon.
		if(!empty($layout_def['image2']) && !empty($layout_def['image2_url_field'])){

			if (is_array($layout_def['image2_url_field'])) {
				//Generate file url.
				if (!empty($layout_def['fields'][strtoupper($layout_def['image2_url_field']['id_field'])])
				and !empty($layout_def['fields'][strtoupper($layout_def['image2_url_field']['filename_field'])]) ) {

					$key=$layout_def['fields'][strtoupper($layout_def['image2_url_field']['id_field'])];
                    $file=$layout_def['fields'][strtoupper($layout_def['image2_url_field']['filename_field'])];
                    $filepath="index.php?entryPoint=download&id=".$key."&type=".$layout_def['module'];
				}
			} else {
				if (!empty($layout_def['fields'][strtoupper($layout_def['image2_url_field'])])) {
					$filepath="index.php?entryPoint=download&id=".$layout_def['fields']['ID']."&type=".$layout_def['module'];
				}
			}
			$icon_img_html = SugarThemeRegistry::current()->getImage( $layout_def['image2'] . '', 'border="0"',null,null,'.gif',$layout_def['image2']);
			if ($action_access && !empty($filepath)) {
				$ret .= '<a href="' . $filepath. '" >' . "$icon_img_html</a>";
			} elseif (!empty($filepath)) {
				$ret .= $icon_img_html;
			}
		}
		// now handle attachments for Emails
		else if(!empty($layout_def['module']) && $layout_def['module'] == 'Emails' && !empty($layout_def['fields']['ATTACHMENT_IMAGE'])) {
			$ret.= $layout_def['fields']['ATTACHMENT_IMAGE'];
		}
		return $ret;
	}
}
?>
