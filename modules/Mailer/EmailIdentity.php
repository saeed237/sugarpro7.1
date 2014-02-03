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

/**
 * This class encapsulates properties and behavior of email identities, which are the email address and a name, if one
 * is associated with the email address. An email identity can be considered to look like "Bob Smith" <bsmith@yahoo.com>
 * in practice.
 */
class EmailIdentity
{
    // private members
    private $email; // The email address used in this identity.
    private $name;  // The name that accompanies the email address.

    /**
     * @access public
     * @param string      $email required
     * @param string|null $name  Should be a string unless no name is associated with the email address.
     */
    public function __construct($email, $name = null) {
        $this->setEmail($email);
        $this->setName($name);
    }

    /**
     * @access public
     * @param string $email required
     * @throws MailerException
     * @todo still need to do more to validate the email address
     */
    public function setEmail($email) {
        // validate the email address
        if (!is_string($email) || trim($email) == "") {
            //@todo stringify $email and add it to the message
            throw new MailerException("Invalid email address", MailerException::InvalidEmailAddress);
        }

        $this->email = trim($email);
    }

    /**
     * @access public
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @access public
     * @param string|null $name required Should be a string unless no name is associated with the email address.
     */
    public function setName($name) {
        // if $name is null, then trim will return an empty string, which is perfectly acceptable
        $this->name = trim($name);
    }

    /**
     * Returns a string if a name exists, or an empty string or null if a name does not exist.
     *
     * @access public
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Convert special HTML entities back to characters in cases where the email address contains characters that are
     * considered invalid for email. Call this method on the object before transferring the object or its email property
     * to a package that is being used to deliver email.
     *
     * @access public
     * @bug 31778
     */
    public function decode() {
        // add back in html characters (apostrophe ' and ampersand &) to email addresses
        // this was causing email bounces in names like "O'Reilly@example.com" being sent over as "O&#039;Reilly@example.com"
        // transferred from the commit found at https://github.com/sugarcrm/Mango/commit/67b9144cd7bfa5425a98e28a1f7d9e994c7826bc
        $this->email = htmlspecialchars_decode($this->email, ENT_QUOTES);
    }
}
