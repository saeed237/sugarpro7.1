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

 * Description: This file is used to override the default Meta-data EditView behavior
 * to provide customization specific to the Quotes module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once 'modules/ModuleBuilder/Module/StudioModule.php' ;

class LeadsStudioModule extends StudioModule
{
     function __construct ($module)
    {
         parent::__construct ($module);
    }

    function getLayouts()
    {
        $layouts = parent::getLayouts();
        
        $layouts = array_merge(array( translate("LBL_CONVERTLEAD", "Leads") => array ( 
            'name' => translate("LBL_CONVERTLEAD", "Leads") , 
            'action' => "module=Leads&action=Editconvert&to_pdf=1" , 
            'imageTitle' => 'icon_ConvertLead' , 
            'help' => 'layoutsBtn' , 
            'size' => '48')), $layouts);
        
        return $layouts ;

    }
}