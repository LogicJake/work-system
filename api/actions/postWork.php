<?php
// require_once './include/info.function.php';
$action_type = $_GET['action_type'];
if(preg_match('/[^a-zA-Z]+/',$action_type)){
    Result::error('wrong action_type');
}


switch($action_type){
    case 'releaseNewwork':
    $work_name = Request::$body['work_name'];
    $target_group = Request::$body['target_group'];
    $start_time = Request::$body['start_time'];
    $end_time = Request::$body['end_time'];
    $inform_all = Request::$body['inform_all'];
    $allow_ext = Request::$body['allow_ext'];
    $attention_content = Request::$body['attention_content'];
        releaseNewwork($work_name,$target_group,$start_time,$end_time,$inform_all,$allow_ext,$attention_content);
        break;
    case 'getWorks':
        getWorks();
        break;
}
function getWorks()
{
    global $db;
    $re = $db->select('work',[
        'work_name',
        'target_group',
        'add_time',
        'start_time',
        'end_time',
        'allow_ext',
        'attention_content'
    ],[
        "ORDER" => ["add_time" => "DESC"]
    ]
    );
    if($re)
    {
        $return['status'] = 1;
        $return['works'] = $re;
        Result::success($return);
    }else {
        $return['status'] = 0;
        Result::error($return);
    }

}


function releaseNewwork($work_name,$target_group,$start_time,$end_time,$inform_all,$allow_ext,$attention_content)
{
    global $db;
    $re = $db->insert('work',[
        'work_name' => $work_name,
        'target_group' => $target_group,
        'add_time' => time(),
        'start_time' => $start_time,
        'end_time' => $end_time,
        // 'inform_all' => $inform_all,
        'allow_ext' => $allow_ext,
        'attention_content' => $attention_content
    ]);
    if($inform_all)
    {
        /**
         * 通知所在分组的人
         * 
         */
    }
    if($re)
    {
        $return['status'] = 1;
    }else {
        $return['status'] = 0;
    }
    Result::success($return);
    // return $return;

}