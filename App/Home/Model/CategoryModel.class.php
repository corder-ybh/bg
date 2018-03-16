<?php
/**
 * 前台的bg_category表操作模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/15
 * Time: 16:29
 */
class CategoryModel extends Model
{
    /**
     * 获取所有一级分类信息
     */
    public function getFirstCate()
    {
        $sql = "SELECT * FROM bg_category WHERE cate_pid='0' ORDER BY cate_sort LIMIT 5";
        return $this->dao->fetchAll($sql);
    }

}