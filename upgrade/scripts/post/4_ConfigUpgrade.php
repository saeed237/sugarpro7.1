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
 * Update config entries for CE->PRO
 */
class SugarUpgradeConfigUpgrade extends UpgradeScript
{
    public $order = 4000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        // only do it when going from ce to non-ce
        if(!($this->from_flavor == 'ce' && $this->to_flavor != 'ce')) return;

        if(isset($this->upgrader->config['sugarbeet']))
        {
            unset($this->upgrader->config['sugarbeet']);
        }

        if(isset($this->upgrader->config['disable_team_access_check']))
        {
            unset($this->upgrader->config['disable_team_access_check']);
        }

        $passwordsetting_defaults = array(
                'minpwdlength' => '',
                'maxpwdlength' => '',
                'oneupper' => '',
                'onelower' => '',
                'onenumber' => '',
                'onespecial' => '',
                'SystemGeneratedPasswordON' => '',
                'generatepasswordtmpl' => '',
                'lostpasswordtmpl' => '',
                'customregex' => '',
                'regexcomment' => '',
                'forgotpasswordON' => false,
                'linkexpiration' => '1',
                'linkexpirationtime' => '30',
                'linkexpirationtype' => '1',
                'userexpiration' => '0',
                'userexpirationtime' => '',
                'userexpirationtype' => '1',
                'userexpirationlogin' => '',
                'systexpiration' => '0',
                'systexpirationtime' => '',
                'systexpirationtype' => '0',
                'systexpirationlogin' => '',
                'lockoutexpiration' => '0',
                'lockoutexpirationtime' => '',
                'lockoutexpirationtype' => '1',
                'lockoutexpirationlogin' => ''
         );

        if(!isset($this->upgrader->config['passwordsetting'])) {
            $this->upgrader->config['passwordsetting'] = $passwordsetting_defaults;
        } else {
            $this->upgrader->config['passwordsetting'] = array_merge($passwordsetting_defaults, $this->upgrader->config['passwordsetting']);
        }

    }
}
