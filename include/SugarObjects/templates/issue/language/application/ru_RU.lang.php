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


















$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_type_dom' => 
  array (
    'Administration' => 'Ведение',
    'Product' => 'Результат',
    'User' => 'Клиентское',
  ),
  $object_name.'_status_dom' => 
  array (
    'New' => 'Новое',
    'Assigned' => 'Назначенное',
    'Closed' => 'Закрыто',
    'Pending Input' => 'Ожидание решения',
    'Rejected' => 'Отклонено',
    'Duplicate' => 'Дублировать',
  ),
  $object_name.'_priority_dom' => 
  array (
    'P1' => 'Высокий',
    'P2' => 'Средний',
    'P3' => 'Низкий',
  ),
  $object_name.'_resolution_dom' => 
  array (
    '' => ' ',
    'Accepted' => 'Принято',
    'Duplicate' => 'Дублировать',
    'Closed' => 'Закрыто',
    'Out of Date' => 'Устарело',
    'Invalid' => 'Недействительно',
  ),
);

