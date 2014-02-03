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
  'LBL_SNIP_KEY_DESC' => 'Email Archiving clave OAuth. Se utiliza para acceder a esta instancia para la importación de mensajes de correo electrónico.',
  'LBL_SNIP_STATUS_ERROR' => 'Error',
  'LBL_SNIP_SUMMARY' => 'Email Archiving es un servicio automático de importación que permite a los usuarios importar correos electrónicos en Sugar mediante el envío de cualquier cliente de correo o servicio a un Sugar proporciona dirección de correo electrónico. Cada instancia de Sugar tiene su propia dirección de correo electrónico única. Para importar mensajes de correo electrónico, un usuario envía a la dirección de correo electrónico proporcionada con el Para, CC, CCO. El servicio de Email Archiving va a importar el correo electrónico en el caso del Sugar. El servicio de las importaciones del correo electrónico, junto con los archivos adjuntos, imágenes y citas del calendario, y crea los registros dentro de la aplicación que se asocian con los registros existentes basados en la coincidencia de direcciones de correo electrónico.<br />    <br><br>Ejemplo: Como usuario, cuando miro una cuenta, voy a ser capaz de ver todos los mensajes de correo electrónico que se asocian con la cuenta sobre la base de la dirección de correo electrónico en el registro de cuenta. También voy a ser capaz de ver los correos electrónicos que están asociados con los contactos relacionados con la cuenta.<br />    <br><br>Aceptar los términos a continuación y haga clic en Habilitar para empezar a utilizar el servicio. Usted será capaz de deshabilitar el servicio en cualquier momento. Una vez que el servicio está habilitado, la dirección de correo electrónico que se utilizará para el servicio aparecerá en pantalla.<br />    <br><br>',
  'LBL_REGISTER_SNIP_FAIL' => 'No se pudo contactar con el servicio de Facilidad de Sugar : %s!<br>',
  'LBL_CONFIGURE_SNIP' => 'Facilidad de Sugar',
  'LBL_DISABLE_SNIP' => 'Deshabilitar',
  'LBL_SNIP_APPLICATION_UNIQUE_KEY' => 'Solicitud de clave única',
  'LBL_SNIP_USER' => 'Usuario de Facilidad de Sugar',
  'LBL_SNIP_PWD' => 'Contraseña de Facilidad de Sugar',
  'LBL_SNIP_SUGAR_URL' => 'La URL de la instancia de Sugar',
  'LBL_SNIP_CALLBACK_URL' => 'URL del servicio de Facilidad de Sugar',
  'LBL_SNIP_USER_DESC' => 'Usuario de Email Archiving',
  'LBL_SNIP_STATUS_OK' => 'Habilitado',
  'LBL_SNIP_STATUS_OK_SUMMARY' => 'Esta instancia de Sugar se ha conectado al servidor de Email Archiving.',
  'LBL_SNIP_STATUS_ERROR_SUMMARY' => 'Esta instancia tiene un servidor de licencia de Email Archiving valido, pero el servidor devolvió el siguiente mensaje de error:',
  'LBL_SNIP_STATUS_FAIL' => 'No se puede registrar con el servidor de Facilidad de Sugar',
  'LBL_SNIP_STATUS_FAIL_SUMMARY' => 'El servicio Facilidad de Sugar no está disponible actualmente. O bien el servicio está inactivo o la conexión con la instancia de Sugar falla.',
  'LBL_SNIP_GENERIC_ERROR' => 'El servicio Facilidad de Sugar no está disponible actualmente. O bien el servicio está inactivo o la conexión con la instancia de Sugar falla.',
  'LBL_SNIP_STATUS_RESET' => 'Sin embargo, no se ejecutan',
  'LBL_SNIP_STATUS_PROBLEM' => 'Problema: %s',
  'LBL_SNIP_NEVER' => 'Nunca',
  'LBL_SNIP_STATUS_SUMMARY' => 'Facilidad de Sugar en el estado de archivo:',
  'LBL_SNIP_ACCOUNT' => 'Cuenta',
  'LBL_SNIP_STATUS' => 'Estado',
  'LBL_SNIP_LAST_SUCCESS' => 'Último arranque exitoso',
  'LBL_SNIP_DESCRIPTION' => 'Facilidad de Sugar es un sistema de correo electrónico de archivo automático',
  'LBL_SNIP_DESCRIPTION_SUMMARY' => 'Que le permite ver correos electrónicos que fueron enviados hacia o desde sus contactos dentro de SugarCRM, sin tener que importar manualmente y vincular los correos electrónicos',
  'LBL_SNIP_PURCHASE_SUMMARY' => 'Para utilizar Email Archiving, usted debe comprar una licencia para la instancia de SugarCRM',
  'LBL_SNIP_PURCHASE' => 'Haga clic aquí para comprar',
  'LBL_SNIP_EMAIL' => 'Dirección de Email Archiving',
  'LBL_SNIP_AGREE' => 'Estoy de acuerdo en los términos anteriores y el <a href="http://www.sugarcrm.com/crm/TRUSTe/privacy.html" target="_blank">acuerdo de privacidad</a>.',
  'LBL_SNIP_PRIVACY' => 'acuerdo de privacidad',
  'LBL_SNIP_STATUS_PINGBACK_FAIL' => 'Fallo de retorno de Ping',
  'LBL_SNIP_STATUS_PINGBACK_FAIL_SUMMARY' => 'El servidor de Email Archiving no es capaz de establecer una conexión con la instancia de Sugar. Por favor, inténtelo de nuevo o <a href="http://www.sugarcrm.com/crm/case-tracker/submit.html?lsd=supportportal&tmpl=" target="_blank">póngase en contacto con atención al cliente</a>.',
  'LBL_SNIP_BUTTON_ENABLE' => 'Activar Facilidad de Sugar',
  'LBL_SNIP_BUTTON_DISABLE' => 'Desactivar Facilidad de Sugar',
  'LBL_SNIP_BUTTON_RETRY' => 'Intente conectarse de nuevo',
  'LBL_SNIP_ERROR_DISABLING' => 'Se produjo un error al intentar comunicarse con el servidor de Email Archiving, y el servicio no puede ser desactivado',
  'LBL_SNIP_ERROR_ENABLING' => 'Se produjo un error al intentar comunicarse con el servidor de Email Archiving, y el servicio no puede ser habilitado',
  'LBL_CONTACT_SUPPORT' => 'Por favor, inténtelo de nuevo o póngase en contacto con el soporte de SugarCRM.',
  'LBL_SNIP_SUPPORT' => 'Por favor, póngase en contacto con el soporte de SugarCRM para obtener ayuda.',
  'ERROR_BAD_RESULT' => 'Mal resultado devuelto por el servicio',
  'ERROR_NO_CURL' => 'La extensión cURL es necesario, pero no esta activa',
  'ERROR_REQUEST_FAILED' => 'No se pudo contactar con el servidor',
  'LBL_CANCEL_BUTTON_TITLE' => 'Cancelar',
  'LBL_SNIP_MOUSEOVER_STATUS' => 'Este es el estado del servicio de Email Archiving en su instancia. El estado refleja que la conexión entre el servidor de Email Archiving y la instancia de Sugar es correcto.',
  'LBL_SNIP_MOUSEOVER_EMAIL' => 'Este es la dirección de correo electrónico de Email Archiving para enviar a fin de importar mensajes de correo electrónico en Sugar.',
  'LBL_SNIP_MOUSEOVER_SERVICE_URL' => 'Esta es la URL del servidor de Email Archiving. Todas las solicitudes, como habilitar y deshabilitar el servicio de Email Archiving, será retransmitido a través de esta URL.',
  'LBL_SNIP_MOUSEOVER_INSTANCE_URL' => 'Esta es la URL de servicios web de la instancia de Sugar. El servidor de Email Archiving se conectará a su servidor a través de esta URL.',
);

