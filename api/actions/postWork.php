<?php
require_once './include/remind.function.php';
require_once './include/info.function.php';
require_once './include/team.function.php';

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
        $allow_ext = explode("-", $allow_ext);
        $target_user_nums = Request::$body['target_user_nums'];
        $download_format = Request::$body['download_format'];


        #insertteam($target_group,$target_user_nums);

        foreach ($allow_ext as $allow_key => $allow_value) {
            $allow_ext[$allow_key] = '.'.$allow_ext[$allow_key];
        }
        $allow_ext = implode(',',$allow_ext);
        $attention_content = Request::$body['attention_content'];
        releaseNewwork($work_name,$target_group,$start_time,$end_time,$inform_all,$allow_ext,$attention_content,$target_user_nums,$download_format);
        break;
    case 'getWorks':
        getWorks();
        break;
    case 'getAllStu':
        $team_name = Request::$body['team_name'];
        getAllStu($team_name);
        break;
}
function getAllStu($team_name)
{
    global $db;
     $re = $db->select('team',[
        'user_num'
    ],[
        'team_name' => $team_name
    ],[
        "ORDER" => ["add_time" => "DESC"]
    ]
    );
    if($re)
    {
        Result::success($re);
    }
    else {
        Result::success($re);
    }

}
function getAllTeamname()
{
    global $db;
     $re = $db->select('team',[
        'team_name'
    ],[
        "ORDER" => ["add_time" => "DESC"]
    ]
    );
    if($re)
    {
        Result::success($re);
    }
    else {
        Result::success($re);
    }

}
function getWorks()
{
    global $db;
    $re = $db->select('work',[
        'id',
        'work_name',
        'target_group',
        'add_time',
        'start_time',
        'end_time',
        'allow_ext',
        'attention_content',
    ],[
        "ORDER" => ["add_time" => "DESC"]
    ]
    );
    $user = get_person_info($GLOBALS['uid']);
    foreach( $re as $key=>$value ) 
    {
        $has_upload = $db->has('work_upload',[
            'upload_by_user' => $user['id'],
            'work_id' => $value['id'],
            'has_upload' => 1
        ]);

        $should_upload = $db->has('work_upload',[
            'upload_by_user' => $user['id'],
            'work_id' => $value['id']
        ]);

        // $re[$key]['allow_ext'] = $allow_ext;
        $re[$key]['expired']  = $value['end_time']<time()?true:false;
        $re[$key]['should_upload']  = $should_upload;
        $re[$key]['has_upload'] = $has_upload;
    }
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


function releaseNewwork($work_name,$target_group,$start_time,$end_time,$inform_all,$allow_ext,$attention_content,$target_user_nums,$download_format)
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
        'attention_content' => $attention_content,
        'release_by_user' => $GLOBALS['uid'],
        'download_format' => $download_format
    ]);
    $re = $db->get('work','id',[
        'work_name' => $work_name
    ]);
    $data = array();
    foreach($target_user_nums as $target_user_num){
        $id = $db->get('user','id',[
            'stu_num' => $target_user_num
        ]);
        $tmp['upload_by_user'] = $id;
        $tmp['work_id'] = $re;
        $tmp['has_upload'] = 0;
        array_push($data,$tmp);
    }
    $re = $db->insert('work_upload',$data);

    if($inform_all)
    {
        /**
         * 通知所在分组的人
         * 
         */
        date_default_timezone_set('Etc/GMT-8');
        $end_date = date("Y-m-d H:i:s",$end_time);
        $message = "
<b>您好！</b><br>
<b>&nbsp;&nbsp;&nbsp;&nbsp;您有新的作业需要提交，作业内容如下！</b><br>
<table border=\"1\">
  <tr>
    <th width=\"150dp\">作业名称</th>
    <td width=\"100dp\">{$work_name}</td>
  </tr>
  <tr>
    <th>允许上传作业类型</th>
    <td>{$allow_ext}</td>
  </tr>
  <tr>
    <th>提交须知</th>
    <td>{$attention_content}</td>
  </tr>
  <tr>
    <th>作业提交截至日期</th>
    <td>{$end_date}</td>
  </tr>
</table>";
        remiandAllbyGroup($target_group,$message);
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