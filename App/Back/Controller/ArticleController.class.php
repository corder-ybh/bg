<?php
/**
 * 后台文章管理控制器
 * Created by PhpStorm.
 * User: ybh
 * Date: 2018/3/11
 * Time: 21:02
 */
class ArticleController extends PlatformController
{
    /**
     * 文章管理首页动作
     */
    public function indexAction()
    {
        //实例化模型，提取所有的文章信息
        $article = Factory::M('ArticleModel');
        $artInfo = $article->getArticle();
        //分配变量
        $this->assign('artInfo', $artInfo);

        //以下为分页相关代码
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $maxNum = $GLOBALS['conf']['Page']['maxNum'];
        $url = "index.php?p=Back&c=Article&a=index&";
        $rowCount = $article->getRowCount();    //获取总记录数
        //实例化分页类
        $page = new Page($rowPerPage, $rowCount, $maxNum, $url);
        $strPage = $page->getStrPage();
        //分配页码字符串
        $this->assign('strPage', $strPage);
        //分页到此结束

        //输出视图文件
        $this->display('index.html');
    }

    /**
     * 添加文章表单的显示
     */
    public  function addAction()
    {
        //需要先提取文章分类信息
        $category = Factory::M('CategoryModel');
        $cateInfo = $category->getCategory();
        //分配变量
        $this->assign('cateInfo', $cateInfo);
        //输出视图文件
        $this->display('add.html');

    }

    /**
     * 处理提交文章表单的动作
     */
    public function dealAddAction()
    {
        //接收表单
        $art = array();
        $art['cate_id'] = $_POST['cate_id'];
        $art['title'] = $this->escapeData($_POST['title']);
        $art['content'] = addslashes($_POST['content']);
        $art['art_desc'] = $this->escapeData($_POST['art_desc']);
        $art['author'] = $this->escapeData($_POST['author']);
        $art['keywords'] = $this->escapeData($_POST['keywords']);
        //判断数据合法性
        if (empty($art['title']) || empty($art['content'])
            || empty($art['art_desc']) || empty($art['author'])) {
            $this->jump('index.php?p=Back&c=Article&a=add', ':( 您填写的信息不完整！');
        }
        if (empty($art['cate_id'])) {
            $this->jump('index.php?p=Back&c=Article&a=add', ':( 请指定文章类型');
        }
        //判断是否有缩略图上传
        if ($_FILES['thumb']['error'] != 4) {
            //说明用户选择了上传文件，实例化上传类
            $upload = Factory::M('Upload');
            //初始化相关参数
            $allow = array('image/jpeg','image/png','image/gif','image/jpg');
            $path = UPLOADS_DIR . 'thumb';
            //调用uploadAction方法
            $result = $upload->uploadAction($_FILES['thumb'], $allow, $path);
            //判断是否上传成功
            if ($result) {
                $art['thumb'] = $result;  //将新文件名字记录到数组
            } else {
                //记录错误信息并跳转
                $error = Upload::$error;
                $this->jump('index.php?p=Back&c=Article&a=add',$error);
            }
        } else {
            $art['thumb'] = 'default.jpg';
        }
        //调用模型，数据入库
        $article = Factory::M('ArticleModel');
        $result = $article->insertArt($art);
        if ($result) {
            $this->jump('index.php?p=Back&c=Article&a=index');
        } else {
            $this->jump('index.php?p=Back&c=Article&a=add', ':( 发生未知错误，发布文章失败！');
        }
    }

    /**
     * 显示修改文章表单
     */
    public function editAction()
    {
        //接收文章id号
        $art_id = $_GET['art_id'];
        //获取当前文章的信息
        $article = Factory::M('ArticleModel');
        $artInfoById = $article->getArtInfoById($art_id);
        //分配变量
        $this->assign('artInfoById', $artInfoById);
        //获取文章类别信息
        $category = Factory::M('CategoryModel');
        $cateInfo = $category->getCategory();
        //分配变量
        $this->assign('cateInfo', $cateInfo);
        //输出视图文件
        $this->display('edit.html');
    }

    /**
     * 处理文章修改请求
     */
    public function dealeditAction()
    {
        //接收表单
        $art = array();
        $art['art_id'] = $_POST['art_id'];
        $art['cate_id'] = $_POST['cate_id'];
        $art['title'] = $this->escapeData($_POST['title']);
        $art['content'] = addslashes($_POST['content']);
        $art['art_desc'] = $this->escapeData($_POST['art_desc']);
        $art['author'] = $this->escapeData($_POST['author']);
        $art['keywords'] = $this->escapeData($_POST['keywords']);

        //判断数据合法性
        if (empty($art['title']) || empty($art['content'])
            || empty($art['art_desc']) || empty($art['author']) || empty($art['keywords'])) {
            $this->jump("index.php?p=Back&c=Article&a=edit&art_id=".$art['art_id'], ':( 您填写的信息不完整！');
        }
        if (empty($art['cate_id'])) {
            $this->jump("index.php?p=Back&c=Article&a=edit&art_id=".$art['art_id'], ':( 请指定文章类型');
        }

        //判断是否有缩略图上传
        if ($_FILES['thumb']['error'] != 4) {
            //说明用户选择了上传文件，实例化上传类
            $upload = Factory::M('Upload');
            //初始化相关参数
            $allow = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
            $path = UPLOADS_DIR . 'thumb';
            //调用uploadAction方法
            $result = $upload->uploadAction($_FILES['thumb'], $allow, $path);
            //判断是否上传成功
            if ($result) {
                if ($_POST['thumb_bak'] != 'default.jpg') {
                    //这是什么高级用法？
                    unlink(UPLOADS_DIR . 'thumb/' . $_POST['thumb_bak']);
                }
                $art['thumb'] = $result;    //将新名字记录到数组
            } else {
                //记录错误信息并跳转
                $error = Upload::$error;
                $this->jump("index.php?p=Back&c=Article&a=edit&art_id={$art['art_id']}", $error);
            }
        } else {
            //用户未上传新缩略图，使用以前的图片
            $art['thumb'] = $_POST['thumb_bak'];
        }

        //调用模型，数据入库
        $article = Factory::M('ArticleModel');
        $result = $article->updateArtById($art);
        if ($result) {
            $this->jump('index?p=Back&c=Article&a=index');
        } else {
            $this->jump("index.php?p=Back&c=Article&a=edit&art_id={$art['art_id']}", ':( 发生位置错误，修改文章失败');
        }
    }

    /**
     * 处理文章删除请求
     */
    public function delAction()
    {
        //获取要删除的文章的id号
        $art_id = $_GET['art_id'];
        //实例化模型
        $article = Factory::M('ArticleModel');
        $result = $article->delArtById($art_id);
        if ($result) {
            $this->jump('index.php?p=Back&c=Article&a=index');
        } else {
            $this->jump('index.php?p=Back&c=Article&a=index', ':( 发生未知错误，删除文章失败！');
        }
    }

    /**
     * 根据id号批量删除文章
     */
    public function delAllAction()
    {
        //先判断用户是否选择了文章
        if (!isset($_POST['art_id'])) {
            //说明没有选择文章
            $this->jump('index.php?p=Back&c=Article&a=index',':( 请先选择要删除的文章！');
        }
        //获取要删除的所有文章的id
        $art_ids = implode(',', $_POST['art_id']);
        //调用模型
        $article = Factory::M('ArticleModel');
        $result = $article->delAllArt($art_ids);
        if ($result) {
            $this->jump('index.php?p=Back&c=Article&a=index');
        } else {
            $this->jump('index.php?p=Back&c=Article&a=index', ':( 发生位置错误，批量删除失败');
        }
    }

    /**
     * 显示回收站页面
     */
    public function recycleAction()
    {
        //调用模型，提取所有已经被逻辑删除的文章信息
        $article = Factory::M('ArticleModel');
        $artInfo = $article->getDelArt();
        //分配变量
        $this->assign('artInfo', $artInfo);

        //添加分页相关代码
        $rowPerPage = $GLOBALS['conf']['Page']['rowPerPage'];
        $maxNum = $GLOBALS['conf']['Page']['maxNum'];
        $url = "index.php?p=Back&c=Article&a=recycle&";
        $rowCount = $article->getDelRowCount();    //获取总记录数
        //实例化分页类
        $page = new Page($rowPerPage, $rowCount, $maxNum, $url);
        $strPage = $page->getStrPage();
        //分配页码字符串
        $this->assign('strPage', $strPage);

        //输出视图文件
        $this->display('recycle.html');
    }

    /**
     * 根据id号实现文章还原操作
     */
    public function recoverAction()
    {
        //获取需要还原的文章的id号
        $art_id = $_GET['art_id'];
        //调用模型
        $article = Factory::M('ArticleModel');
        $result = $article->recoverArtById($art_id);
        if ($result) {
            $this->jump('index.php?p=Back&c=Article&a=recycle');
        } else {
            $this->jump('index.php?p=Back&c=Article&a=recycle', ':( 发生未知错误，还原文章失败！');
        }
    }

    /**
     * 根据id号实现彻底删除功能
     */
    public function realDelAction()
    {
        //获取需要彻底删除的文章的id号
        $art_id = $_GET['art_id'];
        //调用模型
        $article = Factory::M('ArticleModel');
        $result = $article->realDealArtById($art_id);
        if ($result) {
            $this->jump('index.php?p=Back&c=Article&a=recycle');
        } else {
            $this->jump('index.php?p=Back&c=Article&a=recycle', ':( 发生未知错误，彻底删除文章失败！');
        }
    }

    /**
     * 根据id号批量彻底删除
     */
    public function realDelAllAction()
    {
        //先判断用户是否选择了文章
        if (!isset($_POST['art_id'])) {
            //说明没有选择文章
            $this->jump('index.php?p=Back&c=Article&a=recycle',':( 请选择要删除的文章');
        }
        //获取要彻底删除的所有文章的id号
        $art_ids = implode(',', $_POST['art_id']);
        //调用模型
        $article = Factory::M('ArticleModel');
        $result = $article->realDelAllArt($art_ids);
        if ($result) {
            $this->jump('index.php?p=Back&c=Article&a=recycle');
        } else {
            $this->jump('index.php?p=Back&c=Article&a=recycle',':( 发生未知错误，批量彻底删除失败！');
        }
    }

    /**
     * 设置文章是否推荐
     */
    public function ifRecommendAction()
    {
        //接收文章编号
        $art_id = $_GET['art_id'];
        //接收推荐状态
        $is_recommend = $_GET['is_recommend'];
        //接收当前页码
        $pageNum = $_GET['pageNum'];
        //调用模型
        $article = Factory::M('ArticleModel');
        $result = $article->updateRecommendById($art_id, $is_recommend);
        if ($result) {
            $this->jump("index.php?p=Back&c=Article&a=index&pageNum=$pageNum");
        } else {
            $this->jump("index.php?p=Back&c=Article&a=index&pageNum=$pageNum",':( 发生未知错误，设置推荐文章失败！');
        }

    }
}