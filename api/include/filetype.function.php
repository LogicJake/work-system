    <?php
    $tmpname = $_FILES ['userfile'] ['tmp_name'];  
    if(is_uploaded_file($tmpname)) {  
        $mimetype = detectMIME($tmpname);  
        $tuozhanming = getFileExt($filename, $mimetype);  
        if($tuozhanming == "type_error"){  
            echo '仅支持word和pdf文件，且文件大小小于512kb:<a href='.$reurl.'>请重试</a>';  
            exit();  
        }  
    }else{  
        $_FILES ['userfile'] ['error'] = 6;  
    }  
  
    if ($_FILES ['userfile'] ['error'] > 0) {  
        echo 'Problem: ';  
        switch ($_FILES ['userfile'] ['error']) {  
            case 1 :  
                echo '上传文件过大:<a href='.$reurl.'>请重试</a>';  
                break;  
            case 2 :  
                echo '上传文件过大:<a href='.$reurl.'>请重试</a>';  
                break;  
            case 3 :  
                echo '文件上传丢失:<a href='.$reurl.'>请重试</a>';  
                break;  
            case 4 :  
                echo '无文件被上传:<a href='.$reurl.'>请重试</a>';  
                break;  
            case 6 :  
                echo '仅支持word和pdf文件，且文件大小小于512kb:<a href='.$reurl.'>请重试</a>';  
                break;  
            case 7 :  
                echo '上传文件存储失败:<a href='.$reurl.'>请重试</a>';  
                break;  
        }  
        exit ();  
    }  
    //判断文件类型  
    //上传文件   
    $_FILES ['userfile'] ['name'] = time () . "." . $tuozhanming;  
    $upfile = '../uploads/' . $_FILES ['userfile'] ['name'];  
  
    if ( !move_uploaded_file ( $_FILES ['userfile'] ['tmp_name'], $upfile )) {  
        echo 'Problem: 文件移动失败';  
        exit ();  
    }   
  
function detectMIME($filename) {  
    $file = fopen ( $filename, "rb" );  
    $finfo = finfo_open ( FILEINFO_MIME );  
    if (! $finfo) {  
        // 直接读取文件的前4个字节，根据硬编码判断  
        $file = fopen ( $filename, "rb" );  
        $bin = fread ( $file, 4 ); //只读文件头4字节  
        fclose ( $file );  
        $strInfo = @unpack ( "C4chars", $bin );  
        //dechex() 函数把十进制转换为十六进制。  
        $typeCode = dechex ( $strInfo ['chars1'] ) .   
                            dechex ( $strInfo ['chars2'] ) .   
                            dechex ( $strInfo ['chars3'] ) .   
                            dechex ( $strInfo ['chars4'] );  
        $type = '';  
        switch ($typeCode) //硬编码值查表  
        {  
            case "504b34" :  
                $type = 'application/zip; charset=binary';  
                break;  
            case "d0cf11e0" :  
                $type = 'application/vnd.ms-office; charset=binary';  
                break;  
            case "25504446" :  
                $type = 'application/pdf; charset=binary';  
                break;  
            default :  
                $type = 'application/vnd.ms-office; charset=binary';  
                break;  
        }  
    } else {  
        //finfo_file return information of a file  
        $type = finfo_file ( $finfo, $filename );  
    }  
    return $type;  
}
  
function getFileExt($filename, $type) {  
    switch ($type) {  
        case "application/zip; charset=binary" :  
            $extType = "docx";  
            break;  
        case "application/vnd.ms-office; charset=binary" :  
            $extType = "doc";  
            break;  
        case "application/msword; charset=binary" :  
                $extType = "doc";  
            break;  
        case "application/pdf; charset=binary" :  
            $extType = "pdf";  
            break;  
        default :  
            $extType = "type_error";  
            break;  
    }  
    return $extType;  
}  