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
<div style="padding:5px" height="100%">
	<div>
		<a class="listViewThLinkS1" href="javascript:SUGAR.routing.ui.addRule();">{$app_strings.LBL_ROUTING_ADD_RULE}</a> <a class="listViewThLinkS1" href="javascript:SUGAR.routing.ui.addRule();">{sugar_getimage alt=$app_strings.LBL_ADD name="plus" ext=".gif" other_attributes='align="absmiddle" border="0" '}</a>
	</div>
	<br />
	<div id="rulesList" style="background:#fff; overflow:auto; margin:5px; padding:2px; border:1px solid #ccc;">{$savedRules}</div>
	<div>
		<i>{$app_strings.LBL_ROUTING_SUB_DESC}</i>
	</div>
</div>