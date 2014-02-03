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


$lotusLiveUrl = '';
$llNowButton = '';

if ( !isset($dynamicDCActions) || !is_array($dynamicDCActions) ) {
    $dynamicDCActions = array();
}

if (isset($_SESSION['current_db_version']) && isset($_SESSION['target_db_version']) && version_compare($_SESSION['current_db_version'], $_SESSION['target_db_version'], '!='))
{
    // check if we are in upgrade. If yes, skip EAPM for now, until the DB is upgraded
    return;
}


require_once('include/connectors/utils/ConnectorUtils.php');
require_once('include/connectors/sources/SourceFactory.php');
$connector = SourceFactory::getSource('ext_eapm_ibmsmartcloud', false);

// Check if IBM SmartCloud (was Lotus Live) is configured and enabled
if ( !empty($connector) && $connector->propertyExists('oauth_consumer_key') && $connector->propertyExists('oauth_consumer_secret') && ConnectorUtils::eapmEnabled('ext_eapm_ibmsmartcloud')) {
    // All we need is ibm smartcloud url
    require_once('modules/EAPM/EAPM.php'); 
    $eapmBean = EAPM::getLoginInfo('IBMSmartCloud');
    
    if ( !empty($eapmBean->api_data) ) {
        $api_data = json_decode(base64_decode($eapmBean->api_data), true);
    
        if ( isset($api_data['hostURL']) ) {
            $lotusLiveUrl = $api_data['hostURL'];
            $lotusLiveMeetNowLabel = translate('LBL_MEET_NOW_BUTTON','EAPM');
            $llNowButton = '<button onclick=\\\'DCMenu.hostMeeting();\\\'>'.$lotusLiveMeetNowLabel.'</button>';
            $dynamicDCActions['LotusLiveMeetings'] = array(
                    'module' => 'Meetings',
                    'label' => translate('LBL_VIEW_LOTUS_LIVE_MEETINGS','EAPM'),
                    'action'=> "DCMenu.hostMeetingUrl='".$lotusLiveUrl."'; DCMenu.loadView('".translate('LBL_TITLE_LOTUS_LIVE_MEETINGS','EAPM')."','index.php?module=Meetings&action=listbytype&type=IBMSmartCloud',undefined,undefined,undefined,'".$llNowButton."');",
                    'icon'=> 'icon_LotusMeetings_footer_bar.png',
            );
            $dynamicDCActions['LotusLiveDocuments'] = array(
                    'module' => 'Documents',
                    'label' => translate('LBL_VIEW_LOTUS_LIVE_DOCUMENTS','EAPM'),
                    'action' => 'DCMenu.loadView(\''.translate('LBL_TITLE_LOTUS_LIVE_DOCUMENTS','EAPM').'\',\'index.php?module=Documents&action=extdoc&type=IBMSmartCloud\');',
                    'icon' => 'icon_LotusDocuments_footer_bar.png',
            );
        }
    }
    
    // Display alert if not connected
    $_SESSION['display_lotuslive_alert'] = empty($eapmBean);
}
