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

$viewdefs['Calls']['mobile']['view']['detail'] = array(
	'templateMeta' => array(
                            'maxColumns' => '1', 
                            'widths' => array(
								array('label' => '10', 'field' => '30'), 
                            ),                                  
                           ),
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name'=>'name',
                    'displayParams'=>array(
                        'required'=>true,
                        'wireless_edit_only'=>true,
                    ),
                ),
                'date_start',
                'direction',
                'status',
                array(
                    'name' => 'duration',
                    'type' => 'fieldset',
                    'orientation' => 'horizontal',
                    'related_fields' => array('duration_hours', 'duration_minutes'),
                    'label' => "LBL_DURATION",
                    'fields' => array(
                        array(
                            'name' => 'duration_hours',
                        ),
                        array(
                            'type' => "label",
                            'default' => "LBL_HOURS_ABBREV",
                            'css_class' => "label_duration_hours hide",
                        ),
                        array(
                            'name' => 'duration_minutes',
                        ),
                        array(
                            'type' => "label",
                            'default' => "LBL_MINSS_ABBREV",
                            'css_class' => "label_duration_minutes hide",

                        ),
                    ),
                ),
                'description',
                'parent_name',
                'assigned_user_name',
                'team_name',
            ),
        ),
	),
);