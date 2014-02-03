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
 * Files to delete for 6.7 install
 */
class SugarUpgrade67ForDelete extends UpgradeScript
{
    public $order = 7000;
    public $version = '6.7.0';
    public $type = self::UPGRADE_CORE;

    public function run()
    {
        $files = array('themes/Sugar/js',
            //Remove the themes/Sugar/tpls directory
            'themes/Sugar/tpls',
            'themes/Sugar5',
            // remove the files moved to vendor
            'include/HTMLPurifier',
            'include/HTTP_WebDAV_Server',
            'include/Pear',
            'include/Smarty',
            'XTemplate',
            'Zend',
            'include/lessphp',
            'log4php',
            'include/nusoap',
            'include/oauth2-php',
            'include/pclzip',
            'include/reCaptcha',
            'include/tcpdf',
            'include/ytree',
            'include/SugarSearchEngine/Elastic/Elastica',
            //Remove the SugarFeed files
            'modules/Cases/SugarFeeds',
            'modules/Contacts/SugarFeeds',
            'modules/Leads/SugarFeeds',
            'modules/Opportunities/SugarFeeds/OppFeed.php',
            'modules/SugarFeed',
            // remove the old FTS Logic Hook
            'custom/Extension/application/Ext/LogicHooks/SugarFTSHooks.php',
            // remove old popup picker files from RLI
            'modules/RevenueLineItems/Popup_picker.html',
            'modules/RevenueLineItems/Popup_picker.php',
            // remove phpunit from vendor
            'vendor/phpunit',
            // remove the old base metadata file template for the dashablelist view
            'include/SugarObjects/templates/basic/clients/base/views/dashablelist/dashablelist.php',
        );
        $this->fileToDelete($files);
    }
}
