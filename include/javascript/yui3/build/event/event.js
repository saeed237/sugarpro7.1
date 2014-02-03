/*
     Copyright (c) 2010, Yahoo! Inc. All rights reserved.
     Code licensed under the BSD License:
     http://developer.yahoo.com/yui/license.html
     version: 3.3.0
     build: 3167
     */
var GLOBAL_ENV=YUI.Env;if(!GLOBAL_ENV._ready){GLOBAL_ENV._ready=function(){GLOBAL_ENV.DOMReady=true;GLOBAL_ENV.remove(YUI.config.doc,'DOMContentLoaded',GLOBAL_ENV._ready);};GLOBAL_ENV.add(YUI.config.doc,'DOMContentLoaded',GLOBAL_ENV._ready);}
YUI.add('event-base',function(Y){Y.publish('domready',{fireOnce:true,async:true});if(GLOBAL_ENV.DOMReady){Y.fire('domready');}else{Y.Do.before(function(){Y.fire('domready');},YUI.Env,'_ready');}
var ua=Y.UA,EMPTY={},webkitKeymap={63232:38,63233:40,63234:37,63235:39,63276:33,63277:34,25:9,63272:46,63273:36,63275:35},resolve=function(n){if(!n){return n;}
try{if(n&&3==n.nodeType){n=n.parentNode;}}catch(e){return null;}
return Y.one(n);},DOMEventFacade=function(ev,currentTarget,wrapper){this._event=ev;this._currentTarget=currentTarget;this._wrapper=wrapper||EMPTY;this.init();};Y.extend(DOMEventFacade,Object,{init:function(){var e=this._event,overrides=this._wrapper.overrides,x=e.pageX,y=e.pageY,c,currentTarget=this._currentTarget;this.altKey=e.altKey;this.ctrlKey=e.ctrlKey;this.metaKey=e.metaKey;this.shiftKey=e.shiftKey;this.type=(overrides&&overrides.type)||e.type;this.clientX=e.clientX;this.clientY=e.clientY;this.pageX=x;this.pageY=y;c=e.keyCode||e.charCode;if(ua.webkit&&(c in webkitKeymap)){c=webkitKeymap[c];}
this.keyCode=c;this.charCode=c;this.which=e.which||e.charCode||c;this.button=this.which;this.target=resolve(e.target);this.currentTarget=resolve(currentTarget);this.relatedTarget=resolve(e.relatedTarget);if(e.type=="mousewheel"||e.type=="DOMMouseScroll"){this.wheelDelta=(e.detail)?(e.detail*-1):Math.round(e.wheelDelta / 80)||((e.wheelDelta<0)?-1:1);}
if(this._touch){this._touch(e,currentTarget,this._wrapper);}},stopPropagation:function(){this._event.stopPropagation();this._wrapper.stopped=1;this.stopped=1;},stopImmediatePropagation:function(){var e=this._event;if(e.stopImmediatePropagation){e.stopImmediatePropagation();}else{this.stopPropagation();}
this._wrapper.stopped=2;this.stopped=2;},preventDefault:function(returnValue){var e=this._event;e.preventDefault();e.returnValue=returnValue||false;this._wrapper.prevented=1;this.prevented=1;},halt:function(immediate){if(immediate){this.stopImmediatePropagation();}else{this.stopPropagation();}
this.preventDefault();}});DOMEventFacade.resolve=resolve;Y.DOM2EventFacade=DOMEventFacade;Y.DOMEventFacade=DOMEventFacade;(function(){Y.Env.evt.dom_wrappers={};Y.Env.evt.dom_map={};var _eventenv=Y.Env.evt,config=Y.config,win=config.win,add=YUI.Env.add,remove=YUI.Env.remove,onLoad=function(){YUI.Env.windowLoaded=true;Y.Event._load();remove(win,"load",onLoad);},onUnload=function(){Y.Event._unload();},EVENT_READY='domready',COMPAT_ARG='~yui|2|compat~',shouldIterate=function(o){try{return(o&&typeof o!=="string"&&Y.Lang.isNumber(o.length)&&!o.tagName&&!o.alert);}catch(ex){return false;}},Event=function(){var _loadComplete=false,_retryCount=0,_avail=[],_wrappers=_eventenv.dom_wrappers,_windowLoadKey=null,_el_events=_eventenv.dom_map;return{POLL_RETRYS:1000,POLL_INTERVAL:40,lastError:null,_interval:null,_dri:null,DOMReady:false,startInterval:function(){if(!Event._interval){Event._interval=setInterval(Event._poll,Event.POLL_INTERVAL);}},onAvailable:function(id,fn,p_obj,p_override,checkContent,compat){var a=Y.Array(id),i,availHandle;for(i=0;i<a.length;i=i+1){_avail.push({id:a[i],fn:fn,obj:p_obj,override:p_override,checkReady:checkContent,compat:compat});}
_retryCount=this.POLL_RETRYS;setTimeout(Event._poll,0);availHandle=new Y.EventHandle({_delete:function(){if(availHandle.handle){availHandle.handle.detach();return;}
var i,j;for(i=0;i<a.length;i++){for(j=0;j<_avail.length;j++){if(a[i]===_avail[j].id){_avail.splice(j,1);}}}}});return availHandle;},onContentReady:function(id,fn,obj,override,compat){return Event.onAvailable(id,fn,obj,override,true,compat);},attach:function(type,fn,el,context){return Event._attach(Y.Array(arguments,0,true));},_createWrapper:function(el,type,capture,compat,facade){var cewrapper,ek=Y.stamp(el),key='event:'+ek+type;if(false===facade){key+='native';}
if(capture){key+='capture';}
cewrapper=_wrappers[key];if(!cewrapper){cewrapper=Y.publish(key,{silent:true,bubbles:false,contextFn:function(){if(compat){return cewrapper.el;}else{cewrapper.nodeRef=cewrapper.nodeRef||Y.one(cewrapper.el);return cewrapper.nodeRef;}}});cewrapper.overrides={};cewrapper.el=el;cewrapper.key=key;cewrapper.domkey=ek;cewrapper.type=type;cewrapper.fn=function(e){cewrapper.fire(Event.getEvent(e,el,(compat||(false===facade))));};cewrapper.capture=capture;if(el==win&&type=="load"){cewrapper.fireOnce=true;_windowLoadKey=key;}
_wrappers[key]=cewrapper;_el_events[ek]=_el_events[ek]||{};_el_events[ek][key]=cewrapper;add(el,type,cewrapper.fn,capture);}
return cewrapper;},_attach:function(args,conf){var compat,handles,oEl,cewrapper,context,fireNow=false,ret,type=args[0],fn=args[1],el=args[2]||win,facade=conf&&conf.facade,capture=conf&&conf.capture,overrides=conf&&conf.overrides;if(args[args.length-1]===COMPAT_ARG){compat=true;}
if(!fn||!fn.call){return false;}
if(shouldIterate(el)){handles=[];Y.each(el,function(v,k){args[2]=v;handles.push(Event._attach(args,conf));});return new Y.EventHandle(handles);}else if(Y.Lang.isString(el)){if(compat){oEl=Y.DOM.byId(el);}else{oEl=Y.Selector.query(el);switch(oEl.length){case 0:oEl=null;break;case 1:oEl=oEl[0];break;default:args[2]=oEl;return Event._attach(args,conf);}}
if(oEl){el=oEl;}else{ret=Event.onAvailable(el,function(){ret.handle=Event._attach(args,conf);},Event,true,false,compat);return ret;}}
if(!el){return false;}
if(Y.Node&&Y.instanceOf(el,Y.Node)){el=Y.Node.getDOMNode(el);}
cewrapper=Event._createWrapper(el,type,capture,compat,facade);if(overrides){Y.mix(cewrapper.overrides,overrides);}
if(el==win&&type=="load"){if(YUI.Env.windowLoaded){fireNow=true;}}
if(compat){args.pop();}
context=args[3];ret=cewrapper._on(fn,context,(args.length>4)?args.slice(4):null);if(fireNow){cewrapper.fire();}
return ret;},detach:function(type,fn,el,obj){var args=Y.Array(arguments,0,true),compat,l,ok,i,id,ce;if(args[args.length-1]===COMPAT_ARG){compat=true;}
if(type&&type.detach){return type.detach();}
if(typeof el=="string"){if(compat){el=Y.DOM.byId(el);}else{el=Y.Selector.query(el);l=el.length;if(l<1){el=null;}else if(l==1){el=el[0];}}}
if(!el){return false;}
if(el.detach){args.splice(2,1);return el.detach.apply(el,args);}else if(shouldIterate(el)){ok=true;for(i=0,l=el.length;i<l;++i){args[2]=el[i];ok=(Y.Event.detach.apply(Y.Event,args)&&ok);}
return ok;}
if(!type||!fn||!fn.call){return Event.purgeElement(el,false,type);}
id='event:'+Y.stamp(el)+type;ce=_wrappers[id];if(ce){return ce.detach(fn);}else{return false;}},getEvent:function(e,el,noFacade){var ev=e||win.event;return(noFacade)?ev:new Y.DOMEventFacade(ev,el,_wrappers['event:'+Y.stamp(el)+e.type]);},generateId:function(el){return Y.DOM.generateID(el);},_isValidCollection:shouldIterate,_load:function(e){if(!_loadComplete){_loadComplete=true;if(Y.fire){Y.fire(EVENT_READY);}
Event._poll();}},_poll:function(){if(Event.locked){return;}
if(Y.UA.ie&&!YUI.Env.DOMReady){Event.startInterval();return;}
Event.locked=true;var i,len,item,el,notAvail,executeItem,tryAgain=!_loadComplete;if(!tryAgain){tryAgain=(_retryCount>0);}
notAvail=[];executeItem=function(el,item){var context,ov=item.override;if(item.compat){if(item.override){if(ov===true){context=item.obj;}else{context=ov;}}else{context=el;}
item.fn.call(context,item.obj);}else{context=item.obj||Y.one(el);item.fn.apply(context,(Y.Lang.isArray(ov))?ov:[]);}};for(i=0,len=_avail.length;i<len;++i){item=_avail[i];if(item&&!item.checkReady){el=(item.compat)?Y.DOM.byId(item.id):Y.Selector.query(item.id,null,true);if(el){executeItem(el,item);_avail[i]=null;}else{notAvail.push(item);}}}
for(i=0,len=_avail.length;i<len;++i){item=_avail[i];if(item&&item.checkReady){el=(item.compat)?Y.DOM.byId(item.id):Y.Selector.query(item.id,null,true);if(el){if(_loadComplete||(el.get&&el.get('nextSibling'))||el.nextSibling){executeItem(el,item);_avail[i]=null;}}else{notAvail.push(item);}}}
_retryCount=(notAvail.length===0)?0:_retryCount-1;if(tryAgain){Event.startInterval();}else{clearInterval(Event._interval);Event._interval=null;}
Event.locked=false;return;},purgeElement:function(el,recurse,type){var oEl=(Y.Lang.isString(el))?Y.Selector.query(el,null,true):el,lis=Event.getListeners(oEl,type),i,len,props,children,child;if(recurse&&oEl){lis=lis||[];children=Y.Selector.query('*',oEl);i=0;len=children.length;for(;i<len;++i){child=Event.getListeners(children[i],type);if(child){lis=lis.concat(child);}}}
if(lis){i=0;len=lis.length;for(;i<len;++i){props=lis[i];props.detachAll();remove(props.el,props.type,props.fn,props.capture);delete _wrappers[props.key];delete _el_events[props.domkey][props.key];}}},getListeners:function(el,type){var ek=Y.stamp(el,true),evts=_el_events[ek],results=[],key=(type)?'event:'+ek+type:null,adapters=_eventenv.plugins;if(!evts){return null;}
if(key){if(adapters[type]&&adapters[type].eventDef){key+='_synth';}
if(evts[key]){results.push(evts[key]);}
key+='native';if(evts[key]){results.push(evts[key]);}}else{Y.each(evts,function(v,k){results.push(v);});}
return(results.length)?results:null;},_unload:function(e){Y.each(_wrappers,function(v,k){v.detachAll();remove(v.el,v.type,v.fn,v.capture);delete _wrappers[k];delete _el_events[v.domkey][k];});remove(win,"unload",onUnload);},nativeAdd:add,nativeRemove:remove};}();Y.Event=Event;if(config.injected||YUI.Env.windowLoaded){onLoad();}else{add(win,"load",onLoad);}
if(Y.UA.ie){Y.on(EVENT_READY,Event._poll);}
add(win,"unload",onUnload);Event.Custom=Y.CustomEvent;Event.Subscriber=Y.Subscriber;Event.Target=Y.EventTarget;Event.Handle=Y.EventHandle;Event.Facade=Y.EventFacade;Event._poll();})();Y.Env.evt.plugins.available={on:function(type,fn,id,o){var a=arguments.length>4?Y.Array(arguments,4,true):null;return Y.Event.onAvailable.call(Y.Event,id,fn,o,a);}};Y.Env.evt.plugins.contentready={on:function(type,fn,id,o){var a=arguments.length>4?Y.Array(arguments,4,true):null;return Y.Event.onContentReady.call(Y.Event,id,fn,o,a);}};},'3.3.0',{requires:['event-custom-base']});YUI.add('event-delegate',function(Y){var toArray=Y.Array,YLang=Y.Lang,isString=YLang.isString,isObject=YLang.isObject,isArray=YLang.isArray,selectorTest=Y.Selector.test,detachCategories=Y.Env.evt.handles;function delegate(type,fn,el,filter){var args=toArray(arguments,0,true),query=isString(el)?el:null,typeBits,synth,container,categories,cat,i,len,handles,handle;if(isObject(type)){handles=[];if(isArray(type)){for(i=0,len=type.length;i<len;++i){args[0]=type[i];handles.push(Y.delegate.apply(Y,args));}}else{args.unshift(null);for(i in type){if(type.hasOwnProperty(i)){args[0]=i;args[1]=type[i];handles.push(Y.delegate.apply(Y,args));}}}
return new Y.EventHandle(handles);}
typeBits=type.split(/\|/);if(typeBits.length>1){cat=typeBits.shift();type=typeBits.shift();}
synth=Y.Node.DOM_EVENTS[type];if(isObject(synth)&&synth.delegate){handle=synth.delegate.apply(synth,arguments);}
if(!handle){if(!type||!fn||!el||!filter){return;}
container=(query)?Y.Selector.query(query,null,true):el;if(!container&&isString(el)){handle=Y.on('available',function(){Y.mix(handle,Y.delegate.apply(Y,args),true);},el);}
if(!handle&&container){args.splice(2,2,container);handle=Y.Event._attach(args,{facade:false});handle.sub.filter=filter;handle.sub._notify=delegate.notifySub;}}
if(handle&&cat){categories=detachCategories[cat]||(detachCategories[cat]={});categories=categories[type]||(categories[type]=[]);categories.push(handle);}
return handle;}
delegate.notifySub=function(thisObj,args,ce){args=args.slice();if(this.args){args.push.apply(args,this.args);}
var currentTarget=delegate._applyFilter(this.filter,args,ce),e,i,len,ret;if(currentTarget){currentTarget=toArray(currentTarget);e=args[0]=new Y.DOMEventFacade(args[0],ce.el,ce);e.container=Y.one(ce.el);for(i=0,len=currentTarget.length;i<len&&!e.stopped;++i){e.currentTarget=Y.one(currentTarget[i]);ret=this.fn.apply(this.context||e.currentTarget,args);if(ret===false){break;}}
return ret;}};delegate.compileFilter=Y.cached(function(selector){return function(target,e){return selectorTest(target._node,selector,e.currentTarget._node);};});delegate._applyFilter=function(filter,args,ce){var e=args[0],container=ce.el,target=e.target||e.srcElement,match=[],isContainer=false;if(target.nodeType===3){target=target.parentNode;}
args.unshift(target);if(isString(filter)){while(target){isContainer=(target===container);if(selectorTest(target,filter,(isContainer?null:container))){match.push(target);}
if(isContainer){break;}
target=target.parentNode;}}else{args[0]=Y.one(target);args[1]=new Y.DOMEventFacade(e,container,ce);while(target){if(filter.apply(args[0],args)){match.push(target);}
if(target===container){break;}
target=target.parentNode;args[0]=Y.one(target);}
args[1]=e;}
if(match.length<=1){match=match[0];}
args.shift();return match;};Y.delegate=Y.Event.delegate=delegate;},'3.3.0',{requires:['node-base']});YUI.add('event-synthetic',function(Y){var DOMMap=Y.Env.evt.dom_map,toArray=Y.Array,YLang=Y.Lang,isObject=YLang.isObject,isString=YLang.isString,query=Y.Selector.query,noop=function(){};function Notifier(handle,emitFacade){this.handle=handle;this.emitFacade=emitFacade;}
Notifier.prototype.fire=function(e){var args=toArray(arguments,0,true),handle=this.handle,ce=handle.evt,sub=handle.sub,thisObj=sub.context,delegate=sub.filter,event=e||{};if(this.emitFacade){if(!e||!e.preventDefault){event=ce._getFacade();if(isObject(e)&&!e.preventDefault){Y.mix(event,e,true);args[0]=event;}else{args.unshift(event);}}
event.type=ce.type;event.details=args.slice();if(delegate){event.container=ce.host;}}else if(delegate&&isObject(e)&&e.currentTarget){args.shift();}
sub.context=thisObj||event.currentTarget||ce.host;ce.fire.apply(ce,args);sub.context=thisObj;};function SyntheticEvent(){this._init.apply(this,arguments);}
Y.mix(SyntheticEvent,{Notifier:Notifier,getRegistry:function(node,type,create){var el=node._node,yuid=Y.stamp(el),key='event:'+yuid+type+'_synth',events=DOMMap[yuid]||(DOMMap[yuid]={});if(!events[key]&&create){events[key]={type:'_synth',fn:noop,capture:false,el:el,key:key,domkey:yuid,notifiers:[],detachAll:function(){var notifiers=this.notifiers,i=notifiers.length;while(--i>=0){notifiers[i].detach();}}};}
return(events[key])?events[key].notifiers:null;},_deleteSub:function(sub){if(sub&&sub.fn){var synth=this.eventDef,method=(sub.filter)?'detachDelegate':'detach';this.subscribers={};this.subCount=0;synth[method](sub.node,sub,this.notifier,sub.filter);synth._unregisterSub(sub);delete sub.fn;delete sub.node;delete sub.context;}},prototype:{constructor:SyntheticEvent,_init:function(){var config=this.publishConfig||(this.publishConfig={});this.emitFacade=('emitFacade'in config)?config.emitFacade:true;config.emitFacade=false;},processArgs:noop,on:noop,detach:noop,delegate:noop,detachDelegate:noop,_on:function(args,delegate){var handles=[],extra=this.processArgs(args,delegate),selector=args[2],method=delegate?'delegate':'on',nodes,handle;nodes=(isString(selector))?query(selector):toArray(selector);if(!nodes.length&&isString(selector)){handle=Y.on('available',function(){Y.mix(handle,Y[method].apply(Y,args),true);},selector);return handle;}
Y.Array.each(nodes,function(node){var subArgs=args.slice(),filter;node=Y.one(node);if(node){if(delegate){filter=subArgs.splice(3,1)[0];}
subArgs.splice(0,4,subArgs[1],subArgs[3]);if(!this.preventDups||!this.getSubs(node,args,null,true)){handle=this._getNotifier(node,subArgs,extra,filter);this[method](node,handle.sub,handle.notifier,filter);handles.push(handle);}}},this);return(handles.length===1)?handles[0]:new Y.EventHandle(handles);},_getNotifier:function(node,args,extra,filter){var dispatcher=new Y.CustomEvent(this.type,this.publishConfig),handle=dispatcher.on.apply(dispatcher,args),notifier=new Notifier(handle,this.emitFacade),registry=SyntheticEvent.getRegistry(node,this.type,true),sub=handle.sub;handle.notifier=notifier;sub.node=node;sub.filter=filter;if(extra){this.applyArgExtras(extra,sub);}
Y.mix(dispatcher,{eventDef:this,notifier:notifier,host:node,currentTarget:node,target:node,el:node._node,_delete:SyntheticEvent._deleteSub},true);registry.push(handle);return handle;},applyArgExtras:function(extra,sub){sub._extra=extra;},_unregisterSub:function(sub){var notifiers=SyntheticEvent.getRegistry(sub.node,this.type),i;if(notifiers){for(i=notifiers.length-1;i>=0;--i){if(notifiers[i].sub===sub){notifiers.splice(i,1);break;}}}},_detach:function(args){var target=args[2],els=(isString(target))?query(target):toArray(target),node,i,len,handles,j;args.splice(2,1);for(i=0,len=els.length;i<len;++i){node=Y.one(els[i]);if(node){handles=this.getSubs(node,args);if(handles){for(j=handles.length-1;j>=0;--j){handles[j].detach();}}}}},getSubs:function(node,args,filter,first){var notifiers=SyntheticEvent.getRegistry(node,this.type),handles=[],i,len,handle;if(notifiers){if(!filter){filter=this.subMatch;}
for(i=0,len=notifiers.length;i<len;++i){handle=notifiers[i];if(filter.call(this,handle.sub,args)){if(first){return handle;}else{handles.push(notifiers[i]);}}}}
return handles.length&&handles;},subMatch:function(sub,args){return!args[1]||sub.fn===args[1];}}},true);Y.SyntheticEvent=SyntheticEvent;Y.Event.define=function(type,config,force){if(!config){config={};}
var eventDef=(isObject(type))?type:Y.merge({type:type},config),Impl,synth;if(force||!Y.Node.DOM_EVENTS[eventDef.type]){Impl=function(){SyntheticEvent.apply(this,arguments);};Y.extend(Impl,SyntheticEvent,eventDef);synth=new Impl();type=synth.type;Y.Node.DOM_EVENTS[type]=Y.Env.evt.plugins[type]={eventDef:synth,on:function(){return synth._on(toArray(arguments));},delegate:function(){return synth._on(toArray(arguments),true);},detach:function(){return synth._detach(toArray(arguments));}};}
return synth;};},'3.3.0',{requires:['node-base','event-custom']});YUI.add('event-mousewheel',function(Y){var DOM_MOUSE_SCROLL='DOMMouseScroll',fixArgs=function(args){var a=Y.Array(args,0,true),target;if(Y.UA.gecko){a[0]=DOM_MOUSE_SCROLL;target=Y.config.win;}else{target=Y.config.doc;}
if(a.length<3){a[2]=target;}else{a.splice(2,0,target);}
return a;};Y.Env.evt.plugins.mousewheel={on:function(){return Y.Event._attach(fixArgs(arguments));},detach:function(){return Y.Event.detach.apply(Y.Event,fixArgs(arguments));}};},'3.3.0',{requires:['node-base']});YUI.add('event-mouseenter',function(Y){function notify(e,notifier){var current=e.currentTarget,related=e.relatedTarget;if(current!==related&&!current.contains(related)){notifier.fire(e);}}
var config={proxyType:"mouseover",on:function(node,sub,notifier){sub.onHandle=node.on(this.proxyType,notify,null,notifier);},detach:function(node,sub){sub.onHandle.detach();},delegate:function(node,sub,notifier,filter){sub.delegateHandle=Y.delegate(this.proxyType,notify,node,filter,null,notifier);},detachDelegate:function(node,sub){sub.delegateHandle.detach();}};Y.Event.define("mouseenter",config,true);Y.Event.define("mouseleave",Y.merge(config,{proxyType:"mouseout"}),true);},'3.3.0',{requires:['event-synthetic']});YUI.add('event-key',function(Y){Y.Env.evt.plugins.key={on:function(type,fn,id,spec,o){var a=Y.Array(arguments,0,true),parsed,etype,criteria,ename;parsed=spec&&spec.split(':');if(!spec||spec.indexOf(':')==-1||!parsed[1]){a[0]='key'+((parsed&&parsed[0])||'press');return Y.on.apply(Y,a);}
etype=parsed[0];criteria=(parsed[1])?parsed[1].split(/,|\+/):null;ename=(Y.Lang.isString(id)?id:Y.stamp(id))+spec;ename=ename.replace(/,/g,'_');if(!Y.getEvent(ename)){Y.on(type+etype,function(e){var passed=false,failed=false,i,crit,critInt;for(i=0;i<criteria.length;i=i+1){crit=criteria[i];critInt=parseInt(crit,10);if(Y.Lang.isNumber(critInt)){if(e.charCode===critInt){passed=true;}else{failed=true;}}else if(passed||!failed){passed=(e[crit+'Key']);failed=!passed;}}
if(passed){Y.fire(ename,e);}},id);}
a.splice(2,2);a[0]=ename;return Y.on.apply(Y,a);}};},'3.3.0',{requires:['node-base']});YUI.add('event-focus',function(Y){var Event=Y.Event,YLang=Y.Lang,isString=YLang.isString,useActivate=YLang.isFunction(Y.DOM.create('<p onbeforeactivate=";"/>').onbeforeactivate);function define(type,proxy,directEvent){var nodeDataKey='_'+type+'Notifiers';Y.Event.define(type,{_attach:function(el,notifier,delegate){if(Y.DOM.isWindow(el)){return Event._attach([type,function(e){notifier.fire(e);},el]);}else{return Event._attach([proxy,this._proxy,el,this,notifier,delegate],{capture:true});}},_proxy:function(e,notifier,delegate){var node=e.target,notifiers=node.getData(nodeDataKey),yuid=Y.stamp(e.currentTarget._node),defer=(useActivate||e.target!==e.currentTarget),sub=notifier.handle.sub,filterArgs=[node,e].concat(sub.args||[]),directSub;notifier.currentTarget=(delegate)?node:e.currentTarget;notifier.container=(delegate)?e.currentTarget:null;if(!sub.filter||sub.filter.apply(node,filterArgs)){if(!notifiers){notifiers={};node.setData(nodeDataKey,notifiers);if(defer){directSub=Event._attach([directEvent,this._notify,node._node]).sub;directSub.once=true;}}
if(!notifiers[yuid]){notifiers[yuid]=[];}
notifiers[yuid].push(notifier);if(!defer){this._notify(e);}}},_notify:function(e,container){var node=e.currentTarget,notifiers=node.getData(nodeDataKey),doc=node.get('ownerDocument')||node,target=node,nots=[],notifier,i,len;if(notifiers){while(target&&target!==doc){nots.push.apply(nots,notifiers[Y.stamp(target)]||[]);target=target.get('parentNode');}
nots.push.apply(nots,notifiers[Y.stamp(doc)]||[]);for(i=0,len=nots.length;i<len;++i){notifier=nots[i];e.currentTarget=nots[i].currentTarget;if(notifier.container){e.container=notifier.container;}else{delete e.container;}
notifier.fire(e);}
node.clearData(nodeDataKey);}},on:function(node,sub,notifier){sub.onHandle=this._attach(node._node,notifier);},detach:function(node,sub){sub.onHandle.detach();},delegate:function(node,sub,notifier,filter){if(isString(filter)){sub.filter=Y.delegate.compileFilter(filter);}
sub.delegateHandle=this._attach(node._node,notifier,true);},detachDelegate:function(node,sub){sub.delegateHandle.detach();}},true);}
if(useActivate){define("focus","beforeactivate","focusin");define("blur","beforedeactivate","focusout");}else{define("focus","focus","focus");define("blur","blur","blur");}},'3.3.0',{requires:['event-synthetic']});YUI.add('event-resize',function(Y){(function(){var detachHandle,timerHandle,CE_NAME='window:resize',handler=function(e){if(Y.UA.gecko){Y.fire(CE_NAME,e);}else{if(timerHandle){timerHandle.cancel();}
timerHandle=Y.later(Y.config.windowResizeDelay||40,Y,function(){Y.fire(CE_NAME,e);});}};Y.Env.evt.plugins.windowresize={on:function(type,fn){if(!detachHandle){detachHandle=Y.Event._attach(['resize',handler]);}
var a=Y.Array(arguments,0,true);a[0]=CE_NAME;return Y.on.apply(Y,a);}};})();},'3.3.0',{requires:['node-base']});YUI.add('event-hover',function(Y){var isFunction=Y.Lang.isFunction,noop=function(){},conf={processArgs:function(args){var i=isFunction(args[2])?2:3;return(isFunction(args[i]))?args.splice(i,1)[0]:noop;},on:function(node,sub,notifier,filter){sub._detach=node[(filter)?"delegate":"on"]({mouseenter:Y.bind(notifier.fire,notifier),mouseleave:sub._extra},filter);},detach:function(node,sub,notifier){sub._detacher.detach();}};conf.delegate=conf.on;conf.detachDelegate=conf.detach;Y.Event.define("hover",conf);},'3.3.0',{requires:['event-mouseenter']});YUI.add('event',function(Y){},'3.3.0',{use:['event-base','event-delegate','event-synthetic','event-mousewheel','event-mouseenter','event-key','event-focus','event-resize','event-hover']});