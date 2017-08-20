<?php
//  ------------------------------------------------------------------------ //
// 本模組由 aandd 製作
// 製作日期：2015-05-23
// $Id:$
// ------------------------------------------------------------------------- //
//引入TadTools的函式庫
if(!file_exists(TADTOOLS_PATH."/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once TADTOOLS_PATH."/tad_function.php";

$product_formarr=array(
	'complete'=>'完整',
	'simple'=>'簡易'	
);



/********************* 自訂函數 *********************/
/********************* 自訂函數 *********************/
function arrayToSelect($arr,$option=true,$default_val="",$use_v=false,$validate=false){
	if(empty($arr))return;
	$opt=($option)?"<option value=''>請選擇</option>\n":"";
	foreach($arr as $i=>$v){
		//false則以陣列索引值為選單的值，true則以陣列的值為選單的值
		$val=($use_v)?$v:$i;
		$selected=($val==$default_val)?'selected="selected"':"";        //設定預設值
		$validate_check=($validate)?"class='required'":"";
		$opt.="<option value='$val' $selected $validate_check>$v</option>\n";
	}
	return  $opt;
}

function arrayToRadio($arr,$use_v=false,$name="default",$default_val=""){
    	if(empty($arr))return;
    	$opt="";
    	foreach($arr as $i=>$v){
    		$val=($use_v)?$v:$i;
    		$checked=($val==$default_val)?"checked='checked'":"";
    		$opt.="<input type='radio' name='{$name}' id='{$val}' value='{$val}' $checked><label for='{$val}' style='display:inline;margin-right:15px;'> $v</label>";
    	}
    	return $opt;
}

function arrayToRadioBS2($arr,$use_v=false,$name="default",$default_val=""){
    	if(empty($arr))return;
    	$opt="";
    	foreach($arr as $i=>$v){
    		$val=($use_v)?$v:$i;
    		$checked=($val==$default_val)?"checked='checked'":"";
    		$opt.="<label class='radio inline'><input type='radio' name='{$name}' id='{$val}' value='{$val}' $checked>$v</label>";
    	}
    	return $opt;
}

function arrayToCheckbox($arr,$name,$default_val="",$use_v=false){
	//<input type="checkbox" name="option1" value="Milk">\
	$default_valarr=explode(",",$default_val);
	//die(var_dump($default_valarr));
	if(empty($arr))return;
	foreach($arr as $i=>$v){
		//false則以陣列索引值為選單的值，true則以陣列的值為選單的值
		$val=($use_v)?$v:$i;
		$selected=(in_array($val,$default_valarr))?"checked":"";        //設定預設值
		$opt.=" <label class='checkbox' for='stu_{$val}'><input type='checkbox' name='{$name}' value='{$val}' id='stu_{$val}' {$selected}>{$v}</label> ";
	}
	return  $opt;
}


/********************* 預設函數 *********************/
//圓角文字框
function div_3d($title="",$main="",$kind="raised",$style="",$other=""){
	$main="<table style='width:auto;{$style}'><tr><td>
	<div class='{$kind}'>
	<h1>$title</h1>
	$other
	<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
	<div class='boxcontent'>
 	$main
	</div>
	<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>
	</td></tr></table>";
	return $main;
}
?>