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
  'Bugs' => 
  array (
    'QuickCreate' => 
    array (
      'templateMeta' => 
      array (
        'form' => 
        array (
          'hidden' => 
          array (
            0 => '<input type="hidden" name="account_id" value="{$smarty.request.account_id}">',
            1 => '<input type="hidden" name="contact_id" value="{$smarty.request.contact_id}">',
          ),
        ),
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
      ),
      'panels' => 
      array (
        'DEFAULT' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'priority',
            ),
            1 => 
            array (
              'name' => 'assigned_user_name',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'source',
            ),
            1 => 
            array (
              'name' => 'team_name',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'type',
            ),
            1 => 
            array (
              'name' => 'status',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'product_category',
            ),
            1 => 
            array (
              'name' => 'found_in_release',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'name',
              'displayParams'=>array('required'=>true),
            ),
          ),
          5 => 
          array (
            0 => 
            array (
              'name' => 'description',
            ),
          ),
        ),
      ),
    ),
  ),
);
?>
