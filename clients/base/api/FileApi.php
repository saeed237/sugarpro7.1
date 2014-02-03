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
 * API Class to handle file and image (attachment) interactions with a field in
 * a record.
 */
class FileApi extends SugarApi {
    /**
     * Dictionary registration method, called when the API definition is built
     *
     * @return array
     */
    public function registerApiRest() {
        return array(
            'saveFilePost' => array(
                'reqType' => 'POST',
                'path' => array('<module>', '?', 'file', '?'),
                'pathVars' => array('module', 'record', '', 'field'),
                'method' => 'saveFilePost',
                'rawPostContents' => true,
                'shortHelp' => 'Saves a file. The file can be a new file or a file override.',
                'longHelp' => 'include/api/help/module_record_file_field_post_help.html',
            ),
            'saveFilePut' => array(
                'reqType' => 'PUT',
                'path' => array('<module>', '?', 'file', '?'),
                'pathVars' => array('module', 'record', '', 'field'),
                'method' => 'saveFilePut',
                'rawPostContents' => true,
                'shortHelp' => 'Saves a file. The file can be a new file or a file override. (This is an alias of the POST method save.)',
                'longHelp' => 'include/api/help/module_record_file_field_put_help.html',
            ),
            'getFileList' => array(
                'reqType' => 'GET',
                'path' => array('<module>', '?', 'file'),
                'pathVars' => array('module', 'record', ''),
                'method' => 'getFileList',
                'shortHelp' => 'Gets a listing of files related to a field for a module record.',
                'longHelp' => 'include/api/help/module_record_file_get_help.html',
            ),
            'getFileContents' => array(
                'reqType' => 'GET',
                'path' => array('<module>', '?', 'file', '?'),
                'pathVars' => array('module', 'record', '', 'field'),
                'method' => 'getFile',
                'rawReply' => true,
                'allowDownloadCookie' => true,
                'shortHelp' => 'Gets the contents of a single file related to a field for a module record.',
                'longHelp' => 'include/api/help/module_record_file_field_get_help.html',
            ),
            'removeFile' => array(
                'reqType' => 'DELETE',
                'path' => array('<module>', '?', 'file', '?'),
                'pathVars' => array('module', 'record', '', 'field'),
                'method' => 'removeFile',
                'rawPostContents' => true,
                'shortHelp' => 'Removes a file from a field.',
                'longHelp' => 'include/api/help/module_record_file_field_delete_help.html',
            ),
        );
    }

    /**
     * Saves a file to a module field using the PUT method
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return array
     */
    public function saveFilePut($api, $args) {
        // Mime type, set to null for grabbing it later if not sent
        $filetype = isset($_SERVER['HTTP_CONTENT_TYPE']) ? $_SERVER['HTTP_CONTENT_TYPE'] : null;

        // Set the filename, first from the passed args then from the request itself
        if (isset($args['filename'])) {
            $filename = $args['filename'];
        } else {
            $filename = isset($_SERVER['HTTP_FILENAME']) ? $_SERVER['HTTP_FILENAME'] : create_guid();
        }

        // Create a temp name for our file to begin mocking the $_FILES array
        $tempfile = tempnam(sys_get_temp_dir(), 'API');

        // Now read the raw body to capture what is being sent by PUT requests
        // Using a file handle to save on memory consumption with file_get_contents
        $inputHandle  = fopen('php://input', 'r');
        $outputHandle = fopen($tempfile, 'w');

        // Write it out
        while ($data = fread($inputHandle, 1024)) {
            fwrite($outputHandle, $data);
        }

        // Close the handles
        fclose($inputHandle);
        fclose($outputHandle);

        // Now validate our file
        $filesize = filesize($tempfile);
        if (empty($filesize)) {
            throw new SugarApiExceptionMissingParameter('File is missing or no file data was received.');
        }

        // Now get our actual mime type from our internal methodology if it wasn't passed
        if (empty($filetype)) {
            require_once 'include/download_file.php';
            $dl = new DownloadFileApi($api);
            $filetype = $dl->getMimeType($tempfile);
        }

        // Mock a $_FILES array member, adding in _SUGAR_API_UPLOAD to allow file uploads
        $_FILES[$args['field']] = array(
            'name' => $filename,
            'type' => $filetype,
            'tmp_name' => $tempfile,
            'error' => 0,
            'size' => $filesize,
            '_SUGAR_API_UPLOAD' => true, // This is in place to allow bypassing is_uploaded_file() checks
        );

        // Now that we are set up, hand this off to the POST save handler
        $return = $this->saveFilePost($api, $args);

        // Handle temp file cleanup
        if (file_exists($tempfile)) {
            unlink($tempfile);
        }

        // Send back our result
        return $return;
    }

    /**
     * Saves a file to a module field using the POST method
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @param bool $temporary true if we are saving a temporary image
     * @return array
     * @throws SugarApiExceptionError
     */
    public function saveFilePost($api, $args, $temporary = false) {
        //Needed by SugarFieldImage.php to know if we are saving a temporary image
        $args['temp'] = $temporary;

        // Get the field
        $field = $args['field'];

        // To support field prefixes like Sugar proper
        $prefix = empty($args['prefix']) ? '' : $args['prefix'];

        // Set the files array index (for type == file)
        $filesIndex = $prefix . $field;

        // Get the bean before we potentially delete if fails (e.g. see below if attachment too large, etc.)
        $bean = $this->loadBean($api, $args);

        if(!$bean->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }

        // Simple validation
        // In the case of very large files that are too big for the request too handle AND
        // if the auth token was sent as part of the request body, you will get a no auth error
        // message on uploads. This check is in place specifically for file uploads that are too
        // big to be handled by checking for the presence of the $_FILES array and also if it is empty.
        if (isset($_FILES)) {
            if (empty($_FILES)) {

                // If we get here, the attachment was > php.ini upload_max_filesize value so we need to
                // check if delete_if_fails optional parameter was set true, etc.
                $this->deleteIfFails($bean, $args);

                // @TODO Localize this exception message
                throw new SugarApiExceptionRequestTooLarge('Attachment is too large');
            }
        } else {
            throw new SugarApiExceptionMissingParameter('Attachment is missing');
        }

        if (empty($_FILES[$filesIndex])) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionMissingParameter("Incorrect field name for attachement: $filesIndex");
        }

        // Handle ACL - if there is no current field data, it is a CREATE
        // This addresses an issue where the portal user has create but not edit
        // rights for particular modules. The perspective here is that even if
        // a record exists, if there is no attachment, you are CREATING the
        // attachment instead of EDITING the parent record. -rgonzalez
        $accessType = empty($bean->$field) ? 'create' : 'edit';
        $this->verifyFieldAccess($bean, $field, $accessType);

        // Get the defs for this field
        $def = $bean->field_defs[$field];

        // Only work on file or image fields
        if (isset($def['type']) && ($def['type'] == 'image' || $def['type'] == 'file')) {
            // Get our tools to actually save the file|image
            require_once 'include/SugarFields/SugarFieldHandler.php';
            $sfh = new SugarFieldHandler();
            $sf = $sfh->getSugarField($def['type']);
            if ($sf) {
                // SugarFieldFile expects something different than SugarFieldImage
                if ($def['type'] == 'file') {
                    // docType setting is throwing errors if missing
                    if (!isset($def['docType'])) {
                        $def['docType'] = 'Sugar';
                    }

                    // Session error handler is throwing errors if not set
                    $_SESSION['user_error_message'] = array();

                    // Handle setting the files array to what SugarFieldFile is expecting
                    if (!empty($_FILES[$filesIndex]) && empty($_FILES[$filesIndex . '_file'])) {
                        $_FILES[$filesIndex . '_file'] = $_FILES[$filesIndex];
                        unset($_FILES[$filesIndex]);
                        $filesIndex .= '_file';
                    }
                }

                // Noticed for some reason that API FILE[type] was set to application/octet-stream
                // That breaks the uploader which is looking for very specific mime types
                // So rather than rely on what $_FILES thinks, set it with our own methodology
                require_once 'include/download_file.php';
                $dl = new DownloadFileApi($api);
                $mime = $dl->getMimeType($_FILES[$filesIndex]['tmp_name']);
                $_FILES[$filesIndex]['type'] = $mime;

                // Set the docType into args if its in the def
                // This addresses a need in the UploadFile object
                if (isset($def['docType']) && !isset($args[$prefix . $def['docType']])) {
                    $args[$prefix . $def['docType']] = $mime;
                }

                // This saves the attachment
                $sf->save($bean, $args, $field, $def, $prefix);

                // Handle errors
                if (!empty($sf->error)) {

                    // Note, that although the code earlier in this method (where attachment too large) handles
                    // if file > php.ini upload_maxsize, we still may have a file > sugarcrm maxsize
                    $this->deleteIfFails($bean, $args);
                    throw new SugarApiExceptionError($sf->error);
                }

                // Prep our return
                $fileinfo = array();

                //In case we are returning a temporary file
                if ($temporary) {
                    $fileinfo['guid'] = $bean->$field;
                }
                else {
                    // Save the bean
                    $bean->save();

                    $fileinfo = $this->getFileInfo($bean, $field, $api);

                    // Clean up the uri
                    $fileinfo['uri'] = rtrim($api->getResourceURI(''), '/');

                    // This isn't needed in this return
                    unset($fileinfo['path']);
                }

                // This is a good return
                return array($field => $fileinfo);
            }
        }

        // @TODO Localize this exception message
        throw new SugarApiExceptionError("Unexpected field type: ".$def['type']);
    }

    /**
     * Gets a list of all fields that have files attached to them for a module
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return array
     */
    public function getFileList($api, $args) {
        // Validate and load up the bean because we need it
        $bean = $this->loadBean($api, $args, 'view');

        if(!$bean->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }

        // Special cases for document revision sets
        if (property_exists($bean, 'document_revision_id') && !empty($bean->document_revision_id)) {
            $newbean = BeanFactory::getBean('DocumentRevisions', $bean->document_revision_id);
            // Some Doc Revisions have a filename but no mime type, which means no file
            if ($newbean && !empty($newbean->file_mime_type)) {
                $bean = $newbean;
            }
        }

        // Set up our return array
        $list = array();
        foreach ($bean->field_defs as $field => $def) {
            // We are looking specifically for file and image types
            if (isset($def['type']) && ($def['type'] == 'image' || $def['type'] == 'file')) {
                // Add this field to the response, even if it is empty
                $fileinfo = $this->getFileInfo($bean, $field, $api);

                // This isn't needed in this return
                unset($fileinfo['path']);

                // Add it to the return, as an object so that if it is empty it
                // is still an object in json responses
                $list[$field] = (object) $fileinfo;
            }
        }

        return $list;
    }

    /**
     * Gets a single file for rendering
     *
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @return string
     * @throws SugarApiExceptionMissingParameter|SugarApiExceptionNotFound
     */
    public function getFile($api, $args) {
        // Get the field
        if (empty($args['field'])) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionMissingParameter('Field name is missing');
        }
        $field = $args['field'];

        // Get the bean
        $bean = $this->loadBean($api, $args);

        if(!$bean->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }

        if (empty($bean->{$field})) {
            // @TODO Localize this exception message
            throw new SugarApiExceptionNotFound("The requested file $args[module] :: $field could not be found.");
        }

        // Handle ACL
        $this->verifyFieldAccess($bean, $field);

        $def = $bean->field_defs[$field];
        //for the image type field, forceDownload set default as false in order to display on the image element.
        $forceDownload = ($def['type'] == 'image') ? false : true;
        if (isset($args['force_download'])) {
            $forceDownload = (bool) $args['force_download'];
        }

        require_once 'include/download_file.php';
        $download = new DownloadFileApi($api);
        try {
            $download->getFile($bean, $field, $forceDownload);
        } catch (Exception $e) {
            throw new SugarApiExceptionNotFound($e->getMessage(), null, null, 0, $e);
        }
    }

    /**
     * Removes an attachment from a record field
     *
     * @param ServiceBase $api The service base
     * @param array $args The request args
     * @return array Listing of fields for a record
     * @throws SugarApiExceptionError|SugarApiExceptionNoMethod|SugarApiExceptionRequestMethodFailure
     */
    public function removeFile($api, $args) {
        // Get the field
        $field = $args['field'];

        // Get the bean
        $bean = $this->loadBean($api, $args);

        // Handle ACL
        $this->verifyFieldAccess($bean, $field, 'delete');

        // Only remove if there is something to remove
        if (!empty($bean->{$field})) {
            // Get the defs for this field
            $def = $bean->field_defs[$field];

            // Only work on file or image fields
            if (isset($def['type']) && ($def['type'] == 'image' || $def['type'] == 'file')) {
                if ($def['type'] == 'file') {
                    if (method_exists($bean, 'deleteAttachment')) {
                        if (!$bean->deleteAttachment()) {
                            // @TODO Localize this exception message
                            throw new SugarApiExceptionRequestMethodFailure('Removal of attachment failed.');
                        }
                    } else {
                        // @TODO Localize this exception message
                        throw new SugarApiExceptionNoMethod('No method found to remove attachment.');
                    }
                } else {
                    require_once 'include/upload_file.php';
                    $upload = new UploadFile($field);
                    $upload->unlink_file($bean->$field);
                    $bean->$field = '';
                    $bean->save();
                }
            } else {
                // @TODO Localize this exception message
                throw new SugarApiExceptionError("Unexpected field type: ".$def['type']);
            }
        }

        return $this->getFileList($api, $args);
    }

    /**
     * Provides ability to mark a SugarBean deleted if related file upload failed (and user passed
     * the delete_if_fails optional parameter). Note, private to respect "Principle of least privilege"
     * If you need in derived classes then you may change to protected.
     *
     * @param SugarBean $bean Bean
     * @param array $args The request args
     * @return false if no deletion occured because delete_if_fails was not set otherwise true.
     */
    private function deleteIfFails($bean, $args) {
        // Bug 57210: Need to be able to mark a related record 'deleted=1' when a file uploads fails.
        // delete_if_fails flag is an optional query string which can trigger this behavior. An example
        // use case might be: user's in a modal and client: 1. POST's related record 2. uploads file...
        // If the file was too big, the user may still want to go back and select a smaller file < max;
        // but now, upon saving, the client will attempt to PUT related record first and if their ACL's
        // may prevent edit/deletes it would fail. This rectifies such a scenario.
        if(!empty($args['delete_if_fails'])) {

            // First ensure user owns record
            if($bean->created_by == $GLOBALS['current_user']->id) {
                $bean->mark_deleted($bean->id);
                return true;
            }
        }
        return false;
    }

    /**
     * Gets the file information array for an uploaded file that is associated
     * with a bean's $field
     *
     * The $args array should have already been called prior to this method in
     * order to get full path URIs for the file
     *
     * @param SugarBean $bean The bean to get the info from
     * @param string $field The field name to get the file data from
     * @param ServiceBase $api The calling API service object
     * @return array|bool
     */
    protected function getFileInfo($bean, $field, $api) {
        $info = array();
        if (isset($bean->field_defs[$field])) {
            $def = $bean->field_defs[$field];
            if (isset($def['type']) && !empty($bean->{$field})) {
                if ($def['type'] == 'image') {
                    $filename = $bean->{$field};
                    $filepath = 'upload://' . $filename;
                    $filedata = getimagesize($filepath);

                    // Add in height and width for image types
                    $info = array(
                        'content-type' => $filedata['mime'],
                        'content-length' => filesize($filepath),
                        'name' => $filename,
                        'path' => $filepath,
                        'width' => empty($filedata[0]) ? 0 : $filedata[0],
                        'height' => empty($filedata[1]) ? 0 : $filedata[1],
                        'uri' => $api->getResourceURI(array($bean->module_dir, $bean->id, 'file', $field)),
                    );
                } elseif ($def['type'] == 'file') {
                    require_once 'include/download_file.php';
                    $download = new DownloadFileApi($api);
                    $info = $download->getFileInfo($bean, $field);
                    if (!empty($info) && empty($info['uri'])) {
                        $info['uri'] = $api->getResourceURI(array($bean->module_dir, $bean->id, 'file', $field));
                    }
                }
            }
        }

        return $info;
    }
}
