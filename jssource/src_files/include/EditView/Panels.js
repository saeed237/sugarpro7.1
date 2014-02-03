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


function initPanel(id, state) {
    panelId = 'detailpanel_' + id;
    expandPanel(id);
    if(state == 'collapsed') {
        collapsePanel(id);
    }
}

function expandPanel(id) {
    var panelId = 'detailpanel_' + id;
    document.getElementById(panelId).className = document.getElementById(panelId).className.replace(/(expanded|collapsed)/ig, '') + ' expanded';
}

function collapsePanel(id) {
    var panelId = 'detailpanel_' + id;
    document.getElementById(panelId).className = document.getElementById(panelId).className.replace(/(expanded|collapsed)/ig, '') + ' collapsed';
}

function setCollapseState(mod, panel, isCollapsed) {
    var sugar_panel_collase = Get_Cookie("sugar_panel_collase");
    if(sugar_panel_collase == null) {
        sugar_panel_collase = {};
    } else {
        sugar_panel_collase = YAHOO.lang.JSON.parse(sugar_panel_collase);
    }
    sugar_panel_collase[mod] = sugar_panel_collase[mod] || {};
    sugar_panel_collase[mod][panel] = isCollapsed;

    Set_Cookie('sugar_panel_collase', YAHOO.lang.JSON.stringify(sugar_panel_collase),30,'/','','');
}