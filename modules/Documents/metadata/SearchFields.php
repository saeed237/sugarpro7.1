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

$searchFields['Documents'] = 
	array (
		'document_name' => array( 'query_type'=>'default'),
        'category_id'=> array('query_type'=>'default', 'options' => 'document_category_dom', 'template_var' => 'CATEGORY_OPTIONS'),
        'subcategory_id'=> array('query_type'=>'default', 'options' => 'document_subcategory_dom', 'template_var' => 'SUBCATEGORY_OPTIONS'),
		'active_date'=> array('query_type'=>'default'),
		'exp_date'=> array('query_type'=>'default'),
		'assigned_user_id'=> array('query_type'=>'default'),
		'filename' => array(
    		    'query_type' => 'format',
    		    'operator' => 'subquery',
    		    'subquery' => 'SELECT document_revisions.id FROM document_revisions
			           WHERE document_revisions.deleted=0
				   AND document_revisions.filename LIKE \'{0}\'',
                    'db_field' => array(0 => 'document_revision_id')
                ),
		'favorites_only' => array(
            'query_type'=>'format',
			'operator' => 'subquery',
			'subquery' => 'SELECT sugarfavorites.record_id FROM sugarfavorites 
			                    WHERE sugarfavorites.deleted=0 
			                        and sugarfavorites.module = \'Documents\' 
			                        and sugarfavorites.assigned_user_id = \'{0}\'',
			'db_field'=>array('id')),
		//Range Search Support 
	    'range_date_entered' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
	    'start_range_date_entered' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
	    'end_range_date_entered' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
	    'range_date_modified' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
	    'start_range_date_modified' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
        'end_range_date_modified' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),	
	    //Range Search Support 			
	);
?>
