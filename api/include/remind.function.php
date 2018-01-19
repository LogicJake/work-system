<?php
require_once 'Medoo.php';
require_once 'config.php';
require_once 'mail.function.php';
function remiandAllbyGroup($groupId,$message){
	$groups = explode("-",$groupId);		//分割获取多个group
	$emails = array();
	foreach ($groups as $group){ 
		global $db;
        $res = $db->select('user',[
        	'email'
        ],[
        	'class_num' => $group,
        	'email[!]' => null
        ]);
        foreach ($res as $r) {
        	$email = $r['email'];
        	array_push($emails,$email);
        }
    } 
    $res = sendMail($emails,'作业发布',$message,false);
    return $res;
}