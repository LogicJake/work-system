<?php
/**
 * 在这里先check学号密码是否正确并返回个人信息
 * 保存user_num
 * 
 * 
 * 
 * 
 */
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

 function check_login($user_name,$user_passwd)
    {
        global $db;
        $re =$db->has("user", [
                "stu_num" => $user_name,
                "passwd" => md5($user_passwd),
            ]
            );
        if(!$re)
        {
            if(!check_ded_login($user_name,$user_passwd)){
                // insert_person_info($user_name,$user_passwd);
                // $return = get_person_info($user_name,$user_passwd);
                $return['status'] = 2;
                // $return['status'] = 1;
            }
            else {
                insert_person_info($user_name,$user_passwd);
                $return = get_person_info($user_name,$user_passwd);
                $return['status'] = 1;
            }
        }
        else
        {
            $return = get_person_info($user_name,$user_passwd);
            $return['status'] = 1;
        }
        return $return;

    }
    /**
     * 需要的信息 
     * 学号 姓名 班号 当前年级 专业号
     * stu_num stu_name class_num current_grade profession_num
     * 
     */
    function insert_person_info($user_name,$user_passwd)
    {
        //爬教务处信息 插入数据库
        global $db;
        $db->insert('user',[
            "stu_num" => $user_name,
            "passwd" => md5($user_passwd),
            "stu_name" => '默认姓名',
            "class_num" => '161540203',
            "current_grade" => '2015' ,
            "profession_num" => 'n2008'
        ]
        );
    }
    function get_person_info($user_name,$user_passwd)
    {
        global $db;

        $re = $db->get("user",[
            "id",
            "stu_name",
            "stu_num",
            "email"
        ],[
            "stu_num" => $user_name,
            "passwd" => md5($user_passwd),
        ]
        );
        if($re)
        {
            $token = Token::addToken($re['id']);
            $return['id'] = $re['id'];
            $return['user_name'] = $re['stu_name'];
            $return['user_num'] = $re['stu_num'];
            $return['email'] = $re['email'];
            $return['token'] = $token;
        }
        else
        {
            $return['status'] = 0;
        }
        return $return;
    }