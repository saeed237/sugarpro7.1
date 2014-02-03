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

 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 

define ( 'MB_PACKAGE_PATH', 'custom/modulebuilder/packages' ) ;
define('MB_PACKAGE_BUILD', 'custom' . DIRECTORY_SEPARATOR . 'modulebuilder' . DIRECTORY_SEPARATOR . 'builds');
require_once ('modules/ModuleBuilder/MB/MBPackage.php') ;

class ModuleBuilder
{
    var $packages = array ( ) ;

    function getPackageList ()
    {
        static $list = array ( ) ;
        if (! empty ( $list ) || ! file_exists ( MB_PACKAGE_PATH ))
            return $list ;
        $d = dir ( MB_PACKAGE_PATH ) ;
        while ( $e = $d->read () )
        {
            if (file_exists ( MB_PACKAGE_PATH . '/' . $e . '/manifest.php' ))
            {
                $list [] = $e ;
            }
        }
        sort ( $list ) ; // order important as generate_nodes_array in Tree.php later loops over this by foreach to generate the package list
        return $list ;
    
    }

    /**
     * @param $name
     * @return MBPackage
     */
    function getPackage ($name)
    {
        if (empty ( $this->packages [ $name ] ))
            $this->packages [ $name ] = new MBPackage ( $name ) ;

        return $this->packages [ $name ] ;
    }
    
    function getPackageKey ($name)
    {
        $manifestPath = MB_PACKAGE_PATH . '/' . $name . '/manifest.php' ;
        if (file_exists ( $manifestPath ))
        {
            require( $manifestPath ) ;
            if(!empty($manifest))
                return $manifest['key'];
        }
        return false ;
    }

    function &getPackageModule ($package , $module)
    {
        $this->getPackage ( $package ) ;
        $this->packages [ $package ]->getModule ( $module ) ;
        return $this->packages [ $package ]->modules [ $module ] ;
    }

    function save ()
    {
        $packages = array_keys ( $this->packages ) ;
        foreach ( $packages as $package )
        {
            $this->packages [ $package ]->save () ;
        }
    }

    function build ()
    {
        $packages = array_keys ( $this->packages ) ;
        foreach ( $packages as $package )
        {
            if (count ( $packages ) == 1)
            {
                $this->packages [ $package ]->build ( true ) ;
            } else
            {
                $this->packages [ $package ]->build ( false ) ;
            }
        }
    }

    function getPackages ()
    {
        if (empty ( $this->packages ))
        {
            $list = $this->getPackageList () ;
            foreach ( $list as $package )
            {
                if (! empty ( $this->packages [ $package ] ))
                    continue ;
                $this->packages [ $package ] = new MBPackage ( $package ) ;
            }
        }
    }

    function getNodes ()
    {
        $this->getPackages () ;
        $nodes = array ( ) ;
        foreach ( array_keys ( $this->packages ) as $name )
        {
            $nodes [] = $this->packages [ $name ]->getNodes () ;
        }
        return $nodes ;
    }

    /**
     * Function return module name and this aliases
     *
     * @param string $module
     * @return array $aliases
     */
    static public function getModuleAliases($module)
    {
        $aliases = array($module);
        $relate_arr = array(
            'Users' => 'Employees',
            'Employees' => 'Users'
        );

        if (isset($relate_arr[$module])){
            $aliases[] = $relate_arr[$module];
        }

        return $aliases;
    }

}
