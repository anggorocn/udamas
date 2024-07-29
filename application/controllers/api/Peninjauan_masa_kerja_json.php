<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Peninjauan_masa_kerja_json extends CI_Controller {

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

		$reqNoSK= $this->input->post('reqNoSK');
		$reqTanggalSk= $this->input->post('reqTanggalSk');
		$reqTmtSk= $this->input->post('reqTmtSk');
		$reqTahunTambahan= $this->input->post('reqTahunTambahan');
		$reqBulanTambahan= $this->input->post('reqBulanTambahan');
		$reqTahunBaru= $this->input->post('reqTahunBaru');
		$reqBulanBaru= $this->input->post('reqBulanBaru');

		$reqGolRuang= $this->input->post('reqGolRuang');
		$reqNoNota= $this->input->post('reqNoNota');
		$reqTglNota= $this->input->post('reqTglNota');
		$reqGajiPokok= $this->input->post('reqGajiPokok');
		$reqPejabatPenetapId= $this->input->post('reqPejabatPenetapId');
		$reqPejabatPenetap= $this->input->post('reqPejabatPenetap');

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqNoSK'=>$reqNoSK
			, 'reqTanggalSk'=>$reqTanggalSk
			, 'reqTmtSk'=>$reqTmtSk
			, 'reqTahunTambahan'=>$reqTahunTambahan
			, 'reqBulanTambahan'=>$reqBulanTambahan
			, 'reqTahunBaru'=>$reqTahunBaru
			, 'reqBulanBaru'=>$reqBulanBaru
			, 'reqGolRuang'=>$reqGolRuang
			, 'reqNoNota'=>$reqNoNota
			, 'reqTglNota'=>$reqTglNota
			, 'reqGajiPokok'=>$reqGajiPokok
			, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
			, 'reqPejabatPenetap'=>$reqPejabatPenetap
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("tambahan_masa_kerja_json", $data);
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