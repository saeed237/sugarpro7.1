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


require_once('include/MVC/View/views/view.detail.php');

class EmployeesViewDetail extends ViewDetail {

 	function EmployeesViewDetail(){
 		parent::ViewDetail();
 	}
 	
   /**
    * Return the "breadcrumbs" to display at the top of the page
    *
    * @param  bool $show_help optional, true if we show the help links
    * @return HTML string containing breadcrumb title
    */
    public function getModuleTitle($show_help = true)
    {
        global $sugar_version, $sugar_flavor, $server_unique_key, $current_language, $action, $current_user;

        $theTitle = "<div class='moduleTitle'>\n";

        $module = preg_replace("/ /","",$this->module);

        $params = $this->_getModuleTitleParams();
        $count = count($params);
        $index = 0;

		if(SugarThemeRegistry::current()->directionality == "rtl") {
			$params = array_reverse($params);
		}

        $paramString = '';
        foreach($params as $parm){
            $index++;
            $paramString .= $parm;
            if($index < $count){
                $paramString .= $this->getBreadCrumbSymbol();
            }
        }

        if(!empty($paramString)){
            $theTitle .= "<h2> $paramString </h2>\n";
        }

        if ($show_help) {
            $theTitle .= "<span class='utils'>";
            if(is_admin($current_user) || is_admin_for_module($current_user, $this->module))
            {
            $createImageURL = SugarThemeRegistry::current()->getImageURL('create-record.gif');
            $theTitle .= <<<EOHTML
&nbsp;
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
<img src='{$createImageURL}' alt='{$GLOBALS['app_strings']['LNK_CREATE']}'></a>
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
{$GLOBALS['app_strings']['LNK_CREATE']}
</a>
EOHTML;
            }
        }

        $theTitle .= "</span></div>\n";
        return $theTitle;
    }

 	function display() {
       	if(is_admin($GLOBALS['current_user']) || $_REQUEST['record'] == $GLOBALS['current_user']->id) {
			 $this->ss->assign('DISPLAY_EDIT', true);
        }
        if(is_admin($GLOBALS['current_user'])){
 			$this->ss->assign('DISPLAY_DUPLICATE', true);
 		}

 		$showDeleteButton = FALSE;
 		if(  $_REQUEST['record'] != $GLOBALS['current_user']->id && $GLOBALS['current_user']->isAdminForModule('Users') )
        {
            $showDeleteButton = TRUE;
 		     if( empty($this->bean->user_name) ) //Indicates just employee
 		         $deleteWarning = $GLOBALS['mod_strings']['LBL_DELETE_EMPLOYEE_CONFIRM'];
 		     else
 		         $deleteWarning = $GLOBALS['mod_strings']['LBL_DELETE_USER_CONFIRM'];
 		     $this->ss->assign('DELETE_WARNING', $deleteWarning);
        }
        $this->ss->assign('DISPLAY_DELETE', $showDeleteButton);
        
 		parent::display();
 	}
}
?>
