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
<hr />
<!-- Wireless Detail View -->
<div class="sectitle">{$MODULE_NAME}: {$BEAN_NAME}</div>
<div class="sec">
<table>
	{foreach from=$DETAILS item=DETAIL name="recordlist"}
	{if !$fields[$DETAIL.field].hidden}
    <tr>
		<td class="detail_label {if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">{$DETAIL.label|strip_semicolon}:</td>
		<td class="{if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">
		{if !empty($DETAIL.customCode)}
            {eval var=$DETAIL.customCode}
        {else}
            {sugar_field parentFieldArray='fields' vardef=$fields[$DETAIL.field] displayType='wirelessDetailView' displayParams='' typeOverride=$DETAIL.type}
        {/if}
		</td>
	</tr>
    {/if}
	{/foreach}
</table>
{if $ENABLE_FORM}
<form action="index.php" method="POST">
	<input class="button" type="submit" value="{sugar_translate label='LBL_EDIT_BUTTON_LABEL' module=''}" />
	<input type="hidden" name="record" value="{$BEAN_ID}" />
	<input type="hidden" name="module" value="{$MODULE}" />
	<input type="hidden" name="action" value="wirelessedit" />
    <input type="hidden" name="return_action" value="wirelessdetail" />
</form>
{/if}
</div>
{if $AVAILABLE_SUBPANELS}
	{if $AVAILABLE_SUBPANEL_DATA}
		<hr />
		<div class="sectitle">{sugar_translate label='LBL_RELATED_INFORMATION' module=''}</div>	
		{foreach from=$SUBPANEL_DATA key=SUBPANEL item=DATA}
			{if $DATA.count > 0}
				<div class="subpanel_sec">{$MODULELIST[$DATA.module]}</div>
				<ul class="sec">
				{foreach from=$DATA.list item=NAME key=ID name="recordlist"}
				<li class="{if $smarty.foreach.recordlist.index % 2 == 0}odd{else}even{/if}">
                    {assign var="module_image" value=$DATA.module}
                    {assign var="dotgif" value=".gif"}  
                    <a href="index.php?module={$DATA.module}&record={$ID}&action=wirelessdetail">
                        {sugar_getimage name=$module_image$dotgif alt=$module_image other_attributes='border="0" '}&nbsp;
                        {$NAME}
                    </a><br />                    
				</li>
				{/foreach}
				</ul>
				{if $DATA.count > $MAX_SUBPANEL_DATA}<a class="nav" href="index.php?module={$MODULE}&parent_id={$DETAIL.id}&action=wirelesslist&subpanel={$SUBPANEL}">({sugar_translate label='LBL_SEE_ALL' module=''} {$DATA.count} {sugar_translate label='LBL_LINK_RECORDS' module=''})</a><br />{/if}
			{/if}
			</div>
		{/foreach}
	{/if}
	<hr />
	<div class="sectitle">{sugar_translate label='LBL_ADD_BUTTON' module=''} {sugar_translate label='LBL_RELATED_INFORMATION' module=''}</div>
	<div class="sec">
	<form method="POST" action="index.php">
	<select name="module">
		{foreach from=$SUBPANEL_DATA key=SUBPANEL item=DATA}
		<option value="{$DATA.module}">{$MODULELIST[$DATA.module]}</option>
		{/foreach}
	</select>
    <input type="hidden" name="from_subpanel" value="1" />
	<input type="hidden" name="action" value="wirelessedit" />
	<input type="hidden" name="relate_id" value="{$BEAN_ID}" />
	<input type="hidden" name="related_module" value="{$MODULE}" />
    <input type="hidden" name="return_action" value="wirelessdetail" />
	<input type="submit" class="button" value="{sugar_translate label='LBL_ADD_BUTTON' module=''}" />
	</form>
	</div>
{/if}