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

/*********************************************************************************

 * Description:
 ********************************************************************************/








class Controller extends SugarBean {
	
	var $focus;
	var $type;  //defines id this is a new list order or existing, or delete
				// New, Save, Delete
	
	function Controller() {
		parent::__construct();

		$this->disable_row_level_security =true;

	}
	
	function init(& $seed_object, $type){
	
		$this->focus = & $seed_object;
		$this->type = $type;
	
	//end function Controller
	}	

	function change_component_order($magnitude, $direction, $parent_id=""){
		
		if(!empty($this->type) && $this->type=="Save"){
			
			//safety check
			$wall_test = $this->check_wall($magnitude, $direction, $parent_id);

			if($wall_test==false){
				return;
			}
				
				
				if($direction=="Left"){
					if($this->focus->controller_def['list_x']=="Y"){
						$new_x = $this->focus->list_order_x -1;
						$affected_x = $this->focus->list_order_x;
					} else {
						$new_x = "";
						$affected_x = "";
					}	
					if($this->focus->controller_def['list_y']=="Y"){	
						
						$new_y = $this->focus->list_order_y;
						$affected_y = $this->focus->list_order_y;
					} else {
						$new_y = "";
						$affected_y = "";	
					}	
					
					$affected_id = $this->get_affected_id($parent_id, $new_x, $new_y);
				//end if direction Left
				}	
				if($direction=="Right"){
					
					if($this->focus->controller_def['list_x']=="Y"){
						$new_x = $this->focus->list_order_x + 1;
						$affected_x = $this->focus->list_order_x;						
					} else {
						$new_x = "";
						$affected_x = "";
					}
					if($this->focus->controller_def['list_y']=="Y"){
						$new_y = $this->focus->list_order_y;
						$affected_y = $this->focus->list_order_y;
					} else {
						$new_y = "";
						$affected_y = "";
					}						
					$affected_id = $this->get_affected_id($parent_id, $new_x, $new_y);		
				//end if direction Right
				}
			
				if($direction=="Up"){
					if($this->focus->controller_def['list_x']=="Y"){
						$new_x = $this->focus->list_order_x;
						$affected_x = $this->focus->list_order_x;
					} else {
						$new_x = "";
						$affected_x = "";
					}	
					if($this->focus->controller_def['list_y']=="Y"){	
						
					$new_y = $this->focus->list_order_y - 1;
					$affected_y = $this->focus->list_order_y;
					} else {
						$new_y = "";
						$affected_y = "";	
					}	
					
					$affected_id = $this->get_affected_id($parent_id, $new_x, $new_y);
					
				//end if direction Up
				}	
				if($direction=="Down"){
					
					if($this->focus->controller_def['list_x']=="Y"){
						$new_x = $this->focus->list_order_x;
						$affected_x = $this->focus->list_order_x;
					} else {
						$new_x = "";
						$affected_x = "";
					}
					if($this->focus->controller_def['list_y']=="Y"){

						$new_y = $this->focus->list_order_y + 1;
						$affected_y = $this->focus->list_order_y;
					} else {
						$new_y = "";
						$affected_y = "";
					}						
					$affected_id = $this->get_affected_id($parent_id, $new_x, $new_y);		
				//end if direction Down
				}

			//This takes care of the component being pushed out of its position
			$this->update_affected_order($affected_id, $affected_x, $affected_y);
			
				//This takes care of the new positions for itself
			if($this->focus->controller_def['list_x']=="Y"){
				$this->focus->list_order_x = $new_x;
			}
				
			if($this->focus->controller_def['list_y']=="Y"){	
				$this->focus->list_order_y = $new_y;
			}
			
		} else {
		//this is a new component, set the x or y value to the max + 1

				$query = "SELECT MAX(".$this->focus->controller_def['start_var'].") max_start from ".$this->focus->table_name."
						  WHERE ".$this->focus->controller_def['parent_var']."='$parent_id'
						  AND ".$this->focus->table_name.".deleted='0'
						 ";
				$result = $this->db->query($query,true," Error capturing max start order: ");
				$row = $this->db->fetchByAssoc($result);
		
			if(!is_null($row['max_start'])){		
				
				if($this->focus->controller_def['start_axis']=="x")	{
					$this->focus->list_order_x = $row['max_start'] + 1;
					if($this->focus->controller_def['list_y']=="Y") $this->focus->list_order_y = 0;
				}
				
				if($this->focus->controller_def['start_axis']=="y")	{
					$this->focus->list_order_y = $row['max_start'] + 1;
					if($this->focus->controller_def['list_x']=="Y") $this->focus->list_order_x = 0;
				}
				
			} else {
				//first row
				if($this->focus->controller_def['list_x']=="Y") $this->focus->list_order_x = 0;
				if($this->focus->controller_def['list_y']=="Y") $this->focus->list_order_y = 0;

			//end if else to check if this is first entry
			}
		//end if else on whether this is a new entry
		}	
	//end function change_component_order	
	}
	
	function update_affected_order($affected_id, $affected_new_x="", $affected_new_y=""){
		 
		$query = 	"UPDATE ".$this->focus->table_name." SET";
		
		if($this->focus->controller_def['list_x']=="Y"){				
				$query .= 	"	 list_order_x='$affected_new_x'";
		}
		if($this->focus->controller_def['list_y']=="Y"){	

			if($this->focus->controller_def['list_x']=="Y"){
				$query .= 	"	, ";
			}		 
			$query .= 	"	list_order_y='$affected_new_y'";
		}						
		
		$query .=	"	WHERE id='$affected_id'";
		$query .=   "	AND ".$this->focus->table_name.".deleted='0'";
		$result = $this->db->query($query,true," Error updating affected order id: ");
	//end function update_affected_order
	}
	
	function get_affected_id($parent_id, $list_order_x="", $list_order_y=""){	
		
		$query = "	SELECT id from ".$this->focus->table_name."
					WHERE ".$this->focus->controller_def['parent_var']."='$parent_id'
					AND ".$this->focus->table_name.".deleted='0'
					";
		
		if($this->focus->controller_def['list_x']=="Y"){		
			$query .= "	AND list_order_x='$list_order_x' ";
		}
		
		if($this->focus->controller_def['list_y']=="Y"){			
			$query .= "	AND list_order_y='$list_order_y' ";
		}			

	//echo $query."<BR>";		
		$result = $this->db->query($query,true," Error capturing affected id: ");
		$row = $this->db->fetchByAssoc($result);

		return $row['id'];
		
	//end function get_affected_id
	}	
	

/////////////Wall Functions////////////////////


function check_wall($magnitude, $direction, $parent_id){
	
//TODO: jgreen - this is only single axis check_wall mechanism, will need to upgrade this to double axis	
//This function determines if you can't move the direction you want, because you are at the edge

	
//If down or Right, then check max list_order value
	if($direction=="Down" || $direction =="Right"){

		$query = "SELECT MAX(".$this->focus->controller_def['start_var'].") max_start from ".$this->focus->table_name."
				  WHERE ".$this->focus->controller_def['parent_var']."='$parent_id'
				  AND ".$this->focus->table_name.".deleted='0'
						 ";
		$result = $this->db->query($query,true," Error capturing max start order: ");
		$row = $this->db->fetchByAssoc($result);
		
			if($this->focus->controller_def['start_axis']=="x")	{
				if($row['max_start'] == $this->focus->list_order_x){
					return false;	
				}	
			}
			if($this->focus->controller_def['start_axis']=="y")	{
				if($row['max_start'] == $this->focus->list_order_y){
					return false;	
				}	
			}
	//end if up or right
	}

//If up or left, then simply check the 0 value	
	if($direction=="Up" || $direction =="Left"){
			if($this->focus->controller_def['start_axis']=="x")	{
				if($this->focus->list_order_x==0){
					return false;	
				}	
			}
			if($this->focus->controller_def['start_axis']=="y")	{
				if($this->focus->list_order_y==0){
					return false;	
				}	
			}
		
	//end if down or left
	}	
	
	//If you get here, then you are not at the wall and can change order
	return true;
		
//end function check_wall	
}	
	
//End Wall Functions/////////////////////////

//Delete adjust functions////////////////////


function delete_adjust_order($parent_id){
	
	
	//Currently handles single axis motion only!!!!!!!!!
	//TODO: jgreen - Add dual axis motion 
	
	//adjust along start_axis
	$variable_name = $this->focus->controller_def['start_var'];
	$current_position = $this->focus->$variable_name;

	$query =  "UPDATE ".$this->focus->table_name." ";
	$query .= "SET ".$this->focus->controller_def['start_var']." = ".$this->focus->controller_def['start_var']." - 1 ";
	$query .= "WHERE ".$this->focus->controller_def['start_var']." > ".$current_position." AND deleted=0 ";
	$query .= "AND ".$this->focus->controller_def['parent_var']." = '".$parent_id."'";

	$result = $this->db->query($query,true," Error updating the delete_adjust_order: ");
//end delete_adjust_order	
}	
//End Delete Functions/////////////////////////
//end class Controller
}	

?>