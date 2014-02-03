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

 * Description: Handles Generic Widgets 
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/




class DashletCacheBuilder {
    
    /**
     * Builds the cache of Dashlets by scanning the system
     */
    function buildCache() {
        global $beanList;
        $dashletFiles = array();
        $dashletFilesCustom = array();
        
        getFiles($dashletFiles, 'modules', '/^.*\/Dashlets\/[^\.]*\.php$/');
        getFiles($dashletFilesCustom, 'custom/modules', '/^.*\/Dashlets\/[^\.]*\.php$/');
        $cacheDir = create_cache_directory('dashlets/');
        $allDashlets = array_merge($dashletFiles, $dashletFilesCustom);
        $dashletFiles = array();
        foreach($allDashlets as $num => $file) {
            if(substr_count($file, '.meta') == 0) { // ignore meta data files
                $class = substr($file, strrpos($file, '/') + 1, -4);
                $dashletFiles[$class] = array();
                $dashletFiles[$class]['file'] = $file;
                $dashletFiles[$class]['class'] = $class;
                if(is_file(preg_replace('/(.*\/.*)(\.php)/Uis', '$1.meta$2', $file))) { // is there an associated meta data file?
                    $dashletFiles[$class]['meta'] = preg_replace('/(.*\/.*)(\.php)/Uis', '$1.meta$2', $file);
                    require($dashletFiles[$class]['meta']);
                    if ( isset($dashletMeta[$class]['module']) )
                        $dashletFiles[$class]['module'] = $dashletMeta[$class]['module'];
                }
                
                $filesInDirectory = array();
                getFiles($filesInDirectory, substr($file, 0, strrpos($file, '/')), '/^.*\/Dashlets\/[^\.]*\.icon\.(jpg|jpeg|gif|png)$/i');
                if(!empty($filesInDirectory)) {
                    $dashletFiles[$class]['icon'] = $filesInDirectory[0]; // take the first icon we see
                }
            }
        }
        
        write_array_to_file('dashletsFiles', $dashletFiles, $cacheDir . 'dashlets.php');
    }
}
?>