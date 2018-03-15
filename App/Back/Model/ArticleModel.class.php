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
        $sql = "SELECT * FROM bg_article AS a
            LEFT JOIN bg_category AS c ON a.cate_id=c.cate_id
            WHERE a.is_del='0' ORDER BY a.addtime desc;";
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
}