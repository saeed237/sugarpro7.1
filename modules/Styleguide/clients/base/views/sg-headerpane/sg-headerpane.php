<?php

/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

$viewdefs['Styleguide']['base']['view']['sg-headerpane'] = array(
    'template_values' => array(
        'last_updated' => '2013-05-06T22:47:00+00:00',
        'version' => '7.0.1',
    ),

    'page_data' => array (
        "home" => array (
            "title" => "Styleguide",
            "description" => "Major components of Styleguide.",
            "index" => false,
        ),
        "index" => array (
            "title" => "Core Elements",
            "description" => "Simple and flexible HTML, CSS, and Javascript for popular user interface components and interactions.",
            "index" => false,
        ),
        "field" => array (
            "title" => "Example Sugar7 Fields",
            "description" => "Basic fields that support detail, record, and edit modes with error addons.",
            "index" => false,
        ),
        "base" => array (
            "title" => "Base CSS",
            "description" => "Basic HTML elements styled and enhanced with extensible classes for a fresh, consistent look and feel.",
            "index" => true,
            "pages" => array (
                "typography" => array("label"=>"Typography", "description"=>"Headings, paragraphs, lists, and other inline type elements."),
                "grid" => array("label"=>"Grid system", "description"=>"A responsive 12-column grid including fixed- and fluid-width layouts based on that system."),
                "icons" => array("label"=>"Icons", "description"=>"Font Awesome icon library for scalable font based icons and glyphs for a full array of web-related actions."),
                "mixins" => array("label"=>"Mixins", "description"=>"Include or generate snippets of CSS with parameters."),
                "responsive" => array("label"=>"Responsive design", "description"=>"Media queries for various devices and resolutions."),
                "variables" => array("label"=>"Variables", "description"=>"LESS variables, HTML values, and usage guidelines."),
                "labels" => array("label"=>"Labels", "description"=>"Label and annotate text."),
                "edit" => array("label"=>"Edit Documentation", "description"=>"Instructions for updating Styleguide documentation."),
            )
        ),
        "forms" => array (
            "title" => "Form Elements",
            "description" => "Basic form elements and layouts for a consistent editing experience.",
            "index" => true,
            "pages" => array (
                "fields" => array("label"=>"Sugar7 fields", "url"=>"#Styleguide/field/all", "description"=>"Basic fields that support detail, record, and edit modes with error addons."),
                "buttons" => array("label"=>"Buttons", "description"=>"Standard css only button styles."),
                "editable" => array("label"=>"Editable", "description"=>"Inline form edit inputs."),
                "layouts" => array("label"=>"Form layouts", "description"=>"Customized layouts of field components."),
                "file" => array("label"=>"File uploader", "description"=>"Avatar file upload widget."),
                "datetime" => array("label"=>"Date-time picker", "description"=>"Lightweight date/time picker."),
                "select2" => array("label"=>"Select2", "description"=>"jQuery plugin replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results."),
                "jstree" => array("label"=>"jsTree", "description"=>"jQuery plugin cross browser tree component."),
                "range" => array("label"=>"Range Slider", "description"=>"jQuery plugin range picker."),
                "switch" => array("label"=>"Switch", "description"=>"jQuerty plugin turns check boxes into toggle switch."),
            )
        ),
        "components" => array (
            "title" => "Components",
            "description" => "Dozens of reusable components are built in to provide navigation, alerts, popovers, and much more.",
            "index" => true,
            "pages" => array (
                "alerts" => array("label"=>"Alerts", "description"=>"Styles for success, warning, and error messages."),
                "collapse" => array("label"=>"Collapse", "description"=>"Get base styles and flexible support for collapsible components like accordions and navigation."),
                "dropdowns" => array("label"=>"Dropdowns", "description"=>"Add dropdown menus to nearly anything with this simple plugin. Features full dropdown menu support on in the navbar, tabs, and pills."),
                "popovers" => array("label"=>"Popovers", "description"=>"Add small overlays of content, like those on the iPad, to any element for housing secondary information."),
                "progress" => array("label"=>"Progress bars", "description"=>"For loading, redirecting, or action status."),
                "tooltips" => array("label"=>"Tooltips", "description"=>"A new take on the jQuery Tipsy plugin, Tooltips don't rely on images, uss CSS3 for animations, and data-attributes for local title storage."),
            )
        ),
        "layouts" => array (
            "title" => "Layouts & Views",
            "description" => "Modals, navbars, and other layout widgets.",
            "index" => true,
            "pages" => array (
                "list" => array("label"=>"List Tables", "description"=>"For, you guessed it, tabular data."),
                "record" => array("label"=>"Record Views", "description"=>"Detail, edit and create views for records."),
                "drawer" => array("label"=>"Drawers", "description"=>"Drawer is a form of a modal that pushes main content down and expands from the top taking 100% of the screen width."),
                "navbar" => array("label"=>"Navbar", "description"=>"Top level navigation layout."),
                "tabs" => array("label"=>"Tab Navigation", "description"=>"Use this plugin to make tabs and pills more useful by allowing them to toggle through tabbable panes of local content."),
                "modals" => array("label"=>"Modals", "description"=>"A streamlined, but flexible, take on the traditional javascript modal plugin with only the minimum required functionality and smart defaults."),
                "wizard" => array("label"=>"Wizard", "description"=>"Wizard takes advantage of bootstrap modals and sets up a framework for taking a user through multiple steps to complete a task."),
                //"thumbnails" => array("label"=>"Thumbnails", "description"=>"Grids of images, videos, text, and more."),
                //"scrollspy" => array("label"=>"Scrollspy", "description"=>"Use scrollspy to automatically update the links in your navbar to show the current active link based on scroll position."),
                //"carousel" => array("label"=>"Carousel", "description"=>"Create a merry-go-round of any content you wish to provide an interactive slideshow of content."),
                //"typeahead" => array("label"=>"Typeahead", "description"=>"A basic, easily extended plugin for quickly creating elegant typeaheads with any form text input."),
                //"transitions" => array("label"=>"Transitions", "description"=>"For simple transition effects, include bootstrap-transition.js once to slide in modals or fade out alerts."),
          )
        ),
        "charts" => array (
            "title" => "Charting",
            "description" => "Standard and custom SVG charts for Sugar7 using the D3 library and the NVD3 framework.",
            "index" => true,
            "pages" => array (
                "circular" => array("label"=>"Circular", "description"=>"Used for comparing parts to a whole."),
                "line" => array("label"=>"Line", "description"=>"Used for comparing data series."),
                "horizontal" => array("label"=>"Horizontal Bar", "description"=>"Used for comparing many values in a single series."),
                "vertical" => array("label"=>"Vertical Bar", "description"=>"Used for comparing multiple series with a few values."),
                "custom" => array("label"=>"Custom", "description"=>"Used for comparing values in a process."),
                "implementation" => array("label"=>"Implementation", "description"=>"Patterns for inserting and configuring charts."),
                "colors" => array("label"=>"Colors", "description"=>"Flexible methods for assigning color maps and fill methods to D3 charts."),
            )
        ),
    ),
);
