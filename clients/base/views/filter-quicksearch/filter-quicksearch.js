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
({events:{'keyup':'throttledSearch','paste':'throttledSearch'},plugins:['QuickSearchFilter'],tagName:'input',className:'search-name',attributes:{'type':'text'},initialize:function(opts){app.view.View.prototype.initialize.call(this,opts);this.listenTo(this.layout,'filter:clear:quicksearch',this.clearInput);this.listenTo(this.layout,'filter:change:module',this.updatePlaceholder);},throttledSearch:_.debounce(function(e){var newSearch=this.$el.val();if(this.currentSearch!==newSearch){this.currentSearch=newSearch;this.layout.trigger('filter:apply',newSearch);}},400),getFieldLabels:function(moduleName,fields){var moduleMeta=app.metadata.getModule(moduleName);var labels=[];_.each(fields,function(fieldName){var fieldMeta=moduleMeta.fields[fieldName];labels.push(app.lang.get(fieldMeta.vname,moduleName).toLowerCase());});return labels;},updatePlaceholder:function(linkModuleName,linkModule){var label;this.toggleInput();if(!this.$el.hasClass('hide')&&linkModule!=='all_modules'){var fields=this.getModuleQuickSearchFields(linkModuleName),fieldLabels=this.getFieldLabels(linkModuleName,fields);label=app.lang.get('LBL_SEARCH_BY')+' '+fieldLabels.join(', ')+'...';}else{label=app.lang.get('LBL_BASIC_QUICK_SEARCH');}
this.$el.attr('placeholder',label);},toggleInput:function(){this.$el.toggleClass('hide',!!this.layout.showingActivities);},clearInput:function(){this.toggleInput();this.$el.val('');this.currentSearch='';this.layout.trigger('filter:apply');}})