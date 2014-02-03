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


require_once('clients/base/api/ModuleApi.php');

class RelateRecordApi extends ModuleApi {
    public function registerApiRest() {
        return array(
            'fetchRelatedRecord' => array(
                'reqType'   => 'GET',
                'path'      => array('<module>','?',     'link','?',        '?'),
                'pathVars'  => array('module',  'record','',    'link_name','remote_id'),
                'method'    => 'getRelatedRecord',
                'shortHelp' => 'Fetch a single record related to this module',
                'longHelp'  => 'include/api/help/module_record_link_link_name_remote_id_get_help.html',
            ),
            'createRelatedRecord' => array(
                'reqType'   => 'POST',
                'path'      => array('<module>','?',     'link','?'),
                'pathVars'  => array('module',  'record','',    'link_name'),
                'method'    => 'createRelatedRecord',
                'shortHelp' => 'Create a single record and relate it to this module',
                'longHelp'  => 'include/api/help/module_record_link_link_name_post_help.html',
            ),
            'createRelatedLink' => array(
                'reqType'   => 'POST',
                'path'      => array('<module>','?',     'link','?'        ,'?'),
                'pathVars'  => array('module',  'record','',    'link_name','remote_id'),
                'method'    => 'createRelatedLink',
                'shortHelp' => 'Relates an existing record to this module',
                'longHelp'  => 'include/api/help/module_record_link_link_name_remote_id_post_help.html',
            ),
            'updateRelatedLink' => array(
                'reqType'   => 'PUT',
                'path'      => array('<module>','?',     'link','?'        ,'?'),
                'pathVars'  => array('module',  'record','',    'link_name','remote_id'),
                'method'    => 'updateRelatedLink',
                'shortHelp' => 'Updates relationship specific information ',
                'longHelp'  => 'include/api/help/module_record_link_link_name_remote_id_put_help.html',
            ),
            'deleteRelatedLink' => array(
                'reqType'   => 'DELETE',
                'path'      => array('<module>','?'     ,'link','?'        ,'?'),
                'pathVars'  => array('module'  ,'record',''    ,'link_name','remote_id'),
                'method'    => 'deleteRelatedLink',
                'shortHelp' => 'Deletes a relationship between two records',
                'longHelp'  => 'include/api/help/module_record_link_link_name_remote_id_delete_help.html',
            ),
        );
    }


    /**
     * Fetches data from the $args array and updates the bean with that data
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how security is applied
     * @param $args array The arguments array passed in from the API
     * @param $primaryBean SugarBean The near side of the link
     * @param $securityTypeLocal string What ACL to check on the near side of the link
     * @param $securityTypeRemote string What ACL to check on the far side of the link
     * @return array Two elements: The link name, and the SugarBean of the far end
     */
    protected function checkRelatedSecurity(ServiceBase $api, $args, SugarBean $primaryBean, $securityTypeLocal='view', $securityTypeRemote='view') {
        if ( empty($primaryBean) ) {
            throw new SugarApiExceptionNotFound('Could not find the primary bean');
        }
        if ( ! $primaryBean->ACLAccess($securityTypeLocal) ) {
            throw new SugarApiExceptionNotAuthorized('No access to '.$securityTypeLocal.' records for module: '.$args['module']);
        }
        // Load up the relationship
        $linkName = $args['link_name'];
        if ( ! $primaryBean->load_relationship($linkName) ) {
            // The relationship did not load, I'm guessing it doesn't exist
            throw new SugarApiExceptionNotFound('Could not find a relationship named: '.$args['link_name']);
        }
        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $primaryBean->$linkName->getRelatedModuleName();
        $linkSeed = BeanFactory::getBean($linkModuleName);

        // FIXME: No create ACL yet
        if ( $securityTypeRemote == 'create' ) { $securityTypeRemote = 'edit'; }

        // only check here for edit...view and list are checked on formatBean
        if ( $securityTypeRemote == 'edit' && ! $linkSeed->ACLAccess($securityTypeRemote) ) {
            throw new SugarApiExceptionNotAuthorized('No access to '.$securityTypeRemote.' records for module: '.$linkModuleName);
        }

        return array($linkName, $linkSeed);
        
    }

    /**
     * This function is used to popluate an fields on the relationship from the request
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how security is applied
     * @param $args array The arguments array passed in from the API
     * @param $primaryBean SugarBean The near side of the link
     * @param $linkName string What is the name of the link field that you want to get the related fields for
     * @return array A list of the related fields pulled out of the $args array
     */
    protected function getRelatedFields(ServiceBase $api, $args, SugarBean $primaryBean, $linkName, $seed = null) {
        $relatedData = array();
        if ($seed instanceof SugarBean) {
            foreach ($args as $field => $value) {
                if (empty($seed->field_defs[$field]['rname_link'])) {
                    continue;
                }
                $relatedData[$seed->field_defs[$field]['rname_link']] = $value;
            }
        }
        
        return $relatedData;
    }

    /**
     * This function is here temporarily until the Link2 class properly handles these for the non-subpanel requests
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how security is applied
     * @param $args array The arguments array passed in from the API
     * @param $primaryBean SugarBean The near side of the link
     * @param $relatedBean SugarBean The far side of the link
     * @param $linkName string What is the name of the link field that you want to get the related fields for
     * @param $relatedData array The data for the related fields (such as the contact_role in opportunities_contacts relationship)
     * @return array Two elements, 'record' which is the formatted version of $primaryBean, and 'related_record' which is the formatted version of $relatedBean
     */
    protected function formatNearAndFarRecords(ServiceBase $api, $args, SugarBean $primaryBean, $relatedArray = array()) {
        $api->action = 'view';
        $recordArray = $this->formatBean($api, $args, $primaryBean);
        if (empty($relatedArray))
            $relatedArray = $this->getRelatedRecord($api, $args);

        return array(
            'record'=>$recordArray,
            'related_record'=>$relatedArray
        );
    }


    function getRelatedRecord($api, $args) {
        $primaryBean = $this->loadBean($api, $args);
        
        list($linkName, $relatedBean) = $this->checkRelatedSecurity($api, $args, $primaryBean, 'view','view');

        $related = array_values($primaryBean->$linkName->getBeans(array(
            'where' => array(
                'lhs_field' => 'id',
                'operator' => '=',
                'rhs_value' => $args['remote_id'],
            )
        )));
        if ( empty($related[0]->id) ) {
            // Retrieve failed, probably doesn't have permissions
            throw new SugarApiExceptionNotFound('Could not find the related bean');
        }

        return $this->formatBean($api, $args, $related[0]);
        
    }

    function createRelatedRecord($api, $args) {
        $primaryBean = $this->loadBean($api, $args);

        list($linkName, $relatedBean) = $this->checkRelatedSecurity($api, $args, $primaryBean, 'view','create');

        if ( isset($args['id']) ) {
            $relatedBean->new_with_id = true;
        }

        $id = $this->updateBean($relatedBean, $api, $args);

        $relatedData = $this->getRelatedFields($api, $args, $primaryBean, $linkName, $relatedBean);
        $primaryBean->$linkName->add(array($relatedBean),$relatedData);

        //Clean up any hanging related records.
        SugarRelationship::resaveRelatedBeans();

        $args['remote_id'] = $relatedBean->id;
        return $this->formatNearAndFarRecords($api,$args,$primaryBean);
    }

    function createRelatedLink($api, $args) {
        $primaryBean = $this->loadBean($api, $args);

        list($linkName, $relatedBean) = $this->checkRelatedSecurity($api, $args, $primaryBean, 'view','view');

        $relatedBean->retrieve($args['remote_id']);
        if ( empty($relatedBean->id) ) {
            // Retrieve failed, probably doesn't have permissions
            throw new SugarApiExceptionNotFound('Could not find the related bean');
        }

        $relatedData = $this->getRelatedFields($api, $args, $primaryBean, $linkName, $relatedBean);
        $primaryBean->$linkName->add(array($relatedBean),$relatedData);

        //Clean up any hanging related records.
        SugarRelationship::resaveRelatedBeans();

        return $this->formatNearAndFarRecords($api,$args,$primaryBean);
    }


    function updateRelatedLink($api, $args) {
        $primaryBean = $this->loadBean($api, $args);

        list($linkName, $relatedBean) = $this->checkRelatedSecurity($api, $args, $primaryBean, 'view','edit');

        $relatedBean->retrieve($args['remote_id']);
        if ( empty($relatedBean->id) ) {
            // Retrieve failed, probably doesn't have permissions
            throw new SugarApiExceptionNotFound('Could not find the related bean');
        }

        $id = $this->updateBean($relatedBean, $api, $args);

        $relatedData = $this->getRelatedFields($api, $args, $primaryBean, $linkName, $relatedBean);
        $primaryBean->$linkName->add(array($relatedBean),$relatedData);
        
        //Clean up any hanging related records.
        SugarRelationship::resaveRelatedBeans();

        return $this->formatNearAndFarRecords($api,$args,$primaryBean);
    }

    function deleteRelatedLink($api, $args) {
        $primaryBean = $this->loadBean($api, $args);

        list($linkName, $relatedBean) = $this->checkRelatedSecurity($api, $args, $primaryBean, 'view','view');

        $relatedBean->retrieve($args['remote_id']);
        if ( empty($relatedBean->id) ) {
            // Retrieve failed, probably doesn't have permissions
            throw new SugarApiExceptionNotFound('Could not find the related bean');
        }

        $primaryBean->$linkName->delete($primaryBean->id,$relatedBean);

        //Because the relationship is now deleted, we need to pass the $relatedBean data into formatNearAndFarRecords
        return $this->formatNearAndFarRecords($api,$args,$primaryBean, $this->formatBean($api, $args, $relatedBean));
    }

}
