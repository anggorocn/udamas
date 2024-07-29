<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: date.func.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle date operations
***************************************************************************************************** */

	function dateToPage($_date){
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $_date;
	}

	function addWIB($_date){
		if($_date == "")
			return $_date;
		else
			return ", ".$_date." WIB";		
	}

	function datetimeToPage($_date, $_type){
		if($_date == "")
			return "";
		$arrDateTime = explode(" ", $_date);
		if($_type == "date")
		{
			$arrDate = explode("-", $arrDateTime[0]);
			$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
			return $_date;
		}
		else
		{
			$_date = $arrDateTime[1];
			$arrTime = explode(":", $_date);
			if($_type == "hour")
				return $arrTime[0];
			elseif($_type == "minutes")
				return $arrTime[1];						
			else
				return $_date;							
		}
	}

	function dateTimeToPageCheck($_date){
		if($_date == "")
		{
			return "";	
		}
		$arrDateTime = explode(" ", $_date);
		$arrDate = explode("-", $arrDateTime[0]);
		
		/*if($arrDateTime[1] == "")
		{
			$_date = $arrDate[2]."-".generateZeroDate($arrDate[1],2)."-".generateZeroDate($arrDate[0], 2);
		}
		else
		{
			$_date = $arrDate[2]."-".generateZeroDate($arrDate[1],2)."-".generateZeroDate($arrDate[0], 2)." ".$arrDateTime[1];
		}*/
		
		$_date = $arrDate[2]."-".generateZeroDate($arrDate[1],2)."-".generateZeroDate($arrDate[0], 2);
		
		return $_date;
	}
	function getNamaHari($hari, $bulan, $tahun)
	{
		//$x= mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$x= mktime(0, 0, 0, $bulan, $hari, $tahun);
		$namahari = date("l", $x);
		
		if ($namahari == "Sunday") $namahari = "Minggu";
		else if ($namahari == "Monday") $namahari = "Senin";
		else if ($namahari == "Tuesday") $namahari = "Selasa";
		else if ($namahari == "Wednesday") $namahari = "Rabu";
		else if ($namahari == "Thursday") $namahari = "Kamis";
		else if ($namahari == "Friday") $namahari = "Jumat";
		else if ($namahari == "Saturday") $namahari = "Sabtu";
		
		return $namahari;
	}
	
	function generateZeroDate($varId, $digitGroup, $digitCompletor = "0")
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
	function dateToPageCheck($_date){
		if($_date == "")
		{
			return "";	
		}
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $_date;
	}
	
	function dateToDB($_date){
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $_date;
	}
	
	function dateToDBCheck($_date){
		if($_date == "")
		{
			return "NULL";	
		}
		$arrDate = explode("-", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return "TO_DATE('".$_date."', 'YYYY-MM-DD')";
	}	
	
	function dateMixToDB($_date){
		$arrDate = explode("/", $_date);
		$_date = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
		return $_date;
	}
	
	function getDay($_date) {
		$arrDate = explode("-", $_date);
		return $arrDate[0];
	}
	
	function getMonth($_date) {
		$arrDate = explode("-", $_date);
		return $arrDate[1];
	}
	
	function getYear($_date) {
		$arrDate = explode("-", $_date);
		return $arrDate[2];
	}

	function getHari($hari)
	{
		switch ($hari){
			case 0 : $hari="Minggu";
				break;
			case 1 : $hari="Senin";
				break;
			case 2 : $hari="Selasa";
				break;
			case 3 : $hari="Rabu";
				break;
			case 4 : $hari="Kamis";
				break;
			case 5 : $hari="Jum'at";
				break;
			case 6 : $hari="Sabtu";
				break;
		}
		return $hari;
	}
		function getFormattedDateView($_date)
	{
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $_date);
		$_month = intval($arrDate[1]);

		$date = ''.$arrDate[0].' '.$arrMonth[$_month].' '.$arrDate[2].'';
		return $date;
	}
		function getSelectFormattedDate($_date)
	{
		$arrMonth = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", 
						  "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$date = $arrMonth[$_date];
		return $date;
	}	
	function getNameMonth($number) {
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");
		return $arrMonth[$number];
	}

	function getNamePeriode($periode) {
		$periode = trim($periode);	
		$reqBulan = substr($periode, 0, 2);
		$reqTahun = substr($periode, 2, 4);
		
		return getNameMonth((int)$reqBulan)." ".$reqTahun;
	}
		
	function getNameMonth3Digit($number) {
		$arrMonth = array("1"=>"Jan", "2"=>"Feb", "3"=>"Mar", "4"=>"Apr", "5"=>"Mei", 
						  "6"=>"Jun", "7"=>"Jul", "8"=>"Agu", "9"=>"Sep", "10"=>"Okt", 
						  "11"=>"Nov", "12"=>"Des");
		return $arrMonth[$number];
	}

	function getRomawiMonth($number) {
		$arrMonth = array("1"=>"I", "2"=>"II", "3"=>"III", "4"=>"IV", "5"=>"V", 
						  "6"=>"VI", "7"=>"VII", "8"=>"VIII", "9"=>"IX", "10"=>"X", 
						  "11"=>"XI", "12"=>"XII");
		return $arrMonth[$number];
	}
	
	// date input : database
	function getFormattedDateJson($_date)
	{
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $_date);
		$_month = intval($arrDate[1]);

		$date = $arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0];
		return $date;
	}
	
	function getValueDate($_date)
	{		
		$arrDate = explode("-", $_date);
		$_month = intval($arrDate[1]);
		
		$jumHari = cal_days_in_month(CAL_GREGORIAN, $_month, $arrDate[0]);	
		$date = $jumHari;
		
		return $date;
	}
	
	function getFormattedDate($_date)
	{
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $_date);
		$_month = intval($arrDate[1]);

		$date = ''.$arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0].'';
		return $date;
	}
	
	// date input : database
	function getFormattedDateTime($_date, $showTime=true)
	{
		$_date = explode(" ", $_date);
		$explodedDate = $_date[0];
		$explodedTime = $_date[1];
		
		$arrMonth = array("1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", 
						  "6"=>"Juni", "7"=>"Juli", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", 
						  "11"=>"November", "12"=>"Desember");

		$arrDate = explode("-", $explodedDate);
		$_month = intval($arrDate[1]);
		
		$date = $arrDate[2].' '.$arrMonth[$_month].' '.$arrDate[0];
		$time = $explodedTime;

		if($showTime == true)
			$datetime = '<span style="white-space:nowrap">'.$date.',&nbsp;'.$time.'</span>';
		else
			$datetime = '<span style="white-space:nowrap">'.$date.'</span>';
		return $datetime;
	}
?>