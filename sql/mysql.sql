CREATE TABLE `aandd_achivement` (
`achivement_sn` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '成果序號',
  `achivement_title` varchar(255) NOT NULL COMMENT '成果標題',
  `achivement_date` date NOT NULL COMMENT '成果日期',
  `achivement_uid` mediumint(9) unsigned NOT NULL COMMENT '擁有者',
  `achivement_status` varchar(255) NOT NULL COMMENT '狀態',
  PRIMARY KEY (`achivement_sn`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;

CREATE TABLE `aandd_achivement_files_center` (
  `files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
  `col_name` varchar(255) NOT NULL COMMENT '欄位名稱',
  `col_sn` smallint(5) unsigned NOT NULL COMMENT '欄位編號',
  `sort` smallint(5) unsigned NOT NULL COMMENT '排序',
  `kind` enum('img','file') NOT NULL COMMENT '檔案種類',
  `file_name` varchar(255) NOT NULL COMMENT '檔案名稱',
  `file_type` varchar(255) NOT NULL COMMENT '檔案類型',
  `file_size` int(10) unsigned NOT NULL COMMENT '檔案大小',
  `description` text NOT NULL COMMENT '檔案說明',
  `counter` mediumint(8) unsigned NOT NULL COMMENT '下載人次',
  PRIMARY KEY (`files_sn`)
) ENGINE=MyISAM COMMENT='檔案資料表';

CREATE TABLE `aandd_achivement_product` (
  `achivement_sn` mediumint(9) unsigned NOT NULL  COMMENT '成果序號',
`product_sn` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '活動序號',
  `product_title` varchar(255) NOT NULL COMMENT '活動標題',
  `product_content` text NOT NULL COMMENT '活動內容',
  `product_point` varchar(255) NOT NULL COMMENT '活動地點',
  `product_date` date NOT NULL COMMENT '活動日期',
  `product_who` varchar(255) NOT NULL COMMENT '活動參加人員',
  `product_create_date` date NOT NULL COMMENT '活動建立日期',
  `product_think` text NOT NULL COMMENT '活動省思',
  `product_form` enum('simple','complete') NOT NULL DEFAULT 'complete' COMMENT '活動格式',
  `product_enddate` date NOT NULL,
  PRIMARY KEY (`product_sn`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;