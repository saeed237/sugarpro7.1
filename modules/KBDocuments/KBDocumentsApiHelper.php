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


require_once('data/SugarBeanApiHelper.php');

/**
 * This class is here to add in the file information to the KBDocuments so that it can be easily displayed by remote consumers of the API. Otherwise you have to traverse a number of links to pull up this information.
 */
class KBDocumentsApiHelper extends SugarBeanApiHelper
{

    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array() )
    {

        // bug 56834 - the api doesn't return kbdoc_approver_name
        $isKbApprover = in_array('kbdoc_approver_name', $fieldList);

        //add kbdoc_approver_id if not in fieldList
        if ( $isKbApprover && !in_array('kbdoc_approver_id', $fieldList) ) {
            $fieldList[] = 'kbdoc_approver_id';
        }
        $data = parent::formatForApi($bean, $fieldList, $options);

        // bug 56834 - manually fill kbdoc_approver_name if in fieldList
        if ( (empty($fieldList) || $isKbApprover) && isset($data['kbdoc_approver_id']) ) {
            $user = new User();
            $user->retrieve($data['kbdoc_approver_id'],true);
            $data['kbdoc_approver_name'] = $user->name;
        }

        if ( empty($fieldList) || in_array('attachment_list',$fieldList) ) {
            $db = DBManagerFactory::getInstance();

            $query = "SELECT rev.id rev_id, rev.filename filename, kbrev.id docrev_id FROM kbdocument_revisions kbrev LEFT JOIN document_revisions rev ON (kbrev.document_revision_id = rev.id) WHERE kbrev.kbdocument_id = '".$bean->id."' AND kbrev.deleted = 0 AND rev.deleted = 0 AND kbrev.kbcontent_id is NULL";
            $ret = $db->query($query,true);
            $files = array();
            while ( $row = $db->fetchByAssoc($ret) ) {
                $thisFile = array();
                $thisFile['document_revision_id'] = $row['rev_id'];
                $thisFile['name'] = $row['filename'];
                $thisFile['kbdocument_revision_id'] = $row['docrev_id'];
                $thisFile['uri'] = $this->api->getResourceURI(array('DocumentRevisions',$row['rev_id'],'file','filename'));
                $files[] = $thisFile;
            }
            $data['attachment_list'] = $files;
        }

        return $data;
    }
}
