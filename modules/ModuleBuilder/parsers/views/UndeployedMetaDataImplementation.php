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


require_once 'modules/ModuleBuilder/MB/ModuleBuilder.php' ;
require_once 'modules/ModuleBuilder/parsers/views/AbstractMetaDataImplementation.php' ;
require_once 'modules/ModuleBuilder/parsers/views/MetaDataImplementationInterface.php' ;
require_once 'modules/ModuleBuilder/parsers/views/ListLayoutMetaDataParser.php' ;
require_once 'modules/ModuleBuilder/parsers/views/GridLayoutMetaDataParser.php' ;
require_once 'modules/ModuleBuilder/parsers/constants.php' ;

class UndeployedMetaDataImplementation extends AbstractMetaDataImplementation implements MetaDataImplementationInterface
{

    private $_packageName ;

    /**
     * Constructor
     * @param string $view
     * @param string $moduleName
     * @param string $packageName
     * @param string $client The client making the request for this implementation
     * @throws Exception Thrown if the provided view doesn't exist for this module
     */

    function __construct ($view , $moduleName , $packageName, $client = '')
    {

    	// BEGIN ASSERTIONS
        if (! isset ( $this->_fileVariables [ $view ] ))
        {
            sugar_die ( get_class ( $this ) . ": View $view is not supported" ) ;
        }
        // END ASSERTIONS

        $this->_view = strtolower ( $view ) ;
        $this->setViewClient($client);
        $this->_moduleName = $moduleName ;
        $this->_packageName = $packageName ;

        //get the bean from ModuleBuilder
        $mb = new ModuleBuilder ( ) ;
        $this->module = $module = & $mb->getPackageModule ( $packageName, $moduleName ) ;
        $pak = $mb->getPackage($packageName);
        $module->mbvardefs->updateVardefs () ;

        // Set the list of fields associated with this module
        $fielddefs = array_change_key_case ( $module->mbvardefs->vardefs [ 'fields' ] ) ;

        // Set the global mod_strings directly as Sugar does not automatically load the language files for undeployed modules (how could it?)
        $selected_lang = 'en_us';
        if(isset($GLOBALS['current_language']) &&!empty($GLOBALS['current_language'])) {
            $selected_lang = $GLOBALS['current_language'];
        }
        $GLOBALS [ 'mod_strings' ] = array_merge ( $GLOBALS [ 'mod_strings' ], $module->getModStrings ($selected_lang) ) ;

        //Load relationshhip based fields and labels
        $moduleRels = $pak->getRelationshipsForModule($moduleName);
        foreach($moduleRels as $rName => $rel ) {
            $varDefsSet = $rel->buildVardefs();
        if (!empty($varDefsSet[$module->key_name])) {
            	foreach ($varDefsSet[$module->key_name] as $def) {
                    $fielddefs[$def['name']] = $def;
                 }
            }
            $labels = $rel->buildLabels();
            foreach ($labels as $def) {
                if ($def['module'] == $module->key_name) {
            	   $GLOBALS [ 'mod_strings' ][$def['system_label']] = $def['display_label'];

            	}
            }
        }

        $loaded = null ;
        foreach ( array ( MB_WORKINGMETADATALOCATION , MB_HISTORYMETADATALOCATION ) as $type )
    	{
			$this->_sourceFilename = $this->getFileName ( $view, $moduleName, $packageName , $type ) ;
			if($view == MB_POPUPSEARCH || $view == MB_POPUPLIST){
				$layout = $this->_loadFromPopupFile ( $this->_sourceFilename , null, $view);
			}else{
				$layout = $this->_loadFromFile ( $this->_sourceFilename );
			}
			if ( null !== $layout  )
			{
                if (MB_WORKINGMETADATALOCATION == $type) {
                    $this->_useWorkingFile = true;
                } elseif (MB_HISTORYMETADATALOCATION == $type && $this->_useWorkingFile) {
                    $this->_useWorkingFile = false;
                }

				// merge in the fielddefs from this layout
				$this->_mergeFielddefs ( $fielddefs , $layout ) ;
				$loaded = $layout ;
			}
		}

        if ($loaded === null)
        {
            throw new Exception ( get_class ( $this ) . ": view definitions for View $this->_view and Module $this->_moduleName are missing" ) ;
        }

        $this->_viewdefs = $loaded ;
        $sourceFilename = $this->getFileName ( $view, $moduleName, $packageName, MB_WORKINGMETADATALOCATION );
        if($view == MB_POPUPSEARCH || $view == MB_POPUPLIST){
			$layout = $this->_loadFromPopupFile ( $sourceFilename , null, $view);
		}else{
			$layout = $this->_loadFromFile ($sourceFilename) ;
		}
		$this->_originalViewdefs = $layout ;
		$this->_fielddefs = $fielddefs ;
        
        // Bug 56675 - Panel defs needed for undeployed modules as well
        // Set the panel defs (the old field defs)
        $this->setPanelDefsFromViewDefs();

        // Make sure the paneldefs are proper if there are any
        if (is_array($this->_paneldefs) && !is_numeric(key($this->_paneldefs))) {
            $this->_paneldefs = array($this->_paneldefs);
        }
                
        $this->_history = new History ( $this->getFileName ( $view, $moduleName, $packageName, MB_HISTORYMETADATALOCATION ) ) ;
    }

    function getLanguage ()
    {
        return $this->_packageName . $this->_moduleName ;
    }

    /*
     * Deploy a layout
     * @param array defs    Layout definition in the same format as received by the constructor
     */
    function deploy ($defs)
    {
        //If we are pulling from the History Location, that means we did a restore, and we need to save the history for the previous file.
    	if ($this->_sourceFilename == $this->getFileName ( $this->_view, $this->_moduleName, $this->_packageName, MB_HISTORYMETADATALOCATION )
    	&& file_exists($this->getFileName ( $this->_view, $this->_moduleName, $this->_packageName, MB_WORKINGMETADATALOCATION ))) {
        	$this->_history->append ( $this->getFileName ( $this->_view, $this->_moduleName, $this->_packageName, MB_WORKINGMETADATALOCATION )) ;
        } else {
    		$this->_history->append ( $this->_sourceFilename ) ;
        }
        $filename = $this->getFileName ( $this->_view, $this->_moduleName, $this->_packageName, MB_WORKINGMETADATALOCATION ) ;
        $GLOBALS [ 'log' ]->debug ( get_class ( $this ) . "->deploy(): writing to " . $filename ) ;
        $this->_saveToFile ( $filename, $defs ) ;
    }

    /*
     * Construct a full pathname for the requested metadata
     * @param string $view           The view type, that is, EditView, DetailView etc
     * @param string $modulename     The name of the module that will use this layout
     * @param string $type           The location of the file
     * @param string $client         The client to get the filename for
     */
    public function getFileName ($view , $moduleName , $packageName , $type = MB_BASEMETADATALOCATION, $client = null)
    {
        if ($client === null) {
            $client = $this->_viewClient;
        }
        return MetaDataFiles::getUndeployedFileName($view, $moduleName, $packageName, $type, $client);
    }
    
    public function getModuleDir(){
		return $this->module->key_name;
	}
}
?>
