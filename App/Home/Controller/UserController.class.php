<?php
/**
 * 前台用户控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/22
 * Time: 17:17
 */
class UserController extends PlatformController
{
    /**
     * 注册动作处理
     */
    public function registerAction()
    {
        //获取站长信息
        $master = Factory::M('MasterModel');
        $masterInfo = $master->getMasterInfo();
        //分配变量
        $this->assign('masterInfo', $masterInfo);
        //调用Article模型
        $article = Factory::M('ArticleModel');
        //获取最新文章列表
        $newArt = $article->getNewArt(8);
        //分配变量
        $this->assign('newArt', $newArt);
        //获取最热推荐文章列表
        $rmdArtByHits = $article->getRmdByHits(8);
        //分配变量
        $this->assign('rmdArtByHits', $rmdArtByHits);
        //显示输出视图文件
        $this->display('register.html');
    }

    /**
     * 处理会员注册动作
     */
    public function dealRegisterAction()
    {
        //接收数据
        $userInfo = array();
        $user_name = $this->escapeData($_POST['user_name']);
    }
}