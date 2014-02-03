<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$viewdefs['Documents']['base']['layout']['tabbed-layout'] = array (
  'components' => 
  array (
    array (
      'view' => 'activitystream',
      'label' => 'Activity Stream',
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Document Revisions',
      'context' => 
      array (
        'link' => 'revisions',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Contracts',
      'context' => 
      array (
        'link' => 'contracts',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Accounts',
      'context' => 
      array (
        'link' => 'accounts',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Contacts',
      'context' => 
      array (
        'link' => 'contacts',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Opportunities',
      'context' => 
      array (
        'link' => 'opportunities',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Cases',
      'context' => 
      array (
        'link' => 'cases',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Bugs',
      'context' => 
      array (
        'link' => 'bugs',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Quotes',
      'context' => 
      array (
        'link' => 'quotes',
      ),
    ),
    array (
      'layout' => 'list-cluster',
      'label' => 'Products',
      'context' => 
      array (
        'link' => 'products',
      ),
    ),
  ),
  'type' => 'simple',
  'span' => 12,
);

