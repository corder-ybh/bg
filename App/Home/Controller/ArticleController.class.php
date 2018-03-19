<?php
/**
 * 前台文章管理控制器
 * Created by PhpStorm.
 * User: ybh
 * Date: 2018/3/17
 * Time: 12:41
 */
class ArticleController extends PlatformController
{
    /**
     * 栏目首页动作
     */
    public function indexAction()
    {
        //接收栏目编号(主类别编号)
        $cate_id = $_GET['cate_id'];
        //获取该栏目（主类别）下所有的文章信息
        $article = Factory::M('ArticleModel');
        $artInfo = $article->getArtInfo($cate_id);

        //分配变量
        $this->assign('artInfo', $artInfo);
        //增加分页功能
        //获取该分类下所有文章的总记录数
        $rowCount = $article->getRowCount($cate_id);
        $maxNum = $GLOBALS['conf']['Page']['maxNum'];
        $url = "index.php?p=Home&c=Article&a=index&cate_id=$cate_id&";
        //实例化分分业类
        $page = new Page(9, $rowCount, $maxNum, $url);
        //获取页码字符串
        $strPage = $page->getStrPage();
        //分配页码字符串
        $this->assign('strPage', $strPage);
        //分页到此结束
        //获取当前类别的一层子类别的信息
        $category = Factory::M('CategoryModel');
        $subCate = $category->getSubCateByPid($cate_id);
        //分配变量
        $this->assign('subCate', $subCate);
        //获取面包屑导航数组信息
        $list = $article->getAllCateName($cate_id);
        //分配变量
        $this->assign('list', $list);
        //获取当前分类下点击排行文章
        $sortByHits = $article->getSortByHits($cate_id, 9);
        $this->assign('sortByHits', $sortByHits);
        //获取当前分类下推荐文章
        $sortByRecommend = $article->getSortByRecommend($cate_id, 9);
        $this->assign('sortByRecommend', $sortByRecommend);

        //加载视图文件
        $this->display('index.html');
    }
}