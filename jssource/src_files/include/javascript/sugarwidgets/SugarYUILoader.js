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


/**
 * @author dwheeler
 */
//Load up the YUI loader and go!
SUGAR.yui = {
	loader : new YAHOO.util.YUILoader({
        // Bug #48940 Skin always must be blank
        skin: {
            base: 'blank',
            defaultSkin: ''
        }
    })
} 

SUGAR.yui.loader.addModule({
	name:'sugarwidgets',
	type:'js', 
	path:'SugarYUIWidgets.js', 
	requires:['yahoo', 'layout', 'dragdrop', 'treeview', 'json', 'datatable', 'container', 'button', 'tabview'], 
	varname: YAHOO.SUGAR
});
