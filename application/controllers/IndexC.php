<?php
/**
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/1
 * Time: 15:01
 * 控制器中get请求只传值不传名字
 * http://blog.com/index.php/indexC/index/tom/100
 */
class IndexC extends CI_Controller
{
    //设置默认值
    public  function index($name='', $age='') {
        $this->input->post('content', TRUE); //7、POST过滤xss攻击，第二个参数传true就是进行xss过滤
        //echo 'name:'.$name.' age'.$age;
        //生成商品模型，可以其别名，也可以不加别名
        $this->load->model('GoodsM','gm');
        $this->gm->getAll();
        /**
         * 9、所有的静态页面都放到views目录下，所有页面的后缀名都是.php
         * 9.1、静态页面放到views目录下即可，但是为了防止混淆，一个控制器一个目录
         * 9.2、控制器中显示静态页面，如果后缀名是html，则要加上后缀名，如果只是php，可以省略
         */
        //显示静态页面,向静态页面传值，显示直接使用php变量，【ci中没有模板标签】
        $this->load->view('indexC/add',array(
            'today' => date('Y-m-d H:i:s'),
            'title' => ' php',
        ));
        /**
         * 10、类库的自动加载，CI中提供了很多类库，这些类必须手动加载之后才能使用，但是有些
         * 类用的频率较高，如果每次再加载才能用有些麻烦，比如DB、SESSION等
         * 【延迟加载：只有要用时才加载】
         * 可以在配置文件中配置那些类自动加载进来，config/autoload.php
         * $autoload['libraries'] = array();中添加
         * $autoload['helper'] 辅助函数
         */
    }
}