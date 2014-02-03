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
 

$viewdefs ['Accounts'] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          'SAVE',
          'CANCEL',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        array (
          'label' => '10',
          'field' => '30',
        ),
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'includes' => 
      array (
        array (
          'file' => 'modules/Accounts/Account.js',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        array (
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
        ),
        array (
          array (
            'name' => 'website',
          ),
          array (
            'name' => 'phone_office',
          ),
        ),
        array (
          array (
            'name' => 'email1',
          ),
          array (
            'name' => 'phone_fax',
          ),
        ),
        array (
          array (
            'name' => 'industry',
          ),
          array (
            'name' => 'account_type',
          ),
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
); 
 
?>