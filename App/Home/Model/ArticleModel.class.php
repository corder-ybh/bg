<?php
/**
 * 前台bg_article表操作模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/16
 * Time: 11:02
 */
class ArticleModel extends Model
{
    /**
     * 获取推荐的文章列表
     * @param $length
     */
    public function getRecommendArt($length)
    {
        $sql = "SELECT a.*,c.cate_name FROM bg_article a LEFT JOIN bg_category c ON a.cate_id=c.cate_id
            WHERE a.is_del='0' AND a.is_recommend='1' LIMIT $length";
        return $this->dao->fetchAll($sql);
    }
}