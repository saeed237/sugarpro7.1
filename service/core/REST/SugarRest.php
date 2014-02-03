<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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
 * This class is a base class implementation of REST protocol
 * @api
 */
 class SugarRest{

 	/**
 	 * Constructor
 	 *
 	 * @param String $implementation - name of the implementation class
 	 */
	function __construct($implementation){
		$this->implementation = $implementation;
	} // fn

	/**
	 * It will json encode version of the input object
	 *
	 * @param array $input - assoc array of input values: key = param name, value = param type
	 * @return String - print's $input object
	 */
	function generateResponse($input){
		print_r($input);
	} // fn

	/**
	 * This method calls functions on the implementation class and returns the output or Fault object in case of error to client
	 *
	 * @return unknown
	 */
	function serve(){
		if(empty($_REQUEST['method']) || !method_exists($this->implementation, $_REQUEST['method'])){
			if (empty($_REQUEST['method'])) {
				echo '<pre>';
				$reflect = new ReflectionClass(get_class($this->implementation));
				$restWSDL = $reflect->__toString();
				$restWSDL = preg_replace('/@@.*/', "", $restWSDL);
				echo $restWSDL;
			}else{
				$er = new SoapError();
				$er->set_error('invalid_call');
				$this->fault($er);
			}
		}else{
			$method = $_REQUEST['method'];
			return  $this->implementation->$method();
		} // else
	} // fn

	/**
	 * This function sends response to client containing error object
	 *
	 * @param SoapError $errorObject - This is an object of type SoapError
	 * @access public
	 */
	function fault($errorObject){
		$this->faultServer->generateFaultResponse($errorObject);

	} // fn

	function generateFaultResponse($errorObject){
		//ob_clean();
		$GLOBALS['log']->info('In SugarRest->fault. Setting fault object on response');
		header('HTTP/1.1 500 Internal Server Error');
		header('Content-Type: text/html; charset="ISO-8859-1"');
		echo '<br>500 Internal Server Error <br>';
		if(is_object($errorObject)){
			$error = $errorObject->number . ': ' . $errorObject->name . '<br>' . $errorObject->description;
			$GLOBALS['log']->error($error);
			echo  $error;
		}else{
			$GLOBALS['log']->error(var_export($errorObject, true));
			print_r($errorObject);
		} // else
	}

} // clazz
