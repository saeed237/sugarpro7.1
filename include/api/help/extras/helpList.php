<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


/**
 * This file is here to provide a HTML template for the rest help api.
 */

$theme = new SidecarTheme();

$bootstrap_css = $theme->getCSSURL();

?>

<!DOCTYPE HTML>
<html>

    <head>
        <title>SugarCRM Auto Generated API Help</title>
        <?php
        foreach($bootstrap_css as $css) {
            echo '<link rel="stylesheet" href="../../' . $css . '">';
        }
        ?>
        <style>

            body {
                padding: 5px;
            }

            .container-fluid div{
                background-color: @NavigationBar;
            }

            .line{
                border-bottom: 1px solid black;
            }

            .score{
                text-align: right;
            }

            .pre-scrollable {
                width: 600px;
                background-color: white;
                color: red;
            }

            .table {

                background-color: white;
            }

            .table td {
                white-space: normal;
                word-wrap: break-word;
            }

            h2{
                padding-top: 30px;
            }

            .well-small {
                background-color: white;
            }

            .alert {
                padding: 20px;
                text-align: center;
            }

        </style>

        <script type="text/javascript" src="../../cache/include/javascript/sugar_grp1_jquery.js"></script>
        <script type="text/javascript" src="../../cache/include/javascript/sugar_grp1_bootstrap_core.js"></script>
    </head>

    <body>

        <h2>SugarCRM API</h2>

        <div class="container-fluid">

            <div class="row-fluid">

                <div class="span1"><h1>Type</h1></div>
                <div class="span4"><h1>Endpoint</h1></div>
                <div class="span2"><h1>Method</h1></div>
                <div class="span4"><h1>Description</h1></div>
                <div class="span1 score"><h1>Score</h1></div>
            </div>

        <?php
            foreach ( $endpointList as $i => $endpoint )
            {
                if ( empty($endpoint['shortHelp']) ) { continue; }
        ?>

            <div class="row-fluid line">

                <div class="row-fluid">

                    <div class="span1">
                            <?php echo htmlspecialchars($endpoint['reqType']) ?>
                    </div>

                    <div class="span4">

                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#endpoint_<?php echo $i ?>_full">
                            <?php echo htmlspecialchars($endpoint['fullPath']) ?>
                        </button>
                    </div>

                    <div class="span2">

                        <?php echo $endpoint['method']; ?>
                    </div>

                    <div class="span4">
                        <?php echo htmlspecialchars($endpoint['shortHelp']) ?>
                    </div>

                    <div class="span1 score">
                        <?php echo sprintf("%.02f",$endpoint['score']) ?>
                    </div>

                </div>

                <div id="endpoint_<?php echo $i ?>_full" class="row-fluid collapse">
                    <div class="span12 well">

                        <?php

                            if ( file_exists($endpoint['longHelp']) )
                            {
                                echo file_get_contents($endpoint['longHelp']);
                            }
                            else
                            {
                                echo '<span class="lead">No additional help.</span>';
                            }

                        ?>

                        <div class="pull-right muted">
                            <i class="icon-file"></i>
                            <?php echo "./" . htmlspecialchars($endpoint['longHelp']); ?>
                        </div>

                    </div>

                    <div class="pull-right">
                        <i class="icon-file"></i>
                        <?php echo "./" . htmlspecialchars($endpoint['file']); ?>
                    </div>
                </div>

            </div>

        <?php
            }
        ?>

        </div>

    </body>
</html>
