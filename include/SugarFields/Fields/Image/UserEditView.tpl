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


{if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}
<input type="hidden" id="picture_duplicate" name="picture_duplicate" value="{$picture_value}"/>
{/if}

<input 
	type="file" id="picture" name="picture" 
	title="" size="30" maxlength="255" value="" tabindex="0" 
	onchange="confirm_imagefile('picture');" 
	{if !empty($picture_value)}
	style="display:none"
	{/if}
/>

{if empty($picture_value)}
<img
	id="img_picture" 
	name="img_picture" 	
	src='index.php?entryPoint=download&id={$picture_value}&type=SugarFieldImage&isTempFile=1&isProfile=1'
	style='
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
			height: {$vardef.height} px;
		{/if}
		'	

>
{else}
<img
	id="img_picture" 
	name="img_picture" 	
	src='index.php?entryPoint=download&id={$picture_value}&type=SugarFieldImage&isTempFile=1&isProfile=1'
	style='
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
			height: {$vardef.height} px;
		{/if}
		'	

>
<img
	id="bt_remove_picture" 
	name="bt_remvoe_picture" 
	alt=$APP.LBL_REMOVE
	title="{$APP.LBL_REMOVE}"
	src="{sugar_getimagepath file='delete_inline.gif'}"
	onclick="remove_upload_imagefile('picture');" 	
	/>

<input id="remove_imagefile_picture" name="remove_imagefile_picture" type="hidden"  value="" />
{/if}


<script type='text/javascript'>	
     function remove_upload_imagefile(field_name) {ldelim}
            var field=document.getElementById('remove_imagefile_' + field_name);
            field.value=1;            
            
            //enable the file upload button.
            var field=document.getElementById( field_name);
            field.style.display="";
            
            //hide the image and remove button.
            var field=document.getElementById('img_' + field_name);
            field.style.display="none";
            var field=document.getElementById('bt_remove_' + field_name);
            field.style.display="none";
            
            if(document.getElementById(field_name + '_duplicate')) {ldelim}
               var field = document.getElementById(field_name + '_duplicate');
               field.value = "";
            {rdelim}            
    {rdelim}
    
    function confirm_imagefile(field_name) {ldelim}
    		var field=document.getElementById(field_name); 
    		var filename=field.value;   
        	var fileExtension = filename.substring(filename.lastIndexOf(".")+1);
        	fileExtension = fileExtension.toLowerCase();
			if (fileExtension == "jpg" || fileExtension == "jpeg" 
				|| fileExtension == "gif" || fileExtension == "png" || fileExtension == "bmp"){ldelim}
					//image file
				{rdelim}
			else{ldelim}
				field.value=null;
				alert("{$APP.LBL_UPLOAD_IMAGE_FILE_INVALID}");
			{rdelim}
	{rdelim}
</script>