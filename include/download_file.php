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


// Check to see if we have already registered our upload stream wrapper
if (!in_array('upload', stream_get_wrappers())) {
    require_once 'include/upload_file.php';
    UploadStream::register();
}

/**
 * Class to handle downloading of files. Should eventually replace download.php
 */
class DownloadFile {
    /**
     * Gets a file and returns an HTTP response with the contents of the request file for download
     *
     * @param SugarBean $bean The SugarBean to get the file for
     * @param string $field The field name to get the file for
     * @param boolean $forceDownload force to download the file if true.
     */
    public function getFile(SugarBean $bean, $field, $forceDownload = false) {
        if ($this->validateBeanAndField($bean, $field, 'file') || $this->validateBeanAndField($bean, $field, 'image')) {
            $def = $bean->field_defs[$field];

            if ($def['type'] == 'image') {
                $info = $this->getImageInfo($bean, $field);
            } elseif ($def['type'] == 'file') {
                $info = $this->getFileInfo($bean, $field);

                require_once 'include/SugarFields/SugarFieldHandler.php';
                $sfh = new SugarFieldHandler();
                /* @var $sf SugarFieldFile */
                $sf = $sfh->getSugarField($def['type']);

                //If the requested file is not a supported image type, we should force a download.
                if (!$forceDownload && !in_array($info['content-type'], $sf::$imageFileMimeTypes)) {
                    $forceDownload = true;
                }
            }

            if ($info) {
                $this->outputFile($forceDownload, $info);
            } else {
                // @TODO Localize this exception message
                throw new Exception('File information could not be retrieved for this record');
            }
        }
    }

    /**
     * Sends an HTTP response with the contents of the request file for download
     *
     * @param boolean $forceDownload force to download the file if true.
     * @param array $info Array containing the file details.
     */
    public function outputFile($forceDownload, array $info) {
        header("Pragma: public");
        header("Cache-Control: maxage=1, post-check=0, pre-check=0");

        if (!$forceDownload) {
            header("Content-Type: {$info['content-type']}");
        } else {
            header("Content-Type: application/force-download");
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"".$info['name']."\";");
        }
        header("X-Content-Type-Options: nosniff");
        header("Content-Length: " . filesize($info['path']));
        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
        set_time_limit(0);
        ob_start();

            readfile($info['path']);
        @ob_end_flush();
    }

    /**
     * Gets the server path to a file named $fileid
     *
     * @param string $fileid The name of the file to get - Can be a path as well
     * @return string
     */
    public function getFilePathFromId($fileid) {
        return 'upload://' . $fileid;
    }

    /**
     * Gets file info for a bean and field type image
     *
     * @param SugarBean $bean The bean to get the info for
     * @param string $field The field name to get the file information for
     * @return array|bool
     */
    public function getImageInfo($bean, $field) {
        if ($this->validateBeanAndField($bean, $field, 'image')) {
            $filename = $bean->{$field};
            $filepath = $this->getFilePathFromId($filename);

            // Quick existence check to make sure we are actually working
            // on a real file
            if (!file_exists($filepath)) {
                return false;
            }

            $filedata = getimagesize($filepath);

            $info = array(
                'content-type' => $filedata['mime'],
                'content-length' => filesize($filepath),
                'name' => $filename,
                'path' => $filepath,
            );
            return $info;
        }
    }

    /**
     * This function makes sure the bean exists, the field exists in the bean and is the expected type
     *
     * @param SugarBean $bean The SugarBean to get the file for
     * @param string $field The field name to get the file for
     * @param string $type the type of the field
     * @return bool
     * @throws Exception
     */
    private function validateBeanAndField($bean, $field, $type) {
        if (!$bean instanceof SugarBean || empty($bean->id) || empty($bean->{$field})) {
            // @TODO Localize this exception message
            throw new Exception('Invalid SugarBean');
            return false;
        }
        if (!isset($bean->field_defs[$field])) {
            // @TODO Localize this exception message
            throw new Exception('Missing field definitions for ' . $field);
            return false;
        }
        if (!isset($bean->field_defs[$field]['type']) || $bean->field_defs[$field]['type'] != $type) {
            return false;
        }
        return true;
    }

    /**
     * Gets file info for a bean and field type file
     *
     * @param SugarBean $bean The bean to get the info for
     * @param string $field The field name to get the file information for
     * @return array|bool
     */
    public function getFileInfo($bean, $field) {
        if ($this->validateBeanAndField($bean, $field, 'file')) {
                    // Default the file id and url
                    $fileid  = $bean->id;
                    $fileurl = '';

                    // Handle special cases, like Documents and KBDocumentRevisions
                    if (isset($bean->object_name)) {
                        if ($bean->object_name == 'Document') {
                            // Documents store their file information in DocumentRevisions
                            $revision = BeanFactory::retrieveBean('DocumentRevisions', $bean->id);

                            if (!empty($revision)) {
                                $fileid  = $revision->id;
                                $name    = $revision->filename;
                                $fileurl = empty($revision->doc_url) ? '' : $revision->doc_url;
                            } else {
                                // The id is not a revision id, try the actual document revision id
                                $revision = BeanFactory::retrieveBean('DocumentRevisions', $bean->document_revision_id);

                                if (!empty($revision)) {
                                    // Revision will hold the file id AND the file name
                                    $fileid = $revision->id;
                                    $name   = $revision->filename;
                                    $fileurl = empty($revision->doc_url) ? '' : $revision->doc_url;
                                } else {
                                    // Nothing to find
                                    return false;
                                }
                            }
                        } elseif ($bean->object_name == 'KBDocument') {
                            // Sorta the same thing with KBDocuments
                            $revision = BeanFactory::getBean('KBDocumentRevisions', $bean->id);

                            if (!empty($revision)) {
                                $revision = BeanFactory::getBean('DocumentRevisions', $revision->document_revision_id);
                                // Last change to fail, if nothing found, return false
                                if (empty($revision)) {
                                    return false;
                                }

                                $fileid = $revision->id;
                                $name   = $revision->filename;
                                $fileurl = empty($revision->doc_url) ? '' : $revision->doc_url;
                            } else {
                                // Try the kbdoc revision
                                $revision = BeanFactory::getBean('KBDocumentRevisions', $bean->kbdocument_revision_id);
                                if (!empty($revision)) {
                                    $revision = BeanFactory::getBean('DocumentRevisions', $revision->document_revision_id);
                                    // Last change to fail, if nothing found, return false
                                    if (empty($revision)) {
                                        return false;
                                    }

                                    $fileid = $revision->id;
                                    $name   = $revision->filename;
                                    $fileurl = empty($revision->doc_url) ? '' : $revision->doc_url;
                                } else {
                                    return false;
                                }
                            }
                        }
                    } else {
                        $fileid = $bean->id;
                        $fileurl  = '';
                    }

                    $filepath = $this->getFilePathFromId($fileid);

                    // Quick existence check to make sure we are actually working
                    // on a real file
                    if (!file_exists($filepath)) {
                        return false;
                    }

                    if (empty($fileurl) && !empty($bean->doc_url)) {
                        $fileurl = $bean->doc_url;
                    }

                    // Get our filename if we don't have it already
                    if (empty($name)) {
                        $name = $bean->getFileName();
                    }

                    return array(
                        'content-type' => $this->getMimeType($filepath),
                        'content-length' => filesize($filepath),
                        'name' => $name,
                        'uri' => $fileurl,
                        'path' => $filepath,
                    );
        } else {
            return null;
        }
    }

    /**
     * Gets the mime type of a file
     *
     * @param string $filename Path to the file
     * @return string|false The string mime type or false if the file does not exist
     */
    public function getMimeType($filename) {
        return get_file_mime_type($filename);
    }

    /**
     * Gets the contents of a file
     *
     * @param string $filename Path to the file
     * @return string
     */
    public function getFileByFilename($file)
    {
        if(!file_exists($file))
        {
            // handle exception elsewhere
            throw new Exception('File could not be retrieved', 'FILE_DOWNLOAD_INCORRECT_DEF_TYPE');
        }

        return file_get_contents($file);

    }
}

/**
 * File downloading for API
 */
class DownloadFileApi extends DownloadFile
{
    /**
     * API object
     * @var ServiceBase
     */
    protected $api;

    public function __construct(ServiceBase $api)
    {
        $this->api = $api;
    }

    /**
     * Sends an HTTP response with the contents of the request file for download
     *
     * @param boolean $forceDownload true if force to download the file
     * @param array $info Array containing the file details.
     * Currently supported:
     * - content-type - content type for the file
     *
     */
    public function outputFile($forceDownload, array $info)
    {
        if(empty($info['path'])) {
            throw new SugarApiException('No file name supplied');
        }

        $this->api->setHeader("Expires", TimeDate::httpTime(time() + 2592000));

        if (!$forceDownload) {
            if(!empty($info['content-type'])) {
                $this->api->setHeader("Content-Type", $info['content-type']);
            } else {
                $this->api->setHeader("Content-Type", "application/octet-stream");
            }
        } else {
            $this->api->setHeader("Content-Type", "application/force-download");
            $this->api->setHeader("Content-type", "application/octet-stream");
            if(empty($info['name'])) {
                $info['name'] = pathinfo($info['path'], PATHINFO_BASENAME);
            }
            $this->api->setHeader("Content-Disposition", "attachment; filename=\"".$info['name']."\";");
        }
        $this->api->fileResponse($info['path']);
    }
}
