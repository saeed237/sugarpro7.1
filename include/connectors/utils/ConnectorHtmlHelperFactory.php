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
 * Connector's HTML helper factory
 * @api
 */
class ConnectorHtmlHelperFactory
{
    const CONNECTOR_HTML_HELPER_MAIN = 'include/connectors/utils/ConnectorHtmlHelper.php';
    const CONNECTOR_HTML_HELPER_CUSTOM = 'custom/include/connectors/utils/ConnectorHtmlHelper.php';

    /**
     * Return instance of HTML helper class
     *
     * @return ConnectorHtmlHelper
     */
    public static function build()
    {
        if (file_exists(self::CONNECTOR_HTML_HELPER_CUSTOM))
        {
            require_once(self::CONNECTOR_HTML_HELPER_CUSTOM);
        }
        else
        {
            require_once(self::CONNECTOR_HTML_HELPER_MAIN);
        }
        return new ConnectorHtmlHelper();
    }
}