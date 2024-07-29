<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Penghargaan_json extends CI_Controller {

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

		$reqPjPenetapNama= $this->input->post('reqPjPenetapNama');
		$reqPjPenetap= $this->input->post('reqPjPenetap');
		$reqNamaPenghargaan= $this->input->post('reqNamaPenghargaan');
		$reqTahun= $this->input->post('reqTahun');
		$reqTglSK= $this->input->post('reqTglSK');
		$reqNoSK= $this->input->post('reqNoSK');
		$reqPejabatPenetap= $this->input->post("reqPejabatPenetap");
		$reqPejabatPenetapId= $this->input->post("reqPejabatPenetapId");

		$reqRefPenghargaanId= $this->input->post("reqRefPenghargaanId");
		$reqNamaDetil= $this->input->post("reqNamaDetil");
		$reqJenjangPeringkatId= $this->input->post("reqJenjangPeringkatId");

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqPjPenetapNama'=>$reqPjPenetapNama
			, 'reqPjPenetap'=>$reqPjPenetap
			, 'reqNamaPenghargaan'=>$reqNamaPenghargaan
			, 'reqTahun'=>$reqTahun
			, 'reqTglSK'=>$reqTglSK
			, 'reqNoSK'=>$reqNoSK
			, 'reqPejabatPenetap'=>$reqPejabatPenetap
			, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
			, 'reqRefPenghargaanId'=>$reqRefPenghargaanId
			, 'reqNamaDetil'=>$reqNamaDetil
			, 'reqJenjangPeringkatId'=>$reqJenjangPeringkatId
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("penghargaan_json", $data);
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