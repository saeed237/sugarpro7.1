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


$moduleList = array();
// this list defines the modules shown in the top tab list of the app
//the order of this list is the default order displayed - do not change the order unless it is on purpose
$moduleList[] = 'Home';
$moduleList[] = 'Calendar';
$moduleList[] = 'Calls';
$moduleList[] = 'Meetings';
$moduleList[] = 'Tasks';
$moduleList[] = 'Notes';
$moduleList[] = 'Reports';
$moduleList[] = 'Leads';
$moduleList[] = 'Contacts';
$moduleList[] = 'Accounts';
$moduleList[] = 'Opportunities';

$moduleList[] = 'Emails';
$moduleList[] = 'Campaigns';
$moduleList[] = 'Prospects';
$moduleList[] = 'ProspectLists';

$moduleList[] = 'Quotes';
$moduleList[] = 'Products';
$moduleList[] = 'Forecasts';
$moduleList[] = 'Contracts';
$moduleList[] = 'KBDocuments';

$moduleList[] = 'Documents';
$moduleList[] = 'Cases';
$moduleList[] = 'Bugs';

// this list defines all of the module names and bean names in the app
// to create a new module's bean class, add the bean definition here
$beanList = array();
//ACL Objects
$beanList['ACLRoles']       = 'ACLRole';
$beanList['ACLActions']     = 'ACLAction';
$beanList['ACLFields']       = 'ACLField';
//END ACL OBJECTS
$beanList['Leads']          = 'Lead';
$beanList['Cases']          = 'aCase';
$beanList['Bugs']           = 'Bug';
$beanList['ProspectLists']      = 'ProspectList';
$beanList['Prospects']  = 'Prospect';
$beanList['Campaigns']          = 'Campaign';
$beanList['EmailMarketing']  = 'EmailMarketing';
$beanList['CampaignLog']        = 'CampaignLog';
$beanList['CampaignTrackers']   = 'CampaignTracker';
$beanList['Releases']       = 'Release';
$beanList['Groups'] = 'Group';
$beanList['EmailMan'] = 'EmailMan';
$beanList['Schedulers']  = 'Scheduler';
$beanList['SchedulersJobs']  = 'SchedulersJob';
$beanList['Contacts']       = 'Contact';
$beanList['Accounts']       = 'Account';
$beanList['DynamicFields']  = 'DynamicField';
$beanList['EditCustomFields']   = 'FieldsMetaData';
$beanList['Opportunities']  = 'Opportunity';

$beanList['EmailTemplates']     = 'EmailTemplate';
$beanList['UserSignatures'] = 'UserSignature';
$beanList['Notes']          = 'Note';
$beanList['Calls']          = 'Call';
$beanList['Emails']         = 'Email';
$beanList['Meetings']       = 'Meeting';
$beanList['Tasks']          = 'Task';
$beanList['Users']          = 'User';
$beanList['Currencies']     = 'Currency';
$beanList['Trackers']       = 'Tracker';
$beanList['Connectors']     = 'Connectors';
$beanList['TrackerSessions']= 'TrackerSession';
$beanList['TrackerPerfs']   = 'TrackerPerf';
$beanList['TrackerQueries'] = 'TrackerQuery';
$beanList['Import_1']         = 'ImportMap';
$beanList['Import_2']       = 'UsersLastImport';
$beanList['Versions']       = 'Version';
$beanList['Administration'] = 'Administration';
$beanList['vCals']          = 'vCal';
$beanList['CustomFields']       = 'CustomFields';


$beanList['Documents']  = 'Document';
$beanList['DocumentRevisions']  = 'DocumentRevision';
$beanList['Roles']  = 'Role';

$beanList['Audit']  = 'Audit';

$beanList['Styleguide'] = 'Styleguide';
// deferred
//$beanList['Queues'] = 'Queue';

$beanList['InboundEmail'] = 'InboundEmail';


$beanList['SavedSearch']            = 'SavedSearch';
$beanList['UserPreferences']        = 'UserPreference';
$beanList['MergeRecords'] = 'MergeRecord';
$beanList['EmailAddresses'] = 'EmailAddress';
$beanList['EmailText'] = 'EmailText';
$beanList['Relationships'] = 'Relationship';
$beanList['Employees']      = 'Employee';
$beanList['Reports']        = 'SavedReport';
$beanList['Reports_1']      = 'SavedReport';
$beanList['Teams']          = 'Team';
$beanList['TeamMemberships']            = 'TeamMembership';
$beanList['TeamSets']            = 'TeamSet';
$beanList['TeamSetModules']            = 'TeamSetModule';
$beanList['Quotes']         = 'Quote';
$beanList['RevenueLineItems'] = 'RevenueLineItem';
$beanList['Products']       = 'Product';
$beanList['ProductBundles']     = 'ProductBundle';
$beanList['ProductBundleNotes'] = 'ProductBundleNote';
$beanList['ProductTemplates']= 'ProductTemplate';
$beanList['ProductTypes']   = 'ProductType';
$beanList['ProductCategories']= 'ProductCategory';
$beanList['Manufacturers']  = 'Manufacturer';
$beanList['Shippers']       = 'Shipper';
$beanList['TaxRates']       = 'TaxRate';
$beanList['TeamNotices']        = 'TeamNotice';
$beanList['TimePeriods']    = 'TimePeriod';
$beanList['AnnualTimePeriods'] = 'AnnualTimePeriod';
$beanList['QuarterTimePeriods']    = 'QuarterTimePeriod';
$beanList['Quarter544TimePeriods']    = 'Quarter544TimePeriod';
$beanList['Quarter445TimePeriods']    = 'Quarter445TimePeriod';
$beanList['Quarter454TimePeriods']    = 'Quarter454TimePeriod';
$beanList['MonthTimePeriods']    = 'MonthTimePeriod';
$beanList['Forecasts']  = 'Forecast';
$beanList['ForecastWorksheets']  = 'ForecastWorksheet';
$beanList['ForecastManagerWorksheets']  = 'ForecastManagerWorksheet';
$beanList['ForecastSchedule']  = 'ForecastSchedule';
$beanList['Worksheet']  = 'Worksheet';
$beanList['ForecastOpportunities']  = 'ForecastOpportunities';
$beanList['ForecastDirectReports'] = 'ForecastDirectReports';
$beanList['Quotas']     = 'Quota';
$beanList['WorkFlow']  = 'WorkFlow';
$beanList['WorkFlowTriggerShells']  = 'WorkFlowTriggerShell';
$beanList['WorkFlowAlertShells']  = 'WorkFlowAlertShell';
$beanList['WorkFlowAlerts']  = 'WorkFlowAlert';
$beanList['WorkFlowActionShells']  = 'WorkFlowActionShell';
$beanList['WorkFlowActions']  = 'WorkFlowAction';
$beanList['Expressions']  = 'Expression';
$beanList['Contracts']  = 'Contract';
$beanList['KBDocuments'] = 'KBDocument';
$beanList['KBDocumentRevisions'] = 'KBDocumentRevision';
$beanList['KBTags'] = 'KBTag';
$beanList['KBDocumentKBTags'] = 'KBDocumentKBTag';
$beanList['KBContents'] = 'KBContent';
$beanList['ContractTypes']  = 'ContractType';
$beanList['Holidays'] = 'Holiday';
$beanList['Empty'] = 'EmptyBean';
$beanList['TeamHierarchy'] = 'TeamHierarchy';
$beanList['UpgradeHistory'] = 'UpgradeHistory';

// this list defines all of the files that contain the SugarBean class definitions from $beanList
// to create a new module's bean class, add the file definition here
$beanFiles = array();

$beanFiles['ACLAction'] = 'modules/ACLActions/ACLAction.php';
$beanFiles['ACLRole'] = 'modules/ACLRoles/ACLRole.php';
$beanFiles['Relationship']  = 'modules/Relationships/Relationship.php';

$beanFiles['Lead']          = 'modules/Leads/Lead.php';
$beanFiles['aCase']         = 'modules/Cases/Case.php';
$beanFiles['Bug']           = 'modules/Bugs/Bug.php';
$beanFiles['Group'] = 'modules/Groups/Group.php';
$beanFiles['CampaignLog']  = 'modules/CampaignLog/CampaignLog.php';
$beanFiles['Campaign']          = 'modules/Campaigns/Campaign.php';
$beanFiles['ProspectList']      = 'modules/ProspectLists/ProspectList.php';
$beanFiles['Prospect']  = 'modules/Prospects/Prospect.php';

$beanFiles['EmailMarketing']          = 'modules/EmailMarketing/EmailMarketing.php';
$beanFiles['CampaignTracker']  = 'modules/CampaignTrackers/CampaignTracker.php';
$beanFiles['Release']           = 'modules/Releases/Release.php';
$beanFiles['EmailMan']          = 'modules/EmailMan/EmailMan.php';

$beanFiles['Scheduler']  = 'modules/Schedulers/Scheduler.php';
$beanFiles['SchedulersJob']  = 'modules/SchedulersJobs/SchedulersJob.php';
$beanFiles['Contact']       = 'modules/Contacts/Contact.php';
$beanFiles['Account']       = 'modules/Accounts/Account.php';
$beanFiles['Opportunity']   = 'modules/Opportunities/Opportunity.php';
$beanFiles['EmailTemplate']         = 'modules/EmailTemplates/EmailTemplate.php';
$beanFiles['UserSignature'] = 'modules/UserSignatures/UserSignature.php';
$beanFiles['Note']          = 'modules/Notes/Note.php';
$beanFiles['Call']          = 'modules/Calls/Call.php';
$beanFiles['Email']         = 'modules/Emails/Email.php';
$beanFiles['Meeting']       = 'modules/Meetings/Meeting.php';
$beanFiles['Task']          = 'modules/Tasks/Task.php';
$beanFiles['User']          = 'modules/Users/User.php';
$beanFiles['Employee']      = 'modules/Employees/Employee.php';
$beanFiles['Currency']          = 'modules/Currencies/Currency.php';
$beanFiles['Tracker']          = 'modules/Trackers/Tracker.php';
$beanFiles['TrackerPerf']      = 'modules/Trackers/TrackerPerf.php';
$beanFiles['TrackerSession']   = 'modules/Trackers/TrackerSession.php';
$beanFiles['TrackerQuery']     = 'modules/Trackers/TrackerQuery.php';
$beanFiles['ImportMap']     = 'modules/Import/maps/ImportMap.php';
$beanFiles['UsersLastImport']= 'modules/Import/UsersLastImport.php';
$beanFiles['Administration']= 'modules/Administration/Administration.php';
$beanFiles['UpgradeHistory']= 'modules/Administration/UpgradeHistory.php';
$beanFiles['vCal']          = 'modules/vCals/vCal.php';

$beanFiles['Version']           = 'modules/Versions/Version.php';

$beanFiles['Role']          = 'modules/Roles/Role.php';

$beanFiles['Document']  = 'modules/Documents/Document.php';
$beanFiles['DocumentRevision']  = 'modules/DocumentRevisions/DocumentRevision.php';
$beanFiles['FieldsMetaData']    = 'modules/DynamicFields/FieldsMetaData.php';
//$beanFiles['Audit']           = 'modules/Audit/Audit.php';

// deferred
//$beanFiles['Queue'] = 'modules/Queues/Queue.php';

$beanFiles['InboundEmail'] = 'modules/InboundEmail/InboundEmail.php';



$beanFiles['SavedSearch']  = 'modules/SavedSearch/SavedSearch.php';
$beanFiles['UserPreference']  = 'modules/UserPreferences/UserPreference.php';
$beanFiles['MergeRecord']  = 'modules/MergeRecords/MergeRecord.php';
$beanFiles['EmailAddress'] = 'modules/EmailAddresses/EmailAddress.php';
$beanFiles['EmailText'] = 'modules/EmailText/EmailText.php';
$beanFiles['SavedReport']   = 'modules/Reports/SavedReport.php';
$beanFiles['ACLField'] = 'modules/ACLFields/ACLField.php';
$beanFiles['Contract']  = 'modules/Contracts/Contract.php';
$beanFiles['Team']          = 'modules/Teams/Team.php';
$beanFiles['TeamMembership']            = 'modules/Teams/TeamMembership.php';
$beanFiles['TeamSet']            = 'modules/Teams/TeamSet.php';
$beanFiles['TeamSetModule']            = 'modules/Teams/TeamSetModule.php';
$beanFiles['TeamNotice']            = 'modules/TeamNotices/TeamNotice.php';
$beanFiles['ProductTemplate']= 'modules/ProductTemplates/ProductTemplate.php';
$beanFiles['ProductType']   = 'modules/ProductTypes/ProductType.php';
$beanFiles['ProductCategory']= 'modules/ProductCategories/ProductCategory.php';
$beanFiles['Manufacturer']  = 'modules/Manufacturers/Manufacturer.php';
$beanFiles['Quote']         = 'modules/Quotes/Quote.php';
$beanFiles['ProductBundleNote'] = 'modules/ProductBundleNotes/ProductBundleNote.php';
$beanFiles['Product']       = 'modules/Products/Product.php';
$beanFiles['ProductBundle']     = 'modules/ProductBundles/ProductBundle.php';
$beanFiles['RevenueLineItem'] = 'modules/RevenueLineItems/RevenueLineItem.php';
$beanFiles['Shipper']       = 'modules/Shippers/Shipper.php';
$beanFiles['TaxRate']       = 'modules/TaxRates/TaxRate.php';
$beanFiles['TimePeriod']        = 'modules/TimePeriods/TimePeriod.php';
$beanFiles['AnnualTimePeriod']        = 'modules/TimePeriods/AnnualTimePeriod.php';
$beanFiles['QuarterTimePeriod']    = 'modules/TimePeriods/QuarterTimePeriod.php';
$beanFiles['Quarter544TimePeriod']    = 'modules/TimePeriods/Quarter544TimePeriod.php';
$beanFiles['Quarter454TimePeriod']    = 'modules/TimePeriods/Quarter454TimePeriod.php';
$beanFiles['Quarter445TimePeriod']    = 'modules/TimePeriods/Quarter445TimePeriod.php';
$beanFiles['MonthTimePeriod']    = 'modules/TimePeriods/MonthTimePeriod.php';
$beanFiles['Forecast']      = 'modules/Forecasts/Forecast.php';
$beanFiles['ForecastWorksheet'] = 'modules/ForecastWorksheets/ForecastWorksheet.php';
$beanFiles['ForecastManagerWorksheet'] = 'modules/ForecastManagerWorksheets/ForecastManagerWorksheet.php';
$beanFiles['ForecastSchedule']  = 'modules/ForecastSchedule/ForecastSchedule.php';
$beanFiles['ForecastOpportunities']  = 'modules/Forecasts/ForecastOpportunities.php';
$beanFiles['ForecastDirectReports'] = 'modules/Forecasts/ForecastDirectReports.php';
$beanFiles['Quota']  = 'modules/Quotas/Quota.php';
$beanFiles['Worksheet']  = 'modules/Forecasts/Worksheet.php';
$beanFiles['WorkFlow']  = 'modules/WorkFlow/WorkFlow.php';
$beanFiles['WorkFlowTriggerShell']  = 'modules/WorkFlowTriggerShells/WorkFlowTriggerShell.php';
$beanFiles['WorkFlowAlertShell']  = 'modules/WorkFlowAlertShells/WorkFlowAlertShell.php';
$beanFiles['WorkFlowAlert']  = 'modules/WorkFlowAlerts/WorkFlowAlert.php';
$beanFiles['WorkFlowActionShell']  = 'modules/WorkFlowActionShells/WorkFlowActionShell.php';
$beanFiles['WorkFlowAction']  = 'modules/WorkFlowActions/WorkFlowAction.php';
$beanFiles['Expression']  = 'modules/Expressions/Expression.php';
$beanFiles['System']      = 'modules/Administration/System.php';
$beanFiles['SessionManager']      = 'modules/Administration/SessionManager.php';
$beanFiles['KBDocument'] = 'modules/KBDocuments/KBDocument.php';
$beanFiles['KBDocumentRevision'] = 'modules/KBDocumentRevisions/KBDocumentRevision.php';
$beanFiles['KBTag'] = 'modules/KBTags/KBTag.php';
$beanFiles['KBDocumentKBTag'] = 'modules/KBDocumentKBTags/KBDocumentKBTag.php';
$beanFiles['KBContent'] = 'modules/KBContents/KBContent.php';
$beanFiles['ContractType']  = 'modules/ContractTypes/ContractType.php';
$beanFiles['Holiday'] = 'modules/Holidays/Holiday.php';

$beanFiles['Configurator']          = 'modules/Configurator/Configurator.php';
$beanFiles['EmptyBean'] = 'data/EmptyBean.php';
$beanFiles['Styleguide'] = 'modules/Styleguide/Styleguide.php';

// added these lists for security settings for tabs
$modInvisList = array('Administration', 'Currencies', 'CustomFields', 'Connectors',
    'Dropdown', 'Dynamic', 'DynamicFields', 'DynamicLayout', 'EditCustomFields',
    'Help', 'Import',  'MySettings', 'EditCustomFields','FieldsMetaData',
    'UpgradeWizard', 'Trackers', 'Connectors', 'Employees', 'Calendar',
    'Manufacturers', 'ProductBundles', 'ProductBundleNotes', 'ProductCategories', 'ProductTemplates', 'ProductTypes',
    'Shippers', 'TaxRates', 'TeamNotices', 'Teams', 'TimePeriods', 'ForecastOpportunities', 'Quotas',
    'KBDocumentRevisions', 'KBDocumentKBTags', 'KBTags', 'KBContents', 'ContractTypes', 'ForecastSchedule',
    'Worksheet', 'ACLFields', 'Holidays', 'SNIP', 'ForecastDirectReports',
    'Releases','Sync', 'Users',  'Versions', 'LabelEditor','Roles','EmailMarketing', 'OptimisticLock',
    'TeamMemberships', 'TeamSets', 'TeamSetModule', 'Audit', 'MailMerge', 'MergeRecords', 'EmailAddresses', 'EmailText',
    'Schedulers','Schedulers_jobs', /*'Queues',*/ 'EmailTemplates','UserSignature',
    'CampaignTrackers', 'CampaignLog', 'EmailMan', 'Prospects', 'ProspectLists',
    'Groups','InboundEmail',
    'ACLActions', 'ACLRoles',
    'DocumentRevisions',
    'Empty',
    'RevenueLineItems'
    );
$adminOnlyList = array(
                    //module => list of actions  (all says all actions are admin only)
                   //'Administration'=>array('all'=>1, 'SupportPortal'=>'allow'),
                    'Dropdown'=>array('all'=>1),
                    'Dynamic'=>array('all'=>1),
                    'DynamicFields'=>array('all'=>1),
                    'Currencies'=>array('all'=>1),
                    'EditCustomFields'=>array('all'=>1),
                    'FieldsMetaData'=>array('all'=>1),
                    'LabelEditor'=>array('all'=>1),
                    'ACL'=>array('all'=>1),
                    'ACLActions'=>array('all'=>1),
                    'ACLRoles'=>array('all'=>1),
                    'ACLFields'=>array('all'=>1),
                    'UpgradeWizard' => array('all' => 1),
                    'Studio' => array('all' => 1),
                    'Schedulers' => array('all' => 1),
                    'WebLogicHooks' => array('all' => 1),
                    );

$apiModuleList = array('Users', 'ActivityStream');


//$modInvisList[] = 'QueryBuilder';
$modInvisList[] = 'WorkFlow';
$modInvisList[] = 'WorkFlowTriggerShells';
$modInvisList[] = 'WorkFlowAlertShells';
$modInvisList[] = 'WorkFlowAlerts';
$modInvisList[] = 'WorkFlowActionShells';
$modInvisList[] = 'WorkFlowActions';
$modInvisList[] = 'Expressions';
$modInvisList[] = 'ACLFields';
$modInvisList[] = 'ForecastManagerWorksheet';
$modInvisList[] = 'ForecastWorksheet';
$modInvisList[] = 'ACL';
$modInvisList[] = 'ACLRoles';
$modInvisList[] = 'Configurator';
$modInvisList[] = 'UserPreferences';
$modInvisList[] = 'SavedSearch';
// deferred
//$modInvisList[] = 'Queues';
$modInvisList[] = 'Studio';
$modInvisList[] = 'Connectors';
$modInvisList[] = 'Styleguide';

$report_include_modules = array();
$report_include_modules['Currencies']='Currency';
//add prospects
$report_include_modules['Prospects']='Prospect';
$report_include_modules['DocumentRevisions'] = 'DocumentRevision';
$report_include_modules['ProductCategories'] = 'ProductCategory';
$report_include_modules['ProductTypes'] = 'ProductType';
$report_include_modules['Contracts']='Contract';
//add Tracker modules

$report_include_modules['Trackers']         = 'Tracker';


$report_include_modules['TimePeriods'] = 'TimePeriod';
$report_include_modules['TrackerPerfs']     = 'TrackerPerf';
$report_include_modules['TrackerSessions']  = 'TrackerSession';
$report_include_modules['TrackerQueries']   = 'TrackerQuery';
$report_include_modules['Worksheet']    = 'Worksheet';
$report_include_modules['Quotas']    = 'Quota';


$beanList['Notifications'] = 'Notifications';
$beanFiles['Notifications'] = 'modules/Notifications/Notifications.php';
$modInvisList[] = 'Notifications';
// This is the mapping for modules that appear under a different module's tab
// Be sure to also add the modules to $modInvisList, otherwise their tab will still appear
$GLOBALS['moduleTabMap'] = array(
    'UpgradeWizard' => 'Administration',
    'EmailMan' => 'Administration',
    'ModuleBuilder' => 'Administration',
    'Configurator' => 'Administration',
    'Studio' => 'Administration',
    'Currencies' => 'Administration',
    'DocumentRevisions' => 'Documents',
    'EmailTemplates' => 'Emails',
    'EmailMarketing' => 'Campaigns',
    'Quotas' => 'Forecasts',
    'TeamNotices' => 'Teams',
    'Activities' => 'Home',
    'WorkFlowAlertShells' => 'WorkFlow',
 );
$beanList['EAPM'] = 'EAPM';
$beanFiles['EAPM'] = 'modules/EAPM/EAPM.php';
$modules_exempt_from_availability_check['EAPM'] = 'EAPM';
$modInvisList[] = 'EAPM';
$beanList['OAuthKeys'] = 'OAuthKey';
$beanFiles['OAuthKey'] = 'modules/OAuthKeys/OAuthKey.php';
$modules_exempt_from_availability_check['OAuthKeys'] = 'OAuthKeys';
$modInvisList[] = 'OAuthKeys';
$beanList['OAuthTokens'] = 'OAuthToken';
$beanFiles['OAuthToken'] = 'modules/OAuthTokens/OAuthToken.php';
$modules_exempt_from_availability_check['OAuthTokens'] = 'OAuthTokens';
$modInvisList[] = 'OAuthTokens';


$beanList['SugarFavorites'] = 'SugarFavorites';
$beanFiles['SugarFavorites'] = 'modules/SugarFavorites/SugarFavorites.php';
$modules_exempt_from_availability_check['SugarFavorites'] = 'SugarFavorites';
$modInvisList[] = 'SugarFavorites';


$beanList['WebLogicHooks'] = 'WebLogicHook';
$beanFiles['WebLogicHook'] = 'modules/WebLogicHooks/WebLogicHook.php';
$modInvisList[] = 'WebLogicHooks';

$beanList['Activities'] = 'Activity';
$beanFiles['Activity'] = 'modules/ActivityStream/Activities/Activity.php';
$modInvisList[] = 'Activities';

$beanList['Comments'] = 'Comment';
$beanFiles['Comment'] = 'modules/ActivityStream/Comments/Comment.php';
$modInvisList[] = 'Comments';

$beanList['Subscriptions'] = 'Subscription';
$beanFiles['Subscription'] = 'modules/ActivityStream/Subscriptions/Subscription.php';
$modInvisList[] = 'Subscriptions';

$beanList['Filters'] = 'Filters';
$beanFiles['Filters'] = 'modules/Filters/Filters.php';
$modInvisList[] = 'Filters';

$beanList['Dashboards'] = 'Dashboard';
$beanFiles['Dashboard'] = 'modules/Dashboards/Dashboard.php';
$modInvisList[] = 'Dashboards';

//Object list is only here to correct for modules that break
//the bean class name == dictionary entry/object name convention
//No future module should need an entry here.
$objectList = array();
$objectList['Cases'] =  'Case';
$objectList['Groups'] =  'User';
$objectList['Users'] =  'User';
$objectList['TrackerSessions'] =  'tracker_sessions';
$objectList['TrackerPerfs'] =  'tracker_perf';
$objectList['TrackerQueries'] =  'tracker_queries';
$objectList['TeamNotices'] =  'TeamNotices';

$beanList['PdfManager']     = 'PdfManager';
$beanFiles['PdfManager']     = 'modules/PdfManager/PdfManager.php';
$modInvisList[] = 'PdfManager';
$adminOnlyList['PdfManager'] = array('all' => 1);


// TODO: this definition should be grouped with all the others definitions like $beanList, $beanFiles and so on
$bwcModules = array(
    'ACLFields',
    'ACLRoles',
    'ACLActions',
    'Administration',
    'Audit',
    'Calendar',
    'Calls',
    'CampaignLog',
    'Campaigns',
    'CampaignTrackers',
    'Charts',
    'Configurator',
    'Contracts',
    'ContractTypes',
    'Connectors',
    'Currencies',
    'DocumentRevisions',
    'Documents',
    'EAPM',
    'EmailAddresses',
    'EmailMarketing',
    'EmailMan',
    'Emails',
    'EmailTemplates',
    'Employees',
    'Exports',
    'Expressions',
    'Groups',
    'History',
    'Holidays',
    'iCals',
    'Import',
    'InboundEmail',
    'KBContents',
    'KBDocuments',
    'KBDocumentRevisions',
    'KBTags',
    'KBDocumentKBTags',
    'KBContents',
    'Manufacturers',
    'Meetings',
    'MergeRecords',
    'ModuleBuilder',
    'MySettings',
    'OAuthKeys',
    'OptimisticLock',
    'OutboundEmailConfiguration',
    'PdfManager',
    'ProductBundleNotes',
    'ProductBundles',
    'ProductTypes',
    'Quotes',
    'QueryBuilder',
    'Relationships',
    'Releases',
    'Reports',
    'Roles',
    'SavedSearch',
    'Schedulers',
    'SchedulersJobs',
    'Shippers',
    'SNIP',
    'Studio',
    'SugarFavorites',
    'TaxRates',
    'Teams',
    'TeamMemberships',
    'TeamSets',
    'TeamSetModules',
    'TeamNotices',
    'TimePeriods',
    'Trackers',
    'TrackerSessions',
    'TrackerPerfs',
    'TrackerQueries',
    'UserPreferences',
    'UserSignatures',
    'Users',
    'vCals',
    'vCards',
    'Versions',
    'WorkFlow',
    'WorkFlowActions',
    'WorkFlowActionShells',
    'WorkFlowAlerts',
    'WorkFlowAlertShells',
    'WorkFlowTriggerShells'
);

foreach(SugarAutoLoader::existing('include/modules_override.php', SugarAutoLoader::loadExtension("modules")) as $file) {
    include $file;
}
