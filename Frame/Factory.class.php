<?php
/**
 * 项目中的单例工厂
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/5
 * Time: 15:01
 */
class Factory
{
    /**
     * 生成模型类的单例对象
     * @param $class_name
     */
    public static function M($class_name)
    {
        // 定义静态变量，用于保存已经实例化好了的对象列表
        // 下标时类名，值时类的对象
        static $model_list = array();
        if (!isset($model_list[$class_name])) {
            //没有实例化
            $model_list[$class_name] = new $class_name;//可变类
        }
        return $model_list[$class_name];
    }

}