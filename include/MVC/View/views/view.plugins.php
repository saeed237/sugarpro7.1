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


require_once('include/MVC/View/views/view.ajax.php');
require_once('include/SugarPlugins/SugarPlugins.php');

class ViewPlugins extends ViewAjax
{
    /**
     * @see SugarView::display()
     */
    public function display()
    {
    	global $app_strings;
        
		$sp = new SugarPlugins();
		
		$plugins = $sp->getPluginList();
		$pluginsCat = array(
					"Outlook" => array(
						"name" => $app_strings['LBL_PLUGIN_OUTLOOK_NAME'],
						"desc" => $app_strings['LBL_PLUGIN_OUTLOOK_DESC'],
						),
					"Word" => array(
						"name" => $app_strings['LBL_PLUGIN_WORD_NAME'],
						"desc" => $app_strings['LBL_PLUGIN_WORD_DESC'],
						),
					"Excel" => array(
						"name" => $app_strings['LBL_PLUGIN_EXCEL_NAME'],
						"desc" => $app_strings['LBL_PLUGIN_EXCEL_DESC'],
						),
					);
		$str = '<table cellpadding="0" cellspacing="0" class="detail view">';
		$str .= "<tr><th colspan='2'>";
		$str .= "<h4>{$app_strings['LBL_PLUGINS_TITLE']}</h4>";
		$str .= "</th><tr>";

		$str .= "<tr><td colspan='2' style='padding-left: 10px;'>{$app_strings['LBL_PLUGINS_DESC']}</td></tr>";

        foreach($pluginsCat as $key => $value )
        {
      			$pluginImage = SugarThemeRegistry::current()->getImageURL("plug-in_{$key}.gif");
                $pluginContents = '';

      			foreach($plugins as $plugin)
                {
      				$raw_name = urlencode($plugin['raw_name']);
      				$display_name = str_replace('_', ' ' , $plugin['formatted_name']);
      				if(strpos($display_name,$key)!==false)
                    {
      					$pluginContents .= "<li><a href='index.php?module=Home&action=DownloadPlugin&plugin={$raw_name}'>{$display_name}</a></li>";
      				}
      			}

                //If we have pluginContents value, combine together
      			if(!empty($pluginContents))
                {
                    $str .= "<tr><td valign='top' width='80' style='padding-right: 10px; padding-left: 10px;'><img src='{$pluginImage}' alt='{$pluginImage}'></td>";
                    $str .= "<td><b>{$value['name']}</b><br>";
                    $str .= $value['desc'];
                    $str .= '<ul id="pluginList">';
                    $str .= $pluginContents;
                    $str .= '</ul></td></tr>';
                }
      	}

		$str .= "</table>";

		echo $str;
    }
}
