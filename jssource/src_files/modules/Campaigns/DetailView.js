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




function set_return_prospect_list_and_save(popup_reply_data)
{
	var form_name = popup_reply_data.form_name;
	var name_to_value_array = popup_reply_data.name_to_value_array;
	
	
	for (var the_key in name_to_value_array)
	{
		if(the_key == 'toJSON')
		{
			/* just ignore */
		}
		else
		{
			window.document.forms[form_name].elements[the_key].value = name_to_value_array[the_key];
		}
	}
	
	window.document.forms[form_name].module.value = 'Campaigns';
	window.document.forms[form_name].return_module.value = window.document.forms[form_name].module.value;
	window.document.forms[form_name].return_action.value = 'DetailView';
	window.document.forms[form_name].return_id.value = window.document.forms[form_name].record.value;
	window.document.forms[form_name].action.value = 'SaveCampaignProspectListRelationship';
	window.document.forms[form_name].submit();
}