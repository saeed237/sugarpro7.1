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


require_once('include/Dashlets/Dashlet.php');


class SugarNewsDashlet extends Dashlet {
    var $displayTpl = 'modules/Home/Dashlets/SugarNewsDashlet/display.tpl';
    var $configureTpl = 'modules/Home/Dashlets/SugarNewsDashlet/configure.tpl';
    var $defaultURL = 'http://apps.sugarcrm.com/dashlet/sugarcrm-news-dashlet.html?lang=@@LANG@@&edition=@@EDITION@@&ver=@@VER@@';
    var $url;

    function SugarNewsDashlet($id, $options = null) {
        parent::Dashlet($id);
        $this->isConfigurable = true;
        
        if(empty($options['title'])) { 
            $this->title = translate('LBL_DASHLET_SUGAR_NEWS', 'Home'); 
        } else {
            $this->title = $options['title'];
        }
        if(empty($options['url'])) { 
            $this->url = $this->defaultURL;
        } else {
            $this->url = $options['url'];
        }

        if(empty($options['height']) || (int)$options['height'] < 1 ) { 
            $this->height = 315; 
        } else {
            $this->height = (int)$options['height'];
        }

        if(isset($options['autoRefresh'])) $this->autoRefresh = $options['autoRefresh'];
    }

    function displayOptions() {
        global $app_strings;
        $ss = new Sugar_Smarty();
        $ss->assign('titleLBL', translate('LBL_DASHLET_OPT_TITLE', 'Home'));
		$ss->assign('urlLBL', translate('LBL_DASHLET_OPT_URL', 'Home'));
		$ss->assign('heightLBL', translate('LBL_DASHLET_OPT_HEIGHT', 'Home'));
        $ss->assign('title', $this->title);
        $ss->assign('url', $this->url);
        $ss->assign('id', $this->id);
        $ss->assign('height', $this->height);
        $ss->assign('saveLBL', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('clearLBL', $app_strings['LBL_CLEAR_BUTTON_LABEL']);
        if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
        
        return  $ss->fetch('modules/Home/Dashlets/SugarNewsDashlet/configure.tpl');        
    }

    function saveOptions($req) {
        $options = array();
        
        if ( isset($req['title']) ) {
            $options['title'] = $req['title'];
        }
        if ( isset($req['url']) ) {
            $options['url'] = $req['url'];
        }
        if ( isset($req['height']) ) {
            $options['height'] = (int)$req['height'];
        }
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];
        
        return $options;
    }

    function display(){
        $sugar_edition = 'PRO';

        $out_url = str_replace(
            array('@@LANG@@','@@VER@@','@@EDITION@@'),
            array($GLOBALS['current_language'],$GLOBALS['sugar_config']['sugar_version'],$sugar_edition),
            $this->url);
        return parent::display() . "<iframe class='teamNoticeBox' title='{$out_url}' src='{$out_url}' height='{$this->height}px'></iframe>";
    }
}
