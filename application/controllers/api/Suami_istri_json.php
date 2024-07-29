<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Suami_istri_json extends CI_Controller {

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

		$reqPendidikanId= $this->input->post("reqPendidikanId");
		$reqNama= $this->input->post("reqNama");
		$reqTempatLahir= $this->input->post("reqTempatLahir");
		$reqTanggalLahir= $this->input->post("reqTanggalLahir");
		$reqTanggalKawin= $this->input->post("reqTanggalKawin");
		$reqKartu= $this->input->post("reqKartu");
		$reqStatusPns= $this->input->post("reqStatusPns");
		$reqNipPns= $this->input->post("reqNipPns");
		$reqPekerjaan= $this->input->post("reqPekerjaan");
		$reqStatusTunjangan= $this->input->post("reqStatusTunjangan");
		$reqStatusBayar= $this->input->post("reqStatusBayar");
		$reqBulanBayar= $this->input->post("reqBulanBayar");
		$reqStatusSi= $this->input->post("reqStatusSi");
		
		$reqSuratKawin= $this->input->post("reqSuratKawin");
		$reqNik= $this->input->post("reqNik");
		$reqCeraiSurat= $this->input->post("reqCeraiSurat");
		$reqCeraiTanggal= $this->input->post("reqCeraiTanggal");
		$reqCeraiTmt= $this->input->post("reqCeraiTmt");
		$reqKematianSurat= $this->input->post("reqKematianSurat");
		$reqKematianTanggal= $this->input->post("reqKematianTanggal");
		$reqKematianTmt= $this->input->post("reqKematianTmt");

		$reqStatusHidup= $this->input->post('reqStatusHidup');
		$reqStatusBekerja= $this->input->post('reqStatusBekerja');
		$reqGelarDepan= $this->input->post('reqGelarDepan');
		$reqGelarBelakang= $this->input->post('reqGelarBelakang');
		$reqAktaKelahiran= $this->input->post('reqAktaKelahiran');
		$reqJenisIdDokumen= $this->input->post('reqJenisIdDokumen');
		$reqNoInduk= $this->input->post('reqNoInduk');
		$reqAgamaId= $this->input->post('reqAgamaId');
		$reqEmail= $this->input->post('reqEmail');
		$reqHp= $this->input->post('reqHp');
		$reqTelepon= $this->input->post('reqTelepon');
		$reqAlamat= $this->input->post('reqAlamat');
		$reqBpjsNo= $this->input->post('reqBpjsNo');
		$reqBpjsTanggal= $this->input->post('reqBpjsTanggal');
		$reqNpwpNo= $this->input->post('reqNpwpNo');
		$reqNpwpTanggal= $this->input->post('reqNpwpTanggal');
		$reqStatusPns= $this->input->post('reqStatusPns');
		$reqNipPns= $this->input->post('reqNipPns');
		$reqStatusLulus= $this->input->post('reqStatusLulus');
		$reqKematianNo= $this->input->post('reqKematianNo');
		$reqKematianTanggal= $this->input->post('reqKematianTanggal');
		$reqJenisKawinId= $this->input->post('reqJenisKawinId');
		$reqAktaNikahNo= $this->input->post('reqAktaNikahNo');
		$reqAktaNikahTanggal= $this->input->post('reqAktaNikahTanggal');
		$reqNikahTanggal= $this->input->post('reqNikahTanggal');
		$reqAktaCeraiNo= $this->input->post('reqAktaCeraiNo');
		$reqAktaCeraiTanggal= $this->input->post('reqAktaCeraiTanggal');
		$reqCeraiTanggal= $this->input->post('reqCeraiTanggal');
		$reqTanggalMeninggal= $this->input->post('reqTanggalMeninggal');

		$reqAgamaId= $this->input->post('reqAgamaId');
		$reqJenisKelamin= $this->input->post('reqJenisKelamin');

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqPendidikanId'=>$reqPendidikanId
			, 'reqNama'=>$reqNama
			, 'reqTempatLahir'=>$reqTempatLahir
			, 'reqTanggalLahir'=>$reqTanggalLahir
			, 'reqTanggalKawin'=>$reqTanggalKawin
			, 'reqKartu'=>$reqKartu
			, 'reqStatusPns'=>$reqStatusPns
			, 'reqNipPns'=>$reqNipPns
			, 'reqPekerjaan'=>$reqPekerjaan
			, 'reqStatusTunjangan'=>$reqStatusTunjangan
			, 'reqStatusBayar'=>$reqStatusBayar
			, 'reqBulanBayar'=>$reqBulanBayar
			, 'reqStatusSi'=>$reqStatusSi
			, 'reqSuratKawin'=>$reqSuratKawin
			, 'reqNik'=>$reqNik
			, 'reqCeraiSurat'=>$reqCeraiSurat
			, 'reqCeraiTanggal'=>$reqCeraiTanggal
			, 'reqCeraiTmt'=>$reqCeraiTmt
			, 'reqKematianSurat'=>$reqKematianSurat
			, 'reqKematianTanggal'=>$reqKematianTanggal
			, 'reqKematianTmt'=>$reqKematianTmt
			, 'reqStatusHidup'=>$reqStatusHidup
			, 'reqStatusBekerja'=>$reqStatusBekerja
			, 'reqGelarDepan'=>$reqGelarDepan
			, 'reqGelarBelakang'=>$reqGelarBelakang
			, 'reqAktaKelahiran'=>$reqAktaKelahiran
			, 'reqJenisIdDokumen'=>$reqJenisIdDokumen
			, 'reqNoInduk'=>$reqNoInduk
			, 'reqAgamaId'=>$reqAgamaId
			, 'reqEmail'=>$reqEmail
			, 'reqHp'=>$reqHp
			, 'reqTelepon'=>$reqTelepon
			, 'reqAlamat'=>$reqAlamat
			, 'reqBpjsNo'=>$reqBpjsNo
			, 'reqBpjsTanggal'=>$reqBpjsTanggal
			, 'reqNpwpNo'=>$reqNpwpNo
			, 'reqNpwpTanggal'=>$reqNpwpTanggal
			, 'reqStatusPns'=>$reqStatusPns
			, 'reqNipPns'=>$reqNipPns
			, 'reqStatusLulus'=>$reqStatusLulus
			, 'reqKematianNo'=>$reqKematianNo
			, 'reqKematianTanggal'=>$reqKematianTanggal
			, 'reqJenisKawinId'=>$reqJenisKawinId
			, 'reqAktaNikahNo'=>$reqAktaNikahNo
			, 'reqAktaNikahTanggal'=>$reqAktaNikahTanggal
			, 'reqNikahTanggal'=>$reqNikahTanggal
			, 'reqAktaCeraiNo'=>$reqAktaCeraiNo
			, 'reqAktaCeraiTanggal'=>$reqAktaCeraiTanggal
			, 'reqCeraiTanggal'=>$reqCeraiTanggal
			, 'reqTanggalMeninggal'=>$reqTanggalMeninggal
			, 'reqAgamaId'=>$reqAgamaId
			, 'reqJenisKelamin'=>$reqJenisKelamin
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("suami_istri_json", $data);
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