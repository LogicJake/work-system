<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET,POST');
header('Access-Control-Allow-Headers: Content-Type');
session_start();
/*
ini_set("display_errors", "On");

error_reporting(E_ALL | E_STRICT);
*/

require_once './include/Medoo.php';
require_once './include/config.php';
require_once './include/result.class.php';
// require_once './include/info.function.php';
require_once './include/token.class.php';
require_once './include/request.class.php';

Request::initialize();


if(!isset($_SESSION)){
    session_start();
}
// white list
// $actionList = ['postLogin','upload','getImage','get_show_pic','postSignup','collect_info','chatting','chatting2','getMessages','getGroups','addGroup','addGroupusers','getUsers','addMessage','getLogou'];
$actionList = ['admin','postLogin','upload','getImage','get_show_pic','postSignup','collect_info','getPersonalInfo','admin'];
$noTokenList = ['admin','postLogin','upload','getImage','get_show_pic','postSignup','collect_info','admin'];

define('UPLOAD_DIR', '/www/upload/work-system/');

if (!isset($_GET['_action'])) {
    Result::error('missing _action');
}
if (!in_array($_GET['_action'], $actionList)) {
    Result::error('_action error');
}

if (in_array($_GET['_action'], $noTokenList)){//如果是不需要token的 action 直接进入
    require_once "actions/{$_GET['_action']}.php";

} else {//token验证
    // if (!isset($_GET['token'])){//无token错误
    //     Result::error('no token');
    // }
    // if(Token::userid($_GET['token']) < 1){//token不存在终止
    //     Result::error('token wrong');
    // }
    // //其余为正确情况 全局并进入action
    // $GLOBALS['uid'] = Token::userid($_GET['token']);
    // require_once "actions/{$_GET['_action']}.php";
    if (!isset($_GET['token'])){//无token错误
        Result::error('no token');
    }
    if(Token::userid($_GET['token']) < 1){//token不存在终止
        Result::error('token wrong');
    }
    //其余为正确情况 全局并进入action
    $GLOBALS['uid'] = Token::userid($_GET['token']);
    require_once "actions/{$_GET['_action']}.php";
}
