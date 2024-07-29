<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autobarcode extends CI_Controller {

	function __construct() {
		parent::__construct();
		//kauth

		$this->load->library('kauth');

		$CI =& get_instance();
		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];
	}

	public function test()
	{
		echo 'TEST';
	}
	
	function barcode(){
		$reqPegawaiId= $this->input->get('id');
		$reqPegawaiNipBaru= $this->input->get('nip');

		$this->load->library("qrcodegenerator");
		$qrcodegenerators= new qrcodegenerator();

		$settingurlapi= $this->config->config["settingurlapi"];
		$url= $settingurlapi.'Pegawai_get_token_json/?reqToken='.$reqPegawaiNipBaru;
		// echo $url;exit;
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
        $arrData= json_decode($html,true);
        $arrData= $arrData['result'];
        // print_r($arrData);exit;
		$reqToken= $arrData[0]['token_baru_pegawai'];

		$arrparam= ["reqPegawaiId"=>$reqPegawaiId, "reqPegawaiNipBaru"=>$reqPegawaiNipBaru, "reqToken"=>$reqToken];
		// print_r($arrparam);exit;
		$qrcodegenerators->generateQr($arrparam);
	}

}