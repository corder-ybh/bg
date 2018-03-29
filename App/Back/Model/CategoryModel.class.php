<?php
/**
 * 后台bg_category分类表操作模型
 * Created by PhpStorm.
 * User: bhyang
 * Date: 2018/3/6
 * Time: 14:46
 */
class CategoryModel extends Model
{
    /**
     * 获取分类信息
     */
    public function getCategory()
    {
        $sql = "SELECT * FROM bg_category ORDER BY cate_sort ASC";
        $list = $this->dao->fetchAll($sql);
        return $this->getCateTree($list);
    }

    /**
     * 格式化分类列表，重新排序并树状展示
     * @param array $list 原始分类列表
     * @param int $pid 父类id号
     * @param int $level 缩进级别
     */
    private function getCateTree($list, $pid=0, $level=0)
    {
        // 定义静态数组变量用于存放格式化之后的数据
        static $cate_list = array();
        // 遍历
        foreach ($list as $row) {
            if ($row['cate_pid'] == $pid) {
                $row['level'] = $level;
                $cate_list[] = $row;
                //递归
                $this->getCateTree($list, $row['cate_id'], $level+1);
            }
        }
        // 返回遍历结果
        return $cate_list;
    }

    /**
     * 增加分类信息
     * @param $cate
     */
    public function insertCate($cate)
    {
        //通过数组得到多个变量
        extract($cate);
        $sql = "INSERT INTO bg_category VALUES(null, '$cate_name', $cate_pid, $cate_sort, '$cate_desc')";
        return $this->dao->my_query($sql);
    }

    /**
     * 通过cate_id获取到分类信息
     * @param $cate_id
     */
    public function getCateInfoById($cate_id)
    {
        $sql = "SELECT * FROM bg_category WHERE cate_id = $cate_id";
        return $this->dao->fetchRow($sql);
    }

    /**
     * 根据ID号修改分类信息
     * @param $cate
     */
    public function updateCateById($cate)
    {
        //通过数组得到多个变量
        extract($cate);
        $sql = "UPDATE bg_category SET cate_name='$cate_name', cate_pid=$cate_pid, 
            cate_sort=$cate_sort, cate_desc='$cate_desc' WHERE cate_id=$cate_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 根据ID删除分类信息
     * @param $cate_id
     * @return mixed
     */
    public function delCateById($cate_id)
    {
        $sql = "DELETE FROM bg_category WHERE cate_id = $cate_id";
        return $this->dao->my_query($sql);
    }

    /**
     * 批量删除分类信息
     * @param $cate_id
     * @return mixed
     */
    public function delAllCate($cate_id)
    {
        // 此时$cate_id是一个数组，需要先转换为字符串
        $cate_id = implode(',', $cate_id);
        $sql = "DELETE FROM bg_category WHERE cate_id in ($cate_id)";
        return $this->dao->my_query($sql);
    }
}