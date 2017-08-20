<?php
//  ------------------------------------------------------------------------ //
// 本模組由 aandd 製作
// 製作日期：2015-05-23
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
include_once "up_file.php";
$xoopsOption['template_main'] = "aandd_achivement_product_tpl.html";
/*-----------function區--------------*/

//aandd_achivement_product編輯表單
function aandd_achivement_product_form($product_sn=""){
	global $xoopsDB,$xoopsUser,$product_formarr;
	//include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
	//include_once(XOOPS_ROOT_PATH."/class/xoopseditor/xoopseditor.php");

	//抓取預設值
	if(!empty($product_sn)){
		$DBV=get_aandd_achivement_product($product_sn);
	}else{
		$DBV=array();
	}

	//預設值設定
	
	
	//設定「achivement_sn」欄位預設值
	$achivement_sn=(!isset($DBV['achivement_sn']))?$_GET['achivement_sn']:$DBV['achivement_sn'];
	
	//設定「product_sn」欄位預設值
	$product_sn=(!isset($DBV['product_sn']))?"":$DBV['product_sn'];
	
	//設定「product_title」欄位預設值
	$product_title=(!isset($DBV['product_title']))?"":$DBV['product_title'];
	
	//設定「product_content」欄位預設值
	$product_content=(!isset($DBV['product_content']))?"":$DBV['product_content'];
	
	//設定「product_point」欄位預設值
	$product_point=(!isset($DBV['product_point']))?"":$DBV['product_point'];
	
	//設定「product_date」欄位預設值
	$product_date=(!isset($DBV['product_date']))?date("Y-m-d"):$DBV['product_date'];
	
	//設定「product_who」欄位預設值
	$product_who=(!isset($DBV['product_who']))?"":$DBV['product_who'];
	
	//設定「product_create_date」欄位預設值
	$product_create_date=(!isset($DBV['product_create_date']))?date("Y-m-d"):$DBV['product_create_date'];
	
	//設定「product_think」欄位預設值
	$product_think=(!isset($DBV['product_think']))?"":$DBV['product_think'];
	
	//設定「product_form」欄位預設值
	$product_form=(!isset($DBV['product_form']))?"complete":$DBV['product_form'];
	
	//設定「product_enddate」欄位預設值
	$product_enddate=(!isset($DBV['product_enddate']))?date("Y-m-d"):$DBV['product_enddate'];

	$op=(empty($product_sn))?"insert_aandd_achivement_product":"update_aandd_achivement_product";
	//$op="replace_aandd_achivement_product";
	
	if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
   redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once TADTOOLS_PATH."/formValidator.php";
  $formValidator= new formValidator("#myForm",true);
  $formValidator_code=$formValidator->render();
	
	//取得評鑑成果資料
	$achivement_data=get_aandd_achivement($_GET['achivement_sn']);
	
	
	$main="
	$formValidator_code
	<a href='product.php?achivement_sn={$achivement_sn}'><h1>{$achivement_data['achivement_title']}</a> | 
	<a href='output.php?op=show_product&product_sn={$product_sn}' class='btn btn-success'>預覽</a> | 
	<a href='output.php?op=output_word&product_sn={$product_sn}' class=' btn btn-primary'>輸出WORD</a></h1>
	<script type='text/javascript' src='".TADTOOLS_URL."/My97DatePicker/WdatePicker.js'></script>
	<form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm' enctype='multipart/form-data'>
	<table class='table table-condensed table-hover table-striped table-bordered'>
  

	<!--成果序號-->
	<input type='hidden' name='achivement_sn' value='{$achivement_sn}'>

	<!--活動序號-->
	<input type='hidden' name='product_sn' value='{$product_sn}'>

	<!--活動標題-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_PRODUCT_TITLE."</td>
	<td class='col'><input type='text' name='product_title' size='50' value='{$product_title}' id='product_title' ></td></tr>";

	if(!file_exists(TADTOOLS_PATH."/fck.php")){
		redirect_header("index.php",3, _MA_NEED_TADTOOLS);
	}
	include_once TADTOOLS_PATH."/fck.php";
	$fck=new CKEditor("aandd_achivement","product_content",$product_content);
	$fck->setWidth(565);
	$fck->setHeight(300);
	$product_content_editor=$fck->render();
	//修成單純textarea
	$product_content_editor="<textarea style='width:500px;height:120px' name='product_content'>{$product_content}</textarea>";

	$main.="
	<!--活動內容-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_PRODUCT_CONTENT."</td>
	<td class='col'>{$product_content_editor}</td></tr>

	<!--活動地點-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_PRODUCT_POINT."</td>
	<td class='col'><input type='text' name='product_point' size='30' value='{$product_point}' id='product_point' ></td></tr>

	<!--活動日期-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_PRODUCT_DATE."</td>
	<td class='col'><input type='text' name='product_date' size='20' value='{$product_date}' id='product_date'   onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd' , startDate:'%y-%M-%d}'})\"></td></tr>
	
	<!--活動結束日期-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_PRODUCT_ENDDATE."</td>
	<td class='col'><input type='text' name='product_enddate' size='20' value='{$product_enddate}' id='product_enddate'   onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd' , startDate:'%y-%M-%d}'})\"></td></tr>

	<!--活動參加人員-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_PRODUCT_WHO."</td>
	<td class='col'><input type='text' name='product_who' size='20' value='{$product_who}' id='product_who' ></td></tr>

	<!--活動建立日期-->
	<input type='hidden' name='product_create_date' value='{$product_create_date}'>";

	if(!file_exists(TADTOOLS_PATH."/fck.php")){
		redirect_header("index.php",3, _MA_NEED_TADTOOLS);
	}
	include_once TADTOOLS_PATH."/fck.php";
	$fck=new CKEditor("aandd_achivement","product_think",$product_think);
	$fck->setWidth(565);
	$fck->setHeight(300);
	$product_think_editor=$fck->render();
	$product_think_editor="<textarea style='width:500px;height:120px' name='product_think'>{$product_think}</textarea>";
	$main.="
	<!--活動省思-->
	<tr><td class='title' nowrap>"._MA_AANDDACHIVE_PRODUCT_THINK."</td>
	<td class='col' colspan='2'>{$product_think_editor}</td></tr>

	<!--活動格式-->
	<tr><td class='title' nowrap>活動格式</td>
	<td class='col' colspan='2'>
	<select name='product_form' size=1 >
		".arrayToSelect($product_formarr,false,$product_form)."
	</select>
	</td></tr>
	
	
	<tr>
	<td class='col' colspan='2'>選擇上傳檔案：<input type='file' name='upfile[]' multiple>".list_DelAndModify_file($achivement_sn,$product_sn,true)."</td></tr>
	
	<tr><td class='bar' colspan='2'>
	<input type='hidden' name='op' value='{$op}'>
	<input type='submit' value='"._MA_SAVE."' class='btn btn-info'></td></tr>
	</table>
	</form>";
	

	//raised,corners,inset
	$main=div_3d(_MA_AANDD_ACHIVEMENT_PRODUCT_FORM,$main,"raised");
  
	return $main;
}



//新增資料到aandd_achivement_product中
function insert_aandd_achivement_product(){
	global $xoopsDB,$xoopsUser;
	

	$myts =& MyTextSanitizer::getInstance();
	$_POST['product_title']=$myts->addSlashes($_POST['product_title']);
	$_POST['product_content']=$myts->addSlashes($_POST['product_content']);
	$_POST['product_point']=$myts->addSlashes($_POST['product_point']);
	$_POST['product_who']=$myts->addSlashes($_POST['product_who']);
	$_POST['product_think']=$myts->addSlashes($_POST['product_think']);

  
	$sql = "insert into ".$xoopsDB->prefix("aandd_achivement_product")."
	(`achivement_sn` , `product_title` , `product_content` , `product_point` , `product_date` , `product_who` , `product_create_date` , `product_think` , `product_form` , `product_enddate`)
	values('{$_POST['achivement_sn']}' , '{$_POST['product_title']}' , '{$_POST['product_content']}' , '{$_POST['product_point']}' , '{$_POST['product_date']}' , '{$_POST['product_who']}' , '{$_POST['product_create_date']}' , '{$_POST['product_think']}' , '{$_POST['product_form']}' , '{$_POST['product_enddate']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	//取得最後新增資料的流水編號
	$product_sn=$xoopsDB->getInsertId();
	return $product_sn;
}

//更新aandd_achivement_product某一筆資料
function update_aandd_achivement_product($product_sn=""){
	global $xoopsDB,$xoopsUser;
	

	$myts =& MyTextSanitizer::getInstance();
	$_POST['product_title']=$myts->addSlashes($_POST['product_title']);
	$_POST['product_content']=$myts->addSlashes($_POST['product_content']);
	$_POST['product_point']=$myts->addSlashes($_POST['product_point']);
	$_POST['product_who']=$myts->addSlashes($_POST['product_who']);
	$_POST['product_think']=$myts->addSlashes($_POST['product_think']);

  
	$sql = "update ".$xoopsDB->prefix("aandd_achivement_product")." set 
	 `achivement_sn` = '{$_POST['achivement_sn']}' , 
	 `product_title` = '{$_POST['product_title']}' , 
	 `product_content` = '{$_POST['product_content']}' , 
	 `product_point` = '{$_POST['product_point']}' , 
	 `product_date` = '{$_POST['product_date']}' , 
	 `product_who` = '{$_POST['product_who']}' , 
	 `product_create_date` = '{$_POST['product_create_date']}' , 
	 `product_think` = '{$_POST['product_think']}' , 
	 `product_form` = '{$_POST['product_form']}' , 
	 `product_enddate` = '{$_POST['product_enddate']}'
	where product_sn='$product_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $product_sn;
}

//列出所有aandd_achivement_product資料
function list_aandd_achivement_product($show_function=1){
	global $xoopsDB,$xoopsModule;
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement_product")." where achivement_sn = '{$_GET['achivement_sn']}'";

	//getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
  $PageBar=getPageBar($sql,30,10);
  $bar=$PageBar['bar'];
  $sql=$PageBar['sql'];
  $total=$PageBar['total'];

	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	$function_title=($show_function)?"<th>"._BP_FUNCTION."</th>":"";
	
	$all_content="";
	
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $achivement_sn , $product_sn , $product_title , $product_content , $product_point , $product_date , $product_who , $product_create_date , $product_think , $product_form , $product_enddate
    foreach($all as $k=>$v){
      $$k=$v;
    }
    
		$fun=($show_function)?"
		<td>
		<a href='{$_SERVER['PHP_SELF']}?op=aandd_achivement_product_form&achivement_sn={$achivement_sn}&product_sn=$product_sn' class='btn btn-primary'>"._BP_EDIT."</a>
		<a href=\"javascript:delete_aandd_achivement_product_func($product_sn);\" class='btn btn-danger'>"._BP_DEL."</a>
		</td>":"";
		
		$all_content.="<tr>
		<td>{$achivement_sn}</td>
		<td>{$product_sn}</td>
		<td>{$product_title}</td>
		<td>{$product_point}</td>
		<td>{$product_date}</td>
		<td>{$product_who}</td>
		<td>{$product_create_date}</td>
		<td>{$product_form}</td>
		<td>{$product_enddate}</td>
		$fun
		</tr>";
	}

  //if(empty($all_content))return "";
  
  $add_button=($show_function)?"<a href='{$_SERVER['PHP_SELF']}?op=aandd_achivement_product_form&achivement_sn={$_GET['achivement_sn']}'  class='btn btn-warning'>"._BP_ADD."</a>":"";
	
	//取得評鑑成果資料
	$achivement_data=get_aandd_achivement($_GET['achivement_sn']);
	
	
	//刪除確認的JS
	$data="
	<script>
	function delete_aandd_achivement_product_func(product_sn){
		var sure = window.confirm('"._BP_DEL_CHK."');
		if (!sure)	return;
		location.href=\"{$_SERVER['PHP_SELF']}?op=delete_aandd_achivement_product&achivement_sn={$_GET['achivement_sn']}&product_sn=\" + product_sn;
	}
	</script>
	<a href='index.php' class='btn btn-info'>回評鑑列表</a>
	<h1>{$achivement_data['achivement_title']}</h1>
	<table class='table table-condensed table-hover table-striped table-bordered'>
	<tr>
	<th>"._MA_AANDDACHIVE_ACHIVEMENT_SN."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_SN."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_TITLE."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_POINT."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_DATE."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_WHO."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_CREATE_DATE."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_FORM."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_ENDDATE."</th>
	$function_title</tr>
	<tbody>
	$all_content
	<tr>
	<td colspan=12 class='bar'>
	$add_button
	{$bar}</td></tr>
	</tbody>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}


//以流水號取得某筆aandd_achivement_product資料
function get_aandd_achivement_product($product_sn=""){
	global $xoopsDB;
	if(empty($product_sn))return;
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement_product")." where product_sn='$product_sn'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//刪除aandd_achivement_product某筆資料資料
function delete_aandd_achivement_product($product_sn=""){
	global $xoopsDB;
	$sql = "delete from ".$xoopsDB->prefix("aandd_achivement_product")." where product_sn='$product_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//以流水號秀出某筆aandd_achivement_product資料內容
function show_one_aandd_achivement_product($product_sn=""){
	global $xoopsDB,$xoopsModule;
	if(empty($product_sn)){
		return;
	}else{
		$product_sn=intval($product_sn);
	}
	
  
	
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement_product")." where product_sn='{$product_sn}'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$all=$xoopsDB->fetchArray($result);
	
	//以下會產生這些變數： $achivement_sn , $product_sn , $product_title , $product_content , $product_point , $product_date , $product_who , $product_create_date , $product_think , $product_form , $product_enddate
	foreach($all as $k=>$v){
		$$k=$v;
	}
  
	$data="
	<table class='table table-condensed table-hover table-striped table-bordered'>
	<tr><th>"._MA_AANDDACHIVE_ACHIVEMENT_SN."</th><td>{$achivement_sn}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_SN."</th><td>{$product_sn}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_TITLE."</th><td>{$product_title}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_CONTENT."</th><td>{$product_content}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_POINT."</th><td>{$product_point}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_DATE."</th><td>{$product_date}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_WHO."</th><td>{$product_who}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_CREATE_DATE."</th><td>{$product_create_date}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_THINK."</th><td>{$product_think}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_FORM."</th><td>{$product_form}</td></tr>
	<tr><th>"._MA_AANDDACHIVE_PRODUCT_ENDDATE."</th><td>{$product_enddate}</td></tr>
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

	//ajax修改圖片description
function ajax_description($files_sn,$ajaxdescription){
	global $xoopsDB;
	$sql = "update ".$xoopsDB->prefix("aandd_achivement_files_center")." set `description`='{$ajaxdescription}' where `files_sn`='{$files_sn}'";
	//die($sql);
	 $result=$xoopsDB->queryF($sql) or die("修改資料失敗");
	 die("圖檔：".$files_sn."。內容：".$ajaxdescription);
}

function modify_file_desc($data=array()){
	global $xoopsDB;
	foreach($data as $k => $v){
		$sql = "update ".$xoopsDB->prefix("aandd_achivement_files_center")." set `description` = '{$v}'  where files_sn='$k'";
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	
	}
}


/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$achivement_sn=empty($_REQUEST['achivement_sn'])?"":intval($_REQUEST['achivement_sn']);
$product_sn=empty($_REQUEST['product_sn'])?"":intval($_REQUEST['product_sn']);

if(empty($xoopsUser)) redirect_header('index.php',3,'請先登入');
//檢查是否為擁有者，若不是導出
if(!empty($achivement_sn)){
	$achivement_dataarr=get_aandd_achivement($achivement_sn);
	$achivement_uid=$achivement_dataarr['achivement_uid'];
	$uid=$xoopsUser->uid();
	//die($uid);
	if($uid != $achivement_uid) redirect_header('index.php',3,"您不是評鑑建立者，請使用評鑑分享功能{$achivement_uid}");
}else{
	$product_dataarr=get_aandd_achivement_product($product_sn);
	$achivement_dataarr=get_aandd_achivement($product_dataarr['achivement_sn']);
	$achivement_uid=$achivement_dataarr['achivement_uid'];
	$uid=$xoopsUser->uid();
	if($uid != $achivement_uid) redirect_header('index.php',3,"您不是評鑑建立者，請使用評鑑分享功能{$achivement_uid}");
}



switch($op){
	//ajax修改圖片description
	case "ajax_description":
		//die($_POST['description']);
		ajax_description($_POST['file_sn'],$_POST['ajaxdescription']);
		die("圖檔：".$_POST['file_sn']."。內容：".$_POST['ajaxdescription']);
	break;
	
	//替換資料
	case "replace_aandd_achivement_product":
	replace_aandd_achivement_product();
	modify_file_desc($_POST['ajaxdescription']);
	upload_file($achivement_sn,$product_sn);
	header("location: {$_SERVER['PHP_SELF']}?op=aandd_achivement_product_form&product_sn={$product_sn}&achivement_sn={$achivement_sn}");
	break;

	//新增資料
	case "insert_aandd_achivement_product":
	$product_sn=insert_aandd_achivement_product();
	upload_file($achivement_sn,$product_sn);
	header("location: {$_SERVER['PHP_SELF']}?op=aandd_achivement_product_form&product_sn={$product_sn}&achivement_sn={$achivement_sn}");
	break;

	//更新資料
	case "update_aandd_achivement_product":
	update_aandd_achivement_product($product_sn);
	modify_file_desc($_POST['ajaxdescription']);
	upload_file($achivement_sn,$product_sn);
	header("location: {$_SERVER['PHP_SELF']}?op=aandd_achivement_product_form&product_sn={$product_sn}&achivement_sn={$achivement_sn}");
	break;

	//輸入表格
	case "aandd_achivement_product_form":
	$main=aandd_achivement_product_form($product_sn);
	break;

	//刪除資料
	case "delete_aandd_achivement_product":
	delete_aandd_achivement_product($product_sn);
	del_files("",$achivement_sn,$product_sn);
	header("location: {$_SERVER['PHP_SELF']}?achivement_sn={$achivement_sn}");
	break;

	//預設動作
	default:
	if(empty($product_sn)){
		$main=list_aandd_achivement_product();
		//$main.=aandd_achivement_product_form($product_sn);
	}else{
		$main=show_one_aandd_achivement_product($product_sn);
	}
	break;

}

/*-----------秀出結果區--------------*/
module_footer($main);
?>