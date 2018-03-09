<?php
function getbyteamname($teamname){
    global $db;
    $res = $db->select("team",
    [
        "[<]user" => ["user_num"=>"stu_num"]
    ],[
        "user.stu_num",
        "user.stu_name",
        "user.id"
    ],[
        "team.team_name" => $teamname
    ]);
    return $res;
}
function insertteam($teamname,$user_nums){
    global $db;
    foreach ($user_nums as $user_num) {
        $res = $db->insert("team",[
            "team_name"=>$teamname,
            "user_num"=>$user_num,
            "add_time"=>time()
        ]);
    }
    if($res->rowCount()>0)
        return 1;
    else
        return 0;
}
function getallteam(){
    global $db;
    $res = $db->select("team",[
        "team_name"
    ]);
    $data = array();
    foreach($res as $re){
        array_push($data,$re["team_name"]);
    }

    return array_unique($data);
}