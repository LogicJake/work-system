<?php
    function save_email($user_id,$email)
    {
        global $db;
        $re = $db->update('user',[
            'id' => $user_id,
            'email' => $email
        ]);
        return $re;
    }
    function get_person_info($user_id)
    {
        global $db;
        $re = $db->get('user',[
            'id',
            'stu_num',
            'stu_name'
        ],[
            'id' => $user_id
        ]);
        return $re;
    }