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


// This is a set of classes that are here temporarialy until we get rid of any dependencies on the files in service/core

class SCErrorObject {
    var $errorMessage;
    function set_error($errorMessage) {
        $this->errorMessage = $errorMessage;
    }
    function error($errorObject) {
        throw new SugarApiExceptionError($errorObject->errorMessage);
    }
}