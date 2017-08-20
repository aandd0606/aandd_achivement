<?php
//  ------------------------------------------------------------------------ //
// 本模組由 aandd 製作
// 製作日期：2015-05-23
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "aandd_achivement_index_tpl.html";
/*-----------function區--------------*/

//aandd_achivement編輯表單
function aandd_achivement_form($achivement_sn=""){
	global $xoopsDB,$xoopsUser;
	//include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
	//include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");

	//抓取預設值
	if(!empty($achivement_sn)){
		$DBV=get_aandd_achivement($achivement_sn);
	}else{
		$DBV=array();
	}

	//預設值設定
	
	
	//設定「achivement_sn」欄位預設值
	$achivement_sn=(!isset($DBV['achivement_sn']))?"":$DBV['achivement_sn'];
	
	//設定「achivement_title」欄位預設值
	$achivement_title=(!isset($DBV['achivement_title']))?"":$DBV['achivement_title'];
	
	//設定「achivement_date」欄位預設值
	$nowdate=date("Y-m-d");
	$achivement_date=(!isset($DBV['achivement_date']))?$nowdate:$DBV['achivement_date'];
	
	//設定「achivement_uid」欄位預設值
	if($xoopsUser){
		$uid=$xoopsUser->uid();
	}else{
		redirect_header($_SERVER['PHP_SELF'],3, "未登入");	
	}
	
	$achivement_uid=(!isset($DBV['achivement_uid']))?$uid:$DBV['achivement_uid'];
	
	//設定「achivement_status」欄位預設值
	$achivement_status=(!isset($DBV['achivement_status']))?"":$DBV['achivement_status'];

	$op=(empty($achivement_sn))?"insert_aandd_achivement":"update_aandd_achivement";
	//$op="replace_aandd_achivement";
	
	if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
   redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once TADTOOLS_PATH."/formValidator.php";
  $formValidator= new formValidator("#myForm",true);
  $formValidator_code=$formValidator->render();
	
	$main="
	$formValidator_code
	
	<form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm' enctype='multipart/form-data'>
	<table class='table table-condensed table-hover table-striped table-bordered'>
  

	<!--成果序號-->
	<input type='hidden' name='achivement_sn' value='{$achivement_sn}'>

	<!--成果標題-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_ACHIVEMENT_TITLE."</td>
	<td class='col'><input type='text' name='achivement_title' size='20' value='{$achivement_title}' id='achivement_title' ></td></tr>

	<!--擁有者-->
	<input type='hidden' name='achivement_uid' value='{$achivement_uid}'>
	<tr><td class='bar' colspan='2'>
	<input type='hidden' name='achivement_date' size='20' value='{$achivement_date}' id='achivement_date' >
	<input type='hidden' name='op' value='{$op}'>
	<input type='submit' value='"._MA_SAVE."'></td></tr>
	</table>
	</form>";

	//raised,corners,inset
	$main=div_3d(_MA_AANDD_ACHIVEMENT_FORM,$main,"raised");
  
	return $main;
}



//新增資料到aandd_achivement中
function insert_aandd_achivement(){
	global $xoopsDB,$xoopsUser;
	

	$myts =& MyTextSanitizer::getInstance();
	$_POST['achivement_title']=$myts->addSlashes($_POST['achivement_title']);
	$_POST['achivement_date']=$myts->addSlashes($_POST['achivement_date']);

  
	$sql = "insert into ".$xoopsDB->prefix("aandd_achivement")."
	(`achivement_title` , `achivement_date` , `achivement_uid` , `achivement_status`)
	values('{$_POST['achivement_title']}' , '{$_POST['achivement_date']}' , '{$_POST['achivement_uid']}' , '{$_POST['achivement_status']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	//取得最後新增資料的流水編號
	$achivement_sn=$xoopsDB->getInsertId();
	return $achivement_sn;
}

//更新aandd_achivement某一筆資料
function update_aandd_achivement($achivement_sn=""){
	global $xoopsDB,$xoopsUser;
	

	$myts =& MyTextSanitizer::getInstance();
	$_POST['achivement_title']=$myts->addSlashes($_POST['achivement_title']);
	$_POST['achivement_date']=$myts->addSlashes($_POST['achivement_date']);

  
	$sql = "update ".$xoopsDB->prefix("aandd_achivement")." set 
	 `achivement_title` = '{$_POST['achivement_title']}' , 
	 `achivement_date` = '{$_POST['achivement_date']}' , 
	 `achivement_uid` = '{$_POST['achivement_uid']}' , 
	 `achivement_status` = '{$_POST['achivement_status']}'
	where achivement_sn='$achivement_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $achivement_sn;
}

//列出所有aandd_achivement資料
function list_aandd_achivement($show_function=1){
	global $xoopsDB,$xoopsModule,$xoopsUser;
	//if(empty($xoopsUser)) redirect_header('index.php',3,'請先登入');
	$uid=$xoopsUser->uid();
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement")." WHERE `achivement_uid`='{$uid}' ORDER BY achivement_sn DESC";

	//getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
  $PageBar=getPageBar($sql,20,10);
  $bar=$PageBar['bar'];
  $sql=$PageBar['sql'];
  $total=$PageBar['total'];

	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	$function_title=($show_function)?"<th>"._BP_FUNCTION."</th>":"";
	
	$all_content="";
	
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $achivement_sn , $achivement_title , $achivement_date , $achivement_uid , $achivement_status
    foreach($all as $k=>$v){
      $$k=$v;
    }
    
		$fun=($show_function)?"
		<td>
		<a href='{$_SERVER['PHP_SELF']}?op=aandd_achivement_form&achivement_sn=$achivement_sn' class='btn btn-primary'>"._BP_EDIT."</a>
		<a href=\"javascript:delete_aandd_achivement_func($achivement_sn);\" class='btn btn-success'>"._BP_DEL."</a>
		<a href='product.php?achivement_sn={$achivement_sn}' class='btn btn-warning'>管理活動成果</a>
		</td>":"";
		
		$uid_name=XoopsUser::getUnameFromId($achivement_uid,1);
		if(empty($uid_name))$uid_name=XoopsUser::getUnameFromId($achivement_uid,0);
		
		$all_content.="<tr>
		<td>{$achivement_sn}</td>
		<td>{$achivement_title}</td>
		<td>{$achivement_date}</td>
		<td>{$uid_name}</td>
		<td>{$achivement_status}</td>
		$fun
		</tr>";
	}

  //if(empty($all_content))return "";
  
  $add_button=($show_function)?"<a href='{$_SERVER['PHP_SELF']}?op=aandd_achivement_form'  class='btn btn-danger'>"._BP_ADD."</a>":"";
	
	//刪除確認的JS
	$data="
	<script>
	function delete_aandd_achivement_func(achivement_sn){
		var sure = window.confirm('"._BP_DEL_CHK."');
		if (!sure)	return;
		location.href=\"{$_SERVER['PHP_SELF']}?op=delete_aandd_achivement&achivement_sn=\" + achivement_sn;
	}
	</script>

	<table class='table table-condensed table-hover table-striped table-bordered'>
	<tr>
	<th>"._MA_AANDDACHIVE_ACHIVEMENT_SN."</th>
	<th>"._MA_AANDDACHIVE_ACHIVEMENT_TITLE."</th>
	<th>"._MA_AANDDACHIVE_ACHIVEMENT_DATE."</th>
	<th>"._MA_AANDDACHIVE_ACHIVEMENT_UID."</th>
	<th>"._MA_AANDDACHIVE_ACHIVEMENT_STATUS."</th>
	$function_title</tr>
	<tbody>
	$all_content
	<tr>
	<td colspan=6 class='bar'>
	$add_button
	{$bar}</td></tr>
	</tbody>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}


//以流水號取得某筆aandd_achivement資料
function get_aandd_achivement($achivement_sn=""){
	global $xoopsDB;
	if(empty($achivement_sn))return;
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement")." where achivement_sn='$achivement_sn'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//刪除aandd_achivement某筆資料資料
function delete_aandd_achivement($achivement_sn=""){
	global $xoopsDB;
	$sql = "delete from ".$xoopsDB->prefix("aandd_achivement")." where achivement_sn='$achivement_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//以流水號秀出某筆aandd_achivement資料內容
function show_one_aandd_achivement($achivement_sn=""){
	global $xoopsDB,$xoopsModule;
	if(empty($achivement_sn)){
		return;
	}else{
		$achivement_sn=intval($achivement_sn);
	}
	
	
	
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement")." where achivement_sn='{$achivement_sn}' AND ";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$all=$xoopsDB->fetchArray($result);
	
	//以下會產生這些變數： $achivement_sn , $achivement_title , $achivement_date , $achivement_uid , $achivement_status
	foreach($all as $k=>$v){
		$$k=$v;
	}
  
	$data="
	<table class='table table-condensed table-hover table-striped table-bordered'>
	<tr><th>"._MA_AANDDACHIVE_ACHIVEMENT_SN."</th><td>{$achivement_sn}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_ACHIVEMENT_TITLE."</th><td>{$achivement_title}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_ACHIVEMENT_DATE."</th><td>{$achivement_date}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_ACHIVEMENT_UID."</th><td>{$achivement_uid}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_ACHIVEMENT_STATUS."</th><td>{$achivement_status}</td></tr>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}



/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$achivement_sn=empty($_REQUEST['achivement_sn'])?"":intval($_REQUEST['achivement_sn']);
$product_sn=empty($_REQUEST['product_sn'])?"":intval($_REQUEST['product_sn']);

//檢查是否為擁有者，若不是導出
//if(empty($xoopsUser)) redirect_header('index.php',3,'請先登入');
// if(!empty($achivement_sn)){
	// $achivement_dataarr=get_aandd_achivement($achivement_sn);
	// $achivement_uid=$achivement_dataarr['achivement_uid'];

	// $uid=$xoopsUser->uid();
	// if($uid != $achivement_uid) redirect_header('index.php',3,"您不是評鑑建立者，請使用評鑑分享功能{$achivement_uid}");
// }else{
	
// }

switch($op){
	//替換資料
	case "replace_aandd_achivement":
	replace_aandd_achivement();
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//新增資料
	case "insert_aandd_achivement":
	$achivement_sn=insert_aandd_achivement();
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//更新資料
	case "update_aandd_achivement":
	update_aandd_achivement($achivement_sn);
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//輸入表格
	case "aandd_achivement_form":
	$main=aandd_achivement_form($achivement_sn);
	break;

	//刪除資料
	case "delete_aandd_achivement":
	delete_aandd_achivement($achivement_sn);
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//預設動作
	default:
	if(empty($achivement_sn)){
		$main=list_aandd_achivement();
		//$main.=aandd_achivement_form($achivement_sn);
	}else{
		$main=show_one_aandd_achivement($achivement_sn);
	}
	break;

}

/*-----------秀出結果區--------------*/
module_footer($main);
?>