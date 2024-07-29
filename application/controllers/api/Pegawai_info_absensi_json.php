<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Pegawai_info_absensi_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('kauth');

		$CI =& get_instance();

		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];

		if($this->session->userdata("PERSONAL_TOKEN".$configvlxsessfolder) == "")
		{
			redirect('login');
		}

		$this->MD5KEY = $this->config->item('md5key');
		$this->PERSONAL_TOKEN= $this->session->userdata("PERSONAL_TOKEN".$configvlxsessfolder);
		// $this->db->query("SET DATESTYLE TO PostgreSQL,European;");
	}

	function index()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;
		$reqTanggal=$this->input->get('reqTanggal');

		// $settingurlapi= $this->config->config["settingurlapi"];
		$settingurlapi="https://siapasn.jombangkab.go.id/api/api-baru/";
        $url =  $settingurlapi.'Info_absensi_json?reqToken='.$sessPersonalToken.'&tanggalmulai='.$reqTanggal.'&tanggalakhir='.$reqTanggal;
        
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
        
        $arrData = json_decode($html,true);
        $arrData=$arrData['result'];
        $arrDataFilter = multi_array_search($arrData,array("TANGGAL"=>$reqTanggal));
        $arrDataFilter=$arrDataFilter[0];
        	

        if( $arrDataFilter['LOG_MASUK']=='--:--'|| $arrDataFilter['LOG_MASUK']=='-' || empty($arrDataFilter['LOG_MASUK'])){
        	$arrDataFilter['LOG_MASUK']='--:--';
        	$arrDataFilter['LOG_MASUK_A']='-';
        }else {
        	$arrDataVal = date('H:i A', strtotime($arrDataFilter['LOG_MASUK']));
        	$arrDataVals = explode(" ",$arrDataVal);
        	$arrDataFilter['LOG_MASUK']=$arrDataVals[0];        
        	$arrDataFilter['LOG_MASUK_A']=$arrDataVals[1];
		}

		if( $arrDataFilter['LOG_PULANG']=='--:--'|| $arrDataFilter['LOG_PULANG']=='-' || empty($arrDataFilter['LOG_PULANG'])){
			$arrDataFilter['LOG_PULANG']='--:--';
			$arrDataFilter['LOG_PULANG_A']='-';
		}else {
			$arrDataVal = date('H:i A', strtotime($arrDataFilter['LOG_PULANG']));
        	$arrDataVals = explode(" ",$arrDataVal);
			$arrDataFilter['LOG_PULANG']=$arrDataVals[0];
			$arrDataFilter['LOG_PULANG_A']=$arrDataVals[1];
			
		}

		if( $arrDataFilter['TERLAMBAT']=='--:--' || $arrDataFilter['TERLAMBAT']=='-' || empty($arrDataFilter['TERLAMBAT'])){
			$arrDataFilter['TERLAMBAT']='--:--';
			$arrDataFilter['TERLAMBAT_A']='-';
		}else {
			$arrDataVal = date('H:i A', strtotime($arrDataFilter['TERLAMBAT']));
        	$arrDataVals = explode(" ",$arrDataVal);
			$arrDataFilter['TERLAMBAT']=$arrDataVals[0];
			$arrDataFilter['TERLAMBAT_A']=$arrDataVals[1];
		}


		if( $arrDataFilter['PULANG_CEPAT']=='--:--' || $arrDataFilter['PULANG_CEPAT']=='-' || empty($arrDataFilter['PULANG_CEPAT'])){
			$arrDataFilter['PULANG_CEPAT']='--:--';
			$arrDataFilter['PULANG_CEPAT_A']='-';
		}else {
			$arrDataVal = date('H:i A', strtotime($arrDataFilter['PULANG_CEPAT']));
        	$arrDataVals = explode(" ",$arrDataVal);
			$arrDataFilter['PULANG_CEPAT']=$arrDataVals[0];
			$arrDataFilter['PULANG_CEPAT_A']=$arrDataVals[1];
		}

		
        echo json_encode($arrDataFilter);

        // echo json_response($arrData);
       

	}

}