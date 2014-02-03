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

$module_name = 'Campaigns';
$viewdefs[$module_name]['base']['menu']['header'] = array(
    array(
        'route'=>'#bwc/index.php?module=Campaigns&action=WizardHome&return_module=Campaigns&return_action=index',
        'label' =>'LNL_NEW_CAMPAIGN_WIZARD',
        'acl_action'=>'create',
        'acl_module'=>$module_name,
        'icon' => 'icon-magic',
    ),
    array(
        'route'=>'#bwc/index.php?module=Campaigns&action=EditView&return_module=Campaigns&return_action=index',
        'label' =>'LNK_NEW_CAMPAIGN',
        'acl_action'=>'create',
        'acl_module'=>$module_name,
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#bwc/index.php?module=Campaigns&action=index&return_module=Campaigns&return_action=index',
        'label' =>'LNK_CAMPAIGN_LIST',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=Campaigns&action=newsletterlist&return_module=Campaigns&return_action=index',
        'label' =>'LBL_NEWSLETTERS',
        'acl_action'=>'list',
        'acl_module'=>$module_name,
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=EmailTemplates&action=EditView&return_module=EmailTemplates&return_action=DetailView',
        'label' =>'LNK_NEW_EMAIL_TEMPLATE',
        'acl_action'=>'create',
        'acl_module'=>'EmailTemplates',
        'icon' => 'icon-plus',
    ),
    array(
        'route'=>'#bwc/index.php?module=EmailTemplates&action=index',
        'label' =>'LNK_EMAIL_TEMPLATE_LIST',
        'acl_action'=>'list',
        'acl_module'=>'EmailTemplates',
        'icon' => 'icon-reorder',
    ),
    array(
        'route'=>'#bwc/index.php?module=Campaigns&action=WizardEmailSetup&return_module=Campaigns&return_action=index',
        'label' =>'LBL_EMAIL_SETUP_WIZARD',
        'acl_action'=>'admin',
        'acl_module'=>$module_name,
        'icon' => 'icon-cog',
    ),
    array(
        'route'=>'#bwc/index.php?module=Campaigns&action=CampaignDiagnostic&return_module=Campaigns&return_action=index',
        'label' =>'LBL_DIAGNOSTIC_WIZARD',
        'acl_action'=>'edit',
        'acl_module'=>$module_name,
        'icon' => 'icon-bar-chart',
    ),
    array(
        'route'=>'#bwc/index.php?module=Campaigns&action=WebToLeadCreation&return_module=Campaigns&return_action=index',
        'label' =>'LBL_WEB_TO_LEAD',
        'acl_action'=>'edit',
        'acl_module'=>$module_name,
        'icon' => 'icon-plus',
    ),
);
