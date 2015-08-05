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

    function startShake() {


            $data['time'] = time();
            $data['endtime'] = 0;
            file_put_contents($this->filename, json_encode($data));
            echo jsonencode($data);
    }
    function endShake() {

        if(file_exists($this->filename)) {
            $data = json_decode(file_get_contents($this->filename), true);
            $data['endtime'] = time();
            file_put_contents($this->filename, json_encode($data));
        echo jsonencode($data);
        }
    }
    
    function getDataList() {
        $sql="SELECT * FROM weixin_attention WHERE delated=0 ORDER BY p_shake DESC LIMIT 0,10";
        $data=$this->mydb->selectAll($sql);
        echo json_encode($data);
    }

}

$cshake = new Cshake();
$get = get();
switch ($get['a']) {
    case "start":
        $cshake->startShake();
        break;
    case "end":
        $cshake->endShake();
        break;
    case "getDataList":
        $cshake->getDataList();
        break;


    default:
        break;
}
