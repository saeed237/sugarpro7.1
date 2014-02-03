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
  'LBL_ALERT_SWITCH_BASE_MODULE' => 'AVISO: Se alterar o módulo principal, todos os campos já adicionados ao template terão que ser removidos.',
  'LBL_ASSIGNED_TO_ID' => 'Id do Utilizador Atribuído',
  'LBL_ASSIGNED_TO_NAME' => 'Atribuído a',
  'LBL_AUTHOR' => 'Autor',
  'LBL_BASE_MODULE' => 'Módulo',
  'LBL_BASE_MODULE_POPUP_HELP' => 'Seleccionar um módulo para o qual este template estará disponível.',
  'LBL_BODY_HTML' => 'Template',
  'LBL_BODY_HTML_POPUP_HELP' => 'Crie um template utilizando o editor HTML. Depois de guardar o template, terá a possibilidade de ver uma antevisão da versão PDF do template.',
  'LBL_BODY_HTML_POPUP_QUOTES_HELP' => 'Crie um template utilizando o editor HTML. Depois de guardar o template, terá a possibilidade de ver uma antevisão da versão PDF do template.<br /><br />Para editar ciclo usado para criar os itens de Linha de Produtos, carregue no botão "HTML" no editor para aceder ao código. O código está contido dentro de <!--START_BUNDLE_LOOP-->, <!--START_PRODUCT_LOOP-->, <!--END_PRODUCT_LOOP-->; and <!--END_BUNDLE_LOOP-->.',
  'LBL_BTN_INSERT' => 'Inserir',
  'LBL_CREATED' => 'Criado por',
  'LBL_CREATED_ID' => 'Id de Utilizador que Criou',
  'LBL_CREATED_USER' => 'Criado pelo Utilizador',
  'LBL_DATE_ENTERED' => 'Data de Criação',
  'LBL_DATE_MODIFIED' => 'Data de Modificação',
  'LBL_DELETED' => 'Eliminado',
  'LBL_DESCRIPTION' => 'Descrição',
  'LBL_EDITVIEW_PANEL1' => 'Propriedades do Documento PDF',
  'LBL_EMAIL_PDF_DEFAULT_DESCRIPTION' => 'Aqui está o ficheiro requerido (Pode mudar este texto)',
  'LBL_FIELD' => 'Campo',
  'LBL_FIELDS_LIST' => 'Campos',
  'LBL_FIELD_POPUP_HELP' => 'Seleccione um campo para inserir a variável para o valor do campo. Para seleccionar campos de um módulo pai, primeiro seleccionar o módulo na área de Links no fundo da lista de Campos, no primeiro dropdown e depois seleccionar o campo no segundo dropdown.',
  'LBL_FOOTER_TEXT' => 'Texto do Rodapé',
  'LBL_HEADER_LOGO_URL' => 'URL do Logo do Cabeçalho',
  'LBL_HEADER_TEXT' => 'Texto de Cabeçalho',
  'LBL_HEADER_TITLE' => 'Título do Cabeçalho',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Ver Histórico',
  'LBL_HOMEPAGE_TITLE' => 'Os Meus Templates PDf',
  'LBL_ID' => 'ID',
  'LBL_KEYWORDS' => 'Palavra(s)-Chave',
  'LBL_KEYWORDS_POPUP_HELP' => 'Associar Palavras-chave ao documento, geralmente no formato "palavra-chave1 palavra-chave2..."',
  'LBL_LINK_LIST' => 'Links',
  'LBL_LIST_FORM_TITLE' => 'Lista de Templates PDF',
  'LBL_LIST_NAME' => 'Nome',
  'LBL_MODIFIED' => 'Modificado por',
  'LBL_MODIFIED_ID' => 'Id de Utilizador que Modificou',
  'LBL_MODIFIED_NAME' => 'Modificado pelo Nome do Utilizador',
  'LBL_MODIFIED_USER' => 'Modificado pelo Utilizador',
  'LBL_MODULE_NAME' => 'PdfManager',
  'LBL_MODULE_NAME_SINGULAR' => 'PdfManager',
  'LBL_MODULE_TITLE' => 'PdfManager',
  'LBL_NAME' => 'Nome',
  'LBL_NEW_FORM_TITLE' => 'Novo Template PDF',
  'LBL_PAYMENT_TERMS' => 'Termos de Pagamento:',
  'LBL_PDFMANAGER_SUBPANEL_TITLE' => 'PdfManager',
  'LBL_PREVIEW' => 'Pré-Visualização',
  'LBL_PUBLISHED' => 'Publicado',
  'LBL_PUBLISHED_POPUP_HELP' => 'Publicar um template para torna-lo disponível aos utilizadores.',
  'LBL_PURCHASE_ORDER_NUM' => 'Número do Pedido de Compra:',
  'LBL_SEARCH_FORM_TITLE' => 'Procurar no Gestor de PDF',
  'LBL_SUBJECT' => 'Assunto',
  'LBL_TEAM' => 'Equipas',
  'LBL_TEAMS' => 'Equipas',
  'LBL_TEAM_ID' => 'ID da Equipa',
  'LBL_TITLE' => 'Título',
  'LBL_TPL_BILL_TO' => 'Facturar a',
  'LBL_TPL_CURRENCY' => 'Moeda:',
  'LBL_TPL_DISCOUNT' => 'Desconto:',
  'LBL_TPL_DISCOUNTED_SUBTOTAL' => 'Subtotal do Desconto:',
  'LBL_TPL_EXT_PRICE' => 'Preço Externo',
  'LBL_TPL_GRAND_TOTAL' => 'Total Geral',
  'LBL_TPL_INVOICE' => 'Factura',
  'LBL_TPL_INVOICE_DESCRIPTION' => 'Este template é usado para imprimir uma Factura em PDF',
  'LBL_TPL_INVOICE_NAME' => 'Factura',
  'LBL_TPL_INVOICE_NUMBER' => 'Número de factura:',
  'LBL_TPL_INVOICE_TEMPLATE_NAME' => 'factura',
  'LBL_TPL_LIST_PRICE' => 'Preço de Lista',
  'LBL_TPL_PART_NUMBER' => 'Número da Peça',
  'LBL_TPL_PRODUCT' => 'Produto',
  'LBL_TPL_QUANTITY' => 'Quantidade',
  'LBL_TPL_QUOTE' => 'Cotação',
  'LBL_TPL_QUOTE_DESCRIPTION' => 'Este template é usado para imprimir uma Cotação em PDF',
  'LBL_TPL_QUOTE_NAME' => 'Cotação',
  'LBL_TPL_QUOTE_NUMBER' => 'Numero da cotação:',
  'LBL_TPL_QUOTE_TEMPLATE_NAME' => 'cotação',
  'LBL_TPL_SALES_PERSON' => 'Vendedor:',
  'LBL_TPL_SHIPPING' => 'Envio:',
  'LBL_TPL_SHIPPING_PROVIDER' => 'Fornecedor de Entrega',
  'LBL_TPL_SHIP_TO' => 'Entregar a',
  'LBL_TPL_SUBTOTAL' => 'Subtotal:',
  'LBL_TPL_TAX' => 'Imposto:',
  'LBL_TPL_TAX_RATE' => 'Taxa de Imposto:',
  'LBL_TPL_TOTAL' => 'Total',
  'LBL_TPL_UNIT_PRICE' => 'Preço Unitário',
  'LBL_TPL_VALID_UNTIL' => 'Válido até:',
  'LNK_EDIT_PDF_TEMPLATE' => 'Editar Template de PDF',
  'LNK_IMPORT_PDFMANAGER' => 'Importar Templates',
  'LNK_LIST' => 'Ver Templates PDF',
  'LNK_NEW_RECORD' => 'Criar Template PDF',
);

