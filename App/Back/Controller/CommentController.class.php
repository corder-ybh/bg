<?php
/**
 * 评论管理控制器
 * Created by PhpStorm.
 * User: ybh
 * Date: 2018/3/25
 * Time: 21:11
 */
class CommentController extends PlatformController
{
    /**
     * 显示评论管理页面
     */
    public function indexAction()
    {
        //实例化模型，提取所有待审核的评论信息
        $comment = Factory::M('CommentModel');
        $comInfo = $comment->getUnauditedComment();
        $this->assign('comInfo', $comInfo);

        //显示页面
        $this->display('index.html');
    }
}