<?
require_once './include/commonhead.inc.php';

if(!isset($_SESSION['admin'])){
    Result::error('no permission~');
}
/**
 * 返回-1为过大
 *   2为出错
 *   3为拓展名违规
 */

$file_path="/www/upload/";
//664权限为文件属主和属组用户可读和写，其他用户只读。
if(is_dir($file_path)!=TRUE){
    mkdir($file_path,0664);
}
//定义允许上传的文件扩展名
$ext_arr = array( "jpg", "jpeg", "png", "bmp");

if (empty($_FILES) === false) {
    //判断检查
    if($_FILES["file"]["size"] > 1024*1024){//2M
        $result['status'] = -1;
        Result::success($result);
    }
    if($_FILES["file"]["error"] > 0){
        // $result['msg'] = "文件上传发生错误：".$_FILES["file"]["error"];
        $result['status'] = 2;
        Result::success($result);
    }

    $temp_arr = explode(".", $_FILES["file"]["name"]);
    $file_ext = array_pop($temp_arr);
    $file_ext = trim($file_ext);
    $file_ext = strtolower($file_ext);

    if (in_array($file_ext, $ext_arr) === false) {
        $result['status'] = 3;
        Result::success($result);
    }

    $imageSalt = 'imageIsThere';
    $imageName = md5($imageSalt . time() . mt_rand(0, 1e10));
    $new_image_url = $imageName . ".jpg";
    move_uploaded_file($_FILES["file"]["tmp_name"],$file_path . $new_image_url);

    $db->insert('image',[
            'url' => $new_image_url,
            'time' => time()
    ]);

    $result['image_url'] = $new_image_url;
    $result['status'] = 200;
    Result::success($result);
} else {
    $result['status'] = 404;
    Result::success($result);
}
