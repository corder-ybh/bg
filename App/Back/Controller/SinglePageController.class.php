<?php
/**
 * 单页管理控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/22
 * Time: 14:54
 */
class SinglePageController extends PlatformController
{
    /**
     * 单页管理首页动作
     */
    public function indexAction()
    {
        //需要提取所有的页面信息
        //调用模型
        $singlePage = Factory::M('SinglePageModel.class');
        $pageInfo = $singlePage->getSinglePage();
        //分配变量
        $this->assign('pageInfo', $pageInfo);
        //输出到视图文件
        $this->display('index.html');
    }

    /**
     * 显示添加单页表单
     */
    public function addAction()
    {
        $this->display('add.html');
    }

    /**
     * 处理增加单页动作
     */
    public function dealAddAction()
    {
        //接收表单
        $pageInfo = array();
        $pageInfo['title'] = $this->escapeData($_POST['title']);
        $pageInfo['content'] = $this->escapeData($_POST['content']);
        //判断数据的合法性
        if (empty($pageInfo['title']) || empty($pageInfo['content'])) {
            $this->jump('index.php?p=Back&c=SinglePage&a=add', ':( 填写的信息不完整');
        }
        //调用模型，数据入库
        $singlePage = Factory::M('SinglePageModel.class');
        $result = $singlePage->insertPage($pageInfo);
        if ($result) {
            $this->jump('index.php?p=Back&c=SinglePage&a=index');
        } else {
            $this->jump('index.php?p=Back&c=SinglePage&a=add', ':( 发生未知错误，添加失败');
        }
    }

    /**
     * 获取并显示编辑单页相关的内容
     */
    public function editAction()
    {
        //接收单页id号
        $page_id = $_GET['page_id'];
        //获取当前单页的信息
        $SinglePage = Factory::M('SinglePageModel.class');
        $pageInfoById = $SinglePage->getPageInfoById($page_id);
        //分配变量
        $this->assign('pageInfoById', $pageInfoById);
        //输出视图文件
        $this->display('edit.html');
    }

    /**
     * 处理单页修改请求
     */
    public function deleditAction()
    {}
}