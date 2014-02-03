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

<!DOCTYPE HTML>
<html class="no-js">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <title>SugarCRM</title>
        <link rel="icon" href="themes/default/images/sugar_icon.ico">
        <!-- CSS -->
        {foreach from=$css_url item=url}
            <link rel="stylesheet" href="{$url}"/>
        {/foreach}
        <!--[if lt IE 10]>
        <link rel="stylesheet" type="text/css" href="themes/default/css/ie.css">
        <![endif]-->
        {sugar_getscript file="include/javascript/modernizr.js"}
    </head>
    <body>
        <div id="sugarcrm">
            <div id="sidecar">
                <div id="alerts" class="alert-top">
                    <div class="alert alert-process">
                        <strong>{$LBL_LOADING}</strong>
                        <div class="loading">
                            <span class="l1"></span><span class="l2"></span><span class="l3"></span>
                        </div>
                    </div>
                </div>
                <div id="header"></div>
                <div id="content"></div>
                <div id="drawers"></div>
                <div id="footer"></div>
                <div id="tourguide"></div>
            </div>
        </div>
        <!-- App Scripts -->
        {if !empty($developerMode)}
            {sugar_getscript file="sidecar/minified/sidecar.js"}
        {else}
            {sugar_getscript file="sidecar/minified/sidecar.min.js"}
        {/if}
        <script src='{$sugarSidecarPath}'></script>
        <script src='{$SLFunctionsPath}'></script>
        <!-- <script src='sidecar/minified/sugar.min.js'></script> -->
        <script src='{$configFile}?hash={$configHash}'></script>
        {sugar_getscript file="include/javascript/jquery/jquery.dataTables.min.js"}

        {sugar_getscript file="include/javascript/sugar7.js"}
        {sugar_getscript file="include/javascript/sugar7/bwc.js"}
        {sugar_getscript file="include/javascript/sugar7/utils.js"}
        {sugar_getscript file="include/javascript/sugar7/field.js"}
        {sugar_getscript file="include/javascript/sugar7/hacks.js"}
        {sugar_getscript file="include/javascript/sugar7/alert.js"}
        {sugar_getscript file="include/javascript/sugar7/hbs-helpers.js"}
        {literal}
        <script language="javascript">
            if (parent.window != window && typeof(parent.SUGAR.App.router) != "undefined") {
                parent.SUGAR.App.router.navigate("#Home", {trigger:true});
            } else {
                var App;
                {/literal}{if $authorization}
                SUGAR.App.cache.set("{$appPrefix}AuthAccessToken", "{$authorization.access_token}")
                {if $authorization.refresh_token}
                SUGAR.App.cache.set("{$appPrefix}AuthRefreshToken", "{$authorization.refresh_token}")
                {/if}
                history.replaceState(null, 'SugarCRM', window.SUGAR.App.config.siteUrl+"/"+window.location.hash)
                {/if}{literal}
                App = SUGAR.App.init({
                    el: "#sidecar",
                    callback: function(app){
                        $('#alerts').empty();
                        app.start();
                    }
                });
                App.api.debug = App.config.debugSugarApi;
            }
        </script>
        {/literal}

        {if !empty($voodooFile)}
            <script src="{$voodooFile}"></script>
        {/if}
    </body>
</html>
