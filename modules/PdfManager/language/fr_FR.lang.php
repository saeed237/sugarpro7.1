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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activités à réaliser',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'ATTENTION: Si vous changez le module principal, tous les champs déjà ajoutés au modèle devront être supprimés.',
  'LBL_ASSIGNED_TO_ID' => 'Assigné à (ID)',
  'LBL_ASSIGNED_TO_NAME' => 'Assigné à:',
  'LBL_AUTHOR' => 'Auteur',
  'LBL_BASE_MODULE' => 'Module',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Choisissez un module pour lequel ce modèle est disponible.',
  'LBL_BODY_HTML' => 'Modèle',
  'LBL_BODY_HTML_POPUP_HELP' => 'Créez le modèle en utilisant l&#39;éditeur HTML. Après la sauvegarde du modèle, vous serez capable de voir une prévisualisation du modèle PDF.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Créez le modèle en utilisant l&#39;éditeur HTML. Après la sauvegarde du modèle, vous serez capable de voir une prévisualisation du modèle PDF..<br /><br />Pour modifier la boucle utilisée pour gérer les lignes de produits, cliquez sur le bouton "HTML" pour accéder au code.  Le code est contenu à l&#39;intérieur des balises suivantes <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP--> et <!--END_BUNDLE_LOOP-->.',
  'LBL_BTN_INSERT' => 'Insérer',
  'LBL_CREATED' => 'Créé par',
  'LBL_CREATED_ID' => 'Créé par (ID)',
  'LBL_CREATED_USER' => 'Créé par',
  'LBL_DATE_ENTERED' => 'Date de création',
  'LBL_DATE_MODIFIED' => 'Date de modification',
  'LBL_DELETED' => 'Supprimé',
  'LBL_DESCRIPTION' => 'Description',
  'LBL_EDITVIEW_PANEL1' => 'Propriétés du document PDF',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Voici le fichier que vous avez demandé (Vous pouvez changer ce texte)',
  'LBL_FIELD' => 'Champ',
  'LBL_FIELDS_LIST' => 'Champs',
  'LBL_FIELD_POPUP_HELP' => 'Choisissez un champ pour l&#39;insérer dans votre modèle. Pour sélectionner les champs d&#39;un module parent, sélectionnez d&#39;abord le module dans la section des liens à la fin de la liste des champs puis choisissez le champ dans la seconde liste déroulante.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historique et activités terminées',
  'LBL_HOMEPAGE_TITLE' => 'Mes modèles PDF',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Mot(s) Clé(s)',
  'LBL_KEYWORDS_POPUP_HELP' => 'Associer des mots clés au document, généralement de la forme "motclé1 motclé2..."',
  'LBL_LINK_LIST' => 'Liens',
  'LBL_LIST_FORM_TITLE' => 'Liste des modèles PDF',
  'LBL_LIST_NAME' => 'Nom',
  'LBL_MODIFIED' => 'Modifié par',
  'LBL_MODIFIED_ID' => 'Modifié par (ID)',
  'LBL_MODIFIED_NAME' => 'Modifié par',
  'LBL_MODIFIED_USER' => 'Modifié par',
  'LBL_MODULE_NAME' => 'Modèles PDF',
  'LBL_MODULE_NAME_SINGULAR' => 'Modèle PDF',
  'LBL_MODULE_TITLE' => 'Modèles PDF',
  'LBL_NAME' => 'Nom',
  'LBL_NEW_FORM_TITLE' => 'Nouveau modèle PDF',
  'LBL_PAYMENT_TERMS' => 'Modalités de paiement:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'Modèles PDF',
  'LBL_PREVIEW' => 'Aperçu',
  'LBL_PUBLISHED' => 'Publié',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publiez un modèle pour le rendre disponible aux utilisateurs.',
  'LBL_PURCHASE_ORDER_NUM' => 'Référence Commande:',
  'LBL_SEARCH_FORM_TITLE' => 'Rechercher un modèle PDF',
  'LBL_SUBJECT' => 'Sujet',
  'LBL_TEAM' => 'Equipes',
  'LBL_TEAMS' => 'Equipes',
  'LBL_TEAM_ID' => 'Equipe (ID)',
  'LBL_TITLE' => 'Titre',
  'LBL_TPL_BILL_TO' => 'Adresse de Facturation',
  'LBL_TPL_CURRENCY' => 'Devise:',
  'LBL_TPL_DISCOUNT' => 'Remise:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Sous-total remisé:',
  'LBL_TPL_EXT_PRICE' => 'Prix ext.',
  'LBL_TPL_GRAND_TOTAL' => 'Total Général',
  'LBL_TPL_INVOICE' => 'Facture',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Ce modèle est utilisé pour imprimer des factures en PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Facture',
  'LBL_TPL_INVOICE_NUMBER' => 'Numéro de facture:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'facture',
  'LBL_TPL_LIST_PRICE' => 'Prix Public',
  'LBL_TPL_PART_NUMBER' => 'Référence',
  'LBL_TPL_PRODUCT' => 'Produit',
  'LBL_TPL_QUANTITY' => 'Quantité',
  'LBL_TPL_QUOTE' => 'Devis',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Ce modèle est utilisé pour imprimer des devis en PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Devis',
  'LBL_TPL_QUOTE_NUMBER' => 'N° devis:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'devis',
  'LBL_TPL_SALES_PERSON' => 'Commercial:',
  'LBL_TPL_SHIPPING' => 'Livraison:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Livreur:',
  'LBL_TPL_SHIP_TO' => 'Adresse de Livraison',
  'LBL_TPL_SUBTOTAL' => 'Sous-total:',
  'LBL_TPL_TAX' => 'TVA:',
  'LBL_TPL_TAX_RATE' => 'Taux TVA:',
  'LBL_TPL_TOTAL' => 'Total',
  'LBL_TPL_UNIT_PRICE' => 'Prix unitaire',
  'LBL_TPL_VALID_UNTIL' => 'Valide jusqu&#39;à:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Modifier un modèle PDF',
  'LNK_IMPORT_PDFMANAGER' => 'Importer un modèle PDF',
  'LNK_LIST' => 'Voir les modèles PDF',
  'LNK_NEW_RECORD' => 'Créer un modèle PDF',
);

