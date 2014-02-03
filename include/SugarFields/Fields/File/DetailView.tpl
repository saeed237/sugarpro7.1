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
<span class="sugar_field" id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}">
<a href="index.php?entryPoint=download&id={$fields.{{$vardef.fileId}}.value}&type={{$vardef.linkModule}}" class="tabDetailViewDFLink" target='_blank'>{{sugarvar key='value'}}</a>
</span>
{{if isset($vardef) && isset($vardef.allowEapm) && $vardef.allowEapm}}
{if isset($fields.{{$vardef.docType}}) && !empty($fields.{{$vardef.docType}}.value) && $fields.{{$vardef.docType}}.value != 'SugarCRM' && !empty($fields.{{$vardef.docUrl}}.value) }
{capture name=imageNameCapture assign=imageName}
{$fields.{{$vardef.docType}}.value}_image_inline.png
{/capture}
<a href="{$fields.{{$vardef.docUrl}}.value}" class="tabDetailViewDFLink" target="_blank">{sugar_getimage name=$imageName alt=$imageName other_attributes='border="0" '}</a>
{/if}
{{/if}}
{{if !empty($displayParams.enableConnectors)}}
{{sugarvar_connector view='DetailView'}}
{{/if}}
