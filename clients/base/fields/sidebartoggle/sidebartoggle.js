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
({extendsFrom:'button',events:{'click .drawerTrig':'toggle'},_render:function(){app.view.Field.prototype._render.call(this);app.controller.context.trigger("sidebarRendered");},bindDataChange:function(){app.controller.context.on("toggleSidebarArrows",this.updateArrows,this);app.controller.context.on("openSidebarArrows",this.sidebarArrowsOpen,this);},updateArrows:function(){var chevron=this.$('.drawerTrig i'),pointRightClass='icon-double-angle-right';if(chevron.hasClass(pointRightClass)){this.updateArrowsWithDirection('close');}else{this.updateArrowsWithDirection('open');}},sidebarArrowsOpen:function(){this.updateArrowsWithDirection('open');},updateArrowsWithDirection:function(state){var chevron=this.$('.drawerTrig i'),pointRightClass='icon-double-angle-right',pointLeftClass='icon-double-angle-left';if(state==='open'){chevron.removeClass(pointLeftClass).addClass(pointRightClass);app.events.trigger('app:toggle:sidebar','open');}else if(state==='close'){chevron.removeClass(pointRightClass).addClass(pointLeftClass);app.events.trigger('app:toggle:sidebar','close');}else{app.logger.warn("updateArrowsWithDirection called with invalid state; should be 'open' or 'close', but was: "+state)}},toggle:function(){this.context.trigger('toggleSidebar');$(window).trigger('resize');},_dispose:function(){app.view.invokeParent(this,{type:'field',name:'button',method:'_dispose'});app.controller.context.off(null,null,this);}})