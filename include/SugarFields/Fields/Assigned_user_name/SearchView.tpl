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
{{capture name=display_size assign=size}}{{$displayParams.size|default:6}}{{/capture}}
{php}$this->_tpl_vars['user_options'] = get_user_array(false);{/php}
{html_options name='{{$vardef.name}}[]' options=$user_options size="{{$size}}" style="width: 150px" {{if $size > 1}}multiple="1"{{/if}} selected={{sugarvar key='value' string=true}}}
