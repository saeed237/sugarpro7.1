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


require_once "Attachment.php"; // requires Attachment in order to extend it

/**
 * This class encapsulates properties and behavior of an embedded image, which is a type of attachment, so that a common
 * interface can be expected no matter what package is being used to deliver email.
 *
 * @extends Attachment
 */
class EmbeddedImage extends Attachment
{
    // private members
    private $cid;   // The Content-ID used to reference the image in the message.

    /**
     * @access public
     * @param string      $path     required
     * @param string      $cid      required
     * @param null|string $name              Should be a string, but null is acceptable if the path will be used for
     *                                       the name.
     * @param string      $encoding
     * @param string      $mimeType
     */
    public function __construct($cid, $path, $name = null, $encoding = Encoding::Base64, $mimeType = "") {
        $this->setCid($cid);
        parent::__construct($path, $name, $encoding, $mimeType);
    }

    /**
     * @access public
     * @param string $cid required
     */
    public function setCid($cid) {
        $this->cid = $cid;
    }

    /**
     * @return string
     */
    public function getCid() {
        return $this->cid;
    }

    /**
     * Returns an array representation of the embedded image by adding the Content-ID to the array resulting from
     * calling the parent method of the same name.
     *
     * @access public
     * @return array Array of key value pairs representing the properties of the attachment.
     */
    public function toArray() {
        $image = parent::toArray();
        $image["cid"] = $this->getCid();

        return $image;
    }
}
