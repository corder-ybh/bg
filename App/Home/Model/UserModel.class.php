<?php
/**
 * 用户操作模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/23
 * Time: 10:00
 */
class UserModel extends Model
{
    /**
     * 判断用户是否已存在
     * @param $user_name string 用户名
     */
    public function if_name_exists($user_name)
    {
        $sql = "SELECT * FROM bg_user WHERE user_name = '$user_name'";
        return $this->dao->fetchRow($sql);
    }

    /**
     * 注册用户信息入库
     * @param $userInfo array 用户信息
     */
    public function insertUser($userInfo)
    {
        extract($userInfo);
        $sql = "INSERT INTO bg_user VALUES(null, '$user_name', '$user_pass', '$user_image', $user_time)";
        return $this->dao->my_query($sql);
    }

    /**
     *
     * @param $user_name string 用户名
     * @param $user_pass string 用户已md5处理的密码
     */
    public function check($user_name, $user_pass)
    {
        $sql = "SELECT * FROM bg_user WHERE user_name='$user_name' AND user_pass='$user_pass'";
        return $this->dao->fetchRow($sql);
    }
}