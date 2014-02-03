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
{{if !$nolink && !empty($vardef.id_name)}} 
{if !empty({{sugarvar memberName='vardef.id_name' key='value' string='true'}})}
{capture assign="detail_url"}index.php?module={{$vardef.module}}&action=DetailView&record={{sugarvar  memberName='vardef.id_name' key='value'}}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
{{/if}}
<span id="{{$vardef.id_name}}" class="sugar_field" data-id-value="{{sugarvar memberName='vardef.id_name' key='value'}}">{{sugarvar key='value'}}</span>
{{if !$nolink && !empty($vardef.id_name)}}
{if !empty({{sugarvar memberName='vardef.id_name' key='value' string='true'}})}</a>{/if}
{{/if}}
{{if !empty($displayParams.enableConnectors) && !empty($vardef.id_name)}}
{if !empty({{sugarvar memberName='vardef.id_name' key='value' string='true'}})}
{{sugarvar_connector view='DetailView'}} 
{/if}
{{/if}}
