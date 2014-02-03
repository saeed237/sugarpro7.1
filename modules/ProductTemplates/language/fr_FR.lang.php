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

	

$mod_strings = array (
  'ERR_DELETE_RECORD' => 'Un numéro d&#39;enregistrement doit être spécifié pour toute suppression.',
  'LBL_ACCOUNT_NAME' => 'Nom du Compte:',
  'LBL_ASSIGNED_TO' => 'Assigné à:',
  'LBL_ASSIGNED_TO_ID' => 'Assigné à (ID)',
  'LBL_CATEGORY' => 'Catégorie',
  'LBL_CATEGORY_ID' => 'Catégorie (ID)',
  'LBL_CATEGORY_NAME' => 'Catégorie',
  'LBL_CONTACT_NAME' => 'Nom du Contact:',
  'LBL_COST_PRICE' => 'Prix de Revient:',
  'LBL_COST_USDOLLAR' => 'Coût (devise par défaut):',
  'LBL_CURRENCY' => 'Devise:',
  'LBL_CURRENCY_SYMBOL_NAME' => 'Symbole monétaire:',
  'LBL_DATE_AVAILABLE' => 'Date de disponibilité:',
  'LBL_DATE_COST_PRICE' => 'Date-Coût-Prix:',
  'LBL_DESCRIPTION' => 'Description:',
  'LBL_DISCOUNT_PRICE' => 'Prix unitaire:',
  'LBL_DISCOUNT_PRICE_DATE' => 'Date promotion:',
  'LBL_DISCOUNT_USDOLLAR' => 'Prix remisé (devise par défaut):',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Assigné à (ID)',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Assigné à',
  'LBL_EXPORT_COST_PRICE' => 'Prix de revient',
  'LBL_EXPORT_CREATED_BY' => 'Créé par (ID)',
  'LBL_EXPORT_CURRENCY' => 'Devise',
  'LBL_EXPORT_CURRENCY_ID' => 'Devise (ID)',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modifié par (ID)',
  'LBL_LIST_CATEGORY' => 'Catégorie',
  'LBL_LIST_CATEGORY_ID' => 'Catégorie (ID)',
  'LBL_LIST_COST_PRICE' => 'Prix Revient:',
  'LBL_LIST_DISCOUNT_PRICE' => 'Prix Remisé',
  'LBL_LIST_FORM_TITLE' => 'Liste des produits du Catalogue',
  'LBL_LIST_LBL_MFT_PART_NUM' => 'Réf Fabricant',
  'LBL_LIST_LIST_PRICE' => 'Prix Public',
  'LBL_LIST_MANUFACTURER' => 'Fabricant',
  'LBL_LIST_MANUFACTURER_ID' => 'Fabricant (ID)',
  'LBL_LIST_NAME' => 'Nom',
  'LBL_LIST_PRICE' => 'Prix Public:',
  'LBL_LIST_QTY_IN_STOCK' => 'Qté',
  'LBL_LIST_STATUS' => 'Dispo',
  'LBL_LIST_TYPE' => 'Type:',
  'LBL_LIST_TYPE_ID' => 'Type (ID)',
  'LBL_LIST_USDOLLAR' => 'Liste (devise par défaut):',
  'LBL_MANUFACTURER' => 'Fabricant:',
  'LBL_MANUFACTURERS' => 'Fabricants',
  'LBL_MANUFACTURER_ID' => 'Fabricant (ID)',
  'LBL_MANUFACTURER_NAME' => 'Nom Fabricant',
  'LBL_MFT_PART_NUM' => 'Référence Fabricant:',
  'LBL_MODULE_ID' => 'Catalogue Produits (ID)',
  'LBL_MODULE_NAME' => 'Catalogue Produits',
  'LBL_MODULE_NAME_SINGULAR' => 'Catalogue Produits',
  'LBL_MODULE_TITLE' => 'Catalogue de Produits',
  'LBL_NAME' => 'Nom du Produit:',
  'LBL_NEW_FORM_TITLE' => 'Nouvel élément',
  'LBL_PERCENTAGE' => 'Pourcentage(%)',
  'LBL_POINTS' => 'Points',
  'LBL_PRICING_FACTOR' => 'Quotient:',
  'LBL_PRICING_FORMULA' => 'Calcul du prix remisé:',
  'LBL_PRODUCT' => 'Produit:',
  'LBL_PRODUCT_CATEGORIES' => 'Catégories de produits',
  'LBL_PRODUCT_ID' => 'Produit (ID)',
  'LBL_PRODUCT_TYPES' => 'Types de Produit',
  'LBL_QTY_IN_STOCK' => 'Quantité en stock',
  'LBL_QUANTITY' => 'Quantité en stock:',
  'LBL_RELATED_PRODUCTS' => 'Produit lié',
  'LBL_SEARCH_FORM_TITLE' => 'Rechercher un Produit',
  'LBL_STATUS' => 'Disponibilité:',
  'LBL_SUPPORT_CONTACT' => 'Contact Support:',
  'LBL_SUPPORT_DESCRIPTION' => 'Desc. Support:',
  'LBL_SUPPORT_NAME' => 'Titre du Support:',
  'LBL_SUPPORT_TERM' => 'Durée du Support:',
  'LBL_TAX_CLASS' => 'Classe de Taxe:',
  'LBL_TYPE' => 'Type:',
  'LBL_TYPE_ID' => 'Type (ID)',
  'LBL_TYPE_NAME' => 'Nom du Type',
  'LBL_URL' => 'URL:',
  'LBL_VENDOR_PART_NUM' => 'Référence Interne:',
  'LBL_WEBSITE' => 'Site Web:',
  'LBL_WEIGHT' => 'Poids:',
  'LNK_IMPORT_PRODUCTS' => 'Import Produits',
  'LNK_NEW_MANUFACTURER' => 'Fabricants',
  'LNK_NEW_PRODUCT' => 'Nouveau Produit',
  'LNK_NEW_PRODUCT_CATEGORY' => 'Catégories de produit',
  'LNK_NEW_PRODUCT_TYPE' => 'Types',
  'LNK_NEW_SHIPPER' => 'Transporteurs',
  'LNK_PRODUCT_LIST' => 'Catalogue Produits',
  'NTC_DELETE_CONFIRMATION' => 'Etes vous sûr de vouloir supprimer cet enregistrement ?',
);

