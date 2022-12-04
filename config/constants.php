<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/01
 * Time: 14:17
 */
// roles
if (!defined('USER_ROLE_ADMIN')) define('USER_ROLE_ADMIN', 'admin');
if (!defined('USER_ROLE_PE')) define('USER_ROLE_PE', 'pe');
if (!defined('USER_ROLE_MANAGE_LINE')) define('USER_ROLE_MANAGE_LINE', 'line');

// id roles
if (!defined('ROLE_ADMIN_ID')) define('ROLE_ADMIN_ID', 1);
if (!defined('ROLE_PE_ID')) define('ROLE_PE_ID', 2);
if (!defined('ROLE_MANAGE_LINE_ID')) define('ROLE_MANAGE_LINE_ID', 3);

// department
if (!defined('DEPARTMENT_ID_FOR_ADMIN_AND_PE')) define('DEPARTMENT_ID_FOR_ADMIN_AND_PE', 0);

// permission
if (!defined('PERMISSION_MANAGE_USER')) define('PERMISSION_MANAGE_USER', 'manage_user');
if (!defined('PERMISSION_MANAGE_DEPARTMENT')) define('PERMISSION_MANAGE_DEPARTMENT', 'manage_deparment');
if (!defined('PERMISSION_SYNC_FILE')) define('PERMISSION_SYNC_FILE', 'sync_file');
if (!defined('PERMISSION_MANAGE_LINE')) define('PERMISSION_MANAGE_LINE', 'manage_line');
if (!defined('PERMISSION_PLAY_FILE')) define('PERMISSION_PLAY_FILE', 'play_file');
if (!defined('PERMISSION_MANAGE_MICROPC')) define('PERMISSION_MANAGE_MICROPC', 'manage_micro_pc');
if (!defined('PERMISSION_MANAGE_PC')) define('PERMISSION_MANAGE_PC', 'manage_pc');
if (!defined('PERMISSION_SETTING')) define('PERMISSION_SETTING', 'setting');

//  id permission
if (!defined('PERMISSION_MANAGE_USER_ID')) define('PERMISSION_MANAGE_USER_ID', 1);
if (!defined('PERMISSION_SYNC_FILE_ID')) define('PERMISSION_SYNC_FILE_ID', 2);
if (!defined('PERMISSION_MANAGE_LINE_ID')) define('PERMISSION_MANAGE_LINE_ID', 3);
if (!defined('PERMISSION_DEPARTMENT_ID')) define('PERMISSION_DEPARTMENT_ID', 4);
if (!defined('PERMISSION_PLAY_FILE_ID')) define('PERMISSION_PLAY_FILE_ID', 5);
if (!defined('PERMISSION_MANAGE_MICROPC_ID')) define('PERMISSION_MANAGE_MICROPC_ID', 6);
if (!defined('PERMISSION_MANAGE_PC_ID')) define('PERMISSION_MANAGE_PC_ID', 7);
if (!defined('PERMISSION_SETTING_ID')) define('PERMISSION_SETTING_ID', 8);

//Error code
if (!defined('ERROR_CODE_UNAUTHORIZED')) define('ERROR_CODE_UNAUTHORIZED', 1001);
if (!defined('ERROR_CODE_BAD_REQUEST')) define('ERROR_CODE_BAD_REQUEST', 1002);
if (!defined('ERROR_CODE_SERVER_ERROR')) define('ERROR_CODE_SERVER_ERROR', 1099);

// HTTP Request error code
if (!defined('HTTP_ERROR_CODE_UNAUTHORIZED')) define('HTTP_ERROR_CODE_UNAUTHORIZED', 403);
if (!defined('HTTP_ERROR_BAD_REQUEST')) define('HTTP_ERROR_BAD_REQUEST', 400);
if (!defined('HTTP_ERROR_SERVER_ERROR')) define('HTTP_ERROR_SERVER_ERROR', 500);

//User
if (!defined('DEFAULT_LANG_CODE')) define('DEFAULT_LANG_CODE', 'vi');

//SETTING
if (!defined('NEED_TO_CONFIG')) define('NEED_TO_CONFIG', '/need/tobe/configured');
if (!defined('SOURCE_PATH')) define('SOURCE_PATH', 'source_path');
if (!defined('DESTINATION_PATH')) define('DESTINATION_PATH', 'destination_path');

//SYNC FILE DELETE ITEM IN TREE
if (!defined('ERROR_INVALID_PATH')) define('ERROR_INVALID_PATH', 0);
if (!defined('ERROR_FILE_USING')) define('ERROR_FILE_USING', 1);
if (!defined('NORMALLY_DONE')) define('NORMALLY_DONE', 2);






