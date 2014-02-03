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
    /**
     * extendsFrom: This needs to be app.view.TutorialView since it's extending a Sidecar specific view class.  This is a
     * special case, as the normal method is for it to be a string.
     */
    extendsFrom: app.view.TutorialView,

    className: '', //override default class

    initialize: function(options) {
        this.resizeCallback = _.debounce(_.bind(function(){
            this.highlightItem(this.index);
        }, this), 400);
        $(window).on('resize', this.resizeCallback);
        this.keyupCallback = _.bind(this.processKeyCode, this);
        $(document).on('keyup', this.keyupCallback);
        app.view.TutorialView.prototype.initialize.call(this, options);
    },
    processKeyCode: function(e) {
        switch(e.which) {
            case 37: // left
                this.back(e);
                break;

            case 39: // right
                this.next(e);
                break;

            case 27: // exit
                this.hide(e);
                break;

            default: return; // exit this handler for other keys
        }
        e.preventDefault();
    },
    remove: function () {
        $(window).off('resize', this.resizeCallback);
        $(document).off('keyup', this.keyupCallback);
        app.view.TutorialView.prototype.remove.call(this);
    }
})