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
        $sql = "SELECT COUNT(*) FROM bg_comment WHERE art_id=$art_id AND is_show = '1'";
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
        $sql = "SELECT c.*, u.user_image FROM bg_comment AS c LEFT JOIN bg_user AS u ON c.cmt_user = u.user_name 
                    WHERE c.art_id = $art_id AND c.is_show='1' ORDER BY c.cmt_time ASC LIMIT $offset, $rowsPerPage";
        return $this->dao->fetchAll($sql);
    }
}