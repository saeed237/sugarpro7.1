{*
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

*}

<script type="text/javascript" language="Javascript">
var req;
var target;
var flexContentOld = "";
var forcePreview = false;
var inCompose = false;

/* globals for Callback functions */
var email; // AjaxObject.showEmailPreview
var ieId;
var ieName;
var focusFolder;
var meta; // AjaxObject.showEmailPreview
var sendType;
var targetDiv;
var urlBase = 'index.php';
var urlStandard = 'sugar_body_only=true&to_pdf=true&module=Emails&action=EmailUIAjax';

var lazyLoadFolder = null;
</script>
