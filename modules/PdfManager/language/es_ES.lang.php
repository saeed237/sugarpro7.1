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
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'ADVERTENCIA: Si cambia el módulo primario, todos los campos ya agregados a la plantilla tendrán que ser eliminados.',
  'LBL_ASSIGNED_TO_ID' => 'ID usuario asignado',
  'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
  'LBL_AUTHOR' => 'Autor',
  'LBL_BASE_MODULE' => 'Módulo',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Seleccione un módulo donde quiera disponer de esta plantilla.',
  'LBL_BODY_HTML' => 'Plantilla',
  'LBL_BODY_HTML_POPUP_HELP' => 'Cree la plantilla utilizando el editor HTML. Después de guardar la plantilla, podrá ver una vista previa de la versión en PDF de la misma.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Cree la plantilla utilizando el editor HTML. Después de guardar la plantilla, podrá ver una vista previa de la versión en PDF de la misma.<br /><br />Para editar el bucle utilizado para crear los elementos de la línea de Productos, haga clic en el botón "HTML" del editor para acceder al código. El código está dentro de &lt;!--START_BUNDLE_LOOP--&gt;, &lt;!--START_PRODUCT_LOOP--&gt;, &lt;!--END_PRODUCT_LOOP--&gt; and &lt;!--END_BUNDLE_LOOP--&gt;.',
  'LBL_BTN_INSERT' => 'Insertar',
  'LBL_CREATED' => 'Creado Por',
  'LBL_CREATED_ID' => 'Creado Por Id',
  'LBL_CREATED_USER' => 'Creada por Usuario',
  'LBL_DATE_ENTERED' => 'Fecha de Creación',
  'LBL_DATE_MODIFIED' => 'Fecha de Modificación',
  'LBL_DELETED' => 'Eliminado',
  'LBL_DESCRIPTION' => 'Descripción',
  'LBL_EDITVIEW_PANEL1' => 'Propiedades del Documento PDF',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Aquí está el archivo que ha solicitado (Puede cambiar este texto)',
  'LBL_FIELD' => 'Campo',
  'LBL_FIELDS_LIST' => 'Campos',
  'LBL_FIELD_POPUP_HELP' => 'Seleccione un campo para introducir la variable para el valor del campo. Para seleccionar campos de un módulo principal, seleccione primero el módulo en el área de enlaces en la parte inferior de la lista de campos en el primer menú desplegable, posteriormente seleccione el campo en el segundo menú desplegable.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Ver Historial',
  'LBL_HOMEPAGE_TITLE' => 'Mis Plantillas PDF',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Palabra(s) clave',
  'LBL_KEYWORDS_POPUP_HELP' => 'Asociar Palabras clave con el documento, generalmente en la forma "palabra1 palabra2..."',
  'LBL_LINK_LIST' => 'Enlaces',
  'LBL_LIST_FORM_TITLE' => 'Lista de Plantillas PDF',
  'LBL_LIST_NAME' => 'Nombre',
  'LBL_MODIFIED' => 'Modificado Por',
  'LBL_MODIFIED_ID' => 'Modificado Por Id',
  'LBL_MODIFIED_NAME' => 'Modificado Por Nombre',
  'LBL_MODIFIED_USER' => 'Modificada por Usuario',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Nombre',
  'LBL_NEW_FORM_TITLE' => 'Nueva Plantilla PDF',
  'LBL_PAYMENT_TERMS' => 'Forma de Pago:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Vista Preliminar',
  'LBL_PUBLISHED' => 'Publicado',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publicar una plantilla para que pueda estar disponible para los usuarios.',
  'LBL_PURCHASE_ORDER_NUM' => 'Núm. Pedido de Compra:',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda en PDF Manager',
  'LBL_SUBJECT' => 'Asunto',
  'LBL_TEAM' => 'Equipos',
  'LBL_TEAMS' => 'Equipos',
  'LBL_TEAM_ID' => 'Id de Equipo',
  'LBL_TITLE' => 'Título',
  'LBL_TPL_BILL_TO' => 'Cobrar a',
  'LBL_TPL_CURRENCY' => 'Moneda:',
  'LBL_TPL_DISCOUNT' => 'Descuento:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Subtotal Descontado:',
  'LBL_TPL_EXT_PRICE' => 'Precio Ext.',
  'LBL_TPL_GRAND_TOTAL' => 'Totales',
  'LBL_TPL_INVOICE' => 'Factura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Esta plantilla es utilizada para imprimir Facturas en PDF.',
  'LBL_TPL_INVOICE_NAME' => 'Factura',
  'LBL_TPL_INVOICE_NUMBER' => 'Número de factura:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'factura',
  'LBL_TPL_LIST_PRICE' => 'Precio de Lista',
  'LBL_TPL_PART_NUMBER' => 'Número de Pieza',
  'LBL_TPL_PRODUCT' => 'Producto',
  'LBL_TPL_QUANTITY' => 'Cantidad',
  'LBL_TPL_QUOTE' => 'Presupuesto',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Esta plantilla es utilizada para imprimir Presupuestos en PDF.',
  'LBL_TPL_QUOTE_NAME' => 'Presupuesto',
  'LBL_TPL_QUOTE_NUMBER' => 'Número de Presupuesto:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'presupuesto',
  'LBL_TPL_SALES_PERSON' => 'Vendedor:',
  'LBL_TPL_SHIPPING' => 'Envío:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Proveedor de Transporte:',
  'LBL_TPL_SHIP_TO' => 'Enviar a',
  'LBL_TPL_SUBTOTAL' => 'Subtotal:',
  'LBL_TPL_TAX' => 'Impuesto:',
  'LBL_TPL_TAX_RATE' => 'Tipo de Impuesto:',
  'LBL_TPL_TOTAL' => 'Total',
  'LBL_TPL_UNIT_PRICE' => 'Precio Unitario',
  'LBL_TPL_VALID_UNTIL' => 'Válido hasta:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Editar plantilla PDF',
  'LNK_IMPORT_PDFMANAGER' => 'Importar Plantillas PDF',
  'LNK_LIST' => 'Ver Plantillas PDF',
  'LNK_NEW_RECORD' => 'Crear Plantilla PDF',
);

