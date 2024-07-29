<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'kloader.php';
include_once("lib/nusoap-0.9.5/lib/nusoap.php");

class Kauth {
    function __construct() {
		$CI =& get_instance();
		$CI->load->driver('session');
    }

    public function localToken($token) {
        $CI =& get_instance();
        $configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];
        $settingurlapi= $configdata->config["settingurlapi"];

        $ch = curl_init();
        $url= $settingurlapi.'pegawai_menu_json?reqToken='.$token;
        // echo $url;exit;
        
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
        $vmenu= $rs->result[0];
        $vmenu= json_decode(json_encode($vmenu), true);
        // print_r($vmenu);exit;

        $aColumns = array("STATUS_DATA_UTAMA", "ICON_DATA_UTAMA", "STATUS_SK_CPNS", "ICON_SK_CPNS", "STATUS_SK_PNS", "ICON_SK_PNS", "STATUS_SK_PPPK", "ICON_SK_PPPK", "STATUS_PANGKAT", "ICON_PANGKAT", "STATUS_GAJI", "ICON_GAJI", "STATUS_JABATAN", "ICON_JABATAN", "STATUS_TUGAS", "ICON_TUGAS", "STATUS_PENDIDIKAN", "ICON_PENDIDIKAN", "STATUS_DIKLAT_STRUKTURAL", "ICON_DIKLAT_STRUKTURAL", "STATUS_DIKLAT_KURSUS", "ICON_DIKLAT_KURSUS", "STATUS_CUTI", "ICON_CUTI", "STATUS_SKP_PPK", "ICON_SKP_PPK", "STATUS_PAK", "ICON_PAK", "STATUS_KOMPETENSI", "ICON_KOMPETENSI", "STATUS_PENGHARGAAN", "ICON_PENGHARGAAN", "STATUS_PENINJAUAN_MASA_KERJA", "ICON_PENINJAUAN_MASA_KERJA", "STATUS_SURAT_TANDA_LULUS", "ICON_SURAT_TANDA_LULUS", "STATUS_SUAMI_ISTRI", "ICON_SUAMI_ISTRI", "STATUS_ANAK", "ICON_ANAK", "STATUS_ORANG_TUA_ADD", "ICON_ORANG_TUA_ADD", "STATUS_SAUDARA", "ICON_SAUDARA", "STATUS_MERTUA_ADD", "ICON_MERTUA_ADD", "STATUS_BAHASA", "ICON_BAHASA");

        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $CI->session->set_userdata(trim($aColumns[$i]).$configvlxsessfolder, $vmenu[trim($aColumns[$i])]);
        }

        $CI->session->set_userdata("PERSONAL_TOKEN".$configvlxsessfolder, $token);

        // print_r($CI->session->userdata);exit;

        // echo $CI->session->userdata("PERSONAL_TOKEN".$configvlxsessfolder);exit;
    }

    public function unsettoken() {
        $CI =& get_instance();
        $configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];

        $CI->session->unset_userdata("PERSONAL_TOKEN".$configvlxsessfolder);
    }
    
    public function paymentAuthenticate($username,$credential) {
      
        $CI =& get_instance();
		/* API */
		$ch = curl_init();
		$data = array('reqUser' => $username, "reqPasswd" => $credential, "reqDeviceID" => "DESKTOP");
		
		curl_setopt($ch, CURLOPT_URL, $CI->config->item("base_api")."mobile/login_json");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		$obj = json_decode($response);

		if($obj->{'status'} == "success")
		{
            $CI->session->set_userdata('ID', $obj->{'reqUserLoginId'});
            $CI->session->set_userdata('REKANAN_ID', $obj->{'reqPerusahaanId'});
            $CI->session->set_userdata('KODE_REKANAN', $obj->{'reqKode'});
            $CI->session->set_userdata('REKANAN', $obj->{'reqNama'});
            $CI->session->set_userdata('EMAIL', $obj->{'reqEmail'});
            $CI->session->set_userdata('TOKEN', $obj->{'token'});
			$CI->session->set_userdata('HAK_AKSES', "");

            $CI->session->set_userdata('NPWP',  $obj->{'data_perusahaan'}[0]->npwp); 
            $CI->session->set_userdata('BANK_REKENING',  $obj->{'data_perusahaan'}[0]->rekening);
            $CI->session->set_userdata('BANK',  $obj->{'data_perusahaan'}[0]->rekening_bank); 
            $CI->session->set_userdata('BANK_PEMILIK',  $obj->{'data_perusahaan'}[0]->rekening_nama); 
            $CI->session->set_userdata('DIREKTUR',  $obj->{'data_perusahaan'}[0]->pimpinan); 
            $CI->session->set_userdata('HAK_AKSES', "");
            $CI->session->set_userdata('JABATAN_DIREKTUR',  $obj->{'data_perusahaan'}[0]->pimpinan_jabatan); 
            $CI->session->set_userdata('KODE_ANAK_PERUSAHAAN', "");
            return $obj->{'status'};	
        }
        else
        {
            return $obj->{'message'};
        }
    }

    public function getArrayData($arrStatement,$apiName, $method="POST") {


        $CI =& get_instance();

        /* API */
        $ch = curl_init();

        $paramGet = "";
        $isPost = 1;
        $data = $arrStatement;

        if($method=="GET")
        {
            $paramGet = "/?method=get";

            foreach ($arrStatement as $key => $value)
            {
                $paramGet .= "&$key=$value";
            }

        }

        curl_setopt($ch, CURLOPT_URL, $CI->config->item("base_api")."mobile/".$apiName.$paramGet);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if($method=="GET")
        {}
        else
        {
            curl_setopt($ch, CURLOPT_POST, $isPost);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $obj = json_decode($response, true);

        
        return $obj;

    }

    public function setcekfile($reqLinkFile)
    {
        $files = array();
        foreach ($_FILES["reqLinkFile"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {

                $namaFile= $reqLinkFile['name'][$key];
                $typeFile= $reqLinkFile['type'][$key];
                $sizeFile= $reqLinkFile['size'][$key];
                $tmp_name= $reqLinkFile['tmp_name'][$key];

                $files[$key] = new CURLFile(
                    realpath($tmp_name),
                    $typeFile,
                    $namaFile
                );

                /*$files[$key] = curl_file_create(
                    $tmp_name,
                    $typeFile,
                    $namaFile
                );*/
            }
        }

        /*return new CURLFile(
            realpath($tmp_name),
            $typeFile,
            $namaFile
        );*/

        /*Array
        (
            [0] => Array
                (
                    [name] => C:\wamp\tmp\phpB581.tmp
                    [mime] => application/octet-stream
                    [postname] => .htaccess
                )

        )*/
        return $files;
    }

    public function setfile($vpost, $reqLinkFile, $arrparam=[])
    {
        $CI =& get_instance();
        $CI->load->model("base-curl/DataCombo");

        $reqToken= $arrparam["reqToken"];
        $reqRowId= $arrparam["reqRowId"];
        $reqTempValidasiId= $arrparam["reqTempValidasiId"];

        // if(!empty($_FILES["reqLinkFile"]))
        if(!empty($_FILES["reqLinkFile"]["tmp_name"][0]))
        {
            foreach ($_FILES["reqLinkFile"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {

                    $namaFile= $reqLinkFile['name'][$key];
                    $typeFile= $reqLinkFile['type'][$key];
                    $sizeFile= $reqLinkFile['size'][$key];
                    $tmp_name= $reqLinkFile['tmp_name'][$key];

                    $linkfile= new CURLFile(
                        realpath($tmp_name),
                        $typeFile,
                        $namaFile
                    );

                    $data= array(
                        "reqToken"=>$reqToken
                        , "reqRowId"=>$reqRowId
                        , "reqTempValidasiId"=>$reqTempValidasiId
                        , "reqLinkFile"=>$linkfile
                        , "reqDokumenRequired"=>$vpost["reqDokumenRequired"][$key]
                        , "reqDokumenRequiredNama"=>$vpost["reqDokumenRequiredNama"][$key]
                        , "reqDokumenRequiredTable"=>$vpost["reqDokumenRequiredTable"][$key]
                        , "reqDokumenRequiredTableRow"=>$vpost["reqDokumenRequiredTableRow"][$key]
                        , "reqDokumenFileId"=>$vpost["reqDokumenFileId"][$key]
                        , "reqDokumenKategoriFileId"=>$vpost["reqDokumenKategoriFileId"][$key]
                        , "reqDokumenKategoriField"=>$vpost["reqDokumenKategoriField"][$key]
                        , "reqDokumenPath"=>$vpost["reqDokumenPath"][$key]
                        , "reqDokumenTipe"=>$vpost["reqDokumenTipe"][$key]
                        , "reqDokumenPilih"=>$vpost["reqDokumenPilih"][$key]
                        , "reqDokumenFileKualitasId"=>$vpost["reqDokumenFileKualitasId"][$key]
                        , "reqDokumenIndexId"=>$vpost["reqDokumenIndexId"][$key]
                    );
                    // $data= urldecode(http_build_query($data));
                    // print_r($data);exit;

                    $set= new DataCombo();
                    $response= $set->updatepersonal("upload_file_json", $data, "");
                }
            }
        }
        else
        {
            $key= 0;
            $data= array(
                "reqToken"=>$reqToken
                , "reqRowId"=>$reqRowId
                , "reqTempValidasiId"=>$reqTempValidasiId
                , "reqLinkFile"=>$linkfile
                , "reqDokumenRequired"=>$vpost["reqDokumenRequired"][$key]
                , "reqDokumenRequiredNama"=>$vpost["reqDokumenRequiredNama"][$key]
                , "reqDokumenRequiredTable"=>$vpost["reqDokumenRequiredTable"][$key]
                , "reqDokumenRequiredTableRow"=>$vpost["reqDokumenRequiredTableRow"][$key]
                , "reqDokumenFileId"=>$vpost["reqDokumenFileId"][$key]
                , "reqDokumenKategoriFileId"=>$vpost["reqDokumenKategoriFileId"][$key]
                , "reqDokumenKategoriField"=>$vpost["reqDokumenKategoriField"][$key]
                , "reqDokumenPath"=>$vpost["reqDokumenPath"][$key]
                , "reqDokumenTipe"=>$vpost["reqDokumenTipe"][$key]
                , "reqDokumenPilih"=>$vpost["reqDokumenPilih"][$key]
                , "reqDokumenFileKualitasId"=>$vpost["reqDokumenFileKualitasId"][$key]
                , "reqDokumenIndexId"=>$vpost["reqDokumenIndexId"][$key]
            );
            // $data= urldecode(http_build_query($data));
            // print_r($data);exit;

            $set= new DataCombo();
            $response= $set->updatepersonal("upload_file_json", $data, "");
        }
    }
}
?>