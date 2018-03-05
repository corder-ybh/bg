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
        'default_platform' => 'Test',
        'dao' => 'pdo',//mysql 、 pdo
    ),

    //前台组
    'Home' => array(

    ),
    //后台组
    'Back' => array(

    ),
    //测试平台组
    'Test' => array(
        'default_controller' => 'Stu',
        'default_action' => 'list'
    ),
    //其他
);