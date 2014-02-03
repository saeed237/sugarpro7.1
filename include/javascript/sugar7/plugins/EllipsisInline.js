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
(function(app){app.events.on("app:init",function(){app.plugins.register('EllipsisInline',['view','field'],{events:{'mouseenter .ellipsis_inline':'_showEllipsisTooltip','mouseleave .ellipsis_inline':'_hideEllipsisTooltip'},_$ellipsisTooltips:null,onAttach:function(){this.before('render',function(){this.destroyEllipsisTooltips();},this);this.on('render',function(){this.initializeEllipsisTooltips();},this);},onDetach:function(){this.destroyEllipsisTooltips();},initializeEllipsisTooltips:function(){app.utils.tooltip.destroy(this._$ellipsisTooltips);this._$ellipsisTooltips=app.utils.tooltip.initialize(this.$('.ellipsis_inline'),{trigger:'manual'});},destroyEllipsisTooltips:function(){app.utils.tooltip.destroy(this._$ellipsisTooltips);this._$ellipsisTooltips=null;},_showEllipsisTooltip:function(event){var target=event.currentTarget;if(this._shouldShowEllipsisTooltip(target)){$(target).tooltip('show');}},_hideEllipsisTooltip:function(event){var target=event.currentTarget;if(this._shouldHideEllipsisTooltip(target)){$(target).tooltip('hide');}},_shouldShowEllipsisTooltip:function(target){return app.utils.tooltip.has(target)&&(target.offsetWidth<target.scrollWidth);},_shouldHideEllipsisTooltip:function(target){return app.utils.tooltip.has(target)&&$(target).data('tooltip').tip().hasClass('in');}});});})(SUGAR.App);