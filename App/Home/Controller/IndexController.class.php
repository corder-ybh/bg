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
        //调用模型
        $category = Factory::M('CategoryModel');
        //获取所有一级分类信息
        $firstCate = $category->getFirstCate();
        //调用Article模型
        $article = Factory::M('ArticleModel');
        //获取推荐文章信息
        $recommendArt = $article->getRecommendArt(5);
        //获取站长信息
        $master = Factory::M('MasterModel');
        $masterInfo = $master->getMasterInfo();

        //分配变量
        $this->assign('firstCate', $firstCate);
        $this->assign('recommendArt', $recommendArt);
        $this->assign('masterInfo', $masterInfo);
        //显示输出
        $this->display('index.html');
    }
}