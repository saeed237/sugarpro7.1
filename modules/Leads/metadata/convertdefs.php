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

$viewdefs['Contacts']['ConvertLead'] = array(
    'copyData' => true,
    'required' => true,
    'select' => "report_to_name",
    'default_action' => 'create',
    'templateMeta' => array(
        'form'=>array(
            'hidden'=>array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
    			'<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
    			'<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
    			'<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
    			'<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            )
        ),
		'maxColumns' => '2', 
        'widths' => array(
            array('label' => '10', 'field' => '30'), 
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' =>array (
        'LNK_NEW_CONTACT' => array (
            array (
                array (
                    'name' => 'first_name',
                    'customCode' => '{html_options name="Contactssalutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="Contactsfirst_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                ),
                'title',
            ), 
            array (
                
                'last_name',
                'department',
            ),
            array (
                array('name' => 'primary_address_street', 'label' => 'LBL_PRIMARY_ADDRESS'),
                'phone_work',
                
            ),
            array (
                array('name'=>'primary_address_state', 'label' => 'LBL_STATE'),
                'phone_mobile',
            ),
            array (
                array('name'=>'primary_address_postalcode', 'label' => 'LBL_POSTAL_CODE'),
                'phone_other',
            ),
            array (
                array('name'=>'primary_address_country', 'label' => 'LBL_COUNTRY'),
                'phone_fax',
            ),
            array (
                'email1',
                'lead_source',
            ),
            array(
                'description',
                'preferred_language'
            ),
        )
    ),
);
$viewdefs['Accounts']['ConvertLead'] = array(
    'copyData' => true,
    'required' => true,
    'select' => "account_name",
	'default_action' => 'create',
    'relationship' => 'accounts_contacts',
    'templateMeta' => array(
        'form'=>array(
            'hidden'=>array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            )
        ),
        'maxColumns' => '2', 
        'widths' => array(
            array('label' => '10', 'field' => '30'), 
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' =>array (
        'LNK_NEW_ACCOUNT' => array (
            array (
                'name',
                'phone_office',
            ),
            array (
                'website',
            ),
            array(
                'description'
            ),
        )
    ),
);
$viewdefs['Opportunities']['ConvertLead'] = array(
    'copyData' => true,
    'required' => false,
    'templateMeta' => array(
        'form'=>array(
            'hidden'=>array(
            )
        ),
        'maxColumns' => '2', 
        'widths' => array(
            array('label' => '10', 'field' => '30'), 
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' =>array (
        'LNK_NEW_OPPORTUNITY' => array (
            array (
                'name',
                'currency_id'
            ), 
            array (
                'sales_stage',
                'amount'
            ),
            array (
                'date_closed',
                ''
            ),
            array (
                'description'
            ),
        )
    ),
);
$viewdefs['Notes']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'templateMeta' => array(
        'form'=>array(
            'hidden'=>array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            )
        ),
        'maxColumns' => '2', 
        'widths' => array(
            array('label' => '10', 'field' => '30'), 
            array('label' => '10', 'field' => '30'),    
        ),
    ),
    'panels' =>array (
        'LNK_NEW_NOTE' => array (
            array (
                array('name'=>'name', 'displayParams'=>array('size'=>90)),
            ), 
            array (
                array('name' => 'description', 'displayParams' => array('rows'=>10, 'cols'=>90) ),
            ),
        )
    ),
);

$viewdefs['Calls']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'templateMeta' => array(
        'form'=>array(
            'hidden'=>array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
                '<input type="hidden" name="Callsstatus" value="{sugar_translate label=\'call_status_default\'}">',
            )
        ),
        'maxColumns' => '2', 
        'widths' => array(
            array('label' => '10', 'field' => '30'), 
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' =>array (
        'LNK_NEW_CALL' => array (
            array (
                array('name'=>'name', 'displayParams'=>array('size'=>90)),
            ), 
            array (
               'date_start', 
                array (
                    'name' => 'duration_hours',
                    'label' => 'LBL_DURATION',
                    'customCode' => '{literal}
<script type="text/javascript">
    function isValidCallsDuration() { 
        form = document.getElementById(\'ConvertLead\');
        if ( form.duration_hours.value + form.duration_minutes.value <= 0 ) {
            alert(\'{/literal}{sugar_translate label="NOTICE_DURATION_TIME" module="Calls"}{literal}\'); 
            return false;
        }
        return true; 
    }
</script>{/literal}
<input name="Callsduration_hours" tabindex="1" size="2" maxlength="2" type="text" value="{$fields.duration_hours.value}"/>
{php}$this->_tpl_vars["minutes_values"] = $this->_tpl_vars["bean"]->minutes_values;{/php}
{html_options name="Callsduration_minutes" options=$minutes_values selected=$fields.duration_minutes.value} &nbsp;
<span class="dateFormat">{sugar_translate label="LBL_HOURS_MINUTES" module="Calls"}',
                    'displayParams' => 
                    array (
                      'required' => true,
                    ),
                ),
            ),
            array (
                array('name' => 'description', 'displayParams' => array('rows'=>10, 'cols'=>90) ),
            ),
        )
    ),
);

$viewdefs['Meetings']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'relationship' => 'meetings_users',
    'templateMeta' => array(
        'form'=>array(
            'hidden'=>array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">',
                '<input type="hidden" name="Meetingsstatus" value="{sugar_translate label=\'meeting_status_default\'}">',
            )
        ),
        'maxColumns' => '2', 
        'widths' => array(
            array('label' => '10', 'field' => '30'), 
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' =>array (
        'LNK_NEW_MEETING' => array (
            array (
                array('name'=>'name', 'displayParams'=>array('size'=>90)),
            ), 
            array (
               'date_start', 
	            array (
                    'name' => 'duration_hours',
                    'label' => 'LBL_DURATION',
                    'customCode' => '{literal}
<script type="text/javascript">
    function isValidMeetingsDuration() { 
        form = document.getElementById(\'ConvertLead\');
        if ( form.duration_hours.value + form.duration_minutes.value <= 0 ) {
            alert(\'{/literal}{sugar_translate label="NOTICE_DURATION_TIME" module="Calls"}{literal}\'); 
            return false;
        }
        return true; 
    }
</script>{/literal}
<input name="Meetingsduration_hours" tabindex="1" size="2" maxlength="2" type="text" value="{$fields.duration_hours.value}" />
{php}$this->_tpl_vars["minutes_values"] = $this->_tpl_vars["bean"]->minutes_values;{/php}
{html_options name="Meetingsduration_minutes" options=$minutes_values selected=$fields.duration_minutes.value} &nbsp;
<span class="dateFormat">{sugar_translate label="LBL_HOURS_MINUTES" module="Calls"}',
                    'displayParams' => 
                    array (
                      'required' => true,
                    ),
                ),
            ),
            array (
                array('name' => 'description', 'displayParams' => array('rows'=>10, 'cols'=>90) ),
            ),
        )
    ),
);

$viewdefs['Tasks']['ConvertLead'] = array(
    'copyData' => false,
    'required' => false,
    'templateMeta' => array(
        'form'=>array(
            'hidden'=>array(
                '<input type="hidden" name="opportunity_id" value="{$smarty.request.opportunity_id}">',
                '<input type="hidden" name="case_id" value="{$smarty.request.case_id}">',
                '<input type="hidden" name="bug_id" value="{$smarty.request.bug_id}">',
                '<input type="hidden" name="email_id" value="{$smarty.request.email_id}">',
                '<input type="hidden" name="inbound_email_id" value="{$smarty.request.inbound_email_id}">'
            )
        ),
        'maxColumns' => '2', 
        'widths' => array(
            array('label' => '10', 'field' => '30'), 
            array('label' => '10', 'field' => '30'),
        ),
    ),
    'panels' =>array (
        'LNK_NEW_TASK' => array (
            array (
                array('name'=>'name', 'displayParams'=>array('size'=>90)),
            ), 
			array (
               'status', 'priority'
            ), 
            
            array (
                array('name' => 'description', 'displayParams' => array('rows'=>10, 'cols'=>90) ),
            ),
        )
    ),
);


?>