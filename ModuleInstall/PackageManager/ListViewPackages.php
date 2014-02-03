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

 require_once('include/ListView/ListViewSmarty.php');
 
class ListViewPackages extends ListViewSmarty{
    var $secondaryDisplayColumns;
    /**
     * Constructor  Call ListViewSmarty
     */
    function ListViewPackages(){
        parent::ListViewSmarty();   
    } 
    
    /**
     * Override the setup method in ListViewSmarty since we are not passing in a bean
     * 
     * @param data  the data to display on the page
     * @param file  the template file to parse
     */
    function setup($data, $file){
        $this->data = $data;
        $this->tpl = $file;       
    }
    
    /**
     * Override the display method
     */
    function display(){
        global $odd_bg, $even_bg, $app_strings;
        $this->ss->assign('rowColor', array('oddListRow', 'evenListRow'));
        $this->ss->assign('bgColor', array($odd_bg, $even_bg));
        $this->ss->assign('displayColumns', $this->displayColumns);
        $this->ss->assign('secondaryDisplayColumns', $this->secondaryDisplayColumns);
        $this->ss->assign('data', $this->data); 
        return $this->ss->fetch($this->tpl);  
    }  
}
?>
