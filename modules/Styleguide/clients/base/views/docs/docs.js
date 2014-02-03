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
({className:'container-fluid',pageData:{},section:{},page:{},section_page:false,parent_link:'',file:'',keys:[],initialize:function(options){var self=this,keys=[];app.view.View.prototype.initialize.call(this,options);this.pageData=app.metadata.getView('Styleguide','sg-headerpane').page_data;this.file=this.context.get('page_name');if(this.file&&this.file!==''){keys=this.file.split('_');}
this.keys=keys;if(keys.length){if(keys[0]==='index'){if(keys.length>1){this.section=this.pageData[keys[1]];}else{this.section=this.pageData[keys[0]];}
this.section_page=true;this.file='index';}else if(keys.length>1){this.section=this.pageData[keys[0]];this.page=this.section.pages[keys[1]];this.parent_link='_'+keys[0];}else{this.section=this.pageData[keys[0]];}}
var initFn=this['init_'+keys[1]];if(initFn){initFn(this.pageData);}},_render:function(){var self=this,$find;var pageContent=app.template.getView('content.'+this.file,'Styleguide');if(pageContent){this.content=pageContent(self);}
app.view.View.prototype._render.call(this);if(this.keys[0]==='index'){this.render_index(this.keys[1]);}else{var renderFn=this['render_'+this.keys[1]];if(renderFn){renderFn(self);}
window.prettyPrint&&prettyPrint();}},init_labels:function(pageData){pageData.module_list=[];if(app.metadata.getModuleNames(true,'read')){_.each(app.metadata.getModuleNames(true,'read'),function(val){if(['Home'].indexOf(val)===-1){pageData.module_list.push(val);}});}
pageData.module_list.sort();},render_jstree:function(view){view.$('#people').jstree({"json_data":{"data":[{"data":"Sabra Khan","state":"open","metadata":{id:1},"children":[{"data":"Mark Gibson","metadata":{id:2}},{"data":"James Joplin","metadata":{id:3}},{"data":"Terrence Li","metadata":{id:4}},{"data":"Amy McCray","metadata":{id:5},"children":[{"data":"Troy McClure","metadata":{id:6}},{"data":"James Kirk","metadata":{id:7}}]}]}]},"plugins":["json_data","ui","types"]}).bind('loaded.jstree',function(){view.$('#people').addClass('jstree-sugar');view.$('#people > ul').addClass('list');view.$('#people > ul > li > a').addClass('jstree-clicked');}).bind('select_node.jstree',function(e,data){data.inst.toggle_node(data.rslt.obj);});},render_editable:function(view){view.$('.url-editable-trigger').on('click.styleguide',function(){var uefield=$(this).next();uefield.html(uefield.text()).editable(function(value,settings){var nvprep='<a href="'+value+'">',nvapp='</a>',value=nvprep.concat(value);return(value);},{onblur:'submit'}).trigger('click.styleguide');});view.$('.text-editable-trigger').on('click.styleguide',function(){var uefield=$(this).next();uefield.html(uefield.text()).editable().trigger('click.styleguide');});view.$('.urleditable-field > a').each(function(){if(isEllipsis($(this))===true){$(this).attr({'data-original-title':$(this).text(),'rel':'tooltip','class':'longUrl'});}});function isEllipsis(e){return(e[0].offsetWidth<e[0].scrollWidth);}
view.$('.longUrl[rel=tooltip]').tooltip({placement:'top'});},render_switch:function(view){view.$('#mySwitch').on('switch-change',function(e,data){var $el=$(data.el),value=data.value;});},render_datetime:function(view){view.model.start_date='2000-01-01T22:47:00+00:00';var fieldSettingsDate={view:view,def:{name:'start_date',type:'date',view:'edit',enabled:true},viewName:'edit',context:view.context,module:view.module,model:view.model,meta:app.metadata.getField('date')},dateField=app.view.createField(fieldSettingsDate);view.$('#sugar7_date').append(dateField.el);dateField.render();view.model.start_datetime='2000-01-01T22:47:00+00:00';var fieldSettingsCombo={view:view,def:{name:'start_datetime',type:'datetimecombo',view:'edit',enabled:true},viewName:'edit',context:view.context,module:view.module,model:view.model,meta:app.metadata.getField('datetimecombo')},datetimecomboField=app.view.createField(fieldSettingsCombo);view.$('#sugar7_datetimecombo').append(datetimecomboField.el);datetimecomboField.render();view.$('#dp1').datepicker();view.$('#tp1').timepicker();view.$('#dp2').datepicker({format:'mm-dd-yyyy'});view.$('#tp2').timepicker({timeFormat:'H.i.s'});view.$('#dp3').datepicker();var startDate=new Date(2012,1,20);var endDate=new Date(2012,1,25);view.$('#dp4').datepicker().on('changeDate',function(ev){if(ev.date.valueOf()>endDate.valueOf()){view.$('#alert').show().find('strong').text('The start date can not be greater then the end date');}else{view.$('#alert').hide();startDate=new Date(ev.date);view.$('#startDate').text(view.$('#dp4').data('date'));}
view.$('#dp4').datepicker('hide');});view.$('#dp5').datepicker().on('changeDate',function(ev){if(ev.date.valueOf()<startDate.valueOf()){view.$('#alert').show().find('strong').text('The end date can not be less then the start date');}else{view.$('#alert').hide();endDate=new Date(ev.date);view.$('#endDate').text(view.$('#dp5').data('date'));}
view.$('#dp5').datepicker('hide');});view.$('#tp3').timepicker({'scrollDefaultNow':true});view.$('#tp4').timepicker();view.$('#tp4_button').on('click',function(){view.$('#tp4').timepicker('setTime',new Date());});view.$('#tp5').timepicker({'minTime':'2:00pm','maxTime':'6:00pm','showDuration':true});view.$('#tp6').timepicker();view.$('#tp6').on('changeTime',function(){view.$('#tp6_legend').text('You selected: '+$(this).val());});view.$('#tp7').timepicker({'step':5});},render_modals:function(view){view.$('[rel=popover]').popover();view.$('.modal').tooltip({selector:'[rel=tooltip]'});view.$('#dp1').datepicker({format:'mm-dd-yyyy'});view.$('#dp3').datepicker();view.$('#tp1').timepicker();},render_wizard:function(view){view.$('#launch_simple_wizard').on('click.styleguide',function(e){wizard.init({id:'wizardSimpleDemo',modalUrl:'styleguide/content/wizard-modal.html',className:'setup',headerText:'Simple Wizard Demo',navMenu:new Array('Screen Two','Screen Screen Three','Screen Four')});e.stopPropagation();e.preventDefault();});view.$('#launch_wizard').on('click.styleguide',function(e){wizard.init({id:'wizardDemo',modalUrl:'styleguide/content/wizard-modal.html',className:'setup',headerText:'Custom Wizard Demo',navMenu:new Array('Screen Two','Screen Screen Three','Screen Four'),'onWizardStart':function(){view.$('#wizardDemo .start').live('click',function(){view.$('#wizardDemo .manual').css('display','none');});},defaults:{startText:'Setup Wizard','footer':function(){return'<div class="modal-footer">'+'<a href="#" class="btn btn-invisible btn-link pull-left cancel">'+this.cancelText+'</a>'+'<a class="btn back" href="#">'+this.backText+'</a>'+'<a class="btn btn-primary next" href="#">'+this.nextText+'</a>'+'<a class="btn btn-primary finish" href="#">'+this.finishText+'</a>'+'<a href="#" class="btn manual">Manual Setup</a>'+'<a class="btn btn-primary start" href="#">'+this.startText+'</a>'+'</div>';}}});e.stopPropagation();e.preventDefault();});},render_tooltips:function(view){$('body').tooltip({selector:'[rel=tooltip]'});},render_dropdowns:function(view){view.$('#mm001demo *').on('click.styleguide',function(){return false;});view.$('*').on('click.styleguide',function(){setTimeout(function(){view.$('#mm001demo').find('li.open .btn-group').addClass('open');},0.1);});},render_popovers:function(view){view.$('[rel=popover]').popover();view.$('[rel=popoverHover]').popover({trigger:'hover'});view.$('[rel=popoverTop]').popover({placement:'top'});view.$('[rel=popoverBottom]').popover({placement:'bottom'});},render_alerts:function(view){$(document).keyup(function(e){if(e.keyCode===27){view.$('.alert-top .timeten').hide();view.$('.alert-confirm').modal('hide');}});setTimeout(function(){view.$('.timeten').fadeOut().remove();},9000);view.$('.alert-confirm').on('show.styleguide',function(){var modal=$(this);modal.find('a.close').off('click').on('click',function(e){modal.modal('hide');});modal.find('a.leave').off('click').on('click',function(e){modal.modal('hide');});modal.find('a.return').off('click').on('click',function(e){modal.modal('hide');});}).modal({'backdrop':'static','show':false});view.$('a').on('click.styleguide',function(e){e.preventDefault();e.stopPropagation();view.$('.alert-confirm').modal('show');view.$('.alert-confirm a.leave').attr('href',e.target.href);});},render_drawer:function(view){view.$('#sg_open_drawer').on('click.styleguide',function(){app.drawer.open({layout:'create',context:{create:true,model:app.data.createBean('Styleguide')}});});},render_tabs:function(view){view.$('#nav-tabs-pills').find('ul.nav-tabs > li > a, ul.nav-list > li > a, ul.nav-pills > li > a').on('click.styleguide',function(e){e.preventDefault();e.stopPropagation();$(this).tab('show');});},render_inputs:function(view){view.$('.error input, .error textarea').on('focus.styleguide',function(){$(this).next().tooltip('show');});view.$('.error input, .error textarea').on('blur.styleguide',function(){$(this).next().tooltip('hide');});view.$('.add-on').tooltip({trigger:'click',container:'body'});},render_range:function(view){var fieldSettings={view:view,def:{name:'include',type:'range',view:'edit',sliderType:'connected',minRange:0,maxRange:100,'default':true,enabled:true},viewName:'edit',context:view.context,module:view.module,model:view.model,meta:app.metadata.getField('range')},rangeField=app.view.createField(fieldSettings);view.$('#test_slider').append(rangeField.el);rangeField.render();rangeField.sliderDoneDelegate=function(minField,maxField){return function(value){minField.val(value.min);maxField.val(value.max);};}(view.$('#test_slider_min'),view.$('#test_slider_max'));},render_index:function(section){var self=this,i=0,m='',l=0;if(!section){$.each(this.pageData,function(kS,vS){if(!vS.index)return;m+=(i%3===0?'<div class="row-fluid">':'');m+='<div class="span4"><h3>'+'<a class="section-link" href="'+
(vS.url?vS.url:fmtLink(kS))+'">'+
vS.title+'</a></h3><p>'+vS.description+'</p><ul>';if(vS.pages){$.each(vS.pages,function(kP,vP){m+='<li ><a class="section-link" href="'+
(vP.url?vP.url:fmtLink(kS,kP))+'">'+
vP.label+'</a></li>';});}
m+='</ul></div>';m+=(i%3===2?'</div>':'');i+=1;});}else{$.each(this.pageData[section].pages,function(kP,vP){m+=(i%4===0?'<div class="row-fluid">':'');m+='<div class="span3"><h3>'+
(!vP.items?('<a class="section-link" href="'+(vP.url?vP.url:fmtLink(section,kP))+'">'+vP.label+'</a>'):vP.label)+'</h3><p>'+vP.description;m+='</p></div>';m+=(i%4===3?'</div>':'');i+=1;});}
$('#index-content').append('<section id="section-menu"></section>').html(m);function fmtLink(section,page){return'#Styleguide/docs/'+
(page?'':'index_')+section.replace(/[\s\,]+/g,'-').toLowerCase()+(page?'_'+page:'');}
(function($){jQuery.expr[':'].Contains=function(a,i,m){return(a.textContent||a.innerText||'').toUpperCase().indexOf(m[3].toUpperCase())>=0;};function filterList($input,$list){$input.on('change.styleguide',function(){var filter=$(this).val();if(filter)
{$list.find('p').hide();var $matches=$list.find('ul').find('a:Contains('+filter+')').parent();$('li',$list).not($matches).slideUp();$matches.slideDown();}
else
{$list.find('p').show();$list.find('li').slideDown();}
return false;}).on('keyup.styleguide',function(){$(this).change();});}
$(function(){filterList($('.filterinput'),$('#index-content'));});}(jQuery));}})