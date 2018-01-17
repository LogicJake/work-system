<?php
require_once './include/info.function.php';
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
    // $re =  $_SESSION['user_id'];
//     $_SESSION['who'] = '0090';
//    echo $re;
    // $email = $_POST['email'];
    // echo $email;
    if(isset(Request::$body['email']))
    {
        $email = Request::$body['email'];
        $re = save_email($GLOBALS['uid'],$email);
        if($re){
            $return['status'] = 1;
            Result::success($return);
        }
        else {
            $return['status'] = 0;
            Result::error($return);
        }
    }
    else {
         $return['status'] = 0;
         Result::error($return);
    }
    //  echo $GLOBALS['uid'];

//    Result::success($re);
}
