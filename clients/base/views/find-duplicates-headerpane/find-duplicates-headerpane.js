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
({extendsFrom:'HeaderpaneView',events:{'click a[name=cancel_button]':'cancel','click a[name=merge_duplicates_button]:not(".disabled")':'mergeDuplicatesClicked'},plugins:['MergeDuplicates'],bindDataChange:function(){app.view.invokeParent(this,{type:'view',name:'headerpane',method:'bindDataChange'});this.on('mergeduplicates:complete',this.mergeComplete,this);this.context.on('change:mass_collection',this.addMassCollectionListener,this);},unbindData:function(){var massCollection=this.context.get('mass_collection');if(massCollection){massCollection.off(null,null,this);}
app.view.View.prototype.unbindData.call(this);},addMassCollectionListener:function(){var massCollection=this.context.get('mass_collection');massCollection.on('add remove',this.toggleMergeButton,this);},toggleMergeButton:function(){var disabled;if(this.context.get('mass_collection').length>0){disabled=false;}else{disabled=true;}
this.$("[name='merge_duplicates_button']").toggleClass('disabled',disabled);},cancel:function(){app.drawer.close();},mergeComplete:function(primaryRecord){app.drawer.closeImmediately(true,primaryRecord);},mergeDuplicatesClicked:function(){this.mergeDuplicates(this.context.get('mass_collection'),this.collection.dupeCheckModel);}})