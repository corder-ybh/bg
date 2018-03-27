<?php
/**
 * 后台管理平台控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/6
 * Time: 9:45
 */
class ManageController extends PlatformController
{
    /**
     * 首页
     */
    public function indexAction()
    {
        $this->display('index.html');

    }
}