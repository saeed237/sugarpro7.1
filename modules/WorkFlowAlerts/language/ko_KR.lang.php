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
  'LBL_ADDRESS_BCC' => '숨은 참조인',
  'LBL_ADDRESS_CC' => '참조인',
  'LBL_ADDRESS_TO' => '받는사람',
  'LBL_ADDRESS_TYPE' => '사용중인 주소',
  'LBL_ADDRESS_TYPE_TARGET' => '형식',
  'LBL_ALERT_CURRENT_USER' => '목표고객과 관련된 사용자',
  'LBL_ALERT_CURRENT_USER_TITLE' => '목표 모듈과 관련된 사용자',
  'LBL_ALERT_LOGIN_USER_TITLE' => '실행시간에 접속한 사용자',
  'LBL_ALERT_REL1' => '관련 모듈',
  'LBL_ALERT_REL2' => '관련된 모듈',
  'LBL_ALERT_REL_USER' => '관련 사용자',
  'LBL_ALERT_REL_USER_CUSTOM' => '관련된 수신자',
  'LBL_ALERT_REL_USER_CUSTOM_TITLE' => '관련 모듈과 연관된 사용자',
  'LBL_ALERT_REL_USER_TITLE' => '관련 모듈과 연관된 사용자',
  'LBL_ALERT_SPECIFIC_ROLE' => '지정된 모든 사용자',
  'LBL_ALERT_SPECIFIC_ROLE_TITLE' => '지정된 역할의 모든 사용자',
  'LBL_ALERT_SPECIFIC_TEAM' => '지정된 모든 사용자',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET' => '목표 모듈과 연관된 팀에 속한 모든 사용자들',
  'LBL_ALERT_SPECIFIC_TEAM_TARGET_TITLE' => '목표 모듈과 연관된 팀의 회원목록',
  'LBL_ALERT_SPECIFIC_TEAM_TITLE' => '지정된 팀의 모든 사용자',
  'LBL_ALERT_SPECIFIC_USER' => '지정된',
  'LBL_ALERT_SPECIFIC_USER_TITLE' => '지정된 사용자',
  'LBL_ALERT_TRIG_USER_CUSTOM' => '목표모듈과 연관된 수신자',
  'LBL_ALERT_TRIG_USER_CUSTOM_TITLE' => '목표모듈과 연관된 수신자',
  'LBL_AND' => '그리고 이름 필드',
  'LBL_ARRAY_TYPE' => '액션 형식',
  'LBL_BLANK' => ' ',
  'LBL_CUSTOM_USER' => '고객 사용자',
  'LBL_EDITLAYOUT' => '지면 배치 편집하기',
  'LBL_FIELD' => '필드',
  'LBL_FIELD_VALUE' => '선택한 사용자',
  'LBL_FILTER_BY' => '(추가 필터) 모듈에 관련 필터',
  'LBL_FILTER_CUSTOM' => '(추가 필터) 지정 모듈에 관련 필터',
  'LBL_LIST_ADDRESS_TYPE' => '주소 형식',
  'LBL_LIST_ARRAY_TYPE' => '액션 형식',
  'LBL_LIST_FIELD_VALUE' => '사용자',
  'LBL_LIST_FORM_TITLE' => '수신자 목록',
  'LBL_LIST_RELATE_TYPE' => '연관 형식',
  'LBL_LIST_REL_MODULE1' => '연관 모듈',
  'LBL_LIST_REL_MODULE2' => '연관 모듈에 연관',
  'LBL_LIST_STATEMENT' => '알림 수신자',
  'LBL_LIST_STATEMENT_CONTENT' => '다음 수신자에 알림 보내기',
  'LBL_LIST_STATEMENT_INVITE' => '회의/전화 초대자',
  'LBL_LIST_USER_TYPE' => '사용자 종류',
  'LBL_LIST_WHERE_FILTER' => '상태',
  'LBL_MODULE_NAME' => '알림 수신자 목록',
  'LBL_MODULE_NAME_INVITE' => '초대자 목록',
  'LBL_MODULE_NAME_SINGULAR' => '알림 수신자 목록',
  'LBL_MODULE_NAME_SINGULAR_INVITE' => '초대자 목록',
  'LBL_MODULE_TITLE' => '수신자:홈',
  'LBL_NEW_FORM_TITLE' => '작업흐름 수신자 새로 만들기',
  'LBL_NEXT_BUTTON' => '다음',
  'LBL_PLEASE_SELECT' => '선택해 주십시오',
  'LBL_PREVIOUS_BUTTON' => '이전',
  'LBL_RECORD' => '모듈',
  'LBL_RELATE_TYPE' => '관계 형식',
  'LBL_REL_CUSTOM' => '고객 이메일 필드를 선택하십시오.',
  'LBL_REL_CUSTOM2' => '필드',
  'LBL_REL_CUSTOM3' => '필드',
  'LBL_REL_CUSTOM_STRING' => '고객 이메일과 이름필드를 선택하십시오.',
  'LBL_REL_MODULE1' => '연관 모듈',
  'LBL_REL_MODULE2' => '연관 모듈에 연관',
  'LBL_ROLE' => '역할',
  'LBL_SEARCH_FORM_TITLE' => '작업흐름 수신자 검색',
  'LBL_SELECT_EMAIL' => '고객 이메일 필드를 반드시 선택해야 합니다.',
  'LBL_SELECT_FILTER' => '관련 모듈 필터가 있는 필드를 선택해야 합니다.',
  'LBL_SELECT_NAME' => '고객명 필드를 반드시 선택해야 합니다.',
  'LBL_SELECT_NAME_EMAIL' => '이름과 이메일 필드를 반드시 선택해야 합니다.',
  'LBL_SELECT_VALUE' => '반드시 가치를 선택해야 합니다.',
  'LBL_SEND_EMAIL' => '이메일 전송',
  'LBL_SPECIFIC_FIELD' => '필드',
  'LBL_TEAM' => '팀:',
  'LBL_USER' => '사용자',
  'LBL_USER1' => '기록 생성자',
  'LBL_USER2' => '기록 최종 수정자',
  'LBL_USER3' => '현재',
  'LBL_USER3b' => '시스템',
  'LBL_USER4' => '기록 현재 배정자',
  'LBL_USER5' => '기록 예전 배정자',
  'LBL_USER_MANAGER' => '사용자 상급자',
  'LBL_USER_TYPE' => '사용자 종류',
  'LBL_WHERE_FILTER' => '상태',
  'LNK_NEW_WORKFLOW' => '작업흐름 정의 새로 만들기',
  'LNK_WORKFLOW' => '작업흐름 정의 목록',
  'NTC_REMOVE_ALERT_USER' => '이 알림 수신자를 제거하시겠습니까?',
);

