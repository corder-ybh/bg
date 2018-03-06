<?php
/**
 * 后台的平台控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/6
 * Time: 11:45
 */
class PlatformController extends Controller
{
    /**
     * 判断后台管理员是否登陆，防止未授权访问
     */
    protected function checkLogin()
    {
        // 登录页面、生成验证码图片、验证是否登录、密码找回等操作是不需要进行验证的
        $no_need = array(
            // 控制器名=> 该控制器下不需要验证的动作列表
            'Admin' => array('login', 'check', 'captcha'),
        );
        if (isset($no_need[CONTROLLER]) && in_array(ACTION, $no_need[CONTROLLER])) {
            //说明当前控制器下的当前方法不需要验证
            return;
        }
        @session_start();
        if (!isset($_SESSION['adminInfo']))
        {
            //说明还没有登陆，跳转到登陆页面
            $this->jump('index.php?p=Back&c=Admin&a=login', ':( 请先登录！ ');
        }
    }

    /**
     * 构造方法
     */
    public function __construct()
    {
        //先显示调用父类构造方法
        parent::__construct();
        //判断后台管理员是否登陆，防止非法访问
        $this->checkLogin();
    }

}
