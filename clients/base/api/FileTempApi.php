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


require_once 'clients/base/api/FileApi.php';

/**
 * API Class to handle temporary image (attachment) interactions with a field in
 * a bean that can be new, so no record id is associated yet.
 */
class FileTempApi extends FileApi {
    /**
     * Dictionary registration method, called when the API definition is built
     *
     * @return array
     */
    public function registerApiRest() {
        return array(
            'saveTempImagePost' => array(
                'reqType' => 'POST',
                'path' => array('<module>', 'temp', 'file', '?'),
                'pathVars' => array('module', 'temp', '', 'field'),
                'method' => 'saveTempImagePost',
                'rawPostContents' => true,
                'shortHelp' => 'Saves an image to a temporary folder.',
                'longHelp' => 'include/api/help/module_temp_file_field_post_help.html',
            ),
            'getTempImage' => array(
                'reqType' => 'GET',
                'path' => array('<module>', 'temp', 'file', '?', '?'),
                'pathVars' => array('module', 'record', '', 'field', 'temp_id'),
                'method' => 'getTempImage',
                'rawReply' => true,
                'shortHelp' => 'Reads a temporary image and deletes it.',
                'longHelp' => 'include/api/help/module_temp_file_field_temp_id_get_help.html',
            ),
        );
    }

    /**
     * Saves a temporary image to a module field using the POST method (but not attached to any model)
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return array
     * @throws SugarApiExceptionError
     */
    public function saveTempImagePost($api, $args)
    {
        if (!isset($args['record'])) {
            $args['record'] = null;
        }
        $temp = true;
        return $this->saveFilePost($api, $args, $temp);
    }

    /**
     * Gets a single temporary file for rendering and removes it from filesystem.
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return array
     */
    public function getTempImage($api, $args)
    {
        // Get the field
        if (empty($args['field'])) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionMissingParameter('Field name is missing');
        }
        $field = $args['field'];

        // Get the bean
        $bean = BeanFactory::newBean($args['module']);

        // Handle ACL
        $this->verifyFieldAccess($bean, $field);

        $filepath = UploadStream::path("upload://tmp/") . $args['temp_id'];
        if (file_exists($filepath)) {
            $filedata = getimagesize($filepath);

            $info = array(
                'content-type' => $filedata['mime'],
                'path' => $filepath,
            );
            require_once "include/download_file.php";
            $dl = new DownloadFileApi($api);
            $dl->outputFile(false, $info);
            register_shutdown_function(
                function () use($filepath) {
                    unlink($filepath);
                }
            );
        } else {
            throw new SugarApiExceptionInvalidParameter('File not found');
        }
    }
}
