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


$login_xml = <<<LOG
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
xmlns:impl="G2M_Organizers">
  <soap:Body
soap:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <impl:logon>
      <id xsi:type="xsd:string"></id>
      <password xsi:type="xsd:string"></password>
      <version xsi:type="xsd:long">2</version>
    </impl:logon>
  </soap:Body>
</soap:Envelope>
LOG;

$schedule_xml = <<<SCH
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
xmlns:impl="G2M_Organizers">
  <soap:Body soap:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <impl:createMeeting>
      <connectionId xsi:type="xsd:string"></connectionId>
      <meetingParameters xsi:type="impl:MeetingParameters">
        <subject xsi:type="xsd:string"></subject>
        <startTime xsi:type="xsd:dateTime"></startTime>
        <timeZoneKey xsi:type="xsd:string">50</timeZoneKey>
        <conferenceCallInfo xsi:type="xsd:string">Hybrid</conferenceCallInfo>
        <meetingType xsi:type="xsd:string">Scheduled</meetingType>
        <passwordRequired xsi:type="xsd:boolean"></passwordRequired>
      </meetingParameters>
    </impl:createMeeting>
  </soap:Body>
</soap:Envelope>
SCH;

$host_xml = <<<HST
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
xmlns:impl="G2M_Organizers">
  <soap:Body soap:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <impl:startMeeting>
      <connectionId xsi:type="xsd:string"></connectionId>
      <meetingId xsi:type="xsd:long"></meetingId>
      <uniqueMeetingId xsi:type="xsd:string"></uniqueMeetingId>
    </impl:startMeeting>
  </soap:Body>
</soap:Envelope>
HST;

$logoff_xml = <<<LGF
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
xmlns:impl="G2M_Organizers">
  <soap:Body
soap:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <impl:logoff>
      <connectionId
xsi:type="xsd:string"></connectionId>
    </impl:logoff>
  </soap:Body>
</soap:Envelope>
LGF;

$edit_xml = <<<EDT
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" 
   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
   xmlns:xsd="http://www.w3.org/2001/XMLSchema"
   xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
   xmlns:impl="G2M_Organizers">
  <soap:Body soap:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <impl:updateMeeting>
      <connectionId xsi:type="xsd:string"></connectionId>
      <meetingId xsi:type="xsd:long"></meetingId>
      <uniqueMeetingId xsi:type="xsd:string"></uniqueMeetingId>
      <meetingParameters xsi:type="impl:MeetingParameters">
        <subject xsi:type="xsd:string"></subject>
        <startTime xsi:type="xsd:dateTime"></startTime>
        <timeZoneKey xsi:type="xsd:string">50</timeZoneKey>
        <conferenceCallInfo xsi:type="xsd:string">Hybrid</conferenceCallInfo>
        <meetingType xsi:type="xsd:string">Scheduled</meetingType>
        <passwordRequired xsi:type="xsd:boolean"></passwordRequired>
      </meetingParameters>
    </impl:updateMeeting>
  </soap:Body>
</soap:Envelope>
EDT;
