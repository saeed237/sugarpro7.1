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
require_once('include/SugarSmarty/plugins/function.sugar_replace_vars.php');

class SugarFieldLink extends SugarFieldBase {
    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties) {
    	// this is only for generated links
    	if(isset($bean->field_defs[$fieldName]['gen']) && $bean->field_defs[$fieldName]['gen'] == 1) {
	        $params = array(
	            'use_curly' => true,
	            'subject' => $bean->field_defs[$fieldName]['default'],
	            'fields' => $bean->fetched_row,
	            );
			$nothing = '';
	        $data[$fieldName] = smarty_function_sugar_replace_vars($params, $nothing);
	    } else {
            parent::apiFormatField($data, $bean, $args, $fieldName, $properties);
        }
    }
}
