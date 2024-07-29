<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Orang_tua_json extends CI_Controller {

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

		$reqIdAyah= $this->input->post("reqIdAyah");
		$reqIdIbu= $this->input->post("reqIdIbu");

		$reqNamaAyah= $this->input->post("reqNamaAyah");
		$reqNamaIbu= $this->input->post("reqNamaIbu");
		$reqTmptLahirAyah= $this->input->post("reqTmptLahirAyah");
		$reqTmptLahirIbu= $this->input->post("reqTmptLahirIbu");
		$reqTglLahirAyah= $this->input->post("reqTglLahirAyah");
		$reqTglLahirIbu= $this->input->post("reqTglLahirIbu");
		// $reqUsiaAyah= $this->input->post("reqUsiaAyah");
		// $reqUsiaIbu= $this->input->post("reqUsiaIbu");
		$reqPekerjaanAyah= $this->input->post("reqPekerjaanAyah");
		$reqPekerjaanIbu= $this->input->post("reqPekerjaanIbu");
		$reqAlamatAyah= $this->input->post("reqAlamatAyah");
		$reqAlamatIbu= $this->input->post("reqAlamatIbu");
		$reqPropinsiAyahId= $this->input->post("reqPropinsiAyahId");
		$reqPropinsiIbuId= $this->input->post("reqPropinsiIbuId");
		$reqKabupatenAyahId= $this->input->post("reqKabupatenAyahId");
		$reqKabupatenIbuId= $this->input->post("reqKabupatenIbuId");
		$reqKecamatanAyahId= $this->input->post("reqKecamatanAyahId");
		$reqKecamatanIbuId= $this->input->post("reqKecamatanIbuId");
		$reqDesaAyahId= $this->input->post("reqDesaAyahId");
		$reqDesaIbuId= $this->input->post("reqDesaIbuId");
		$reqKodePosAyah= $this->input->post("reqKodePosAyah");
		$reqKodePosIbu= $this->input->post("reqKodePosIbu");
		$reqTeleponAyah= $this->input->post("reqTeleponAyah");
		$reqTeleponIbu= $this->input->post("reqTeleponIbu");
		$reqStatusAktifAyah= $this->input->post("reqStatusAktifAyah");
		$reqStatusAktifIbu= $this->input->post("reqStatusAktifIbu");

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqIdAyah'=>$reqIdAyah
			, 'reqIdIbu'=>$reqIdIbu
			, 'reqNamaAyah'=>$reqNamaAyah
			, 'reqNamaIbu'=>$reqNamaIbu
			, 'reqTmptLahirAyah'=>$reqTmptLahirAyah
			, 'reqTmptLahirIbu'=>$reqTmptLahirIbu
			, 'reqTglLahirAyah'=>$reqTglLahirAyah
			, 'reqTglLahirIbu'=>$reqTglLahirIbu
			, 'reqPekerjaanAyah'=>$reqPekerjaanAyah
			, 'reqPekerjaanIbu'=>$reqPekerjaanIbu
			, 'reqAlamatAyah'=>$reqAlamatAyah
			, 'reqAlamatIbu'=>$reqAlamatIbu
			, 'reqPropinsiAyahId'=>$reqPropinsiAyahId
			, 'reqPropinsiIbuId'=>$reqPropinsiIbuId
			, 'reqKabupatenAyahId'=>$reqKabupatenAyahId
			, 'reqKabupatenIbuId'=>$reqKabupatenIbuId
			, 'reqKecamatanAyahId'=>$reqKecamatanAyahId
			, 'reqKecamatanIbuId'=>$reqKecamatanIbuId
			, 'reqDesaAyahId'=>$reqDesaAyahId
			, 'reqDesaIbuId'=>$reqDesaIbuId
			, 'reqKodePosAyah'=>$reqKodePosAyah
			, 'reqKodePosIbu'=>$reqKodePosIbu
			, 'reqTeleponAyah'=>$reqTeleponAyah
			, 'reqTeleponIbu'=>$reqTeleponIbu
			, 'reqStatusAktifAyah'=>$reqStatusAktifAyah
			, 'reqStatusAktifIbu'=>$reqStatusAktifIbu
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("orang_tua_json", $data);
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