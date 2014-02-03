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


require_once "OutboundEmailConfiguration.php"; // requires OutboundEmailConfiguration in order to extend it

/**
 * Represents the configurations and contains the logic for setting the configurations for an SMTP Mailer.
 *
 * @extends OutboundEmailConfiguration
 */
class OutboundSmtpEmailConfiguration extends OutboundEmailConfiguration
{
    // constants used for documenting which security protocol configurations are valid
    const SecurityProtocolNone = "";
    const SecurityProtocolSsl  = "ssl";
    const SecurityProtocolTls  = "tls";

    // private members
    private $host;             // the hostname of the SMTP server to use
    private $port;             // the SMTP port to use on the server
    private $securityProtocol; // the SMTP connection prefix ("", "ssl" or "tls")
    private $authenticate;     // true=require authentication on the SMTP server
    private $username;         // the username to use if authenticate=true
    private $password;         // the password to use if authenticate=true

    /**
     * Extends the default configurations for this sending strategy. Adds default SMTP configurations needed to send
     * email over SMTP using PHPMailer.
     *
     * @access public
     */
    public function loadDefaultConfigs() {
        parent::loadDefaultConfigs(); // load the base defaults

        $this->setMode();
        $this->setHost();
        $this->setPort();
        $this->setSecurityProtocol();
        $this->setAuthenticationRequirement();
        $this->setUsername();
        $this->setPassword();
    }

    /**
     * @param null|string $mode
     * @throws MailerException
     */
    public function setMode($mode = null) {
        if (empty($mode)) {
            $mode = OutboundEmailConfigurationPeer::MODE_SMTP;
        }

        parent::setMode($mode);
    }

    /**
     * Sets or overwrites the host configuration. Multiple hosts can be supplied, but all hosts must be separated by a
     * semicolon (e.g. "smtp1.example.com;smtp2.example.com") and hosts will be tried in the order they are provided.
     *
     * The port for the host can be defined using the format:
     *
     *      host:port
     *
     * @access public
     * @param string $host required
     * @throws MailerException
     */
    public function setHost($host = "localhost") {
        if (!is_string($host)) {
            throw new MailerException(
                "Invalid Configuration: host must be a domain name or IP address (string) resolving to the SMTP server",
                MailerException::InvalidConfiguration
            );
        }

        $this->host = $host;
    }

    /**
     * Returns the host configuration.
     *
     * @access public
     * @return string
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Sets or overwrites the port number configuration. Default to 25, which is the default port number for SMTP.
     *
     * @access public
     * @param int $port required A numeric string is acceptable, as it can be casted to an integer.
     * @throws MailerException
     */
    public function setPort($port = 25) {
        if (!is_numeric($port)) {
            throw new MailerException(
                "Invalid Configuration: SMTP port must be an integer",
                MailerException::InvalidConfiguration
            );
        }

        $this->port = (int) $port;
    }

    /**
     * Returns the port number configuration.
     *
     * @access public
     * @return int
     */
    public function getPort() {
        return $this->port;
    }

    /**
     * Sets or overwrites the security protocol configuration.
     *
     * @access public
     * @param string $securityProtocol required
     * @throws MailerException
     */
    public function setSecurityProtocol($securityProtocol = self::SecurityProtocolNone) {
        if (!self::isValidSecurityProtocol($securityProtocol)) {
            throw new MailerException(
                "Invalid Configuration: security protocol is invalid",
                MailerException::InvalidConfiguration
            );
        }

        $this->securityProtocol = $securityProtocol;
    }

    /**
     * Returns the security protocol configuration.
     *
     * @access public
     * @return string
     */
    public function getSecurityProtocol() {
        return $this->securityProtocol;
    }

    /**
     * Sets the requirement for authenticating with the SMTP server.
     *
     * @access public
     * @param bool $required required
     * @throws MailerException
     */
    public function setAuthenticationRequirement($required = false) {
        if (!is_bool($required)) {
            throw new MailerException(
                "Invalid Configuration: must be a boolean to determine authentication requirements",
                MailerException::InvalidConfiguration
            );
        }

        $this->authenticate = $required;
    }

    /**
     * Returns the configuration indicating whether or not authentication on the SMTP server is required.
     *
     * @access public
     * @return boolean
     */
    public function isAuthenticationRequired() {
        return $this->authenticate;
    }

    /**
     * Sets or overwrites the username configuration.
     *
     * @access public
     * @param string $username required
     * @throws MailerException
     */
    public function setUsername($username = "") {
        if (!is_string($username)) {
            throw new MailerException(
                "Invalid Configuration: username must be a string",
                MailerException::InvalidConfiguration
            );
        }

        $this->username = $username;
    }

    /**
     * Returns the username configuration.
     *
     * @access public
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Sets or overwrites the password configuration.
     *
     * @access public
     * @param string $password required
     * @throws MailerException
     */
    public function setPassword($password = "") {
        if (!is_string($password)) {
            throw new MailerException(
                "Invalid Configuration: password must be a string",
                MailerException::InvalidConfiguration
            );
        }

        $this->password = $password;
    }

    /**
     * Returns the password configuration.
     *
     * @access public
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Returns true/false indicating whether or not $securityProtocol is a valid, known security protocol for
     * the context of a Mailer.
     *
     * @static
     * @access public
     * @param string $securityProtocol required
     * @return bool
     */
    public static function isValidSecurityProtocol($securityProtocol) {
        switch ($securityProtocol) {
            case self::SecurityProtocolNone:
            case self::SecurityProtocolSsl:
            case self::SecurityProtocolTls:
                return true;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * @access public
     * @return array
     */
    public function toArray() {
        $fields = array(
            "host"         => $this->getHost(),
            "port"         => $this->getPort(),
            "authenticate" => $this->isAuthenticationRequired(),
            "securityProtocol" => $this->getSecurityProtocol(),
            "username"     => $this->getUsername(),
            "password"     => $this->getPassword(),
        );
        return array_merge(parent::toArray(), $fields);
    }
}
