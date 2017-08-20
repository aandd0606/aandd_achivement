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
function f1(){
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
	
		
	//產生綜合圖片
	$n=0;
	$totalphoto="";
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
		$m=0;
		foreach($desc as $kkk => $vvv){
			if($m%2 == 0) {
				$table->addRow(1000);
			}
			$table->addCell(5000)->addText($vvv,$fontStyle);
			$m++;
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

	default:
	$main=f1();
	break;
}

/*-----------秀出結果區--------------*/
module_footer($main);
?>