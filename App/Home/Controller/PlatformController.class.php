<?php
/**
 * 前台平台控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/15
 * Time: 16:19
 */
class PlatformController extends Controller
{
    /**
     * 构造方法
     */
    public function __construct()
    {
        parent::__construct();
        $this->initFirstCateInfo();
        //初始化时完成关键字的设置
        $this->initVars();
    }

    /**
     * 分配导航条中的一级分类列表信息
     */
    public function initFirstCateInfo()
    {
        //调用Category模型
        $category = Factory::M('CategoryModel');
        //获取所有一级分类信息
        $firstCate = $category->getFirstCate();
        //分配变量
        $this->assign('firstCate', $firstCate);
    }

    /**
     * 分配meta标签公共数据
     */
    public function initVars()
    {
        $title = "bhy个人博客";
        $keywords = "个人博客,响应式";
        $description = "个人博客,技术博客";

        //分配变量
        $this->assign('title', $title);
        $this->assign('keywords', $keywords);
        $this->assign('description', $description);
    }
}