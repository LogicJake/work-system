<?php
require_once './include/team.function.php';
if (!isset($_GET['action_type'])) {
    Result::error('missing _action_type');
}
else{
    $action_type = $_GET['action_type'];
    switch($action_type){
        case 'getbyteam':
            if (!isset($_GET['teamname'])) {
                Result::error('missing _teamname');
            }
            else{
                $res = getbyteamname($_GET['teamname']);
                Result::success($res);
            }
            break;
        case 'insertteam':
            if (!isset($_GET['teamname'],$_GET['user_num'])) {
                Result::error('missing_something');
            }
            $res = insertteam($_GET['teamname'],$_GET['user_num']);
            Result::success($res);
            break;
        case 'getallteam':
            $res=getallteam();
            Result::success($res);
            break;
    }
}