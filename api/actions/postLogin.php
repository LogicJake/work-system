<?php
require_once './include/login.function.php';
require_once './include/ded.function.php';

$action_type = $_GET['action_type'];
if(preg_match('/[^a-zA-Z]+/',$action_type)){
    Result::error('wrong action_type');
}

switch($action_type){
    case 'logout':
        logout();
        break;
    case 'login':
        checkLogin();
        break;
}

function logout(){
     $_SESSION = array();
    // echo  $_SESSION['user_id'];
    Result::success( $_SESSION['user_id']);
}

function checkLogin(){
    // if(isset($_POST['ppp']))
    // {
    //     echo $_POST['ppp'];
    // }
    if(!isset($_GET['user'],$_GET['passwd'])){

        Result::error('error012300');
    }else {
        $result = check_login($_GET['user'],$_GET['passwd']);
        // var_dump($result);
        if($result['status']===1)
        {
            $GLOBALS['stu_id'] = $result['id'];
            $GLOBALS['stu_name'] = $result['user_name'];
            $GLOBALS['stu_num'] = $result['user_num'];
            $_SESSION['user_id'] = $result['id'];

            Result::success($result);
        }
        else {
            $_SESSION['user_id'] = 99;

            Result::error('check failed');
        }
    }
    // if($_GET['user'] === 'admin' && $_GET['passwd'] === 'admin'){
    //     $_SESSION['admin'] = time();
    //     Result::success('login success');
    // }else{
    //     Result::error('check failed');
    // }
    //$_SESSION['user_id'] = '123123';
   
}