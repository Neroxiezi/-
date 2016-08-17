-- 分类表
-- 0 代表不显示 1代表显示
create table if not exists `category`(
	`id` int auto_increment primary key,
	`name` char(32) not null,
	`pid` int not null default 0,
	`path` varchar(255) not null default '0,',
	`status` tinyint not null default 1,
	`addtime` int not null 
)engine=InnoDB default charset=utf8;
