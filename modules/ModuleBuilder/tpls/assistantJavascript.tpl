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
<script>
{literal}
if(typeof(Assistant)!="undefined" && Assistant.mbAssistant){
	//Assistant.mbAssistant.render(document.body);
{/literal}
{if $userPref }
	Assistant.processUserPref("{$userPref}");
{/if}
{if $assistant.key && $assistant.group}
	Assistant.mbAssistant.setBody(SUGAR.language.get('ModuleBuilder','assistantHelp').{$assistant.group}.{$assistant.key});
{/if}
{literal}
	if(Assistant.mbAssistant.visible){
		Assistant.mbAssistant.show();
		}
}
{/literal}
</script>