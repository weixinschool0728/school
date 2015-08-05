<?php

include_once './commonCBaseClass.php';
error_reporting(E_ALL);

//$cbass = new CBaseClass();
class Cshake extends CBaseClass {

    // private $perpage = 10;
    private $filename = "../startshake.txt";

    function __construct() {
        parent::__construct();
    }

    // function updateChile($post = array()) {
    //     $data['c_no'] = $post['no'];
    //     $data['c_username'] = $post['name'];
    //     $data['c_head'] = $post['img'];
    //     $data['content'] = $post['content'];
    //     $data['updated'] = time();
    //     $data['delated'] = $post['state'];
    //     $id = $post['id'];
    //     return $this->mydb->update("weixin_child", $data, "c_id={$id}");
    // }

    function startShake() {

        if (file_exists($this->filename)) {
            $data = json_decode(file_get_contents($this->filename), true);
            $data['leave'] = time() - $data['time'];
            
            file_put_contents($this->filename, json_encode($data));
        } else {
            $data['time']=time();
            $data['leave']=0;
            file_put_contents($this->filename,json_encode($data));
        }
        echo jsonencode($data);
    }

}

$cshake = new Cshake();
$get = get();
switch ($get['a']) {
    case "start":
        $cshake->startShake();

        break;


    default:
        break;
}
