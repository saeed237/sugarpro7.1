/*
     Copyright (c) 2010, Yahoo! Inc. All rights reserved.
     Code licensed under the BSD License:
     http://developer.yahoo.com/yui/license.html
     version: 3.3.0
     build: 3167
     */
YUI.add('dom-base',function(Y){(function(Y){var NODE_TYPE='nodeType',OWNER_DOCUMENT='ownerDocument',DOCUMENT_ELEMENT='documentElement',DEFAULT_VIEW='defaultView',PARENT_WINDOW='parentWindow',TAG_NAME='tagName',PARENT_NODE='parentNode',FIRST_CHILD='firstChild',PREVIOUS_SIBLING='previousSibling',NEXT_SIBLING='nextSibling',CONTAINS='contains',COMPARE_DOCUMENT_POSITION='compareDocumentPosition',EMPTY_STRING='',EMPTY_ARRAY=[],documentElement=Y.config.doc.documentElement,re_tag=/<([a-z]+)/i,createFromDIV=function(html,tag){var div=Y.config.doc.createElement('div'),ret=true;div.innerHTML=html;if(!div.firstChild||div.firstChild.tagName!==tag.toUpperCase()){ret=false;}
return ret;},addFeature=Y.Features.add,testFeature=Y.Features.test,Y_DOM={byId:function(id,doc){return Y_DOM.allById(id,doc)[0]||null;},getText:(documentElement.textContent!==undefined)?function(element){var ret='';if(element){ret=element.textContent;}
return ret||'';}:function(element){var ret='';if(element){ret=element.innerText||element.nodeValue;}
return ret||'';},setText:(documentElement.textContent!==undefined)?function(element,content){if(element){element.textContent=content;}}:function(element,content){if('innerText'in element){element.innerText=content;}else if('nodeValue'in element){element.nodeValue=content;}},ancestor:function(element,fn,testSelf){var ret=null;if(testSelf){ret=(!fn||fn(element))?element:null;}
return ret||Y_DOM.elementByAxis(element,PARENT_NODE,fn,null);},ancestors:function(element,fn,testSelf){var ancestor=Y_DOM.ancestor.apply(Y_DOM,arguments),ret=(ancestor)?[ancestor]:[];while((ancestor=Y_DOM.ancestor(ancestor,fn))){if(ancestor){ret.unshift(ancestor);}}
return ret;},elementByAxis:function(element,axis,fn,all){while(element&&(element=element[axis])){if((all||element[TAG_NAME])&&(!fn||fn(element))){return element;}}
return null;},contains:function(element,needle){var ret=false;if(!needle||!element||!needle[NODE_TYPE]||!element[NODE_TYPE]){ret=false;}else if(element[CONTAINS]){if(Y.UA.opera||needle[NODE_TYPE]===1){ret=element[CONTAINS](needle);}else{ret=Y_DOM._bruteContains(element,needle);}}else if(element[COMPARE_DOCUMENT_POSITION]){if(element===needle||!!(element[COMPARE_DOCUMENT_POSITION](needle)&16)){ret=true;}}
return ret;},inDoc:function(element,doc){var ret=false,rootNode;if(element&&element.nodeType){(doc)||(doc=element[OWNER_DOCUMENT]);rootNode=doc[DOCUMENT_ELEMENT];if(rootNode&&rootNode.contains&&element.tagName){ret=rootNode.contains(element);}else{ret=Y_DOM.contains(rootNode,element);}}
return ret;},allById:function(id,root){root=root||Y.config.doc;var nodes=[],ret=[],i,node;if(root.querySelectorAll){ret=root.querySelectorAll('[id="'+id+'"]');}else if(root.all){nodes=root.all(id);if(nodes){if(nodes.nodeName){if(nodes.id===id){ret.push(nodes);nodes=EMPTY_ARRAY;}else{nodes=[nodes];}}
if(nodes.length){for(i=0;node=nodes[i++];){if(node.id===id||(node.attributes&&node.attributes.id&&node.attributes.id.value===id)){ret.push(node);}}}}}else{ret=[Y_DOM._getDoc(root).getElementById(id)];}
return ret;},create:function(html,doc){if(typeof html==='string'){html=Y.Lang.trim(html);}
doc=doc||Y.config.doc;var m=re_tag.exec(html),create=Y_DOM._create,custom=Y_DOM.creators,ret=null,creator,tag,nodes;if(html!=undefined){if(m&&m[1]){creator=custom[m[1].toLowerCase()];if(typeof creator==='function'){create=creator;}else{tag=creator;}}
nodes=create(html,doc,tag).childNodes;if(nodes.length===1){ret=nodes[0].parentNode.removeChild(nodes[0]);}else if(nodes[0]&&nodes[0].className==='yui3-big-dummy'){if(nodes.length===2){ret=nodes[0].nextSibling;}else{nodes[0].parentNode.removeChild(nodes[0]);ret=Y_DOM._nl2frag(nodes,doc);}}else{ret=Y_DOM._nl2frag(nodes,doc);}}
return ret;},_nl2frag:function(nodes,doc){var ret=null,i,len;if(nodes&&(nodes.push||nodes.item)&&nodes[0]){doc=doc||nodes[0].ownerDocument;ret=doc.createDocumentFragment();if(nodes.item){nodes=Y.Array(nodes,0,true);}
for(i=0,len=nodes.length;i<len;i++){ret.appendChild(nodes[i]);}}
return ret;},CUSTOM_ATTRIBUTES:(!documentElement.hasAttribute)?{'for':'htmlFor','class':'className'}:{'htmlFor':'for','className':'class'},setAttribute:function(el,attr,val,ieAttr){if(el&&attr&&el.setAttribute){attr=Y_DOM.CUSTOM_ATTRIBUTES[attr]||attr;el.setAttribute(attr,val,ieAttr);}},getAttribute:function(el,attr,ieAttr){ieAttr=(ieAttr!==undefined)?ieAttr:2;var ret='';if(el&&attr&&el.getAttribute){attr=Y_DOM.CUSTOM_ATTRIBUTES[attr]||attr;ret=el.getAttribute(attr,ieAttr);if(ret===null){ret='';}}
return ret;},isWindow:function(obj){return!!(obj&&obj.alert&&obj.document);},_fragClones:{},_create:function(html,doc,tag){tag=tag||'div';var frag=Y_DOM._fragClones[tag];if(frag){frag=frag.cloneNode(false);}else{frag=Y_DOM._fragClones[tag]=doc.createElement(tag);}
frag.innerHTML=html;return frag;},_removeChildNodes:function(node){while(node.firstChild){node.removeChild(node.firstChild);}},addHTML:function(node,content,where){var nodeParent=node.parentNode,i=0,item,ret=content,newNode;if(content!=undefined){if(content.nodeType){newNode=content;}else if(typeof content=='string'||typeof content=='number'){ret=newNode=Y_DOM.create(content);}else if(content[0]&&content[0].nodeType){newNode=Y.config.doc.createDocumentFragment();while((item=content[i++])){newNode.appendChild(item);}}}
if(where){if(where.nodeType){where.parentNode.insertBefore(newNode,where);}else{switch(where){case'replace':while(node.firstChild){node.removeChild(node.firstChild);}
if(newNode){node.appendChild(newNode);}
break;case'before':nodeParent.insertBefore(newNode,node);break;case'after':if(node.nextSibling){nodeParent.insertBefore(newNode,node.nextSibling);}else{nodeParent.appendChild(newNode);}
break;default:node.appendChild(newNode);}}}else if(newNode){node.appendChild(newNode);}
return ret;},VALUE_SETTERS:{},VALUE_GETTERS:{},getValue:function(node){var ret='',getter;if(node&&node[TAG_NAME]){getter=Y_DOM.VALUE_GETTERS[node[TAG_NAME].toLowerCase()];if(getter){ret=getter(node);}else{ret=node.value;}}
if(ret===EMPTY_STRING){ret=EMPTY_STRING;}
return(typeof ret==='string')?ret:'';},setValue:function(node,val){var setter;if(node&&node[TAG_NAME]){setter=Y_DOM.VALUE_SETTERS[node[TAG_NAME].toLowerCase()];if(setter){setter(node,val);}else{node.value=val;}}},siblings:function(node,fn){var nodes=[],sibling=node;while((sibling=sibling[PREVIOUS_SIBLING])){if(sibling[TAG_NAME]&&(!fn||fn(sibling))){nodes.unshift(sibling);}}
sibling=node;while((sibling=sibling[NEXT_SIBLING])){if(sibling[TAG_NAME]&&(!fn||fn(sibling))){nodes.push(sibling);}}
return nodes;},_bruteContains:function(element,needle){while(needle){if(element===needle){return true;}
needle=needle.parentNode;}
return false;},_getRegExp:function(str,flags){flags=flags||'';Y_DOM._regexCache=Y_DOM._regexCache||{};if(!Y_DOM._regexCache[str+flags]){Y_DOM._regexCache[str+flags]=new RegExp(str,flags);}
return Y_DOM._regexCache[str+flags];},_getDoc:function(element){var doc=Y.config.doc;if(element){doc=(element[NODE_TYPE]===9)?element:element[OWNER_DOCUMENT]||element.document||Y.config.doc;}
return doc;},_getWin:function(element){var doc=Y_DOM._getDoc(element);return doc[DEFAULT_VIEW]||doc[PARENT_WINDOW]||Y.config.win;},_batch:function(nodes,fn,arg1,arg2,arg3,etc){fn=(typeof fn==='string')?Y_DOM[fn]:fn;var result,args=Array.prototype.slice.call(arguments,2),i=0,node,ret;if(fn&&nodes){while((node=nodes[i++])){result=result=fn.call(Y_DOM,node,arg1,arg2,arg3,etc);if(typeof result!=='undefined'){(ret)||(ret=[]);ret.push(result);}}}
return(typeof ret!=='undefined')?ret:nodes;},wrap:function(node,html){var parent=Y.DOM.create(html),nodes=parent.getElementsByTagName('*');if(nodes.length){parent=nodes[nodes.length-1];}
if(node.parentNode){node.parentNode.replaceChild(parent,node);}
parent.appendChild(node);},unwrap:function(node){var parent=node.parentNode,lastChild=parent.lastChild,node=parent.firstChild,next=node,grandparent;if(parent){grandparent=parent.parentNode;if(grandparent){while(node!==lastChild){next=node.nextSibling;grandparent.insertBefore(node,parent);node=next;}
grandparent.replaceChild(lastChild,parent);}else{parent.removeChild(node);}}},generateID:function(el){var id=el.id;if(!id){id=Y.stamp(el);el.id=id;}
return id;},creators:{}};addFeature('innerhtml','table',{test:function(){var node=Y.config.doc.createElement('table');try{node.innerHTML='<tbody></tbody>';}catch(e){return false;}
return(node.firstChild&&node.firstChild.nodeName==='TBODY');}});addFeature('innerhtml-div','tr',{test:function(){return createFromDIV('<tr></tr>','tr');}});addFeature('innerhtml-div','script',{test:function(){return createFromDIV('<script></script>','script');}});addFeature('value-set','select',{test:function(){var node=Y.config.doc.createElement('select');node.innerHTML='<option>1</option><option>2</option>';node.value='2';return(node.value&&node.value==='2');}});(function(Y){var creators=Y_DOM.creators,create=Y_DOM.create,re_tbody=/(?:\/(?:thead|tfoot|tbody|caption|col|colgroup)>)+\s*<tbody/,TABLE_OPEN='<table>',TABLE_CLOSE='</table>';if(!testFeature('innerhtml','table')){creators.tbody=function(html,doc){var frag=create(TABLE_OPEN+html+TABLE_CLOSE,doc),tb=frag.children.tags('tbody')[0];if(frag.children.length>1&&tb&&!re_tbody.test(html)){tb[PARENT_NODE].removeChild(tb);}
return frag;};}
if(!testFeature('innerhtml-div','script')){creators.script=function(html,doc){var frag=doc.createElement('div');frag.innerHTML='-'+html;frag.removeChild(frag[FIRST_CHILD]);return frag;}
Y_DOM.creators.link=Y_DOM.creators.style=Y_DOM.creators.script;}
if(!testFeature('value-set','select')){Y_DOM.VALUE_SETTERS.select=function(node,val){for(var i=0,options=node.getElementsByTagName('option'),option;option=options[i++];){if(Y_DOM.getValue(option)===val){option.selected=true;break;}}}}
Y.mix(Y_DOM.VALUE_GETTERS,{button:function(node){return(node.attributes&&node.attributes.value)?node.attributes.value.value:'';}});Y.mix(Y_DOM.VALUE_SETTERS,{button:function(node,val){var attr=node.attributes.value;if(!attr){attr=node[OWNER_DOCUMENT].createAttribute('value');node.setAttributeNode(attr);}
attr.value=val;}});if(!testFeature('innerhtml-div','tr')){Y.mix(creators,{option:function(html,doc){return create('<select><option class="yui3-big-dummy" selected></option>'+html+'</select>',doc);},tr:function(html,doc){return create('<tbody>'+html+'</tbody>',doc);},td:function(html,doc){return create('<tr>'+html+'</tr>',doc);},col:function(html,doc){return create('<colgroup>'+html+'</colgroup>',doc);},tbody:'table'});Y.mix(creators,{legend:'fieldset',th:creators.td,thead:creators.tbody,tfoot:creators.tbody,caption:creators.tbody,colgroup:creators.tbody,optgroup:creators.option});}
Y.mix(Y_DOM.VALUE_GETTERS,{option:function(node){var attrs=node.attributes;return(attrs.value&&attrs.value.specified)?node.value:node.text;},select:function(node){var val=node.value,options=node.options;if(options&&options.length){if(node.multiple){}else{val=Y_DOM.getValue(options[node.selectedIndex]);}}
return val;}});})(Y);Y.DOM=Y_DOM;})(Y);var addClass,hasClass,removeClass;Y.mix(Y.DOM,{hasClass:function(node,className){var re=Y.DOM._getRegExp('(?:^|\\s+)'+className+'(?:\\s+|$)');return re.test(node.className);},addClass:function(node,className){if(!Y.DOM.hasClass(node,className)){node.className=Y.Lang.trim([node.className,className].join(' '));}},removeClass:function(node,className){if(className&&hasClass(node,className)){node.className=Y.Lang.trim(node.className.replace(Y.DOM._getRegExp('(?:^|\\s+)'+
className+'(?:\\s+|$)'),' '));if(hasClass(node,className)){removeClass(node,className);}}},replaceClass:function(node,oldC,newC){removeClass(node,oldC);addClass(node,newC);},toggleClass:function(node,className,force){var add=(force!==undefined)?force:!(hasClass(node,className));if(add){addClass(node,className);}else{removeClass(node,className);}}});hasClass=Y.DOM.hasClass;removeClass=Y.DOM.removeClass;addClass=Y.DOM.addClass;Y.mix(Y.DOM,{setWidth:function(node,size){Y.DOM._setSize(node,'width',size);},setHeight:function(node,size){Y.DOM._setSize(node,'height',size);},_setSize:function(node,prop,val){val=(val>0)?val:0;var size=0;node.style[prop]=val+'px';size=(prop==='height')?node.offsetHeight:node.offsetWidth;if(size>val){val=val-(size-val);if(val<0){val=0;}
node.style[prop]=val+'px';}}});},'3.3.0',{requires:['oop']});YUI.add('dom-style',function(Y){(function(Y){var DOCUMENT_ELEMENT='documentElement',DEFAULT_VIEW='defaultView',OWNER_DOCUMENT='ownerDocument',STYLE='style',FLOAT='float',CSS_FLOAT='cssFloat',STYLE_FLOAT='styleFloat',TRANSPARENT='transparent',GET_COMPUTED_STYLE='getComputedStyle',GET_BOUNDING_CLIENT_RECT='getBoundingClientRect',WINDOW=Y.config.win,DOCUMENT=Y.config.doc,UNDEFINED=undefined,Y_DOM=Y.DOM,TRANSFORM='transform',VENDOR_TRANSFORM=['WebkitTransform','MozTransform','OTransform'],re_color=/color$/i,re_unit=/width|height|top|left|right|bottom|margin|padding/i;Y.Array.each(VENDOR_TRANSFORM,function(val){if(val in DOCUMENT[DOCUMENT_ELEMENT].style){TRANSFORM=val;}});Y.mix(Y_DOM,{DEFAULT_UNIT:'px',CUSTOM_STYLES:{},setStyle:function(node,att,val,style){style=style||node.style;var CUSTOM_STYLES=Y_DOM.CUSTOM_STYLES;if(style){if(val===null||val===''){val='';}else if(!isNaN(new Number(val))&&re_unit.test(att)){val+=Y_DOM.DEFAULT_UNIT;}
if(att in CUSTOM_STYLES){if(CUSTOM_STYLES[att].set){CUSTOM_STYLES[att].set(node,val,style);return;}else if(typeof CUSTOM_STYLES[att]==='string'){att=CUSTOM_STYLES[att];}}else if(att===''){att='cssText';val='';}
style[att]=val;}},getStyle:function(node,att,style){style=style||node.style;var CUSTOM_STYLES=Y_DOM.CUSTOM_STYLES,val='';if(style){if(att in CUSTOM_STYLES){if(CUSTOM_STYLES[att].get){return CUSTOM_STYLES[att].get(node,att,style);}else if(typeof CUSTOM_STYLES[att]==='string'){att=CUSTOM_STYLES[att];}}
val=style[att];if(val===''){val=Y_DOM[GET_COMPUTED_STYLE](node,att);}}
return val;},setStyles:function(node,hash){var style=node.style;Y.each(hash,function(v,n){Y_DOM.setStyle(node,n,v,style);},Y_DOM);},getComputedStyle:function(node,att){var val='',doc=node[OWNER_DOCUMENT];if(node[STYLE]&&doc[DEFAULT_VIEW]&&doc[DEFAULT_VIEW][GET_COMPUTED_STYLE]){val=doc[DEFAULT_VIEW][GET_COMPUTED_STYLE](node,null)[att];}
return val;}});if(DOCUMENT[DOCUMENT_ELEMENT][STYLE][CSS_FLOAT]!==UNDEFINED){Y_DOM.CUSTOM_STYLES[FLOAT]=CSS_FLOAT;}else if(DOCUMENT[DOCUMENT_ELEMENT][STYLE][STYLE_FLOAT]!==UNDEFINED){Y_DOM.CUSTOM_STYLES[FLOAT]=STYLE_FLOAT;}
if(Y.UA.opera){Y_DOM[GET_COMPUTED_STYLE]=function(node,att){var view=node[OWNER_DOCUMENT][DEFAULT_VIEW],val=view[GET_COMPUTED_STYLE](node,'')[att];if(re_color.test(att)){val=Y.Color.toRGB(val);}
return val;};}
if(Y.UA.webkit){Y_DOM[GET_COMPUTED_STYLE]=function(node,att){var view=node[OWNER_DOCUMENT][DEFAULT_VIEW],val=view[GET_COMPUTED_STYLE](node,'')[att];if(val==='rgba(0, 0, 0, 0)'){val=TRANSPARENT;}
return val;};}
Y.DOM._getAttrOffset=function(node,attr){var val=Y.DOM[GET_COMPUTED_STYLE](node,attr),offsetParent=node.offsetParent,position,parentOffset,offset;if(val==='auto'){position=Y.DOM.getStyle(node,'position');if(position==='static'||position==='relative'){val=0;}else if(offsetParent&&offsetParent[GET_BOUNDING_CLIENT_RECT]){parentOffset=offsetParent[GET_BOUNDING_CLIENT_RECT]()[attr];offset=node[GET_BOUNDING_CLIENT_RECT]()[attr];if(attr==='left'||attr==='top'){val=offset-parentOffset;}else{val=parentOffset-node[GET_BOUNDING_CLIENT_RECT]()[attr];}}}
return val;};Y.DOM._getOffset=function(node){var pos,xy=null;if(node){pos=Y_DOM.getStyle(node,'position');xy=[parseInt(Y_DOM[GET_COMPUTED_STYLE](node,'left'),10),parseInt(Y_DOM[GET_COMPUTED_STYLE](node,'top'),10)];if(isNaN(xy[0])){xy[0]=parseInt(Y_DOM.getStyle(node,'left'),10);if(isNaN(xy[0])){xy[0]=(pos==='relative')?0:node.offsetLeft||0;}}
if(isNaN(xy[1])){xy[1]=parseInt(Y_DOM.getStyle(node,'top'),10);if(isNaN(xy[1])){xy[1]=(pos==='relative')?0:node.offsetTop||0;}}}
return xy;};Y_DOM.CUSTOM_STYLES.transform={set:function(node,val,style){style[TRANSFORM]=val;},get:function(node,style){return Y_DOM[GET_COMPUTED_STYLE](node,TRANSFORM);}};})(Y);(function(Y){var PARSE_INT=parseInt,RE=RegExp;Y.Color={KEYWORDS:{black:'000',silver:'c0c0c0',gray:'808080',white:'fff',maroon:'800000',red:'f00',purple:'800080',fuchsia:'f0f',green:'008000',lime:'0f0',olive:'808000',yellow:'ff0',navy:'000080',blue:'00f',teal:'008080',aqua:'0ff'},re_RGB:/^rgb\(([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\)$/i,re_hex:/^#?([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})$/i,re_hex3:/([0-9A-F])/gi,toRGB:function(val){if(!Y.Color.re_RGB.test(val)){val=Y.Color.toHex(val);}
if(Y.Color.re_hex.exec(val)){val='rgb('+[PARSE_INT(RE.$1,16),PARSE_INT(RE.$2,16),PARSE_INT(RE.$3,16)].join(', ')+')';}
return val;},toHex:function(val){val=Y.Color.KEYWORDS[val]||val;if(Y.Color.re_RGB.exec(val)){val=[Number(RE.$1).toString(16),Number(RE.$2).toString(16),Number(RE.$3).toString(16)];for(var i=0;i<val.length;i++){if(val[i].length<2){val[i]='0'+val[i];}}
val=val.join('');}
if(val.length<6){val=val.replace(Y.Color.re_hex3,'$1$1');}
if(val!=='transparent'&&val.indexOf('#')<0){val='#'+val;}
return val.toUpperCase();}};})(Y);},'3.3.0',{requires:['dom-base']});YUI.add('dom-screen',function(Y){(function(Y){var DOCUMENT_ELEMENT='documentElement',COMPAT_MODE='compatMode',POSITION='position',FIXED='fixed',RELATIVE='relative',LEFT='left',TOP='top',_BACK_COMPAT='BackCompat',MEDIUM='medium',BORDER_LEFT_WIDTH='borderLeftWidth',BORDER_TOP_WIDTH='borderTopWidth',GET_BOUNDING_CLIENT_RECT='getBoundingClientRect',GET_COMPUTED_STYLE='getComputedStyle',Y_DOM=Y.DOM,RE_TABLE=/^t(?:able|d|h)$/i,SCROLL_NODE;if(Y.UA.ie){if(Y.config.doc[COMPAT_MODE]!=='quirks'){SCROLL_NODE=DOCUMENT_ELEMENT;}else{SCROLL_NODE='body';}}
Y.mix(Y_DOM,{winHeight:function(node){var h=Y_DOM._getWinSize(node).height;return h;},winWidth:function(node){var w=Y_DOM._getWinSize(node).width;return w;},docHeight:function(node){var h=Y_DOM._getDocSize(node).height;return Math.max(h,Y_DOM._getWinSize(node).height);},docWidth:function(node){var w=Y_DOM._getDocSize(node).width;return Math.max(w,Y_DOM._getWinSize(node).width);},docScrollX:function(node,doc){doc=doc||(node)?Y_DOM._getDoc(node):Y.config.doc;var dv=doc.defaultView,pageOffset=(dv)?dv.pageXOffset:0;return Math.max(doc[DOCUMENT_ELEMENT].scrollLeft,doc.body.scrollLeft,pageOffset);},docScrollY:function(node,doc){doc=doc||(node)?Y_DOM._getDoc(node):Y.config.doc;var dv=doc.defaultView,pageOffset=(dv)?dv.pageYOffset:0;return Math.max(doc[DOCUMENT_ELEMENT].scrollTop,doc.body.scrollTop,pageOffset);},getXY:function(){if(Y.config.doc[DOCUMENT_ELEMENT][GET_BOUNDING_CLIENT_RECT]){return function(node){var xy=null,scrollLeft,scrollTop,box,off1,off2,bLeft,bTop,mode,doc,inDoc,rootNode;if(node&&node.tagName){doc=node.ownerDocument;rootNode=doc[DOCUMENT_ELEMENT];if(rootNode.contains){inDoc=rootNode.contains(node);}else{inDoc=Y.DOM.contains(rootNode,node);}
if(inDoc){scrollLeft=(SCROLL_NODE)?doc[SCROLL_NODE].scrollLeft:Y_DOM.docScrollX(node,doc);scrollTop=(SCROLL_NODE)?doc[SCROLL_NODE].scrollTop:Y_DOM.docScrollY(node,doc);box=node[GET_BOUNDING_CLIENT_RECT]();xy=[box.left,box.top];if(Y.UA.ie){off1=2;off2=2;mode=doc[COMPAT_MODE];bLeft=Y_DOM[GET_COMPUTED_STYLE](doc[DOCUMENT_ELEMENT],BORDER_LEFT_WIDTH);bTop=Y_DOM[GET_COMPUTED_STYLE](doc[DOCUMENT_ELEMENT],BORDER_TOP_WIDTH);if(Y.UA.ie===6){if(mode!==_BACK_COMPAT){off1=0;off2=0;}}
if((mode==_BACK_COMPAT)){if(bLeft!==MEDIUM){off1=parseInt(bLeft,10);}
if(bTop!==MEDIUM){off2=parseInt(bTop,10);}}
xy[0]-=off1;xy[1]-=off2;}
if((scrollTop||scrollLeft)){if(!Y.UA.ios||(Y.UA.ios>=4.2)){xy[0]+=scrollLeft;xy[1]+=scrollTop;}}}else{xy=Y_DOM._getOffset(node);}}
return xy;}}else{return function(node){var xy=null,doc,parentNode,bCheck,scrollTop,scrollLeft;if(node){if(Y_DOM.inDoc(node)){xy=[node.offsetLeft,node.offsetTop];doc=node.ownerDocument;parentNode=node;bCheck=((Y.UA.gecko||Y.UA.webkit>519)?true:false);while((parentNode=parentNode.offsetParent)){xy[0]+=parentNode.offsetLeft;xy[1]+=parentNode.offsetTop;if(bCheck){xy=Y_DOM._calcBorders(parentNode,xy);}}
if(Y_DOM.getStyle(node,POSITION)!=FIXED){parentNode=node;while((parentNode=parentNode.parentNode)){scrollTop=parentNode.scrollTop;scrollLeft=parentNode.scrollLeft;if(Y.UA.gecko&&(Y_DOM.getStyle(parentNode,'overflow')!=='visible')){xy=Y_DOM._calcBorders(parentNode,xy);}
if(scrollTop||scrollLeft){xy[0]-=scrollLeft;xy[1]-=scrollTop;}}
xy[0]+=Y_DOM.docScrollX(node,doc);xy[1]+=Y_DOM.docScrollY(node,doc);}else{xy[0]+=Y_DOM.docScrollX(node,doc);xy[1]+=Y_DOM.docScrollY(node,doc);}}else{xy=Y_DOM._getOffset(node);}}
return xy;};}}(),getX:function(node){return Y_DOM.getXY(node)[0];},getY:function(node){return Y_DOM.getXY(node)[1];},setXY:function(node,xy,noRetry){var setStyle=Y_DOM.setStyle,pos,delta,newXY,currentXY;if(node&&xy){pos=Y_DOM.getStyle(node,POSITION);delta=Y_DOM._getOffset(node);if(pos=='static'){pos=RELATIVE;setStyle(node,POSITION,pos);}
currentXY=Y_DOM.getXY(node);if(xy[0]!==null){setStyle(node,LEFT,xy[0]-currentXY[0]+delta[0]+'px');}
if(xy[1]!==null){setStyle(node,TOP,xy[1]-currentXY[1]+delta[1]+'px');}
if(!noRetry){newXY=Y_DOM.getXY(node);if(newXY[0]!==xy[0]||newXY[1]!==xy[1]){Y_DOM.setXY(node,xy,true);}}}else{}},setX:function(node,x){return Y_DOM.setXY(node,[x,null]);},setY:function(node,y){return Y_DOM.setXY(node,[null,y]);},swapXY:function(node,otherNode){var xy=Y_DOM.getXY(node);Y_DOM.setXY(node,Y_DOM.getXY(otherNode));Y_DOM.setXY(otherNode,xy);},_calcBorders:function(node,xy2){var t=parseInt(Y_DOM[GET_COMPUTED_STYLE](node,BORDER_TOP_WIDTH),10)||0,l=parseInt(Y_DOM[GET_COMPUTED_STYLE](node,BORDER_LEFT_WIDTH),10)||0;if(Y.UA.gecko){if(RE_TABLE.test(node.tagName)){t=0;l=0;}}
xy2[0]+=l;xy2[1]+=t;return xy2;},_getWinSize:function(node,doc){doc=doc||(node)?Y_DOM._getDoc(node):Y.config.doc;var win=doc.defaultView||doc.parentWindow,mode=doc[COMPAT_MODE],h=win.innerHeight,w=win.innerWidth,root=doc[DOCUMENT_ELEMENT];if(mode&&!Y.UA.opera){if(mode!='CSS1Compat'){root=doc.body;}
h=root.clientHeight;w=root.clientWidth;}
return{height:h,width:w};},_getDocSize:function(node){var doc=(node)?Y_DOM._getDoc(node):Y.config.doc,root=doc[DOCUMENT_ELEMENT];if(doc[COMPAT_MODE]!='CSS1Compat'){root=doc.body;}
return{height:root.scrollHeight,width:root.scrollWidth};}});})(Y);(function(Y){var TOP='top',RIGHT='right',BOTTOM='bottom',LEFT='left',getOffsets=function(r1,r2){var t=Math.max(r1[TOP],r2[TOP]),r=Math.min(r1[RIGHT],r2[RIGHT]),b=Math.min(r1[BOTTOM],r2[BOTTOM]),l=Math.max(r1[LEFT],r2[LEFT]),ret={};ret[TOP]=t;ret[RIGHT]=r;ret[BOTTOM]=b;ret[LEFT]=l;return ret;},DOM=Y.DOM;Y.mix(DOM,{region:function(node){var xy=DOM.getXY(node),ret=false;if(node&&xy){ret=DOM._getRegion(xy[1],xy[0]+node.offsetWidth,xy[1]+node.offsetHeight,xy[0]);}
return ret;},intersect:function(node,node2,altRegion){var r=altRegion||DOM.region(node),region={},n=node2,off;if(n.tagName){region=DOM.region(n);}else if(Y.Lang.isObject(node2)){region=node2;}else{return false;}
off=getOffsets(region,r);return{top:off[TOP],right:off[RIGHT],bottom:off[BOTTOM],left:off[LEFT],area:((off[BOTTOM]-off[TOP])*(off[RIGHT]-off[LEFT])),yoff:((off[BOTTOM]-off[TOP])),xoff:(off[RIGHT]-off[LEFT]),inRegion:DOM.inRegion(node,node2,false,altRegion)};},inRegion:function(node,node2,all,altRegion){var region={},r=altRegion||DOM.region(node),n=node2,off;if(n.tagName){region=DOM.region(n);}else if(Y.Lang.isObject(node2)){region=node2;}else{return false;}
if(all){return(r[LEFT]>=region[LEFT]&&r[RIGHT]<=region[RIGHT]&&r[TOP]>=region[TOP]&&r[BOTTOM]<=region[BOTTOM]);}else{off=getOffsets(region,r);if(off[BOTTOM]>=off[TOP]&&off[RIGHT]>=off[LEFT]){return true;}else{return false;}}},inViewportRegion:function(node,all,altRegion){return DOM.inRegion(node,DOM.viewportRegion(node),all,altRegion);},_getRegion:function(t,r,b,l){var region={};region[TOP]=region[1]=t;region[LEFT]=region[0]=l;region[BOTTOM]=b;region[RIGHT]=r;region.width=region[RIGHT]-region[LEFT];region.height=region[BOTTOM]-region[TOP];return region;},viewportRegion:function(node){node=node||Y.config.doc.documentElement;var ret=false,scrollX,scrollY;if(node){scrollX=DOM.docScrollX(node);scrollY=DOM.docScrollY(node);ret=DOM._getRegion(scrollY,DOM.winWidth(node)+scrollX,scrollY+DOM.winHeight(node),scrollX);}
return ret;}});})(Y);},'3.3.0',{requires:['dom-base','dom-style','event-base']});YUI.add('selector-native',function(Y){(function(Y){Y.namespace('Selector');var COMPARE_DOCUMENT_POSITION='compareDocumentPosition',OWNER_DOCUMENT='ownerDocument';var Selector={_foundCache:[],useNative:true,_compare:('sourceIndex'in Y.config.doc.documentElement)?function(nodeA,nodeB){var a=nodeA.sourceIndex,b=nodeB.sourceIndex;if(a===b){return 0;}else if(a>b){return 1;}
return-1;}:(Y.config.doc.documentElement[COMPARE_DOCUMENT_POSITION]?function(nodeA,nodeB){if(nodeA[COMPARE_DOCUMENT_POSITION](nodeB)&4){return-1;}else{return 1;}}:function(nodeA,nodeB){var rangeA,rangeB,compare;if(nodeA&&nodeB){rangeA=nodeA[OWNER_DOCUMENT].createRange();rangeA.setStart(nodeA,0);rangeB=nodeB[OWNER_DOCUMENT].createRange();rangeB.setStart(nodeB,0);compare=rangeA.compareBoundaryPoints(1,rangeB);}
return compare;}),_sort:function(nodes){if(nodes){nodes=Y.Array(nodes,0,true);if(nodes.sort){nodes.sort(Selector._compare);}}
return nodes;},_deDupe:function(nodes){var ret=[],i,node;for(i=0;(node=nodes[i++]);){if(!node._found){ret[ret.length]=node;node._found=true;}}
for(i=0;(node=ret[i++]);){node._found=null;node.removeAttribute('_found');}
return ret;},query:function(selector,root,firstOnly,skipNative){root=root||Y.config.doc;var ret=[],useNative=(Y.Selector.useNative&&Y.config.doc.querySelector&&!skipNative),queries=[[selector,root]],query,result,i,fn=(useNative)?Y.Selector._nativeQuery:Y.Selector._bruteQuery;if(selector&&fn){if(!skipNative&&(!useNative||root.tagName)){queries=Selector._splitQueries(selector,root);}
for(i=0;(query=queries[i++]);){result=fn(query[0],query[1],firstOnly);if(!firstOnly){result=Y.Array(result,0,true);}
if(result){ret=ret.concat(result);}}
if(queries.length>1){ret=Selector._sort(Selector._deDupe(ret));}}
return(firstOnly)?(ret[0]||null):ret;},_splitQueries:function(selector,node){var groups=selector.split(','),queries=[],prefix='',i,len;if(node){if(node.tagName){node.id=node.id||Y.guid();prefix='[id="'+node.id+'"] ';}
for(i=0,len=groups.length;i<len;++i){selector=prefix+groups[i];queries.push([selector,node]);}}
return queries;},_nativeQuery:function(selector,root,one){if(Y.UA.webkit&&selector.indexOf(':checked')>-1&&(Y.Selector.pseudos&&Y.Selector.pseudos.checked)){return Y.Selector.query(selector,root,one,true);}
try{return root['querySelector'+(one?'':'All')](selector);}catch(e){return Y.Selector.query(selector,root,one,true);}},filter:function(nodes,selector){var ret=[],i,node;if(nodes&&selector){for(i=0;(node=nodes[i++]);){if(Y.Selector.test(node,selector)){ret[ret.length]=node;}}}else{}
return ret;},test:function(node,selector,root){var ret=false,groups=selector.split(','),useFrag=false,parent,item,items,frag,i,j,group;if(node&&node.tagName){if(!root&&!Y.DOM.inDoc(node)){parent=node.parentNode;if(parent){root=parent;}else{frag=node[OWNER_DOCUMENT].createDocumentFragment();frag.appendChild(node);root=frag;useFrag=true;}}
root=root||node[OWNER_DOCUMENT];if(!node.id){node.id=Y.guid();}
for(i=0;(group=groups[i++]);){group+='[id="'+node.id+'"]';items=Y.Selector.query(group,root);for(j=0;item=items[j++];){if(item===node){ret=true;break;}}
if(ret){break;}}
if(useFrag){frag.removeChild(node);}}
return ret;},ancestor:function(element,selector,testSelf){return Y.DOM.ancestor(element,function(n){return Y.Selector.test(n,selector);},testSelf);}};Y.mix(Y.Selector,Selector,true);})(Y);},'3.3.0',{requires:['dom-base']});YUI.add('selector-css2',function(Y){var PARENT_NODE='parentNode',TAG_NAME='tagName',ATTRIBUTES='attributes',COMBINATOR='combinator',PSEUDOS='pseudos',Selector=Y.Selector,SelectorCSS2={_reRegExpTokens:/([\^\$\?\[\]\*\+\-\.\(\)\|\\])/,SORT_RESULTS:true,_children:function(node,tag){var ret=node.children,i,children=[],childNodes,child;if(node.children&&tag&&node.children.tags){children=node.children.tags(tag);}else if((!ret&&node[TAG_NAME])||(ret&&tag)){childNodes=ret||node.childNodes;ret=[];for(i=0;(child=childNodes[i++]);){if(child.tagName){if(!tag||tag===child.tagName){ret.push(child);}}}}
return ret||[];},_re:{attr:/(\[[^\]]*\])/g,pseudos:/:([\-\w]+(?:\(?:['"]?(.+)['"]?\)))*/i},shorthand:{'\\#(-?[_a-z]+[-\\w]*)':'[id=$1]','\\.(-?[_a-z]+[-\\w]*)':'[className~=$1]'},operators:{'':function(node,attr){return Y.DOM.getAttribute(node,attr)!=='';},'~=':'(?:^|\\s+){val}(?:\\s+|$)','|=':'^{val}-?'},pseudos:{'first-child':function(node){return Y.Selector._children(node[PARENT_NODE])[0]===node;}},_bruteQuery:function(selector,root,firstOnly){var ret=[],nodes=[],tokens=Selector._tokenize(selector),token=tokens[tokens.length-1],rootDoc=Y.DOM._getDoc(root),child,id,className,tagName;if(token){id=token.id;className=token.className;tagName=token.tagName||'*';if(root.getElementsByTagName){if(id&&(root.all||(root.nodeType===9||Y.DOM.inDoc(root)))){nodes=Y.DOM.allById(id,root);}else if(className){nodes=root.getElementsByClassName(className);}else{nodes=root.getElementsByTagName(tagName);}}else{child=root.firstChild;while(child){if(child.tagName){nodes.push(child);}
child=child.nextSilbing||child.firstChild;}}
if(nodes.length){ret=Selector._filterNodes(nodes,tokens,firstOnly);}}
return ret;},_filterNodes:function(nodes,tokens,firstOnly){var i=0,j,len=tokens.length,n=len-1,result=[],node=nodes[0],tmpNode=node,getters=Y.Selector.getters,operator,combinator,token,path,pass,value,tests,test;for(i=0;(tmpNode=node=nodes[i++]);){n=len-1;path=null;testLoop:while(tmpNode&&tmpNode.tagName){token=tokens[n];tests=token.tests;j=tests.length;if(j&&!pass){while((test=tests[--j])){operator=test[1];if(getters[test[0]]){value=getters[test[0]](tmpNode,test[0]);}else{value=tmpNode[test[0]];if(value===undefined&&tmpNode.getAttribute){value=tmpNode.getAttribute(test[0]);}}
if((operator==='='&&value!==test[2])||(typeof operator!=='string'&&operator.test&&!operator.test(value))||(!operator.test&&typeof operator==='function'&&!operator(tmpNode,test[0]))){if((tmpNode=tmpNode[path])){while(tmpNode&&(!tmpNode.tagName||(token.tagName&&token.tagName!==tmpNode.tagName))){tmpNode=tmpNode[path];}}
continue testLoop;}}}
n--;if(!pass&&(combinator=token.combinator)){path=combinator.axis;tmpNode=tmpNode[path];while(tmpNode&&!tmpNode.tagName){tmpNode=tmpNode[path];}
if(combinator.direct){path=null;}}else{result.push(node);if(firstOnly){return result;}
break;}}}
node=tmpNode=null;return result;},combinators:{' ':{axis:'parentNode'},'>':{axis:'parentNode',direct:true},'+':{axis:'previousSibling',direct:true}},_parsers:[{name:ATTRIBUTES,re:/^\[(-?[a-z]+[\w\-]*)+([~\|\^\$\*!=]=?)?['"]?([^\]]*?)['"]?\]/i,fn:function(match,token){var operator=match[2]||'',operators=Y.Selector.operators,test;if((match[1]==='id'&&operator==='=')||(match[1]==='className'&&Y.config.doc.documentElement.getElementsByClassName&&(operator==='~='||operator==='='))){token.prefilter=match[1];token[match[1]]=match[3];}
if(operator in operators){test=operators[operator];if(typeof test==='string'){match[3]=match[3].replace(Y.Selector._reRegExpTokens,'\\$1');test=Y.DOM._getRegExp(test.replace('{val}',match[3]));}
match[2]=test;}
if(!token.last||token.prefilter!==match[1]){return match.slice(1);}}},{name:TAG_NAME,re:/^((?:-?[_a-z]+[\w-]*)|\*)/i,fn:function(match,token){var tag=match[1].toUpperCase();token.tagName=tag;if(tag!=='*'&&(!token.last||token.prefilter)){return[TAG_NAME,'=',tag];}
if(!token.prefilter){token.prefilter='tagName';}}},{name:COMBINATOR,re:/^\s*([>+~]|\s)\s*/,fn:function(match,token){}},{name:PSEUDOS,re:/^:([\-\w]+)(?:\(['"]?(.+)['"]?\))*/i,fn:function(match,token){var test=Selector[PSEUDOS][match[1]];if(test){return[match[2],test];}else{return false;}}}],_getToken:function(token){return{tagName:null,id:null,className:null,attributes:{},combinator:null,tests:[]};},_tokenize:function(selector){selector=selector||'';selector=Selector._replaceShorthand(Y.Lang.trim(selector));var token=Selector._getToken(),query=selector,tokens=[],found=false,match,test,i,parser;outer:do{found=false;for(i=0;(parser=Selector._parsers[i++]);){if((match=parser.re.exec(selector))){if(parser.name!==COMBINATOR){token.selector=selector;}
selector=selector.replace(match[0],'');if(!selector.length){token.last=true;}
if(Selector._attrFilters[match[1]]){match[1]=Selector._attrFilters[match[1]];}
test=parser.fn(match,token);if(test===false){found=false;break outer;}else if(test){token.tests.push(test);}
if(!selector.length||parser.name===COMBINATOR){tokens.push(token);token=Selector._getToken(token);if(parser.name===COMBINATOR){token.combinator=Y.Selector.combinators[match[1]];}}
found=true;}}}while(found&&selector.length);if(!found||selector.length){tokens=[];}
return tokens;},_replaceShorthand:function(selector){var shorthand=Selector.shorthand,attrs=selector.match(Selector._re.attr),pseudos=selector.match(Selector._re.pseudos),re,i,len;if(pseudos){selector=selector.replace(Selector._re.pseudos,'!!REPLACED_PSEUDO!!');}
if(attrs){selector=selector.replace(Selector._re.attr,'!!REPLACED_ATTRIBUTE!!');}
for(re in shorthand){if(shorthand.hasOwnProperty(re)){selector=selector.replace(Y.DOM._getRegExp(re,'gi'),shorthand[re]);}}
if(attrs){for(i=0,len=attrs.length;i<len;++i){selector=selector.replace('!!REPLACED_ATTRIBUTE!!',attrs[i]);}}
if(pseudos){for(i=0,len=pseudos.length;i<len;++i){selector=selector.replace('!!REPLACED_PSEUDO!!',pseudos[i]);}}
return selector;},_attrFilters:{'class':'className','for':'htmlFor'},getters:{href:function(node,attr){return Y.DOM.getAttribute(node,attr);}}};Y.mix(Y.Selector,SelectorCSS2,true);Y.Selector.getters.src=Y.Selector.getters.rel=Y.Selector.getters.href;if(Y.Selector.useNative&&Y.config.doc.querySelector){Y.Selector.shorthand['\\.(-?[_a-z]+[-\\w]*)']='[class~=$1]';}},'3.3.0',{requires:['selector-native']});YUI.add('selector',function(Y){},'3.3.0',{use:['selector-native','selector-css2']});YUI.add('dom',function(Y){},'3.3.0',{use:['dom-base','dom-style','dom-screen','selector']});