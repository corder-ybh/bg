<?php
/**
 * 后台管理员控制器 登陆、注销、管理员增删改查等
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/5
 * Time: 16:38
 */
class AdminController extends PlatformController
{
    /**
     * 展示登陆表单动作
     */
    public function loginAction()
    {
        $this->display('login.html');
    }

    /**
     * 验证管理员的合法性
     */
    public function checkAction()
    {
        // 接收表单数据，账户名防止sql注入
        $admin_name = $this->escapeData($_POST['admin_name']);
        $admin_pass = $_POST['admin_pass'];
        //接收验证码表单数据
        $passcode = trim($_POST['passcode']);

        //先进行验证码的验证
        $captcha = Factory::M('Captcha');
        if (!$captcha->checkCaptcha($passcode)) {
            //验证码非法，跳回
            $this->jump('index.php?p=Back&c=Admin&a=login', ':( 验证码错误！ ');
        }

        // 从数据库中验证管理员的合法性
        // 实例化模型
        $admin = Factory::M('AdminModel');
        if ($row = $admin->check($admin_name, $admin_pass)){
            //如果合法，那么把信息放到session中
            //echo "验证合法，跳转到后台页面";
            @session_start();    //确定开启session机制
            $_SESSION['adminInfo'] = $row;
            // 更新当前管理员信息
            $admin->updateAdminInfo($row['admin_id']);
            //直接跳转到后台管理页面
            $this->jump('index.php?p=Back&c=Manage&a=index');
        } else {
            //验证失败，提示后跳转到登陆页面
            $this->jump('index.php?p=Back&c=Admin&a=login', ':( 用户名或密码错误！ ');
        }
    }

    /**
     * 生成验证码的动作
     */
    public function captchaAction()
    {
        // 1、实例化验证码类
        $captcha = Factory::M('Captcha');
        $captcha->generate();
    }

    /**
     * 注销操作
     */
    public function logoutAction()
    {
        @session_start();
        // 删除相关会话数据
        unset($_SESSION['adminInfo']);
        // 删除会话数据区
        session_destroy();
        // 立即跳转到登陆页面
        $this->jump('index.php?p=Back&c=Admin&a=login');
    }

}