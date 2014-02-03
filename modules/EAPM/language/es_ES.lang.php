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
  'LBL_ACTIVE' => 'Activa',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
  'LBL_API_CONSKEY' => 'Clave del Consumidor',
  'LBL_API_CONSSECRET' => 'Secreto del Consumidor',
  'LBL_API_DATA' => 'Datos API',
  'LBL_API_OAUTHTOKEN' => 'OAuth Token',
  'LBL_API_TYPE' => 'Tipo de registro',
  'LBL_APPLICATION' => 'Aplicación',
  'LBL_APPLICATION_FOUND_NOTICE' => 'Una cuenta para esta aplicación ya existe. Se ha restituido la cuenta existente.',
  'LBL_ASSIGNED_TO_ID' => 'ID usuario asignado',
  'LBL_ASSIGNED_TO_NAME' => 'Usuario de Sugar',
  'LBL_AUTH_ERROR' => 'El intento de conectarse con la cuenta fallo.',
  'LBL_AUTH_UNSUPPORTED' => 'Este método de registro no es compatible con la aplicación',
  'LBL_BASIC_SAVE_NOTICE' => 'Haga clic en <b> conectar </b> para conectar la cuenta en Sugar.',
  'LBL_CONNECTED' => 'Conectado',
  'LBL_CONNECT_BUTTON_TITLE' => 'Conecta',
  'LBL_CREATED' => 'Creado por',
  'LBL_CREATED_ID' => 'Creado por Id',
  'LBL_CREATED_USER' => 'Creada por usuario',
  'LBL_DATE_ENTERED' => 'Fecha de creación',
  'LBL_DATE_MODIFIED' => 'Fecha de modificación',
  'LBL_DELETED' => 'Eliminado',
  'LBL_DESCRIPTION' => 'Descripción',
  'LBL_DISCONNECTED' => 'No conectado',
  'LBL_DISPLAY_PROPERTIES' => 'Ver propiedades',
  'LBL_ERR_FACEBOOK' => 'Facebook ha devuelto un error, y la información no se puede mostrar.',
  'LBL_ERR_FAILED_QUICKCHECK' => 'Usted no está conectado a su cuenta {0}. Haga clic en Aceptar para acceder a su cuenta y volver a activar la conexión.',
  'LBL_ERR_NO_AUTHINFO' => 'No hay información de autenticación para esta cuenta.',
  'LBL_ERR_NO_RESPONSE' => 'Se produjo un error al intentar conectarse a esta cuenta.',
  'LBL_ERR_NO_TOKEN' => 'No hay token válido para registrar esta cuenta.',
  'LBL_ERR_OAUTH_FACEBOOK_1' => 'Sesión de facebook caducada. Para transferirse, por favor',
  'LBL_ERR_OAUTH_FACEBOOK_2' => 'vuelva a iniciar sesión de Facebook',
  'LBL_ERR_POPUPS_DISABLED' => 'Por favor, activa las ventanas emergente del navegador o agregar una excepción para el sitio web "{0}" a la lista de excepciones con el fin de conectar.',
  'LBL_ERR_TWITTER' => 'Twitter ha devuelto un error, y la información no se puede mostrar.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Ver historial',
  'LBL_HOMEPAGE_TITLE' => 'Mis cuentas externas',
  'LBL_ID' => 'ID',
  'LBL_LIST_FORM_TITLE' => 'Lista de cuentas externas',
  'LBL_LIST_NAME' => 'Nombre',
  'LBL_MEET_NOW_BUTTON' => 'Reunirse ahora',
  'LBL_MODIFIED' => 'Modificado por',
  'LBL_MODIFIED_ID' => 'Modificado por Id',
  'LBL_MODIFIED_NAME' => 'Modificada por usuario',
  'LBL_MODIFIED_USER' => 'Modificado por usuario',
  'LBL_MODULE_NAME' => 'Cuenta externa',
  'LBL_MODULE_NAME_SINGULAR' => 'Cuenta Externa',
  'LBL_MODULE_TITLE' => 'Cuentas externas',
  'LBL_NAME' => 'Nombre del usuario de la App',
  'LBL_NEW_FORM_TITLE' => 'Nueva cuenta externa',
  'LBL_NOTE' => 'Tenga en cuenta',
  'LBL_OAUTH_NAME' => '%s',
  'LBL_OAUTH_SAVE_NOTICE' => 'Haga clic en <b> conectar </ b> para dirigirse a una página para proporcionar información de su cuenta y para autorizar el acceso a la cuenta por Sugar. Después de conectar, se le redirige de vuelta Sugar.',
  'LBL_OMIT_URL' => '(Omitir http:// o https://)',
  'LBL_PASSWORD' => 'Contraseña App',
  'LBL_REAUTHENTICATE_KEY' => 'a',
  'LBL_REAUTHENTICATE_LABEL' => 'Volver a registrarse',
  'LBL_SEARCH_FORM_TITLE' => 'Buscar fuentes externas',
  'LBL_SUCCESS' => 'ÉXITO',
  'LBL_SUGAR_EAPM_SUBPANEL_TITLE' => 'Cuentas externas',
  'LBL_SUGAR_USER_NAME' => 'Usuario Sugar',
  'LBL_TEAM' => 'Equipo',
  'LBL_TEAMS' => 'Equipos',
  'LBL_TEAM_ID' => 'ID Equipo',
  'LBL_TITLE_LOTUS_LIVE_DOCUMENTS' => 'Archivos de LotusLive&trade;',
  'LBL_TITLE_LOTUS_LIVE_MEETINGS' => 'Próximas reuniones LotusLive&trade;',
  'LBL_URL' => 'URL',
  'LBL_USER_NAME' => 'Usuario App',
  'LBL_VALIDATED' => 'Conectado',
  'LBL_VIEW_LOTUS_LIVE_DOCUMENTS' => 'Ver archivos de LotusLive&trade;',
  'LBL_VIEW_LOTUS_LIVE_MEETINGS' => 'Ver próximas reuniones de LotusLive&trade;',
  'LNK_IMPORT_SUGAR_EAPM' => 'Importar cuentas externas',
  'LNK_LIST' => 'Ver cuentas externas',
  'LNK_NEW_RECORD' => 'Crear cuenta externa',
);

