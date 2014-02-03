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
<input type='text' name='{$vardef.name}' id='{$vardef.name}' size='{$displayParams.size|default:20}' {if !empty($vardef.len)}maxlength='{$vardef.len}'{elseif !empty($displayParams.maxlength)}maxlength='{$displayParams.maxlength}'{/if} value='{$vardef.value}' title='{$vardef.help}' {if !empty($vardef.readOnly) || !empty($displayParams.readOnly)}readonly="1"{/if} {$displayParams.field}> 