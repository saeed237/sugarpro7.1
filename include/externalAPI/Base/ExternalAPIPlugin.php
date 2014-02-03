<?php
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
 * External API interface
 * @api
 */
interface ExternalAPIPlugin {
    /**
     * Check if this API supports certain authentication method
     * If $method is empty, return the list of supported methods
     * @param string $method
	 * @return array|bool
     */
    public function supports($method = '');
    /**
     * Load data from EAPM bean
     * @param EAPM $eapmBean
     */
    public function loadEAPM($eapmBean);
    /**
     * Check if the data from the bean are good for login
     * @param EAPM $eapmBean
     * @return bool
     */
    public function checkLogin($eapmBean = null);
    /**
     * Log out from the service
     */
    public function logOff();
}