<?php
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

 //Sidecar Lite: no jQuery
$buildFiles = array(
    'sidecar.lite' => array(
        # The real deal
        'lib/sugarapi/sugarapi.js',
        'src/app.js',
        'src/utils/utils.js',
        'src/utils/date.js',
        'src/utils/file.js',
        'src/utils/math.js',
        'src/utils/currency.js',
        'src/core/cache.js',
        'src/core/events.js',
        'src/core/before-event.js',
        'src/core/error.js',
        'src/view/template.js',
        'src/core/context.js',
        'src/core/controller.js',
        'src/core/router.js',
        'src/core/language.js',
        'src/core/metadata-manager.js',
        'src/core/acl.js',
        'src/core/user.js',
        'src/core/plugin-manager.js',
        'src/utils/logger.js',
        'src/data/bean.js',
        'src/data/bean-collection.js',
        'src/data/mixed-bean-collection.js',
        'src/data/data-manager.js',
        'src/data/validation.js',
        'src/view/hbs-helpers.js',
        'src/view/view-manager.js',
        'src/view/component.js',
        'src/view/view.js',
        'src/view/field.js',
        'src/view/layout.js',
        'src/view/alert.js',
        'src/view/tutorial.js',
        'lib/sugar/sugar.searchahead.js',
        'lib/sugar/sugar.timeago.js',
        'lib/sugar/sugar.ajaxcallInprogress.js',
    ),
);

//full sidecar stub
$buildFiles['sidecar'] = array(
        # Libraries
        'lib/handlebars/handlebars.js',
        'lib/jquery/jquery.min.js',
        'lib/jquery-ui/js/jquery-ui-1.8.18.custom.min.js',
        'lib/backbone/underscore.js',
        'lib/backbone/backbone.js',
        'lib/stash/stash.js',
        'lib/async/async.js',
        'lib/jquery/jquery.iframe.transport.js',
        'lib/jquery/jquery.tinymce.js',
        'lib/php-js/version_compare.js',
        );

//combine the two to build out the full Sidecar.js
$buildFiles['sidecar'] = array_merge($buildFiles['sidecar'], $buildFiles['sidecar.lite']);
