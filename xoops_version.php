<?php
//  ------------------------------------------------------------------------ //
// 本模組由 aandd 製作
// 製作日期：2015-05-23
// $Id:$
// ------------------------------------------------------------------------- //

//---基本設定---//
//模組名稱
$modversion['name'] = _MI_AANDDACHIVE_NAME;
//模組版次
$modversion['version']	= '1.0';
//模組作者
$modversion['author'] = _MI_AANDDACHIVE_AUTHOR;
//模組說明
$modversion['description'] = _MI_AANDDACHIVE_DESC;
//模組授權者
$modversion['credits']	= _MI_AANDDACHIVE_CREDITS;
//模組版權
$modversion['license']		= "GPL see LICENSE";
//模組是否為官方發佈1，非官方0
$modversion['official']		= 0;
//模組圖示
$modversion['image']		= "images/logo.png";
//模組目錄名稱
$modversion['dirname']		= "aandd_achivement";

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "aandd_achivement";
$modversion['tables'][2] = "aandd_achivement_product";

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;
$modversion['sub'][2]['name'] =_MI_AANDDACHIVE_SMNAME2;
$modversion['sub'][2]['url'] = "product.php";
$modversion['sub'][3]['name'] =_MI_AANDDACHIVE_SMNAME3;
$modversion['sub'][3]['url'] = "share.php";


//---樣板設定---//

$modversion['templates'][1]['file'] = 'aandd_achivement_index_tpl.html';
$modversion['templates'][1]['description'] = _MI_AANDDACHIVE_TEMPLATE_DESC1;
$modversion['templates'][2]['file'] = 'aandd_achivement_product_tpl.html';
$modversion['templates'][2]['description'] = _MI_AANDDACHIVE_TEMPLATE_DESC2;
$modversion['templates'][3]['file'] = 'aandd_achivement_output_tpl.html';
$modversion['templates'][3]['description'] = _MI_AANDDACHIVE_TEMPLATE_DESC3;
//---區塊設定---//

?>