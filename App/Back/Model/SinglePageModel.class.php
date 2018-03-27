<?php
/**
 * 后台bg_singlePage表操作模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/22
 * Time: 14:58
 */
class SinglePageModel extends Model
{
    /**
     * 获取所有的单页页面信息
     */
    public function getSinglePage()
    {
        $sql = "SELECT * FROM bg_singlePage ORDER BY page_id DESC";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 单页面入库
     */
    public function insertPage($pageInfo)
    {
        extract($pageInfo);
        //入库
        $sql = "INSERT INTO bg_singlePage VALUES (null, '$title', '$content')";
        return $this->dao->my_query($sql);
    }

    /**
     * 获取编辑文章的相关信息
     * @param $page_id
     */
    public function getPageInfoById($page_id)
    {
        $sql = "SELECT * FROM bg_singlePage WHERE page_id = $page_id";
        return $this->dao->fetchRow($sql);
    }

    /**
     * 更新单页信息
     * @param $pageInfo
     */
    public function updatePageByid($pageInfo)
    {
        extract($pageInfo);
        $sql = "UPDATE bg_singlePage SET title='$title', content='$content' WHERE page_id=$page_id";
        return $this->dao->my_query($sql);
    }
}