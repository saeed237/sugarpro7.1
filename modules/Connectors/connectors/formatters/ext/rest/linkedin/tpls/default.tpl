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
<script src="{if $smarty.server.HTTPS === 'on'}index.php?entryPoint=get_url&type=linkedin{else}{{$config.properties.company_url}}{/if}" type="text/javascript"></script>
<script type="text/javascript" src="{sugar_getjspath file='include/connectors/formatters/default/company_detail.js'}"></script>
{literal}
<style type="text/css">
.yui-panel .hd {
	background-color:#3D77CB;
	border-color:#FFFFFF #FFFFFF #000000;
	border-style:solid;
	border-width:1px;
	color:#000000;
	font-size:100%;
	font-weight:bold;
	line-height:100%;
	padding:4px;
	white-space:nowrap;
}
</style>
{/literal}
<script type="text/javascript">
function show_ext_rest_linkedin(event)
{literal} 
{

var xCoordinate = event.clientX;
var yCoordinate = event.clientY;
var isIE = document.all?true:false;
      
if(isIE) {
    xCoordinate = xCoordinate + document.body.scrollLeft;
    yCoordinate = yCoordinate + document.body.scrollTop;
}

{/literal}

cd = new CompanyDetailsDialog("linkedin_popup_div", '<div id="linkedin_div"></div>', xCoordinate, yCoordinate);
cd.setHeader("{$fields.{{$mapping_name}}.value}");
cd.display();
linked_in_popup = new LinkedIn.CompanyInsiderBox("linkedin_div", "{$fields.{{$mapping_name}}.value}");
{literal}
} 
{/literal}
</script>
