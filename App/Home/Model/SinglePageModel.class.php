<?php
/**
 * 单页操作
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/22
 * Time: 16:48
 */
class SinglePageModel extends Model
{
    /**
     * 根据id号获取单页面信息
     * @param $page_id int
     */
    public function getPageInfoById($page_id)
    {
        $sql = "SELECT * FROM bg_singlePage WHERE page_id=$page_id";
        return $this->dao->fetchRow($sql);
    }
}