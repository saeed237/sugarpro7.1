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

    	var SubpanelInit = function() {
    		SubpanelInitTabNames(["quotes","activities","opportunities","history","leads","campaigns","cases","contacts"]);
    	}
        var SubpanelInitTabNames = function(tabNames) {
    		subpanel_dd = new Array();
    		j = 0;
    		for(i in tabNames) {
    			subpanel_dd[j] = new ygDDList('whole_subpanel_' + tabNames[i]);
    			subpanel_dd[j].setHandleElId('subpanel_title_' + tabNames[i]);
    			subpanel_dd[j].onMouseDown = SUGAR.subpanelUtils.onDrag;
    			subpanel_dd[j].afterEndDrag = SUGAR.subpanelUtils.onDrop;
    			j++;
    		}

    		YAHOO.util.DDM.mode = 1;
    	}
    	currentModule = 'Contacts';
    	YAHOO.util.Event.addListener(window, 'load', SubpanelInit);

<script type='text/javascript'>
{literal}
var GlobalSearchOnDrag = function()
{
//console.log('dragging');
}

var GlobalSearchOnDrop = function()
{
//console.log('dropping');
}

{/literal}

var GlobalSearchInit = function()
{ldelim}
//console.log('loading...');
subpanel_dd = new Array();

{foreach from=$MODULE_RESULTS name=m key=module item=info}
subpanel_dd[{$module}] = new ygDDList('whole_subpanel_' + {$module});
subpanel_dd[{$module}].setHandleElId('div_' + {$module});
subpanel_dd[{$module}].onMouseDown = GlobalSearchOnDrag;
subpanel_dd[{$module}].afterEndDrag = GlobalSearchOnDrop;
{/foreach}	

YAHOO.util.DDM.mode = 1;
{rdelim}

YAHOO.util.Event.addListener(window, 'load', GlobalSearchInit);

</script>