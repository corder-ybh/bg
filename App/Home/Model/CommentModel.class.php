<?php
/**
 * 评论操作模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/23
 * Time: 13:59
 */
class CommentModel extends Model
{
    /**
     * 插入评论
     * @param $cmtInfo array
     */
    public function insertComment($cmtInfo)
    {
        extract($cmtInfo);
        $sql = "INSERT INTO bg_comment VALUE (NULL, $art_id, '$cmt_user', '$cmt_content', $cmt_time, DEFAULT )";
        return $this->dao->my_query($sql);
    }

    /**
     * 根据文章id获取当前文章总评论数
     * @param $art_id int 文章id
     */
    public function getRowCountById($art_id)
    {
        $sql = "SELECT COUNT(*) FROM bg_comment WHERE art_id=$art_id AND cmt_status = '1'";
        return $this->dao->fetchColumn($sql);
    }

    /**
     * 根据文章id号获取当前页码所有评论信息
     * @param $art_id int 文章id
     * @param $rowsPerPage int 每页行数
     */
    public function getCmtInfosById($art_id, $rowsPerPage)
    {
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
        $offset = ($pageNum - 1) * $rowsPerPage;
        $sql = "SELECT c.*, u.user_image,u.user_name
                  FROM bg_comment AS c 
                  LEFT JOIN bg_user AS u ON c.cmt_user = u.user_id 
                  WHERE c.art_id = $art_id AND c.cmt_status='1' 
                  ORDER BY c.cmt_time ASC LIMIT $offset, $rowsPerPage";
        return $this->dao->fetchAll($sql);
    }

    /**
     * 获取最新的评论
     */
    public function getLatestCmt($num)
    {
        $sql = "SELECT bc.*, bu.user_name, bu.user_image, bat.art_id
                  FROM bg_comment bc 
                  LEFT JOIN bg_article bat ON bc.art_id = bat.art_id
                  LEFT JOIN bg_user bu ON bc.cmt_user = bu.user_id
                  WHERE bc.cmt_status = '1'
                  ORDER BY bc.cmt_time DESC LIMIT $num";
        return $this->dao->fetchAll($sql);
    }
}