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
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 7/21/11
 * Time: 11:58 AM
 * To change this template use File | Settings | File Templates.
 */
require_once('service/core/REST/SugarRest.php');

class SugarRestDecorator extends SugarRest{
    protected $decoratedClass;

    public function __construct($decoratedClass){
        $this->decoratedClass = $decoratedClass;
	}

    public function serve(){
        return $this->decoratedClass->serve();
    }
}
 
