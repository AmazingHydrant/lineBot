<?php
class DAO
{
    /**
     * 
     */
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $port;
    private $charset;
    /**
     * @var mysqli
     */
    private $dblink;
    private static $instance = null;
    /**
     *
     */
    private function __construct($option)
    {
        $this->dbInit($option);
        $this->dbConnect();
        $this->dbCharset();
    }
    public function __destruct()
    {
        if ($this->dblink) {
            $this->dblink->close();
        }
    }
    /**
     * DB參數初始化
     */
    private function dbInit($option)
    {
        $this->host = isset($option['host']) ?  $option['host'] : '127.0.0.1';
        $this->user = isset($option['user']) ?  $option['user'] : 'root';
        $this->pass = isset($option['pass']) ?  $option['pass'] : null;
        $this->dbname = isset($option['dbname']) ?  $option['dbname'] : null;
        $this->port = isset($option['port']) ?  $option['port'] : '3306';
        $this->charset = isset($option['charset']) ?  $option['charset'] : 'utf8';
        if (!($this->host && $this->user && $this->pass && $this->dbname && $this->port)) {
            die("DB初始化參數不完整！");
        }
    }
    /**
     * 連接DB
     */
    private function dbConnect()
    {
        $mysqli = @new mysqli($this->host, $this->user, $this->pass, $this->dbname, $this->port);
        if ($mysqli->connect_error) {
            echo "connect error: {$mysqli->connect_error}<br/>";
            die;
        }
        $this->dblink = $mysqli;
    }
    /**
     * 設定字符編碼
     */
    private function dbCharset()
    {
        $res = $this->dblink->set_charset($this->charset);
        if (!$res) {
            echo "無效的字符編碼：{$this->charset}<br/>";
            return false;
        }
    }
    /**
     * 單例模式
     * @param array $option
     * default arr['host'=>'127.0.0.1', 'user'=>'root', 'pass'=>'null', 'dbname'=>'null', 'charset'=>'utf8']
     */
    public static function getInstance($option)
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self($option);
        }
        return self::$instance;
    }
    public function myQuery($sql)
    {
        $res = $this->dblink->query($sql);
        if ($res) {
            return $res;
        }
        echo "sql error: {$this->dblink->error}<br/>";
        return false;
    }
    /**
     * @param string $sql
     */
    public function fetchAll($sql)
    {
        if ($res = $this->myQuery($sql)) {
            $rows = [];
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
            $res->free();
            return $rows;
        }
        return false;
    }
    /**
     * @param string $sql
     */
    public function fetchRow($sql)
    {
        if ($res = $this->myQuery($sql)) {
            $row = $res->fetch_assoc();
            $res->free();
            return $row;
        }
        return false;
    }
    /**
     * @param string $sql
     */
    public function fetchCol($sql)
    {
        if ($res = $this->myQuery($sql)) {
            $row = $res->fetch_assoc();
            $res->free();
            return isset($row[0]) ? $row[0] : false;
        }
        return false;
    }
}
