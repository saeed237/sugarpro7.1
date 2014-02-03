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
    extendsFrom: 'DupecheckListView',
    additionalTableClasses: 'duplicates-selectedit',

    addActions:function () {
        if (this.actionsAdded) return;
        app.view.invokeParent(this, {type: 'view', name: 'dupecheck-list', method: 'addActions'});

        var firstRightColumn = this.rightColumns[0];
        if (firstRightColumn && _.isArray(firstRightColumn.fields)) {
            //Prepend Select and Edit action
            firstRightColumn.fields.unshift({
                type: 'rowaction',
                label: 'LBL_LISTVIEW_SELECT_AND_EDIT',
                css_class: 'btn btn-invisible btn-link',
                event: 'list:dupecheck-list-select-edit:fire'
            });
            this.rightColumns[0] = firstRightColumn;
        }
        this.actionsAdded = true;
    }
})
