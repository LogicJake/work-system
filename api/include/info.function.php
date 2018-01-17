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