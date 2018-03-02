CREATE  DATABASE blog;
USE blog;
SET NAMES utf8;
CREATE  TABLE blog_log (
    id mediumint unsigned NOT NULL auto_increment comment 'id',
    title VARCHAR(150) NOT NULL comment '日志名称',
    content longtext comment '内容',
    is_show enum('是','否') NOT NULL DEFAULT '是' comment '是否显示',
    addtime datetime NOT NULL comment '添加时间',
    logo VARCHAR(150) NOT NULL DEFAULT '' comment '',
    sm_logo VARCHAR(150) NOT NULL DEFAULT '' comment '',
    mid_logo VARCHAR(150) NOT NULL DEFAULT '' comment '',
    big_logo VARCHAR(150) NOT NULL DEFAULT '' comment '',
    mbig_logo VARCHAR(150) NOT NULL DEFAULT '' comment '',
    PRIMARY KEY (id)
) engine=InnoDB DEFAULT charset=utf8 comment '日志';