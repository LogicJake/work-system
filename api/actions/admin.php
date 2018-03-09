<?php
require_once './include/admin.function.php';
require_once './include/work.function.php';
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
            // $target_group = $_GET['target_group'];
            // $result = get_upload_by_group($target_group,$work_id);
            // $page_num = $_GET['page_num']?$_GET['page_num']:1;
            $page_num = 1;
            $result = get_upload_by_work_id($work_id,$page_num);
            break;
        case 'get_work_ids':
            $result = get_work_ids($GLOBALS['uid']);
            break;
        case 'remind_one':
            $work_id = $_GET['work_id'];
            $user_id = $_GET['user_id'];
            $result = remindOneuser($work_id,$user_id);
            break;
        case 'remind_team':
            $work_id = $_GET['work_id'];
            $result = remindGruop($work_id);
            break;
        case 'check_is_admin':
            $user_id = $GLOBALS['uid'];
            $result = check_is_admin($user_id);
            break;
    }

    Result::success($result);