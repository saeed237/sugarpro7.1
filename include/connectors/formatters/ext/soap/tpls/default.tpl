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
<div style="visibility:hidden;" id="{{$source}}_popup_div"></div>
<script type="text/javascript">
function show_{{$source}}(event) 
{literal}
{

		var callback =	{
			success: function(data) {
				eval('result = ' + data.responseText);
				if(typeof result != 'Undefined') {
				    names = new Array();
				    output = '';
				    count = 0;
                    for(var i in result) {
                        if(count == 0) {
	                        detail = 'Showing first result <p>';
	                        for(var field in result[i]) {
	                            detail += '<b>' + field + ':</b> ' + result[i][field] + '<br>';
	                        }
	                        output += detail + '<p>';
                        } 
                        count++;
                    }
                {/literal}
					cd = new CompanyDetailsDialog("{{$source}}_popup_div", output, event.clientX, event.clientY);
			    {literal}
					cd.setHeader("Found " + count + (count == 1 ? " result" : " results"));
					cd.display();                    
				} else {
				    alert("Unable to retrieve information for record");
				}
			},
			
			failure: function(data) {
				
			}		  
		}

{/literal}

url = 'index.php?module=Connectors&action=DefaultSoapPopup&source_id={{$source}}&module_id={{$module}}&record_id={$fields.id.value}&mapping={{$mapping}}';
var cObj = YAHOO.util.Connect.asyncRequest('POST', url, callback);
			   
{literal}
}
{/literal}
</script>