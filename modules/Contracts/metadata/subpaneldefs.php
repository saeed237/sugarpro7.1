<?php
/*
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement ("MSA"), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright 2004-2013 SugarCRM Inc. All rights reserved.
 */

$layout_defs['Contracts'] = array( 
    // sets up which panels to show, in which order, and with what linked_fields 
    'subpanel_setup' => array(
        'contracts_documents' => array(
            'order' => 10,
            'module' => 'Documents',
            'sort_order' => 'asc',
            'sort_by' => 'document_name',
            'subpanel_name' => 'default',
            'get_subpanel_data' => 'function:get_contract_documents',
            'set_subpanel_data' => 'contracts_documents',
            'title_key' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
            'fill_in_additional_fields' => true,
            'refresh_page' => 1,            
        ),
        'history' => array(
            'order' => 20,
            'sort_order' => 'desc',
            'sort_by' => 'notes.date_entered',
            'title_key' => 'LBL_NOTES_SUBPANEL_TITLE',
            'type' => 'collection',
            'subpanel_name' => 'history',   //this values is not associated with a physical file.
            'header_definition_from_subpanel'=> 'meetings',
            'module'=>'History',
            
            'top_buttons' => array(
                array('widget_class' => 'SubPanelTopCreateNoteButton'),
            ),    
                    
            'collection_list' => array(    
                'notes' => array(
                    'module' => 'Notes',
                    'subpanel_name' => 'default',
                    'get_subpanel_data' => 'notes',
                ),
            ),
        ),
        'contacts' => array(
            'order' => 30,
            'module' => 'Contacts',
            'sort_order' => 'asc',
            'sort_by' => 'last_name, first_name',
            'subpanel_name' => 'default',
            'get_subpanel_data' => 'contacts',
            'add_subpanel_data' => 'contact_id',
            'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
            'top_buttons' => array(
                array('widget_class' => 'SubPanelTopSelectButton', 'mode'=>'MultiSelect'),
            ),
        ),
        'products' => array(
            'order' => 40,
            'module' => 'Products',
            'sort_order' => 'desc',
            'sort_by' => 'date_purchased',
            'subpanel_name' => 'default',
            'get_subpanel_data' => 'products',
            'add_subpanel_data' => 'product_id',
            'title_key' => 'LBL_PRODUCTS_SUBPANEL_TITLE',
            'top_buttons' => array(
                array('widget_class' => 'SubPanelTopSelectButton'),
            ),
        ),
        'quotes' => array(
            'order' => 50,
            'module' => 'Quotes',
            'sort_order' => 'desc',
            'sort_by' => 'date_quote_expected_closed',
            'subpanel_name' => 'default',
            'get_subpanel_data' => 'quotes',
            'get_distinct_data'=> true,
            'add_subpanel_data' => 'quote_id',
            'title_key' => 'LBL_QUOTES_SUBPANEL_TITLE',
            'top_buttons' => array(
                array(
                    'widget_class' => 'SubPanelTopSelectButton',
                    'popup_module' => 'Quotes',
                    'mode' => 'MultiSelect', 
                    'initial_filter_fields' => array('account_id' => 'account_id'), //'account_name' => 'account_name'),   
                ),
            ),
        ),
    ),
);
