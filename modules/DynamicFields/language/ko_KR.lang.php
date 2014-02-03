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
  'COLUMN_DISABLE_NUMBER_FORMAT' => '쓸수없는 형식',
  'COLUMN_TITLE_AUDIT' => '회계감사',
  'COLUMN_TITLE_AUTOINC_NEXT' => '다음 가치 자동 증가',
  'COLUMN_TITLE_COMMENT_TEXT' => '의견 원문',
  'COLUMN_TITLE_DATA_TYPE' => '데이타 유형',
  'COLUMN_TITLE_DEFAULT_EMAIL' => '초기설정값',
  'COLUMN_TITLE_DEFAULT_VALUE' => '초기설정값',
  'COLUMN_TITLE_DISPLAYED_ITEM_COUNT' => '전시된 아이템 목록',
  'COLUMN_TITLE_DISPLAY_LABEL' => '라벨 전시',
  'COLUMN_TITLE_DUPLICATE_MERGE' => '중복 통합',
  'COLUMN_TITLE_ENABLE_RANGE_SEARCH' => '활성범위 검색',
  'COLUMN_TITLE_EXT1' => '추가 Meta 필드 1',
  'COLUMN_TITLE_EXT2' => '추가 Meta 필드 2',
  'COLUMN_TITLE_EXT3' => '추가 Meta 필드 3',
  'COLUMN_TITLE_FRAME_HEIGHT' => 'IFrame 높이',
  'COLUMN_TITLE_FTS' => '전체문장 검색가능',
  'COLUMN_TITLE_GLOBAL_SEARCH' => '세계전체 검색',
  'COLUMN_TITLE_HELP_TEXT' => '도움말 원문',
  'COLUMN_TITLE_HTML_CONTENT' => 'HTML',
  'COLUMN_TITLE_IMPORTABLE' => '가져올수 있음',
  'COLUMN_TITLE_LABEL' => '시스템 라벨',
  'COLUMN_TITLE_LABEL_COLS' => '칸',
  'COLUMN_TITLE_LABEL_ROWS' => '줄',
  'COLUMN_TITLE_LABEL_VALUE' => '라벨 가치',
  'COLUMN_TITLE_MASS_UPDATE' => '전체 업데이트',
  'COLUMN_TITLE_MAX_SIZE' => '최대 크기',
  'COLUMN_TITLE_MAX_VALUE' => '최대 가치',
  'COLUMN_TITLE_MIN_VALUE' => '최소 가치',
  'COLUMN_TITLE_NAME' => '필드명',
  'COLUMN_TITLE_PRECISION' => '정밀함',
  'COLUMN_TITLE_REPORTABLE' => '보고가능',
  'COLUMN_TITLE_REQUIRED_OPTION' => '필수항목 필드',
  'COLUMN_TITLE_URL' => 'URL 초기설정',
  'COLUMN_TITLE_VALIDATE_US_FORMAT' => '미국 형식',
  'ERR_FIELD_NAME_ALREADY_EXISTS' => '필드명이 이미 존재합니다.',
  'ERR_RESERVED_FIELD_NAME' => '예비 키워드',
  'ERR_SELECT_FIELD_TYPE' => '필드유형을 선택해 주십시오',
  'LBL_ADD_FIELD' => '필드 추가',
  'LBL_AUDITED' => '회계감사 완료',
  'LBL_BTN_ADD' => '추가하기',
  'LBL_BTN_EDIT' => '편집하기',
  'LBL_BTN_EDIT_VISIBILITY' => '시야 변경하기',
  'LBL_CALCULATED' => '가치 계산',
  'LBL_DATA_TYPE' => '데이타 유형',
  'LBL_DEFAULT_VALUE' => '초기설정값',
  'LBL_DEPENDENT' => '의존',
  'LBL_DEPENDENT_CHECKBOX' => '의존',
  'LBL_DEPENDENT_TRIGGER' => '영업기회',
  'LBL_DROP_DOWN_LIST' => '내려보기 목록',
  'LBL_DYNAMIC_VALUES_CHECKBOX' => '의존',
  'LBL_EDIT_VIS' => '시야 편집',
  'LBL_ENFORCED' => '강제적',
  'LBL_FORMULA' => '공식',
  'LBL_GENERATE_URL' => 'URL 생성하기',
  'LBL_HAS_PARENT' => '상위를 가집니다.',
  'LBL_HELP' => '도움말',
  'LBL_IMAGE_BORDER' => '경계',
  'LBL_IMAGE_HEIGHT' => '높이',
  'LBL_IMAGE_WIDTH' => '너비',
  'LBL_LABEL' => '라벨',
  'LBL_LINK_TARGET' => '링크 열기',
  'LBL_MODULE' => '모듈',
  'LBL_MODULE_SELECT' => '편집할 모듈',
  'LBL_MULTI_SELECT_LIST' => '다중 검색 목록',
  'LBL_PARENT_DROPDOWN' => '상위 내려보기',
  'LBL_RADIO_FIELDS' => '라디오 필드',
  'LBL_REPORTABLE' => '보고할수 있는',
  'LBL_SEARCH_FORM_TITLE' => '모듈 검색',
  'LBL_VISIBLE_IF' => '만약 다음과 같다면 보입니다.',
  'LNK_CALL_LIST' => '전화 목록',
  'LNK_EMAIL_LIST' => '이메일 목록',
  'LNK_MEETING_LIST' => '회의 목록',
  'LNK_NEW_CALL' => '통화일지',
  'LNK_NEW_EMAIL' => '이메일 보관하기',
  'LNK_NEW_MEETING' => '회의 일정잡기',
  'LNK_NEW_NOTE' => '노트 새로만들거나 첨부하기',
  'LNK_NEW_TASK' => '신규 업무 추가하기',
  'LNK_NOTE_LIST' => '노트 목록',
  'LNK_REPAIR_CUSTOM_FIELD' => '고객필드 수리',
  'LNK_SELECT_CUSTOM_FIELD' => '고객필드 선택',
  'LNK_TASK_LIST' => '업무 목록',
  'MSG_DELETE_CONFIRM' => '이 아이템을 삭제하시겠습니까?',
  'POPUP_EDIT_HEADER_TITLE' => '고객 필드 편집하기',
  'POPUP_INSERT_HEADER_TITLE' => '고객 필드 추가하기',
);

