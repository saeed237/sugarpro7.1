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


require_once('modules/KBDocuments/SearchUtils.php');


    $node_depth = isset($_REQUEST['PARAMT_depth']) ? $_REQUEST['PARAMT_depth'] : 0;
    $n_id = isset($_REQUEST['PARAMN_id_'.$node_depth]) ? $_REQUEST['PARAMN_id_'.$node_depth] : '';
    $zero_node =  isset($_REQUEST['PARAMN_id_0']) ? $_REQUEST['PARAMN_id_0'] : '';
    $sortCol = '';
    
    //if we do not get the node id, then cancel this call, we cannot proceed
    if(empty($n_id )){
        return;   
    }
    
    $search_str = ' kbdocuments.deleted =0';
    //if node id is untagged, then create query for all untagged articles
    if($n_id == 'UNTAGGED_NODE_ID'){
    $search_str .= " and kbdocuments.id NOT IN
                                (select kbdocument_id from kbdocuments_kbtags where deleted = 0)";      
        
    }else{
        //create query for articles under this tag
    $search_str .= " and kbdocuments.id
                        IN (
                            SELECT kbd.id
                            FROM kbdocuments kbd, kbdocuments_kbtags kbd_kt
                            WHERE kbd.id = kbd_kt.kbdocument_id
                            AND kbd.deleted = 0
                            AND kbd_kt.deleted = 0
                            AND kbd_kt.kbtag_id = '$n_id'
                        )";        
    
    }
    
    //check to see if sortCol has been specified
    if( isset($_REQUEST['sortCol']) && !empty($_REQUEST['sortCol'])) {
        //if sorcol has been set to PAGINATE, then this is a pagination and requires
        //reversing the sort order so listview data can process correctly
        if($_REQUEST['sortCol']=='PAGINATE'){
            if(isset($lvso) && !empty($lvso)){
                $lvso = (strcmp(strtolower($lvso), 'asc') == 0)?'DESC':'ASC';
            }
        }else{
            //this is a normal sort column command, override sort order 
            //with currently selected column (if this call is from sort event)
            $sortCol = $_REQUEST['sortCol'];
        }
    }
   //Set Request Object parameter so that Sort order will happen in get_fts_list method
   $_REQUEST['KBDocuments2_KBDOCUMENT_ORDER_BY'] = $sortCol;
       
   //if set to 'all tags', pass in query 'where' clause into method that returns list for admins
   if(!empty($zero_node) && strtolower($zero_node) == 'all_tags'){
   		$results = get_admin_fts_list($search_str,false,true);
   }else{   
        $results = get_fts_list($search_str,false,true);
   }

echo $results;

?>
