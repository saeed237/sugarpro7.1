{*
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

*}

<div id="{$source_id}_add_tables" class="sources_table_div">
{foreach from=$display_data key=module item=data}
<table border="0" cellspacing="1" cellpadding="1" name="{$module}" id="{$module}">
<tr>
<td colspan="2"><span><font size="3">{sugar_translate label=$module}</font></span></td>
</tr>
<tr>
<td><b>{$mod.LBL_DEFAULT}</b></td>
<td><b>{$mod.LBL_AVAILABLE}</b></td>
</tr>
<tr>
<td>
<div class="enabled_workarea" id="{$source_id}:{$module}:enabled_div">
<ul class="draglist" id="{$source_id}:{$module}:enabled_ul">
{foreach from=$data.enabled key=enabled_id item=enabled_value}
<li class="noBullet2" id="{$source_id}:{$module}:{$enabled_id}">{$enabled_value}</li>
{/foreach}
</ul>
</div>
</td>
<td>
<div class="disabled_workarea" id="{$source_id}:{$module}:disabled_div">
<ul class="draglist" id="{$source_id}:{$module}:disabled_ul">
{foreach from=$data.disabled key=disabled_id item=disabled_value}
<li class="noBullet2" id="{$source_id}:{$module}:{$disabled_id}">{$disabled_value}</li>
{/foreach}
</ul>
</div>
</td>
</tr>
</table>
<hr/>
{/foreach}
</div>

<script type="text/javascript">
{literal}

var Dom = YAHOO.util.Dom; 
var Event = YAHOO.util.Event; 
var DDM = YAHOO.util.DragDropMgr;

(function() {

YAHOO.example.DDApp = { 
init: function() { 
{/literal}	    
{foreach from=$modules_sources key=module item=field_defs}  
    new YAHOO.util.DDTarget("{$source_id}:{$module}:enabled_ul", "{$source_id}:{$module}"); 
	new YAHOO.util.DDTarget("{$source_id}:{$module}:disabled_ul", "{$source_id}:{$module}"); 
	{foreach from=$field_defs key=index item=field}
	     new YAHOO.example.DDList("{$source_id}:{$module}:{$index}", "{$source_id}:{$module}");
	{/foreach}
{/foreach}    
{literal}	        
}
};

YAHOO.example.DDList = function(id, sGroup, config) { 
	    YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config); 
	    var el = this.getDragEl(); 
	    Dom.setStyle(el, "opacity", 0.67);
	    this.goingUp = false; 
	    this.lastY = 0; 
}; 


YAHOO.extend(YAHOO.example.DDList, YAHOO.util.DDProxy, { 	 
	    startDrag: function(x, y) { 
	        // make the proxy look like the source element 
	        var dragEl = this.getDragEl(); 
	        var clickEl = this.getEl(); 
	        Dom.setStyle(clickEl, "visibility", "hidden"); 
	        dragEl.innerHTML = clickEl.innerHTML; 
	        Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color")); 
	        Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor")); 
	        Dom.setStyle(dragEl, "border", "2px solid gray");
	        Dom.setStyle(dragEl, "cursor", "pointer");  
	    }, 
	 
	    endDrag: function(e) { 
	 
	        var srcEl = this.getEl(); 
	        var proxy = this.getDragEl(); 
	 
	        // Show the proxy element and animate it to the src element's location 
	        Dom.setStyle(proxy, "visibility", ""); 
	        var a = new YAHOO.util.Motion(  
	            proxy, {  
	                points: {  
	                    to: Dom.getXY(srcEl) 
	                } 
	            },  
	            0.2,  
	            YAHOO.util.Easing.easeOut  
	        ) 
	        var proxyid = proxy.id; 
	        var thisid = this.id; 
	 
	        // Hide the proxy and show the source element when finished with the animation 
	        a.onComplete.subscribe(function() { 
	                Dom.setStyle(proxyid, "visibility", "hidden"); 
	                Dom.setStyle(thisid, "visibility", ""); 
	            }); 
	        a.animate(); 
	    }, 
	 
	    onDragDrop: function(e, id) { 	 
	        // If there is one drop interaction, the li was dropped either on the list, 
	        // or it was dropped on the current location of the source element. 
	        if (typeof(DDM.interactionInfo) != 'undefined' && DDM.interactionInfo.drop.length === 1) { 
	 
	            // The position of the cursor at the time of the drop (YAHOO.util.Point) 
	            var pt = DDM.interactionInfo.point;  
	 
	            // The region occupied by the source element at the time of the drop 
	            var region = DDM.interactionInfo.sourceRegion;  
	            // Check to see if we are over the source element's location.  We will 
	            // append to the bottom of the list once we are sure it was a drop in 
	            // the negative space (the area of the list without any list items) 
	            if (!region.intersect(pt)) { 
	                var destEl = Dom.get(id);
	                var destDD = DDM.getDDById(id); 
	                destEl.appendChild(this.getEl()); 
	                destDD.isEmpty = false; 
	                DDM.refreshCache(); 
	            } 
	 
	        } 
	    }, 
	 
	    onDrag: function(e) { 
	 
	        // Keep track of the direction of the drag for use during onDragOver 
	        var y = Event.getPageY(e); 
	 
	        if (y < this.lastY) { 
	            this.goingUp = true; 
	        } else if (y > this.lastY) { 
	            this.goingUp = false; 
	        } 
	 
	        this.lastY = y; 
	    }, 
	    
	    onDragOver: function(e, id) { 
	        var srcEl = this.getEl(); 
	        var destEl = Dom.get(id);
	 
	        if (destEl.nodeName.toLowerCase() == "li") { 
	            var orig_p = srcEl.parentNode; 
	            var p = destEl.parentNode; 
		        if (this.goingUp) { 
	                p.insertBefore(srcEl, destEl); // insert above 
	            } else { 
	                p.insertBefore(srcEl, destEl.nextSibling); // insert below 
	            } 
		        DDM.refreshCache(); 
	        }  else if(destEl.nodeName.toLowerCase() == "ul") {
	            var p = destEl.parentNode;
                blank_list = p.lastChild;
                if(!blank_list.id) {
                    destEl.appendChild(srcEl);
                } else {
	                blank_list.insertBefore(srcEl, destEl.nextSibling);
                }
                DDM.refreshCache(); 
	        }
	    } 
	}); 

 
YAHOO.util.Event.onDOMReady(function(){
      YAHOO.example.DDApp.init();
 });

})();
{/literal}
</script>

{if $no_searchdefs_defined}
<h3>{$mod.ERROR_NO_SEARCHDEFS_DEFINED}</h3>
{/if}
