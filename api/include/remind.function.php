<?php
require_once 'Medoo.php';
require_once 'config.php';
require_once 'mail.function.php';
function remiandAllbyGroup($teamname,$message){
	$emails = array();
	global $db;
	$res = $db->select('team',[
		'user_num'
	],[
		'team_name' => $teamname,
	]);
	foreach ($res as $r) {
		$user_num = $r['user_num'];		//获取user_name
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