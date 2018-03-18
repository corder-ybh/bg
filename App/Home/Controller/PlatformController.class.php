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
}