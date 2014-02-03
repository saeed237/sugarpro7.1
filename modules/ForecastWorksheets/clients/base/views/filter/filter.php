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


$viewdefs['ForecastWorksheetss']['base']['view']['filter'] = array(
    'panels' => array(
        0 => array(
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'ranges',
                    /*
                    This is an enum field, however the 'options' string is set dynamically in the view (which is why it
                    is missing here), since the dropdown shown to the user depends on a config setting
                    */
                    'type' => 'enum',
                    'multi' => true,
                    'label' => 'LBL_FILTERS',
                    'default' => false,
                    'enabled' => true,
                ),
            ),
        ),
    )
);
