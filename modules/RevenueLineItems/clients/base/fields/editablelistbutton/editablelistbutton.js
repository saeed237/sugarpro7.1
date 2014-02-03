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
({extendsFrom:'EditablelistbuttonField',getCustomSaveOptions:function(options){var origSuccess=options.success;return{success:_.bind(function(){if(_.isFunction(origSuccess)){origSuccess.apply(this,arguments);}
if(!_.isEmpty(this.model.get('quote_id'))){app.alert.show('save_rli_quote_notice',{level:'info',messages:app.lang.get('SAVE_RLI_QUOTE_NOTICE','RevenueLineItems'),autoClose:true});}},this)};}});