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


require_once "Encoding.php";      // needs to know the valid encodings that are available for email
require_once "EmailIdentity.php"; // requires EmailIdentity for representing email senders and recipients
require_once "EmbeddedImage.php"; // requires Attachment and EmbeddedImage, which imports Attachment

// external imports
require_once "modules/OutboundEmailConfiguration/OutboundEmailConfiguration.php"; // needs to take on an
                                                                                  // OutboundEmailConfiguration or a
                                                                                  // type that derives from it

/**
 * This defines the basic interface that is expected from a Mailer.
 *
 * @interface
 */
interface IMailer
{
    /**
     * @abstract
     * @access public
     * @param OutboundEmailConfiguration $config required
     */
    public function __construct(OutboundEmailConfiguration $config);

    /**
     * Set the object properties back to their initial default values.
     *
     * @abstract
     * @access public
     */
    public function reset();

    /**
     * Replaces the existing email headers with the headers passed in as a parameter.
     *
     * @abstract
     * @access public
     * @param EmailHeaders $headers required
     */
    public function setHeaders(EmailHeaders $headers);

    /**
     * Returns the value currently representing the header.
     *
     * @access public
     * @param string $key required Should look like the real header it represents.
     * @return mixed Refer to EmailHeaders::getHeader to see the possible return types.
     */
    public function getHeader($key);

    /**
     * Adds or replaces header values.
     *
     * @access public
     * @param string $key   required Should look like the real header it represents.
     * @param mixed  $value          The value of the header.
     * @throws MailerException
     */
    public function setHeader($key, $value = null);

    /**
     * Adds or replaces the Subject header.
     *
     * @access public
     * @param string $subject
     * @throws MailerException
     */
    public function setSubject($subject = null);

    /**
     * Restores the email headers to a fresh EmailHeaders object.
     *
     * @abstract
     * @access public
     */
    public function clearHeaders();

    /**
     * Clears the recipients from the selected recipient lists. By default, clear all recipients.
     *
     * @abstract
     * @access public
     * @param bool $to  true=clear the To list; false=leave the To list alone
     * @param bool $cc  true=clear the CC list; false=leave the CC list alone
     * @param bool $bcc true=clear the BCC list; false=leave the BCC list alone
     */
    public function clearRecipients($to = true, $cc = true, $bcc = true);

    /**
     * Adds recipients to the To list.
     *
     * @abstract
     * @access public
     * @param array $recipients Array of EmailIdentity objects.
     */
    public function addRecipientsTo($recipients = array());

    /**
     * Removes the recipients from the To list.
     *
     * @abstract
     * @access public
     */
    public function clearRecipientsTo();

    /**
     * Adds recipients to the CC list.
     *
     * @abstract
     * @access public
     * @param array $recipients Array of EmailIdentity objects.
     */
    public function addRecipientsCc($recipients = array());

    /**
     * Removes the recipients from the CC list.
     *
     * @abstract
     * @access public
     */
    public function clearRecipientsCc();

    /**
     * Adds recipients to the BCC list.
     *
     * @abstract
     * @access public
     * @param array $recipients Array of EmailIdentity objects.
     */
    public function addRecipientsBcc($recipients = array());

    /**
     * Removes the recipients from the BCC list.
     *
     * @abstract
     * @access public
     */
    public function clearRecipientsBcc();

    /**
     * Returns the plain-text part of the email.
     *
     * @access public
     * @return string
     */
    public function getTextBody();

    /**
     * Sets the plain-text part of the email.
     *
     * @abstract
     * @access public
     * @param string $body
     */
    public function setTextBody($body = null);

    /**
     * Returns the HTML part of the email.
     *
     * @access public
     * @return string
     */
    public function getHtmlBody();

    /**
     * Sets the HTML part of the email.
     *
     * @abstract
     * @access public
     * @param string $body
     */
    public function setHtmlBody($body = null);

    /**
     * Adds an attachment from a path on the filesystem.
     *
     * @abstract
     * @access public
     * @param Attachment $attachment
     */
    public function addAttachment(Attachment $attachment);

    /**
     * Removes any existing attachments by restoring the container to an empty array.
     *
     * @abstract
     * @access public
     */
    public function clearAttachments();

    /**
     * Performs the send of an email using the package that is being used to deliver email.
     *
     * @abstract
     * @access public
     * @throws MailerException
     */
    public function send();
}
