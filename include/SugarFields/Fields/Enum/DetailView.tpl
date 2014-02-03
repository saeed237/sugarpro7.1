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
{* This is here so currency fields, who don't really have dropdown
lists can work. *}
{if is_string({{sugarvar key='options' string=true}})}
<input type="hidden" class="sugar_field" id="{{sugarvar key='name'}}" value="{ {{sugarvar key='options' string=true}} }">
{ {{sugarvar key='options' string=true}} }
{else}
<input type="hidden" class="sugar_field" id="{{sugarvar key='name'}}" value="{ {{sugarvar key='value' string=true}} }">
{ {{sugarvar key='options' string=true}}[{{sugarvar key='value' string=true}}]}
{/if}
{{if !empty($displayParams.enableConnectors)}}
{{sugarvar_connector view='DetailView'}}
{{/if}}