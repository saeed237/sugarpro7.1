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

require_once('modules/DynamicFields/templates/Fields/TemplateText.php');
class TemplateImage extends TemplateText{
	var $type = 'image';	
		
	function get_field_def(){
		$def = parent::get_field_def();
		$def['studio'] = 'visible';		
		$def['type'] = 'image';
		$def['dbType'] = 'varchar';
		$def['len']= 255;
		
		if(	isset($this->ext1)	)	$def[ 'border' ] 	= $this->ext1 ;            
		if(	isset($this->ext2)	)	$def[ 'width' ] 	= $this->ext2 ;
		if(	isset($this->ext3)	)	$def[ 'height' ] 	= $this->ext3 ;
		if(	isset($this->border))	$def[ 'border' ] 	= $this->border ;          
	    if(	isset($this->width)	)	$def[ 'width' ] 	= $this->width ;
        if(	isset($this->height))	$def[ 'height' ] 	= $this->height ;
        
		return $def;	
	}
	
	public function __construct()
	{
		$this->vardef_map['border'] = 'ext1';
		$this->vardef_map['width'] = 'ext2';
		$this->vardef_map['height'] = 'ext3';		
	}
	
	function set($values){
	   parent::set($values);
	   if(!empty($this->ext1)){
	       $this->border = $this->ext1;
	   }
	   if(!empty($this->ext2)){
	       $this->width = $this->ext2;
	   }
	   if(!empty($this->ext3)){
	       $this->height = $this->ext3;
	   }
	   
	}
	
		
}


?>
