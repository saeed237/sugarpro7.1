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

 * Description:  Target for ajax calls to retrieve AdditionalDetails
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/MVC/View/SugarView.php');

class HomeViewAdditionaldetailsretrieve extends SugarView
{
 	public function display()
 	{
        global $beanList, $beanFiles, $current_user, $app_strings, $app_list_strings;

        $moduleDir = empty($_REQUEST['bean']) ? '' : $_REQUEST['bean'];
        $beanName = empty($beanList[$moduleDir]) ? '' : $beanList[$moduleDir];
        $id = empty($_REQUEST['id']) ? '' : $_REQUEST['id'];

        // Bug 40216 - Add support for a custom additionalDetails.php file
        $additionalDetailsFile = $this->getAdditionalDetailsMetadataFile($moduleDir);

        if(empty($id) || empty($additionalDetailsFile) ) {
                echo 'bad data';
                die();
        }

        require_once($additionalDetailsFile);
        $adFunction = 'additionalDetails' . $beanName;

        if(function_exists($adFunction)) { // does the additional details function exist
            $json = getJSONobj();
            $bean = BeanFactory::getBean($moduleDir, $id);

        	//bug38901 - shows dropdown list label instead of database value
			foreach($bean->field_name_map as $field => $value)
			{
				if($value["type"] == "enum" && isset($app_list_strings[$value['options']][$bean->$field]))
				{
					$bean->$field = $app_list_strings[$value['options']][$bean->$field];
				}
			}

            $bean->ACLFilterFields();
            $arr = array_change_key_case($bean->toArray(), CASE_UPPER);

            $results = $adFunction($arr);
            $retArray['body'] = str_replace(array("\rn", "\r", "\n"), array('','','<br />'), $results['string']);
            if(!$bean->ACLAccess('EditView')) $results['editLink'] = '';
            if(!$bean->ACLAccess('DetailView')) $results['viewLink'] = '';

            $retArray['caption'] = "<div style='float:left'>{$app_strings['LBL_ADDITIONAL_DETAILS']}</div><div style='float: right'>";
            if(!empty($_REQUEST['show_buttons'])){
		    if(!empty($results['editLink']))
		    	$retArray['caption'] .= "<a title='".$GLOBALS['app_strings']['LBL_EDIT_BUTTON']."' href='".$results['editLink']."'><img border=0 src='".SugarThemeRegistry::current()->getImageURL('edit_inline.png',false)."'></a>";
		    if(!empty($results['viewLink']))
		    	$retArray['caption'] .= "<a title='".$GLOBALS['app_strings']['LBL_VIEW_BUTTON']."' href='".$results['viewLink']."'><img border=0 src='".SugarThemeRegistry::current()->getImageURL('view_inline.png',false)."' style='margin-left:2px;'></a>";
		    	$retArray['caption'] .= "<a title='".$GLOBALS['app_strings']['LBL_ADDITIONAL_DETAILS_CLOSE_TITLE']."' href='javascript: SUGAR.util.closeStaticAdditionalDetails();'><img border=0 src='".SugarThemeRegistry::current()->getImageURL('close.png',false)."' style='margin-left:2px;'></a>";
            }
            $retArray['caption'] .= "";
            $retArray['width'] = (empty($results['width']) ? '300' : $results['width']);
            echo 'result = ' . $json->encode($retArray);
        }
    }

    protected function getAdditionalDetailsMetadataFile($moduleName)
    {
        return SugarAutoLoader::existingCustomOne('modules/' . $moduleName . '/metadata/additionalDetails.php');
    }
}
