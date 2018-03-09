<?php
require_once 'Medoo.php';
require_once 'config.php';
require_once 'mail.function.php';
function remiandAllbyGroup($teamname,$message){
	$emails = array();
	global $db;
	$id = $db->get('work','id',[
		'target_group' => $teamname,
	]);
	$res = $db->select('work_upload',[
		'upload_by_user'
	],[
		'work_id'=>$id 
	]);
	$stu_nums = array();
	foreach($res as $re){
		$upload_by_user = $re['upload_by_user'];
		$stu_num = $db->get('user','stu_num',[
			'id'=>$upload_by_user
		]);
		array_push($stu_nums,$stu_num);
	}
	foreach ($stu_nums as $r) {
		$user_num = $r;		//获取user_name
		$rr = $db->get('user',[
			'email'
		],[
			'stu_num' => $user_num,
		]);
		array_push($emails,$rr['email']);
	}
    $res = sendMail($emails,'作业发布',$message,false);
    return $res;
}
function remiandOne($user_id,$message){
	$emails = array();

		global $db;
        $res = $db->select('user',[
        	'email'
        ],[
        	'id' => $user_id,
        	'email[!]' => null
        ]);
        foreach ($res as $r) {
        	$email = $r['email'];
        	array_push($emails,$email);
        }
    $res = sendMail($emails,'作业发布',$message,false);
    return $res;
}