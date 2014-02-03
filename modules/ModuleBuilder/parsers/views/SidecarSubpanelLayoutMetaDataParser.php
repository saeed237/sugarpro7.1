<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright  2004-2013 SugarCRM Inc.  All rights reserved.
 */

require_once 'modules/ModuleBuilder/parsers/views/SidecarListLayoutMetaDataParser.php';
require_once 'include/MetaDataManager/MetaDataManager.php';

class SidecarSubpanelLayoutMetaDataParser extends SidecarListLayoutMetaDataParser
{

    public $invisibleFields = array();

    /*
     * Constructor, builds the parent ListLayoutMetaDataParser then adds the
     * panel data to it
     *
     * @param string $view           The view type, that is, editview, searchview etc
     * @param string $moduleName     The name of the module to which this listview belongs
     * @param string $packageName    If not empty, the name of the package to which this listview belongs
     * @param string $client         The client making the request for this parser
     */
    public function __construct($subpanelName, $moduleName, $packageName = '', $client = 'base')
    {
        $GLOBALS['log']->debug(get_class($this) . ": __construct()");

        if (empty($client)) {
            throw new \InvalidArgumentException("Client cannot be blank in SidecarSubpanelLayoutMetaDataParser");
        }

        if (empty($packageName)) {
            require_once 'modules/ModuleBuilder/parsers/views/DeployedSidecarSubpanelImplementation.php';
            $this->implementation = new DeployedSidecarSubpanelImplementation($subpanelName, $moduleName, $client);
        } else {
            require_once 'modules/ModuleBuilder/parsers/views/UndeployedSidecarSubpanelImplementation.php';
            $this->implementation = new UndeployedSidecarSubpanelImplementation($subpanelName, $moduleName, $packageName, $client);
        }

        $this->_viewdefs = $this->implementation->getViewdefs();
        $this->_paneldefs = $this->implementation->getPanelDefs();
        $this->_fielddefs = $this->implementation->getFieldDefs();
        $this->columns = array('LBL_DEFAULT' => 'getDefaultFields', 'LBL_HIDDEN' => 'getAvailableFields');
    }
}
