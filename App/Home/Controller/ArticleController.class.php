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
        /*
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
        */
        //调用公共模块
        $this->PublicAction($cate_id);
        //加载视图文件
        $this->display('index.html');
    }

    /**
     * 公共动作
     * @param $cate_id 分类id
     */
    public function PublicAction($cate_id)
    {
        //获取当前类别的一层子类别的信息
        $category = Factory::M('CategoryModel');
        $subCate = $category->getSubCateByPid($cate_id);
        //分配变量
        $this->assign('subCate', $subCate);
        //获取面包屑导航栏数组信息
        $article = Factory::M('ArticleModel');
        $list = $article->getAllCateName($cate_id);
        //分配变量
        $this->assign('list', $list);
        //获取当前分类下点击排行文章
        $sortByHits = $article->getSortByHits($cate_id, 9);
        $this->assign('sortByHits', $sortByHits);
        //获取当前分类下推荐文章
        $sortByRecommend = $article->getSortByRecommend($cate_id,9);
        $this->assign('sortByRecommend', $sortByRecommend);
    }

    /**
     * 显示文章内容的页动作
     */
    public function showAction()
    {
        //接受当前文章的id号
        $art_id = $_GET['art_id'];
        //调用模型，提取当前文章的信息
        $article = Factory::M('ArticleModel');
        //在获取文章信息之前更新浏览次数
        $article->updateHitsById($art_id);
        //通过id号获取文章信息
        $artInfoByid = $article->getArtInfoById($art_id);
        //分配变量
        $this->assign('artInfoById', $artInfoByid);
        //获取当前文章的分类ID号
        $cate_id = $artInfoByid['cate_id'];
        //调用公共动作
        $this->PublicAction($cate_id);
        //下一步，获取上一篇和下一篇，不能直接id+1，因为文章可能被删除，而应该>$art_id order by art_id limit 1
        $prev = $article->getPrevArt($art_id, $cate_id);
        $next = $article->getNextArt($art_id, $cate_id);
        $this->assign('prev', $prev);
        $this->assign('next', $next);
        //标题
        $this->assign('title', $artInfoByid['title']);

        //输出视图
        $this->display('show.html');
    }
}