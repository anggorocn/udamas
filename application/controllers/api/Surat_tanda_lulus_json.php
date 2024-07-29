<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Surat_tanda_lulus_json extends CI_Controller {

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

		$reqJenisId= $this->input->post('reqJenisId');
		$reqNoStlud= $this->input->post('reqNoStlud');
		$reqTglStlud= $this->input->post('reqTglStlud');
		$reqNilaiNpr= $this->input->post('reqNilaiNpr');
		$reqNilaiNt= $this->input->post('reqNilaiNt');
		$reqTanggalMulai= $this->input->post('reqTanggalMulai');
		$reqTanggalAkhir= $this->input->post('reqTanggalAkhir');
		$reqPendidikanRiwayatId= $this->input->post('reqPendidikanRiwayatId');
		$reqPendidikanId= $this->input->post('reqPendidikanId');

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqJenisId'=>$reqJenisId
			, 'reqNoStlud'=>$reqNoStlud
			, 'reqTglStlud'=>$reqTglStlud
			, 'reqNilaiNpr'=>$reqNilaiNpr
			, 'reqNilaiNt'=>$reqNilaiNt
			, 'reqTanggalMulai'=>$reqTanggalMulai
			, 'reqTanggalAkhir'=>$reqTanggalAkhir
			, 'reqPendidikanRiwayatId'=>$reqPendidikanRiwayatId
			, 'reqPendidikanId'=>$reqPendidikanId
			
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("Surat_tanda_lulus_json", $data);
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