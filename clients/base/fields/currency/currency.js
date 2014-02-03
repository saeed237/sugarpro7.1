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
({'events':{'click':'updateCss'},transactionValue:'',_currencyField:null,_currencyFieldDisabled:false,hideCurrencyDropdown:false,_lastCurrencyId:null,initialize:function(options){app.view.Field.prototype.initialize.call(this,options);var currencyField=this.def.currency_field||'currency_id';if(this.model.isNew()&&(!this.model.isCopy())){this.model.set(currencyField,app.user.get('preferences').currency_id);this.model.set(this.def.base_rate_field||'base_rate',app.metadata.getCurrency(app.user.get('preferences').currency_id).conversion_rate);}
this.hideCurrencyDropdown=this.view.action==='list';this._lastCurrencyId=this.model.get(currencyField);},_render:function(){if(this._currencyField){this._currencyField.dispose();this._currencyField=null;}
app.view.Field.prototype._render.call(this);if(this.hideCurrencyDropdown===false&&(this.action==='edit'||this.action==='disabled')){this.getCurrencyField().setElement(this.$('span[sfuuid="'+this.currencySfId+'"]'));this.$el.find('div.select2-container').css('min-width','8px');this.getCurrencyField().render();}
return this;},bindDataChange:function(){this.model.on('change:'+this.name,this._valueChangeHandler,this);if(this.def.is_base_currency){return;}
var currencyField=this.def.currency_field||'currency_id';var baseRateField=this.def.base_rate_field||'base_rate';this.model.on('change:'+currencyField,function(model,currencyId,options){if(!currencyId||!this._lastCurrencyId){this._lastCurrencyId=currencyId;return;}
this.model.set(baseRateField,app.metadata.getCurrency(currencyId).conversion_rate);if(model.has(this.name)){var val=model.get(this.name);if(val===''){val=0;}
this.model.set(this.name,app.currency.convertAmount(app.currency.unformatAmountLocale(val),this._lastCurrencyId,currencyId),{silent:true});var self=this;_.defer(function(){self.model.trigger('change:'+self.name,self.model,self.model.get(self.name));});}
this._lastCurrencyId=currencyId;},this);},_valueChangeHandler:function(model,value)
{if(this.action!='edit'){this.render();}else{this.setCurrencyValue(value);}},setCurrencyValue:function(value){this.$('[name='+this.name+']').val(app.utils.formatNumberLocale(value));},format:function(value){if(_.isNull(value)||_.isUndefined(value)||_.isNaN(value)){value='';}
if(this.tplName==='edit'||(this.tplName=='disabled'&&this.action=='disabled')){this.currencySfId=this.getCurrencyField().sfId;return app.utils.formatNumberLocale(value);}
var baseRate;var currencyId;if(this.def.is_base_currency){currencyId=app.currency.getBaseCurrencyId();}else{this.transactionValue='';if(this.def.convertToBase&&this.def.showTransactionalAmount&&this.model.get(this.def.currency_field||'currency_id')!==app.currency.getBaseCurrencyId()){this.transactionValue=app.currency.formatAmountLocale(this.model.get(this.name)||0,this.model.get(this.def.currency_field||'currency_id'));}
baseRate=this.model.get(this.def.base_rate_field||'base_rate');currencyId=this.model.get(this.def.currency_field||'currency_id');if(this.def.convertToBase){value=app.currency.convertWithRate(value,baseRate)||0;currencyId=app.currency.getBaseCurrencyId();}}
return app.currency.formatAmountLocale(value,currencyId);},unformat:function(value){if(this.tplName==='edit'){return app.utils.unformatNumberStringLocale(value);}
return app.currency.unformatAmountLocale(value);},updateCss:function(){$('div.select2-drop.select2-drop-active').width('auto');},getCurrencyField:function(){if(!_.isNull(this._currencyField)){return this._currencyField;}
var currencyDef=this.model.fields[this.def.currency_field||'currency_id'];currencyDef.type='enum';currencyDef.options=app.currency.getCurrenciesSelector(Handlebars.compile('{{symbol}} ({{iso4217}})'));currencyDef.enum_width='100%';currencyDef.searchBarThreshold=this.def.searchBarThreshold||7;this._currencyField=app.view.createField({def:currencyDef,view:this.view,viewName:this.action,model:this.model});this._currencyField.defaultOnUndefined=false;return this._currencyField;},setMode:function(name){app.view.Field.prototype.setMode.call(this,name);this.getCurrencyField().setMode(name);},dispose:function(){if(this._currencyField){this._currencyField.dispose();this._currencyField=null;}
app.view.Field.prototype.dispose.call(this);}})