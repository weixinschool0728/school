<?php

error_reporting(0);
$action = $_GET['act'];
$filepath = "./upload/" . date("Y-m-d");
if (!file_exists($filepath)) {
    mkdir($filepath, 0777);
}
if ($action == 'delimg') {
    $filename = $_POST['imagename'];
    if (!empty($filename)) {
        unlink($filepath . $filename);
        echo '1';
    } else {
        echo '删除失败.';
    }
} else {
    $picname = $_FILES['mypic']['name'];
    $picsize = $_FILES['mypic']['size'];
    if ($picname != "") {
        if ($picsize > 10240000) {
            echo '图片大小不能超过10M';
            exit;
        }
        $type = strstr($picname, '.');
        if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
            echo '图片格式不对！';
            exit;
        }
        $rand = rand(100, 999);
        $pics = date("YmdHis") . $rand . $type;
        //上传路径
        $pic_path = $filepath . "/" . $pics;
        move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
        $url = preg_replace("/^(\.)(.*)$/", "http://" . $_SERVER['HTTP_HOST'] . "/html/admin$2", $pic_path);
    }
    $size = round($picsize / 1024, 2);
    $arr = array(
        'name' => $picname,
        'pic' => $url,
        'size' => $size
    );
    echo json_encode($arr);
}
?>