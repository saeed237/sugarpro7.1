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
<!--end body panes-->
{if $use_table_container}
</td>
</tr>
</table>
{/if}
</div>
<div class="clear"></div>
</div>
<div id="bottomLinks">
{if $AUTHENTICATED}
{$BOTTOMLINKS}
{/if}
</div>

<div class="clear"></div>
<div id="arrow" title="Show" class="up"><i class="icon-chevron-down"></i></div>
<div id="footer">
{if $COMPANY_LOGO_URL}
    <img src="{$COMPANY_LOGO_URL}" class="logo" id="logo" title="{$STATISTICS}" border="0"/>
{/if}
    <div id="buffer"></div>
{if $HELP_LINK}
    <div id="help" class="help">{$HELP_LINK}</div>
{/if}
    <div id="partner">
        <div id="integrations">
        {foreach from=$DYNAMICDCACTIONS item=action}
                {$action.script} {$action.image}
            {/foreach}
        </div>
    </div>
{if $AUTHENTICATED}
    <div id="productTour">
        {$TOUR_LINK}
    </div>
{/if}
    <a href="http://www.sugarcrm.com" target="_blank" class="copyright">&#169; 2013 SugarCRM Inc.</a>
    <script>
        var logoStats = "&#169; 2004-2013 SugarCRM Inc. All Rights Reserved. {$STATISTICS|addslashes}";
    </script>

{literal}


    <div class="clear"></div>
</div>
<script>
// TODO no more tours and DCMenu or quick edits :)
//    $("#productTour").click(function(){
//
//        if($('#tour').length > 0){
//            $('#tour').modal("show");
//        }  else {
//            SUGAR.tour.init({
//                id: 'tour',
//                modals: modals,
//                modalUrl: "index.php?module=Home&action=tour&to_pdf=1",
//                prefUrl: "index.php?module=Users&action=UpdateTourStatus&to_pdf=true&viewed=true",
//                className: 'whatsnew',
//                onTourFinish: function() {}
//            });
//        }
//    });
//    //qe_init function sets listeners to click event on elements of 'quickEdit' class
//    if(typeof(DCMenu) !='undefined'){
//        DCMenu.qe_refresh = false;
//        DCMenu.qe_handle;
//    }
//    function qe_init(){
//
//        //do not process if YUI is undefined
//        if(typeof(YUI)=='undefined' || typeof(DCMenu) == 'undefined'){
//            return;
//        }
//
//
//        //remove all existing listeners.  This will prevent adding multiple listeners per element and firing multiple events per click
//        if(typeof(DCMenu.qe_handle) !='undefined'){
//            DCMenu.qe_handle.detach();
//        }
//
//        //set listeners on click event, and define function to call
//        YUI().use('node', function(Y) {
//            var qe = Y.all('.quickEdit');
//            var refreshDashletID;
//            var refreshListID;
//
//            //store event listener handle for future use, and define function to call on click event
//            DCMenu.qe_handle = qe.on('click', function(e) {
//                //function will flash message, and retrieve data from element to pass on to DC.miniEditView function
//                ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_LOADING'),800);
//                e.preventDefault();
//                if(typeof(e.currentTarget.getAttribute('data-dashlet-id'))!='undefined'){
//                    refreshDashletID = e.currentTarget.getAttribute('data-dashlet-id');
//                }
//                if(typeof(e.currentTarget.getAttribute('data-list'))!='undefined'){
//                    refreshListID = e.currentTarget.getAttribute('data-list');
//                }
//                DCMenu.miniEditView(e.currentTarget.getAttribute('data-module'), e.currentTarget.getAttribute('data-record'),refreshListID,refreshDashletID);
//            });
//
//        });
//    }
//
//    qe_init();
//
//
//    SUGAR_callsInProgress++;
//    SUGAR._ajax_hist_loaded = true;
//    if(SUGAR.ajaxUI)
//        YAHOO.util.Event.onContentReady('ajaxUI-history-field', SUGAR.ajaxUI.firstLoad);
</script>
{/literal}
</body>
</html>

