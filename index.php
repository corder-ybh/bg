<?php
/**
 * 引入项目初始化框架类
 * User: bhyang
 * Date: 2018/3/5
 * Time: 10:39
 */
//防止非法入侵，方法1、在index入口文件中定义一个常量，每个文件都验证是否有该常量
//2、使用.htaccess文件进行限制，Deny from All
define('ABCDEF', true);
include'./Frame/Frame.class.php';
//调用run方法
Frame::run();