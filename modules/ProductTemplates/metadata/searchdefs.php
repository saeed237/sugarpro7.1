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


$searchdefs['ProductTemplates'] = array(
			'templateMeta' => array(
					'maxColumns' => '3', 
                    'maxColumnsBasic' => '4', 
                    'widths' => array('label' => '10', 'field' => '30'),                 
                   ),
            'layout' => array(  					
				'basic_search' => array(
				 	'name',					
				),
				'advanced_search' => array(
					'name',
					'tax_class',
					array('name'=>'type_id', 'label'=>'LBL_TYPE', 'type'=>'multienum', 'function' => array('name'=>'getProductTypes', 'returns'=>'html', 'include'=>'modules/ProductTemplates/ProductTemplate.php', 'preserveFunctionValue'=>true)),
					array('name'=>'manufacturer_id', 'label'=>'LBL_MANUFACTURER', 'type'=>'multienum', 'function' => array('name'=>'getManufacturers', 'returns'=>'html', 'include'=>'modules/ProductTemplates/ProductTemplate.php', 'preserveFunctionValue'=>true)),
					'mft_part_num',
					array('name' => 'discount_price_date', 'label'=>'LBL_DISCOUNT_PRICE_DATE'),
					'vendor_part_num',
					array('name'=>'category_id', 'label'=>'LBL_CATEGORY', 'type'=>'multienum', 'function' => array('name'=>'getCategories', 'returns'=>'html', 'include'=>'modules/ProductTemplates/ProductTemplate.php', 'preserveFunctionValue'=>true)),
					array('name' => 'contact_name', 'label' => 'LBL_CONTACT_NAME'),
					'date_available',
					array('name' => 'url', 'label' => 'LBL_URL'),
					'support_term',
				),												
			),
);
?>