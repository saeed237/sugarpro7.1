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
[{foreach from=$FAVORITES item=item name=favorites}{ldelim}"text":"{$item.label|htmlentities:$smarty.const.ENT_QUOTES:'utf-8'}","url": "{sugar_link module=$item.module action='DetailView' record=$item.record_id link_only=1}"{rdelim}{if !$smarty.foreach.favorites.last},{/if}{foreachelse}{ldelim} "text": "{$APP.NTC_NO_ITEMS_DISPLAY}"{rdelim}{/foreach}]