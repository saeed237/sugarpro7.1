<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 * Connector's HTML helper
 * @api
 */
class ConnectorHtmlHelper
{
    /**
     * Method return the HTML code for the hover link field
     *
     * @param array $shown_sources
     * @param mixed $module
     * @param mixed $smarty
     * @return string
     */
    public function getConnectorButtonCode(array $shown_sources, $module, $smarty)
    {
        require_once('include/connectors/formatters/FormatterFactory.php');

        return $this->getButton($shown_sources, $module, $smarty);
    }

    /**
     * Get button for source
     *
     * @param string $shown_source
     * @param mixed $module
     * @param mixed $smarty
     * @return string
     */
    private function getButton(array $shown_sources, $module, $smarty)
    {
        $code = '';

         foreach($shown_sources as $id) {
             $formatter = FormatterFactory::getInstance($id);
             $formatter->setModule($module);
             $formatter->setSmarty($smarty);
             $formatter_code = $formatter->getDetailViewFormat();
             if (!empty($formatter_code))
             {
                 $iconFilePath = $formatter->getIconFilePath();
                 $iconFilePath = empty($iconFilePath) ? 'themes/default/images/MoreDetail.png' : $iconFilePath;


            $code .= '<!--not_in_theme!--><img id="dswidget_img" border="0" src="' . $iconFilePath .'" alt="'
                         . $id .'" onclick="show_' . $id . '(event);">';

            $code .= "<script type='text/javascript' src='{sugar_getjspath file='include/connectors/formatters/default/company_detail.js'}'></script>";
                 //$code .= $formatter->getDetailViewFormat();
                 $code .= $formatter_code;
             }
        }

        return $code;
    }

    /**
     * Get popup for sources
     *
     * @param array $shown_sources
     * @param mixed $module
     * @param mixed $smarty
     * @return string
     */
    private function getPopup(array $shown_sources, $module, $smarty)
    {
        global $app_strings;

        $code = '';
        $menuParams = 'var menuParams = "';
        $formatterCode = '';
        $sourcesDisplayed = 0;
        $singleIcon = '';
        foreach($shown_sources as $id)
        {
            $formatter = FormatterFactory::getInstance($id);
            $formatter->setModule($module);
            $formatter->setSmarty($smarty);
            $buttonCode = $formatter->getDetailViewFormat();
            if (!empty($buttonCode))
            {
                $sourcesDisplayed++;
                $singleIcon = $formatter->getIconFilePath();
                $source = SourceFactory::getSource($id);
                $config = $source->getConfig();
                $name = !empty($config['name']) ? $config['name'] : $id;
                //Create the menu item to call show_[source id] method in javascript
                $menuParams .= '<a href=\'#\' style=\'width:150px\' class=\'menuItem\' onmouseover=\'hiliteItem(this,\"yes\");\''
                            . ' onmouseout=\'unhiliteItem(this);\' onclick=\'show_' . $id . '(event);\'>' . $name . '</a>';
                $formatterCode .= $buttonCode;
            }
        } //for

        if (!empty($formatterCode))
        {
            if ($sourcesDisplayed > 1)
            {
                $dswidget_img = SugarThemeRegistry::current()->getImageURL('MoreDetail.png');
                $code = '<!--not_in_theme!--><img id="dswidget_img" src="' . $dswidget_img . '" width="11" height="7" border="0" alt="'
                        . $app_strings['LBL_CONNECTORS_POPUPS'] . '" onclick="return showConnectorMenu2(this);">';
            }
            else
            {
                $dswidget_img = SugarThemeRegistry::current()->getImageURL('MoreDetail.png');
                $singleIcon = empty($singleIcon) ? $dswidget_img : $singleIcon;
                $code = '<!--not_in_theme!--><img id="dswidget_img" border="0" src="' . $singleIcon . '" alt="'.$app_strings['LBL_CONNECTORS_POPUPS']
                        . '" onclick="return showConnectorMenu2(this);">';

            }
            $code .= "<script type='text/javascript' src='{sugar_getjspath file='include/connectors/formatters/default/company_detail.js'}'></script>\n";
            $code .= "<script type='text/javascript'>\n";
            $code .= "function showConnectorMenu2(el) {literal} { {/literal}\n";

            $menuParams .= '";';
            $code .= $menuParams . "\n";
            $code .= "return SUGAR.util.showHelpTips(el,menuParams);\n";
            $code .= "{literal} } {/literal}\n";
            $code .= "</script>\n";
            $code .= $formatterCode;
        }
        return $code;
    }
}
