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

require_once('include/MVC/View/SugarView.php');

class CalendarViewJson extends SugarView 
{

    public function display()
    {    
        if (!isset($this->view_object_map['jsonData']) || !is_array($this->view_object_map['jsonData'])) {
            $GLOBALS['log']->fatal("JSON data has not been passed from Calendar controller");
            sugar_cleanup(true);
        }
        
        $jsonData = $this->view_object_map['jsonData'];
        
        ob_clean();
        echo json_encode($jsonData);
    }
}

?>
