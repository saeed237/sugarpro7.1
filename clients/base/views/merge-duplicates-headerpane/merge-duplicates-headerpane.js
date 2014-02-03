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
({extendsFrom:'HeaderpaneView',events:{'click a[name=cancel_button]':'cancel','click a[name=save_button]':'save'},initialize:function(options){app.view.invokeParent(this,{type:'view',name:'headerpane',method:'initialize',args:[options]});var records=options.context.get('selectedDuplicates');this.title=app.lang.get('TPL_MERGING_RECORDS',this.module,{mergeCount:records.length});},cancel:function(){app.drawer.close();},save:function(){this.layout.trigger('mergeduplicates:save:fire');}})