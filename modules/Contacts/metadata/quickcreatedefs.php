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
  'Contacts' => 
  array (
    'QuickCreate' => 
    array (
      'templateMeta' => 
      array (
        'form' => 
        array (
          'hidden' => 
          array (
            '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
            '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
            '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
            '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
            '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
            '{if !empty($smarty.request.contact_id)}<input type="hidden" name="reports_to_id" value="{$smarty.request.contact_id}">{/if}',
            '{if !empty($smarty.request.contact_name)}<input type="hidden" name="report_to_name" value="{$smarty.request.contact_name}">{/if}',
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
      ),
      'panels' => 
      array (
        'default' => 
        array (

          array (

            array (
              'name' => 'first_name',
                'customCode' => '{html_options name="salutation" id="salutation" options=$fields.salutation.options selected=$fields.salutation.value}'
                . '&nbsp;<input name="first_name" id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
            ),

            array (
              'name' => 'account_name',
            ),
          ),

          array (

            array (
              'name' => 'last_name',
              'displayParams'=>array('required'=>true),
            ),

            array (
              'name' => 'phone_work',
            ),
          ),

          array (

            array (
              'name' => 'title',
            ),

            array (
              'name' => 'phone_mobile',
            ),
          ),

          array (

            array (
              'name' => 'phone_fax',
            ),

            array (
              'name' => 'do_not_call',
            ),
          ),

          array (
            array (
              'name' => 'email1',
            ),
            array (
              'name' => 'lead_source',
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
  ),
);
?>
