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
<script type="text/javascript" src="{sugar_getjspath file='modules/ModuleBuilder/javascript/JSTransaction.js'}" ></script>
<script>
	var jstransaction = new JSTransaction();
	{literal}
	if (SUGAR.themes.tempHideLeftCol){
    	SUGAR.themes.tempHideLeftCol();
    }
    {/literal}
</script>

<link rel="stylesheet" type="text/css" href="{sugar_getjspath file="modules/ModuleBuilder/tpls/LayoutEditor.css"}" />
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file="vendor/ytree/TreeView/css/folders/tree.css"}" />

<script type="text/javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/studio2.js'}' ></script>
<script type="text/javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/studio2PanelDD.js'}' ></script>
<script type="text/javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/studio2RowDD.js'}' ></script>
<script type="text/javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/studio2FieldDD.js'}' ></script>
<script type="text/javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/studiotabgroups.js'}'></script>
<script type="text/javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/studio2ListDD.js'}' ></script>

<!--end ModuleBuilder Assistant!-->
<script type="text/javascript" language="Javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/ModuleBuilder.js'}'></script>
<script type="text/javascript" language="Javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/SimpleList.js'}'></script>
<script type="text/javascript" src='{sugar_getjspath file ='modules/ModuleBuilder/javascript/JSTransaction.js'}' ></script>
<script type="text/javascript" src='{sugar_getjspath file ='include/javascript/tiny_mce/tiny_mce.js'}' ></script>

<!-- Formula builder and dependency manager -->
<script src="{sugar_getjspath file='include/javascript/jquery/markitup/jquery.markitup.js'}"></script>
<script src="{sugar_getjspath file='include/javascript/jquery/markitup/sets/default/set.js'}"></script>


<link rel="stylesheet" type="text/css" href="{sugar_getjspath file="modules/ModuleBuilder/tpls/MB.css"}" />
