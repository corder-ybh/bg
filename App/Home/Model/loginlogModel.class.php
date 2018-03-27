<?php
/**
 * 登录日志操作模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/26
 * Time: 16:08
 */
class loginlogModel extends Model
{
    public function insertLoginLog($loginLog)
    {
        extract($loginLog);
        $sql = "INSERT INTO `blog`.`bg_loginlog` (user_id, login_time, login_ip, login_client) 
                  VALUES ($user_id, NOW(),'$login_ip','$login_client')";
        $this->dao->my_query($sql);
    }
}