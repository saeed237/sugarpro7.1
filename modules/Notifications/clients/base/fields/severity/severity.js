/*
     * By installing or using this file, you are confirming on behalf of the entity
     * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
     * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
     * http://www.sugarcrm.com/master-subscription-agreement
     *
     * If Company is not bound by the MSA, then by installing or using this file
     * you are agreeing unconditionally that Company will be bound by the MSA and
     * certifying that you have authority to bind Company accordingly.
     *
     * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
     */
({extendsFrom:'EnumField',_styleMapping:{'default':'label',alert:'label label-important',information:'label label-info',other:'label label-inverse',success:'label label-success',warning:'label label-warning'},_render:function(){this._super('_render');var severity=this.model.get(this.name);var severityCss=this._styleMapping[severity]||this._styleMapping.default;this.getFieldElement().addClass(severityCss);}})