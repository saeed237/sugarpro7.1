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


require_once('include/vCard.php');
/*
 * vCard API implementation
 */
class vCardApi extends SugarApi {

    /**
     * This function registers the vCard api
     */
    public function registerApiRest() {
        return array(
            'vCardSave' => array(
                'reqType' => 'GET',
                'path' => array('VCardDownload'),
                'pathVars' => array(''),
                'method' => 'vCardSave',
                'rawReply' => true,
                'shortHelp' => 'An API to download a contact as a vCard.',
                'longHelp' => 'include/api/help/vcarddownload_get_help.html',
            ),
            'vCardImportPost' => array(
                'reqType' => 'POST',
                'path' => array('<module>', 'file', 'vcard_import'),
                'pathVars' => array('module', '', ''),
                'method' => 'vCardImport',
                'rawPostContents' => true,
                'shortHelp' => 'Imports a person record from a vcard',
                'longHelp' => 'include/api/help/module_file_vcard_import_post_help.html',
            ),
        );
    }

    /**
     * vCardSave
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return String
     */
    public function vCardSave($api, $args)
    {
        $this->requireArgs($args, array('id'));

        $vcard = new vCard();

        if (isset($args['module'])) {
            $module = clean_string($args['module']);
        } else {
            $module = 'Contacts';
        }

        $vcard->loadContact($args['id'], $module);

        return $vcard->saveVCardApi($api);
    }

    /**
     * vCardImport
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return String
     */
    public function vCardImport($api, $args)
    {
        $this->requireArgs($args, array('module'));

        $bean = BeanFactory::getBean($args['module']);
        if (!$bean->ACLAccess('save') || !$bean->ACLAccess('import')) {
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_NOT_AUTHORIZED');
        }

        if (isset($_FILES) && count($_FILES) === 1) {
            reset($_FILES);
            $first_key = key($_FILES);
            if (isset($_FILES[$first_key]['tmp_name']) && $this->isUploadedFile($_FILES[$first_key]['tmp_name']) && isset($_FILES[$first_key]['size']) > 0
            ) {
                $vcard = new vCard();
                try {
                    $recordId = $vcard->importVCard($_FILES[$first_key]['tmp_name'], $args['module']);
                } catch (Exception $e) {
                    throw new SugarApiExceptionRequestMethodFailure('ERR_VCARD_FILE_PARSE');
                }

                $results = array($first_key => $recordId);
                return $results;
            }
        } else {
            throw new SugarApiExceptionMissingParameter('ERR_VCARD_FILE_MISSING');
        }
    }

    /**
     * This function is a wrapper for checking if the file was uploaded so that the php built in function can be mocked
     * @param string FileName
     * @return boolean
     */
    protected function isUploadedFile ($fileName)
    {
        return is_uploaded_file($fileName);
    }
}
