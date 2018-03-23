<?php
/**
 * 前台用户控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/22
 * Time: 17:17
 */
class UserController extends PlatformController
{
    /**
     * 注册动作处理
     */
    public function registerAction()
    {
        //获取站长信息
        $master = Factory::M('MasterModel');
        $masterInfo = $master->getMasterInfo();
        //分配变量
        $this->assign('masterInfo', $masterInfo);
        //调用Article模型
        $article = Factory::M('ArticleModel');
        //获取最新文章列表
        $newArt = $article->getNewArt(8);
        //分配变量
        $this->assign('newArt', $newArt);
        //获取最热推荐文章列表
        $rmdArtByHits = $article->getRmdByHits(8);
        //分配变量
        $this->assign('rmdArtByHits', $rmdArtByHits);
        //显示输出视图文件
        $this->display('register.html');
    }

    /**
     * 处理会员注册动作
     */
    public function dealRegisterAction()
    {
        //接收数据
        $userInfo = array();
        $user_name = $this->escapeData($_POST['user_name']);
        $user_pass1 = trim($_POST['pass1']);
        $user_pass2 = trim($_POST['pass2']);
        //判断用户名或是否为空
        if (empty($user_name) || empty($user_pass1) || empty($user_pass2)) {
            $this->jump('index.php?p=Home&c=User&register', ':( 用户名或密码不能为空');
        }
        //两次密码应一致
        if ($user_pass1 !== $user_pass2) {
            $this->jump('index.php?p=Home&c=User&register', '两次密码不一致');
        }
        //判断用户名是否超出长度
        if (strlen($user_name) > 20) {
            $this->jump('index.php?p=Home&c=User&register', ':( 用户名长度超出范围');
        }

        //调用模型进行操作
        $user = Factory::M('UserModel');
        //判断用户名是否被占用
        if ($user->if_name_exists($user_name)) {
            //用户已存在
            $this->jump('index.php?p=Home&c=User&register', '用户名已被占用');
        }
        $userInfo['user_name'] = $user_name;
        $userInfo['user_pass'] = md5($user_pass1);
        //判断是否上传了头像
        if ($_FILES['user_image']['error'] != 4) {
            $upload = Factory::M('Upload');
            $allow = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
            $path = UPLOADS_DIR . 'user';
            //调用uploadAction
            if ($result = $upload->uploadAction($_FILES['user_image'], $allow, $path)) {
                $userInfo['user_image'] = $result;
            } else {
                //上传失败，记录错误信息并跳转
                $this->jump('index.php?p=Home&c=User&a=register', Upload::$error);
            }
        } else {
            $userInfo['user_image'] = 'default.jpg';
        }
        $userInfo['user_time'] = time();

        //调用模型，数据入库
        $result = $user->insertUser($userInfo);
        if ($result) {
            $this->jump('index.php?p=Home&c=User&a=Login', ':) 注册成功');
        } else {
            $this->jump('index.php?&p=Home&c=User&a=register', '发生错误，注册失败，请联系站长');
        }
    }

    /**
     * 显示会员登录表单动作
     */
    public function loginAction()
    {
        //调用MasterModel获取站长信息
        $master = Factory::M('MasterModel');
        $masterInfo = $master->getMasterInfo();
        //分配变量
        $this->assign('masterInfo', $masterInfo);
        //调用Article模型
        $article = Factory::M('ArticleModel');
        //获取最新文章列表
        $newArt = $article->getNewArt(8);
        $this->assign('newArt', $newArt);
        //获取最热文章列表
        $rmdArtByHits = $article->getRmdByHits(8);
        $this->assign('rmdArtByHits', $rmdArtByHits);

        //显示输出视图文件
        $this->display('login.html');
    }

    /**
     * 处理会员登录动作
     */
    public function dealLoginAction()
    {
        //接收数据
        $user_name = $this->escapeData($_POST['user_name']);
        $user_pass = trim($_POST['pass1']);
        if (empty($user_name) || empty($user_pass)) {
            $this->jump('index.php?p=Home&c=User*a=login', ':( 用户名或密码都不能为空');
        }
        //校验用户名和密码
        $user = Factory::M('UserModel');
        $result = $user->check($user_name, md5($user_pass));
        if ($result) {
            //将用户信息存储到session中
            @session_start();
            $_SESSION['user_info'] = $result;  //数组信息
            $this->jump('index.php?p=Home&c=index&a=index');
        } else {
            $this->jump('index.php?p=Home&c=User&a=login','用户名或密码错误');
        }
    }

    /**
     * logout用户退出动作
     */
    public function logoutAction()
    {
        unset($_SESSION['user_info']);
        session_destroy();
        $this->jump('index.php?p=Home&index&a=index');
    }
}