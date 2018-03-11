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
     * 文章首页动作
     */
    public function indexAction()
    {
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
        //接受表单
        $art = array();
        $art['cate_id'] = $_POST['cate_id'];
        $art['title'] = $this->escapeData($_POST['title']);
        $art['content'] = $this->escapeData($_POST['content']);
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
        //判断是否有缩略图上传，暂时省略
        //调用模型，数据入库
        $article = Factory::M('ArticleModel');
        $result = $article->insertArt($art);
        if ($result) {
            $this->jump('index.php?p=Back&c=Article&a=index');
        } else {
            $this->jump('index.php?p=Back&c=Article&a=add', ':( 发生未知错误，发布文章失败！');
        }
    }

}