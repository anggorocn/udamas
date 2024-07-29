<? 
include_once(APPPATH.'/models/CurlData.php');

class DataCombo extends CurlData{ 

  var $query;
  var $id;

  function DataCombo()
  {
    $this->CurlData(); 
  }

  function selectby($token, $mode, $arrdata=[], $lihat="", $lihathasil="")
  {
  	$infoparam= "&reqMode=".$mode;
  	if(!empty($arrdata))
  	{
  		foreach ($arrdata as $key => $value)
  		{
        		$infoparam.= "&".$key."=".urlencode($value);
      	}
      	// print_r($infoparam);exit;
    }

    $arrhasil= array("json", "file");
    if(in_array($lihathasil, $arrhasil))
    {
      return $this->selectLimit("combo_json", $token.$infoparam, $lihat, $lihathasil);
    }
    else
      $this->selectLimit("combo_json", $token.$infoparam, $lihat);
  }

  function selectdata($arrparam=[], $lihat="")
  {
    $token= $arrparam["token"];
    $vurl= $arrparam["vurl"];
    $id= $arrparam["id"];
    $rowid= $arrparam["rowid"];

    if(!empty($id))
    {
      $token.= "&reqId=".$id;
    }
    if(!empty($rowid))
    {
      $token.= "&reqRowId=".$rowid;
    }
    $this->selectLimit($vurl, $token, $lihat);
  }

  function updatepersonal($vrl, $data, $lihat="")
  {
    return $this->curlpost($vrl, $data, $lihat);
  }
} 
?>