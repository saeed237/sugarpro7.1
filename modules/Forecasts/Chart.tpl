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


<!-- BEGIN: main -->
<graphData title="{GRAPHTITLE}">

        <{AXIS1} length="{AXIS_LENGTH}">
                <!-- BEGIN: row -->
                <dataRow title="{ROW_TITLE}" >
                        <!-- BEGIN: bar -->
                        <bar id="{BAR_ID}" totalSize="{BAR_SIZE}" altText="{BAR_ALTTEXT}" url="{BAR_URL}"/>
                        <!-- END: bar -->
                </dataRow>
                <!-- END: row -->
        </{AXIS1}>
        <{AXIS2} min="{MIN}" max="{MAX}" length="{LENGTH}" kDelim="{KDELIM}" prefix="{PREFIX}" suffix="{SUFFIX}"defaultAltText="{DEFAULT_TEXT}"/>
        <colorLegend status="on">
	       <!-- BEGIN: legend -->
	        <mapping id="{LEGEND_ID}" name="{LEGEND_NAME}" color="{LEGEND_COLOR}"/>
           <!-- END: legend -->
	    </colorLegend >    
        <graphInfo>
			<![CDATA[{CHART_FOOTER}]]>
        </graphInfo>
        <chartColors {COLOR_DEFS}/>
</graphData>
<!-- END: main -->