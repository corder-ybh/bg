<?php
/**
 * Dap层操作接口
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/5
 * Time: 11:40
 */
interface I_DAO {
    public static function getInstance($config);
    public function my_query($sql);
    public function fetchAll($sql);
    public function fetchRow($sql);
    public function fetchColumn($sql);
}