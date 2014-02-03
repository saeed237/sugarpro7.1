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

 * Description: view handler for step 1 of the import process
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/
require_once('modules/Import/views/ImportView.php');
require_once('modules/Import/Importer.php');
require_once('modules/Import/sources/ExternalSourceEAPMAdapter.php');
require_once('include/upload_file.php');

class ImportViewExtimport extends ImportView
{
    protected $pageTitleKey = 'LBL_STEP_DUP_TITLE';
    protected $importSource = FALSE;
    protected $externalSource = '';
    protected $offset = 0;
    protected $recordsPerImport = 10;
    protected $importDone = FALSE;

    public function __construct($bean = null, $view_object_map = array())
    {
        parent::__construct($bean, $view_object_map);
        $this->externalSource = isset($_REQUEST['external_source']) ? $_REQUEST['external_source'] : '';
        $this->offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : '0';
        $this->recordsPerImport = !empty($_REQUEST['records_per_import']) ? $_REQUEST['records_per_import'] : $this->recordsPerImport;
        $this->importSource = $this->getExternalSourceAdapter();
        $this->importSource->setCurrentOffset($this->offset);
        $GLOBALS['log']->fatal("Initiating external source import- source:{$this->externalSource}, offset: {$this->offset}, recordsPerImport: {$this->recordsPerImport}");
    }
 	/**
     * @see SugarView::display()
     */
 	public function display()
    {
        global $mod_strings, $app_strings, $current_user;
        global $sugar_config;

        if($this->importSource === FALSE)
        {
            $GLOBALS['log']->fatal("Found invalid adapter");
            $this->handleImportError($mod_strings['LBL_EXTERNAL_ERROR_NO_SOURCE']);
        }

        $columncount = isset($_REQUEST['columncount']) ? $_REQUEST['columncount'] : '';
        $fieldKeyTranslator = $this->getSugarToExternalFieldMapping($columncount);

        try
        {
            $this->importSource->loadDataSet($this->recordsPerImport);
        }
        catch(Exception $e)
        {
            $GLOBALS['log']->fatal("Unable to import external feed, exception: " . $e->getMessage() );
            $this->handleImportError($mod_strings['LBL_EXTERNAL_ERROR_FEED_CORRUPTED']);
        }

        if (!ImportCacheFiles::ensureWritable())
        {
            $GLOBALS['log']->fatal($mod_strings['LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE']);
            $this->handleImportError($mod_strings['LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE']);
        }

        $importer = new Importer($this->importSource, $this->bean);
        $importer->setFieldKeyTranslator($fieldKeyTranslator);
        $importer->import();

        //Send back our results.
        $metaResult = array('done' => FALSE, 'totalRecordCount' => $this->importSource->getTotalRecordCount() );
        echo json_encode($metaResult);
        sugar_cleanup(TRUE);
    }

    protected function handleImportError($errorMessage)
    {
        $resp = array('totalRecordCount' => -1, 'done' => TRUE, 'error' => $errorMessage);
        echo json_encode($resp);
        sugar_cleanup(TRUE);

    }

    protected function getExternalSourceAdapter()
    {
        if( substr($this->externalSource,7) == 'custom:')
        {
            return $this->getCustomExternalSourceAdapter();
        }
        else
        {
            return new ExternalSourceEAPMAdapter($this->externalSource);
        }
    }

    protected function getCustomExternalSourceAdapter()
    {
        $externalSourceName = ucfirst($this->externalSource);
        $externalSourceClassName = "ExternalSource{$externalSourceName}Adapter";
        $externalSourceFile = "modules/Import/sources/{$externalSourceClassName}.php";
        if(!SugarAutoLoader::requireWithCustom($externalSourceFile)) {
            $GLOBALS['log']->fatal("Unable to load external source adapter, file does not exist: {$externalSourceFile} ");
            return FALSE;
        }

        if( class_exists($externalSourceClassName) )
        {
            $GLOBALS['log']->fatal("Returning external source: $externalSourceClassName");
            return new $externalSourceClassName();
        }
        else
        {
            $GLOBALS['log']->fatal("Unable to load external source adapter class: $externalSourceClassName");
            return FALSE;
        }

    }

    /**
     * Return the user mapping that was constructed during the first page of import.
     *
     * @param  $columncount
     * @return array
     */
    protected function getSugarToExternalFieldMapping($columncount)
    {
        $userMapping = array();
        for($i=0;$i<$columncount;$i++)
        {
            $sugarKeyIndex = 'colnum_' . $i;
            $extKeyIndex = 'extkey_' . $i;
            $sugarKey = $_REQUEST[$sugarKeyIndex];
            //User specified don't map, keep going.
            if($sugarKey == -1)
                continue;

            $extKey = $_REQUEST[$extKeyIndex];
            //$defaultValue = $_REQUEST[$sugarKey];
            $userMapping[$sugarKey] = $extKey;
        }

        return $userMapping;
    }
}