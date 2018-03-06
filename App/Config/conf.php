<?php
/**
 * 配置文件
 * User: bhyang
 * Date: 2018/3/5
 * Time: 10:53
 */
return array(
    //数据库配置信息
    'db' => array(
        'host' => '127.0.0.1',
        'port' => '3306',
        'user' => 'root',
        'pass' => 'root',
        'charset' => 'utf8',
        'dbname' => 'blog'
    ),

    //应用程序配置
    'App' => array(
        'default_platform' => 'Home',
        'dao' => 'pdo',//mysql 、 pdo
    ),

    //前台组
    'Home' => array(
        'default_controller' => 'Index',
        'default_action' => 'index'
    ),
    //后台组
    'Back' => array(
        'default_controller' => 'Admin',
        'default_action' => 'login'
    ),
    //测试平台组
    'Test' => array(
        'default_controller' => 'Stu',
        'default_action' => 'list'
    ),
    //验证码信息组
    'Captcha' => array(
        'width' => 80,
        'height' => 32,
        'pixelnum' => 0.03,  //干扰点密度
        'linenum' => 5,      //干扰先数量
        'stringnum' => 4,    //验证码字符个数
    ),
    //其他
);