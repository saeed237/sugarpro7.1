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

/**
 * Rebuild image sprites
 */
class SugarUpgradeRebuildSprites extends UpgradeScript
{
    public $order = 7000;
    public $type = self::UPGRADE_CUSTOM;

    public function run()
    {
        require_once('modules/Administration/SugarSpriteBuilder.php');
        $sb = new SugarSpriteBuilder();
        $sb->cssMinify = true;
        $sb->fromSilentUpgrade = true;
        $sb->silentRun = true;

        // add common image directories
        $sb->addDirectory('default', 'include/images');
        $sb->addDirectory('default', 'themes/default/images');
        $sb->addDirectory('default', 'themes/default/images/SugarLogic');

        // add all theme image directories
        foreach(array('themes', 'custom/themes') as $themedir) {
            if(!file_exists($themedir)) continue;
            foreach(new DirectoryIterator($themedir) as $fileInfo) {
                if($fileInfo->isDot() || !$fileInfo->isDir()) continue;
                $dir = $fileInfo->getFilename();
                if($dir == 'default' || !is_dir("$themedir/{$dir}/images")) continue;
                $sb->addDirectory($dir, "$themedir/{$dir}/images");
            }
        }

        // generate the sprite goodies
        // everything is saved into cache/sprites
        $sb->createSprites();
    }
}
