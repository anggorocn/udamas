<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: string.func.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle string operation
***************************************************************************************************** */



/* fungsi untuk mengatur tampilan mata uang
 * $value = string
 * $digit = pengelompokan setiap berapa digit, default : 3
 * $symbol = menampilkan simbol mata uang (Rupiah), default : false
 * $minusToBracket = beri tanda kurung pada nilai negatif, default : true
 */
function array_change_key_case_recursive_upper($arr)
{
	return array_map(function($item){
	  if(is_array($item))
	    $item = array_change_key_case_recursive_upper($item);
	  return $item;
	},array_change_key_case($arr,CASE_UPPER));
}

function multi_array_search($array, $search)
{
    $result = array();

    foreach ($array as $key => $val)
    {
        foreach ($search as $k => $v)
        {
            // We check if the $k has an operator.
            $operator = '=';
            if (preg_match('(<|<=|>|>=|!=|=)', $k, $m) === 1)
            {
                // We change the operator.
                $operator = $m[0];

                // We trim $k to remove white spaces before and after.
                $k = trim(str_replace($m[0], '', $k));
            }

            switch ($operator)
            {
                case '=':
                    $cond = ($val[$k] != $v);
                    break;

                case '!=':
                    $cond = ($val[$k] == $v);
                    break;

                case '>':
                    $cond = ($val[$k] <= $v);
                    break;

                case '<':
                    $cond = ($val[$k] >= $v);
                    break;

                case '>=':
                    $cond = ($val[$k] < $sv);
                    break;

                case '<=':
                    $cond = ($val[$k] > $sv);
                    break;
            }

            if (( ! isset($val[$k]) && $val[$k] !== null) OR $cond)
            {
                continue 2;
            }
        }

        $result[] = $val ;
    }

    return $result;
}  
function currencyToPage($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
/*
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = "Rp ".$resValue.",-";
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
*/
    if($value == "")
		$value = 0;
	$rupiah = number_format($value,0, ",",".");
    $rupiah = "Rp. ". $rupiah . ",-";
    return $rupiah;
}
function setLebihNol($input) {
	if($input > 0){}
	else
	$input= 0;
	
	return $input;
}

function coalesce($varAwal, $varPengganti)
{
	if($varAwal == "")
		return 	$varPengganti;
	
	return $varAwal;
}

function displayNone($value)
{
	$value = '<div style="display:none">'.$value.'</div>';	
	return $value;
}


function khan_number($number, $num=2)
{
	$number = str_replace(",", ".", $number);
	if ($number=='' || $number==null)
	return '';
	else{
		if(substr_count($number,',')>0||substr_count($number,'.')>0)
		return number_format($number, $num, ',' , '.');
		else return number_format($number, 0, ',' , '.' );
	}
}

function nomorDigit($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arrValue = explode(".", $value);
	$value = $arrValue[0];
	if(count($arrValue) == 1)
		$belakang_koma = "";
	else
		$belakang_koma = $arrValue[1];
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($belakang_koma == "")
		$resValue = $symbol." ".$resValue;
	else
		$resValue = $symbol." ".$resValue.",".$belakang_koma;
	
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function numberToIna($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	
	if(substr($resValue, 0, 1) == ',')
		$resValue = '0'.$resValue;	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function numberToInaRight($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$novalue = false;
	
	if($value == "")
		$novalue = true;
	
	$arr_value = explode(",", $value);
	//$arr_value = explode($dec_sep, $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	
	if($resValue == "" && $novalue == false)
		$resValue = "0";
		
	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	

	
	$resValue = "<div align=\"right\">".$resValue."</span>";

	return $resValue;
}

function dotToComma($varId)
{
	$newId = str_replace(",", ".", $varId);	
	//$newId = str_replace(".", ",", $varId);	
	return $newId;
}

function commaToDot($varId)
{
	$newId = str_replace(",", ".", $varId);	
	return $newId;
}

function CommaToQuery($varId)
{
	$newId = str_replace(",", "','", $varId);	
	return $newId;
}

function dotToNo($varId)
{
	$newId = str_replace(".", "", $varId);	
	return $newId;
}


function numberToQuery($varId)
{
	$newId = dotToNo($varId);
	$newId = dotToComma($newId);
	
	return $newId;
}

function CommaToNo($varId)
{
	$newId = str_replace(",", "", $varId);	
	return $newId;
}

function CrashToNo($varId)
{
	$newId = str_replace("#", "", $varId);	
	return $newId;
}

function StarToNo($varId)
{
	$newId = str_replace("* ", "", $varId);	
	return $newId;
}

function NullDotToNo($varId)
{
	$newId = str_replace(".00", "", $varId);
	return $newId;
}

function ExcelToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = StarToNo($newId);
	return $newId;
}


function getFotoProfile($id)
{
	$filename = "uploads/profil/profile-".$id.".jpg";
	if (file_exists($filename)) {
	} else {
		$filename = "images/foto-profile.png";
	}	
	return $filename;
}

function ValToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = CommaToNo($newId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNull($varId)
{
	if($varId == '')
		return 0;
	else
		return $varId;
}

function ValToNullDB($varId)
{
	if($varId == '')
		return 'null';
	else
		return $varId;
}
// fungsi untuk generate nol untuk melengkapi digit

function generateZero($varId, $digitGroup, $digitCompletor = "0")
{
	$newId = "";
	
	$lengthZero = $digitGroup - strlen($varId);
	
	for($i = 0; $i < $lengthZero; $i++)
	{
		$newId .= $digitCompletor;
	}
	
	$newId = $newId.$varId;
	
	return $newId;
}

// truncate text into desired word counts.
// to support dropDirtyHtml function, include default.func.php
function truncate($text, $limit, $dropDirtyHtml=true)
{
	$tmp_truncate = array();
	$text = str_replace("&nbsp;", " ", $text);
	$tmp = explode(" ", $text);
	
	for($i = 0; $i <= $limit; $i++)		//truncate how many words?
	{
		$tmp_truncate[$i] = $tmp[$i];
	}
	
	$truncated = implode(" ", $tmp_truncate);
	
	if ($dropDirtyHtml == true and function_exists('dropAllHtml'))
		return dropAllHtml($truncated);
	else
		return $truncated;
}

function arrayMultiCount($array, $field_name, $search)
{
	$summary = 0;
	for($i = 0; $i < count($array); $i++)
	{
		if($array[$i][$field_name] == $search)
			$summary += 1;
	}
	return $summary;
}

function getValueArray($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= $var[$i];
		else
			$tmp .= ",".$var[$i];
	}
	
	return $tmp;
}

function getValueArrayMonth($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= "'".$var[$i]."'";
		else
			$tmp .= ", '".$var[$i]."'";
	}
	
	return $tmp;
}

function getColoms($var)
{
	$tmp = "";
	if($var == 0)	$tmp = 'D';
	elseif($var == 1)	$tmp = 'E';
	elseif($var == 2)	$tmp = 'F';
	elseif($var == 3)	$tmp = 'G';
	elseif($var == 4)	$tmp = 'H';
	elseif($var == 5)	$tmp = 'I';
	elseif($var == 6)	$tmp = 'J';
	elseif($var == 7)	$tmp = 'K';
	elseif($var == 8)	$tmp = 'L';
	elseif($var == 9)	$tmp = 'M';
	elseif($var == 10)	$tmp = 'N';
	elseif($var == 11)	$tmp = 'O';
	elseif($var == 12)	$tmp = 'P';
	elseif($var == 13)	$tmp = 'Q';
	elseif($var == 14)	$tmp = 'R';
	elseif($var == 15)	$tmp = 'S';
	elseif($var == 16)	$tmp = 'T';
	elseif($var == 17)	$tmp = 'U';
	elseif($var == 18)	$tmp = 'V';
	elseif($var == 19)	$tmp = 'W';
	
	return $tmp;
}

function getAbjad($number) {
	$arrMonth = array("1"=>"a", "2"=>"b", "3"=>"c", "4"=>"d", "5"=>"e", 
					  "6"=>"f", "7"=>"g", "8"=>"h", "9"=>"i", "10"=>"j", 
					  "11"=>"k", "12"=>"l");
	return $arrMonth[$number];
}
	
function in_array_column($text, $column, $array)
{
    if (!empty($array) && is_array($array))
    {
        for ($i=0; $i < count($array); $i++)
        {
            if ($array[$i][$column]==$text || strcmp($array[$i][$column],$text)==0) 
				$arr[] = $i;
        }
		return $arr;
    }
    return "";
}

function search_array($array, $find)
{
    if (!empty($array) && is_array($array))
    {
        for ($i=0; $i < count($array); $i++)
        {
            if (trim($array[$i]) == trim($find)) 
				return true;
        }
		return false;
    }
    return false;
}

function getTerbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return getTerbilang($x - 10) . " belas";
  elseif ($x < 100)
    return getTerbilang($x / 10) . " puluh" . getTerbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . getTerbilang($x - 100);
  elseif ($x < 1000)
    return getTerbilang($x / 100) . " ratus" . getTerbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . getTerbilang($x - 1000);
  elseif ($x < 1000000)
    return getTerbilang($x / 1000) . " ribu" . getTerbilang($x % 1000);
  elseif ($x < 1000000000)
    return getTerbilang($x / 1000000) . " juta" . getTerbilang($x % 1000000);
}

function getExe($tipe)
{
	switch ($tipe) {
	  case "application/pdf": $ctype="pdf"; break;
	  case "application/octet-stream": $ctype="exe"; break;
	  case "application/zip": $ctype="zip"; break;
	  case "application/msword": $ctype="doc"; break;
	  case "application/vnd.ms-excel": $ctype="xls"; break;
	  case "application/vnd.ms-powerpoint": $ctype="ppt"; break;
	  case "image/gif": $ctype="gif"; break;
	  case "image/png": $ctype="png"; break;
	  case "image/jpeg": $ctype="jpeg"; break;
	  case "image/jpg": $ctype="jpg"; break;
	  case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": $ctype="xlsx"; break;
	  case "application/vnd.openxmlformats-officedocument.wordprocessingml.document": $ctype="docx"; break;
	  default: $ctype="application/force-download";
	} 
	
	return $ctype;
}

function getExtension($varSource)
{
	$temp = explode(".", $varSource);
	return end($temp);
}

function ratingStar($value)
{
	if($value == 1)
		return "<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate-disabled.png\"> 
				<img src=\"images/icon-rate-disabled.png\">
				<img src=\"images/icon-rate-disabled.png\">
				<img src=\"images/icon-rate-disabled.png\">";
	elseif($value == 2)
		return "<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate-disabled.png\">
				<img src=\"images/icon-rate-disabled.png\">
				<img src=\"images/icon-rate-disabled.png\">";	
	elseif($value == 3)
		return "<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate.png\">
				<img src=\"images/icon-rate-disabled.png\">
				<img src=\"images/icon-rate-disabled.png\">";	
	elseif($value == 4)
		return "<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate.png\">
				<img src=\"images/icon-rate.png\">
				<img src=\"images/icon-rate-disabled.png\">";	
	elseif($value == 5)
		return "<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate.png\"> 
				<img src=\"images/icon-rate.png\">
				<img src=\"images/icon-rate.png\">
				<img src=\"images/icon-rate-disabled.png\">";	
}

function toAlpha($n,$case = 'lower'){
    $alphabet   = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $n = $n;
    if($n <= 26){
        $alpha =  $alphabet[$n-1];
		
    } 
	elseif($n > 26) {
        $dividend   = ($n);
        $alpha      = '';
        $modulo;
        while($dividend > 0){
            $modulo     = ($dividend - 1) % 26;
            $alpha      = $alphabet[$modulo].$alpha;
            $dividend   = floor((($dividend - $modulo) / 26));
        }
    }

    if($case=='lower'){
        $alpha = strtolower($alpha);
    }
	
    return $alpha;

}
	
function maybePrefixZero($input) {
    if( substr($input, 0, 1) === '.' ) return '0' . $input;
        else return $input;
}

function json_response($code = 200, $message = null)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
        ));
}

function makedirs($dirpath, $mode=0755)
{
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}		
?>