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
({className:"filtered tabbable tabs-left",HIDE_SHOW_KEY:'hide-show',HIDE_SHOW:{HIDE:'hide',SHOW:'show'},initialize:function(opts){app.view.Layout.prototype.initialize.call(this,opts);this.hideShowLastStateKey=app.user.lastState.key(this.HIDE_SHOW_KEY,this);this.on("panel:toggle",this.togglePanel,this);this.listenTo(this.collection,"reset",function(){var hideShowLastState=app.user.lastState.get(this.hideShowLastStateKey);if(_.isUndefined(hideShowLastState)){this.togglePanel(this.collection.length>0,false);}else{this.togglePanel(hideShowLastState===this.HIDE_SHOW.SHOW,false);}});this.listenTo(this.collection,"reset add remove",this._checkIfSubpanelEmpty,this);},_checkIfSubpanelEmpty:function(){this.$(".subpanel").toggleClass("empty",this.collection.length===0);},_placeComponent:function(component){this.$(".subpanel").append(component.el);this._hideComponent(component,false);},togglePanel:function(show,saveState){this.$(".subpanel").toggleClass("closed",!show);if(arguments.length===1||saveState){app.user.lastState.set(this.hideShowLastStateKey,show?this.HIDE_SHOW.SHOW:this.HIDE_SHOW.HIDE);}
_.each(this._components,function(component){this._hideComponent(component,show);},this);},_hideComponent:function(component,show){if(component.name!="panel-top"){if(show){component.show();}else{component.hide();}}}})