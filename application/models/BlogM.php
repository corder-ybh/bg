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

    /**
     * 翻页、搜索、排序功能
     */
    public function search($perpage = 5)
    {

        /*********** 搜索 -> 设置where条件到db上**************/
        //标题
        $title = $this->input->get('title');
        if ($title)
        {
            $this->db->like('title', $title);
        }
        //是否显示
        $isShow = $this->input->get('is_show');
        if ($isShow == '是' || $isShow == '否')
        {
            $this->db->where('is_show', $isShow);
        }

        //先设置将要操作的表名
        $this->db->from('blog_log');

        /*********** 翻页 **************/
        //在前面的where的基础上 获取总的记录数
        //【取出总记录数以后，默认就把前面设置的所有where条件清空了，会导致在后续代码中无法使用之前的where条件】
        //第二个参数的意思就是是否清空之前设置的where条件，此处设置为false
        $count = $this->db->count_all_results('', false);
        $this->load->library('pagination');
        //构造配置的数组
        $config['base_url'] = site_url('admin/blogc/lst');
        //配置总的记录数
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage;
        // 翻页时也传递其他的参数，保证搜索等相关的内容不会因为翻页而清空
        $config['reuse_query_string'] = true;
        //自定义首页末页
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['next_link'] = '下一页';
        $config['prev_link'] = '上一页';

        //根据配置数组配置翻页类
        $this->pagination->initialize($config);
        //生成翻页字符串
        $pageString = $this->pagination->create_links();
        //根据当前页计算偏移量,需要取出起始小于1的情况
        $offset = (max(1,(int)$this->pagination->cur_page)- 1) * $perpage;

        /*********** 排序 **************/
        $this->db->order_by('id', 'desc');

        /*********** 取出数据 **************/
        //取出日志中的数据
        $data = $this->db->get('', $perpage, $offset);

        /*********** 8 返回数据 **************/
        return array(
            'data' => $data,
            'page' => $pageString
        );
    }

    /**
     * @param $id
     * 删除日志
     */
    public function delete($id)
    {
        $this->db->delete('blog_log',array('id' => $id));
    }

    /**
     * @param $id
     * 获取某一条日志的信息
     */
    public function find($id)
    {
        $this->db->from('blog_log');
        $this->db->where('id', $id);
        $data = $this->db->get();
        //转化成二维数组
        $data = $data->result('array');
        return $data[0];
    }

    /**
     * @param $id
     * 根据id保存修改后的日志
     */
    public function save()
    {
        //设置修改的id
        $this->db->where('id', $this->input->post('id'));
        //构造数据
        $data = array(
            'title' => $this->input->post('title', true),
            'content' => $this->input->post('content',true),
            'is_show' => $this->input->post('is_show', true),
            'addtime' => date('Y-m-d H:i:s'),
        );
        //插入数据库
        $this->db->update('blog_log', $data);
    }
}