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
        $sql = "SELECT cm.*, bat.title, bu.user_name
                  FROM bg_comment cm 
                  LEFT JOIN bg_article bat ON cm.art_id = bat.art_id
                  LEFT JOIN bg_user bu ON bu.user_id = cm.cmt_user
                  WHERE cm.cmt_status = '0';";
        return $this->dao->fetchall($sql);
    }
}