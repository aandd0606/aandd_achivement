CREATE TABLE `aandd_achivement` (
  `achivement_sn` mediumint(9) unsigned NOT NULL auto_increment COMMENT '評鑑序號',
  `achivement_title` varchar(255) NOT NULL COMMENT '評鑑標題',
  `achivement_date` date NOT NULL COMMENT '評鑑日期',
  `achivement_uid` mediumint(9) unsigned NOT NULL COMMENT '擁有者',
  `achivement_status` varchar(255) NOT NULL COMMENT '狀態',
PRIMARY KEY (`achivement_sn`)
) ENGINE=MyISAM;

CREATE TABLE `aandd_achivement_product` (
  `achivement_sn` mediumint(9) unsigned NOT NULL COMMENT '成果序號',
  `product_sn` int(11) unsigned NOT NULL auto_increment COMMENT '活動序號',
  `product_title` varchar(255) NOT NULL COMMENT '活動標題',
  `product_content` text NOT NULL COMMENT '活動內容',
  `product_point` varchar(255) NOT NULL COMMENT '活動地點',
  `product_date` date NOT NULL COMMENT '活動日期',
  `product_who` varchar(255) NOT NULL COMMENT '活動參加人員',
  `product_create_date` date NOT NULL COMMENT '活動建立日期',
  `product_think` text NOT NULL COMMENT '活動省思',
  `product_form` enum('4','6') NOT NULL COMMENT '活動格式',
PRIMARY KEY (`product_sn`)
) ENGINE=MyISAM;

