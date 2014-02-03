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

/*
 * Changes to AbstractSubpanelImplementation for DeployedSubpanels
 * The main differences are in the load and save of the definitions
 * For subpanels we must make use of the SubPanelDefinitions class to do this; this also means that the history mechanism,
 * which tracks files, not objects, needs us to create an intermediate file representation of the definition that it can manage and restore
 */

require_once 'modules/ModuleBuilder/parsers/views/MetaDataImplementationInterface.php' ;
require_once 'modules/ModuleBuilder/parsers/views/AbstractMetaDataImplementation.php' ;
require_once 'modules/ModuleBuilder/parsers/constants.php' ;

class UndeployedSubpanelImplementation extends AbstractMetaDataImplementation implements MetaDataImplementationInterface
{

    const HISTORYFILENAME = 'restored.php' ;
    const HISTORYVARIABLENAME = 'layout_defs' ;

    /*
     * Constructor
     * @param string subpanelName   The name of this subpanel
     * @param string moduleName     The name of the module to which this subpanel belongs
     * @param string packageName    If not empty, the name of the package to which this subpanel belongs
     */
    function __construct ($subpanelName , $moduleName , $packageName)
    {
        $this->_subpanelName = $subpanelName ;
        $this->_moduleName = $moduleName ;

        // TODO: history
        $this->historyPathname = 'custom/history/modulebuilder/packages/' . $packageName . '/modules/' . $moduleName . '/metadata/' . self::HISTORYFILENAME ;
        $this->_history = new History ( $this->historyPathname ) ;

        //get the bean from ModuleBuilder
        $mb = new ModuleBuilder ( ) ;
        $this->module = & $mb->getPackageModule ( $packageName, $moduleName ) ;
        $this->module->mbvardefs->updateVardefs () ;
        $this->_fielddefs = & $this->module->mbvardefs->vardefs [ 'fields' ] ;

        $templates = & $this->module->config['templates'];
        $template_def="";
         foreach ( $templates as $template => $a ){
             if($a===1) $template_def = $template;
         }
        $template_subpanel_def = 'include/SugarObjects/templates/'.$template_def. '/metadata/subpanels/default.php';
         if (file_exists($template_subpanel_def)){
            include($template_subpanel_def);
            if (!empty($subpanel_layout['list_fields']))
                $this->_mergeFielddefs($this->_fielddefs, $subpanel_layout['list_fields']);
        }

        $subpanel_layout = $this->module->getAvailableSubpanelDef ( $this->_subpanelName ) ;
        $this->_viewdefs = & $subpanel_layout [ 'list_fields' ] ;
        $this->_mergeFielddefs($this->_fielddefs, $this->_viewdefs);
        
        // Set the global mod_strings directly as Sugar does not automatically load the language files for undeployed modules (how could it?)
        $selected_lang = 'en_us';
        if(isset($GLOBALS['current_language']) &&!empty($GLOBALS['current_language'])) {
            $selected_lang = $GLOBALS['current_language'];
        }
        $GLOBALS [ 'mod_strings' ] = array_merge ( $GLOBALS [ 'mod_strings' ], $this->module->getModStrings ($selected_lang) ) ;
    }

    function getLanguage ()
    {
        return "" ; // '' is the signal to translate() to use the global mod_strings
    }

    /*
     * Save a subpanel
     * @param array defs    Layout definition in the same format as received by the constructor
     * @param string type   The location for the file - for example, MB_BASEMETADATALOCATION for a location in the OOB metadata directory
     */
    function deploy ($defs)
    {
        $outputDefs = $this->module->getAvailableSubpanelDef ( $this->_subpanelName ) ;
        // first sort out the historical record...
        // copy the definition to a temporary file then let the history object add it
        write_array_to_file ( self::HISTORYVARIABLENAME, $outputDefs, $this->historyPathname, 'w', '' ) ;
        $this->_history->append ( $this->historyPathname ) ;
        // no need to unlink the temporary file as being handled by in history->append()
        //unlink ( $this->historyPathname ) ;

        $outputDefs [ 'list_fields' ] = $defs ;
        $this->_viewdefs = $defs ;
        $this->module->saveAvailableSubpanelDef ( $this->_subpanelName, $outputDefs ) ;

    }

}