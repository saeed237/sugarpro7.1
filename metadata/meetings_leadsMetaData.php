<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$dictionary['meetings_leads'] = array ( 'table' => 'meetings_leads'
                                  , 'fields' => array (
       array('name' =>'id', 'type' =>'varchar', 'len'=>'36')
      , array('name' =>'meeting_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'lead_id', 'type' =>'varchar', 'len'=>'36', )
      , array('name' =>'required', 'type' =>'varchar', 'len'=>'1', 'default'=>'1')
      , array('name' =>'accept_status', 'type' =>'varchar', 'len'=>'25', 'default'=>'none')
      , array ('name' => 'date_modified','type' => 'datetime')
      , array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>false)
                                                      )     
                                  , 'indices' => array (
       array('name' =>'meetings_leadspk', 'type' =>'primary', 'fields'=>array('id'))
      , array('name' =>'idx_lead_meeting_meeting', 'type' =>'index', 'fields'=>array('meeting_id'))
      , array('name' =>'idx_lead_meeting_lead', 'type' =>'index', 'fields'=>array('lead_id'))
      , array('name' => 'idx_meeting_lead', 'type'=>'alternate_key', 'fields'=>array('meeting_id','lead_id'))            
                                                      )

 	  , 'relationships' => array ('meetings_leads' => array('lhs_module'=> 'Meetings', 'lhs_table'=> 'meetings', 'lhs_key' => 'id',
							  'rhs_module'=> 'Leads', 'rhs_table'=> 'leads', 'rhs_key' => 'id',
							  'relationship_type'=>'many-to-many',
							  'join_table'=> 'meetings_leads', 'join_key_lhs'=>'meeting_id', 'join_key_rhs'=>'lead_id'))

)
?>
