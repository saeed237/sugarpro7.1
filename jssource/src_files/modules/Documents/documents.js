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




var rhandle=new RevisionListHandler();
var from_popup_return  = false;
function document_set_return(popup_reply_data)
{
	from_popup_return = true;
	var form_name = popup_reply_data.form_name;
	var name_to_value_array = popup_reply_data.name_to_value_array;
	related_doc_id='EMPTY';
	for (var the_key in name_to_value_array)
	{
		if(the_key != 'toJSON')
		{
			var displayValue=name_to_value_array[the_key];
			displayValue=displayValue.replace('&#039;',"'");  //restore escaped single quote.
			displayValue=displayValue.replace( '&amp;',"&");  //restore escaped &.
			displayValue=displayValue.replace( '&gt;',">");  //restore escaped >.
			displayValue=displayValue.replace( '&lt;',"<");  //restore escaped <.
			displayValue=displayValue.replace( '&quot; ',"\"");  //restore escaped ".
			if (the_key == 'related_doc_id') {
				related_doc_id =displayValue;
			}
			window.document.forms[form_name].elements[the_key].value = displayValue;
		}
	}
	related_doc_id=YAHOO.lang.JSON.stringify(related_doc_id);
	//make request for document revisions data.
	var conditions  = new Array();
    conditions[conditions.length] = {"name":"document_id","op":"starts_with","value":related_doc_id};
 	var query = {"module":"DocumentRevisions","field_list":['id','revision','date_entered'],"conditions":conditions,"order":{'by':'date_entered', 'desc': true}};

 	//make the call call synchronous for now...
    //todo: convert to async, test on mozilla..
    result = global_rpcClient.call_method('query',query,true);
    rhandle.display(result);
}


function RevisionListHandler() { }

RevisionListHandler.prototype.display = function(result) {
 	var names = result['list'];
 	var rev_tag=document.getElementById('related_doc_rev_id');
 	rev_tag.options.length=0;

	for(i=0; i < names.length; i++) {
		rev_tag.options[i] = new Option(names[i].fields['revision'],names[i].fields['id'],false,false);
	}
 	rev_tag.disabled=false;
}


function setvalue(source) {

	src = new String(source.value);
	target=new String(source.form.document_name.value);

	if (target.length == 0)
	{
		lastindex=src.lastIndexOf("/");
		if (lastindex == -1) {
			lastindex=src.lastIndexOf("\\");
		}
		if (lastindex == -1) {
			source.form.document_name.value=src;
		} else {
			source.form.document_name.value=src.substr(++lastindex, src.length);
		}
	}
}

function toggle_template_type(istemplate) {
	template_type = document.getElementById('template_type');
	if (istemplate.checked) {
		//template_type.enabled=true;
		template_type.disabled=false;
	} else {
		//template_type.enabled=false;
		template_type.disabled=true;
	}
}
