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
({_placeComponent:function(comp,def){var compdef=def.layout||def.view,size=compdef.span||4;if(!this.$el.children()[0]){this.$el.addClass("container-fluid").append('<div class="row-fluid"></div>');}
$().add("<div></div>").addClass("span"+size).append(comp.el).appendTo(this.$el.find("div.row-fluid")[0]);}})