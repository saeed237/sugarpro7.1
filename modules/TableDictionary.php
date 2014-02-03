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



include("metadata/accounts_bugsMetaData.php");
include("metadata/accounts_casesMetaData.php");
include("metadata/accounts_contactsMetaData.php");
include("metadata/accounts_opportunitiesMetaData.php");
include("metadata/calls_contactsMetaData.php");
include("metadata/calls_usersMetaData.php");
include("metadata/calls_leadsMetaData.php");
include("metadata/cases_bugsMetaData.php");
include("metadata/contacts_bugsMetaData.php");
include("metadata/contacts_casesMetaData.php");
include("metadata/configMetaData.php");
include("metadata/contacts_usersMetaData.php");
include("metadata/custom_fieldsMetaData.php");
include("metadata/email_addressesMetaData.php");
include("metadata/emails_beansMetaData.php");
include("metadata/foldersMetaData.php");
include("metadata/import_mapsMetaData.php");
include("metadata/meetings_contactsMetaData.php");
include("metadata/meetings_usersMetaData.php");
include("metadata/meetings_leadsMetaData.php");
include("metadata/opportunities_contactsMetaData.php");
include("metadata/user_feedsMetaData.php");
include("metadata/users_passwordLinkMetaData.php");
include("metadata/team_sets_teamsMetaData.php");
include("metadata/tracker_perfMetaData.php");
include("metadata/tracker_queriesMetaData.php");
include("metadata/tracker_sessionsMetaData.php");
include("metadata/tracker_tracker_queriesMetaData.php");
include("metadata/prospect_list_campaignsMetaData.php");
include("metadata/prospect_lists_prospectsMetaData.php");
include("metadata/roles_modulesMetaData.php");
include("metadata/roles_usersMetaData.php");
include("metadata/outboundEmailMetaData.php");
include("metadata/addressBookMetaData.php");
include("metadata/recordListMetaData.php");


include("metadata/report_cache.php");
include("metadata/report_schedulesMetaData.php");
include("metadata/saved_reportsMetaData.php");

include("metadata/product_bundle_noteMetaData.php");
include("metadata/product_bundle_productMetaData.php");
include("metadata/product_bundle_quoteMetaData.php");
include("metadata/product_productMetaData.php");
include("metadata/quotes_accountsMetaData.php");
include("metadata/quotes_contactsMetaData.php");
include("metadata/quotes_opportunitiesMetaData.php");
include("metadata/products_categoryTreeMetaData.php");
include("metadata/fts_queueMetaData.php");
include("metadata/workflow_schedulesMetaData.php");
include("metadata/schedulers_timesMetaData.php");
include("metadata/contracts_opportunitiesMetaData.php");
include("metadata/contracts_contactsMetaData.php");
include("metadata/contracts_quotesMetaData.php");
include("metadata/contracts_productsMetaData.php");
include("metadata/kbdocuments_views_ratingsMetaData.php");
include("metadata/users_holidaysMetaData.php");

//ACL RELATIONSHIPS
include("metadata/acl_roles_actionsMetaData.php");
include("metadata/acl_roles_usersMetaData.php");
// INBOUND EMAIL
include("metadata/inboundEmail_autoreplyMetaData.php");
include("metadata/inboundEmail_cacheTimestampMetaData.php");
include("metadata/email_cacheMetaData.php");
include("metadata/email_marketing_prospect_listsMetaData.php");

//linked documents.
include("metadata/linked_documentsMetaData.php");
include("metadata/sessionHistoryMetaData.php");

// Documents, so we can start replacing Notes as the primary way to attach something to something else.
include("metadata/documents_accountsMetaData.php");
include("metadata/documents_contactsMetaData.php");
include("metadata/documents_opportunitiesMetaData.php");
include("metadata/documents_casesMetaData.php");
include("metadata/documents_bugsMetaData.php");
include("metadata/documents_productsMetaData.php");
include("metadata/documents_revenuelineitemsMetaData.php");
include("metadata/documents_quotesMetaData.php");
include("metadata/forecast_treeMetaData.php");
include("metadata/oauth_nonce.php");
include("metadata/activities_usersMetaData.php");

$defs = SugarAutoLoader::loadExtension('tabledictionary');
if($defs) {
    require $defs;
}
