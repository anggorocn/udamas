<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Pak_json extends CI_Controller {

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

		$reqJabatanFtId= $this->input->post('reqJabatanFtId');
		$reqCheckPakAwal= $this->input->post('reqCheckPakAwal');
		$reqNoSK= $this->input->post('reqNoSK');
		$reqTglMulai= $this->input->post('reqTglMulai');
		$reqTglSelesai= $this->input->post('reqTglSelesai');
		$reqTglSK= $this->input->post('reqTglSK');
		$reqKreditUtama= $this->input->post('reqKreditUtama');
		$reqKreditPenunjang= $this->input->post('reqKreditPenunjang');
		$reqTotalKredit= $this->input->post('reqTotalKredit');

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqJabatanFtId'=>$reqJabatanFtId
			, 'reqCheckPakAwal'=>$reqCheckPakAwal
			, 'reqNoSK'=>$reqNoSK
			, 'reqTglMulai'=>$reqTglMulai
			, 'reqTglSelesai'=>$reqTglSelesai
			, 'reqTglSK'=>$reqTglSK
			, 'reqKreditUtama'=>$reqKreditUtama
			, 'reqKreditPenunjang'=>$reqKreditPenunjang
			, 'reqTotalKredit'=>$reqTotalKredit
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("pak_json", $data);
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