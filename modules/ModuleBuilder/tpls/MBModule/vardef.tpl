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

$dictionary['{{$class.name}}'] = array(
	'table'=>'{{$class.table_name}}',
	'audited'=>{{$class.audited}},
	{{if !($class.templates|strstr:"file")}}
	'duplicate_merge'=>true,
	{{/if}}
	'fields'=>{{$class.fields_string}},
	'relationships'=>{{$class.relationships}},
	'optimistic_locking'=>true,
	{{if !empty($class.table_name) && !empty($class.templates)}}
	'unified_search'=>true,
	{{/if}}
);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('{{$class.name}}','{{$class.name}}', array({{$class.templates}}));
