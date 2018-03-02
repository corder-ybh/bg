<?php
/**
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/1
 * Time: 16:06
 */

class IndexC extends CI_Controller
{
    public function index()
    {
        $this->load->view('admin/indexc/index');
    }
}