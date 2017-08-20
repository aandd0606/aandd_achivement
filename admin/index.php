<?php
//  ------------------------------------------------------------------------ //
// 本模組由 aandd 製作
// 製作日期：2015-05-23
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header_admin.php";

/*-----------function區--------------*/
//
function f1(){
	global $xoopsDB;
	$main="Hi~ admin~";
  return $main;
}

//
function f2(){
	$main="";
	return $main;
}


/*-----------執行動作判斷區----------*/
$op = empty($_REQUEST['op'])? "":$_REQUEST['op'];
$achivement_sn=empty($_REQUEST['achivement_sn'])?"":intval($_REQUEST['achivement_sn']);
$product_sn=empty($_REQUEST['product_sn'])?"":intval($_REQUEST['product_sn']);


switch($op){
	/*---判斷動作請貼在下方---*/
	
	case "f2":
	f2();
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	default:
	$main=f1();
	break;
	
	/*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
module_admin_footer($main,0);

?>