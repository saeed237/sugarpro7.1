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

({
    className: 'headerpane',
    pageData: {},
    section: {},
    page: {},
    section_page: false,
    parent_link: '',
    file: '',
    keys: [],

    initialize: function(options) {
        var self = this,
            keys = [];

        app.view.View.prototype.initialize.call(this, options);

        this.pageData = options.meta.page_data;

        this.file = this.context.get('page_name');
        if (this.file && this.file !== '') {
            keys = this.file.split('_');
        }
        this.keys = keys;

        if (keys.length) {
            // get page content variables from pageData (defined in view/docs.php)
            if (keys[0] === 'index') {
                if (keys.length > 1) {
                    // section index call
                    this.section = this.pageData[keys[1]];
                } else {
                    // master index call
                    this.section = this.pageData[keys[0]];
                    //this.index_search = true;
                }
                this.section_page = true;
                this.file = 'index';
            } else if (keys.length > 1) {
                // section page call
                this.section = this.pageData[keys[0]];
                this.page = this.section.pages[keys[1]];
                this.parent_link = '_' + keys[0];
            } else {
                // general page call
                this.section = this.pageData[keys[0]];
            }
        }
    },

    _render: function() {
        var self = this,
            $find;

        // render view
        app.view.View.prototype._render.call(this);

        // styleguide guide doc search
        $find = $('#find_patterns');

        if ($find.length)
        {
            // build search select2 options
            var $optgroup;

            $.each(this.pageData, function (k,v) {
                if ( !v.index ) return;
                $optgroup = $('<optgroup>').appendTo($find).attr('label',v.title);
                $.each(v.pages, function (i,d) {
                    renderSearchOption(k, i, d, $optgroup);
                });
            });

            // search for patterns
            $find.on('change', function (e) {
                window.location.href = $(this).val();
            });

            $find.select2();
        }

        function renderSearchOption(section, page, d, optgroup) {
            $('<option>')
                .appendTo(optgroup)
                .attr('value', (d.url ? d.url : fmtLink(section, page)) )
                .text(d.label);
        }

        function fmtLink(section, page) {
            return '#Styleguide/docs/' +
                (page?'':'index_') + section.replace(/[\s\,]+/g,'-').toLowerCase() + (page?'_'+page:'');
        }
    },

})
