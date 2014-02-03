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

$viewdefs['Accounts']['base']['layout']['subpanels'] = array (
  'components' => array (
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_MEMBER_ORG_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'members',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_CONTACTS_SUBPANEL_TITLE',
      'override_subpanel_list_view' => 'subpanel-for-accounts',
      'context' => array (
        'link' => 'contacts',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_OPPORTUNITIES_SUBPANEL_TITLE',
      'override_subpanel_list_view' => 'subpanel-for-accounts',
      'context' => array (
        'link' => 'opportunities',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_LEADS_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'leads',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_CASES_SUBPANEL_TITLE',
      'override_subpanel_list_view' => 'subpanel-for-accounts',
      'context' => array (
        'link' => 'cases',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_BUGS_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'bugs',
      ),
    ),
      array (
          'layout' => 'subpanel',
          'label' => 'LBL_PRODUCTS_SUBPANEL_TITLE',
          'context' => array (
              'link' => 'products',
          ),
      ),
      array (
      'layout' => 'subpanel',
      'label' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
      'context' => array (
        'link' => 'documents',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_QUOTES_SUBPANEL_TITLE',
      'override_subpanel_list_view' => 'subpanel-for-accounts',
      'context' => array (
        'link' => 'quotes',
        'collectionOptions' => array(
          'params' => array(
            'ignore_role' => 1,  //See SP-1305 and BR-344. Load Quotes from all link types (both quotes, quotes_shipto).
          ),
        ),
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE',
      'context' => array (
          'link' => 'campaigns',
      ),
    ),
    array (
      'layout' => 'subpanel',
      'label' => 'LBL_CONTRACTS_SUBPANEL_TITLE',
      'override_subpanel_list_view' => 'subpanel-for-accounts',
      'context' => array (
          'link' => 'contracts',
      ),
    ),
  ),
  'type' => 'subpanels',
  'span' => 12,
);
