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
{if isset($displayParams.link)}
<a href='{$displayParams.link}'>
{/if}

<img
	id="img_picture" 
	name="img_picture" 
	{if empty($picture_value)}
	   src='' 	
	{else}
	   src='index.php?entryPoint=download&id={$picture_value}&type=SugarFieldImage&isTempFile=1&isProfile=1'
	{/if}	
	style='
		{if empty($picture_value)}
			display:	none;
		{/if}
		{if "$vardef.border" eq ""}
			border: 0; 
		{else}
			border: 1px solid black; 
		{/if}
		{if "$vardef.width" eq ""}
			width: auto;
		{else}
			width: {$vardef.width}px;
		{/if}
		{if "$vardef.height" eq ""}
			height: auto;
		{else}
			height: {$vardef.height}px;
		{/if}
		'		
>

{if isset($displayParams.link)}
</a>
{/if}