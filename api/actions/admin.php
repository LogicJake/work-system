<?php
require_once './include/admin.function.php';
    if(isset($_GET['action_type']))
    {
        $action_type = $_GET['action_type'];
    }
    else {
        Result::error('wrong action_type');
    }
    // var_dump('token');
    // var_dump($_GET['token']);
    switch($action_type)
    {
        case 'get_upload_by_group':
            $work_id = $_GET['work_id'];
            // var_dump($work_id);
            $target_group = $_GET['target_group'];
            // $result = get_upload_by_group($target_group,$work_id);
            $result = get_upload_by_work_id($work_id);
            Result::success($result);
            break;
        case 'get_work_ids':
            $result = get_work_ids($GLOBALS['uid']);
            Result::success($result);
            break;
    }