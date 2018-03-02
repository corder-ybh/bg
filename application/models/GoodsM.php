<?php
/**
 * 模型名随便起，所有的模型都继承自CI_Model,
 * 但是模型名不应该和控制器名一致，可以加一个M在最后进行标示，
 * C标示是控制器
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/1
 * Time: 11:55
 */
class GoodsM extends  CI_Model
{
    public function getAll() {
        echo 'all in goodsmodel';
    }
}