<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Gaji_json extends CI_Controller {

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

		$reqPeriode= $this->input->post('reqPeriode');
		
		$reqNoSk= $this->input->post("reqNoSk");
		$reqTanggalSk= $this->input->post("reqTanggalSk");
		$reqGolRuang= $this->input->post("reqGolRuang");
		$reqTmtSk= $this->input->post("reqTmtSk");
		$reqTh= $this->input->post('reqTh');
		$reqTempTh= $this->input->post('reqTempTh');
		$reqBl= $this->input->post('reqBl');
		$reqTempBl= $this->input->post('reqTempBl');
		$reqPejabatPenetapId= $this->input->post('reqPejabatPenetapId');
		$reqPejabatPenetap= $this->input->post('reqPejabatPenetap');
		$reqGajiPokok= $this->input->post("reqGajiPokok");
		$reqJenis= $this->input->post("reqJenis");

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqNoSk'=>$reqNoSk
			, 'reqTanggalSk'=>$reqTanggalSk
			, 'reqGolRuang'=>$reqGolRuang
			, 'reqTmtSk'=>$reqTmtSk
			, 'reqTh'=>$reqTh
			, 'reqTempTh'=>$reqTempTh
			, 'reqBl'=>$reqBl
			, 'reqTempBl'=>$reqTempBl
			, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
			, 'reqPejabatPenetap'=>$reqPejabatPenetap
			, 'reqGajiPokok'=>$reqGajiPokok
			, 'reqJenis'=>$reqJenis
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("gaji_riwayat_json", $data);
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