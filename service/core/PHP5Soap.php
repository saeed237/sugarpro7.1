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

<?php
require('service/core/SugarSoapService.php');
require('vendor/nusoap//nusoap.php');

abstract class PHP5Soap extends SugarSoapService{
	private $nusoap_server = null;
	public function __construct($url){
		$this->soapURL = $url;
		ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
		global $HTTP_RAW_POST_DATA;
		if(!isset($HTTP_RAW_POST_DATA)) {
			$HTTP_RAW_POST_DATA = file_get_contents('php://input');
		}
		parent::__construct();
	}

	public function setObservers() {

	} // fn

	/**
	 * Serves the Soap Request
	 * @return
	 */
	public function serve(){
		ob_clean();
		global $HTTP_RAW_POST_DATA;
		$GLOBALS['log']->debug("I am here1 ". $HTTP_RAW_POST_DATA);
		$qs = '';
		if (isset($_SERVER['QUERY_STRING'])) {
			$qs = $_SERVER['QUERY_STRING'];
		} elseif (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
			$qs = $HTTP_SERVER_VARS['QUERY_STRING'];
		} else {
			$qs = '';
		}

		if (stristr($qs, 'wsdl') || $HTTP_RAW_POST_DATA == ''){
			$wsdlCacheFile = $this->getWSDLPath(false);
			if (stristr($qs, 'wsdl')) {
			    $contents = @sugar_file_get_contents($wsdlCacheFile);
			    if($contents !== false) {
					header("Content-Type: text/xml; charset=ISO-8859-1\r\n");
					print $contents;
			    } // if
			} else {
				$this->nusoap_server->service($HTTP_RAW_POST_DATA);
			} // else
		} else {
			$this->server->handle();
		}
		ob_end_flush();
		flush();
	}

	private function generateSoapServer() {
		if ($this->server == null) {
			$soap_url = $this->getSoapURL() . "?wsdl";
			$this->server = new SoapServer($this->getWSDLPath(true), array('soap_version'=>SOAP_1_2, 'encoding'=>'ISO-8859-1'));
		}
	} // fn

	private function generateNuSoap() {
		if ($this->nusoap_server == null) {
			$this->nusoap_server = new soap_server();
			$this->nusoap_server->configureWSDL('sugarsoap', $this->getNameSpace(), "");
			$this->nusoap_server->register_class('SugarWebServiceImpl');
		} // if
	} // fn

	public function getWSDLPath($generateWSDL) {
		$wsdlURL = $this->getSoapURL().'?wsdl';
		$wsdlCacheFile = 'upload://wsdlcache-' . md5($wsdlURL);

		if ($generateWSDL) {
			$oldqs = $_SERVER['QUERY_STRING'];
			$_SERVER['QUERY_STRING'] = "wsdl";
			$this->nusoap_server->service($wsdlURL);
			$_SERVER['QUERY_STRING'] = $oldqs;
			file_put_contents($wsdlCacheFile, ob_get_contents());
			return $wsdlCacheFile;
		    //ob_clean();
		} else {
			return $wsdlCacheFile;
		}

	} // fn

	public function getNameSpace() {
		return $this->soapURL;
	} // fn

	/**
	 * This function allows specifying what version of PHP soap to use
	 * PHP soap supports version 1.1 and 1.2.
	 * @return
	 * @param $version String[optional]
	 */
	public function setSoapVersion($version='1.1'){
		//PHP SOAP supports 1.1 and 1.2 only currently
		$this->soap_version = ($version == '1.2')?'1.2':'1.1';
	}

	public function error($errorObject){
		$this->server->fault($errorObject->getFaultCode(), $errorObject->getName(), '', $errorObject->getDescription()); 	}

	public function registerImplClass($implementationClass){
		if (empty($implementationClass)) {
			$implementationClass = $this->implementationClass;
		} // if
		$this->generateSoapServer();
		$this->server->setClass($implementationClass);
		parent::setObservers();
	}

	function registerClass($registryClass){
		$this->registryClass = $registryClass;
	}

	public function registerType($name, $typeClass, $phpType, $compositor, $restrictionBase, $elements, $attrs=array(), $arrayType=''){
		$this->nusoap_server->wsdl->addComplexType($name, $typeClass, $phpType, $compositor, $restrictionBase, $elements, $attrs, $arrayType);
  	}

	function registerFunction($function, $input, $output){
		if(in_array($function, $this->excludeFunctions))return;
		if ($this->nusoap_server == null) {
			$this->generateNuSoap();
		} // if
		$this->nusoap_server->register($function, $input, $output, $this->getNameSpace());

	}

}
