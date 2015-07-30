<?php

class db {

    private $host = 'localhost';
    private $db_name = 'weixin_school';
    private $user_name = 'root';
    private $password = '123456';
    public $conn;
    public static $sql;
    public static $instance = null;

    private function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user_name, $this->password);
        if (!mysqli_select_db($this->conn, $this->db_name)) {
            return false;
        };
        mysqli_query($this->conn, 'set names utf8');
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new db;
        }
        return self::$instance;
    }

    /**
     * 查询数据库
     */
    public function selectAll($sql) {
        self::$sql = $sql;
        $result = mysqli_query($this->conn, self::$sql);
        $resuleRow = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $resuleRow[] = $row;
        }
        return $resuleRow;
    }

    public function selectOne($sql) {
        self::$sql = $sql;
        $result = mysqli_query($this->conn, self::$sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            return array();
        }
    }

    /**
     * 添加一条记录
     */
    public function insert($table, $data) {
        $values = '';
        $datas = '';
        foreach ($data as $k => $v) {
            $values.=$k . ',';
            $datas.="'$v'" . ',';
        }
        $values = rtrim($values, ',');
        $datas = rtrim($datas, ',');
        self::$sql = "INSERT INTO  {$table} ({$values}) VALUES ({$datas})";
        if (mysqli_query($this->conn, self::$sql)) {
            return mysqli_insert_id($this->conn);
        } else {
            return false;
        }
    }

    /**
     * 修改一条记录
     */
    public function update($table, $data, $where = "") {
        if (!empty($where)) {
            $where = " where " . $where;
        }
        $updatastr = '';
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $updatastr.= $k . "='" . $v . "',";
            }
            $updatastr = 'set ' . rtrim($updatastr, ',');
        }
        self::$sql = "update {$table} {$updatastr} {$where}";
        echo self::$sql;
        mysqli_query($this->conn, self::$sql);
        return mysqli_affected_rows($this->conn);
    }

    /**
     * 删除记录
     */
    public function delete($table, $where) {
        if (!empty($where)) {
            $where = " where " . $where;
        }
        self::$sql = "delete from {$table} {$where}";
        mysqli_query($this->conn, self::$sql);
        return mysqli_affected_rows($this->conn);
    }

    public function close() {
        mysqli_close($this->conn);
    }

    public function __destruct() {
        $this->close();
    }

}
