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
'LBL_MODULE_NAME'                                  => 'Prognoser',
'LNK_NEW_OPPORTUNITY'                              => 'Opprett mulighet',
'LBL_MODULE_TITLE'                                 => 'Prognoser',
'LBL_LIST_FORM_TITLE'                              => 'Engasjerte prognoser',
'LNK_UPD_FORECAST'                                 => 'Arbeidsflate for prognoser',
'LNK_QUOTA'                                        => 'Kvoter',
'LNK_FORECAST_LIST'                                => 'Prognosehistorikk',
'LBL_FORECAST_HISTORY'                             => 'Prognoser: Historikk',
'LBL_FORECAST_HISTORY_TITLE'                       => 'Prognoser: Historikk',
'LBL_TIMEPERIOD_NAME'                              => 'Tidsperiode',
'LBL_USER_NAME'                                    => 'Brukernavn',
'LBL_REPORTS_TO_USER_NAME'                         => 'Rapporterer til',
'LBL_FORECAST_ID'                                  => 'ID',
'LBL_FORECAST_TIME_ID'                             => 'Tidsperiode-ID',
'LBL_FORECAST_TYPE'                                => 'Prognosetype',
'LBL_FORECAST_OPP_COUNT'                           => 'Muligheter',
'LBL_FORECAST_OPP_WEIGH'                           => 'Vektet mengde',
'LBL_FORECAST_OPP_COMMIT'                          => 'Trolig utfall',
'LBL_FORECAST_OPP_BEST_CASE'                       => 'Beste utfall',
'LBL_FORECAST_OPP_WORST'                           => 'Verste utfall',
'LBL_FORECAST_USER'                                => 'Bruker',
'LBL_DATE_COMMITTED'                               => 'Engasjeringsdato',
'LBL_DATE_ENTERED'                                 => 'Inngangsdato',
'LBL_DATE_MODIFIED'                                => 'Endringsdato',
'LBL_CREATED_BY'                                   => 'Opprettet av',
'LBL_DELETED'                                      => 'Slettet',
'LBL_MODIFIED_USER_ID'                             => 'Endret av',
'LBL_QC_TIME_PERIOD'                               => 'Tidsperiode:',
'LBL_QC_OPPORTUNITY_COUNT'                         => 'Mulighetsberegning:',
'LBL_QC_WEIGHT_VALUE'                              => 'Vektet mengde:',
'LBL_QC_COMMIT_VALUE'                              => 'Engasjeringsmengde:',
'LBL_QC_COMMIT_BUTTON'                             => 'Engasjér',
'LBL_QC_WORKSHEET_BUTTON'                          => 'Arbeidsflate',
'LBL_QC_ROLL_COMMIT_VALUE'                         => 'Rollup-engajseringsmengde:',
'LBL_QC_DIRECT_FORECAST'                           => 'Mine direkte prognoser:',
'LBL_QC_ROLLUP_FORECAST'                           => 'Min grupeps prognoser:',
'LBL_QC_UPCOMING_FORECASTS'                        => 'Mine prognoser',
'LBL_QC_LAST_DATE_COMMITTED'                       => 'Siste engasjeringsdato:',
'LBL_QC_LAST_COMMIT_VALUE'                         => 'Siste engasjeringsmengde:',
'LBL_QC_HEADER_DELIM'                              => 'Til',
'LBL_OW_OPPORTUNITIES'                             => 'Mulighet',
'LBL_OW_ACCOUNTNAME'                               => 'Bedrift',
'LBL_OW_REVENUE'                                   => 'Mengde',
'LBL_OW_WEIGHTED'                                  => 'Vektet mengde',
'LBL_OW_MODULE_TITLE'                              => 'Arbeidsflate for mulighet',
'LBL_OW_PROBABILITY'                               => 'Trolighet',
'LBL_OW_NEXT_STEP'                                 => 'Neste skritt',
'LBL_OW_DESCRIPTION'                               => 'Beskrivelse',
'LBL_OW_TYPE'                                      => 'Type',
'LNK_NEW_TIMEPERIOD'                               => 'Opprett tidsperiode',
'LNK_TIMEPERIOD_LIST'                              => 'Tidsperioder',
'LBL_SVFS_FORECASTDATE'                            => 'Planlegg startdato',
'LBL_SVFS_STATUS'                                  => 'Status',
'LBL_SVFS_USER'                                    => 'For',
'LBL_SVFS_CASCADE'                                 => 'Flomme til rapporter?',
'LBL_SVFS_HEADER'                                  => 'Prognoseskjema:',
'LB_FS_KEY'                                        => 'ID',
'LBL_FS_TIMEPERIOD_ID'                             => 'Tidsperiode-ID:',
'LBL_FS_USER_ID'                                   => 'Bruker-ID:',
'LBL_FS_TIMEPERIOD'                                => 'Tidsperiode',
'LBL_FS_START_DATE'                                => 'Startdato',
'LBL_FS_END_DATE'                                  => 'Sluttdato',
'LBL_FS_FORECAST_START_DATE'                       => 'Startdato for prognose',
'LBL_FS_STATUS'                                    => 'Status',
'LBL_FS_FORECAST_FOR'                              => 'Skjema for:',
'LBL_FS_CASCADE'                                   => 'Flomme?',
'LBL_FS_MODULE_NAME'                               => 'Prognoseskjema',
'LBL_FS_CREATED_BY'                                => 'Opprettet av',
'LBL_FS_DATE_ENTERED'                              => 'Inngangsdato',
'LBL_FS_DATE_MODIFIED'                             => 'Endringsdato',
'LBL_FS_DELETED'                                   => 'Slettet',
'LBL_FDR_USER_NAME'                                => 'Direketrapport',
'LBL_FDR_OPPORTUNITIES'                            => 'Muligheter i prognose:',
'LBL_FDR_WEIGH'                                    => 'Vektet mulighetsmengde:',
'LBL_FDR_COMMIT'                                   => 'Engasjeringsmengde',
'LBL_FDR_DATE_COMMIT'                              => 'Engasjeringsdato',
'LBL_DV_HEADER'                                    => 'Prognoser: Arbeidsflate',
'LBL_DV_MY_FORECASTS'                              => 'Mine prognoser',
'LBL_DV_MY_TEAM'                                   => 'Min gruppes prognoser',
'LBL_DV_TIMEPERIODS'                               => 'Tidsperioder:',
'LBL_DV_FORECAST_PERIOD'                           => 'Tidsperiode for prognose',
'LBL_DV_FORECAST_OPPORTUNITY'                      => 'Prognosemuligheter',
'LBL_SEARCH'                                       => 'Velg',
'LBL_SEARCH_LABEL'                                 => 'Velg',
'LBL_COMMIT_HEADER'                                => 'Engasjér prognose',
'LBL_DV_LAST_COMMIT_DATE'                          => 'Siste engasjeringsdato:',
'LBL_DV_LAST_COMMIT_AMOUNT'                        => 'Siste engasjeringsmengde:',
'LBL_DV_FORECAST_ROLLUP'                           => 'Prognose-rollup',
'LBL_DV_TIMEPERIOD'                                => 'Tidsperiode:',
'LBL_DV_TIMPERIOD_DATES'                           => 'Datoomfang',
'LBL_LV_TIMPERIOD'                                 => 'Tidsperiode',
'LBL_LV_TIMPERIOD_START_DATE'                      => 'Startdato',
'LBL_LV_TIMPERIOD_END_DATE'                        => 'Sluttdato',
'LBL_LV_TYPE'                                      => 'Prognosetype',
'LBL_LV_COMMIT_DATE'                               => 'Engasjeringsdato',
'LBL_LV_OPPORTUNITIES'                             => 'Muligheter',
'LBL_LV_WEIGH'                                     => 'Vektet mengde',
'LBL_LV_COMMIT'                                    => 'Engasjeringsmengde',
'LBL_COMMIT_NOTE'                                  => 'Velg den mengden som du vil engasjere for den valgte tidsperioden:',
'LBL_COMMIT_MESSAGE'                               => 'Vil du engasjere disse mengdene?',
'ERR_FORECAST_AMOUNT'                              => 'Engasjeringsmengden er påkrevd og må være et tall.',
'LBL_FC_START_DATE'                                => 'Startdato',
'LBL_FC_USER'                                      => 'Planlagt for',
'LBL_NO_ACTIVE_TIMEPERIOD'                         => 'Ingen aktive tidsperioder for Prognose.',
'LBL_FDR_ADJ_AMOUNT'                               => 'Justerte mengder',
'LBL_SAVE_WOKSHEET'                                => 'Lagre arbeidsflate',
'LBL_RESET_WOKSHEET'                               => 'Nullstill arbeidsflate',
'LBL_SHOW_CHART'                                   => 'Vis fremstilling',
'LBL_RESET_CHECK'                                  => 'Alle data for arbeidsflate for den valgte tidsperioden og innloggede bruker vil fjernes. Fortsett?',
'LB_FS_LIKELY_CASE'                                => 'Trolig utfall',
'LB_FS_WORST_CASE'                                 => 'Verste utfall',
'LB_FS_BEST_CASE'                                  => 'Beste utfall',
'LBL_FDR_WK_LIKELY_CASE'                           => 'Beregnet trolig utfall',
'LBL_FDR_WK_BEST_CASE'                             => 'Beregnet beste utfall',
'LBL_FDR_WK_WORST_CASE'                            => 'Beregnet verste utfall',
'LBL_BEST_CASE'                                    => 'Beste utfall:',
'LBL_LIKELY_CASE'                                  => 'Trolig utfall:',
'LBL_WORST_CASE'                                   => 'Verste utfall:',
'LBL_FDR_C_BEST_CASE'                              => 'Beste utfall',
'LBL_FDR_C_WORST_CASE'                             => 'Verste utfall:',
'LBL_FDR_C_LIKELY_CASE'                            => 'Trolig utfall:',
'LBL_QC_LAST_BEST_CASE'                            => 'Siste engasjeringsmengde (Beste utfall):',
'LBL_QC_LAST_LIKELY_CASE'                          => 'Siste engasjeringsmengde (Trolig utfall):',
'LBL_QC_LAST_WORST_CASE'                           => 'Siste engasjeringsmengde (Verste utfall):',
'LBL_QC_ROLL_BEST_VALUE'                           => 'Rollup-engasjeringsmengde (Beste utfall):',
'LBL_QC_ROLL_LIKELY_VALUE'                         => 'Rollup-engasjeringsmengde (Trolig utfall):',
'LBL_QC_ROLL_WORST_VALUE'                          => 'Rollup-engasjeringsmengde (Verste utfall):',
'LBL_QC_COMMIT_BEST_CASE'                          => 'Engasjeringsmengde (Beste utfall):',
'LBL_QC_COMMIT_LIKELY_CASE'                        => 'Engasjeringsmengde (Trolig utfall):',
'LBL_QC_COMMIT_WORST_CASE'                         => 'Engasjeringsmengde (Verste utfall):',
'LBL_FORECAST_FOR'                                 => 'Arbeidsflate for prognose:',
'LBL_FMT_ROLLUP_FORECAST'                          => '(Rollup)',
'LBL_FMT_DIRECT_FORECAST'                          => '(Direkte)',
'LBL_GRAPH_TITLE'                                  => 'Prongnosehistorikk',
'LBL_GRAPH_QUOTA_ALTTEXT'                          => 'Kvote for %s',
'LBL_GRAPH_COMMIT_ALTTEXT'                         => 'Engasjeringsmengde for %s',
'LBL_GRAPH_OPPS_ALTTEXT'                           => 'Mulighetsverdier lukket i %s',
'LBL_GRAPH_QUOTA_LEGEND'                           => 'Kvote',
'LBL_GRAPH_COMMIT_LEGEND'                          => 'Engasjert prognos',
'LBL_GRAPH_OPPS_LEGEND'                            => 'Lukkede muligheter',
'LBL_TP_QUOTA'                                     => 'Kvote:',
'LBL_CHART_FOOTER'                                 => 'Prognosehistorikk<br/>Kvote vs Prognosemengde vs Lukkede mulighetsverdier',
'LBL_TOTAL_VALUE'                                  => 'Totale:',
'LBL_COPY_AMOUNT'                                  => 'Total mengde',
'LBL_COPY_WEIGH_AMOUNT'                            => 'Total vektet mengde',
'LBL_WORKSHEET_AMOUNT'                             => 'Total beregnet mengde',
'LBL_COPY'                                         => 'Kopiér verdier',
'LBL_COMMIT_AMOUNT'                                => 'Summering av engasjerte verdier.',
'LBL_COPY_FROM'                                    => 'Kopiér verdi fra:',
'LBL_CHART_TITLE'                                  => 'Verdi vs. Engasjert vs. Faktisk',
);?>
