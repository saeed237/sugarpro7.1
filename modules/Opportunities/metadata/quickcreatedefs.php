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

/*********************************************************************************

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs = array (
  'Opportunities' => 
  array (
    'QuickCreate' => 
    array (
      'templateMeta' => 
      array (
        'maxColumns' => '2',
        'widths' => 
        array (
          0 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
          1 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
        ),
        'javascript' => '{$PROBABILITY_SCRIPT}',
      ),
      'panels' => 
      array (
        'DEFAULT' => 
        array (
          array (
            array (
              'name' => 'name',
              'displayParams'=>array('required'=>true),
            ),
            array (
              'name' => 'account_name',
            ),
          ),
          array (
            array (
              'name' => 'currency_id',
            ),
            array (
              'name' => 'opportunity_type',
            ),            
          ),
          array (
            'amount',
            'date_closed'          
          ),
          array (
             'next_step',
             'sales_stage',
          ),
          array (
             'lead_source',
             'probability',
          ),
        array (
            array (
              'name' => 'assigned_user_name',
            ),
            array (
              'name' => 'team_name',
            ),
        ),
        ),
      ),
    ),
  ),
);
?>
