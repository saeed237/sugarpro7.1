<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry) die ( 'Not A Valid Entry Point' ) ;
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

require_once ('modules/DynamicFields/templates/Fields/TemplateField.php') ;
require_once ('modules/DynamicFields/templates/Fields/TemplateAddressCountry.php') ;

class TemplateAddress extends TemplateField
{
    function save ($df)
    {
        // Bug 58560 - Set the group name since addresses are part of a group
        $this->group = $df->getDBName($this->name);
        
        require_once 'modules/ModuleBuilder/parsers/parser.label.php' ;
        $parser = new ParserLabel ( $df->getModuleName() , $df->getPackageName() ) ;
        
        // Clean up the labels so they more accurately reflect the actual field
        if (!empty($this->label_value)) {
            $labelValue = $this->label_value;
        } else {
            $labelValue = empty($_REQUEST['labelValue']) ? '' : $_REQUEST['labelValue'];
        }
        
        // If there is a label to use, space it here for use below
        if (!empty($labelValue)) {
            $labelValue .= ' ';
        }
        
        // To keep consistency with OOTB address groups, add Street to the fields
        foreach ( array ( 'Street', 'City' , 'State' , 'PostalCode' , 'Country' ) as $addressFieldName )
        {
            $systemLabel = strtoupper( "LBL_" . $this->name . '_' . $addressFieldName );
            // Use the entered label value as a prefix instead of the field name
            $parser->handleSave ( array( "label_" . $systemLabel => $labelValue . $addressFieldName ) , $GLOBALS [ 'current_language' ] ) ;
            $addressField = new TemplateField ( ) ;
            $addressField->len = ($addressFieldName == 'PostalCode') ? 20 : 100 ;
            $addressField->name = $this->name . '_' . strtolower ( $addressFieldName ) ;
            $addressField->label = $addressField->vname = $systemLabel ;
            // Bug 58560 - Add the group to this field so it gets written to the custom vardefs
            $addressField->group = $this->group;
            
            // Maintain unified search setting for 'Street'
            $addressField->supports_unified_search = $addressField == 'Street';
            
            $addressField->save ( $df ) ;
        }
    }
}

?>
