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
{*
    check to see if 'date_formatted_value' has been added to the vardefs, and use it if it has, otherwise use the normal sugarvar function
*}
{{if !empty($vardef.date_formatted_value) }}
    {assign var="value" value={{$vardef.date_formatted_value}} }
{{else}}
    {if strlen({{sugarvar key='value' string=true}}) <= 0}
        {assign var="value" value={{sugarvar key='default_value' string=true}} }
    {else}
        {assign var="value" value={{sugarvar key='value' string=true}} }
    {/if}
{{/if}}



<span class="sugar_field" id="{{sugarvar key='name'}}">{$value}</span>
{{if !empty($displayParams.enableConnectors)}}
{if !empty($value)}
{{sugarvar_connector view='DetailView'}}
{/if}
{{/if}}