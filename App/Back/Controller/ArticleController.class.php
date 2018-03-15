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

        //判断数据合法性
        if (empty($art['title']) || empty($art['content'])
            || empty($art['art_desc']) || empty($art['author'])) {
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
}