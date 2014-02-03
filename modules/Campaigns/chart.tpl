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

        <yData defaultAltText="{Y_DEFAULT_ALT_TEXT}">
                <!-- BEGIN: row -->
                <dataRow title="{Y_ROW_TITLE}" endLabel="{Y_ROW_ENDLABEl}">
                        <!-- BEGIN: bar -->
                        <bar id="{Y_BAR_ID}" totalSize="{Y_BAR_SIZE}" altText="{Y_BAR_ALTTEXT}" url="{Y_BAR_URL}"/>
                        <!-- END: bar -->
                </dataRow>
                <!-- END: row -->
        </yData>
        <xData min="{XMIN}" max="{XMAX}" length="{XLENGTH}" kDelim="{XKDELIM}" prefix="{XPREFIX}" suffix="{XSUFFIX}"/>
        <colorLegend status="on">
                <mapping id="'.$outcome.'" name="'.$outcome_translation.'" color="'.$color.'"/>
        </colorLegend>
        <graphInfo><![CDATA[{GRAPH_DATA}]]></graphInfo>
        <chartColors {COLOR_DEFS}/>
</graphData>
<!-- END: main -->
