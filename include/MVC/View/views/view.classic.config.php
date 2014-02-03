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

/*
 * Created on Apr 23, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 $view_config = array(
	'req_params' =>
		array(
		    'print' => array('param_value' => true,
		                     'config' => array(
		                                  'show_header' => true,
		                                  'show_footer' => false,
		                                  'view_print'  => true,
		                                  'show_title' => false,
                                          'show_subpanels' => false,
                                          'show_javascript' => true,
                                          'show_search' => false,)
                       ),
			'to_pdf' => array('param_value' => true,
							   'config' => array(
		 										'show_all' => false
		 										),
		 				),
		 	'to_csv' => array('param_value' => true,
							   'config' => array(
		 										'show_all' => false
		 										),
		 				),
		),
 );
?>
