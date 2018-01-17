<?php

// require_once './include/commonhead.inc.php';

// if(!isset($_SESSION['admin'])){
//     Result::error('no permission~');
// }

if(!isset($_GET['action_type'])){
    Result::error('wrong action_type');
}

$action_type = $_GET['action_type'];

if(preg_match('/[^a-zA-Z]+/',$action_type)){
    Result::error('wrong qweaction_type');
}

switch($action_type){
    case 'getUserInfo':
        info();
        break;
    case 'getImageInfo':
        imageInfo();
        break;
    case 'getImageDetail':
        imageDetail();
        break;
    case 'update':
        update();
        break;
    case 'allData':
        allData();
        break;
    case 'deleteImage':
        deleteImage();
        break;
    case 'clearTag':
        clearTag();
        break;
    case 'changeUserInfo':
        changeUserInfo();
        break;
    case 'deleteUser':
        deleteUser();
        break;
    case 'saveEmail':
        saveEmail();
}

function saveEmail(){
    global $db;
    //$email = Request::$body['email'];
    $re =  $_SESSION['user_id'];
    $_SESSION['who'] = '0090';
//    echo $re;

   Result::success($re);
}

function info(){
    global $db;
    $page = Request::$body['page'];
    $re = $db->select("user_info",[
        '[>]user' => ['user_id' => 'id']
        ],[
            'user.user_name',
            'user_info.user_id',
            'user_info.sex',
            'user_info.phone_num',
            'user_info.user_sign',
            'user_info.qq_num',
            'user_info.score',
            'user_info.interest',
            
        ], [
            "LIMIT" => [($page-1)*20, ($page)*20],
            "user.status" => 1
        ]);
   
    Result::success($re);
}

function imageInfo(){
    global $db;
    $page = Request::$body['page'];
    $re = $db->select("image", "*", [
            "LIMIT" => [($page-1)*20, ($page)*20],
            'status' => 1
        ]);
    
    foreach($re as &$image){
        $image['tag'] = $db->select('image_tag',[
                "tag"
            ],[
            'image_id' => $image['id'],
            'tag[!]' => '' //非null判断
        ]);
    }
    Result::success($re);
}

function update(){
    global $db;
    if(!isset($_GET['prop'])){
        Result::error('no prop');
    }

    switch($_GET['prop']){
        case 'tips':
            $tips = Request::$body['tips'];
            $tips = preg_replace("/\n/",'\n',$tips);
            $db->update('guide_info', [
                'guide_content' => $tips,
                'add_time' => time()
            ],[
                'id' => 1
            ]);
            break;
        case 'panduan':
            $db->update('judge', [
                'judge_image_time' => Request::$body['panduan']
            ],[
                'id' => 1
            ]);
            break;
        case 'tagnum':
            $db->update('judge', [
                'judge_time' => Request::$body['tagnum']
            ],[
                'id' => 1
            ]);
            break;
    }
    Result::success('ok');
}

function allData(){
    global $db;
    $re = $db->select("image", [
        '[>]image_tag' => ['id' => 'image_id']
    ],[
        'image.id',
        'url(picture_name)',
        'image.time(finish_time)'
    ],[
        'image.status' => 1,
        'tag[!]' => '',
        "ORDER" => ["image.id"],
        "GROUP" => "image.id"
    ]);
    
    foreach($re as &$image){
        $tag = $db->select('image_tag',[
            "tag(labels)"
        ],[
            'image_id' => $image['id'],
            'tag[!]' => '' //非null判断
        ]);
        $image['labels'] = array();

        $image['picture_name'] = preg_replace('/upload\//','',$image['picture_name']);
        foreach($tag as $value){
            if(!in_array($value['labels'], $image['labels'])){ //tag去重
                array_push($image['labels'], $value['labels']);
            }
        }
     
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($re, JSON_UNESCAPED_UNICODE);
}

function deleteImage(){
    if(!isset(Request::$body['image'])){
        Result::error('no image');
    }
    global $db;
    $image = Request::$body['image'];

    $db->update('image',[
        'status' => 0
        ],[
        'id' => $image    
        ]);
    Result::success('ok');
}

function clearTag(){
    if(!isset(Request::$body['image'])){
        Result::error('no image');
    }
    global $db;

    $image = Request::$body['image'];
    $db->delete('image_tag',[
        'image_id' => $image
    ]);
    $db->delete('image_judge',[
        'image_id' => $image
    ]);
    Result::success('ok');
}

function changeUserInfo(){

    if(!isset(Request::$body['id'], Request::$body['property'], Request::$body['value'])){
        Result::error('wrong');
    }
    global $db;
    $property = Request::$body['property'];
    $id = Request::$body['id'];
    $value = htmlspecialchars(Request::$body['value']);
    switch($property){
        case 'phone_num':
            $db->update('user_info',[
                'phone_num' => $value
            ],[
                'user_id' => $id
            ]);
            break;
        case 'qq_num':
            $db->update('user_info',[
                'qq_num' => $value
            ],[
                'user_id' => $id
            ]);
            break;
        case 'score':
            $db->update('user_info',[
                'score' => $value
            ],[
                'user_id' => $id
            ]);
            break;
        case 'user_name':
            $db->update('user',[
                'user_name' => $value
            ],[
                'id' => $id
            ]);
            break;
        case 'user_sign':
            $db->update('user_info',[
                'user_sign' => $value
            ],[
                'user_id' => $id
            ]);
            break;

    }

    Result::success('ok');
}

function deleteUser(){
    if(!isset(Request::$body['id'])){
        Result::error('wrong');
    }
    global $db;

    $db->update('user',[
        'status' => 0
    ],[
        'id' => Request::$body['id']
    ]);
}
