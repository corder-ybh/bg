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
    admin_id tinyint unsigned PRIMARY KEY AUTO_INCREMENT,
    admin_name VARCHAR(20) not NULL UNIQUE KEY ,
    admin_pass CHAR(32) NOT NULL ,
    login_ip VARCHAR(30) NOT NULL ,
    login_nums INT UNSIGNED NOT NULL DEFAULT 0,
    login_time INT UNSIGNED NOT NULL
);
INSERT INTO bg_admin(admin_name, admin_pass,login_ip,login_time)
    VALUE
    ('admin',md5('12345678'),'127.0.0.1',UNIX_TIMESTAMP());

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

#创建文章表
CREATE TABLE bg_article (
    art_id SMALLINT UNSIGNED PRIMARY KEY auto_increment,
    cate_id SMALLINT UNSIGNED NOT NULL COMMENT '文章所属分类',
    title VARCHAR(50) NOT NULL COMMENT '文章标题',
    thumb VARCHAR(100) NOT NULL DEFAULT 'default.jpg',
    art_desc VARCHAR(255) COMMENT '文章描述',
    content text NOT NULL COMMENT '文章内容',
    author VARCHAR(20) NOT NULL COMMENT '文章作者',
    hits SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击次数',
    addtime INT UNSIGNED NOT NULL COMMENT '添加时间',
    is_del enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除'
);

-- 文章表增加是否已推荐记录
ALTER TABLE bg_article add is_recommend enum('0','1') NOT NULL
DEFAULT '0' AFTER `addtime`;

-- 创建站长信息表
CREATE TABLE bg_master (
  id TINYINT PRIMARY KEY auto_increment,
  nickname VARCHAR(20) NOT NULL,
  job VARCHAR(50) NOT NULL,
  home VARCHAR(50) NOT NULL,
  tel char(11) NOT NULL,
  email VARCHAR(50) NOT NULL
);
INSERT INTO bg_master VALUES
(NULL,'站长','执剑人','星云|A区','123456789','2270933604@qq.com');

CREATE TABLE bg_singlePage(
  page_id TINYINT UNSIGNED PRIMARY KEY auto_increment,
  title VARCHAR(50) NOT NULL,
  content text
);

CREATE TABLE bg_user(
  user_id SMALLINT UNSIGNED PRIMARY KEY auto_increment,
  user_name VARCHAR(20) NOT NULL UNIQUE KEY,
  user_pass CHAR(32) NOT NULL,
  user_image VARCHAR(100) NOT NULL DEFAULT 'default.jpg',
  user_time INT UNSIGNED NOT NULL -- 注册时间
);