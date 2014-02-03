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

 function commitverify(theform,notanumber,commitmessage) {
 	
 		best_case=new String(theform.best_case.value);
		if (isNaN(parseInt(best_case)) || isNaN(best_case)) {
			window.alert(notanumber + ' ' + best_case );
			return false;
		}

 		likely_case=new String(theform.likely_case.value);
		if (isNaN(parseInt(likely_case)) || isNaN(likely_case)) {
			window.alert(notanumber + ' ' + likely_case );
			return false;
		}

 		worst_case=new String(theform.worst_case.value);
		if (isNaN(parseInt(worst_case)) || isNaN(worst_case)) {
			window.alert(notanumber + ' ' + worst_case );
			return false;
		}
 		
 		//adjust the commit value if it has a fractional amount.
		if (parseFloat(best_case) != Math.floor(parseFloat(best_case))) {
			best_case = Math.round(parseFloat(best_case));
		}		
 		//adjust the commit value if it has a fractional amount.
		if (parseFloat(likely_case) != Math.floor(parseFloat(likely_case))) {
			likely_case = Math.round(parseFloat(likely_case));
		}		
 		//adjust the commit value if it has a fractional amount.
		if (parseFloat(worst_case) != Math.floor(parseFloat(worst_case))) {
			worst_case = Math.round(parseFloat(worst_case));
		}		

		cnf_message=commitmessage + ' ' + best_case + ', ' + likely_case + ', '+ worst_case + ' ?';				
		if (!confirm(cnf_message)) {
			return false;
		}
		
		theform.likely_case.value=likely_case;
		theform.worst_case.value=worst_case;
		theform.best_case.value=best_case;
		
		theform.commit_forecast.value='1';
	
		//reset value due to undo changes resulting from prior actions.
		document.CommitEditView.call_back_function.value='commit_forecast';
		
		return true;
}

function formsubmit(theform) {
		ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_PROCESSING_REQUEST'));

		var url=site_url.site_url + "/index.php?entryPoint=TreeData";
		var post_data=get_post_url(theform);
		var callback =	{
			  success: function(o) {    
					ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_REQUEST_PROCESSED'));			  	
					window.setTimeout('ajaxStatus.hideStatus()', 2000);
			    	var targetdiv=document.getElementById('activetimeperiodsworksheet');
	    			targetdiv.innerHTML=o.responseText;
                    $("ul.clickMenu").each(function(index, node){
                     	  		$(node).sugarActionMenu();
                    });
			  },
			  failure: function(o) {/*failure handler code*/}
		};
	
		var trobj = YAHOO.util.Connect.asyncRequest('POST',url, callback, post_data);
}

function get_chart(theform) {
		var url=site_url.site_url + "/index.php?entryPoint=TreeData"; 
		var post_data=get_post_url(theform);
		var callback =	{
			  success: function(o) {    
					subwindow=window.open("","forecast_chart","height=640,width=800,left=100,top=100,resizable=yes");
					subwindow.document.write(o.responseText);
					subwindow.document.close();
					subwindow.focus();
                    if (YAHOO.env.ua.ie) {
                        subwindow.location.reload();
                    }
			  },
			  failure: function(o) {/*failure handler code*/}
		};
	
		var trobj = YAHOO.util.Connect.asyncRequest('POST',url, callback, post_data);
}

function get_post_url(theform) {
	var url='';
	for (var i=0; i < theform.elements.length; i++) {
		if ((theform.elements[i].type=="text" || theform.elements[i].type=="hidden") && theform.elements[i].name != 'undefined' & theform.elements[i].name!='') {
			if (i>0) {
				url=url+"&";
			}
			url=url+theform.elements[i].name+"="+escape(theform.elements[i].value);
		}
	}
	return url;

}
//this function manages the adjusted amount array
//and is called every time adjustment amount is changed in the UI.
//works with the global objects adj_object and adj_total, they are set during forecast page load.
function update_adj_amount(field,tfield_name) {
	//calculate new total.
	var hidden_tfield=document.getElementById(tfield_name);
	var newtotal = parseFloat(hidden_tfield.value) - parseFloat(field.getAttribute('old_value'));
	newtotal = newtotal + parseFloat(field.value)
	
	//reset field's old value
	field.setAttribute('old_value',field.value);
	//set new total
	hidden_tfield.value=newtotal;
	
	var display_tfield=document.getElementById(tfield_name+"_DISPLAY");
	display_tfield.innerHTML=newtotal;
}

function list_nav(params,formname) {
	var theform=document.forms[formname];
	var url=site_url.site_url + "/index.php?entryPoint=TreeData";
	var post_data=get_post_url(theform);

	for (node in params) {
		post_data=post_data+'&'+node+'='+params[node]
	}
	post_data=post_data+'&call_back_function=list_nav';

	var callback =	{
		  success: function(o) {    
		    	var targetdiv=document.getElementById('activetimeperiodsworksheet');
    			targetdiv.innerHTML=o.responseText;
    			SUGAR.util.evalScript(o.responseText);
		  },
		  failure: function(o) {/*failure handler code*/}
	};
	
	var trobj = YAHOO.util.Connect.asyncRequest('POST',url, callback, post_data);
}

function copy_amount(forecast_type,copy_type) {
	
	var field_name;
	var best_case=0;
	var worst_case=0;
	var likely_case=0;
	if (forecast_type=='direct') {
		if (copy_type=='worksheet') {
			field=document.getElementById('WK_BEST_CASE_TOTAL');
			best_case=field.value;
			
			field=document.getElementById('WK_LIKELY_CASE_TOTAL');
			likely_case=field.value;

			field=document.getElementById('WK_WORST_CASE_TOTAL');
			worst_case=field.value;

		}else if (copy_type=='weigh') {
			field=document.getElementById('WEIGHTED_VALUE_TOTAL');
			best_case=worst_case=likely_case=field.value;
		} else {
			field=document.getElementById('REVENUE_TOTAL');
			best_case=worst_case=likely_case=field.value;
		}
	} else {
		if (copy_type=='worksheet') {
			field=document.getElementById('WK_BEST_CASE_TOTAL');
			best_case=field.value;
			
			field=document.getElementById('WK_LIKELY_CASE_TOTAL');
			likely_case=field.value;

			field=document.getElementById('WK_WORST_CASE_TOTAL');
			worst_case=field.value;
		} else {
			field=document.getElementById('BEST_CASE_TOTAL');
			best_case=field.value;
			
			field=document.getElementById('LIKELY_CASE_TOTAL');
			likely_case=field.value;

			field=document.getElementById('WORST_CASE_TOTAL');
			worst_case=field.value;
		}
	}
	
	wk_field=document.getElementById('commit_best_case');
	wk_field.value=unformat_currency(best_case);

	wk_field=document.getElementById('commit_worst_case');
	wk_field.value=unformat_currency(worst_case);

	wk_field=document.getElementById('commit_likely_case');
	wk_field.value=unformat_currency(likely_case);
} 
