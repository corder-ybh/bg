<?php

/**
 * 和学生相关的控制器
 */
class StuController extends Controller {
	/**
	 * 获取学生列表的动作
	 */
	public function listAction() {
		// 调用相应的model,获取学生列表数据
		// 通过工厂得到模型类的单例对象
		$m_stu = Factory::M('StuModel');
		$stu_list = $m_stu->getList();
		// 分配变量
		$this->assign('stu_list', $stu_list);
		// 调用模板并输出
		$this->display('stu_v.html');
	}
	/**
	 * 删除学生的动作
	 */
	public function removeAction() {
		$m_stu = Factory::M('StuModel');
		if($m_stu->remove($_GET['id'])) {
			$stu_list = $m_stu->getList(); // 继续获取新的列表信息
		}else {
			die("发生未知错误！");
		}
		// 分配变量
		$this->assign('stu_list', $stu_list);
		// 调用模板并输出
		$this->display('stu_v.html');
	}
}