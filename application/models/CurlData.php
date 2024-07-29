<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/

  class CurlData extends CI_Model{ 

	var $currentRow;
	var $errorMsg;
    var $rowCount;
    var $rowResult=array();
	var $currentRowIndex;
    /**
    * Class constructor.
    **/
    function CurlData()
	{
		parent::__construct(); 
      	// $this->load->database(); 
    }

    function get_tls_version($tlsVersion)
	{
	    $c = curl_init();
	    curl_setopt($c, CURLOPT_URL, "https://www.howsmyssl.com/a/check");
	    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($c, CURLOPT_SSLVERSION, $tlsVersion);
	 
	    $rbody = curl_exec($c);
	    if ($rbody === false) {
	        $errno = curl_errno($c);
	        $msg = curl_error($c);
	        curl_close($c);
	        return "Error! errno = " . $errno . ", msg = " . $msg;
	    } else {
	        $r = json_decode($rbody);
	        curl_close($c);
	        return $r->tls_version;
	    }
	}

	function infocheck()
	{
		echo "OS: " . PHP_OS . "\n";
		echo "uname: " . php_uname() . "\n";
		echo "PHP version: " . phpversion() . "\n";

		$curl_version = curl_version();
		echo "curl version: " . $curl_version["version"] . "\n";
		echo "SSL version: " . $curl_version["ssl_version"] . "\n";
		echo "SSL version number: " . $curl_version["ssl_version_number"] . "\n";
		echo "OPENSSL_VERSION_NUMBER: " . dechex(OPENSSL_VERSION_NUMBER) . "\n";

		echo "\nTesting CURL_SSLVERSION_TLSv... (not forced)\n";
		echo "Result TLS_Default: " . $this->get_tls_version(CURL_SSLVERSION_DEFAULT) . "\n";
		echo "Result TLS_v1_1: " . $this->get_tls_version(CURL_SSLVERSION_TLSv1_1) . "\n";
		echo "Result TLS_v1_2: " . $this->get_tls_version(CURL_SSLVERSION_TLSv1_2) . "\n";
		echo "Result TLS_v1_3: " . $this->get_tls_version(CURL_SSLVERSION_TLSv1_3) . "\n";

		echo "\nTesting CURL_SSLVERSION_MAX_TLSv...\n";
		echo "Result MAX_Default: " . $this->get_tls_version(CURL_SSLVERSION_MAX_DEFAULT) . "\n";
		echo "Result MAX_TLS_v1_1: " . $this->get_tls_version(CURL_SSLVERSION_MAX_TLSv1_1) . "\n";
		echo "Result MAX_TLS_v1_2: " . $this->get_tls_version(CURL_SSLVERSION_MAX_TLSv1_2) . "\n";
		echo "Result MAX_TLS_v1_3: " . $this->get_tls_version(CURL_SSLVERSION_MAX_TLSv1_3) . "\n";
	}
	
	function curlpost($url, $data, $lihat){
    	$settingurlapi= $this->config->config["settingurlapi"];
		// echo $settingurlapi;exit;

		$url= $settingurlapi.$url.'?reqToken='.$data['reqToken'];
		if($lihat == "2")
		{
			echo $url;exit;
		}

		$header = array(
            'Content-Type: multipart/form-data'
            // , 'x-api-key: 5943C044-2EFD-40AB-9A46-8FB482652A4D'
        );

    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		// curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');

		// curl_setopt($ch, CURLOPT_TIMEOUT, 500);
		// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// execute post
		$result = curl_exec($ch);
		// close connection
		curl_close($ch);

		if($lihat == "1")
		{
			print_r($result);exit();
		}

		$rs= json_decode($result);
		// print_r($rs);exit();
		return $rs;

    }
	
	public function getField($fieldName){
		$fieldName = strtolower($fieldName);
		
		return $this->currentRow[$fieldName];
	}
	
	function selectLimit($url, $token, $lihat= "", $lihathasil=""){

		$settingurlapi= $this->config->config["settingurlapi"];
		// echo $settingurlapi;exit;
		$_rowResult = array();
		$this->rowResult = array();
		$this->rowCount = 0;
		
		$ch = curl_init();
		$url= $settingurlapi.$url.'?reqToken='.$token;
		
		if($lihat == "1")
		{
			echo $url;exit;
		}
		
		curl_setopt_array($ch, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_TIMEOUT => 500,
		  CURLOPT_SSL_VERIFYPEER => false,
		));

		$response = curl_exec($ch);
		$rs = json_decode($response);
		curl_close($ch);
		// print_r($rs);exit();

		if($lihathasil == "json")
		{
			$arrreturn= [];
			if ($rs) {

				foreach ($rs->result[0]->data as $row)
				{
					$arrdata= [];
					foreach($row as $key=>$val)
					{
						$arrdata[$key] = $val;
					}
					array_push($arrreturn, $arrdata);
				}
				// print_r($arrreturn);exit;
				return $arrreturn;
			}
		}
		else if($lihathasil == "file")
		{
			$arrreturn= [];
			if ($rs) {

				$rs= json_decode(json_encode($rs), true);
				// print_r($rs);exit;
				// print_r($rs["result"][0]["data"]);exit;
				$infojson= $rs["result"][0]["data"];
				// print_r($infojson);exit;

				foreach ($infojson as $keyrow=> $row)
				{
					$arrdata= [];
					foreach($row as $key=>$val)
					{
						if($key == "kosong")
							$key= "";

						$arrdata[$key] = $val;
					}
					$arrreturn[$keyrow]= $arrdata;
				}
				// print_r($arrreturn);exit;
				return $arrreturn;
			}
		}
		else
		{
			$i=0;
			if ($rs) {
				$i=0;
				foreach ($rs->result as $row) 
				{
					foreach($row as $key=>$val)
					{
						$arr[strtolower($key)] = $val;
					}
					$_rowResult[$i]= $arr;
					$i = $i+1;
				}
			}

			$this->rowResult = $_rowResult;
			$this->rowCount = $i;
			
			$this->currentRowIndex = -1;
			$this->currentRow = array();
		}

    }

    function nextRow(){
    	if($this->currentRowIndex < $this->rowCount-1){
    		$this->currentRowIndex++;
    		$this->setRowValue();
    		return true;
    	} else {
    		return false;
    	}
    }
	
	function firstRow(){
      	if($this->rowCount>0){
			$this->currentRowIndex=0;
			$this->setRowValue();
			return true;
      	} else {
        	return false;
    	}
	}
	
	function setRowValue(){
		$this->currentRow = $this->rowResult[$this->currentRowIndex];
	}	
	
  } 
?>