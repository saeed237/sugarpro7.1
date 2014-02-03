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



$searchdefs['PdfManager'] =
array (
  'layout' =>
  array (
    'basic_search' =>
    array (
      'name' =>
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'base_module' =>
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_BASE_MODULE',
        'width' => '10%',
        'name' => 'base_module',
      ),
      'published' =>
      array (
        'name' => 'published',
        'default' => true,
        'width' => '10%',
      ),      
      'team_name' =>
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TEAMS',
        'id' => 'TEAM_ID',
        'width' => '10%',
        'default' => true,
        'name' => 'team_name',
      ),
    ),
    'advanced_search' =>
    array (),
  ),
  'templateMeta' =>
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' =>
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
