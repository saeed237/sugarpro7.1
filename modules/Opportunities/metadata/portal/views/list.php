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


$viewdefs['Opportunities']['portal']['view']['list'] = array(
    'buttons' =>
    array(
        0 =>
        array(
            'name' => 'show_more_button',
            'type' => 'button',
            'label' => 'Show More',
            'class' => 'loading wide',
            'events' =>
            array(
                'click' => 'function(){ var self = this;this.context.state.collection.paginate({add:true, success:function(){console.log("in paginate success");window.scrollTo(0,document.body.scrollHeight);}});}',
            ),
        ),
    ),
    'listNav' =>
    array(
        0 =>
        array(
            'name' => 'show_more_button_back',
            'type' => 'navElement',
            'icon' => 'icon-plus',
            'label' => ' ',
            'route' =>
            array(
                'action' => 'create',
                'module' => 'Opportunities',
            ),
        ),
        1 =>
        array(
            'name' => 'show_more_button_back',
            'type' => 'navElement',
            'icon' => 'icon-chevron-left',
            'label' => ' ',
            'events' =>
            array(
                'click' => 'function(){ var self = this;this.context.state.collection.paginate({page:-1, success:function(){console.log("in paginate success");}});}',
            ),
        ),
        2 =>
        array(
            'name' => 'show_more_button_forward',
            'type' => 'navElement',
            'icon' => 'icon-chevron-right',
            'label' => ' ',
            'events' =>
            array(
                'click' => 'function(){ var self = this;console.log(this); this.context.state.collection.paginate({success:function(){console.log("in paginate success");}});}',
            ),
        ),
    ),
    'panels' =>
    array(
        0 =>
        array(
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'name',
                    'label' => 'Name',
                    'default' => true,
                    'enabled' => true,
                ),
                1 =>
                array(
                    'name' => 'amount',
                    'label' => 'Opportunity Amount',
                    'default' => true,
                    'enabled' => true,
                    'type' => 'clickToEdit',
                    'cteclass' => 'cteopp',
                ),
                2 =>
                array(
                    'name' => 'opportunity_type',
                    'label' => 'Opp. Type',
                    'default' => true,
                    'enabled' => true,
                ),
                3 =>
                array(
                    'name' => 'lead_source',
                    'label' => 'Lead Source',
                    'default' => true,
                    'enabled' => true,
                )
            ),
        ),
    ),
);
