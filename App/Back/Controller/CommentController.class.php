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
        $cmtInfo = $comment->getUnauditedComment();
        $this->assign('cmtInfo', $cmtInfo);

        //分页相关
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $maxNum = $GLOBALS['conf']['Page']['maxNum'];
        $url = "index.php?p=Back&c=Comment&a=index&";
        //获取总记录数
        $rowCount = $comment->getRowCount(0);
        //实例化分页类
        $page = new Page($rowPerPage, $rowCount, $maxNum, $url);
        $strPage = $page->getStrPage();
        //分配页码字符串
        $this->assign('strPage', $strPage);

        //显示页面
        $this->display('index.html');
    }

    /**
     * 审核通过评论
     */
    public function ifPassAction()
    {
        //接收评论id
        $cmt_id = $_GET['cmt_id'];
        $comment = Factory::M('CommentModel');
        //接收当前页码
        $pageNum = $_GET['pageNum'];
        //更新评论状态为1
        $result = $comment->updateCommentById($cmt_id, 1);
        if ($result) {
            $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum");
        } else {
            $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum","发生未知错误，审核评论失败");
        }
    }

    /**
     * 删除评论(放入回收站)
     */
    public function delAction()
    {
        //接收评论id
        $cmt_id = $_GET['cmt_id'];
        $comment = Factory::M('CommentModel');
        //接收当前页码
        $pageNum = $_GET['pageNum'];
        //更新评论状态为2
        $result = $comment->updateCommentById($cmt_id, 2);
        if ($result) {
            $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum");
        } else {
            $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum","发生未知错误，删除评论失败");
        }
    }

    /**
     * 处理批量删除和审核通过动作
     */
    public function batchAction()
    {
        if ($_REQUEST['delAll']) {
            //批量删除
            if (!isset($_POST['cmt_id'])) {
                //未选择评论
                $this->jump("index.php?p=Back&c=Comment&a=index", "请选择要删除的评论");
            }
            //获取要删除的所有评论的id号
            $cmt_ids = implode(',', $_POST['cmt_id']);
            //调用模型
            $comment = Factory::M('CommentModel');
            $result = $comment->updateCommentByBentch($cmt_ids, 2);
            //接收当前页码
            $pageNum = $_POST['pageNum'];
            if ($result) {
                $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum");
            } else {
                $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum","发生未知错误，批量删除评论失败");
            }
        } else if ($_REQUEST['passAll']) {
            //批量通过
			//接收当前页码
            $pageNum = $_POST['pageNum'];
            if (!isset($_POST['cmt_id'])) {
                //未选择评论
                $this->jump("index.php?p=Back&c=Comment&a=index&$pageNum", "请选择要通过的评论");;
            }
            //获取要批量通过的所有评论的id号
            $cmt_ids = implode(',', $_POST['cmt_id']);
            
            //调用模型
            $comment = Factory::M('CommentModel');
            $result = $comment->updateCommentByBentch($cmt_ids, 1);
            if ($result) {
                $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum");
            } else {
                $this->jump("index.php?p=Back&c=Comment&a=index&pageNum=$pageNum","发生未知错误，批量通过评论失败");
            }
        }
    }

    /**
     * 显示回收站页面
     */
    public function recycleAction()
    {
        //调用模型，提取所有已经被逻辑删除的评论信息
        $comment = Factory::M('CommentModel');
        $cmtInfo = $comment->getDelCmtInfo();
        $this->assign('cmtInfo', $cmtInfo);

        //添加分页相关
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $maxNum = $GLOBALS['conf']['Page']['maxNum'];
        $url = "index.php?p=Back&c=Comment&a=recycle&";
        //获取逻辑删除的总记录数，状态值为2
        $rowCount = $comment->getRowCount(2);
        //实例化分页类
        $page = new Page($rowPerPage, $rowCount, $maxNum, $url);
        $strPage = $page->getStrPage();
        //分配页码字符串
        $this->assign('strPage', $strPage);

        $this->display('recycle.html');
    }

    /**
     * 回收站批量彻底删除和批量恢复
     */
    public function batchRecAction()
    {
        if ($_REQUEST['comDelAll']) {
            //批量彻底删除
            //获取当前页码
            $pageNum = $_POST['pageNum'];
            if (!isset($_POST['cmt_id'])) {
                //未选择评论
                $this->jump("index.php?p=Back&c=Comment&a=recycle&$pageNum", "请选择要通过的评论");;
            }
            //获取要批量恢复的所有评论的id号
            $cmt_ids = implode(',', $_POST['cmt_id']);

            //调用模型
            $comment = Factory::M('CommentModel');
            $result = $comment->relDelComByBentch($cmt_ids);
            if ($result) {
                $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum");
            } else {
                $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum","发生未知错误，批量删除评论失败");
            }
        } else if ($_REQUEST['recAll']){
            //接收当前页码
            $pageNum = $_POST['pageNum'];
            //批量恢复
            if (!isset($_POST['cmt_id'])) {
                //未选择评论
                $this->jump("index.php?p=Back&c=Comment&a=recycle&$pageNum", "请选择要通过的评论");;
            }
            //获取要批量恢复的所有评论的id号
            $cmt_ids = implode(',', $_POST['cmt_id']);

            //调用模型
            $comment = Factory::M('CommentModel');
            $result = $comment->updateCommentByBentch($cmt_ids, 0);
            if ($result) {
                $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum");
            } else {
                $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum","发生未知错误，批量通过评论失败");
            }
        }
    }

    /**
     * 彻底删除评论
     */
    public function relDelAction()
    {
        //接收评论id
        $cmt_id = $_GET['cmt_id'];
        //接收当前页码
        $pageNum = $_GET['pageNum'];
        //实例化模型
        $comment = Factory::M('CommentModel');
        //彻底删除评论
        $result = $comment->relDelCmt($cmt_id);
        if ($result) {
            $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum");
        } else {
            $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum","发生未知错误，删除评论失败");
        }
    }

    /**
     * 恢复评论
     */
    public function recovCmtAction()
    {
        //接收评论id
        $cmt_id = $_GET['cmt_id'];
        //接收当前页码
        $pageNum = $_GET['pageNum'];
        //实例化模型
        $comment = Factory::M('CommentModel');
        //彻底删除评论
        $result = $comment->updateCommentById($cmt_id, 0);
        if ($result) {
            $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum");
        } else {
            $this->jump("index.php?p=Back&c=Comment&a=recycle&pageNum=$pageNum","发生未知错误，恢复评论失败");
        }
    }

    /**
     * 显示已审核通过的评论
     */
    public function passedCmtAction()
    {
        //调用模型，提取所有已审核通过的评论信息
        $comment = Factory::M('CommentModel');
        $cmtInfo = $comment->getPassedCmtInfo();
        $this->assign('cmtInfo', $cmtInfo);

        //添加分页相关
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $maxNum = $GLOBALS['conf']['Page']['maxNum'];
        $url = "index.php?p=Back&c=Comment&a=passedCmt&";
        //获取已审核通过的总记录数，状态值为2
        $rowCount = $comment->getRowCount(1);
        //实例化分页类
        $page = new Page($rowPerPage, $rowCount, $maxNum, $url);
        $strPage = $page->getStrPage();
        //分配页码字符串
        $this->assign('strPage', $strPage);

        $this->display('passedCmt.html');
    }

    /**
     * 设置评论为待审核
     */
    public function reCheckCmtAction()
    {
        //接收评论id
        $cmt_id = $_GET['cmt_id'];
        $pageNum = $_GET['pageNum'];
        $comment = Factory::M('CommentModel');
        //更新评论状态为0
        $result = $comment->updateCommentById($cmt_id, 0);
        if ($result) {
            $this->jump("index.php?p=Back&c=Comment&a=passedCmt&pageNum=$pageNum");
        } else {
            $this->jump("index.php?p=Back&c=Comment&a=passedCmt&pageNum=$pageNum","发生未知错误，删除评论失败");
        }
    }

    /**
     * 批量设置评论为待审核
     */
    public function batchReCheckAction()
    {
        //批量设置为未审核
        //获取当前页码
        $pageNum = $_POST['pageNum'];
        if (!isset($_POST['cmt_id'])) {
            //未选择评论
            $this->jump("index.php?p=Back&c=Comment&a=passedCmt", "请选择要恢复为未审核的评论");
        }
        //获取想要批量设置为未审核的评论的id号
        $cmt_ids = implode(',', $_POST['cmt_id']);

        //调用模型
        $comment = Factory::M('CommentModel');
        $result = $comment->updateCommentByBentch($cmt_ids, 0);
        if ($result) {
            $this->jump("index.php?p=Back&c=Comment&a=passedCmt&pageNum=$pageNum");
        } else {
            $this->jump("index.php?p=Back&c=Comment&a=passedCmt&pageNum=$pageNum","发生未知错误，批量通过评论失败");
        }
    }
}