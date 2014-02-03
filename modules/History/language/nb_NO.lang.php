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

















if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');




$mod_strings= array (
'LBL_MODULE_NAME'                                  => 'Historie',
'LBL_MODULE_TITLE'                                 => 'Historie: Hovedside',
'LBL_SEARCH_FORM_TITLE'                            => 'Historiesøk',
'LBL_LIST_FORM_TITLE'                              => 'Historie',
'LBL_LIST_SUBJECT'                                 => 'Emne',
'LBL_LIST_CONTACT'                                 => 'Kontakt',
'LBL_LIST_RELATED_TO'                              => 'Beslektet med',
'LBL_LIST_DATE'                                    => 'Dato',
'LBL_LIST_TIME'                                    => 'Starttid',
'LBL_LIST_CLOSE'                                   => 'Lukk',
'LBL_SUBJECT'                                      => 'Emne:',
'LBL_STATUS'                                       => 'Status:',
'LBL_LOCATION'                                     => 'Sted:',
'LBL_DATE_TIME'                                    => 'Startdato & klokkeslett:',
'LBL_DATE'                                         => 'Startdato:',
'LBL_TIME'                                         => 'Starttid:',
'LBL_DURATION'                                     => 'Varighet:',
'LBL_HOURS_MINS'                                   => '(timer/minutter)',
'LBL_CONTACT_NAME'                                 => 'Kontaktens navn:',
'LBL_MEETING'                                      => 'Møte:',
'LBL_DESCRIPTION_INFORMATION'                      => 'Beskrivelsesinformasjon',
'LBL_DESCRIPTION'                                  => 'Beskrivelse',
'LBL_COLON'                                        => ':',
'LBL_DEFAULT_STATUS'                               => 'Planlagt',
'LNK_NEW_CALL'                                     => 'Opprett oppringning',
'LNK_NEW_MEETING'                                  => 'Opprett møte',
'LNK_NEW_TASK'                                     => 'Opprett oppgave',
'LNK_NEW_NOTE'                                     => 'Opprett notat eller vedlegg',
'LNK_NEW_EMAIL'                                    => 'Arkivér e-post',
'LNK_CALL_LIST'                                    => 'Oppringninger',
'LNK_MEETING_LIST'                                 => 'Møter',
'LNK_TASK_LIST'                                    => 'Oppgaver',
'LNK_NOTE_LIST'                                    => 'Notater',
'LNK_EMAIL_LIST'                                   => 'E-post',
'ERR_DELETE_RECORD'                                => 'Du må oppgi postens nummer for å slette bedriften.',
'NTC_REMOVE_INVITEE'                               => 'Vil du virkelig fjerne denne deltageren fra møtet?',
'LBL_INVITEE'                                      => 'Deltagere',
'LBL_LIST_DIRECTION'                               => 'Retning',
'LBL_DIRECTION'                                    => 'Retning',
'LNK_NEW_APPOINTMENT'                              => 'Ny avtale',
'LNK_VIEW_CALENDAR'                                => 'I dag',
'LBL_OPEN_ACTIVITIES'                              => 'Åpne aktiviteter',
'LBL_HISTORY'                                      => 'Historie',
'LBL_UPCOMING'                                     => 'Mine neste avtaler',
'LBL_TODAY'                                        => 't.o.m.',
'LBL_NEW_TASK_BUTTON_TITLE'                        => 'Opprett oppgave [Alt+N]',
'LBL_NEW_TASK_BUTTON_KEY'                          => 'N',
'LBL_NEW_TASK_BUTTON_LABEL'                        => 'Opprett oppgave ',
'LBL_SCHEDULE_MEETING_BUTTON_TITLE'                => 'Opprett møte [Alt+M] ',
'LBL_SCHEDULE_MEETING_BUTTON_KEY'                  => 'M',
'LBL_SCHEDULE_MEETING_BUTTON_LABEL'                => 'Opprett møte',
'LBL_SCHEDULE_CALL_BUTTON_TITLE'                   => 'Opprett oppringning [Alt+C]',
'LBL_SCHEDULE_CALL_BUTTON_KEY'                     => 'C',
'LBL_SCHEDULE_CALL_BUTTON_LABEL'                   => 'Opprett oppringning ',
'LBL_NEW_NOTE_BUTTON_TITLE'                        => 'Opprett notat eller vedlegg [Alt+T] ',
'LBL_NEW_NOTE_BUTTON_KEY'                          => 'T',
'LBL_NEW_NOTE_BUTTON_LABEL'                        => 'Opprett notat eller vedlegg',
'LBL_TRACK_EMAIL_BUTTON_TITLE'                     => 'Arkivér e-post [Alt+K]',
'LBL_TRACK_EMAIL_BUTTON_KEY'                       => 'K',
'LBL_TRACK_EMAIL_BUTTON_LABEL'                     => 'Arkivér e-post',
'LBL_LIST_STATUS'                                  => 'Status',
'LBL_LIST_DUE_DATE'                                => 'Tidsfrist',
'LBL_LIST_LAST_MODIFIED'                           => 'Sist endret',
'NTC_NONE_SCHEDULED'                               => 'Ingen planlagt.',
'LNK_IMPORT_NOTES'                                 => 'Importér notater',
'NTC_NONE'                                         => 'Ingen',
'LBL_ACCEPT_THIS'                                  => 'Godta?',
'LBL_DEFAULT_SUBPANEL_TITLE'                       => 'Historie',


'appointment_filter_dom' => array(
'today'                                            => 'i dag',
'tomorrow'                                         => 'i morgen',
'this Saturday'                                    => 'denne uken',
'next Saturday'                                    => 'neste uke',
'last this_month'                                  => 'denne måneden',
'last next_month'                                  => 'neste måned',
),
);?>
