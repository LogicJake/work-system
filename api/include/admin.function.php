<?php

function get_all_upload($work_id)
{
    global $db;
    $re = $db->select('work_upload','*',[
        'work_id' => $work_id
    ]);
    return $re;
}
function get_upload_by_group($target_group,$work_id)
{
    global $db;

    $re = $db->select('user',['id'],[
        'class_num' => $target_group
    ]);
    foreach ($re as $key => $value) {
        $has_upload =  $db->has('work_upload',[
            'work_id' => $work_id,
            'upload_by_user' => $value['id']
        ]);
        if($has_upload)
        {
             $upload =  $db->get('work_upload',['add_time'],[
                'work_id' => $work_id,
                'upload_by_user' => $value['id']
            ]);
            $re[$key]['has_upload'] = 1;
            $re[$key]['add_time'] = $upload['add_time'];
        }
        else 
        {
            $re[$key]['has_upload'] = 0;
        }
    }
    return $re;
}