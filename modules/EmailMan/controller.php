<?php
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


class EmailManController extends SugarController
{
	function action_Save(){

        
        require_once('include/OutboundEmail/OutboundEmail.php');
        require_once('modules/Configurator/Configurator.php');

        $configurator = new Configurator();
        global $sugar_config;
        global $current_user, $mod_strings;
        if ( !is_admin($current_user)
                && !is_admin_for_module($GLOBALS['current_user'],'Emails')
                && !is_admin_for_module($GLOBALS['current_user'],'Campaigns') ){
        sugar_die($mod_strings['LBL_UNAUTH_ACCESS']);
        }

        //Do not allow users to spoof for sendmail if the config flag is not set.
        if( !isset($sugar_config['allow_sendmail_outbound']) || !$sugar_config['allow_sendmail_outbound'])
            $_REQUEST['mail_sendtype'] = "SMTP";

        // save Outbound settings  #Bug 20033 Ensure data for Outbound email exists before trying to update the system mailer.
        if(isset($_REQUEST['mail_sendtype']) && empty($_REQUEST['campaignConfig'])) {
            $oe = new OutboundEmail();
            $oe->populateFromPost();
            $oe->saveSystem();
        }



        $focus = BeanFactory::getBean('Administration');

        if(isset($_POST['tracking_entities_location_type'])) {
            if ($_POST['tracking_entities_location_type'] != '2') {
                unset($_POST['tracking_entities_location']);
                unset($_POST['tracking_entities_location_type']);
            }
        }
        // cn: handle mail_smtpauth_req checkbox on/off (removing double reference in the form itself
        if( !isset($_POST['mail_smtpauth_req']) )
        {
            $_POST['mail_smtpauth_req'] = 0;
		    if (empty($_POST['campaignConfig'])) {
			    $_POST['notify_allow_default_outbound'] = 0; // If smtp auth is disabled ensure outbound is disabled.
		    }
        }

        $focus->saveConfig();

        // save User defaults for emails
        $configurator->config['email_default_delete_attachments'] = (isset($_REQUEST['email_default_delete_attachments'])) ? true : false;

        ///////////////////////////////////////////////////////////////////////////////
        ////	SECURITY
        $security = array();
        if(isset($_REQUEST['applet'])) $security['applet'] = 'applet';
        if(isset($_REQUEST['base'])) $security['base'] = 'base';
        if(isset($_REQUEST['embed'])) $security['embed'] = 'embed';
        if(isset($_REQUEST['form'])) $security['form'] = 'form';
        if(isset($_REQUEST['frame'])) $security['frame'] = 'frame';
        if(isset($_REQUEST['frameset'])) $security['frameset'] = 'frameset';
        if(isset($_REQUEST['iframe'])) $security['iframe'] = 'iframe';
        if(isset($_REQUEST['import'])) $security['import'] = '\?import';
        if(isset($_REQUEST['layer'])) $security['layer'] = 'layer';
        if(isset($_REQUEST['link'])) $security['link'] = 'link';
        if(isset($_REQUEST['object'])) $security['object'] = 'object';
        if(isset($_REQUEST['style'])) $security['style'] = 'style';
        if(isset($_REQUEST['xmp'])) $security['xmp'] = 'xmp';
        $security['script'] = 'script';

        $configurator->config['email_xss'] = base64_encode(serialize($security));

        ////	SECURITY
        ///////////////////////////////////////////////////////////////////////////////

        ksort($sugar_config);

        $configurator->handleOverride();


    }

}
?>