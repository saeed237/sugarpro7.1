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


require_once('include/resource/Observers/ResourceObserver.php');

class SoapResourceObserver extends ResourceObserver {

private $soapServer;

function SoapResourceObserver($module) {
   parent::ResourceObserver($module);
}


/**
 * set_soap_server
 * This method accepts an instance of the nusoap soap server so that a proper
 * response can be returned when the notify method is triggered.
 * @param $server The instance of the nusoap soap server
 */
function set_soap_server(& $server) {
   $this->soapServer = $server;
}


/**
 * notify
 * Soap implementation to notify the soap clients of a resource management error
 * @param msg String message to possibly display
 */
public function notify($msg = '') {

header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
header('Content-Type: text/xml; charset="ISO-8859-1"');
$error = new SoapError();
$error->set_error('resource_management_error');
//Override the description
$error->description = $msg;
$this->soapServer->methodreturn = array('result'=>$msg, 'error'=>$error->get_soap_array());
$this->soapServer->serialize_return();	
$this->soapServer->send_response();
sugar_cleanup(true);

}	
	
}
?>