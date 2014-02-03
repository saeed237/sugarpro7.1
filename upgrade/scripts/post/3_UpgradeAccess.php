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
 * Update .htaccess files or web.config files
 */
class SugarUpgradeUpgradeAccess extends UpgradeScript
{
    public $order = 3000;
    public $type = self::UPGRADE_CORE;

    public function run()
    {
        if(!version_compare($this->from_version, '6.6.0', '<')) {
            return;
        }
        require_once "install/install_utils.php";

        if(!empty($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER["SERVER_SOFTWARE"],'Microsoft-IIS') !== false) {
            $this->handleWebConfig();
        } else {
            $this->handleHtaccess();
        }
    }

    protected function handleWebConfig()
    {
        handleWebConfig();
    }

    protected function handleHtaccess()
    {
        if(!empty($_SERVER['SERVER_SOFTWARE'])) {
            $ignoreCase = (substr_count(strtolower($_SERVER['SERVER_SOFTWARE']), 'apache/2') > 0)?'(?i)':'';
        } else {
            $ignoreCase = false;
        }
        $htaccess_file = $this->context['source_dir']."/.htaccess";

        $status =  $this->putFile($htaccess_file, getHtaccessData($htaccess_file));
        if( !$status ){
            $this->fail(sprintf($this->mod_strings['ERROR_HT_NO_WRITE'], $htaccess_file));
            return;
        }

        if (empty($GLOBALS['sugar_config']['upload_dir'])) {
            $GLOBALS['sugar_config']['upload_dir']='upload/';
        }

        $uploadHta = "upload://.htaccess";

        $denyAll =<<<eoq
        	Order Deny,Allow
        	Deny from all
eoq;

        if(file_exists($uploadHta) && filesize($uploadHta)) {
        	// file exists, parse to make sure it is current
            $oldHtaccess = file_get_contents($uploadHta);
        	// use a different regex boundary b/c .htaccess uses the typicals
        	if(strstr($oldHtaccess, $denyAll) === false) {
                $oldHtaccess .= "\n";
        		$oldHtaccess .= $denyAll;
        	}
        	if(!file_put_contents($uploadHta, $oldHtaccess)) {
                $this->fail(sprintf($this->mod_strings['ERROR_HT_NO_WRITE'], $uploadHta));
        	}
        } else {
        	// no .htaccess yet, create a fill
        	if(!file_put_contents($uploadHta, $denyAll)) {
        		$this->fail(sprintf($this->mod_strings['ERROR_HT_NO_WRITE'], $uploadHta));
        	}
        }
    }
}
