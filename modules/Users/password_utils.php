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

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


function canSendPassword() {
    global $mod_strings,
           $current_user,
           $app_strings;

    require_once "modules/OutboundEmailConfiguration/OutboundEmailConfigurationPeer.php";

    if ($current_user->is_admin) {
        $emailTemplate                             = new EmailTemplate();
        $emailTemplate->disable_row_level_security = true;

        if ($emailTemplate->retrieve($GLOBALS['sugar_config']['passwordsetting']['generatepasswordtmpl']) == '') {
            return $mod_strings['LBL_EMAIL_TEMPLATE_MISSING'];
        }

        if (empty($emailTemplate->body) && empty($emailTemplate->body_html)) {
            return $app_strings['LBL_EMAIL_TEMPLATE_EDIT_PLAIN_TEXT'];
        }

        if (!OutboundEmailConfigurationPeer::validSystemMailConfigurationExists($current_user)) {
            return $mod_strings['ERR_SERVER_SMTP_EMPTY'];
        }

        $emailErrors = $mod_strings['ERR_EMAIL_NOT_SENT_ADMIN'];

        try {
            $config = OutboundEmailConfigurationPeer::getSystemDefaultMailConfiguration();

            if ($config instanceof OutboundSmtpEmailConfiguration) {
                $emailErrors .= "<br>-{$mod_strings['ERR_SMTP_URL_SMTP_PORT']}";

                if ($config->isAuthenticationRequired()) {
                    $emailErrors .= "<br>-{$mod_strings['ERR_SMTP_USERNAME_SMTP_PASSWORD']}";
                }
            }
        } catch (MailerException $me) {
            // might want to report the error
        }

        $emailErrors .= "<br>-{$mod_strings['ERR_RECIPIENT_EMAIL']}";
        $emailErrors .= "<br>-{$mod_strings['ERR_SERVER_STATUS']}";

        return $emailErrors;
    }

    return $mod_strings['LBL_EMAIL_NOT_SENT'];
}

function  hasPasswordExpired($username)
{
    $usr_id=User::retrieve_user_id($username);
	$usr= BeanFactory::getBean('Users', $usr_id);
    $type = '';
	if ($usr->system_generated_password == '1'){
        $type='syst';
    }
    else{
        $type='user';
    }

    if ($usr->portal_only=='0'){
	    global $mod_strings;
	    $res=$GLOBALS['sugar_config']['passwordsetting'];
	  	if ($type != '') {
		    switch($res[$type.'expiration']){

	        case '1':
		    	global $timedate;
		    	if ($usr->pwd_last_changed == ''){
		    		$usr->pwd_last_changed= $timedate->nowDb();
		    		$usr->save();
		    		}

		        $expireday = $res[$type.'expirationtype']*$res[$type.'expirationtime'];
		        $expiretime = $timedate->fromUser($usr->pwd_last_changed)->get("+{$expireday} days")->ts;

			    if ($timedate->getNow()->ts < $expiretime)
			    	return false;
			    else{
			    	$_SESSION['expiration_type']= $mod_strings['LBL_PASSWORD_EXPIRATION_TIME'];
			    	return true;
			    	}
				break;


		    case '2':
		    	$login=$usr->getPreference('loginexpiration');
		    	$usr->setPreference('loginexpiration',$login+1);
		        $usr->save();
		        if ($login+1 >= $res[$type.'expirationlogin']){
		        	$_SESSION['expiration_type']= $mod_strings['LBL_PASSWORD_EXPIRATION_LOGIN'];
		        	return true;
		        }
		        else
		            {
			    	return false;
			    	}
		    	break;

		    case '0':
		        return false;
		   	 	break;
		    }
		}
    }
}
