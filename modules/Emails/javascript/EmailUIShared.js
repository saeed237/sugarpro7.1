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

SUGAR.email2 = {
    cache : new Object(),
    o : null, // holder for reference to AjaxObject's return object (used in composeDraft())
    reGUID : new RegExp(/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/i),
    templates : {},
    tinyInstances : {
        currentHtmleditor : ''
    },

    /**
     * preserves hits from email server
     */ 
    _setDetailCache : function(ret) {
        if(ret.meta) {
            var compKey = ret.meta.mbox + ret.meta.uid;

            if(!SUGAR.email2.cache[compKey]) {
                SUGAR.email2.cache[compKey] = ret;
            }
        }
    },

    autoSetLayout : function() {
    	var c = document.getElementById('container');
        var tHeight = YAHOO.util.Dom.getViewportHeight() - YAHOO.util.Dom.getY(c) - 35;
        //Ensure a minimum height.
        tHeight = Math.max(tHeight, 550);
        c.style.height = tHeight + "px";
        SUGAR.email2.complexLayout.set('height', tHeight);
        SUGAR.email2.complexLayout.set('width', YAHOO.util.Dom.getViewportWidth() - 40);
        SUGAR.email2.complexLayout.render();
        SUGAR.email2.listViewLayout.resizePreview();        
    }
};


/**
 * Shows overlay progress message
 */

//overlayModal
SUGAR.showMessageBoxModal = function(title, body) {
    SUGAR.showMessageBox(title, body);
}

//overlay
SUGAR.showMessageBox = function(reqtitle, body, type, additconfig) {
    var config = { };
    if (typeof(additconfig) == "object") {
        var config = additconfig;
    }
    config.type = type;
    config.title = reqtitle;
    config.msg = body;
    YAHOO.SUGAR.MessageBox.show(config);
}

//hideOverlay
SUGAR.hideMessageBox = function() {
	YAHOO.SUGAR.MessageBox.hide();
};
