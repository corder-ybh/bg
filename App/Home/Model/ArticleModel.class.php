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

    /**
     * 获取最新文章列表
     */
    public function getNewArt($length)
    {
        //只需要文章id和文章标题
        $sql = "SELECT a.art_id, a.title FROM bg_article AS a 
                    WHERE a.is_del='0' 
                    ORDER BY a.addtime DESC LIMIT $length";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 获取最热推荐文章列表
     */
    public function getRmdByHits($length)
    {
        $sql = "SELECT a.art_id,a.title FROM bg_article AS a 
            WHERE a.is_del='0' AND a.is_recommend='1'
            ORDER BY a.hits DESC LIMIT $length";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 根据类别号获取当前类别及其子类别下所有文章的信息
     */
    public function getArtInfo($cate_id)
    {
        //先获取该类别下所有的子类别的id号
        $ids = $this->getAllSubIds($cate_id);
        //再拼凑上当前分类的id号
        $ids .= $cate_id;
        //计算偏移量
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
        $offset = ($pageNum - 1) * 9;
        $sql = "SELECT a.*, c.cate_name FROM bg_article a 
                LEFT JOIN bg_category c ON a.cate_id = c.cate_id
                WHERE a.is_del='0' AND a.cate_id IN($ids) LIMIT {$offset}, 9";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 获取分类下的所有子类别的id
     * @param $cate_id
     */
    private function getAllSubIds($cate_id)
    {
        $sql = "SELECT cate_id FROM bg_category WHERE cate_pid = $cate_id";
        $id = $this->dao->fetchAll($sql);
        //在函数执行完后，变量值仍然保存
        static $ids = '';
        foreach ($id as $row) {
            $ids .= $row['cate_id'] . ',';
            $this->getAllSubIds($row['cate_id']);
        }
        return $ids;
    }

    /**
     * 获取当前分类及其子分类下所有文章的记录
     * @param $cate_id 分类id
     */
    public function getRowCount($cate_id)
    {
        //先获取所有的子分类号
        $ids = $this->getAllSubIds($cate_id);
        //再拼凑上当前分类的id
        $ids .= $cate_id;
        $sql = "SELECT COUNT(*) FROM bg_article WHERE is_del='0' 
                    AND cate_id IN ($ids)";
        return $this->dao->fetchColumn($sql);
    }

    /**
     * 获取当前类别下第一层的子类别
     * @param $pid
     * @return mixed
     */
    public function getSubCateByPid($pid)
    {
        $sql = "SELECT cate_id, cate_name FROM bg_category WHERE cate_pid=$pid";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 获取面包屑导航数组信息
     * @param $cate_id 分类id
     */
    public function getAllCateName($cate_id)
    {
        //获取当前分类的名称和父类的id号
        $sql = "SELECT cate_pid,cate_name FROM bg_category WHERE cate_id=$cate_id";
        $cateInfo = $this->dao->fetchRow($sql);
        $cate_name = $cateInfo['cate_name'];
        static $list = array();
        $list[$cate_id] = $cate_name;
        $cate_pid = $cateInfo['cate_pid'];
        //如果该类别的父类id不为0，递归开始
        if ($cate_pid != 0) {
            $this->getAllCateName($cate_pid);
        }
        return array_reverse($list, true);
    }

    /**
     * 获取某个分类下文章点击排行
     * @param $cate_id
     * @param $length
     */
    public function getSortByHits($cate_id, $length)
    {}

    /**
     * 获取某个分类下推荐文章排行
     * @param $cate_id
     * @param $length
     */
    public function getSortByRecommend($cate_id, $length)
    {}
}