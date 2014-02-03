<?php
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
require_once 'UpgradeDriver.php';

/**
 * Command-line upgrader
 */
class CliUpgrader extends UpgradeDriver
{
    protected $options = array(
    // required, short, long
        "zip" => array(true, 'z', 'zip'),
        "log" => array(true, 'l', 'log'),
        "source_dir" => array(true, 's', 'source'),
        "admin" => array(true, 'u', 'user'),
        "backup" => array(false, 'b', 'backup'),
        "script_mask" => array(false, 'm', 'mask'),
        "stage" => array(false, 'S', 'stage'),
    );

    /**
     * Script mask types
     * @var array[int]
     */
    protected $maskTypes = array(
        'core' => UpgradeScript::UPGRADE_CORE,
        'db' => UpgradeScript::UPGRADE_DB,
        'custom' => UpgradeScript::UPGRADE_CUSTOM,
        'all' => UpgradeScript::UPGRADE_ALL,
        'none' => 0,
    );

    /*
     * CLI arguments: Zipfile Logfile Sugardir Adminuser [Stage]
     */
    public function runStage($stage)
    {
        $argv = $this->context['argv'];
        $cmd = "{$this->context['php']} -f {$this->context['script']} -- " . $this->buildArgString(array("stage" => $stage));
        $this->log("Running $cmd");
        passthru($cmd, $retcode);
        return ($retcode == 0);
    }

    protected static function bannerError($msg)
    {
    	echo "*******************************************************************************\n";
    	echo "*** ERROR: $msg\n";
    	echo "FAILURE\n";
    }

    protected function argError($msg)
    {
        $this->bannerError($msg);
        $this->usage();
        exit(1);
    }

    protected static function usage()
    {
        list($version, $build) = static::getVersion();
$usage =<<<eoq2
CLI Upgrader v.$version (build $build)
Usage:
php CliUpgrader.php -z upgrade.zip -l logFile -s pathToSugarInstance -u admin-user

Example:
    php CliUpgrader.php -z [path-to-upgrade-package/]SugarEnt-Upgrade-6.5.x-to-7.1.0.zip -l [path-to-log-file/]silentupgrade.log -s path-to-sugar-instance/ -u admin

Arguments:
    -z/--zip upgrade.zip                 : Upgrade package file.
    -l/--log logFile                     : Upgarde log file (by default relative to instance dir)
    -s/--source pathToSugarInstance      : Sugar instance being upgraded.
    -u/--user admin-user                 : admin user performing the upgrade
Optional arguments:
    -m/--mask scriptMask                 : Script mask - which types of scripts to run.
                                           Supported types: core, db, custom, all, none. Default is all.
    -b/--backup 0/1                      : Create backup of deleted files? 0 means no backup, default is 1.
    -S/--stage stage                     : Run specific stage of the upgrader. 'continue' means start where it stopped last time.

eoq2;
        echo $usage;
    }

    protected function verifyArguments()
    {
        if(empty($this->context['source_dir']) || !is_dir($this->context['source_dir'])) {
            self::argError("Source directory parameter must be a valid directory.");
        }

        if(!is_file("{$this->context['source_dir']}/include/entryPoint.php") || !is_file("{$this->context['source_dir']}/config.php")) {
            self::argError("{$this->context['source_dir']} is not a SugarCRM directory.");
        }

        if(!is_readable("{$this->context['source_dir']}/include/entryPoint.php") || !is_readable("{$this->context['source_dir']}/config.php")) {
            self::argError("{$this->context['source_dir']} is not a accessible.");
        }

        if(!is_file($this->context['zip'])) { // valid zip?
            self::argError("Zip file argument must be a full path to the patch file.");
        }

        if(!is_readable($this->context['zip'])) { // valid zip?
            self::argError("Zip archive is not readable: {$this->context['zip']}");
        }
        return true;
    }

    /**
     * Parse script mask
     * @param string $mask
     * @return int
     */
    public function parseScriptMask($mask)
    {
        if(is_numeric($mask)) {
            return intval($mask);
        }
        if(empty($mask)) {
            $this->argError("Empty script mask");
            return $this->maskTypes['all'];
        }
        $parts = explode(',', $mask);
        $mask = 0;
        if(empty($parts)) {
            $this->argError("Empty script mask");
            return $this->maskTypes['all'];
        }
        foreach($parts as $part) {
            if(!isset($this->maskTypes[$part])) {
                $this->argError("Unknown script mask: $part");
                continue;
            }
            $mask |= $this->maskTypes[$part];
        }
        return $mask;
    }

    /**
     * Fix values in the context
     * @param array $context
     * @return array
     */
    public function fixupContext($context)
    {
        $context['zip'] = realpath($context['zip']);
        $context['source_dir'] = realpath($context['source_dir']);
        if(isset($context['script_mask'])) {
            $context['script_mask'] = $this->parseScriptMask($context['script_mask']);
        }
        return $context;
    }

    /**
     * Map CLI arguments into context entries
     * @param array $argv
     * @return array
     */
    public function mapNamedArgs($argv)
    {
        $opt = '';
        $context = $longopt = array();
        foreach($this->options as $ctx => $data)
        {
            $opt .= $data[1].':';
            $longopt[] = $data[2].':';
        }
        /* FIXME: getopt always uses global argv */
        $opts = getopt($opt, $longopt);

        if(empty($opts)) {
            $this->argError("Invalid upgrader options");
            return array(); // never happens
        }

        foreach($this->options as $ctx => $data) {
            $val = null;
            if(isset($opts[$data[1]])) {
                $val = $opts[$data[1]];
            } elseif(isset($opts[$data[2]])) {
                $val = $opts[$data[2]];
            }
            if(is_null($val)) {
                if($data[0]) {
                    $this->argError("Required option '{$data[2]}' missing");
                }
                continue;
            } elseif(is_array($val)) {
                $this->argError("Multiple valued for '{$data[2]}' are not allowed");
            }

            $context[$ctx] = $val;
        }
        return $context;
    }

    /**
     * Map CLI arguments into context entries
     * @param array $argv
     * @return array
     */
    public function mapArgs($argv)
    {
        if(!empty($argv[1]) && $argv[1][0] == '-') {
            /* named options */
            $context = $this->mapNamedArgs($argv);
        } else {
            $i = 1;
            $context = array();
            foreach($this->options as $ctx => $data) {
                if(isset($argv[$i])) {
                    if(!$data[0] && $argv[$i][0] == '-') {
                       // if we're positional then no options
                        $this->argError("Positional and named arguments can not be mixed");
                        continue; // never happens
                    }
                    $context[$ctx] = $argv[$i];
                    $i++;
                } else {
                    if($data[0]) {
                        $this->argError("Insufficient arguments");
                        continue; // never happens
                    } else {
                        break;
                    }
                }
            }
        }

        $context = $this->fixupContext($context);
        return $context;
    }

    /**
     * Parse CLI arguments into context
     * @param array $argv
     * @return array
     */
    public function parseArgs($argv)
    {
        if(defined('PHP_BINDIR')) {
        	$php_path = PHP_BINDIR."/";
        } else {
        	$php_path = '';
        }
        if(!file_exists($php_path . 'php')) {
            $php_path = '';
        }
        $context = $this->mapArgs($argv);
        $context['php'] = $php_path."php";
        $context['script'] = __FILE__;
        $context['argv'] = $argv;
        $this->context = $context;
        $this->log("Setting context to: ".var_export($context, true));
        return $context;
    }

    /**
     * Execution starts here
     */
    public static function start()
    {
        global $argv;
        $upgrader = new static();
        $upgrader->parseArgs($argv);
        $upgrader->verifyArguments($argv);
        $upgrader->init();
        if(isset($upgrader->context['stage'])) {
            $stage = $upgrader->context['stage'];
        } else {
            $stage = null;
        }
        if($stage && $stage != 'continue') {
            // Run one step
            if($upgrader->run($stage)) {
                exit(0);
            } else {
                if(!empty($upgrader->error)) {
                    echo "ERROR: {$upgrader->error}\n";
                }
                exit(1);
            }
        } else {
            // whole loop
            if($stage != 'continue') {
                // reset state
                $upgrader->cleanState();
            } else {
                // remove 'continue' from the array
                array_pop($upgrader->context['argv']);
            }
            while(1) {
                $res = $upgrader->runStep($stage);
                if($res === false) {
                    if($stage) {
                        echo "***************         Step \"{$stage}\" FAILED!\n";
                    }
                    exit(1);
                }
                if($stage) {
                    echo "***************         Step \"{$stage}\" OK\n";
                }
                if($res === true) {
                    // we're done successfully
                    echo "***************         SUCCESS!\n";
                    exit(0);
                }
                $stage = $res;
            }
        }
    }

    /**
     * Build argv string from an array
     * @param string $arguments
     * @return string
     */
    protected function buildArgString($arguments=array())
    {
    	$argument_string = '';

    	$arguments = array_merge($this->context, $arguments);

        foreach($this->options as $ctx => $data) {
            if(!$data[0] && !isset($arguments[$ctx])) {
                continue;
            }

            $argument_string .= sprintf(" -%s %s", $data[1], escapeshellarg($arguments[$ctx]));
        }

    	return $argument_string;
   }

}

if(empty($argv[0]) || basename($argv[0]) != basename(__FILE__)) return;

$sapi_type = php_sapi_name();
if (substr($sapi_type, 0, 3) != 'cli') {
    die("This is command-line only script");
}
CliUpgrader::start();

