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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'ADVERTÈNCIA: Si canvia el mòdul primari, tots els camps ja afegits a la plantilla hauran de ser eliminats.',
  'LBL_ASSIGNED_TO_ID' => 'Id usuari assignat',
  'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
  'LBL_AUTHOR' => 'Autor',
  'LBL_BASE_MODULE' => 'Mòdul',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Seleccioneu un módul per al qual aquesta plantilla estarà disponible.',
  'LBL_BODY_HTML' => 'Plantilla',
  'LBL_BODY_HTML_POPUP_HELP' => 'Creï la plantilla mitjançant l&#39;editor HTML. Després de guardar la plantilla, es podrà veure una vista prèvia de la versió en PDF de la plantilla.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Creï la plantilla mitjançant l&#39;editor HTML. Després de guardar la plantilla, es podrà veure una vista prèvia de la versió en PDF de la plantilla.<br /><br />Per editar el bucle per crear els elements de línia de productes, feu clic al "HTML" botó en l&#39;editor per accedir al codi.  El codi està contingut dins de &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => 'Insertar',
  'LBL_CREATED' => 'Creat per',
  'LBL_CREATED_ID' => 'Creat per Id',
  'LBL_CREATED_USER' => 'Creat per usuari',
  'LBL_DATE_ENTERED' => 'Data de creació',
  'LBL_DATE_MODIFIED' => 'Data de modificació',
  'LBL_DELETED' => 'Eliminat',
  'LBL_DESCRIPTION' => 'Descripció',
  'LBL_EDITVIEW_PANEL1' => 'Propietats PDF Document',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Aquí està l&#39;arxiu que ha sol·licitat (Podeu modificar aquest text)',
  'LBL_FIELD' => 'Camp',
  'LBL_FIELDS_LIST' => 'Camps',
  'LBL_FIELD_POPUP_HELP' => 'Seleccioneu un camp per introduir la variable per al valor del camp. Per seleccionar camps d&#39;un mòdul principal, seleccioneu primer el mòdul a l&#39;àrea d&#39;enllaços a la part inferior de la llista de camps al primer menú desplegable, seleccioneu el camp en el segon menú desplegable.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Veure històrial',
  'LBL_HOMEPAGE_TITLE' => 'Les meves plantilles PDF',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Paraula(es) clau',
  'LBL_KEYWORDS_POPUP_HELP' => 'Associar Paraules clau amb el document, generalment a la forma "paraula1 paraula2..."',
  'LBL_LINK_LIST' => 'Enllaços',
  'LBL_LIST_FORM_TITLE' => 'Llista de plantilles PDF',
  'LBL_LIST_NAME' => 'Nom',
  'LBL_MODIFIED' => 'Modificat per',
  'LBL_MODIFIED_ID' => 'Modificat per Id',
  'LBL_MODIFIED_NAME' => 'Modificat per nom',
  'LBL_MODIFIED_USER' => 'Modificat per usuari',
  'LBL_MODULE_NAME' => 'Pdf Manager',
  'LBL_MODULE_NAME_SINGULAR' => 'Pdf Manager',
  'LBL_MODULE_TITLE' => 'Pdf Manager',
  'LBL_NAME' => 'Nom',
  'LBL_NEW_FORM_TITLE' => 'Nova plantilla de PDF',
  'LBL_PAYMENT_TERMS' => 'Forma de Pagament:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'Pdf Manager',
  'LBL_PREVIEW' => 'Vista preliminar',
  'LBL_PUBLISHED' => 'Publicat',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publicar una plantilla perquè estigui disponible per als usuaris.',
  'LBL_PURCHASE_ORDER_NUM' => 'Nombre de comanda:',
  'LBL_SEARCH_FORM_TITLE' => 'Cercar PDF Manager',
  'LBL_SUBJECT' => 'Assumpte',
  'LBL_TEAM' => 'Equip',
  'LBL_TEAMS' => 'Equips',
  'LBL_TEAM_ID' => 'Id d´Equip',
  'LBL_TITLE' => 'Títol',
  'LBL_TPL_BILL_TO' => 'Cobrar a',
  'LBL_TPL_CURRENCY' => 'Moneda:',
  'LBL_TPL_DISCOUNT' => 'Descompte:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Descompte subtotal:',
  'LBL_TPL_EXT_PRICE' => 'Preu Ext.',
  'LBL_TPL_GRAND_TOTAL' => 'Totals',
  'LBL_TPL_INVOICE' => 'Factura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Aquesta plantilla s&#39;utilitza per imprimir factures en format PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Factura',
  'LBL_TPL_INVOICE_NUMBER' => 'Nombre de factura:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'factura',
  'LBL_TPL_LIST_PRICE' => 'Preu de Llista',
  'LBL_TPL_PART_NUMBER' => 'Nombre de referència',
  'LBL_TPL_PRODUCT' => 'Producte',
  'LBL_TPL_QUANTITY' => 'Quantitat',
  'LBL_TPL_QUOTE' => 'Pressupost',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Aquesta plantilla s&#39;utilitza per imprimir pressupost en format PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Pressupost',
  'LBL_TPL_QUOTE_NUMBER' => 'Nombre pressupost:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'pressupost',
  'LBL_TPL_SALES_PERSON' => 'Venedor:',
  'LBL_TPL_SHIPPING' => 'Enviament:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Transportiste:',
  'LBL_TPL_SHIP_TO' => 'Enviar a',
  'LBL_TPL_SUBTOTAL' => 'Subtotal:',
  'LBL_TPL_TAX' => 'Impost:',
  'LBL_TPL_TAX_RATE' => 'Taxa d&#39;impost:',
  'LBL_TPL_TOTAL' => 'Total',
  'LBL_TPL_UNIT_PRICE' => 'Preu Unitari',
  'LBL_TPL_VALID_UNTIL' => 'Vàlid fins:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Edita plantilla PDF',
  'LNK_IMPORT_PDFMANAGER' => 'Importar plantilles de PDF',
  'LNK_LIST' => 'Veure plantilles PDF',
  'LNK_NEW_RECORD' => 'Crear plantilla PDF',
);

