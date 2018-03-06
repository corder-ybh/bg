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

#后台管理员表
CREATE TABLE bg_admin(
    admin_id tinyint unsigned
)

-- 创建分类表
CREATE TABLE bg_category(
    cate_id SMALLINT UNSIGNED PRIMARY KEY auto_increment,
    cate_name VARCHAR(20) NOT NULL,
    cate_pid SMALLINT UNSIGNED NOT NULL COMMENT '父类ID',
    cate_sort SMALLINT NOT NULL COMMENT '分类排序',
    cate_desc VARCHAR(255) COMMENT '分类描述'
);
-- 插入测试数据
INSERT INTO blog.bg_category VALUES
    (1,'慢生活',0,1,'慢生活有益健康'),
    (2,'日记',1,1,'点点滴滴'),
    (3,'欣赏',1,2,'走走停停'),
    (4,'程序人生',1,3,'写需求'),
    (5,'经典语录',1,4,'假鸡汤'),
    (6,'PHP课堂',0,2,'PHP很好用'),
    (7,'HTML',6,1,'还不是很懂');