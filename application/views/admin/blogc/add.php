<?php $this->load->view('admin/top');?>
<div class="container clearfix">
    <?php $this->load->view('admin/menu');?>
    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/jscss/admin/design/">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/jscss/admin/design/">作品管理</a><span class="crumb-step">&gt;</span><span>新增作品</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?=site_url('admin/blogc/add')?>" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>标题：</th>
                                <td>
                                    <?php $error = form_error('title');?>
                                    <input <?php if ($error) echo 'style="border-color:#F00;"'?> class="common-text required" id="title" name="title" size="50" value="<?=set_value('title')?>" type="text">
                                    <span class="error"><?=form_error('title')?></span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>内容：</th>
                                <td>
                                    <?php $error = form_error('content') ?>
                                    <!-- <?php //if ($error)  echo 'style="border-color:#F00;"'?> style="width: 98%;" -->
                                    <textarea  name="content" class="common-textarea" id="content" cols="30" style="width: 98%;<?php if ($error)  echo 'border-color:#F00;"'?> " rows="10"><?=set_value('content')?></textarea>
                                    <span class="error"><?=form_error('content')?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>是否显示：</th>
                                <td>
                                    <input type="radio" name="is_show" value="是" checked="checked" />是
                                    <input type="radio" name="is_show" value="否" />否
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                    <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
</body>
</html>

<!--导入在线编辑器 -->
<script type="text/javascript" src="<?=_PUBLIC?>/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<link href="<?=_PUBLIC?>/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="<?=_PUBLIC?>/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?=_PUBLIC?>/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="<?=_PUBLIC?>/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script>
    UM.getEditor('content', {
        initialFrameWidth : "98%",
        initialFrameHeight : 350
    });
</script>