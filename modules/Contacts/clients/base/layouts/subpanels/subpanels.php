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

$viewdefs['Contacts']['base']['layout']['subpanels'] = array (
  'components' => array (
    array (
      'layout' => "subpanel",
      'label' => 'LBL_LEADS_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'leads',
      ),
    ),
    array (
      'layout' => "subpanel",
      'label' => 'LBL_OPPORTUNITIES_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'opportunities',
      ),
    ),
    array (
      'layout' => "subpanel",
      'label' => 'LBL_CASES_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'cases',
      ),
    ),
    array (
      'layout' => "subpanel",
      'label' => 'LBL_BUGS_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'bugs',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_DIRECT_REPORTS_SUBPANEL_TITLE',
      'override_subpanel_list_view' => 'subpanel-for-contacts',
      'context' => array (
        'link' => 'direct_reports',
      ),
    ),
    array (
      'layout' => "subpanel",
      'label' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'documents',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_QUOTES_SUBPANEL_TITLE',
        'context' => array (
          'link' => 'quotes',
          'collectionOptions' => array(
            'params' => array(
              'ignore_role' => 1,
            ),
          ),
        ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_CONTRACTS_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'contracts',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'campaigns',
      ),
    ),
  ),
  'type' => 'subpanels',
  'span' => 12,
);
