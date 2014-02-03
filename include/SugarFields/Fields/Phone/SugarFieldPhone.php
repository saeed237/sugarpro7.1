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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldPhone extends SugarFieldBase {
    
	/**
     * This should be called when the bean is saved. The bean itself will be passed by reference
     * 
     * @param SugarBean bean - the bean performing the save
     * @param array params - an array of paramester relevant to the save, most likely will be $_REQUEST
     */
	public function save($bean, $params, $field, $properties, $prefix = ''){
		 parent::save($bean, $params, $field, $properties, $prefix);
         	 	if (isset($params[$prefix.$field]))
		            $bean->$field = $params[$prefix.$field];
    }    
    
}
?>