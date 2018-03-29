<?php
/** 站长信息模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/16
 * Time: 15:21
 */
class MasterModel extends Model
{
    /**
     * 获取站长信息
     */
    public function getMasterInfo()
    {
        $sql = "SELECT * FROM bg_master LIMIT 1";
        return $this->dao->fetchRow($sql);
    }

    /**
     * 更新站长信息
     * @param $masterInfo
     */
    public function UpdateMasterInfo($masterInfo)
    {
        extract($masterInfo);
        $sql = "UPDATE bg_master SET nickname='$nickname',job='$job',tel='$tel',home='$home',email='$email'";
        return $this->dao->my_query($sql);
    }
}