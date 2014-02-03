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


/*
 ARGS:

 $_REQUEST['module'] : the module associated with this Bean instance (will be used to get the class name)
 $_REQUEST['prospect_lists'] : the id of the prospect list
 $_REQUEST['uids'] : the ids of the records to be added to the prospect list, separated by ','

 */

require_once 'include/formbase.php';

$focus = BeanFactory::getBean($_REQUEST['module']);

$uids = array();
if($_REQUEST['select_entire_list'] == '1'){
	$order_by = '';

	require_once('include/MassUpdate.php');
	$mass = new MassUpdate();
	$mass->generateSearchWhere($_REQUEST['module'], $_REQUEST['current_query_by_page']);
	$ret_array = create_export_query_relate_link_patch($_REQUEST['module'], $mass->searchFields, $mass->where_clauses);
	$query = $focus->create_export_query($order_by, $ret_array['where'], $ret_array['join']);
	$result = $GLOBALS['db']->query($query,true);
	$uids = array();
	while($val = $GLOBALS['db']->fetchByAssoc($result,false))
	{
		array_push($uids, $val['id']);
	}
}
else{
	$uids = explode ( ',', $_POST['uids'] );
}

// find the relationship to use
$relationship = '';
foreach($focus->get_linked_fields() as $field => $def) {
    if ($focus->load_relationship($field)) {
        if ( $focus->$field->getRelatedModuleName() == 'ProspectLists' ) {
            $relationship = $field;
            break;
        }
    }
}

if ( $relationship != '' ) {
    foreach ( $uids as $id) {
        $focus->retrieve($id);
        $focus->load_relationship($relationship);
        $focus->prospect_lists->add( $_REQUEST['prospect_list'] );
    }
}
handleRedirect();
exit;
?>
