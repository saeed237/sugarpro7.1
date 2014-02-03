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


//Use loader to grab the modules needed
var DCMenu = YUI({debug:false,combine: true, timeout: 10000, base:"include/javascript/yui3/build/", comboBase:"index.php?entryPoint=getYUIComboFile&"}).use('event', 'dd-plugin', 'anim', 'cookie', 'json', 'node-menunav', 'io-base','io-form', 'io-upload-iframe', "overlay", function(Y) {
    //Make this an Event Target so we can bubble to it
    var requests = {};
    var overlays = [];
    var overlayDepth = 0;
    var menuFunctions = {};
    var lastIconChange = null;
    var isRTL = (typeof(rtl) != "undefined") ? true : false;
    function getOverlay(depth, modal){
    		if(!depth)depth = 0;
    		if(typeof overlays[depth] == 'undefined'){
    			 overlays[depth] = new Y.Overlay({
            			bodyContent: "",
           			    zIndex:21 + depth,
            			shim:false,
            			visibility:false
        		});
        		overlays[depth].after('render', function(e) {
                    //Get the bounding box node and plug
                    this.get('boundingBox').plug(Y.Plugin.Drag, {
                        //Set the handle to the header element.
                        handles: ['.hd']
                    });
                });
        		overlays[depth].show = function(){
        			this.visible = true;
                    //Hack until the YUI 3 overlay classes no longer conflicts with the YUI 2 overlay css
					this.get('boundingBox').setStyle('position' , 'absolute');
    				this.get('boundingBox').setStyle('visibility','visible');
    				if(Y.one('#dcboxbody')) {
    					Y.one('#dcboxbody').setStyle('display','');
    					Y.one('#dcboxbody').setStyle('visibility','hidden');
    				}
    			}
    			overlays[depth].hide = function(){
    				this.visible = false;
    				this.get('boundingBox').setStyle('visibility','hidden');
                    if (this.get("modal"))
                        this.toggleModal();
    			}
                overlays[depth].toggleModal = function(){
                    var mask = Y.one("#dcmask")
                    if (this.get("modal"))
                    {
                        //Hide the mask if it has been rendered
                        if (mask){
                            mask.setStyle("display", "none");
                        }
                        this.set("modal", false);
                    }
                    else {
                        if (mask){
                            mask.setStyle("display", "block");
                        }
                        else {
                            mask = document.createElement("div");
                            mask.className = "mask";
                            mask.id = "dcmask";
                            mask.style.width = mask.style.height = "100%";
                            mask.style.position = "fixed";
                            mask.style.display = "block";
                            mask.style.zIndex = 19;
                            document.body.appendChild(mask);
                        }
                        this.set("modal", true);
                    }
                }
    		}

			//var dcmenuContainerHeight = dcmenuContainer.get('offsetHeight');
    		//overlays[depth].set('xy', [20,dcmenuContainerHeight]);
   	  	    overlays[depth].render();
   	  	    
   	  	    
   	  	    //overlays[depth].center();
   	  	    YAHOO.util.Event.onContentReady("dcboxbody", function() {
   	  	    		
   	  	    	   	//console.log(Y.one('#dcboxbody').get('offsetWidth'));
		   	  	    //overlays[depth].set("width", Y.one('#dcboxbody').get('offsetWidth')+"px");
		   	  	    //overlays[depth].set("height", Y.one('#dcboxbody').get('offsetHeight')+"px");
		   	  	    //overlays[depth].set("centered", true);
		   	  	    //Y.one('#dcboxbody').setStyle('display','');
   	  	    	});

            if(modal)
                overlays[depth].toggleModal();
    		return overlays[depth]
    }
    
    DCMenu.menu = function(module,title,modal){
        if ( typeof(lastLoadedMenu) != 'undefined' && lastLoadedMenu == module ) {
            return;
        }
        
        lastLoadedMenu = module;

    	if(typeof menuFunctions[module] == 'undefined'){
    		loadView(
                module,
                'index.php?source_module=' + this.module + '&record=' + this.record + '&action=Quickcreate&module=' + module,
                null,null,title,{modal : modal ? true : false}
            );
    	}	
    }
    
    
    DCMenu.displayModuleMenu = function(obj, module){
    	loadView(module, 'index.php?module=' + module + '&action=ajaxmenu', 0, 'moduleTabLI_' + module); 	
    	
    }
    
    DCMenu.closeTopOverlay = function(){
        overlays[overlays.length - 1].hide();
    }
    
    DCMenu.closeOverlay = function(depth,parentid){
        DCMenu.closeQView();
    	var i=0;
        while(i < overlays.length){
            if(!depth || i >= depth){
                if(i == depth && !overlays[i].visible){
                    overlays[i].show();
                }else{
                    // See if we are hiding a form, and if so if it has changed we need to alert and confirm.
                    if ( typeof(overlays[i].bodyNode) != 'undefined'
                         && typeof(overlays[i].bodyNode._node) != 'undefined'
                         && typeof(overlays[i].bodyNode._node.getElementsByTagName('form')[0]) != 'undefined' ) {
                        var warnMsg = onUnloadEditView(overlays[i].bodyNode._node.getElementsByTagName('form')[0]);
                        if ( warnMsg != null ) {
                            if ( confirm(warnMsg) ) {
                                disableOnUnloadEditView(overlays[i].bodyNode._node.getElementsByTagName('form')[0]);
                            } else {
                                i++;
                                continue;
                            }
                        }
                    }
                    overlays[i].hide();
                    overlays[i].set('bodyContent', "");
                    if(parentid){
                        $('#'+parentid).removeClass("focused");
                    }
                }
            }
            i++;
        }
        DCMenu.hideQEPanel();
    }
    DCMenu.minimizeOverlay = function(){
 		//isIE7 = ua.indexOf('msie 7')!=-1;
		//box_style = isIE7 ? 'position:fixed; width:750px;' : 'none';
		
     	Y.one('#dcboxbody').setStyle('display','none');
     	Y.one('#dcboxbody').setStyle('width', '750px;');
    }
    function setBody(data, depth, parentid,type,title,extraButton){
			//extraButton can be either a string to append to the content or a set of additional parameters;
            var params = {};
            if (typeof(extraButton) == "object" && extraButton != null)
            {
                params = extraButton;
                extraButton = params.extraButton ? params.extraButton : false;
            }

            if(typeof(data.html) == 'undefined')data = {html:data};
			//Check for the login page, meaning we have been logged out.
			if (SUGAR.util.isLoginPage(data.html))
				return false;
    		DCMenu.closeOverlay(depth);
    		var overlay = getOverlay(depth, params.modal);
    		ua = navigator.userAgent.toLowerCase();
    		isIE7 = ua.indexOf('msie 7')!=-1;

            //set the title if it was passed in the data array
            if((typeof(title) == 'undefined' || title =='')&&(typeof(data.title)!='undefined')){
                title = data.title;
            }

    		var style = 'position:fixed';
    		if(parentid){
    			overlay.set("align", {node:"#" + parentid, points:[Y.WidgetPositionAlign.TL, Y.WidgetPositionAlign.BL]});
				overlay.set('y', 42);
    		}
    		var content = '';
    		if(false && depth == 0){
	    		content += '<div id="dcboxtitle">'

	    		if(typeof data.title  !=  'undefined'){
	    			content += '<div style="float:left"><a href="' +data.url + '">' + data.title + '</a></div>';
	    		}

                 content += '<div class="close"><a id="dcmenu_close_link" href="#" onclick="DCMenu.closeOverlay(\'\',\''+parentid+'\'); return false;">[x]</a><a href="#" onclick="DCMenu.minimizeOverlay(); return false;">[-]</a></div></div>';
    		}
    		content += '<div style="' + style + '"><div id="dcboxbody"  class="'+ parentid +'"><div class="dashletPanel dc"><div class="hd" id="dchead">';
			if ( title !== undefined )
			    content +=	'<div id="dctitle">' + title + '</div>';
			else
			    if(typeof type  !=  'undefined')
			        content +=	'<div id="dctitle">' + type + '</div>';

		    content += '<div class="close">';
            if ( typeof(extraButton) == "string" ) {
                content += extraButton
            }
            content += '<a id="dcmenu_close_link" href="#" onclick="lastLoadedMenu=undefined;DCMenu.closeOverlay(\'\',\''+parentid+'\'); return false;"><i class="icon-remove icon-sm"></i></a></div></div><div class="bd"><div class="dccontent">' + data.html + '</div></div></div>';


            //"resetEvalBool" will only be set to true if an eval() has completed succesfully from a previous request.  It will not get reset again within a request.
            //Resetting the switches means this is the first time the eval is attempted in this request, so we are starting over.  This is mostly to handle
            //the use case where Sugar.util.evalScript() executes a script after this function ends leaving the 'evalHappened' flag in a bad state.
            //"evalHappened" var tracks whether an eval() has or is occurring within this request.  It will be reset to false at the end of the function for reuse;
            //It's main purpose is to prevent multiple eval's being executed on the same form.
            if(typeof(resetEvalBool) !='undefined' && resetEvalBool == true){
                resetEvalBool = false;
                evalHappened = false;
            }

            //set eval happened var
            content ='<script> var evalHappened = true; var resetEvalBool=true; </script>'+content;
            overlay.set('bodyContent', content);

            // eval the contents if the eval parameter is passed in.  Cross check with evalHappened parameter which would not
            // be set unless the eval has already happened, in which case we dont want to double eval.
            // This will ensure that quick search, validation, and other relevant js is run in the modal
            if(typeof(data.eval) != 'undefined' && data.eval  && (typeof(evalHappened) =='undefined'|| evalHappened ==false)){
                SUGAR.util.evalScript(content);
            }
        
            //set back to false for reuse
            evalHappened = false;

    		overlay.show();
    		return overlay;
    }
	DCMenu.showView = function(data, parent_id){
		setBody(data, 0, parent_id);
	}
	DCMenu.iFrame = function(url, width, height){
		setBody("<iframe style='border:0px;height:" + height + ";width:" + width + "'src='" + url + "'></iframe>");
	}
    DCMenu.addToFavorites = function(item, module, record){
		Y.one(item).replaceClass('off', 'on');
        Y.one(item).setAttribute("title", SUGAR.language.get('app_strings', 'LBL_REMOVE_FROM_FAVORITES'));
		item.onclick = function(){
			DCMenu.removeFromFavorites(this, module, record);
            SUGAR.themes.updateFavoritesList(true);
		}
		quickRequest('favorites', 'index.php?to_pdf=1&module=SugarFavorites&action=save&fav_id=' + record + '&fav_module=' + module);
        SUGAR.themes.updateFavoritesList(true);
	}

	DCMenu.removeFromFavorites = function(item, module, record){
		Y.one(item).replaceClass('on', 'off');
        Y.one(item).setAttribute("title", SUGAR.language.get('app_strings', 'LBL_ADD_TO_FAVORITES'));
		item.onclick = function(){
			DCMenu.addToFavorites(this, module, record);
		}
		quickRequest('favorites', 'index.php?to_pdf=1&module=SugarFavorites&action=delete&fav_id=' + record + '&fav_module=' + module);
	}
	DCMenu.tagFavorites = function(item,module, record, tag){
		quickRequest('favorites', 'index.php?to_pdf=1&module=SugarFavorites&action=tag&fav_id=' + record + '&fav_module=' + module + '&tag=' + tag);
	}

    function quickRequest(type, url, success)
    {

     	if(typeof success == 'undefined' || typeof success != 'function')
        {
           success=function(id, data) {}
        }

        var id = Y.io(url, {
            method: 'POST',
             //XDR Listeners
 		    on: {
 			    success: success,
 			    failure: function(id, data) {
                     //Something failed..
                     //alert('Feed failed to load..' + id + ' :: ' + data);
                 }
 		    }
        });
    }

    DCMenu.pluginList = function(){
		quickRequest('plugins', 'index.php?to_pdf=1&module=Home&action=pluginList', pluginResults);
	}

	pluginResults = function(id, data){
		var overlay = setBody(data.responseText, 0, 'globalLinks');
		overlay.set('y', 90);
	}
	DCMenu.history = function(q){
		quickRequest('spot', 'index.php?append_wildcard=true&to_pdf=1&module=' + this.module + '&action=modulelistmenu', spotResults);
	}
    DCMenu.startSearch = function(e){
        if (window.event) { e = window.event; }
            if (e.keyCode == 13)
            {
                DCMenu.spot(document.getElementById('sugar_spot_search').value);
            }
    }
	Y.spot = function(q){
        var q = $.trim(q);
        if(q == '')
            return;
        DCMenu.closeQView();
	    ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
		quickRequest('spot', 'index.php?append_wildcard=true&to_pdf=1&module=' + this.module + '&action=spot&record=' + this.record + '&q=' + encodeURIComponent(q), spotResults);
	}
        Y.spotFull = function(q){
        DCMenu.closeQView();
            ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'));
                quickRequest('spot', 'index.php?append_wildcard=true&to_pdf=1&module=' + this.module + '&action=spot&full=true&ajax=true&record=' + this.record + '&q=' + encodeURIComponent(q), fullResults);
        }
	DCMenu.spotZoom = function(q, module, offset){
		quickRequest('spot', 'index.php?append_wildcard=true&to_pdf=1&module=' + this.module + '&action=spot&record=' + this.record + '&q=' + encodeURIComponent(q) + '&zoom=' + module + '&offset=' + offset,  spotResults);
	}
        fullResults = function(id, data){
            var resultsDiv = document.getElementById('sugar_full_search_results');
            resultsDiv.style.display = 'block';
            resultsDiv.innerHTML = data.responseText;
            ajaxStatus.hideStatus();
        }
	spotResults = function(id, data){
		//var overlay = setBody(data.responseText, 0, 'sugar_spot_search');
        document.getElementById('sugar_spot_search').className = 'searching';
                        
        var resultsDiv = document.getElementById('sugar_spot_search_results');
        resultsDiv.style.display = 'block';
        resultsDiv.innerHTML = data.responseText;
		//overlay.set('x', overlay.get('x') - 60);
		ajaxStatus.hideStatus();
		//set focus on first sugaraction element, identified by id sugaraction1
		//var focuselement=document.getElementById('sugaraction1');
		//if (typeof(focuselement) != 'undefined' && focuselement != null) {
		//	focuselement.focus();
		//}
        //$('#sugar_spot_search_results').removeHighlight();
        //$('#sugar_spot_search_results li a').highlight($("#sugar_spot_search").val());
	}

    DCMenu.showQELoadingPanel = function(){
        if (!DCMenu.qePanel)
        {
            DCMenu.qePanel = new YAHOO.widget.Panel('quickEditWindow', {
                width: "1050px",
                draggable: true,
                close: true,
                constraintoviewport: true,
                fixedcenter: false,
                script: true,
                modal: true
            });
        }
        var p = DCMenu.qePanel;
        p.setHeader(SUGAR.language.get('app_strings','LBL_EMAIL_PERFORMING_TASK'));
		p.setBody(SUGAR.language.get('app_strings','LBL_EMAIL_ONE_MOMENT'));
        p.render(document.body);
        p.show();
        p.center();
    }

    DCMenu.miniDetailView = function(module, id){
        DCMenu.showQELoadingPanel();
        YAHOO.util.Connect.asyncRequest('GET', 'index.php?to_pdf=1&module=' + module + '&action=quick&record=' + id, {
            success: DCMenu.miniDetailViewResults
        });
	}
    //this form is used by quickEdits to provide a modal edit form
	DCMenu.miniEditView = function(module, id, refreshListID, refreshDashletID){
        DCMenu.showQELoadingPanel();
        YAHOO.util.Connect.asyncRequest('GET', 'index.php?to_pdf=1&module=' + module + '&action=Quickedit&record=' + id, {
            success: DCMenu.miniDetailViewResults
        });
        //use pased in values to determine if this is being fired from a dashlet or list
        //populate the qe_refresh variable with the correct refresh string to execute on DCMenu.save
        if(typeof(refreshListID) !='undefined' && refreshListID !=''){
            //this is a list, so add a time stamp to url so ajaxUI detects a change and refreshes the screen
            DCMenu.qe_refresh = 'SUGAR.ajaxUI.loadContent("index.php?module='+module+'&action=index&ignore='+new Date().getTime()+'");';

        }
        if(typeof(refreshDashletID) !='undefined' && refreshDashletID !=''){
            //this is a dashlet, use the passed in id to refresh the dashlet
            DCMenu.qe_refresh = 'SUGAR.mySugar.retrieveDashlet("'+refreshDashletID+'");';
        }
	}
	DCMenu.miniDetailViewResults = function(o){
        var p = DCMenu.qePanel;
        var r = Y.JSON.parse(o.responseText);
        if(typeof(r.scriptOnly) != 'undefined' && typeof(r.scriptOnly)=='string' && r.scriptOnly.length >0){
            SUGAR.util.evalScript(r.scriptOnly);
        }else{
            DCMenu.jsEvalled = false;
            p.setHeader(r.title);
            p.setBody("<script type='text/javascript'>DCMenu.jsEvalled = true</script>" + r.html);
            if (!DCMenu.jsEvalled)
                SUGAR.util.evalScript(r.html);
            DCMenu.centerQEPanel();
        }
	}
    DCMenu.centerQEPanel = function()
    {
        var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
        var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
        var viewPortWidth = YAHOO.util.Dom.getClientWidth();
        var viewPortHeight = YAHOO.util.Dom.getClientHeight();
        var elementWidth = DCMenu.qePanel.element.offsetWidth;
        var elementHeight = DCMenu.qePanel.element.offsetHeight;
        var x = (viewPortWidth / 2) - (elementWidth / 2) + scrollX;
        // Bug #50757 : Dashlet quick edit form issue in Chrome
        // if height of panel is more than height of window display panel on top of window
        var y = ( elementHeight + 10 >= viewPortHeight ) ? 10 + scrollY : (viewPortHeight / 2) - (elementHeight / 2) + scrollY;
        DCMenu.qePanel.element.style.left = parseInt(x, 10) + "px";
        DCMenu.qePanel.element.style.top = parseInt(y, 10) + "px";
        DCMenu.qePanel.syncPosition();
        DCMenu.qePanel.cfg.refireEvent("iframe");
    }
    DCMenu.hideQEPanel = function(){
        if (DCMenu.qePanel)
        {
            DCMenu.qePanel.setBody("");
            DCMenu.qePanel.hide();
        }
    }

	DCMenu.save = function(id){
		ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'));
		Y.io('index.php',{
			method:'POST',
			form:{
				id:id,
				upload: true
			},
			on:{
				complete: function(id, data){
				    try {
                        var returnData = Y.JSON.parse(data.responseText);

                        switch ( returnData.status ) {
                        case 'dupe':
                            location.href = 'index.php?' + returnData.get;
                            break;
                        case 'success':
                            ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_SAVED'), 2000);
                            break;
                        }
                    }
                    catch (e) {
                        ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_SAVED'), 2000);
                    }

                    //if DCMenu.qe_refresh is set to a string, then eval it as it is a js reload command (either reloads dashlet or list view)
                    if(typeof(DCMenu.qe_refresh) =='string'){
                        eval(DCMenu.qe_refresh);
                    }
				}
			}

		});
		lastLoadedMenu=undefined;
		DCMenu.closeOverlay();
		return false;
	}

    DCMenu.submitForm = function(id, status, title){
		ajaxStatus.showStatus(status);
		Y.io('index.php',{
			method:'POST',
			form:{
				id:id,
				upload: true
			},
			on:{
				complete: function(id, data){

				}
			}

		});
		lastLoadedMenu=undefined;
		return false;
	}

    DCMenu.hostMeeting = function(){
        window.open(DCMenu.hostMeetingUrl, 'hostmeeting');
    }




    DCMenu.loadView = function(type,url, depth, parentid, title, extraButton){
        if ( extraButton == undefined ) { extraButton = null; }
        var id = Y.io(url, {
             method: 'POST',
             //XDR Listeners
 		    on: {
 			    success: function(id, data) {
            		 //Parse the JSON data
            		 try{
                     	jData = Y.JSON.parse(data.responseText);
                     	//saveView(type, requests[id].url,jData);
                     	 setBody(jData, requests[id].depth, requests[id].parentid,title, extraButton);
                     	 var head =Y.Node.get('head')
                     	for(i in jData['scripts']){
                    	 var script = document.createElement('script');
                    	 script.src =jData['scripts'][i];
                    	 head.appendChild(script);
                     	}
                     	SUGAR.util.evalScript(jData.html);
                     	setTimeout("enableQS();", 1000);
            		 }catch(err){
                        DCMenu.jsEvalled = false;
                        var overlay = setBody({
                            html:"<script type='text/javascript'>DCMenu.jsEvalled = true</script>" + data.responseText
                        }, requests[id].depth, requests[id].parentid,requests[id].type,title, extraButton);
            			var dcmenuSugarCube = Y.one('#dcmenuSugarCube');
			    		var dcboxbody = Y.one('#dcboxbody');

						var dcmenuSugarCubeX = (dcmenuSugarCube)?dcmenuSugarCube.get('offsetLeft'):0;
						var dcboxbodyWidth = dcboxbody.get('offsetWidth');

						setTimeout(function() {
                            //Bug#52650: Centerize modal window using jQuery since .set("centered") is not working properly in IE8
                            if(jQuery && jQuery.fn) {
                                var _overlay = $("#" + overlay.get('id')),
                                    _dcbody = $("#dcboxbody"),
                                    _width = _dcbody.outerWidth(),
                                    _height = _dcbody.outerHeight(),
                                    _viewportWidth = $(window).width(),
                                    _viewportHeight = $(window).height();
                                _overlay.css({
                                    left: (_viewportWidth - _width) * .5,
                                    top: (_viewportHeight- _height) *.5,
                                    width: _width,
                                    height: _height
                                });
                            } else {
                                overlay.set("width", dcboxbody.get('offsetWidth')+"px");
                                overlay.set("height", dcboxbody.get('offsetHeight')+"px");
                                overlay.set("centered", true);
                            }
                            dcboxbody.setStyle("visibility", "visible");
						}, 1000);

                        //set margins on modal so it is visible on all browsers
                        Y.one('#dcboxbody').setStyle('margin', '0 5% 0 0');

                         if(isSafari) {
							dcboxbody.setStyle("width",dcboxbodyWidth+"px");
						}
						if(SUGAR.isIE) {
							var dchead = Y.one('#dchead');
				    		var dcheadwidth = dchead.get('offsetWidth');
				    		Y.one('#dctitle').setStyle("width",dcheadwidth+"px");	
						}
						if(isRTL) {
							overlay.set('x',dcmenuSugarCubeX - dcboxbodyWidth);
						}

                        //only run eval once
                         if (!DCMenu.jsEvalled)
            		 	    SUGAR.util.evalScript(data.responseText);

                        setTimeout("enableQS();", 1000);

            		 }



                 },
 			    failure: function(id, data) {
                     //Something failed..
                     //alert('Feed failed to load..' + id + ' :: ' + data);
                 }
 		    }
         });
        requests[id.id] = {type:type, url:url, parentid:parentid, depth:depth, extraButton:extraButton};
    }

    var loadView = Y.loadView;
    DCMenu.notificationsList = function(q){
		quickRequest('notifications', 'index.php?to_pdf=1&module=Notifications&action=quicklist', notificationsListDisplay );
	}
	notificationsListDisplay = function(id, data){
		var overlay = setBody(data.responseText, 0, 'dcmenuSugarCube',"",SUGAR.language.get('app_strings', 'LBL_NOTIFICATIONS'));
        var dcmenuSugarCube = Y.one('#dcmenuSugarCube');
   		var dcboxbody = Y.one('#dcboxbody');
		Y.one('#dcboxbody').setStyle('visibility','visible');
		var dcmenuSugarCubeX = dcmenuSugarCube.get('offsetLeft');
		var dcmenuSugarCubeWidth = dcmenuSugarCube.get('offsetWidth');
		var dcboxbodyWidth = dcboxbody.get('offsetWidth');
        if(isRTL) {
            overlay.set('x',(dcmenuSugarCubeX));
        } else {
            overlay.set('x',(dcmenuSugarCubeX + dcmenuSugarCubeWidth) - dcboxbodyWidth);
        }
        $('#dcmenuSugarCube').addClass("focused");
		
		


	}
	DCMenu.viewMiniNotification = function(id) {
	    quickRequest('notifications', 'index.php?to_pdf=1&module=Notifications&action=quickView&record='+id, notificationDisplay );
	}
    notificationDisplay = function(id, data){
        var jData = Y.JSON.parse(data.responseText);
		setBody(jData.contents, 0);	
		decrementUnreadNotificationCount();
	}
	decrementUnreadNotificationCount = function() {
	    var oldValue = parseInt(document.getElementById('notifCount').innerHTML);
		document.getElementById('notifCount').innerHTML = oldValue - 1;
	}
	updateNotificationNumber = function(id,data){
	    var jData = Y.JSON.parse(data.responseText);
		var oldValue = parseInt(document.getElementById('notifCount').innerHTML);
		document.getElementById('notifCount').innerHTML = parseInt(jData.unreadCount) + oldValue;
	}
	DCMenu.checkForNewNotifications = function(){
	    quickRequest('notifications', 'index.php?to_pdf=1&module=Notifications&action=checkNewNotifications', updateNotificationNumber );
	}
    DCMenu.showQuickViewIcon = function(id) {
        var gs_div = document.getElementById('gs_div_' + id);
        gs_div.style.visibility = 'visible';
    }
    DCMenu.hideQuickViewIcon = function(id) {
        var gs_div = document.getElementById('gs_div_' + id);
        gs_div.style.visibility = 'hidden';
    }
    DCMenu.closeQView = function()
    {
        if(!overlays['sqv'] || !Y.one('#SpotResults'))
        {
            return;
        }
       
        var o = overlays['sqv'];
        o.visible = false;
        o.get('boundingBox').setStyle('visibility','hidden');
    }


    DCMenu.showQuickView2 = function(module, recordID)
    {
        var q = document.getElementById('sugar_spot_search').value;
        quickRequest('showGAView', 'index.php?module=' + module + '&action=gs&record=' + recordID + '&q=' +  encodeURIComponent(q), function(id,data){
            var dcgscontent = Y.one('#dcgscontent');
            dcgscontent.set('innerHTML', data.responseText);
            var animDCcont = new Y.Anim({ node: dcgscontent, to: { height:500 } });
            animDCcont.run();
        });

        //Slide down dccontent if the height isn't full so things align nicely.
        var animDCcont = new Y.Anim({ node: '#dccontent', to: { height: 500 } });
        animDCcont.set('duration', 0.5);
        animDCcont.set('easing', Y.Easing.easeOut);
        animDCcont.run();

        var qvDepth = 'sqv';

        if(typeof(overlays[qvDepth]) == 'undefined')
        {
            overlays[qvDepth] = new Y.Overlay({
                bodyContent:'',
                zIndex:100,
                height:500,
                width:320,
                shim:false,
                visibility:true
            });
        }
        else
        {
            var dcgscontent = Y.one('#dcgscontent');
            dcgscontent.set('innerHTML', '<div style="height:400px;width:300px;"><img src="themes/default/images/img_loading.gif"/></div>');
            if(! overlays[qvDepth].visible )
            {
                overlays[qvDepth].show();
            }
            return;
        }

        content = '<div id="dcboxbodyqv" class="sugar_spot_search" style="position: fixed;"><div class="dashletPanel dc"><div class="hd"><div><a id="dcmenu_close_link" href="javascript:DCMenu.closeQView()"><i class="icon-remove icon-sm"></i></a></div></div><div class="bd"><div class="bd-center"><div class="dccontent" id="dcgscontent"><br><div style="height:400px;width:300px;"><img src="themes/default/images/img_loading.gif"/><br></div></div></div></div><div class="ft"><div class="bl"></div><div class="ft-center"></div><div class="br"></div></div></div></div></div></div></div></div></div>';

        overlays[qvDepth].set("bodyContent", content);
        overlays[qvDepth].set("align", {node:"#dcboxbody",
                      points:[Y.WidgetPositionExt.TR, Y.WidgetPositionExt.TR]});

        overlays[qvDepth].visible = true;

        overlays[qvDepth].show = function()
        {
            this.visible = true;
            //Hack until the YUI 3 overlay classes no longer conflicts with the YUI 2 overlay css
            //this.get('boundingBox').setStyle('position' , 'absolute');
            this.get('boundingBox').setStyle('visibility','visible');
            //Animate a slide out
            var shim = 10; //TODO: grab padding from parent element.
            var animX = this.get("x") - this.get("width") - shim;
            var animY = this.get("y");
        	var animDCcont = new Y.Anim({ node: this.get("boundingBox"), to: { xy:[animX,animY],height:500 } });
            animDCcont.set('duration', .5);
            animDCcont.set('easing', Y.Easing.easeOut);
            animDCcont.run();
    	}
    	overlays[qvDepth].after('render', function(e) { this.show(); });
        overlays[qvDepth].render();
    }

    DCMenu.showQuickView = function(module, recordID)
    {
        var qvDepth = 'sqv';
        var boxBody = Y.one('#SpotResults');
        if(typeof(overlays[qvDepth]) == 'undefined')
        {
            overlays[qvDepth] = new Y.Overlay({
                bodyContent:'',
                zIndex:100,
                height:boxBody._node.clientHeight,
                width:320,
                shim:false,
                visibility:true
            });
        }

        var q = document.getElementById('sugar_spot_search').value;
        url = 'index.php?module=' + module + '&action=gs&record=' + recordID + '&q=' +  encodeURIComponent(q);
        quickRequest('showGAView', 'index.php?module=' + module + '&action=gs&record=' + recordID + '&q=' +  encodeURIComponent(q), function(id,data)
        {

            var content = '<div id="dcboxbodyqv" class="sugar_spot_search" style="position: fixed;">';
            content += '<div class="dashletPanel dc"><div class="hd">';
            if(SUGAR.themes.theme_name == 'RTL')
            {
                content += '<div><div style="float:right"><a id="dcmenu_close_link" href="javascript:DCMenu.closeQView()">';
                content += '<i class="icon-remove icon-sm"></i>';
                content += '</a></div></div></div><div class="tr"></div><div class="bd">';
            } else {
                content += '<div><a id="dcmenu_close_link" href="javascript:DCMenu.closeQView()">';
                content += '<i class="icon-remove icon-sm"></i>';
                content += '</a></div></div><div class="tr"></div><div class="bd">';
            }
            content += '<div><div class="dccontent" id="dcgscontent">' +  data.responseText;
            content += '</div></div></div>';
            content += '</div></div></div></div></div></div></div></div>';
      
            overlays[qvDepth].set("bodyContent", content);
            overlays[qvDepth].set("align", {node:"#SpotResults", points:[Y.WidgetPositionAlign.TR, Y.WidgetPositionAlign.TR]});
            overlays[qvDepth].visible = true;
            overlays[qvDepth].show = function()
            {
                this.visible = true;
                this.get('boundingBox').setStyle('visibility','visible');
                //Animate a slide out
                var spotLeft = $("#sugar_spot_search_results").offset().left;
                var spotWidth = $("#sugar_spot_search_results").width();
                var shim = 35;  //The padding of the dashletPanel border
                var animX = (SUGAR.themes.theme_name == 'RTL') ? spotLeft + spotWidth + shim + 5: spotLeft - this.get("width") - shim;
                var animY = 42;
                var animDCcont = new Y.Anim({ node: this.get("boundingBox"), to: { xy:[animX,animY]} });
                animDCcont.set('duration', .25);
                animDCcont.set('easing', Y.Easing.easeOut);
                animDCcont.run();
            }

            //var dcgscontent = Y.one('#dcgscontent');
            //dcgscontent.set('innerHTML', data.responseText);
            
            overlays[qvDepth].after('render', function(e) { this.show(); });
            overlays[qvDepth].render();


            //var animDCcont = new Y.Anim({ node: dcgscontent, to: { height:500 } });
            //animDCcont.run();
        });

        //Slide down dccontent if the height isn't full so things align nicely.
        /*
        var animDCcont = new Y.Anim({ node: '#dccontent', to: { height: 500 } });
        animDCcont.set('duration', 0.5);
        animDCcont.set('easing', Y.Easing.easeOut);
        animDCcont.run();
        */

    }
});
