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


class Metric {
	
    function Metric($type, $name) {
        $this->_name = $name;
        $this->_type = $type;
        $this->_mutable = $name == 'monitor_id' ? false : true;
    }
    
    function type() {
        return $this->_type;	
    }
    
    function name() {
        return $this->_name;
    }
    
    function isMutable() {
        return $this->_mutable;	
    }
    
}
?>