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
        $thumb = 'default.jpg';    //暂时使用默认
        $addTime = time();
        //入库
        $sql = "insert into bg_article 
           VALUES (null,$cate_id,'$title','$thumb','$art_desc','$content','$author',DEFAULT ,'$addTime',DEFAULT )";
        return $this->dao->my_query($sql);
    }
}