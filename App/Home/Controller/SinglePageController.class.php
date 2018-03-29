<?php
/**
 * 前台单页页面控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/22
 * Time: 16:39
 */
class SinglePageController extends PlatformController
{
    /**
     * 单页显示动作
     */
    public function indexAction()
    {
        //获取单页的page_id
        $page_id = $_GET['page_id'];
        //调用模型
        $singlePage = Factory::M('SinglePageModel');
        $pageInfo = $singlePage->getPageInfoById($page_id);
        //分配变量
        $this->assign('pageInfo', $pageInfo);
        //调用MasterModel获取站长信息
        $master = Factory::M('MasterModel');
        $masterInfo = $master->getMasterInfo();
        //分配变量
        $this->assign('masterInfo', $masterInfo);
        //输出视图
        $this->display('index.html');
    }
}