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

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top: 0px none; margin-bottom: 4px" >
<tr valign='top'>
	<td width='34%' align='left' rowspan='4' colspan='2'>
		<input id='displayColumnsDef' type='hidden' name='displayColumns'>
		<input id='hideTabsDef' type='hidden' name='hideTabs'>
		{$columnChooser}
		<br>
	</td>
	<td scope='row' align='left' width='10%'>
		{sugar_translate label='LBL_ORDER_BY_COLUMNS' module='SavedSearch'}

	</td>
	<td width='23%'>
		<select name='orderBy' id='orderBySelect'>
		</select>
	</td>
	<td scope='row' width='10%'>
		{sugar_translate label='LBL_DIRECTION' module='SavedSearch'}
	</td>
	<td width='23%'>
		<div><input id='sort_order_desc_radio' type='radio' name='sortOrder' value='DESC' {if $selectedSortOrder == 'DESC'}checked{/if}>&nbsp;<span onclick='document.getElementById("sort_order_desc_radio").checked = true' style="cursor: pointer; cursor: hand">{$MOD.LBL_DESCENDING}</span></div>
		
		<div><input id='sort_order_asc_radio' type='radio' name='sortOrder' value='ASC' {if $selectedSortOrder == 'ASC'}checked{/if}>&nbsp;<span onclick='document.getElementById("sort_order_asc_radio").checked = true' style="cursor: pointer; cursor: hand">{$MOD.LBL_ASCENDING}</span>
		</div>
	</td>
	</tr>

</table>
<script>
	SUGAR.savedViews.columnsMeta = {$columnsMeta};
	columnsMeta = {$columnsMeta};
	saved_search_select = "{$SAVED_SEARCH_SELECT}";
	selectedSortOrder = "{$selectedSortOrder|default:'DESC'}";
	selectedOrderBy = "{$selectedOrderBy}";


{literal}
	//this populates the label that shows the name of the current saved view
	//The label is located under the update/delete buttons
	function fillInLabels(){
		//this javascript runs and populates values in savedSearchForm.tpl
		x = document.getElementById('saved_search_select');
		if ((typeof(x) != 'undefined' && x != null) && x.selectedIndex !=0) {
            curr_search_name = document.getElementById('curr_search_name');
            curr_search_name.innerHTML = '';
            curr_search_name.appendChild(document.createTextNode('"'+x.options[x.selectedIndex].text+'"'));
			document.getElementById('ss_update').disabled = false;
			document.getElementById('ss_delete').disabled = false;
		}else{
			document.getElementById('ss_update').disabled = true;
			document.getElementById('ss_delete').disabled = true;
			document.getElementById('curr_search_name').innerHTML = '';
		}
	}
	//call scripts that need to get run onload of this form.  This function is called when image
	//to collapse/show subpanels is loaded
	function loadSSL_Scripts(){
		//this will fill in the name of the current module, and enable/disable update/delete buttons
		fillInLabels();
		//this populates the order by dropdown, and activates the chooser widget.
		SUGAR.savedViews.handleForm();
	}

{/literal}
</script>


