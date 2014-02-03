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
  'Prospects' => 
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
      ),
      'panels' => 
      array (
        'LBL_PROSPECT_INFORMATION' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'first_name',
            ),
            1 => 
            array (
              'name' => 'phone_work',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'last_name',
              'displayParams'=>array('required'=>true)
            ),
            1 => 
            array (
              'name' => 'phone_mobile',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'account_name',
            ),
            1 => 
            array (
              'name' => 'phone_fax',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'title',
            ),
            1 => 
            array (
              'name' => 'department',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'team_name',
            ),
            1 => 
            array (
              'name' => 'do_not_call',
            ),
          ),
          5 => 
          array (
            0 => 
            array (
              'name' => 'assigned_user_name',
            ),
          ),
        ),
        'lbl_email_addresses' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'email1',
            ),
          ),
        ),
        'LBL_ADDRESS_INFORMATION' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'primary_address_street',
            ),
            1 => 
            array (
              'name' => 'alt_address_street',
            ),
          ),
        ),
      ),
    ),
  ),
);
?>
