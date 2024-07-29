<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kauth
 *
 * @author user
 */
  class opentext{
	var $id;
	var $ticket;
	
    /******************** CONSTRUCTOR **************************************/
    function opentext(){
	
		 $this->emptyProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->id = "";
		$this->ticket = "";
    }
	
	function getData($idNode, $where)
	{

		$action = "GET";
		$url = "https://svrlpot002.pelindo.co.id:8443/OTCS/cs/api/v2/nodes/".$idNode."/nodes";
	
		if($where == "")
		{}
		else
			$parameters = array("where_name" => $where);
	
		$result = callAPI($action, $url, $parameters, $this->ticket);
		$arr = json_decode($result, true);
		$arrData = $arr["results"];
		
		return $arrData;
				
	}
	
    
    /** Verify user login. True when login is valid**/
    function get($dokumenNumber, $dokumenTahun){		
		$CI =& get_instance();
		$CI->load->model("vendor/SubProgramBayarDokumen");
		
		#Send Reponse To FireBase Server	
		$username = 'EPROC';
		$password = "PEL!nd03";

		$action = "POST";
		$url = "https://svrlpot002.pelindo.co.id:8443/OTCS/cs/api/v1/auth";
		$parameters = array("username" => $username, "password" => $password);
		$result = callAPI($action, $url, $parameters);
		$arr = json_decode($result, true);
		$ticket = $arr["ticket"];
		$this->ticket = $ticket;
		
		/* cari dokumen  */
		$arrData = array();
		$arrData = $this->getData("217742", $dokumenNumber." ".$dokumenTahun);
		$nodeId = $arrData[0]["data"]["properties"]["id"];
		/* cari mir7  */
		unset($arrData);
		$arrData = array();
		$arrData = $this->getData($nodeId, "MIR7");
		$nodeId = $arrData[0]["data"]["properties"]["id"];
		/* browse mir7  */
		unset($arrData);
		$arrData = array();
		$arrData = $this->getData($nodeId, "");
		
		$sub_program_bayar_dokumen = new SubProgramBayarDokumen();
		$sub_program_bayar_dokumen->setField("MIR7", $dokumenNumber.$dokumenTahun);
		$sub_program_bayar_dokumen->deleteOpenText();
		$urut = 1;
		for($i=0;$i<count($arrData);$i++)
		{
		
			$nodeId = $arrData[$i]["data"]["properties"]["id"];
			$nodeName = $arrData[$i]["data"]["properties"]["name"];
			$nodeType = $arrData[$i]["data"]["properties"]["mime_type"];	
			/* INSERT KE TIPE FOLDER */
			$sub_program_bayar_dokumen = new SubProgramBayarDokumen();
			$sub_program_bayar_dokumen->setField("MIR7", $dokumenNumber.$dokumenTahun);
			$sub_program_bayar_dokumen->setField("TIPE", "FOLDER");
			$sub_program_bayar_dokumen->setField("IDFOLDER", $nodeId);
			$sub_program_bayar_dokumen->setField("IDFILE", "");
			$sub_program_bayar_dokumen->setField("URUT", $urut);
			$sub_program_bayar_dokumen->setField("NAMA", $nodeName);
			$sub_program_bayar_dokumen->setField("MIME", $nodeType);
			$sub_program_bayar_dokumen->setField("TANGGAL", "");
			$sub_program_bayar_dokumen->setField("UKURAN", "");
			$sub_program_bayar_dokumen->insertOpenText();
			$urut++;
			
			$arrFolder = $this->getData($nodeId, "");
			for($j=0;$j<count($arrFolder);$j++)
			{
				
				$fileId   = $arrFolder[$j]["data"]["properties"]["id"];
				$fileName = $arrFolder[$j]["data"]["properties"]["name"];
				$fileType = $arrFolder[$j]["data"]["properties"]["mime_type"];	
				$fileDate = $arrFolder[$j]["data"]["properties"]["modify_date"];
				$fileSize = $arrFolder[$j]["data"]["properties"]["size_formatted"];
				/* INSERT KE TIPE FILE */
				$sub_program_bayar_dokumen = new SubProgramBayarDokumen();
				$sub_program_bayar_dokumen->setField("MIR7", $dokumenNumber.$dokumenTahun);
				$sub_program_bayar_dokumen->setField("TIPE", "FILE");
				$sub_program_bayar_dokumen->setField("IDFOLDER", $nodeId);
				$sub_program_bayar_dokumen->setField("IDFILE", $fileId);
				$sub_program_bayar_dokumen->setField("URUT", $urut);
				$sub_program_bayar_dokumen->setField("NAMA", $fileName);
				$sub_program_bayar_dokumen->setField("MIME", $fileType);
				$sub_program_bayar_dokumen->setField("TANGGAL", $fileDate);
				$sub_program_bayar_dokumen->setField("UKURAN", $fileSize);
				$sub_program_bayar_dokumen->insertOpenText();
				$urut++;
			
				
			}
			unset($arrFolder);
				
			
		}
		
			
		  
    }

    function download($fileId){			
	
		#Send Reponse To FireBase Server	
		$username = 'eproc';
		$password = "PEL!nd03";

		$action = "POST";
		$url = "https://svrlpot002.pelindo.co.id:8443/OTCS/cs/api/v1/auth";
		$parameters = array("username" => $username, "password" => $password);
		$result = callAPI($action, $url, $parameters);
		$arr = json_decode($result, true);
		$ticket = $arr["ticket"];
		
		$action = "GET";
		$url = "https://svrlpot002.pelindo.co.id:8443/OTCS/cs/api/v1/nodes/".$fileId."/content";
		
		$result = callAPI($action, $url, $parameters, $ticket);
		
		return  $result;
			
	}
	
	

    function upload($folderId, $dokumen, $namaDokumen){			
		
		//$folderId = "453987";
		#Send Reponse To FireBase Server	
		$username = 'eproc';
		$password = "PEL!nd03";

		$action = "POST";
		$url = "https://svrlpot002.pelindo.co.id:8443/OTCS/cs/api/v1/auth";
		$parameters = array("username" => $username, "password" => $password);
		$result = callAPI($action, $url, $parameters);
		$arr = json_decode($result, true);
		$ticket = $arr["ticket"];
		
		$fildata = curl_file_create($dokumen);
		
		$action = "POST";
		$url = "https://svrlpot002.pelindo.co.id:8443/OTCS/cs/api/v2/nodes";
		$parameters = array("type" => "144", "parent_id" => $folderId, "name" => $namaDokumen, "file" => $fildata);
		$result = callAPIUpload($action, $url, $parameters, $file, $size, $ticket);
		$arr = json_decode($result, true);
		if($arr["error"] == "")
			$pesan = "BERHASIL : ".$arr["results"]["data"]["properties"]["create_date"];
		else
			$pesan = "ERROR : ".$arr["error"];
		
		return  $pesan;
		
			
	}
	
	

	function downloadFile($url, $path)
	{
		$newfname = $path;
		$file = fopen ($url, 'rb');
		if ($file) {
			$newf = fopen ($newfname, 'wb');
			if ($newf) {
				while(!feof($file)) {
					fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
				}
			}
		}
		if ($file) {
			fclose($file);
		}
		if ($newf) {
			fclose($newf);
		}
	}
	

	
	
  }




function callAPIUpload($method, $url, $data, $file, $size, $token=""){
	$curl = curl_init();
	
	switch ($method){
	  case "POST":
		 curl_setopt($curl, CURLOPT_POST, 1);
		 if ($data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		 break;
	  case "PUT":
		 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		 if ($data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
		 break;
	  default:
		 if ($data)
			$url = sprintf("%s?%s", $url, http_build_query($data));
	}
	
	// OPTIONS:
	curl_setopt($curl, CURLOPT_INFILE, $file);
	curl_setopt($curl, CURLOPT_INFILESIZE, $size);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	  'OTCSTICKET: '.$token.' Content-Type: application/x-www-form-urlencoded'
	));
	// Blindly accept the certificate
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	
	// EXECUTE:
	$result = curl_exec($curl);
	if(!$result){die("Connection Failure");}
	curl_close($curl);
	//echo $result."<br><br>";
	return $result;
}



function callAPI($method, $url, $data, $token=""){
	$curl = curl_init();
	
	switch ($method){
	  case "POST":
		 curl_setopt($curl, CURLOPT_POST, 1);
		 if ($data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		 break;
	  case "PUT":
		 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		 if ($data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
		 break;
	  default:
		 if ($data)
			$url = sprintf("%s?%s", $url, http_build_query($data));
	}
	
	// OPTIONS:
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	  'OTCSTICKET: '.$token
	));
	// Blindly accept the certificate
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	
	// EXECUTE:
	$result = curl_exec($curl);
	if(!$result){die("Connection Failure");}
	curl_close($curl);
	//echo $result."<br><br>";
	return $result;
}
/***** INSTANTIATE THE GLOBAL OBJECT */
$openText = new OpenText();

?>