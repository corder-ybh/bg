<?php
/* Smarty version 3.1.29, created on 2017-02-14 15:46:43
  from "D:\amp\apache\htdocs\test\v17\App\Test\View\Stu\stu_v.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a2b5e30a59f8_39076178',
  'file_dependency' => 
  array (
    '93003d61f729295cc161a3ec5ec2effb7df3d6f1' => 
    array (
      0 => 'D:\\amp\\apache\\htdocs\\test\\v17\\App\\Test\\View\\Stu\\stu_v.html',
      1 => 1487058399,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a2b5e30a59f8_39076178 ($_smarty_tpl) {
?>
<!-- 利用HTML展示结果 -->
<!DOCTYPE html>
<html>
<head>
	<title>学生表</title>
	<meta charset="utf-8">
</head>
<body>
	<table border="1" cellspacing="0">
		<tr>
			<th>学生ID</th>
			<th>姓名</th>
			<th>性别</th>
			<th>班级</th>
			<th>年龄</th>
			<th>家乡</th>
			<th>分数</th>
			<th>操作</th>
		</tr>
		<?php
$_from = $_smarty_tpl->tpl_vars['stu_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_student_0_saved_item = isset($_smarty_tpl->tpl_vars['student']) ? $_smarty_tpl->tpl_vars['student'] : false;
$_smarty_tpl->tpl_vars['student'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['student']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['student']->value) {
$_smarty_tpl->tpl_vars['student']->_loop = true;
$__foreach_student_0_saved_local_item = $_smarty_tpl->tpl_vars['student'];
?>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['student']->value['id'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['student']->value['name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['student']->value['gender'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['student']->value['class_id'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['student']->value['age'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['student']->value['home'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['student']->value['score'];?>
</td>
			<td><a href="index.php?p=Test&c=Stu&a=remove&id=<?php echo $_smarty_tpl->tpl_vars['student']->value['id'];?>
">删除</a></td>
		</tr>
		<?php
$_smarty_tpl->tpl_vars['student'] = $__foreach_student_0_saved_local_item;
}
if ($__foreach_student_0_saved_item) {
$_smarty_tpl->tpl_vars['student'] = $__foreach_student_0_saved_item;
}
?>
	</table>
	<p><a href="index.php?p=Test&c=Tea&a=list">查看教师列表</a></p>
</body>
</html><?php }
}
