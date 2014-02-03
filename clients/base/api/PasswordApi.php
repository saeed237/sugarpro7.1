<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


require_once('data/BeanFactory.php');
require_once('include/SugarFields/SugarFieldHandler.php');
require_once('include/api/SugarApi.php');


class PasswordApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'create' => array(
                'reqType' => 'GET',
                'path' => array('password', 'request'),
                'pathVars' => array('module'),
                'method' => 'requestPassword',
                'shortHelp' => 'This method sends email requests to reset passwords',
                'longHelp' => 'include/api/help/leads_register_post_help.html',
                'noLoginRequired' => true,
            ),
        );
    }

    /**
     * Resets password and sends email to user
     * @param $api
     * @param array $args
     * @return bool
     * @throws SugarApiExceptionRequestMethodFailure
     * @throws SugarApiExceptionMissingParameter
     */
    public function requestPassword($api, $args)
    {
        require_once('modules/Users/language/en_us.lang.php');
        $res = $GLOBALS['sugar_config']['passwordsetting'];

        $requiredParams = array(
            'email',
            'username',
        );
        if (!$GLOBALS['sugar_config']['passwordsetting']['forgotpasswordON']) {
            throw new SugarApiExceptionRequestMethodFailure(translate(
                'LBL_FORGOTPASSORD_NOT_ENABLED',
                'Users'
            ), $args);
        }

        foreach ($requiredParams as $key => $param) {
            if (!isset($args[$param])) {
                throw new SugarApiExceptionMissingParameter('Error: Missing argument.', $args);
            }
        }

        $usr = empty($this->usr) ? new User() : $this->usr;
        $useremail = $args['email'];
        $username = $args['username'];

        if (!empty($username) && !empty($useremail)) {
            $usr_id = $usr->retrieve_user_id($username);
            $usr->retrieve($usr_id);

            if (!$usr->isPrimaryEmail($useremail))
            {
                throw new SugarApiExceptionRequestMethodFailure(translate(
                    'LBL_PROVIDE_USERNAME_AND_EMAIL',
                    'Users'
                ), $args);
            }

            if ($usr->portal_only || $usr->is_group) {
                throw new SugarApiExceptionRequestMethodFailure(translate(
                    'LBL_PROVIDE_USERNAME_AND_EMAIL',
                    'Users'
                ), $args);
            }
            // email invalid can not reset password
            if (!SugarEmailAddress::isValidEmail($usr->emailAddress->getPrimaryAddress($usr))) {
                throw new SugarApiExceptionRequestMethodFailure(translate('ERR_EMAIL_INCORRECT', 'Users'), $args);
            }

            $isLink = isset($args['link']) && $args['link'] == '1';
            // if i need to generate a password (not a link)
            $password = $isLink ? '' : User::generatePassword();

            // Create URL
            // if i need to generate a link
            if ($isLink) {
                $guid = create_guid();
                $url = $GLOBALS['sugar_config']['site_url'] . "/index.php?entryPoint=Changenewpassword&guid=$guid";
                $time_now = TimeDate::getInstance()->nowDb();
                $q = "INSERT INTO users_password_link (id, username, date_generated) VALUES('" . $guid . "','" . $username . "','" . $time_now . "') ";
                $usr->db->query($q);
            }

            if ($isLink && isset($res['lostpasswordtmpl'])) {
                $emailTemp_id = $res['lostpasswordtmpl'];
            } else {
                $emailTemp_id = $res['generatepasswordtmpl'];
            }

            $additionalData = array(
                'link' => $isLink,
                'password' => $password
            );

            if (isset($url)) {
                $additionalData['url'] = $url;
            }

            $result = $usr->sendEmailForPassword($emailTemp_id, $additionalData);

            if ($result['status']) {
                return true;
            } elseif ($result['message'] != '') {
                throw new SugarApiExceptionRequestMethodFailure($result['message'], $args);
            } else {
                throw new SugarApiExceptionRequestMethodFailure('LBL_EMAIL_NOT_SENT', $args);
            }

        } else {
            throw new SugarApiExceptionMissingParameter('Error: Empty argument', $args);
        }
    }
}
