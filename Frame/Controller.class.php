<?php

/**
 * 基础控制类
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/5
 * Time: 14:54
 */
class Controller
{
    //定义一个属性，用于保存smarty对象
    protected $smarth;

    /**
     * 构造方法
     */
    public function __construct()
    {
        //初始化文件编码
        $this->initCode();
        //初始化Smarty
        $this->initSmarty();
    }

    /**
     * 初始化文件编码
     */
    protected function initCode()
    {
        header("Content-type:text/html;Charset=utf-8");
    }

    /**
     * 初始化Smarty
     */
    protected function initSmarty()
    {
        // 实例化Smarty
        $this->smarty = new Smarty;
        // 设置模板路径
        $this->smarty->setTemplateDir(CURRENT_VIEW_DIR . CONTROLLER . '/');
        // 设置编译文件路径
        $this->smarty->setCompileDir(APP_DIR . PLATFORM . 'View_c' . CONTROLLER . '/');
    }

    protected function assign($name, $value)
    {
        //调用smarty对象的assign方法
        $this->smarty->assign($name, $value);
    }

    protected function display($tpl)
    {
        //调用smarty对象的display方法
        $this->smarty->display($tpl);
    }
}