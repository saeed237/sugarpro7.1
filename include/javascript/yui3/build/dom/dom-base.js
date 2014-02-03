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
node.style[prop]=val+'px';}}});},'3.3.0',{requires:['oop']});