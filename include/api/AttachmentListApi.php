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


require_once('include/api/ListApi.php');

class AttachmentListApi extends ListApi {
    public function registerApiRest() {
        return array(
            'listAttachments' => array(
                'reqType' => 'GET',
                'path' => array('<module>','?', 'link','attachments'),
                'pathVars' => array('module','record','', ''),
                'method' => 'listAttachments',
                'shortHelp' => 'List attachments related to this module',
                'longHelp' => 'include/api/html/module_attach_help.html',
            ),
        );
    }

    public function __construct() {
        $this->defaultLimit = $GLOBALS['sugar_config']['list_max_entries_per_subpanel'];
    }
    
    public function listAttachments($api, $args) {
        // Load up the bean
        $record = BeanFactory::getBean($args['module'], $args['record']);

        if ( empty($record) ) {
            throw new SugarApiExceptionNotFound('Could not find parent record '.$args['record'].' in module '.$args['module']);
        }
        if ( ! $record->ACLAccess('view') ) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$args['module']);
        }
        // Load up the relationship
        if ( ! $record->load_relationship('notes') ) {
            // The relationship did not load, I'm guessing it doesn't exist
            throw new SugarApiExceptionNotFound('Could not find a relationship name notes');
        }
        // Figure out what is on the other side of this relationship, check permissions
        $linkModuleName = $record->notes->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if ( ! $linkSeed->ACLAccess('view') ) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: '.$linkModuleName);
        }

        $options = $this->parseArguments($api, $args, $linkSeed);

        $notes = $record->notes->query(array('where'=>array('lhs_field'=>'filename','operator'=>'<>','rhs_value'=>"''")));
        $rowCount = 1;

        $data['records'] = array();
        foreach ( $notes['rows'] as $noteId => $ignore ) {
            $rowCount++;
            $note = BeanFactory::getBean('Notes',$noteId);
            $data['records'][] = $this->formatBean($api,$args,$note);
            if ( $rowCount == $options['limit'] ) {
                // We have hit our limit.
                break;
            }
        }
        return $data['records'];
    }
}
