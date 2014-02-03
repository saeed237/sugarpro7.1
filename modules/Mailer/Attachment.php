<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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


require_once "MailerException.php"; // requires MailerException in order to throw exceptions of that type
require_once "Encoding.php";        // needs the valid encodings defined in Encoding

/**
 * This class encapsulates properties and behavior of an attachment so that a common interface can be expected
 * no matter what package is being used to deliver email.
 */
class Attachment
{
    // protected members
    protected $path;     // Path to the file being attached.
    protected $name;     // Name of the file to be used to identify the attachment.
    protected $encoding; // The encoding used on the file. Should be one of the valid encodings from Encoding.
    protected $mimeType; // Should be a valid MIME type.

    /**
     * @access public
     * @param string      $path     required
     * @param null|string $name     Should be a string, but null is acceptable if the path will be used for the name.
     * @param string      $encoding
     * @param string      $mimeType
     */
    public function __construct($path, $name = null, $encoding = Encoding::Base64, $mimeType = "") {
        $this->setPath($path);
        $this->setName($name);
        $this->setMimeType($mimeType);
        $this->setEncoding($encoding);
    }

    /**
     * @access public
     * @param string $path required
     */
    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * @access public
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @access public
     * @param null|string $name required Should be a string, but null is acceptable if the path will be used for the name.
     */
    public function setName($name) {
        if (!is_string($name) || $name == "") {
            // derive the name from the path if the name is invalid
            $name = basename($this->path);
        }

        $this->name = trim($name);
    }

    /**
     * @access public
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @access public
     * @param string $encoding
     * @throws MailerException
     */
    public function setEncoding($encoding = Encoding::Base64) {
        if (!Encoding::isValid($encoding)) {
            throw new MailerException(
                "Invalid Attachment: encoding is invalid",
                MailerException::InvalidAttachment
            );
        }

        $this->encoding = $encoding;
    }

    /**
     * @access public
     * @return string
     */
    public function getEncoding() {
        return $this->encoding;
    }

    /**
     * @access public
     * @param string $mimeType
     */
    public function setMimeType($mimeType = "") {
        $this->mimeType = $mimeType;
    }

    /**
     * @access public
     * @return string
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * Returns an array representation of the attachment.
     *
     * @access public
     * @return array Array of key value pairs representing the properties of the attachment.
     */
    public function toArray() {
        return array(
            "path"     => $this->getPath(),
            "name"     => $this->getName(),
            "encoding" => $this->getEncoding(),
            "mimetype" => $this->getMimeType(),
        );
    }
}
