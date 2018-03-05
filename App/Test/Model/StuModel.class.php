<?php

/**
 * php_student表的操作模型
 */
class StuModel extends Model {
	/**
	 * 获得所有学生的列表
	 */
	public function getList() {
		// 获得学生列表数据
		$sql = "select * from php_student";
		return $this->dao->fetchAll($sql);
	}
	/**
	 * 删除某一个学生的记录
	 */
	public function remove($stu_id) {
		// 删除某个学生的记录
		$sql = "delete from php_student where id=$stu_id";
		return $this->dao->my_query($sql); // 返回布尔值
	}
}