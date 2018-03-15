<?php
/**
 * 后台bg_article表操作模型
 * Created by PhpStorm.
 * User: ybh
 * Date: 2018/3/11
 * Time: 22:29
 */
class ArticleModel extends Model
{
    /**
     * 实现文章入库
     */
    public function insertArt($art)
    {
        //通过数组得到多个变量
        extract($art);
        //完善其他数据表模型
        // $thumb = 'default.jpg';    //暂时使用默认
        $addTime = time();
        //入库
        $sql = "insert into bg_article 
           VALUES (null,$cate_id,'$title','$thumb','$art_desc','$content','$author',DEFAULT ,'$addTime',DEFAULT )";
        return $this->dao->my_query($sql);
    }

    /**
     * 获取所有文章信息
     */
    public function getArticle()
    {
        //增加分页相关
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
        $rowsPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $offset = ($pageNum - 1) * $rowsPerPage;

        $sql = "SELECT a.*,c.cate_name FROM bg_article AS a
            LEFT JOIN bg_category AS c ON a.cate_id=c.cate_id
            WHERE a.is_del='0' ORDER BY a.addtime desc LIMIT $offset, $rowsPerPage";
        return $this->dao->fetchall($sql);
    }

    /**
     * 根据id号获取文章信息
     * @param $art_id
     */
    public function getArtInfoById($art_id)
    {
        $sql = "SELECT * FROM bg_article WHERE art_id=$art_id";
        return $this->dao->fetchRow($sql);
    }

    /**
     * 根据id号修改文章信息
     * @param $art
     */
    public function updateArtById($art)
    {
        extract($art);
        $sql = "UPDATE bg_article set cate_id=$cate_id, title='$title', thumb='$thumb', art_desc='$art_desc',
            author='$author',content='$content' WHERE art_id=$art_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 根据id号删除文章
     * @param $art_id
     */
    public function delArtById($art_id)
    {
        $sql = "UPDATE bg_article SET is_del='1' WHERE art_id=$art_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 根据id号批量删除文章
     * @param $art_ids
     */
    public function delAllArt($art_ids)
    {
        $sql = "UPDATE bg_article SET is_del='1' WHERE art_id IN ($art_ids)";
        return $this->dao->my_query($sql);
    }

    /**
     * 获取所有已经被逻辑删除了的文章的信息
     */
    public function getDelArt()
    {
        $sql = "SELECT a.*,c.cate_name FROM bg_article a 
                    LEFT JOIN bg_category c ON a.cate_id=c.cate_id
                    WHERE a.is_del='1';";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 根据id号还原文章
     * @param $art_id
     */
    public function recoverArtById($art_id)
    {
        $sql = "UPDATE bg_article SET is_del='0' WHERE art_id=$art_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 根据id号彻底删除文章
     * @param $art_id 文章id
     */
    public function realDealArtById($art_id)
    {
        $sql = "DELETE FROM bg_article WHERE art_id=$art_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 根据id号批量删除文章
     * @param $art_ids
     */
    public function realDelAllArt($art_ids)
    {
        $sql = "DELETE FROM bg_article WHERE art_id IN ($art_ids)";
        return $this->dao->my_query($sql);
    }

    /**
     * 获取文章的总记录数
     */
    public function getRowCount()
    {
        $sql = "SELECT COUNT(*) FROM bg_article WHERE is_del='0'";
        return $this->dao->fetchColumn($sql);
    }
}