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

// This will need to be pathed properly when packaged
require_once 'SidecarAbstractMetaDataUpgrader.php';

class SidecarSearchMetaDataUpgrader extends SidecarAbstractMetaDataUpgrader
{
    /**
     * Handles the actual upgrading for search metadata. This process is much
     * simpler in that no manipulation of defs is necessary. We simply move the 
     * file contents into place in the new structure.
     * 
     * @return bool
     */
    public function upgrade() {
        if (file_exists($this->fullpath)) {
            // Save the new file and report it
            return $this->handleSave();
        }
        
        return false;
    }
    
    /**
     * Does nothing for search since search is simply a file move.
     */
    public function convertLegacyViewDefsToSidecar() {}
    
    /**
     * Simply gets the current file contents
     * 
     * @return string
     */
    public function getNewFileContents() {
        return file_get_contents($this->fullpath);
    }
}