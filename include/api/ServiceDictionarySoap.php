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


require_once('include/api/ServiceDictionary.php');

class ServiceDictionarySoap extends ServiceDictionary {
    public function loadDictionary() {
        $this->dict = $this->loadDictionaryFromStorage('soap');
    }

    public function preRegisterEndpoints() {
        $this->functionBuffer = array();
        $this->typeBuffer = array();
    }
    
    public function registerEndpoints($newEndpoints, $file, $fileClass, $platform, $isCustom ) {
        if ( ! is_array($newEndpoints) ) {
            return;
        }
        
        $newFuncs = $newEndpoints['functions'];
        $newTypes = $newEndpoints['types'];

        foreach ( $newFuncs as $func ) {
            $this->functionBuffer[$func['methodName']] = $func;
        }
        
        foreach ( $newTypes as $type ) {
            $this->typeBuffer[$type['typeName']] = $type;
        }
    }

    public function getRegisteredEndpoints() {
        // Using the function and type buffers, I need to generate a new WSDL, and cache the function list.
        $returnData['functions'] = $this->functionBuffer;
        $returnData['typeBuffer'] = $this->typeBuffer;
        
        $returnData['wsdl'] = $this->generateWsdl($this->functionBuffer, $this->typeBuffer);

        return $returnData;
    }

    protected function generateWsdl( $rawFunctions, $rawTypes ) {
        $doc = new DOMDocument('1.0','UTF-8');
        $definitions = $doc->createElementNS('http://schemas.xmlsoap.org/wsdl/','wsdl:definitions');
        $doc->appendChild($definitions);
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:wsdl', 'http://schemas.xmlsoap.org/wsdl/');
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:soapenc12', 'http://www.w3.org/2003/05/soap-encoding');
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:soapenc11', 'http://schemas.xmlsoap.org/soap/encoding/');
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:soap12', 'http://www.w3.org/2003/05/soap-envelope');
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:soap11', 'http://schemas.xmlsoap.org/soap/envelope/');
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:wsdlsoap', 'http://schemas.xmlsoap.org/wsdl/soap/');
        $definitions->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:tns', 'http://www.sugarcrm.com/sugarcrm');
        $definitions->setAttribute('targetNamespace','http://www.sugarcrm.com/sugarcrm');
        
        // Types
        $types = $doc->createElement('wsdl:types');
        $definitions->appendChild($types);
        $schema = $doc->createElement('xsd:schema');
        $schema->setAttribute('targetNamespace','http://www.sugarcrm.com/sugarcrm');
        $schema->setAttribute('elementFormDefault','qualified');
        $schema->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $types->appendChild($schema);
        
        // Port Type
        $portType = $doc->createElement('wsdl:portType');
        $portType->setAttribute('name','SugarSoapPort');
        $definitions->appendChild($portType);
        
        // Binding
        $binding = $doc->createElement('wsdl:binding');
        $binding->setAttribute('name','SugarSoapBinding');
        $binding->setAttribute('type','tns:SugarSoapPort');
        $soapBinding = $doc->createElement('wsdlsoap:binding');
        $soapBinding->setAttribute('style','document');
        $soapBinding->setAttribute('transport','http://schemas.xmlsoap.org/soap/http');
        $binding->appendChild($soapBinding);
        $definitions->appendChild($binding);
        
        // Service
        $service = $doc->createElement('wsdl:service');
        $service->setAttribute('name','SugarSoapService');
        $servicePort = $doc->createElement('wsdl:port');
        $servicePort->setAttribute('name','SugarSoapPort');
        $servicePort->setAttribute('binding','tns:SugarSoapBinding');
        $servicePortAddress = $doc->createElement('wsdlsoap:address');
        // FIXME: Change to a real address
        $servicePortAddress->setAttribute('location','http://localhost/sidecar/ent/api/soap.php');
        $servicePort->appendChild($servicePortAddress);
        $service->appendChild($servicePort);
        $definitions->appendChild($service);

        foreach ( $rawTypes as $rawType ) {
            $baseElement = $doc->createElement('xsd:element');
            $baseElement->setAttribute('name',$rawType['typeName']);            
            $schema->appendChild($baseElement);
            $complexType = $doc->createElement('xsd:complexType');
            $baseElement->appendChild($complexType);
            $childType = $doc->createElement('xsd:all');
            $complexType->appendChild($childType);
            
            foreach ( $rawType['fields'] as $rawFieldName => $rawField ) {
                $field = $doc->createElement('xsd:element');
                $childType->appendChild($field);
                $field->setAttribute('name',$rawFieldName);
                $field->setAttribute('type',$rawField['type']);
                if(isset($rawField['optional']) && $rawField['optional']) {
                    $field->setAttribute('nillable','true');
                }
                foreach ( array('minOccurs','maxOccurs') as $otherParam ) {
                    if ( isset($rawField[$otherParam]) ) {
                        $field->setAttribute($otherParam,$rawField[$otherParam]);
                    }
                }
            }
        }

        

        foreach ( $rawFunctions as $rawFunction ) {
            // requestMessage
            $requestMessage = $doc->createElement('wsdl:message');
            $requestMessage->setAttribute('name',$rawFunction['methodName'].'Request');
            foreach ( $rawFunction['requestVars'] as $partName => $partType ) {
                $part = $doc->createElement('wsdl:part');
                $part->setAttribute('name',$partName);
                $part->setAttribute('element',$partType);
                $requestMessage->appendChild($part);
            }
            $definitions->appendChild($requestMessage);

            // responseMessage
            $responseMessage = $doc->createElement('wsdl:message');
            $responseMessage->setAttribute('name',$rawFunction['methodName'].'Response');
            foreach ( $rawFunction['returnVars'] as $partName => $partType ) {
                $part = $doc->createElement('wsdl:part');
                $part->setAttribute('name',$partName);
                $part->setAttribute('element',$partType);
                $responseMessage->appendChild($part);
            }
            $definitions->appendChild($responseMessage);
            
            // Port Type operation
            $operation = $doc->createElement('wsdl:operation');
            $operation->setAttribute('name',$rawFunction['methodName']);
            $documentation = $doc->createElement('wsdl:documentation');
            $documentation->nodeValue = $rawFunction['shortHelp'];
            $operation->appendChild($documentation);
            $input = $doc->createElement('wsdl:input');
            $input->setAttribute('name',$rawFunction['methodName'].'Request');
            $input->setAttribute('message','tns:'.$rawFunction['methodName'].'Request');
            $operation->appendChild($input);
            $output = $doc->createElement('wsdl:output');
            $output->setAttribute('name',$rawFunction['methodName'].'Response');
            $output->setAttribute('message','tns:'.$rawFunction['methodName'].'Response');
            $operation->appendChild($output);
            $portType->appendChild($operation);


            // Binding operation
            $operation = $doc->createElement('wsdl:operation');
            $operation->setAttribute('name',$rawFunction['methodName']);
            $documentation = $doc->createElement('wsdl:documentation');
            $documentation->nodeValue = $rawFunction['shortHelp'];
            $operation->appendChild($documentation);
            $soapOperation = $doc->createElement('wsdlsoap:operation');
            $soapOperation->setAttribute('soapAction','urn:'.$rawFunction['methodName']);
            $operation->appendChild($soapOperation);
            $input = $doc->createElement('wsdl:input');
            $input->setAttribute('name',$rawFunction['methodName'].'Request');
            $soapBody = $doc->createElement('wsdlsoap:body');
            $soapBody->setAttribute('use','literal');
            $input->appendChild($soapBody);
            $operation->appendChild($input);
            $output = $doc->createElement('wsdl:output');
            $output->setAttribute('name',$rawFunction['methodName'].'Response');
            $soapBody = $doc->createElement('wsdlsoap:body');
            $soapBody->setAttribute('use','literal');
            $output->appendChild($soapBody);
            $operation->appendChild($output);
            $binding->appendChild($operation);
            
            
        }
            
        return $doc->saveXML();
    }
}