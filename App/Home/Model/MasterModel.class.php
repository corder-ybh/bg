<?php
/**
 * 站长信息模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/16
 * Time: 17:10
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
}