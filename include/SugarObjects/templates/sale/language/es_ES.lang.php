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
  'ERR_DELETE_RECORD' => 'Debe de especificar un número de registro para eliminar la venta.',
  'LBL_ACCOUNT_ID' => 'ID de Cuenta',
  'LBL_ACCOUNT_NAME' => 'Nombre de Cuenta:',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_AMOUNT' => 'Cantidad:',
  'LBL_AMOUNT_USDOLLAR' => 'Cantidad en Dólares EEUU:',
  'LBL_ASSIGNED_TO_ID' => 'Asignada a ID',
  'LBL_ASSIGNED_TO_NAME' => 'Usuario:',
  'LBL_CAMPAIGN' => 'Campaña:',
  'LBL_CLOSED_WON_SALES' => 'Ventas Ganadas',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
  'LBL_CREATED_ID' => 'Creada por ID',
  'LBL_CURRENCY' => 'Moneda:',
  'LBL_CURRENCY_ID' => 'ID de Moneda',
  'LBL_CURRENCY_NAME' => 'Nombre de Moneda',
  'LBL_CURRENCY_SYMBOL' => 'Símbolo de Moneda',
  'LBL_DATE_CLOSED' => 'Fecha de Cierre Prevista:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Venta',
  'LBL_DESCRIPTION' => 'Descripción:',
  'LBL_DUPLICATE' => 'Posible Venta Duplicada',
  'LBL_EDIT_BUTTON' => 'Editar',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciales',
  'LBL_LEAD_SOURCE' => 'Toma de Contacto:',
  'LBL_LIST_ACCOUNT_NAME' => 'Nombre de Cuenta',
  'LBL_LIST_AMOUNT' => 'Cantidad',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
  'LBL_LIST_DATE_CLOSED' => 'Cierre',
  'LBL_LIST_FORM_TITLE' => 'Lista de Ventas',
  'LBL_LIST_SALE_NAME' => 'Nombre',
  'LBL_LIST_SALE_STAGE' => 'Etapa de Ventas',
  'LBL_MODIFIED_ID' => 'Modificada por ID',
  'LBL_MODIFIED_NAME' => 'Modificada por Usuario',
  'LBL_MODULE_NAME' => 'Ventas',
  'LBL_MODULE_TITLE' => 'Ventas: Inicio',
  'LBL_MY_CLOSED_SALES' => 'Mis Ventas Cerradas',
  'LBL_NAME' => 'Nombre de Venta',
  'LBL_NEW_FORM_TITLE' => 'Nueva Venta',
  'LBL_NEXT_STEP' => 'Próximo Paso:',
  'LBL_PROBABILITY' => 'Probabilidad (%):',
  'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proyectos',
  'LBL_RAW_AMOUNT' => 'Importe Bruto',
  'LBL_REMOVE' => 'Quitar',
  'LBL_SALE' => 'Venta:',
  'LBL_SALES_STAGE' => 'Etapa de Ventas:',
  'LBL_SALE_INFORMATION' => 'Información sobre la Venta',
  'LBL_SALE_NAME' => 'Nombre de Venta:',
  'LBL_SEARCH_FORM_TITLE' => 'Búsqueda de Ventas',
  'LBL_TEAM_ID' => 'ID de Equipo',
  'LBL_TOP_SALES' => 'Mis Principales Ventas Abiertas',
  'LBL_TOTAL_SALES' => 'Ventas Totales',
  'LBL_TYPE' => 'Tipo:',
  'LBL_VIEW_FORM_TITLE' => 'Vista de Ventas',
  'LNK_NEW_SALE' => 'Nueva Venta',
  'LNK_SALE_LIST' => 'Venta',
  'MSG_DUPLICATE' => 'El registro para la venta que va a crear podría ser un duplicado de otro registro de venta existente. Los registros de venta con nombres similares se listan a continuación.<br>Haga clic en Guardar para continuar con la creación de esta venta, o en Cancelar para volver al módulo sin crear la venta.',
  'NTC_REMOVE_OPP_CONFIRMATION' => '¿Está seguro de que desea eliminar este contacto de la venta?',
  'SALE_REMOVE_PROJECT_CONFIRM' => '¿Está seguro de que desea eliminar esta venta del proyecto?',
  'UPDATE' => 'Venta - Actualización de Moneda',
  'UPDATE_BUGFOUND_COUNT' => 'Problemas Detectados:',
  'UPDATE_BUG_COUNT' => 'Problemas Detectados cuya Resolución se ha Intentado:',
  'UPDATE_COUNT' => 'Registros Actualizados:',
  'UPDATE_CREATE_CURRENCY' => 'Creando Nueva Moneda:',
  'UPDATE_DOLLARAMOUNTS' => 'Actualizar Cantidades en Dólares EEUU',
  'UPDATE_DOLLARAMOUNTS_TXT' => 'Actualiza las cantidades en Dólares EEUU para las ventas basadas en el conjunto actual de cambios de moneda. Este valor se usa para calcular gráficas y vistas de listas de cantidades monetarias.',
  'UPDATE_DONE' => 'Hecho',
  'UPDATE_FAIL' => 'No ha podido actualizarse -',
  'UPDATE_FIX' => 'Corregir Cantidades',
  'UPDATE_FIX_TXT' => 'Intenta corregir cualquier cantidad no válida creando un número decimal válido a partir de la cantidad actual. Antes realiza una copia de seguridad de todas las cantidades modificadas en el campo de base de datos amount_backup. Si tras la correción detecta problemas, no vuelva a realizar esta operación sin restaurar los valores previos desde la copia de seguridad ya que si no sobrescribirá la copia de seguridad con nuevos datos no válidos.',
  'UPDATE_INCLUDE_CLOSE' => 'Registros Cerrados Incluidos',
  'UPDATE_MERGE' => 'Unificar Monedas',
  'UPDATE_MERGE_TXT' => 'Unifica múltiples monedas en una única moneda. Si detecta que hay múltiples registros de tipo moneda para la misma moneda, puede unificarlas. Esto también unificará las monedas para el resto de módulos.',
  'UPDATE_NULL_VALUE' => 'La cantidad es NULL, estableciéndola a 0 -',
  'UPDATE_RESTORE' => 'Restaurar Cantidades',
  'UPDATE_RESTORE_COUNT' => 'Registros con Cantidades Restauradas:',
  'UPDATE_RESTORE_TXT' => 'Restaura los valores de las cantidades desde la copia de seguridad creada durante la corrección.',
  'UPDATE_VERIFY' => 'Verificar Cantidades',
  'UPDATE_VERIFY_CURAMOUNT' => 'Moneda Actual:',
  'UPDATE_VERIFY_FAIL' => 'Fallo de Verificación de Registro:',
  'UPDATE_VERIFY_FIX' => 'La Corrección daría',
  'UPDATE_VERIFY_NEWAMOUNT' => 'Nueva Cantidad:',
  'UPDATE_VERIFY_NEWCURRENCY' => 'Nueva Moneda:',
  'UPDATE_VERIFY_TXT' => 'Verifica que los valores de las cantidades en las ventas son números decimales válidos con sólo caracteres numéricos (0-9) y decimales(.)',
);

