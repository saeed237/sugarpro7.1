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


/**
 * This class defines valid encodings to aid in maintaining a list of valid encodings that can be referenced from a
 * single source.
 */
class Encoding
{
    const EightBit        = "8bit";
    const SevenBit        = "7bit";
    const Binary          = "binary";
    const Base64          = "base64";
    const QuotedPrintable = "quoted-printable";

    /**
     * Returns true/false indicating whether or not $encoding is a valid, known encoding for the context of a Mailer.
     *
     * @static
     * @access public
     * @param string $encoding required
     * @return bool
     */
    public static function isValid($encoding) {
        switch ($encoding) {
            case self::EightBit:
            case self::SevenBit:
            case self::Binary:
            case self::Base64:
            case self::QuotedPrintable:
                return true;
                break;
            default:
                return false;
                break;
        }
    }
}
