<?php
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