<?php

/**
 * 封装PDODB类
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/5
 * Time: 14:13
 */
class PDODB implements I_DAO
{
    /**
     * 定义相关的属性
     */
    private $host;    // 地址
    private $port;    // 端口号
    private $user;    // 用户名
    private $pass;    // 密码
    private $charset; // 字符集
    private $dbname;  // 数据库名
    private $dsn;     // 数据源名称
    private $pdo;     // 存放PDO类的对象
    private static $instance;    // 用于存放PDODB类的单例对象

    /**
     * 构造方法
     */
    private function __construct($arr)
    {
        //初始化属性
        $this->initParams($arr);
        //初始化dsn
        $this->initDSN();
        //实例化PDO对象
        $this->initPDO();
        //初始化PDO对象属性
        $this->initAttribute();
    }

    /**
     * 获得PDODB单例对象的公开方法
     */
    public static function getInstance($arr)
    {
        // TODO: Implement getInstance() method.
        if (!self::$instance instanceof self) {
            self::$instance = new self($arr);
        }
        return self::$instance;
    }

    /**
     * 初始化属性的值
     */
    private function initParams($arr)
    {
        $this->host = isset($arr['host']) ? $arr['host'] : '127.0.0.1';
        $this->port = isset($arr['port']) ? $arr['port'] : '3306';
        $this->user = isset($arr['user']) ? $arr['user'] : 'root';
        $this->pass = isset($arr['pass']) ? $arr['pass'] : '';
        $this->charset = isset($arr['charset']) ? $arr['charset'] : 'utf8';
        $this->dbname = isset($arr['dbname']) ? $arr['dbname'] : '';
    }

    /**
     * 初始化DSN
     */
    private function initDSN()
    {
        $this->dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=$this->charset";
    }

    /**
     * 初始化PDO对象
     */
    private function initPDO()
    {
        // 在实例化PDO对象的时候自动走异常模式，也是唯一走异常模式的地方
        try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            echo '数据库连接失败<br/>';
            echo '错误信息：', $e->getMessage(), '<br/>';
            echo '错误代码：', $e->getCode(), '<br/>';
            echo '错误脚本：', $e->getFile(), '<br/>';
            echo '错误行号：', $e->getLine(), '<br/>';
            return false;
        }
    }

    /**
     * 初始化PDO对象属性
     */
    private function initAttribute()
    {
        // 把错误方式修改为异常模式
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 输出异常信息
     */
    private function my_error($e)
    {
        echo 'SQL语句执行失败 <br/>';
        echo '错误信息：', $e->getMessage(), '<br/>';
        echo '错误代码：', $e->getCode(), '<br/>';
        echo '错误脚本：', $e->getFile(), '<br/>';
        echo '错误行号：', $e->getLine(), '<br/>';
        return false;
    }

    /**
     * 执行一条sql语句
     */
    public function my_query($sql)
    {
        // TODO: Implement my_query() method.
        try {
            $result = $this->pdo->exec($sql);
        } catch (PDOException $e) {
            $this->my_error($e);
        }
        return $result;
    }

    /**
     * 获取多行多列的信息
     */
    public function fetchAll($sql)
    {
        // TODO: Implement fetchAll() method.
        try {
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //释放资源，关闭光标
            $stmt->closeCursor();
        } catch (PDOException $e) {
            $this->my_error($e);
        }
        return $result;
    }

    /**
     * 获取一行多列信息
     */
    public function fetchRow($sql)
    {
        try {
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //释放资源 关闭光标
            $stmt->closeCursor();
        } catch (PDOException $e) {
            $this->$result;
        }
        return $result;
    }

    /**
     * 获取单行单列信息
     */
    public function fetchColumn($sql)
    {
        try {
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetchColumn();
            //释放资源
            $stmt->closeCursor();
        } catch (PDOException $e) {
            $this->my_error($e);
        }
        return $result;
    }

    /**
     * 私有化克隆方法
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
}