<?php
require_once 'remind.function.php';
function release_new_work()
{

}
function get_allow_ext($work_id)
{
    global $db;
    $re = $db->get('work',['allow_ext'],['id'=>$work_id]);
    var_dump($re);
    $re = explode(',',$re['allow_ext']);
    return $re;
}
function remindGruop($work_id)
{
    global $db;
    $re = $db->get('work','*',[
        'id' => $work_id
        ]);
    $end_time = $re['end_time'];
    $work_name =  $re['work_name'];
    $allow_ext = $re['allow_ext'];
    $attention_content = $re['attention_content'];
    $target_group = $re['target_group'];
     /**
         * 通知某个人
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
    if($re)
    {
        $return['status'] = 1;
    }else {
        $return['status'] = 0;
    }
    return $return;
}

function remindOneuser($work_id,$user_id)
{
    global $db;
    $re = $db->get('work','*',[
        'id' => $work_id
        ]);
    $end_time = $re['end_time'];
    $work_name =  $re['work_name'];
    $allow_ext = $re['allow_ext'];
    $attention_content = $re['attention_content'];
    $target_group = $re['target_group'];

        /**
         * 通知某个人
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
        remiandOne($user_id,$message);

    if($re)
    {
        $return['status'] = 1;
    }else {
        $return['status'] = 0;
    }
    return $return;
    // return $return;

}