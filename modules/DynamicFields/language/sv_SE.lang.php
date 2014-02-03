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
  'COLUMN_DISABLE_NUMBER_FORMAT' => 'Inaktivera format',
  'COLUMN_TITLE_AUDIT' => 'Spårbarhet',
  'COLUMN_TITLE_AUTOINC_NEXT' => 'Öka automatiskt till nästa värde',
  'COLUMN_TITLE_COMMENT_TEXT' => 'Kommentars text',
  'COLUMN_TITLE_DATA_TYPE' => 'Data typ',
  'COLUMN_TITLE_DEFAULT_EMAIL' => 'Standardvärde',
  'COLUMN_TITLE_DEFAULT_VALUE' => 'Standardvärde',
  'COLUMN_TITLE_DISPLAYED_ITEM_COUNT' => '# Poster visare',
  'COLUMN_TITLE_DISPLAY_LABEL' => 'Display Label',
  'COLUMN_TITLE_DUPLICATE_MERGE' => 'Dublicera sammanfogning',
  'COLUMN_TITLE_ENABLE_RANGE_SEARCH' => 'Aktivera Område Sök',
  'COLUMN_TITLE_EXT1' => 'Extra meta fält 1',
  'COLUMN_TITLE_EXT2' => 'Extra meta fält 2',
  'COLUMN_TITLE_EXT3' => 'Extra meta fält 3',
  'COLUMN_TITLE_FRAME_HEIGHT' => 'IFrame höjd',
  'COLUMN_TITLE_FTS' => 'Möjlig Fulltextsökning',
  'COLUMN_TITLE_GLOBAL_SEARCH' => 'Global Sök',
  'COLUMN_TITLE_HELP_TEXT' => 'Hjälptext',
  'COLUMN_TITLE_HTML_CONTENT' => 'HTML',
  'COLUMN_TITLE_IMPORTABLE' => 'Importerbar',
  'COLUMN_TITLE_LABEL' => 'System Label',
  'COLUMN_TITLE_LABEL_COLS' => 'Kolumner',
  'COLUMN_TITLE_LABEL_ROWS' => 'Rader',
  'COLUMN_TITLE_LABEL_VALUE' => 'Label värde',
  'COLUMN_TITLE_MASS_UPDATE' => 'Massuppdatera',
  'COLUMN_TITLE_MAX_SIZE' => 'Max storlek',
  'COLUMN_TITLE_MAX_VALUE' => 'Max värde',
  'COLUMN_TITLE_MIN_VALUE' => 'Min värde',
  'COLUMN_TITLE_NAME' => 'Fältnamn',
  'COLUMN_TITLE_PRECISION' => 'Precision',
  'COLUMN_TITLE_REPORTABLE' => 'Rapporteringsbar',
  'COLUMN_TITLE_REQUIRED_OPTION' => 'Obligatoriskt fält',
  'COLUMN_TITLE_URL' => 'Standard URL',
  'COLUMN_TITLE_VALIDATE_US_FORMAT' => 'U.S. Format',
  'ERR_FIELD_NAME_ALREADY_EXISTS' => 'Fältnamn existerar redan',
  'ERR_RESERVED_FIELD_NAME' => 'Reserverat nyckelord',
  'ERR_SELECT_FIELD_TYPE' => 'Vänligen välj fält typ',
  'LBL_ADD_FIELD' => 'Lägg till fält',
  'LBL_AUDITED' => 'Granskad',
  'LBL_BTN_ADD' => 'Lägg till',
  'LBL_BTN_EDIT' => 'Redigera',
  'LBL_BTN_EDIT_VISIBILITY' => 'Ändra synlighet',
  'LBL_CALCULATED' => 'Beräknad värde',
  'LBL_DATA_TYPE' => 'Data typ',
  'LBL_DEFAULT_VALUE' => 'Standardvärde',
  'LBL_DEPENDENT' => 'Beroende',
  'LBL_DEPENDENT_CHECKBOX' => 'Beroende',
  'LBL_DEPENDENT_TRIGGER' => 'Trigger',
  'LBL_DROP_DOWN_LIST' => 'Rullgardinsmeny',
  'LBL_DYNAMIC_VALUES_CHECKBOX' => 'Beroende',
  'LBL_EDIT_VIS' => 'Ändra synlighet',
  'LBL_ENFORCED' => 'Verkställas',
  'LBL_FORMULA' => 'Formel',
  'LBL_GENERATE_URL' => 'Generera URL',
  'LBL_HAS_PARENT' => 'Har Förälder',
  'LBL_HELP' => 'Hjälp',
  'LBL_IMAGE_BORDER' => 'Ram',
  'LBL_IMAGE_HEIGHT' => 'Höjd',
  'LBL_IMAGE_WIDTH' => 'Bredd',
  'LBL_LABEL' => 'Label',
  'LBL_LINK_TARGET' => 'Öppna länk i',
  'LBL_MODULE' => 'Modul',
  'LBL_MODULE_SELECT' => 'Editera modul',
  'LBL_MULTI_SELECT_LIST' => 'Multiselekteringslista',
  'LBL_PARENT_DROPDOWN' => 'Förälder Dropdown',
  'LBL_RADIO_FIELDS' => 'Envalsknapp',
  'LBL_REPORTABLE' => 'Rapporteringsbar',
  'LBL_SEARCH_FORM_TITLE' => 'Sök moduler',
  'LBL_VISIBLE_IF' => 'Synlig om',
  'LNK_CALL_LIST' => 'Telefonsamtal',
  'LNK_EMAIL_LIST' => 'Epost',
  'LNK_MEETING_LIST' => 'Möten',
  'LNK_NEW_CALL' => 'Schemalägg telefonsamtal',
  'LNK_NEW_EMAIL' => 'Arkivera epost',
  'LNK_NEW_MEETING' => 'Schemalägg möte',
  'LNK_NEW_NOTE' => 'Skapa anteckning eller bilaga',
  'LNK_NEW_TASK' => 'Skapa uppgift',
  'LNK_NOTE_LIST' => 'Anteckningar',
  'LNK_REPAIR_CUSTOM_FIELD' => 'Reparera specialfält',
  'LNK_SELECT_CUSTOM_FIELD' => 'Välj specialfält',
  'LNK_TASK_LIST' => 'Uppgifter',
  'MSG_DELETE_CONFIRM' => 'Är du säker på att du vill ta bort denna post?',
  'POPUP_EDIT_HEADER_TITLE' => 'Editera specialfält',
  'POPUP_INSERT_HEADER_TITLE' => 'Lägg till specialfält',
);

