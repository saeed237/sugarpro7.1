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

/**
 * This defines a bunch of core classes and where they can be loaded from
 * Only non PSR-0 classes need to be named here, other classes will be found automatically
 */
$class_map = array(
    'XTemplate'=>'vendor/XTemplate/xtpl.php',
    'Javascript'=>'include/javascript/javascript.php',
    'ListView'=>'include/ListView/ListView.php',
    'CustomSugarView' => 'custom/include/MVC/View/SugarView.php',
    'Sugar_Smarty' => 'include/SugarSmarty/Sugar_Smarty.php',
    'HTMLPurifier_Bootstrap' => 'vendor/HTMLPurifier/HTMLPurifier.standalone.php',
    'SugarSearchEngineFullIndexer'=>'include/SugarSearchEngine/SugarSearchEngineFullIndexer.php',
    'SugarSearchEngineSyncIndexer'=>'include/SugarSearchEngine/SugarSearchEngineSyncIndexer.php',
    'SugarCurrency'=>'include/SugarCurrency/SugarCurrency.php',
    'SugarRelationshipFactory' => 'data/Relationships/RelationshipFactory.php',
    'DBManagerFactory' => 'include/database/DBManagerFactory.php',
    'Localization' => 'include/Localization/Localization.php',
    'TimeDate' => 'include/TimeDate.php',
    'SugarDateTime' => 'include/SugarDateTime.php',
    'SugarBean' => 'data/SugarBean.php',
    'LanguageManager' => 'include/SugarObjects/LanguageManager.php',
    'VardefManager' => 'include/SugarObjects/VardefManager.php',
    'MetaDataManager' => 'include/MetaDataManager/MetaDataManager.php',
    'TemplateText' => 'modules/DynamicFields/templates/Fields/TemplateText.php',
    'TemplateField' => 'modules/DynamicFields/templates/Fields/TemplateField.php',
    'SugarEmailAddress' => 'include/SugarEmailAddress/SugarEmailAddress.php',
    'JSON' => 'include/JSON.php',
    'LoggerManager' => 'include/SugarLogger/LoggerManager.php',
    'ACLController' => 'modules/ACL/ACLController.php',
    'ACLJSController' => 'modules/ACL/ACLJSController.php',
    'Administration' => 'modules/Administration/Administration.php',
    'OutboundEmail' => 'include/OutboundEmail/OutboundEmail.php',
    'MailerFactory' => 'modules/Mailer/MailerFactory.php',
    'LogicHook' => 'include/utils/LogicHook.php',
    'SugarTheme' => 'include/SugarTheme/SugarTheme.php',
    'SugarThemeRegistry' => 'include/SugarTheme/SugarTheme.php',
    'SugarModule' => 'include/MVC/SugarModule.php',
    'SugarApplication' => 'include/MVC/SugarApplication.php',
    'ControllerFactory' => 'include/MVC/Controller/ControllerFactory.php',
    'ViewFactory' => 'include/MVC/View/ViewFactory.php',
    'BeanFactory' => 'data/BeanFactory.php',
    'Audit' => 'modules/Audit/Audit.php',
    'Link2' => 'data/Link2.php',
    'SugarJobQueue' => 'include/SugarQueue/SugarJobQueue.php',
    'EmbedLinkService' => 'include/EmbedLinkService.php',
);

