<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Saudara_json extends CI_Controller {

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

		$reqNama= $this->input->post("reqNama");
		$reqTmpLahir= $this->input->post("reqTmpLahir");
		$reqTglLahir= $this->input->post("reqTglLahir");
		$reqJenisKelamin= $this->input->post("reqJenisKelamin");
		$reqPekerjaan= $this->input->post("reqPekerjaan");
		$reqAlamat= $this->input->post("reqAlamat");
		$reqKodePos= $this->input->post("reqKodePos");
		$reqTelepon= $this->input->post("reqTelepon");
		$reqPropinsi= $this->input->post("reqPropinsi");
		$reqKabupaten= $this->input->post("reqKabupaten");
		$reqKecamatan= $this->input->post("reqKecamatan");
		$reqKelurahan= $this->input->post("reqKelurahan");
		$reqStatusHidup= $this->input->post("reqStatusHidup");
		$reqStatusSdr= $this->input->post("reqStatusSdr");

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqNama'=>$reqNama
			, 'reqTmpLahir'=>$reqTmpLahir
			, 'reqTglLahir'=>$reqTglLahir
			, 'reqJenisKelamin'=>$reqJenisKelamin
			, 'reqPekerjaan'=>$reqPekerjaan
			, 'reqAlamat'=>$reqAlamat
			, 'reqKodePos'=>$reqKodePos
			, 'reqTelepon'=>$reqTelepon
			, 'reqPropinsi'=>$reqPropinsi
			, 'reqKabupaten'=>$reqKabupaten
			, 'reqKecamatan'=>$reqKecamatan
			, 'reqKelurahan'=>$reqKelurahan
			, 'reqStatusHidup'=>$reqStatusHidup
			, 'reqStatusSdr'=>$reqStatusSdr
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("saudara_json", $data);
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