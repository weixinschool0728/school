<?php

include_once './commonCBaseClass.php';

//$cbass = new CBaseClass();
class Cerweima extends CBaseClass {

    private $perpage = 10;

    function __construct() {
        parent::__construct();
    }

    function getData() {
        $sql = "SELECT count(*) c 
				FROM weixin_child
				WHERE delated=0 ";
        $res = $this->mydb->selectOne($sql);
        $pages = ceil($res['c'] / $this->perpage);
        for ($page = 0; $page < $pages; $page++) {
            $sql = "SELECT c_no FROM weixin_child WHERE delated=0 ORDER BY c_id
					LIMIT " . ($page * $this->perpage) . ", {$this->perpage}";
                    $res=  $this->mydb->selectAll($sql);
                    var_dump($res);
                    //接着写  太晚啦
        }
    }

}

$cerweima = new Cerweima();
$cerweima->getData();
exit;
$filename = "qrcodeImages";
if (!file_exists($filename)) {
    mkdir("$filename");
}

include('./common/phpqrcode.php');
$value1 = 'http://www.aixianxing.com'; //二维码内容 
$values = array(
    1 => 'http://www.aixianxing.com/index.php?m=Index&a=index&sid=0001',
    2 => 'http://www.aixianxing.com/index.php?m=Index&a=index&sid=0002',
    3 => 'http://www.aixianxing.com/index.php?m=Index&a=index&sid=0003',
    4 => 'http://www.aixianxing.com/index.php?m=Index&a=index&sid=0004',
    5 => 'http://www.aixianxing.com/index.php?m=Index&a=index&sid=0005',
    6 => 'http://www.aixianxing.com/index.php?m=Index&a=index&sid=0006',
);
$errorCorrectionLevel = 'L'; //容错级别 
$matrixPointSize = 6; //生成图片大小 
//生成二维码图片 
foreach ($values as $key => $value) {
    QRcode::png($value, $filename . '/qrcode-' . $key . '.png', $errorCorrectionLevel, $matrixPointSize, 2);
}




$logo = 'logo.png'; //准备好的logo图片 
$QR = 'qrcodeImages/qrcode.png'; //已经生成的原始二维码图 

if ($logo == FALSE) {
    $QR = imagecreatefromstring(file_get_contents($QR));
    $logo = imagecreatefromstring(file_get_contents($logo));
    $QR_width = imagesx($QR); //二维码图片宽度 
    $QR_height = imagesy($QR); //二维码图片高度 
    $logo_width = imagesx($logo); //logo图片宽度 
    $logo_height = imagesy($logo); //logo图片高度 
    $logo_qr_width = $QR_width / 5;
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    $from_width = ($QR_width - $logo_qr_width) / 2;
    //重新组合图片并调整大小 
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}
//输出图片 
//imagepng($QR, 'helloweba.png'); 
echo '<img src="' . $filename . '/qrcode.png">';
