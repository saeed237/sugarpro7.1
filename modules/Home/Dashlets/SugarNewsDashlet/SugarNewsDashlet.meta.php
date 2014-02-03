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

 
global $app_strings;

$dashletMeta['SugarNewsDashlet'] = array('module'		=> 'Home',
                                          'title'       => translate('LBL_DASHLET_SUGAR_NEWS', 'Home'),
                                          'description' => 'A customizeable portal page',
                                          'icon'        => 'themes/default/images/icon_SugarNews_32.gif',
                                          'category'    => 'Tools');