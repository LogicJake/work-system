<?php

function get_all_upload($work_id)
{
    global $db;
    $re = $db->select('work_upload','*',[
        'work_id' => $work_id
    ]);
    return $re;
}
function get_upload_by_work_id($work_id,$page_num)
{
    global $db;
    $result = array();
     $target_group =  $db->get('work',['target_group'],[
                'id' => $work_id
            ])['target_group'];
    $result = get_upload_by_group($target_group,$work_id);
    return $result;
}
function get_upload_by_group($target_group,$work_id)
{
    global $db;

    $re = $db->select('team',[
        'user_num'
    ],[
        'team_name' => $target_group
    ]);
    foreach ($re as $key => $value) {
        $has_upload =  $db->has('work_upload',[
            'work_id' => $work_id,
            'upload_by_user' => $value['user_num']
        ]);
        if($has_upload)
        {
             $upload =  $db->get('work_upload',['add_time','file_name'],[
                'work_id' => $work_id,
                'upload_by_user' => $value['user_num']
            ]);
            $re[$key]['has_upload'] = 1;
            $re[$key]['add_time'] = $upload['add_time'];
            $re[$key]['file_name'] = $upload['file_name'];
        }
        else 
        {
            $re[$key]['has_upload'] = 0;
        }
    }
    return $re;
}
function get_work_ids($user_id)
{
    global $db;
    // var_dump(check_is_admin($user_id));
    if(check_is_admin($user_id))
    {
        $re = $db->select('work',['id','work_name'],[
            'release_by_user' => $user_id,
            "ORDER" => ["add_time" => "DESC"],
        ]);
        // var_dump('oopoppo');
        // var_dump($re);
        return $re;
    }
    else {
        return [];
    }
}
function check_is_admin($user_id)
{
    global $db;
    if($db->has('admin',[
        'user_id' => $user_id
    ]
    )){
        return true;
    }
    else {
        return false;
    }    
}
function check_is_super_admin($user_id)
{
    global $db;
    if($db->has('admin',[
        'user_id' => $user_id,
        'super' => 1
    ]
    )){
        return true;
    }
    else {
        return false;
    }
}
/**
 * not super admin
 */
function get_admin_group($user_id)
{
    global $db;
    $re = $db->get('admin',
    [
        'groups'
    ],[
        'user_id' => $user_id
        ]
    );
    $groups = $re['groups'];
    $groups = explode('-',$groups);
    return $groups;
}