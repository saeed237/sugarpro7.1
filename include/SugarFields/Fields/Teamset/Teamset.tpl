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
{sugarvar_teamset parentFieldArray={{$parentFieldArray}} vardef=$fields.team_name tabindex='{{$tabindex}}' display='{{$displayParams.display}}' labelSpan='{{$displayParams.labelSpan}}' fieldSpan='{{$displayParams.fieldSpan}}' formName='{{$displayParams.formName}}' tabindex=1 displayType='{{$renderView}}' {{if !empty($displayParams.idName)}} idName='{{$displayParams.idName}}'{{/if}} 	{{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}} }
