<?php
if(!isset($_GET['action_type'])){
    Result::error('wrong action_type');
}

$action_type = $_GET['action_type'];

if(preg_match('/[^a-zA-Z]+/',$action_type)){
    Result::error('wrong action_type');
}

switch($action_type){
    case 'saveEmail':
        saveEmail();
}

function saveEmail(){
//     global $db;
//     //$email = Request::$body['email'];
//     $re =  $_SESSION['user_id'];
//     $_SESSION['who'] = '0090';
// //    echo $re;
    echo $GLOBALS['stu_id'];

//    Result::success($re);
}
