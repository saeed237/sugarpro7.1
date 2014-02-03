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

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldRelate extends SugarFieldBase {

    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        $nolink = array('Users', 'Teams');
        if(in_array($vardef['module'], $nolink)){
            $this->ss->assign('nolink', true);
        }else{
            $this->ss->assign('nolink', false);
        }
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('DetailView'));
    }

    /**
     * @see SugarFieldBase::getEditViewSmarty()
     */
    public function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        if(!empty($vardef['function']['returns']) && $vardef['function']['returns'] == 'html'){
            return parent::getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
        }

        $call_back_function = 'set_return';
        if(isset($displayParams['call_back_function'])) {
            $call_back_function = $displayParams['call_back_function'];
        }
        $form_name = 'EditView';
        if(isset($displayParams['formName'])) {
            $form_name = $displayParams['formName'];
        }

        if (isset($displayParams['idName']))
        {
            $rpos = strrpos($displayParams['idName'], $vardef['name']);
            $displayParams['idNameHidden'] = substr($displayParams['idName'], 0, $rpos);
        }
        //Special Case for accounts; use the displayParams array and retrieve
        //the key and copy indexes.  'key' is the suffix of the field we are searching
        //the Account's address with.  'copy' is the suffix we are copying the addresses
        //form fields into.
        if(isset($vardef['module']) && preg_match('/Accounts/si',$vardef['module'])
           && isset($displayParams['key']) && isset($displayParams['copy'])) {

            if(isset($displayParams['key']) && is_array($displayParams['key'])) {
              $database_key = $displayParams['key'];
            } else {
              $database_key[] = $displayParams['key'];
            }

            if(isset($displayParams['copy']) && is_array($displayParams['copy'])) {
                $form = $displayParams['copy'];
            } else {
                $form[] = $displayParams['copy'];
            }

            if(count($database_key) != count($form)) {
              global $app_list_strings;
              $this->ss->trigger_error($app_list_strings['ERR_SMARTY_UNEQUAL_RELATED_FIELD_PARAMETERS']);
            } //if

            $copy_phone = isset($displayParams['copyPhone']) ? $displayParams['copyPhone'] : true;

            $field_to_name = array();
            $field_to_name['id'] = $vardef['id_name'];
            $field_to_name['name'] = $vardef['name'];
            $address_fields = isset($displayParams['field_to_name_array']) ? $displayParams['field_to_name_array'] : array('_address_street', '_address_city', '_address_state', '_address_postalcode', '_address_country');
            $count = 0;
            foreach($form as $f) {
                foreach($address_fields as $afield) {
                    $field_to_name[$database_key[$count] . $afield] = $f . $afield;
                }
                $count++;
            }

            $popup_request_data = array(
                'call_back_function' => $call_back_function,
                'form_name' => $form_name,
                'field_to_name_array' => $field_to_name,
            );

            if($copy_phone) {
              $popup_request_data['field_to_name_array']['phone_office'] = 'phone_work';
            }
        } elseif(isset($displayParams['field_to_name_array'])) {
            $popup_request_data = array(
                'call_back_function' => $call_back_function,
                'form_name' => $form_name,
                'field_to_name_array' => $displayParams['field_to_name_array'],
            );
        } else {
            $popup_request_data = array(
                'call_back_function' => $call_back_function,
                'form_name' => $form_name,
                'field_to_name_array' => array(
                          //'id' => (empty($displayParams['idName']) ? $vardef['id_name'] : ($displayParams['idName'] . '_' . $vardef['id_name'])) ,
                          //bug 43770: Assigned to value could not be saved during lead conversion
                          'id' => (empty($displayParams['idNameHidden']) ? $vardef['id_name'] : ($displayParams['idNameHidden'] . $vardef['id_name'])) ,
                          ((empty($vardef['rname'])) ? 'name' : $vardef['rname']) => (empty($displayParams['idName']) ? $vardef['name'] : $displayParams['idName']),
                    ),
                );
        }
        $json = getJSONobj();
        $displayParams['popupData'] = '{literal}'.$json->encode($popup_request_data). '{/literal}';
        if(!isset($displayParams['readOnly'])) {
           $displayParams['readOnly'] = '';
        } else {
           $displayParams['readOnly'] = $displayParams['readOnly'] == false ? '' : 'READONLY';
        }

        $keys = $this->getAccessKey($vardef,'RELATE',$vardef['module']);
        $displayParams['accessKeySelect'] = $keys['accessKeySelect'];
        $displayParams['accessKeySelectLabel'] = $keys['accessKeySelectLabel'];
        $displayParams['accessKeySelectTitle'] = $keys['accessKeySelectTitle'];
        $displayParams['accessKeyClear'] = $keys['accessKeyClear'];
        $displayParams['accessKeyClearLabel'] = $keys['accessKeyClearLabel'];
        $displayParams['accessKeyClearTitle'] = $keys['accessKeyClearTitle'];

        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('EditView'));
    }

    function getPopupViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex){
    	return $this->getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }

    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex) {
        $call_back_function = 'set_return';
        if(isset($displayParams['call_back_function'])) {
            $call_back_function = $displayParams['call_back_function'];
        }
        $form_name = 'search_form';
        if(isset($displayParams['formName'])) {
            $form_name = $displayParams['formName'];
        }
     	if(!empty($vardef['rname']) && $vardef['rname'] == 'user_name'){
        	$displayParams['useIdSearch'] = true;
        }

        //Special Case for accounts; use the displayParams array and retrieve
        //the key and copy indexes.  'key' is the suffix of the field we are searching
        //the Account's address with.  'copy' is the suffix we are copying the addresses
        //form fields into.
        if(isset($vardef['module']) && preg_match('/Accounts/si',$vardef['module'])
           && isset($displayParams['key']) && isset($displayParams['copy'])) {

            if(isset($displayParams['key']) && is_array($displayParams['key'])) {
              $database_key = $displayParams['key'];
            } else {
              $database_key[] = $displayParams['key'];
            }

            if(isset($displayParams['copy']) && is_array($displayParams['copy'])) {
                $form = $displayParams['copy'];
            } else {
                $form[] = $displayParams['copy'];
            }

            if(count($database_key) != count($form)) {
              global $app_list_strings;
              $this->ss->trigger_error($app_list_strings['ERR_SMARTY_UNEQUAL_RELATED_FIELD_PARAMETERS']);
            } //if

            $copy_phone = isset($displayParams['copyPhone']) ? $displayParams['copyPhone'] : true;

            $field_to_name = array();
            $field_to_name['id'] = $vardef['id_name'];
            $field_to_name['name'] = $vardef['name'];
            $address_fields = array('_address_street', '_address_city', '_address_state', '_address_postalcode', '_address_country');
            $count = 0;
            foreach($form as $f) {
                foreach($address_fields as $afield) {
                    $field_to_name[$database_key[$count] . $afield] = $f . $afield;
                }
                $count++;
            }

            $popup_request_data = array(
                'call_back_function' => $call_back_function,
                'form_name' => $form_name,
                'field_to_name_array' => $field_to_name,
            );

            if($copy_phone) {
              $popup_request_data['field_to_name_array']['phone_office'] = 'phone_work';
            }
        } elseif(isset($displayParams['field_to_name_array'])) {
            $popup_request_data = array(
                'call_back_function' => $call_back_function,
                'form_name' => $form_name,
                'field_to_name_array' => $displayParams['field_to_name_array'],
            );
        } else {
            $popup_request_data = array(
                'call_back_function' => $call_back_function,
                'form_name' => $form_name,
                'field_to_name_array' => array(
                          'id' => $vardef['id_name'],
                          ((empty($vardef['rname'])) ? 'name' : $vardef['rname']) => $vardef['name'],
                    ),
                );
        }
        $json = getJSONobj();
        $displayParams['popupData'] = '{literal}'.$json->encode($popup_request_data). '{/literal}';
        if(!isset($displayParams['readOnly'])) {
           $displayParams['readOnly'] = '';
        } else {
           $displayParams['readOnly'] = $displayParams['readOnly'] == false ? '' : 'READONLY';
        }
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch($this->findTemplate('SearchView'));
    }

    public function apiFormatField(&$data, $bean, $args, $fieldName, $properties)
    {
        /*
         * If we have a related field, use its formatter to format it
         */
        $rbean = false;
        if(!empty($properties['link']) && !empty($bean->related_beans[$properties['link']])) {
            $rbean = $bean->related_beans[$properties['link']];
        } else if (!empty($bean->related_beans[$fieldName])) {
            $rbean = $bean->related_beans[$fieldName];
        }
        if (!empty($rbean)) {
            if(empty($rbean->field_defs[$properties['rname']])) {
                $data[$fieldName] = '';
                return;
            }
            $rdefs = $rbean->field_defs[$properties['rname']];
            if(!empty($rdefs) && !empty($rdefs['type'])) {
                $sfh = new SugarFieldHandler();
                $field = $sfh->getSugarField($rdefs['type']);
                $rdata = array();
                $field->apiFormatField($rdata, $rbean, $args, $properties['rname'], $rdefs);
                $data[$fieldName] = $rdata[$properties['rname']];
                if(!empty($data[$fieldName])) {
                    return;
                }
            }
        }
        if(empty($bean->$fieldName)) {
            $data[$fieldName] = '';
        } else {
            $data[$fieldName] = $this->formatField($bean->$fieldName, $properties);
        }
    }

    /**
     * @see SugarFieldBase::importSanitize()
     */
    public function importSanitize(
        $value,
        $vardef,
        $focus,
        ImportFieldSanitize $settings
        )
    {
        if ( !isset($vardef['module']) )
            return false;
        $newbean = BeanFactory::getBean($vardef['module']);

        // Bug 38885 - If we are relating to the Users table on user_name, there's a good chance
        // that the related field data is the full_name, rather than the user_name. So to be sure
        // let's try to lookup the field the relationship is expecting to use (user_name).
        if ( $vardef['module'] == 'Users' && isset($vardef['rname']) && $vardef['rname'] == 'user_name' ) {
            $userFocus = BeanFactory::getBean('Users');
            $query = sprintf("SELECT user_name FROM {$userFocus->table_name} WHERE %s=%s AND deleted=0",
                $userFocus->db->concat('users',array('first_name','last_name')), $userFocus->db->quoted($value));
            $username = $userFocus->db->getOne($query);
            if(!empty($username)) {
                $value = $username;
            }
        }

        // Bug 32869 - Assumed related field name is 'name' if it is not specified
        if ( !isset($vardef['rname']) )
            $vardef['rname'] = 'name';

        // Bug 27046 - Validate field against type as it is in the related field
        $rvardef = $newbean->getFieldDefinition($vardef['rname']);
        if ( isset($rvardef['type'])
                && method_exists($this,$rvardef['type']) ) {
            $fieldtype = $rvardef['type'];
            $returnValue = $settings->$fieldtype($value,$rvardef);
            if ( !$returnValue )
                return false;
            else
                $value = $returnValue;
        }

        if ( isset($vardef['id_name']) ) {
            $idField = $vardef['id_name'];

            // Bug 24075 - clear out id field value if it is invalid
            if ( isset($focus->$idField) ) {
                $checkfocus = BeanFactory::getBean($vardef['module']);
                if ( $checkfocus && is_null($checkfocus->retrieve($focus->$idField)) )
                    $focus->$idField = '';
            }

            // fixing bug #47722: Imports to Custom Relate Fields Do Not Work
            if (!isset($vardef['table']))
            {
                // Set target module table as the default table name
                $vardef['table'] = $newbean->table_name;
            }
            // be sure that the id isn't already set for this row
            if ( empty($focus->$idField)
                    && $idField != $vardef['name']
                    && !empty($vardef['rname'])
                    && !empty($vardef['table'])) {
                // Bug 27562 - Check db_concat_fields first to see if the field name is a concatenation.
                $relatedFieldDef = $newbean->getFieldDefinition($vardef['rname']);
                if ( isset($relatedFieldDef['db_concat_fields'])
                        && is_array($relatedFieldDef['db_concat_fields']) )
                    $fieldname = $focus->db->concat($vardef['table'],$relatedFieldDef['db_concat_fields']);
                else
                    $fieldname = $vardef['rname'];
                // lookup first record that matches in linked table
                $query = "SELECT id
                            FROM {$vardef['table']}
                            WHERE {$fieldname} = '" . $focus->db->quote($value) . "'
                                AND deleted != 1";

                $result = $focus->db->limitQuery($query,0,1,true, "Want only a single row");
                if(!empty($result)){
                    if ( $relaterow = $focus->db->fetchByAssoc($result) )
                        $focus->$idField = $relaterow['id'];
                    elseif ( !$settings->addRelatedBean
                            || ( $newbean->bean_implements('ACL') && !$newbean->ACLAccess('save') )
                            || ( in_array($newbean->module_dir,array('Teams','Users')) )
                            )
                        return false;
                    else {
                        // add this as a new record in that bean, then relate
                        if ( isset($relatedFieldDef['db_concat_fields'])
                                && is_array($relatedFieldDef['db_concat_fields']) ) {
                            assignConcatenatedValue($newbean, $relatedFieldDef, $value);
                        }
                        else
                            $newbean->$vardef['rname'] = $value;
                        if ( !isset($focus->assigned_user_id) || $focus->assigned_user_id == '' )
                            $newbean->assigned_user_id = $GLOBALS['current_user']->id;
                        else
                            $newbean->assigned_user_id = $focus->assigned_user_id;
                        if ( !isset($focus->modified_user_id) || $focus->modified_user_id == '' )
                            $newbean->modified_user_id = $GLOBALS['current_user']->id;
                        else
                            $newbean->modified_user_id = $focus->modified_user_id;

                        // populate fields from the parent bean to the child bean
                        $focus->populateRelatedBean($newbean);

                        $newbean->save(false);
                        $focus->$idField = $newbean->id;
                        $settings->createdBeans[] = ImportFile::writeRowToLastImport(
                                $focus->module_dir,$newbean->object_name,$newbean->id);
                    }
                }
            }
        }

        return $value;
    }

    /**
     * For Relate fields we should not be sending the len vardef back
     * @param array $vardef
     * @return array of $vardef
     */
    public function getNormalizedDefs($vardef) {
        unset($vardef['len']);
        return parent::getNormalizedDefs($vardef);
    }

}
