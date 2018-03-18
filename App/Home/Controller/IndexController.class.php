<?php
/**
 * 前台首页控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/15
 * Time: 16:19
 */
class IndexController extends PlatformController
{
    /**
     * 显示首页
     */
    public function IndexAction()
    {
        //获取一级分类信息放到了平台控制器中
        //调用Article模型
        $article = Factory::M('ArticleModel');
        //获取推荐文章信息
        $recommendArt = $article->getRecommendArt(5);
        //获取站长信息
        $master = Factory::M('MasterModel');
        $masterInfo = $master->getMasterInfo();
        //获取最新文章列表
        $newArt = $article->getNewArt(8);
        //获取最热推荐文章列表
        $rmdArtByHits = $article->getRmdByHits(8);

        //分配变量
        $this->assign('recommendArt', $recommendArt);
        $this->assign('masterInfo', $masterInfo);
        //分配最新和最热文章列表的变量
        $this->assign('newArt', $newArt);
        $this->assign('rmdArtByHits', $rmdArtByHits);

        //显示输出
        $this->display('index.html');
    }
}