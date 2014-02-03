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

$viewdefs['Contracts']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2', 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
 'javascript' => '<script type="text/javascript" language="javascript">
	function setvalue(source)  {ldelim} 
		src= new String(source.value);
		target=new String(source.form.name.value);

		if (target.length == 0)  {ldelim} 
			lastindex=src.lastIndexOf("\"");
			if (lastindex == -1)  {ldelim} 
				lastindex=src.lastIndexOf("\\\\\"");
			 {rdelim}  
			if (lastindex == -1)  {ldelim} 
				source.form.name.value=src;
				source.form.escaped_name.value = src;
			 {rdelim}  else  {ldelim} 
				source.form.name.value=src.substr(++lastindex, src.length);
				source.form.escaped_name.value = src.substr(lastindex, src.length);
			 {rdelim} 	
		 {rdelim} 			
	 {rdelim} 

	function set_expiration_notice_values(form)  {ldelim} 
		if (form.expiration_notice_flag.checked)  {ldelim} 
			form.expiration_notice_flag.value = "on";
			form.expiration_notice_date.value = "";
			form.expiration_notice_time.value = "";
			form.expiration_notice_date.readonly = true;
			form.expiration_notice_time.readonly = true;
			if(typeof(form.due_meridiem) != \'undefined\')  {ldelim} 
				form.due_meridiem.disabled = true;
			 {rdelim} 
			
		 {rdelim}  else  {ldelim} 
			form.expiration_notice_flag.value="off";
			form.expiration_notice_date.readOnly = false;
			form.expiration_notice_time.readOnly = false;
			
			if(typeof(form.due_meridiem) != \'undefined\')  {ldelim} 
				form.due_meridiem.disabled = false;
			 {rdelim} 
			
		 {rdelim} 
	 {rdelim} 
</script>',
),

'panels' =>array (
  'lbl_contract_information' => 
  array (
    
    array (
      'name',
      'status',
    ),
    
    array (
      'reference_code',
      array('name'=>'start_date', 'displayParams'=>array('showFormats'=>true)),
    ),
    
    array (
      'account_name',
      array('name'=>'end_date', 'displayParams'=>array('showFormats'=>true)),
    ),
    
    array (
      'opportunity_name',
    ),
    
    array (
    	'type',
    	array('name'=>'customer_signed_date', 'displayParams'=>array('showFormats'=>true)),
    ),
    
    array (
    	array('name'=>'currency_id','label'=>'LBL_CURRENCY'),
    	array('name'=>'company_signed_date', 'displayParams'=>array('showFormats'=>true)),
    ),
    
    array (
    	array('name'=>'total_contract_value', 'displayParams'=>array('size'=>15, 'maxlength'=>25)),
    	array('name'=>'expiration_notice', 'type'=>'datetimecombo', 'displayParams'=>array('showFormats'=>true)),      
    ),
    
    array (
      array('name' => 'description'),
    ),
    ),
	'LBL_PANEL_ASSIGNMENT' => 
	array(
	    array (
      'assigned_user_name',
      array('name'=>'team_name','displayParams'=>array('required'=>true)),
      ),
  ),
)

);
?>