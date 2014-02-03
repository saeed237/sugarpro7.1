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


define('MB_BASEMETADATALOCATION', 'base');
define('MB_CUSTOMMETADATALOCATION', 'custom');
define('MB_WORKINGMETADATALOCATION', 'working');
define('MB_HISTORYMETADATALOCATION', 'history');
define('MB_GRIDLAYOUTMETADATA', 'gridLayoutMetaData');
define('MB_LISTLAYOUTMETADATA', 'listLayoutMetaData');
define('MB_LISTVIEW', 'listview');
define('MB_SIDECARLISTVIEW', 'list');
define('MB_SEARCHVIEW', 'searchview');
define('MB_BASICSEARCH', 'basic_search' );
define('MB_ADVANCEDSEARCH', 'advanced_search' );
define('MB_DASHLET', 'dashlet');
define('MB_DASHLETSEARCH', 'dashletsearch');
define('MB_EDITVIEW', 'editview');
define('MB_DETAILVIEW', 'detailview');
define('MB_QUICKCREATE', 'quickcreate');
define('MB_POPUPLIST', 'popuplist');
define('MB_POPUPSEARCH', 'popupsearch');
define('MB_LABEL', 'label');
define('MB_ONETOONE', 'one-to-one');
define('MB_ONETOMANY', 'one-to-many');
define('MB_MANYTOONE', 'many-to-one');
define('MB_MANYTOMANY', 'many-to-many');
define('MB_MAXDBIDENTIFIERLENGTH', 30); // maximum length of any identifier in our supported databases
define('MB_EXPORTPREPEND', 'project_');
define('MB_VISIBILITY', 'visibility');
define('MB_WIRELESSEDITVIEW', 'wirelesseditview');
define('MB_WIRELESSDETAILVIEW', 'wirelessdetailview');
define('MB_WIRELESSLISTVIEW', 'wirelesslistview');
define('MB_WIRELESSBASICSEARCH', 'wireless_basic_search' );
define('MB_WIRELESSADVANCEDSEARCH', 'wireless_advanced_search' );
define('MB_WIRELESS', 'mobile');
define('MB_RECORDVIEW', 'recordview');

class MBConstants
{
    public static $EMPTY = array ( 'name' => '(empty)' , 'label' => '(empty)' ) ;
    public static $FILLER = array ( 'name' => '(filler)' , 'label' => 'LBL_FILLER' ) ; // would prefer to have label => translate('LBL_FILLER') but can't be done in a static, and don't want to require instantiating a new object to get these constants
}
