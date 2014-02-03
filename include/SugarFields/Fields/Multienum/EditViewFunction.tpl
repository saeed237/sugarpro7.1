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
<input type="hidden" id="{{sugarvar key='name'}}_multiselect" name="{{sugarvar key='name'}}_multiselect" value="true">
<select id="{{sugarvar key='name'}}" name="{{sugarvar key='name'}}[]" multiple="true" size="6" style="width:150" tabindex="{{$tabindex}}">
{{sugarvar key='value'}}
</select>