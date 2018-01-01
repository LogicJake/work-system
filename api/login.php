<?php

require_once './include/commonhead.inc.php';
require_once './include/ded.function.php';
require_once './include/login.function.php';

if(!isset($_GET['action'])){
    Result::error('wrong action');
}

$action = $_GET['action'];
if(preg_match('/[^a-zA-Z]+/',$action)){
    Result::error('wrong action');
}

switch($action){
    case 'logout':
        logout();
        break;
    case 'login':
        checkLogin();
        break;
}

function logout(){
    $_SESSION = array();
    Result::success('logout success');
}

function checkLogin(){
    if(!isset(Request::$body['user'],Request::$body['passwd'])){
        Result::error('error');
    }
    // if(Request::$body['user'] === 'admin' && Request::$body['passwd'] === 'admin'){
    //     $_SESSION['admin'] = time();
    //     Result::success('login success');
    // }else{
    //     Result::error('check failed');
    // }
    if(check_ded_login(Request::$body['user'],Request::$body['passwd']))
    {
         Result::success('login success');
    }
    else {
        Result::error('check failed');
    }
}