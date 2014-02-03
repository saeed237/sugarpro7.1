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

(function(app) {

    /*
        Overlays a tutorial.

        // module parameters
        version: Module tutorial version. Increment value to show new data to those who have seen it.
        scroll: (optional) Element that is scrollable.
        intro: (optional) Text shown at the beginning of the tutorial.
        content: Tutorial content. See content parameters below.

        // content parameters
        name: (optional) CSS selector of the element to highlight. If no element found, content will be skipped. If no name, text will be shown without highlighting an element.
        text: Tutorial text for that element.
        horizAdj: (optional) Adjust the highlight position horizontally, negative values are acceptable.
        vertAdj: (optional) Adjust the highlight position vertically, negative values are acceptable.
        glow: (optional) Show spotlight behind the highlight, defaults to true.

        // Sample Data

        app.tutorial.data = {
            "home": {
                "version": 1,
                "scroll": ".list-layout",
                "intro": "Welcome to SugarCRM.<br/><br/> Allow us to highlight some new features...",
                "content":[{
                        "name": "#logo",
                        "text": "Yum! Sugar Cube!"
                    },
                    {
                        "name": "#create",
                        "text": "Create from the Plus!"
                    },
                    {
                        "name": "#blahblah",
                        "text": "This missing element will be skipped."
                    },
                    {
                        "name": ".grip",
                        "text": "Slide grip to get more detailed options",
                        "horizAdj": 5,
                        "vertAdj": 10,
                        "glow": false
                    },
                    {
                        "text": "Explain new features!"
                    },
                    {
                        "name": "#bucket-Upcoming .bucket-header",
                        "text": "Upcoming Items go here",
                        "full": true
                    },
                    {
                        "name": "#bucket-Recent .bucket-header",
                        "text": "Recent Items go here",
                        "horizAdj": 8,
                        "vertAdj": -5
                    },
                    {
                        "text": "Enjoy all the new features!"
                    }]
            },
            "detail": {
                "version": 1,
                    content: [{
                    "text": "Welcome to your detail view!"
                }]
            },
            "edit": {
                "version": 1,
                    content: [{
                    "text": "Welcome to your edit view!"
                }]
            },
            "home-menu": {
                "version": 1,
                    content: [{
                    "text": "Welcome to your home menu!"
                }]
            },
            "plus-menu": {
                "version": 1,
                    content: [{
                    "text": "Welcome to your plus menu!"
                }]
            }
        }
    */
    var animationSpeed = 500; // in milliseconds
    var scrollOffset = 25; // amount of padding to have between the top of the scrollable area and the item when we scroll to it
    var scrollViewReduction = 75; // reduce the calculated viewed area, used if you want to have a padding at the bottom of the viewed area for controls

    app.augment("tutorial", {
        instance: null,
        /**
         * Test if a layout for the given module has a Tutorial associated with it.  By default, this will check if the
         * layout associated with the default context has a Tutorial.
         *
         * @param {String} layout (optional) layout name to check
         * @param {String} module (optional) module name to check
         * @returns {boolean} TRUE if a tutorial exists for this layout
         */
        hasTutorial: function(layout, module) {
            if(_.isUndefined(module)) module = app.controller.context.get('module');
            if(_.isUndefined(layout)) layout = app.controller.context.get('layout');

            var meta = app.metadata.getModule(module);
            //Cache default tutorial metadata
            var defaultMeta = app.metadata.getView('','tutorial');
            if (defaultMeta) {
                this.data = defaultMeta;
            }
            if (meta && meta.views && meta.views.tutorial && meta.views.tutorial.meta && meta.views.tutorial.meta[layout]) {
                return true;
            } else if (this.data && this.data[layout]) {
                return true;
            } else {
                return false;
            }
        },
        show: function (name, params) {
            if (app.config.skipTutorial) {
                return;
            }
            else if (app.tutorial.data) {
                this.doTutorial(name, params);
            }
            else if (app.metadata.getView('','tutorial')) {
                //Cache default tutorial metadata
                app.tutorial.data = app.metadata.getView('','tutorial');
                this.doTutorial(name, params);
            }
            else {
                var self = this;
                $.getJSON(app.config.tutorualURL || 'tutorial.json', function(data) {
                    app.tutorial.data = data;
                    self.doTutorial(name, params);
                });
            }
        },
        doTutorial: function(name, params) {
            var tutorialData = app.tutorial.data[name];
            var prefKey = name;
            // check for module specific tutorial data
            if (params && params.module) {
                var meta = app.metadata.getModule(params.module);
                if (meta.views && meta.views.tutorial && meta.views.tutorial.meta && meta.views.tutorial.meta[name]) {
                    tutorialData = meta.views.tutorial.meta[name];
                    prefKey = name+params.module;
                }
            }

            var prefs = this.getPrefs();
            if (tutorialData &&
                (!prefs.skipVersion[prefKey] || prefs.skipVersion[prefKey] < tutorialData.version) &&
                (!prefs.viewedVersion[prefKey] || prefs.viewedVersion[prefKey] < tutorialData.version)) {
                if (app.view.views.TutorialView) {
                    (new app.view.views.TutorialView(tutorialData)).show();
                } else  {
                    (new app.view.TutorialView(tutorialData)).show();
                }

                prefs.viewedVersion[prefKey] = tutorialData.version;
                app.cache.set("tutorialPrefs", prefs);
                //app.user.setPreference("tutorialPrefs", prefs);
            }
        },
        getPrefs: function() {
            var prefs = app.cache.get("tutorialPrefs") || {};
            //var prefs = app.user.getPreference("tutorialPrefs") || {};
            prefs.viewedVersion = prefs.viewedVersion || {};
            prefs.skipVersion = prefs.skipVersion || {};
            return prefs;
        },
        resetPrefs: function(prefs) {
            prefs = prefs || {};
            prefs.viewedVersion = {};
            prefs.skipVersion = {};
            app.cache.set("tutorialPrefs", prefs);
            //app.user.setPreference("tutorialPrefs", prefs);
        },
        // Skip all tutorials for this version
        skipTutorial: function() {
            var prefs = this.getPrefs();
            _.each(app.tutorial.data, function(data, name) {
                prefs.skipVersion[name] = app.tutorial.data[name].version;
            });
            app.user.setPreference("tutorialPrefs", prefs);
        }
    });
    app.view.TutorialView = app.view.View.extend({

        events: {
            "click .btn.disabled": function(e) {return false;},
            "click .back-btn:not(.disabled)":   "back",
            "click .next-btn:not(.disabled)":   "next",
            "click .done-btn":                  "hide",
            'swipeLeft':                        "onSwipeLeft"
        },

        initialize: function(options) {
            options = _.extend({
            }, options || {});

            this.index = 0;
            this.setIntro(options.intro);
            this.setContent(options.content);
            this.setScroll(options.scroll);
        },

        setContent: function(content) {
            this.content = content;
        },

        setIntro: function(intro) {
            this.intro = intro;
        },

        setScroll: function(scroll) {
            this.scroll = scroll;
        },

        reset: function() {
            this.index = 0;
        },

        onSwipeLeft: function(e) {
            app.tutorial.skipTutorial();
            this.hide(e);
        },

        show: function(options) {
            options = _.extend({
            }, options || {});
            if(options.content) this.setContent(options.content);
            if(options.intro) this.setIntro(options.intro);
            if(options.scroll) this.setScroll(options.scroll);
            if(options.reset) this.reset();

            this.render();

            if (this.intro && !this.introShown) {
                this.index = -1;
                this.introShown = true;
                this.showMessageOnly(this.intro);
            } else {
                this.highlightItem(this.index);
            }
        },

        hide: function(e) {
            e.preventDefault();
            this.remove();
        },

        back: function(e) {
            e.preventDefault();
            this.highlightItem(this.index - 1);
        },

        next: function(e) {
            e.preventDefault();
            this.highlightItem(this.index + 1);
        },

        highlightItem: function(index) {
            var self = this;

            if (index < 0 || index >= this.content.length) {
                return;
            }

            var content = this.content[index];

            // If there is no name for an element, just show the text.
            if (!content.name) {
                this.showMessageOnly(content.text);
            }
            else {
                var item = $(content.name);


                // Skip any items that are not found
                var direction = this.index > index ? -1 : 1;
                if ((item.length === 0 || item.css("display") === "none")  || item.parents(".hide").length > 0) {
                    return this.highlightItem(index + direction);
                }

                var highlightCallback =  function() {
                    // If no existing highlight, create one
                    if (!this.highlight) {
                        this.highlight = $("<div/>");
                        this.highlight.attr("id", "highlight");

                        this.highlightText = $("<div/>");
                        this.highlightText.attr("id", "highlight-text");
                        this.highlight.html(this.highlightText);

                        $("#tutorial-content").html(this.highlight);
                    }

                    // Hide the text and glow since it doesn't make sense to animate (text), or can't be animated (glow)
                    this.highlightText.hide();
                    this.hideGlow();

                    // Move the highlight to the element
                    this.highlight.animate({
                        "top": item.offset().top + (content.vertAdj || 0),
                        "left": item.offset().left + (content.horizAdj || 0),
                        "width": content.full ? item.offset().width : "",
                        "height": content.full ? item.offset().height : ""
                    }, animationSpeed, "linear", function() {
                        // default to have glow effect
                        if (content.glow === undefined || content.glow !== false) self.showGlow();
                        self.showHighlightText(content.text);
                    });
                };
                highlightCallback = _.bind(highlightCallback, this);
                this.scrollToEl(item, highlightCallback);
            }

            // Update the state of the controls
            if (index <= 0) this.$el.find(".back-btn").addClass("disabled");
            else this.$el.find(".back-btn").removeClass("disabled");
            if (index >= (this.content.length - 1)) this.$el.find(".next-btn").addClass("disabled");
            else this.$el.find(".next-btn").removeClass("disabled");

            this.index = index;
        },

        showGlow: function() {
            this.$el.find('#mask').css("background-image", "-webkit-radial-gradient(" + (this.highlight.offset().left + (this.highlight.width()/2)) + "px " +
                (this.highlight.offset().top + (this.getTotalHeight(this.highlight)/2)) + "px , " +
                this.highlight.width() + "px " + this.highlight.height() + "px, transparent, black " + Math.max(this.highlight.width(), this.highlight.height()) + "px)");
            this.$el.find('#mask').css("background", "radial-gradient(circle closest-side at " + (this.highlight.offset().left + (this.highlight.width()/2)) + "px " +
                (this.highlight.offset().top + (this.getTotalHeight(this.highlight)/2)) + "px , " + " transparent 0%, black " + Math.max(this.highlight.width(), this.highlight.height()) + "px)");
            this.$el.find('#mask').css("background-color", "transparent");
        },

        hideGlow: function() {
            this.$el.find('#mask').css("background-color", "");
            this.$el.find('#mask').css("background-image", "");
        },

        showHighlightText: function(message) {
            var top;
            this.highlightText.html(app.lang.get(message, app.controller.context.get('module')));
            this.highlightText.show();

            //try left
            if (this.highlight.offset().left - this.getTotalWidth(this.highlightText) > 0 &&
                this.findIntersectors([this.highlight.offset().left - this.getTotalWidth(this.highlightText), this.highlight.offset().left],  // Check if we overlap controls, using left right positions
                    [this.highlight.offset().top + (this.getTotalHeight(this.highlight)/2) - (this.getTotalHeight(this.highlightText)/2), // and top bottom positions
                        this.highlight.offset().top + (this.getTotalHeight(this.highlight)/2) - (this.getTotalHeight(this.highlightText)/2) + this.getTotalHeight(this.highlightText)], '.btn-group').length === 0) {
                var highlightBorderOffset = parseInt(this.highlight.css("border-left-width"));
                this.highlightText.css("left", 0 - (this.getTotalWidth(this.highlightText) + highlightBorderOffset));
                top = (this.getTotalHeight(this.highlight)/2) - (this.getTotalHeight(this.highlightText)/2);
                this.highlightText.css("top", top >= 0 ? top : 0);
                this.highlightText.css("text-align", "right");
            }
            //try right
            else if (this.highlight.offset().left + this.getTotalWidth(this.highlight) + this.getTotalWidth(this.highlightText) < $(window).width() &&
                this.findIntersectors([this.highlight.offset().left + this.getTotalWidth(this.highlight), this.highlight.offset().left + this.getTotalWidth(this.highlight)+ this.getTotalWidth(this.highlightText)],  // Check if we overlap controls, left right positions
                    [this.highlight.offset().top + (this.getTotalHeight(this.highlight)/2) - (this.getTotalHeight(this.highlightText)/2), // and top bottom positions
                        this.highlight.offset().top + (this.getTotalHeight(this.highlight)/2) - (this.getTotalHeight(this.highlightText)/2) + this.getTotalHeight(this.highlightText)], '.btn-group').length === 0) { // try left) {
                var highlightBorderOffset = parseInt(this.highlight.css("border-right-width"));
                this.highlightText.css("left", this.getTotalWidth(this.highlight) + highlightBorderOffset);
                top = (this.getTotalHeight(this.highlight)/2) - (this.getTotalHeight(this.highlightText)/2);
                this.highlightText.css("top", top >= 0 ? top : 0);
                this.highlightText.css("text-align", "left");
            }
            else { // try below or above
                var newLeftVal = (this.getTotalWidth(this.highlight)/2) - (this.getTotalWidth(this.highlightText)/2);
                var leftEdge = this.highlight.offset().left + newLeftVal;
                newLeftVal = leftEdge < 0 ? 0 - this.highlight.offset().left : newLeftVal; // make sure we're not off the screen on the left
                var rightEdge = this.highlight.offset().left + newLeftVal + this.getTotalWidth(this.highlightText);
                newLeftVal = rightEdge > $(window).width() ? newLeftVal - (rightEdge - $(window).width()): newLeftVal; // make sure we're not off the screen on the right

                var newTopVal;
                // try below
                if (this.highlight.offset().top + this.getTotalHeight(this.highlight) + this.getTotalHeight(this.highlightText) < $(window).height() &&
                    this.findIntersectors([this.highlight.offset().left + newLeftVal, this.highlight.offset().left + newLeftVal + this.getTotalWidth(this.highlightText)],  // Check if we overlap controls, left right positions
                        [this.highlight.offset().top + this.getTotalHeight(this.highlight), // and top bottom positions
                            this.highlight.offset().top + this.getTotalHeight(this.highlight) + this.getTotalHeight(this.highlightText)], '.btn-group').length === 0) {
                    newTopVal = this.getTotalHeight(this.highlight);
                }
                else { // default to above
                    newTopVal = -5 - this.getTotalHeight(this.highlightText);
                }

                this.highlightText.css("left", newLeftVal);
                this.highlightText.css("top", newTopVal);
                this.highlightText.css("text-align", "center");
            }
        },

        findIntersectors: function(t_x, t_y, intersectorsSelector) {
            var intersectors = [], self = this;

            this.$el.find(intersectorsSelector).each(function() {
                var $this = $(this);
                var thisPos = $this.offset();
                var i_x = [thisPos.left, thisPos.left + self.getTotalWidth($this)];
                var i_y = [thisPos.top, thisPos.top + self.getTotalHeight($this)];

                if ( t_x[0] < i_x[1] && t_x[1] > i_x[0] &&
                    t_y[0] < i_y[1] && t_y[1] > i_y[0]) {
                    intersectors.push($this);
                }

            });
            return intersectors;
        },

        showMessageOnly: function(message) {
            $("#tutorial-content").html("<div class='text-container'><div class='text'>" + app.lang.get(message, app.controller.context.get('module')) + "</div></div>");
            this.highlight = null;
            this.hideGlow();
        },

        getTotalWidth: function(el) {
            var totalWidth = el.width();
            totalWidth += parseInt(el.css("padding-left"), 10) + parseInt(el.css("padding-right"), 10); //Total Padding Width
            totalWidth += parseInt(el.css("margin-left"), 10) + parseInt(el.css("margin-right"), 10); //Total Margin Width
            //totalWidth += parseInt(el.css("border-left-width"), 10) + parseInt(el.css("border-right-width"), 10); //Total Border Width

            return totalWidth;
        },

        getTotalHeight: function(el) {
            var totalHeight = el.height();
            totalHeight += parseInt(el.css("padding-top"), 10) + parseInt(el.css("padding-bottom"), 10); //Total Padding Width
            totalHeight += parseInt(el.css("margin-top"), 10) + parseInt(el.css("margin-bottom"), 10); //Total Margin Width
            //totalHeight += parseInt(el.css("border-top-width"), 10) + parseInt(el.css("border-bottom-width"), 10); //Total Border Width

            return totalHeight;
        },

        scrollToEl: function($targetEl, callback) {
            var viewportHeight = $(window).height(),
                elTop = $targetEl.offset().top,
                elHeight = $targetEl.height(),
                headerHeight = ($(".navbar").height() + 3) || 0,
                footerHeight = $("footer").height() || 0,
            // the header and footer cover elements on the page so we account for this
                buffer = 55,
                direction;
            if ($.contains(".navbar", $targetEl)) {
                headerHeight = 0;
            }

            if ($.contains("footer", $targetEl)) {
                footerHeight = 0;
            }

            if( elTop + elHeight > window.pageYOffset + viewportHeight - footerHeight ) {
                direction = "down";
            }
            // Make the buffer negative if we need to scroll up
            else if( elTop + elHeight < window.pageYOffset + elHeight + headerHeight ) {
                direction = "up";
                buffer *= -1;
            }
            else {
                direction = "none";
                if ( callback && _.isFunction(callback) ) {
                    callback();
                }
            }

            if( direction !== "none" ) {
                // scroll to element
                $('body, .main-pane, .side-pane').animate({
                    scrollTop: elTop + buffer
                },
                {
                    duration: "fast",
                    complete: function() {
                        if ( callback && _.isFunction(callback) ) {
                            callback();
                        }
                    }
                });
            }
        },

        render: function() {
            var tutorial = app.template.get('tutorial');
            $("body").append(tutorial());
            this.$el = $("#tutorial");

            this.delegateEvents();

            this.$el.show();
            return this;
        },

        remove: function() {
            delete this.highlight;
            delete this.highlightText;
            Backbone.View.prototype.remove.call(this);
        }

    });

})(SUGAR.App);
