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

<div id="tourStart">
    <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>{$APP.LBL_TOUR_WELCOME}</h3>
    </div>
    
	<div class="modal-body" {if $view_calendar_url}style="overflow: auto;"{/if}>
        <div style="float: left;">
            <div style="float: left; width: 300px;">
				{$APP.LBL_TOUR_FEATURES_670}
				<p>{$APP.LBL_TOUR_VISIT} <a href="javascript:void window.open('http://support.sugarcrm.com/02_Documentation/01_Sugar_Editions/{$appList.documentation.$sugarFlavor}')">{$APP.LNK_TOUR_DOCUMENTATION}</a>.</p>

                {if $view_calendar_url}
                <div style="border-top: 1px solid #F5F5F5;padding-top: 3px;" >
                    <p>{$view_calendar_url}</p>
                </div>
                {/if}

            </div>
            <div class="well" style="float: left; width: 220px; margin-left: 20px;"><img src="themes/default/images/pt-screen0-thumb.png" width="220" id="thumbnail_0" class="thumb"></div>
        </div>
        </div>
        <div class="clear"></div>
    <div class="modal-footer">
    <a href="#" class="btn btn-primary">{$APP.LBL_TOUR_TAKE_TOUR}</a>
    <a href="#" class="btn btn-invisible">{$APP.LBL_TOUR_SKIP}</a>
    </div>
</div>
<div id="tourEnd" style="display: none;">
    <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>{$APP.LBL_TOUR_DONE}</h3>
    </div>
    
	<div class="modal-body">
		<div style="float: left;"> 
			<div style="float: left; width: 360px; margin-right: 50px;">
			<p>
			{$APP.LBL_TOUR_REFERENCE_1} <a href="javascript:void window.open('http://support.sugarcrm.com/02_Documentation/01_Sugar_Editions/{$appList.documentation.$sugarFlavor}')">{$APP.LNK_TOUR_DOCUMENTATION}</a> {$APP.LBL_TOUR_REFERENCE_2}
<br>
				<i class="icon-arrow-right icon-lg" style="float: right; position: relative; right: -33px; top: -30px;"></i>
			</p>
			</div>
			<div style="float: left">
				<img src="themes/default/images/pt-profile-link.png" width="152" height="221">
			</div>
		</div>
	</div>
    <div class="clear"></div>
    
    <div class="modal-footer">
    <a href="#" class="btn btn-primary">{$APP.LBL_TOUR_BTN_DONE}</a>
    <a href="#" class="btn">{$APP.LBL_TOUR_BACK}</a>

    </div>
</div>

<script type="text/javascript">
    {literal}
    $('#thumbnail_0').live("click", function(){
        $("#tour_screenshot .modal-header h3").html("{/literal}{$APP.LBL_TOUR_WELCOME}{literal}");
        $("#tour_screenshot .modal-body").html("<img src='themes/default/images/pt-screen0-full.png' width='600'>");
        $("#tour_screenshot").modal("show");
    });
    {/literal}
</script>