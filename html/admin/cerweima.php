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
            $sql = "SELECT c_id,c_no FROM weixin_child WHERE delated=0 ORDER BY c_id
					LIMIT " . ($page * $this->perpage) . ", {$this->perpage}";
            $res = $this->mydb->selectAll($sql);
            var_dump($res);
            if ($res) {
                $this->processQr($res);
            }
            //接着写  太晚啦
        }
    }

    function processQr($data, $filename = "./qrcodeImages") {
        $errorCorrectionLevel = 'L'; //容错级别 
        $matrixPointSize = 5; //生成图片大小 
//        $filename = $filename . "/" . date("Y-m-d");
        if (!file_exists($filename)) {
            mkdir($filename, 0777, true);
        }
        include_once './common/phpqrcode.php';
        foreach ($data as $value) {
            $qrPath = $filename . '/qrcode-id-' . $value['c_id'] . '-' . $value['c_no'] . '.png';

            QRcode::png($_SERVER['HTTP_HOST'] . "/html/pointlike.php?c_no=" . $value['c_no'], $qrPath, $errorCorrectionLevel, $matrixPointSize, 2);
            $qrPath = preg_replace("/(^\.)(.*)$/i", "Http://" . $_SERVER['HTTP_HOST'] . "/html/admin$2", $qrPath);
            $this->updateChild($value['c_id'], $qrPath);
        }
    }

    function updateChild($cId, $qrPath) {
        $this->mydb->update("weixin_child", array("c_qrpath" => $qrPath), "c_id={$cId}");
    }

    function deleteChild($cId = 0) {
        return $this->mydb->update("weixin_child", array("delated" => "1"), "c_id={$cId}");
    }

    function getchild($page = 1) {
        $sql = "select count(*) c from weixin_child where delated=0";
        $res['p'] = $this->mydb->selectOne($sql);
        $res['p']['perpage'] = $this->perpage;
        $res['p']['pages'] = ceil($res['p']['c'] / $this->perpage);
        $res['p']['page'] = $page;
        if ($page == "all") {
            $sql = "select c_id,c_no,c_username,c_qrpath  from weixin_child where delated=0 ";
        } else {

            $start = ($page - 1) * $this->perpage;
            $sql = "select c_id,c_no,c_username,c_head,c_qrpath,content,created  from weixin_child where delated=0 limit {$start} ,{$this->perpage} ";
        }
        $res['data'] = $this->mydb->selectAll($sql);
        return $res;
    }
    
    function getOneData($cno=0,$delate=0){
        if($delate==0){
        $sql="select c_id,c_no,c_username,c_qrpath  from weixin_child where delated=0 and c_no='{$cno}'";
        }else{
            
        $sql="select * from weixin_child where c_no='{$cno}'";
        }
        
        return $this->mydb->selectOne($sql);
    }
    function getOneDataById($cid=0,$delate=0){
        if($delate==0){
        $sql="select c_id,c_no,c_username,c_qrpath  from weixin_child where delated=0 and c_id='{$cid}'";
        }else{
            
        $sql="select * from weixin_child where c_id='{$cid}'";
        }
        
        return $this->mydb->selectOne($sql);
    }
    
    function updateChile($post = array()) {
        $data['c_no'] = $post['no'];
        $data['c_username'] = $post['name'];
        $data['c_head'] = $post['img'];
        $data['content'] = $post['content'];
        $data['updated'] = time();
        $data['delated'] = $post['state'];
        $id = $post['id'];
        return $this->mydb->update("weixin_child", $data, "c_id={$id}");
    }

}

$cerweima = new Cerweima();
$get = get();
switch ($get['a']) {
    case "userlist":
        $returns = array();
        $data = $cerweima->getchild($get['page']);
        echo jsonencode($data);

        break;
    case "deleteuser":
        $post = post();
        if ($cerweima->deleteChild($post['id'])) {
            $res['state'] = 0;
        } else {
            $res['state'] = 1;
        }
        echo jsonencode($res);

        break;

    case "erweimalist":
        $returns = array();
        $data = $cerweima->getchild("all");
        echo jsonencode($data);

        break;
    case "createers":
        $returns = array();
        $data = $cerweima->getData();
        echo jsonencode($data);

        break;
    case "searchcno":
        $returns = array();
        $post = post();
        $returns = $cerweima->getOneData($post['cno']);
        if ($returns) {
            $returns['state'] = 0;
        } else {
            $returns['state'] = 1;
        }
        echo jsonencode($returns);

        break;
    case "getoneuser":
        $returns = array();
        $post = post();
        $returns = $cerweima->getOneDataById($post['cid'], 1);
        if ($returns) {
            $returns['state'] = 0;
        } else {
            $returns['state'] = 1;
        }
        echo jsonencode($returns);

        break;
    case "edituser":
        $post = post();
        $returns = array();
        if (!$post) {
            $returns['state'] = 1;
            echo json_encode($returns);
            exit;
        }
        $res = $cerweima->updateChile($post);
        if ($res) {
            $returns['state'] = 0;
        } else {
            $returns['state'] = 1;
        }
        echo jsonencode($returns);

        break;

    default:
        break;
}
