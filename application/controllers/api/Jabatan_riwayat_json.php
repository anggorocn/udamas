<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Jabatan_riwayat_json extends CI_Controller {

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

	function add()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$reqMode= $this->input->post("reqMode");
		$reqTempValidasiId= $this->input->post("reqTempValidasiId");
		$reqId= $this->input->post("reqId");
		$reqRowId= $this->input->post("reqRowId");

		$reqJenisJabatan= $this->input->post("reqJenisJabatan");
		$reqIsManual= $this->input->post("reqIsManual");
		$reqJabatanFuId= $this->input->post("reqJabatanFuId");
		$reqJabatanFtId= $this->input->post("reqJabatanFtId");
		$reqTipePegawaiId= $this->input->post("reqTipePegawaiId");
		$reqNoSk= $this->input->post("reqNoSk");
		$reqTglSk= $this->input->post("reqTglSk");
		$reqNama= $this->input->post("reqNama");
		$reqTmtJabatan= $this->input->post("reqTmtJabatan");
		$reqTmtWaktuJabatan= $this->input->post("reqTmtWaktuJabatan");
		$reqTmtEselon= $this->input->post("reqTmtEselon");
		$reqEselonId= $this->input->post("reqEselonId");
		$reqNama= $this->input->post("reqNama");
		$reqTmtEselon= $this->input->post("reqTmtEselon");
		$reqKeteranganBUP= $this->input->post("reqKeteranganBUP");
		$reqNoPelantikan= $this->input->post("reqNoPelantikan");    
		$reqTglPelantikan= $this->input->post("reqTglPelantikan");
		$reqTunjangan= $this->input->post("reqTunjangan");
		$reqBlnDibayar= $this->input->post("reqBlnDibayar");
		$reqSatkerId= $this->input->post("reqSatkerId");
		$reqSatker= $this->input->post("reqSatker");
		$reqKredit= $this->input->post("reqKredit");
		$reqPejabatPenetap= $this->input->post("reqPejabatPenetap");
		$reqPejabatPenetapId= $this->input->post("reqPejabatPenetapId");
		$reqSkDasarJabatan= $this->input->post("reqSkDasarJabatan");

	
		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken
			, 'reqMode'=>$reqMode

		, 'reqJenisJabatan'=>$reqJenisJabatan
		, 'reqIsManual'=>$reqIsManual
		, 'reqJabatanFuId'=>$reqJabatanFuId
		, 'reqJabatanFtId'=>$reqJabatanFtId
		, 'reqTipePegawaiId'=>$reqTipePegawaiId
		, 'reqNoSk'=>$reqNoSk
		, 'reqTglSk'=>$reqTglSk
		, 'reqNama'=>$reqNama
		, 'reqTmtJabatan'=>$reqTmtJabatan
		, 'reqTmtWaktuJabatan'=>$reqTmtWaktuJabatan
		, 'reqTmtEselon'=>$reqTmtEselon
		, 'reqEselonId'=>$reqEselonId
		, 'reqNama'=>$reqNama
		, 'reqTmtEselon'=>$reqTmtEselon
		, 'reqKeteranganBUP'=>$reqKeteranganBUP
		, 'reqNoPelantikan'=>$reqNoPelantikan
		, 'reqTglPelantikan'=>$reqTglPelantikan
		, 'reqTunjangan'=>$reqTunjangan
		, 'reqBlnDibayar'=>$reqBlnDibayar
		, 'reqSatkerId'=>$reqSatkerId
			, 'reqSatker'=>$reqSatker
		, 'reqKredit'=>$reqKredit
		, 'reqSkDasarJabatan'=>$reqSkDasarJabatan
		, 'reqPejabatPenetap'=>$reqPejabatPenetap
		, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
		
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("Jabatan_riwayat_json", $data);
		// print_r($response);exit();
		$returnStatus= $response->status;
		$returnId= $response->id;

		$simpan="";
		if($returnStatus == "success")
		{
			$reqId= $returnId;
			$simpan=1;
		}

		if($simpan == "1")
		{
			echo json_response(200, $reqId.'-Data berhasil disimpan');
		}
		else
		{
			echo json_response(400, 'Data gagal disimpan');
		}
	}

}