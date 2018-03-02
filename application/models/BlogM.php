<?php
/**
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/1
 * Time: 16:54
 */

class BlogM extends CI_Model
{
    public function add()
    {
        //1、构造数据
        $data = array(
            'title' => $this->input->post('title',true),
            'content' => $this->input->post('content',true),//过滤xss攻击
            'is_show' => $this->input->post('is_show'),
            'addtime' => date('Y-m-d H:i:s'),
        );
        //2、插入数据库
        $this->db->insert('blog_log',$data);
    }

    public function query() {
        $data = 'null';
        $data = $this->db->query('select * from blog_log');
        return $data;
    }
}