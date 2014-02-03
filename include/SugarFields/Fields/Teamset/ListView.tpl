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
{if $parentFieldArray.TEAM_COUNT > 1}
<span id='div_{$parentFieldArray.ID}_teams'>
{$parentFieldArray.$col}<a href="#" style='text-decoration:none;' onMouseOver="javascript:toggleMore('div_{$parentFieldArray.ID}_teams','img_{$parentFieldArray.ID}_teams', 'Teams', 'DisplayInlineTeams', 'team_set_id={$parentFieldArray.TEAM_SET_ID}&team_id={$parentFieldArray.TEAM_ID}');"  onFocus="javascript:toggleMore('div_{$parentFieldArray.ID}_teams','img_{$parentFieldArray.ID}_teams', 'Teams', 'DisplayInlineTeams', 'team_set_id={$parentFieldArray.TEAM_SET_ID}');" id='more_feather'>+</a>
</span>
{else}
{$parentFieldArray.$col}
{/if}