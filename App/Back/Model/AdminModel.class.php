<?php
/**
 * 后台操作bg_admin表的模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/5
 * Time: 17:22
 */
class AdminModel extends Model
{
    /**
     * 验证管理员合法性
     */
    public function check($admin_name, $admin_pass)
    {
        $sql = "SELECT * FROM bg_admin WHERE admin_name='$admin_name' AND admin_pass=md5('$admin_pass')";
        return $this->dao->fetchRow($sql);
    }

    /**
     * 更新当前管理员的信息
     * @param $id 当前管理员id号
     */
    public function updateAdminInfo($id)
    {
        $login_ip = $_SERVER["REMOTE_ADDR"];
        $login_time = time();
        $sql = "UPDATE bg_admin SET login_ip='$login_ip', login_time=$login_time,
            login_nums=login_nums+1 WHERE admin_id=$id";
        return $this->dao->my_query($sql);
    }
}