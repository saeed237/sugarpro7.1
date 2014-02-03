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
{{if !$nolink}}
<input type="hidden" class="sugar_field" id="{{sugarvar key='name'}}" value="{{sugarvar key='value'}}">
<input type="hidden" class="sugar_field" id="{{$vardef.id_name}}" value="{{sugarvar key='value' memberName='vardef.id_name'}}">
<a href="index.php?module={{sugarvar objectName='fields' memberName='vardef.type_name' key='value'}}&action=DetailView&record={{sugarvar key='value' memberName='vardef.id_name'}}" class="tabDetailViewDFLink">{{/if}}{{sugarvar key='value'}}{{if !$nolink}}</a>
{{/if}}
{{if !empty($displayParams.enableConnectors)}}
{if !empty({{sugarvar key='value'}})}
{{sugarvar_connector view='DetailView'}}
{/if}
{{/if}}