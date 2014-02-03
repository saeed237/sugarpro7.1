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
require_once "EmbeddedImage.php";   // requires Attachment and EmbeddedImage, which imports Attachment

/**
 * This class encapsulates properties and behavior of an attachment so that a common interface can be expected
 * no matter what package is being used to deliver email.
 */
class AttachmentPeer
{
    /**
     * Constructs an attachment from the SugarBean that is passed in.
     *
     * @static
     * @access public
     * @param SugarBean $bean required
     * @return Attachment
     * @throws MailerException
     */
    public static function attachmentFromSugarBean(SugarBean $bean) {
        $filePath = null;
        $fileName = null;
        $mimeType = "";

        if ($bean instanceof Document) {
            if (empty($bean->id)) {
                throw new MailerException(
                    "Invalid Attachment: document not found",
                    MailerException::InvalidAttachment
                );
            }
            $document_revision_id = $bean->document_revision_id;
            $documentRevision = new DocumentRevision();
            if (!empty($document_revision_id)) {
                $documentRevision->retrieve($bean->document_revision_id);
            }
            if (empty($document_revision_id) || $documentRevision->id != $document_revision_id) {
                throw new MailerException(
                    "Invalid Attachment: Document with Id (" . $bean->id . ")  contains an invalid or empty revision id: (" . $document_revision_id . ")",
                    MailerException::InvalidAttachment
                );
            }
            $bean = $documentRevision;
        }

        $beanName = get_class($bean);
        switch ($beanName) {
            case "Note":
            case "DocumentRevision":
                $filePath = "upload/{$bean->id}";
                $fileName = empty($bean->filename) ? $bean->name : $bean->filename;
                $mimeType = empty($bean->file_mime_type) ? $mimeType : $bean->file_mime_type;
                break;
            default:
                throw new MailerException(
                    "Invalid Attachment: SugarBean '{$beanName}' not supported as an Email Attachment",
                    MailerException::InvalidAttachment
                );
                break;
        }

        // Path must Exist and Must be a Regular File
        if (!is_file($filePath)) {
            throw new MailerException(
                "Invalid Attachment: file not found: {$filePath}",
                MailerException::InvalidAttachment
            );
        }

        $attachment = new Attachment($filePath, $fileName, Encoding::Base64, $mimeType);

        return $attachment;
    }


    /**
     * Constructs an embedded image from the SugarBean that is passed in.
     *
     * @static
     * @access public
     * @param SugarBean $bean required
     * @param $cid required
     * @return EmbeddedImage
     * @throws MailerException
     */
    public static function embeddedImageFromSugarBean(SugarBean $bean, $cid) {
        $beanName = get_class($bean);
        $filePath = null;
        $fileName = null;
        $mimeType = "";

        switch ($beanName) {
            case "Note":
                $filePath = "upload/{$bean->id}";
                $fileName = empty($bean->filename) ? $bean->name : $bean->filename;
                $mimeType = empty($bean->file_mime_type) ? $mimeType : $bean->file_mime_type;
                break;
            default:
                throw new MailerException(
                    "Invalid Attachment: SugarBean '{$beanName}' not supported as an Email EmbeddedImage",
                    MailerException::InvalidAttachment
                );
                break;
        }

        // Path must Exist and Must be a Regular File
        if (!is_file($filePath)) {
            throw new MailerException(
                "Invalid Attachment: file not found: {$filePath}",
                MailerException::InvalidAttachment
            );
        }

        $embeddedImage = new EmbeddedImage($cid, $filePath, $fileName, Encoding::Base64, $mimeType);

        return $embeddedImage;
    }
}
