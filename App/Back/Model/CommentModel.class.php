<?php
/**
 * 评论操作模型
 * Created by PhpStorm.
 * User: ybh
 * Date: 2018/3/25
 * Time: 21:16
 */
class CommentModel extends Model
{
    /**
     * 获取所有待审核评论
     */
    public function getUnauditedComment()
    {
        //3.26增加分页相关
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
        //如果页码小于于0
        $pageNum = $pageNum > 0 ? $pageNum : 1;
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $offset = ($pageNum - 1) * $rowPerPage;

        $sql = "SELECT cm.*, bat.title, bu.user_name, bat.art_id
                  FROM bg_comment cm 
                  LEFT JOIN bg_article bat ON cm.art_id = bat.art_id
                  LEFT JOIN bg_user bu ON bu.user_id = cm.cmt_user
                  WHERE cm.cmt_status = '0' LIMIT $offset, $rowPerPage";
        return $this->dao->fetchall($sql);
    }

    /**
     * 更新评论状态
     * @param $cmt_id
     */
    public function updateCommentById($cmt_id, $cmt_status)
    {
        $sql = "UPDATE bg_comment SET cmt_status = '$cmt_status' WHERE cmt_id = $cmt_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 批量修改评论状态
     * @param $cmt_ids
     * @param $cmt_status
     */
    public function updateCommentByBentch($cmt_ids, $cmt_status)
    {
        $sql = "UPDATE bg_comment SET cmt_status = '$cmt_status' WHERE cmt_id IN ($cmt_ids)";
        return $this->dao->my_query($sql);
    }

    /**
     * 获取对应状态的所有记录数
     */
    public function getRowCount($cmt_status)
    {
        $sql = "SELECT COUNT(*) FROM bg_comment WHERE cmt_status = '$cmt_status'";
        return $this->dao->fetchColumn($sql);
    }

    /**
     * 获取已删除的评论记录
     */
    public function getDelCmtInfo()
    {
        //3.26增加分页相关
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
        //如果页码小于于0
        $pageNum = $pageNum > 0 ? $pageNum : 1;
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $offset = ($pageNum - 1) * $rowPerPage;

        $sql = "SELECT cm.*, bat.title, bu.user_name, bat.art_id
                  FROM bg_comment cm 
                  LEFT JOIN bg_article bat ON cm.art_id = bat.art_id
                  LEFT JOIN bg_user bu ON bu.user_id = cm.cmt_user
                  WHERE cm.cmt_status = '2' LIMIT $offset, $rowPerPage";
        return $this->dao->fetchall($sql);
    }

    /**
     * 批量彻底删除评论
     * @param $cmt_ids
     */
    public function relDelComByBentch($cmt_ids)
    {
        $sql = "DELETE FROM bg_comment WHERE cmt_id IN ($cmt_ids)";
        return $this->dao->my_query($sql);
    }

    /**
     * 彻底删除评论
     * @param $cmt_id
     */
    public function relDelCmt($cmt_id)
    {
        $sql = "DELETE FROM bg_comment WHERE cmt_id = $cmt_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 获取已审核通过的评论
     */
    public function getPassedCmtInfo()
    {
        //3.26增加分页相关
        $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
        //如果页码小于于0
        $pageNum = $pageNum > 0 ? $pageNum : 1;
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $offset = ($pageNum - 1) * $rowPerPage;

        $sql = "SELECT cm.*, bat.title, bu.user_name, bat.art_id
                  FROM bg_comment cm 
                  LEFT JOIN bg_article bat ON cm.art_id = bat.art_id
                  LEFT JOIN bg_user bu ON bu.user_id = cm.cmt_user
                  WHERE cm.cmt_status = '1' LIMIT $offset, $rowPerPage";
        return $this->dao->fetchall($sql);
    }
}