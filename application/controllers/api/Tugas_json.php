<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Tugas_json extends CI_Controller {

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

		$reqTempValidasiId= $this->input->post("reqTempValidasiId");
		$reqId = $this->input->post("reqId");
		$reqRowId= $this->input->post("reqRowId");

		$reqStatusPlt= $this->input->post("reqStatusPlt");
		$reqIsManual= $this->input->post("reqIsManual");
		$reqTugasTambahanId= $this->input->post("reqTugasTambahanId");
		$reqTmtTugas= $this->input->post("reqTmtTugas");
		$reqTmtWaktuTugas= $this->input->post("reqTmtWaktuTugas");
		$reqNamaTugas= $this->input->post("reqNamaTugas");
		$reqPejabatPenetap= $this->input->post("reqPejabatPenetap");
		$reqPejabatPenetapId= $this->input->post("reqPejabatPenetapId");
		$reqNoSk= $this->input->post("reqNoSk");
		$reqTanggalSk= $this->input->post("reqTanggalSk");
		$reqTmtJabatan= $this->input->post("reqTmtJabatan");
		$reqTmtJabatanAkhir= $this->input->post("reqTmtJabatanAkhir");
		$reqSatker= $this->input->post("reqSatker");
		$reqSatkerId= $this->input->post("reqSatkerId");
		$reqNoPelantikan= $this->input->post("reqNoPelantikan");
		$reqTanggalPelantikan= $this->input->post("reqTanggalPelantikan");
		$reqTunjangan= $this->input->post("reqTunjangan");
		$reqBulanDibayar= $this->input->post("reqBulanDibayar");

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqStatusPlt'=>$reqStatusPlt
			, 'reqIsManual'=>$reqIsManual
			, 'reqTugasTambahanId'=>$reqTugasTambahanId
			, 'reqTmtTugas'=>$reqTmtTugas
			, 'reqTmtWaktuTugas'=>$reqTmtWaktuTugas
			, 'reqNamaTugas'=>$reqNamaTugas
			, 'reqPejabatPenetap'=>$reqPejabatPenetap
			, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
			, 'reqNoSk'=>$reqNoSk
			, 'reqTanggalSk'=>$reqTanggalSk
			, 'reqTmtJabatan'=>$reqTmtJabatan
			, 'reqTmtJabatanAkhir'=>$reqTmtJabatanAkhir
			, 'reqSatker'=>$reqSatker
			, 'reqSatkerId'=>$reqSatkerId
			, 'reqNoPelantikan'=>$reqNoPelantikan
			, 'reqTanggalPelantikan'=>$reqTanggalPelantikan
			, 'reqTunjangan'=>$reqTunjangan
			, 'reqBulanDibayar'=>$reqBulanDibayar
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("jabatan_tambahan_json", $data);
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