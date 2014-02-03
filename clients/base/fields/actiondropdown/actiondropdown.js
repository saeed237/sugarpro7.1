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
({extendsFrom:'FieldsetField',fields:null,dropdownFields:null,events:{'click [data-toggle=dropdown]':'renderDropdown','change [data-toggle=dropdownmenu]':'dropdownSelected','touchstart [data-toggle=dropdownmenu]':'renderDropdown'},plugins:['Tooltip'],showNoData:false,initialize:function(options){app.view.invokeParent(this,{type:'field',name:'fieldset',method:'initialize',args:[options]});this.dropdownFields=[];var actiondropdownField=app.view._getController({type:'field',name:'actiondropdown'});this.setPlaceholder=_.throttle(actiondropdownField.prototype.setPlaceholder,100);},renderDropdown:function(){if(_.isEmpty(this.dropdownFields)||this.isDisabled()){return;}
_.each(this.dropdownFields,function(field){this.view.fields[field.sfId]=field;field.setElement(this.$('span[sfuuid="'+field.sfId+'"]'));if(this.def['switch_on_click']&&!this.def['no_default_action']){field.$el.on('click.'+this.cid,_.bind(this.switchButton,this));}
field.render();},this);this.dropdownFields=null;if(!this.def['switch_on_click']||this.def['no_default_action']){return;}
var firstField=_.first(this.fields);firstField.$el.on('click.'+this.cid,_.bind(this.switchButton,this));},switchButton:function(evt){var sfId=parseInt(this.$(evt.currentTarget).attr('sfuuid'),10),index=-1;_.some(this.fields,function(field,idx){if(field.sfId===sfId){index=idx;return true;}
return false;},this);if(index<=0){return;}
var firstField=this.fields.shift(),selectedField=this.fields.splice(index-1,1,firstField).pop();this.fields.splice(0,0,selectedField);this.setPlaceholder();},dropdownSelected:function(evt){if(this.isDisabled()){return;}
var $el=this.$(evt.currentTarget),selectedIndex=$el.val();if(!selectedIndex){return;}
this.fields[selectedIndex].getFieldElement().trigger('click');$el.blur();this.setPlaceholder();},getPlaceholder:function(){if(this.options.viewName==='list-header')return app.view.Field.prototype.getPlaceholder.call(this);var caretCss='btn dropdown-toggle';if(this.def['no_default_action']){caretCss+=' btn-invisible';}else if(this.def['primary']){caretCss+=' btn-primary';}
var cssClass=[],container='',caretIcon=this.def['icon']?this.def['icon']:'icon-caret-down',caret='<a class="'+caretCss+'" data-toggle="dropdown" href="javascript:void(0);" data-placement="bottom" rel="tooltip" title="'+app.lang.get('LBL_LISTVIEW_ACTIONS')+'">'+'<span class="'+caretIcon+'"></span>'+'</a>',dropdown='<ul class="dropdown-menu">';if(app.utils.isTouchDevice()){caret+='<select data-toggle="dropdownmenu" class="hide dropdown-menu-select"></select>';}
var index=this.def['no_default_action']?1:0;_.each(this.def.buttons,function(fieldDef){var field=app.view.createField({def:fieldDef,view:this.view,viewName:this.options.viewName,model:this.model});this.fields.push(field);field.on('show hide',this.setPlaceholder,this);field.parent=this;if(fieldDef.type==='divider'){return;}
if(index==0){container+=field.getPlaceholder();}else{delete this.view.fields[field.sfId];this.dropdownFields.push(field);if(index==1){cssClass.push('actions','btn-group');container+=caret;container+=dropdown;}
container+='<li>'+field.getPlaceholder()+'</li>';}
index++;},this);var cssName=cssClass.join(' '),placeholder='<span sfuuid="'+this.sfId+'" class="'+cssName+'">'+container;placeholder+=(_.size(this.def.buttons)>0)?'</ul></span>':'</span>';return new Handlebars.SafeString(placeholder);},_render:function(){app.view.invokeParent(this,{type:'field',name:'fieldset',method:'_render'});this.setPlaceholder();this._updateCaret();},_updateCaret:function(){if(_.isEmpty(this.dropdownFields)){return;}
var caretEnabled=_.some(this.dropdownFields,function(field){if(field.hasAccess()){if(field.def.css_class.indexOf('disabled')>-1){return false;}else if(field.isDisabled()){return false;}else{return true;}}
return false;});if(!caretEnabled){this.$('.icon-caret-down').closest('a').addClass('disabled');}},setPlaceholder:function(){if(this.disposed){return;}
var index=this.def['no_default_action']?1:0,visibleEl=document.createDocumentFragment(),hiddenEl=document.createDocumentFragment(),selectEl=this.$('.dropdown-menu-select'),html='<option></option>';_.each(this.fields,function(field,idx){var cssClass=_.unique(field.def.css_class?field.def.css_class.split(' '):[]),fieldPlaceholder=this.$('span[sfuuid="'+field.sfId+'"]');if(field.type==='divider'){if(index<=1){return;}
var dividerEl=document.createElement('li');dividerEl.className='divider';visibleEl.appendChild(dividerEl);return;}
if(field.isVisible()&&field.hasAccess()){cssClass=_.without(cssClass,'hide');fieldPlaceholder.toggleClass('hide',false);if(index==0){cssClass.push('btn');field.getFieldElement().addClass('btn');if(this.def.primary){cssClass.push('btn-primary');field.getFieldElement().addClass('btn-primary');}
this.$el.prepend(fieldPlaceholder);}else{cssClass=_.without(cssClass,'btn','btn-primary');field.getFieldElement().removeClass('btn btn-primary');var dropdownEl=document.createElement('li');dropdownEl.appendChild(fieldPlaceholder.get(0));visibleEl.appendChild(dropdownEl);html+='<option value='+idx+'>'+field.label+'</option>';}
index++;}else{cssClass.push('hide');fieldPlaceholder.toggleClass('hide',true);hiddenEl.appendChild(fieldPlaceholder.get(0));}
cssClass=_.unique(cssClass);field.def.css_class=cssClass.join(' ');},this);if(index<=1){this.$('.dropdown-toggle').hide();selectEl.addClass('hide');this.$el.removeClass('btn-group');}else{this.$('.dropdown-toggle').show();selectEl.removeClass('hide');this.$el.addClass('btn-group');}
this.$('.dropdown-menu').children('li').remove();this.$('.dropdown-menu').append(visibleEl);this.$el.append(hiddenEl);if(app.utils.isTouchDevice()){selectEl.html(html);}
var firstButton=_.first(this.fields);if(firstButton&&!firstButton.isVisible()){this.renderDropdown();}},setDisabled:function(disable){app.view.invokeParent(this,{type:'field',name:'fieldset',method:'setDisabled',args:[disable]});disable=_.isUndefined(disable)?true:disable;if(disable){this.$('.dropdown-toggle').addClass('disabled');}else{this.$('.dropdown-toggle').removeClass('disabled');}},_dispose:function(){_.each(this.fields,function(field){field.$el.off('click.'+this.cid);field.off('show hide',this.setPlaceholder,this);},this);this.dropdownFields=null;app.view.invokeParent(this,{type:'field',name:'fieldset',method:'_dispose'});},isVisible:function(){return!this.getFieldElement().is(':hidden');}})