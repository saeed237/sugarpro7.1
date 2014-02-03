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




error_reporting(1);
//destroying global variables
$GLOBALS['studioConfig'] = array();
$GLOBALS['studioConfig']['parsers']['ListViewParser'] = 'modules/Studio/parsers/ListViewParser.php';
$GLOBALS['studioConfig']['parsers']['SlotParser'] = 'modules/Studio/parsers/SlotParser.php';
$GLOBALS['studioConfig']['parsers']['StudioParser'] = 'modules/Studio/parsers/StudioParser.php';
$GLOBALS['studioConfig']['parsers']['StudioRowParser'] = 'modules/Studio/parsers/StudioRowParser.php';
$GLOBALS['studioConfig']['parsers']['StudioUpgradeParser'] = 'modules/Studio/parsers/StudioUpgradeParser.php';
$GLOBALS['studioConfig']['parsers']['SubpanelColParser'] = 'modules/Studio/parsers/SubpanelColParser.php';
$GLOBALS['studioConfig']['parsers']['SubpanelParser'] = 'modules/Studio/parsers/SubpanelParser.php';
$GLOBALS['studioConfig']['parsers']['TabIndexParser'] = 'modules/Studio/parsers/TabIndexParser.php';
$GLOBALS['studioConfig']['parsers']['XTPLListViewParser'] = 'modules/Studio/parsers/XTPLListViewParser.php';
$GLOBALS['studioConfig']['ajax']['customfieldview'] = 'modules/Studio/ajax/customfieldview.php';
$GLOBALS['studioConfig']['ajax']['editcustomfield'] = 'modules/Studio/ajax/editcustomfield.php';
$GLOBALS['studioConfig']['ajax']['relatedfiles'] = 'modules/Studio/ajax/relatedfiles.php';
$GLOBALS['studioConfig']['dynamicFields']['bool'] = 'modules/DynamicFields/templates/Fields/Forms/bool.php';
$GLOBALS['studioConfig']['dynamicFields']['date'] = 'modules/DynamicFields/templates/Fields/Forms/date.php';
$GLOBALS['studioConfig']['dynamicFields']['email'] = 'modules/DynamicFields/templates/Fields/Forms/email.php';
$GLOBALS['studioConfig']['dynamicFields']['enum'] = 'modules/DynamicFields/templates/Fields/Forms/enum.php';
$GLOBALS['studioConfig']['dynamicFields']['float'] = 'modules/DynamicFields/templates/Fields/Forms/float.php';
$GLOBALS['studioConfig']['dynamicFields']['html'] = 'modules/DynamicFields/templates/Fields/Forms/html.php';
$GLOBALS['studioConfig']['dynamicFields']['int'] = 'modules/DynamicFields/templates/Fields/Forms/int.php';
$GLOBALS['studioConfig']['dynamicFields']['multienum'] = 'modules/DynamicFields/templates/Fields/Forms/multienum.php';
$GLOBALS['studioConfig']['dynamicFields']['radioenum'] = 'modules/DynamicFields/templates/Fields/Forms/radioenum.php';
$GLOBALS['studioConfig']['dynamicFields']['text'] = 'modules/DynamicFields/templates/Fields/Forms/text.php';
$GLOBALS['studioConfig']['dynamicFields']['url'] = 'modules/DynamicFields/templates/Fields/Forms/url.php';
$GLOBALS['studioConfig']['dynamicFields']['varchar'] = 'modules/DynamicFields/templates/Fields/Forms/varchar.php';

?>
