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

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-top: 0px none; margin-bottom: 4px;">
<tr>
<td>
<!-- BEGIN PAGE RENDERING -->
	<table cellspacing='5' cellpadding='0' border='0' valign='top' width='100%'>
	{if $numCols > 1}
 	<tr>
 		{if $numCols > 2}
	 	<td>

		</td>
	
		<td rowspan="3">
				{sugar_getimage alt=$app_strings.LBL_BLANK name="blank" ext=".gif" width="15" height="1" other_attributes='border="0" '}
		</td>
		{/if}
		{if $numCols > 1}
		<td>

		</td>
		<td rowspan="3">
				{sugar_getimage alt=$app_strings.LBL_BLANK name="blank" ext=".gif" width="15" height="1" other_attributes='border="0" '}
		</td>
		{/if}	
	</tr>
	{/if}
	<tr>
	{counter assign=hiddenCounter start=0 print=false}
	{foreach from=$columns key=colNum item=data}
	<td valign='top' width={$data.width}>
		<ul class='noBullet' id='col_{$selectedPage}_{$colNum}'>
			<li id='page_{$selectedPage}_hidden{$hiddenCounter}b' style='height: 5px' class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
	        {foreach from=$data.dashlets key=id item=dashlet}		
			<li class='noBullet' id='dashlet_{$id}'>
				<div id='dashlet_entire_{$id}' class='dashletPanel'>
					{$dashlet.script}
					{$dashlet.displayHeader}
					{$dashlet.display}
					{$dashlet.displayFooter}
			    </div>
			</li>
			<script>
				SUGAR.mySugar.attachToggleToolsetEvent('{$id}');
			</script>
			{/foreach}
			<li id='page_{$selectedPage}_hidden{$hiddenCounter}' style='height: 5px' class='noBullet'>&nbsp;&nbsp;&nbsp;</li>
		</ul>
	</td>
	{counter}
	{/foreach}
	</tr>
	</table>
<!-- END PAGE RENDERING -->
</td>
</tr>
</table>
<script>
	{if !$lock_homepage}
	SUGAR.mySugar.attachDashletCtrlEvent();
	{/if}
</script>
