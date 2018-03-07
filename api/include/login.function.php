<?php
/**
 * 在这里先check学号密码是否正确并返回个人信息
 * 保存user_num
 * 
 * 
 * 
 * 
 */
// function check_ded_login($user,$passwd)
// {
    
//     $is_true = dedverify($user, $passwd);
//     if(!$is_true)
//     {
//         return false;
//     }
//     else {
//         return true;
//     }

// }

 function check_login($user_name,$user_passwd)
    {
        global $db;
        $re =$db->has("user", [
                "stu_num" => $user_name,
                "passwd" => md5($user_passwd),
            ]
            );
        if(!$re)            //本地服务器没有数据就去教务处爬取检测登陆
        {
            $res= usrverify($user_name,$user_passwd);
            if($res['status']==0){      //登陆失败或者教务处故障
                // insert_person_info($user_name,$user_passwd);
                // $return = get_person_info($user_name,$user_passwd);
                $return['status'] = 2;
                // $return['status'] = 1;
            }
            else {
                insert_person_info($user_name,$user_passwd,$res['cookie']);
                $return = get_person_info($user_name,$user_passwd);
                $return['status'] = 1;
            }
        }
        else               //有数据直接返回
        {
            $return = get_person_info($user_name,$user_passwd);
            $return['status'] = 1;
        }
        return $return;

    }
// function SaveCookie($stuid, $password){
//     $url = "http://ded.nuaa.edu.cn/NetEAn/User/check.asp";
//     $password = urlencode($password);
//     $post = "user=" . $stuid . "&pwd=" . $password;
//     $cookie = tempnam('/tmp', 'MYAUTH_2');
//     echo $cookie;
//     $curl = curl_init();
//     curl_setopt_array($curl, [
//         CURLOPT_URL => $url,
//         CURLOPT_POST => 1,
//         CURLOPT_POSTFIELDS => $post,
//         CURLOPT_COOKIEJAR => $cookie,
//         CURLOPT_RETURNTRANSFER => 1,
//     ]);
//     curl_exec($curl);
//     curl_setopt_array($curl, [
//         CURLOPT_COOKIEFILE => $cookie,
//         CURLOPT_REFERER => 'http://ded.nuaa.edu.cn'
//     ]);
//     $response = curl_exec($curl);
//     curl_close($curl);
//     if (strstr($response, 'switch (0){') != false) {
//         $res['status'] = 1;
//         $res['cookie'] = $cookie;
//     }
//     else
//         $res['status'] = 0;
//     return $res;
// }

function GetInfo($cookie){        //爬取个人信息
    $cookie=$cookie;
    $url = "http://ded.nuaa.edu.cn/netean/com/jbqkcx.asp";          //个人信息页面
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_COOKIEFILE => $cookie,
        CURLOPT_RETURNTRANSFER => 1,        //不直接输出页面
        CURLOPT_REFERER => 'http://ded.nuaa.edu.cn'
    ]);
    $response = curl_exec($curl);
    $response=mb_convert_encoding($response, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');      //解决乱码
        //$preg = "#<td.*>(.*)&nbsp;</font>#"; 
    $preg = "#<td.*>(.*)&nbsp;.*>#"; 
        // echo $response;
    preg_match_all($preg,$response,$matches);
    $res['name']=$matches[1][0];
    $res['classNo']=$matches[1][8];
    $res['stuid']=$matches[1][12];
    $res['grade']=$matches[1][16];
    $res['major']=$matches[1][24];
    $res['status']=1;
    curl_close($curl);
    return $res;
 }

    /**
     * 需要的信息 
     * 学号 姓名 班号 当前年级 专业号
     * stu_num stu_name class_num current_grade profession_num
     * 
     */
    function insert_person_info($user_name,$user_passwd,$cookie)
    {
        //爬教务处信息 插入数据库
        $res = GetInfo($cookie);

        if($res['status'] == 1){
            global $db;
            if($db->has('user',[
                 "stu_num" => $user_name
            ]))
            {
                $db->update('user',[
                    "stu_num" => $user_name,
                    "passwd" => md5($user_passwd),
                    "stu_name" => $res['name'],
                    "class_num" => $res['classNo'],
                    "current_grade" => $res['grade'] ,
                    "profession_num" => $res['major']
                ],[
                    "stu_num" => $user_name
                    ]
                );
            }
            else {
                
                $db->insert('user',[
                    "stu_num" => $user_name,
                    "passwd" => md5($user_passwd),
                    "stu_name" => $res['name'],
                    "class_num" => $res['classNo'],
                    "current_grade" => $res['grade'] ,
                    "profession_num" => $res['major']
                ]
                );
            }
        }   
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