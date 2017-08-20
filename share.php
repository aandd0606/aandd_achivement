<?php
//  ------------------------------------------------------------------------ //
// 本模組由 aandd 製作
// 製作日期：2015-05-23
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
include_once("up_file.php");
$xoopsOption['template_main'] = "aandd_achivement_output_tpl.html";
/*-----------function區--------------*/

//
function list_(){
	$main="Hello World!";
	return $main;
}

//
function show_product($product_sn){
	global $xoopsDB,$xoopsUser;
	$product_dataarr=get_aandd_achivement_product($product_sn);
	foreach($product_dataarr as $k => $v){
		$$k=$v;
		//產生變數`achivement_sn`, `product_sn`, `product_title`, `product_content`, `product_point`, `product_date`, `product_who`, `product_create_date`, `product_think`, `product_form`, `product_enddate`
	}
	//取得所有圖片
	$allimg=get_file($achivement_sn,$product_sn);
	
	$main.="
	<table class='table table-condensed table-hover table-striped table-bordered'>
	<tr><td colspan=4><h1>{$product_title}</h1></td></tr>
	<tr><td>活動內容</td><td colspan=3>{$product_content}</td></tr>
	<tr><td>活動省思</td><td colspan=3>{$product_think}</td></tr>
	<tr><td>活動開始期間：</td><td>{$product_date}</td>
		<td>活動結束期間：</td><td>{$product_enddate}</td>
	</tr>
	<tr><td>參與人員：</td><td>{$product_who}</td>
		<td>活動地點：</td><td>{$product_point}</td>
	</tr>
	</table>
	";
	
	$product_dataarr=get_aandd_achivement_product($product_sn);
	//取得Product
	foreach($product_dataarr as $k => $v){
		$$k=$v;
		//產生變數`achivement_sn`, `product_sn`, `product_title`, `product_content`, `product_point`, `product_date`, `product_who`, `product_create_date`, `product_think`, `product_form`, `product_enddate`
	}
	
	//產生綜合圖片
	$n=0;
	$totalphoto="";
	if($product_form=="simple"){
		foreach($allimg as $k => $v){
			if($n>=4){
				continue;
			}
			if($n%2 == 0){
				$totalphoto.="<tr>";
			}
			$totalphoto.="<td>{$v['tb_show']}</td>";
			if($n%2 == 1){
				$totalphoto.="</tr>";
			}
			
			$n++;
		}	
	}else{
		foreach($allimg as $k => $v){
			if($n>=9){
				continue;
			}
			if($n%3 == 0){
				$totalphoto.="<tr>";
			}
			$totalphoto.="<td>{$v['tb_show']}</td>";
			if($n%3 == 2){
				$totalphoto.="</tr>";
			}
			
			$n++;
		}	
	}	


	$main.="
	<table class='table table-condensed table-hover table-striped table-bordered'>
	{$totalphoto}
	</table>
	";
	
	
	
	$main.="<table class='table table-condensed table-hover table-striped table-bordered'>";
	
	$n=0;
	$img="";
	$desc="";
	$all="";
	foreach($allimg as $k => $v){
		if($n%2 == 0) {
			$img.="<tr>";
			$desc.="<tr>";
		}
		$img.="<td colspan=2>{$v['tb_show']}</td>";
		$desc.="<td colspan=2>{$v['description']}</td>";
		if($n%2 == 1){
			$img.="</tr>";
			$desc.="</tr>";
			$all.=$img.$desc;
			$img="";
			$desc="";
		}
		

		$n++;
	}
	$main.=$all."</table>";
	return $main;
}

function output_word($product_sn){
	global $xoopsDB,$xoopsUser;
	require_once 'class/PHPWord/PHPWord.php';
	$product_dataarr=get_aandd_achivement_product($product_sn);
	//取得Product
	foreach($product_dataarr as $k => $v){
		$$k=$v;
		//產生變數`achivement_sn`, `product_sn`, `product_title`, `product_content`, `product_point`, `product_date`, `product_who`, `product_create_date`, `product_think`, `product_form`, `product_enddate`
	}
	//取得achivement
	$achivement_arr=get_aandd_achivement($achivement_sn);
	
	
	// New Word Document
	$PHPWord = new PHPWord();
	///成果格式設定
	$styleTable = array('borderSize'=>10, 'borderColor'=>'000000', 'cellMargin'=>80); 
	$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
	$imageStyle = array('width'=>280, 'height'=>180, 'align'=>'center');//成果圖片
	$imagesimpleStyle = array('width'=>560, 'height'=>360, 'align'=>'center');//成果圖片
	$imagethumStyle = array('width'=>200, 'height'=>100, 'align'=>'center');//第一頁縮圖圖片
	$imagesimplethumStyle = array('width'=>300, 'height'=>150, 'align'=>'center');//第一頁縮圖圖片
	$cellheaderStyle = array('valign'=>'center');//標題儲存格
	$cellStyle = array('valign'=>'center');//標題儲存格
	$footertextStyle = array('align'=>'right');//標題儲存格
	$fontStyle = array('bold'=>false,'align'=>'left','size'=>14,'color'=>'000000','spaceBefore'=>100);
	$tdtextfontStyle = array('bold'=>true,'align'=>'center','size'=>14,'color'=>'000000');
	$h1fontStyle = array('bold'=>true,'align'=>'center','size'=>20,'color'=>'000000');
	$tab='    ';
	
	//產生圖檔資料
	$allimg=get_file($achivement_sn,$product_sn);
	
	
	
	// New portrait section
	$section = $PHPWord->createSection();
	$section->addText($tab.$achivement_arr['achivement_title'],$h1fontStyle);
	// Add table
	$table = $section->addTable('myOwnTableStyle');
	$table->addRow(1400);
	$table->addCell(2000,$cellheaderStyle)->addText("評鑑項目",$tdtextfontStyle);
	$table->addCell(8000,$cellStyle)->addText($product_title,$h1fontStyle);
	$table->addRow(2200);
	$table->addCell(2000,$cellheaderStyle)->addText("活動內容",$tdtextfontStyle);
	$table->addCell(8000,$cellStyle)->addText($product_content,$fontStyle);
	$table->addRow(500);
	$table->addCell(2000,$cellheaderStyle)->addText("活動期間",$tdtextfontStyle);
	$table->addCell(8000,$cellStyle)->addText("{$product_date}~{$product_enddate}",$fontStyle);
	$table->addRow(500);
	$table->addCell(2000,$cellheaderStyle)->addText("活動地點",$tdtextfontStyle);
	$table->addCell(8000,$cellStyle)->addText($product_point,$fontStyle);
	$table->addRow(500);
	$table->addCell(2000,$cellheaderStyle)->addText("參加對象",$tdtextfontStyle);
	$table->addCell(8000,$cellStyle)->addText($product_who,$fontStyle);
	$table->addRow(2200);
	$table->addCell(2000,$cellheaderStyle)->addText("活動省思",$tdtextfontStyle);
	$table->addCell(8000,$cellStyle)->addText($product_think,$fontStyle);
	$section->addTextBreak(1);  
	$table = $section->addTable();
	
	if($product_form=='simple'){
		//產生綜合圖片
		$n=0;
		foreach($allimg as $k1 => $v1){
			if($n>=4){
				continue;
			}
			if($n%2 == 0){
				$table->addRow(2000);
			}
			$table->addCell(4000)->addImage(XOOPS_ROOT_PATH."/uploads/aandd_achivement/image/{$v1['file_name']}",$imagesimplethumStyle);
			//$table->addCell(10000)->addText($b);
			
			$n++;
		}
	
	
		$section->addPageBreak();
		$table = $section->addTable('myOwnTableStyle');
		$n=0;
		$img="";
		$desc=array();
		$all="";
		foreach($allimg as $k => $v){
			if($n==0){
				
			}
			$table->addRow(1000);
			$table->addCell(9000)->addImage(XOOPS_ROOT_PATH."/uploads/aandd_achivement/image/{$v['file_name']}",$imagesimpleStyle);
			$table->addRow(1000);
			$table->addCell(9000)->addText($v['description'],$fontStyle);
			$n++;
		}
	
	}else{
		//產生綜合圖片
		$n=0;
		foreach($allimg as $k1 => $v1){
			if($n>=9){
				continue;
			}
			if($n%3 == 0){
				$table->addRow(1500);
			}
			$table->addCell(3000)->addImage(XOOPS_ROOT_PATH."/uploads/aandd_achivement/image/{$v1['file_name']}",$imagethumStyle);
			//$table->addCell(10000)->addText($b);
			
			$n++;
		}
		$section->addPageBreak();
		$table = $section->addTable('myOwnTableStyle');
		$n=0;
		$img="";
		$desc=array();
		$all="";
		foreach($allimg as $k => $v){
			if($n%2 == 0) {
				if(!empty($desc)){
					$table->addRow(1000);
					foreach($desc as $kk => $vv){
						$table->addCell(5000)->addText($vv,$fontStyle);
					}
					unset($desc);
					
				}
				$table->addRow(3000);
			}
				$table->addCell(5000)->addImage(XOOPS_ROOT_PATH."/uploads/aandd_achivement/image/{$v['file_name']}",$imageStyle);
				$desc[]=$v['description'];
			$n++;
		}
		foreach($desc as $kkk => $vvv){
			$table->addRow(1000);
			$table->addCell(5000)->addText($vvv,$fontStyle);
		}
	}
	
	
	$footer = $section->createFooter();
	$footer->addPreserveText('地址：91142屏東縣竹田鄉西勢村光明路8之1號。電話：08-7793474',$footertextStyle);
	$header = $section->createHeader();
	$header->addPreserveText('屏東縣竹田鄉西勢國民小學~'.$achivement_arr['achivement_title']."_".$product_title);
	
	
	$filename=$achivement_sn."_".$product_sn.".docx";
	$realFileName=$achivement_arr['achivement_title']."_".$product_title.".docx";
	
	// Save File
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save($filename);
	
	
	header('Content-type:application/force-download'); //告訴瀏覽器 為下載 
	header('Content-Transfer-Encoding: Binary'); //編碼方式
	header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //編碼方式
	header('Content-Disposition:attachment;filename='.$realFileName); //檔名
	ob_clean();
	flush();
	readfile($filename);
	unlink($filename);
	exit;
	
}
//列出所有aandd_achivement資料
function list_aandd_achivement($show_function=1){
	global $xoopsDB,$xoopsModule,$xoopsUser;
	//if(empty($xoopsUser)) redirect_header('index.php',3,'請先登入');
	$uid=$xoopsUser->uid();
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement")." ORDER BY achivement_sn DESC";

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
		<a href='share.php?op=list_aandd_achivement_product&achivement_sn={$achivement_sn}' class='btn btn-info'>檢視成果</a>
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
  
  $add_button=($show_function)?"<a href='{$_SERVER['PHP_SELF']}?op=aandd_achivement_form'  class='btn btn-warning'>"._BP_ADD."</a>":"";
	
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
	{$bar}</td></tr>
	</tbody>
	</table>";
	
	//raised,corners,inset
	$main=div_3d("",$data,"corners");
	
	return $main;
}

//列出所有aandd_achivement_product資料
function list_aandd_achivement_product($show_function=1){
	global $xoopsDB,$xoopsModule,$product_formarr;
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
		<a href='{$_SERVER['PHP_SELF']}?op=show_product&product_sn=$product_sn' class='btn btn-success'>預覽</a>
		<a href='{$_SERVER['PHP_SELF']}?op=share_product_form&product_sn=$product_sn' class='btn btn-primary'>成果分享</a>
		</td>":"";
		
		$all_content.="<tr>
		<td>{$achivement_sn}</td>
		<td>{$product_sn}</td>
		<td>{$product_title}</td>
		<td>{$product_formarr[$product_form]}</td>
		<td>{$product_enddate}</td>
		$fun
		</tr>";
	}

  //if(empty($all_content))return "";
  
  $add_button=($show_function)?"<a href='{$_SERVER['PHP_SELF']}?op=aandd_achivement_product_form&achivement_sn={$_GET['achivement_sn']}'  class='btn btn-danger'>"._BP_ADD."</a>":"";
	
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
	<a href='index.php' class='btn btn-inverse'>回評鑑列表</a>
	<h1>{$achivement_data['achivement_title']}</h1>
	<table class='table table-condensed table-hover table-striped table-bordered'>
	<tr>
	<th>"._MA_AANDDACHIVE_ACHIVEMENT_SN."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_SN."</th>
	<th>"._MA_AANDDACHIVE_PRODUCT_TITLE."</th>
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

//分享成果到自己的評鑑
function share_product_form($product_sn=""){
	global $xoopsDB,$xoopsUser;
	$product_dataarr=get_aandd_achivement_product($product_sn);
	$uid=$xoopsUser->uid();
	//找出自己建立的評鑑
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement")." where achivement_uid='$uid' order by achivement_sn desc";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($all=$xoopsDB->fetchArray($result)){
		$achivement_titlearr[$all['achivement_sn']]=$all['achivement_title'];
	}
	$main="
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	<h1>複製【{$product_dataarr['product_title']}】</h1>
	以下請選擇您要複製過去的評鑑項目：<br>
	<select name='achivement_sn'>
	".arrayToSelect($achivement_titlearr)."
	</select>
	<input type='hidden' name='product_sn' value='{$product_sn}'>
	<input type='hidden' name='op' value='copy_product'><br>
	<input type='submit' value='複製成果' name='複製成果'>
	</form>
	";
	
	return $main;
}

function copy_product($product_sn="",$newachivement_sn=""){
	global $xoopsDB,$xoopsUser;
	//取得成果資料
	$product_dataarr=get_aandd_achivement_product($product_sn);
	
	foreach($product_dataarr as $k=>$v){
		$$k=$v;
	}
	//變數`achivement_sn`, `product_sn`, `product_title`, `product_content`, `product_point`, `product_date`, `product_who`, `product_create_date`, `product_think`, `product_form`, `product_enddate`
	
	//產生新的
	$sql="insert into ".$xoopsDB->prefix("aandd_achivement_product")." (`achivement_sn`, `product_title`, `product_content`, `product_point`, `product_date`, `product_who`, `product_create_date`, `product_think`, `product_form`, `product_enddate`) values ('{$newachivement_sn}','{$product_title}','{$product_content}','{$product_point}','{$product_date}','{$product_who}','{$product_create_date}','{$product_think}','{$product_form}','{$product_enddate}')";
	//die($sql);

	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	
	//die(var_dump($xoopsDB));
	//取得最後新增資料的流水編號
	$newproduct_sn=$xoopsDB->getInsertId();
	
	//新增圖片檔案的資料庫
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement_files_center")." where `col_name`='{$achivement_sn}' and `col_sn`='{$product_sn}' order by sort";
	//die($sql);


    $result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
    while($all=$xoopsDB->fetchArray($result)){
      //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
		foreach($all as $k=>$v){
			$$k=$v;
		}
		$ext = end(explode('.', $file_name));
		$newfilename="{$newachivement_sn}_{$newproduct_sn}_{$sort}.{$ext}";
		$sql="insert into ".$xoopsDB->prefix("aandd_achivement_files_center")." (`col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`) values ('{$newachivement_sn}','{$newproduct_sn}','{$sort}','{$kind}','{$newfilename}','{$file_type}','{$file_size}','{$description}','{$counter}')";
		$xoopsDB->queryF($sql);
		$filepath=XOOPS_ROOT_PATH."/uploads/aandd_achivement/image";
		$thumfilepath=XOOPS_ROOT_PATH."/uploads/aandd_achivement/image/.thumbs";
		
		if(!copy($filepath."/{$file_name}",$filepath."/{$newfilename}")){
			die("複製檔案失敗");
		};
		if(!copy($thumfilepath."/{$file_name}",$thumfilepath."/{$newfilename}")){
			die("複製縮圖檔案失敗");
		}
		
	}
	
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
//以流水號取得某筆aandd_achivement_product資料
function get_aandd_achivement_product($product_sn=""){
	global $xoopsDB;
	if(empty($product_sn))return;
	$sql = "select * from ".$xoopsDB->prefix("aandd_achivement_product")." where product_sn='$product_sn'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}


/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$achivement_sn=empty($_REQUEST['achivement_sn'])?"":intval($_REQUEST['achivement_sn']);
$product_sn=empty($_REQUEST['product_sn'])?"":intval($_REQUEST['product_sn']);


switch($op){
	case "output_word":
	output_word($product_sn);
	break;
	
	case "show_product":
	$main=show_product($product_sn);
	break;
	
	case "copy_product":
	copy_product($product_sn,$achivement_sn);
	break;
	
	case "share_product_form":
	$main=share_product_form($product_sn);
	break;
	
	case "list_aandd_achivement_product":
	$main=list_aandd_achivement_product($achivement_sn);
	break;
	
	default:
	$main=list_aandd_achivement();
	break;
}

/*-----------秀出結果區--------------*/
module_footer($main);
?>