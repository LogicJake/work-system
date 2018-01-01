<?php
function check_ded_login($user,$passwd)
{
    
    $is_true = dedverify($user, $passwd);
    if(!$is_true)
    {
        return false;
    }
    else {
        return true;
    }
        
}