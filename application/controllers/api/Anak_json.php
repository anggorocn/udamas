<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Anak_json extends CI_Controller {

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

		$reqNama= $this->input->post('reqNama');
		$reqTempatLahir= $this->input->post('reqTempatLahir');
		$reqTanggalLahir= $this->input->post('reqTanggalLahir');
		$reqJenisKelamin= $this->input->post('reqJenisKelamin');
		$reqStatusKeluarga= $this->input->post('reqStatusKeluarga');
		$reqStatusAktif= $this->input->post('reqStatusAktif');
		$reqDapatTunjangan= $this->input->post('reqDapatTunjangan');
		$reqPendidikanId= $this->input->post('reqPendidikanId');
		$reqPekerjaan= $this->input->post('reqPekerjaan');
		$reqAwalBayar= $this->input->post('reqAwalBayar');
		$reqAkhirBayar= $this->input->post('reqAkhirBayar');

		$reqStatusNikah= $this->input->post('reqStatusNikah');
		$reqStatusBekerja= $this->input->post('reqStatusBekerja');

		$reqSuamiIstriId= $this->input->post('reqSuamiIstriId');
		$reqNoInduk= $this->input->post('reqNoInduk');
		$reqStatusNikah= $this->input->post('reqStatusNikah');
		$reqTanggalMeninggal= $this->input->post('reqTanggalMeninggal');

		$reqGelarDepan= $this->input->post('reqGelarDepan');
		$reqGelarBelakang= $this->input->post('reqGelarBelakang');
		$reqAktaKelahiran= $this->input->post('reqAktaKelahiran');
		$reqJenisIdDokumen= $this->input->post('reqJenisIdDokumen');
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
		// echo $sessPersonalToken;
		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqNama'=>$reqNama
			, 'reqTempatLahir'=>$reqTempatLahir
			, 'reqTanggalLahir'=>$reqTanggalLahir
			, 'reqJenisKelamin'=>$reqJenisKelamin
			, 'reqStatusKeluarga'=>$reqStatusKeluarga
			, 'reqStatusAktif'=>$reqStatusAktif
			, 'reqDapatTunjangan'=>$reqDapatTunjangan
			, 'reqPendidikanId'=>$reqPendidikanId
			, 'reqPekerjaan'=>$reqPekerjaan
			, 'reqAwalBayar'=>$reqAwalBayar
			, 'reqAkhirBayar'=>$reqAkhirBayar
			, 'reqStatusNikah'=>$reqStatusNikah
			, 'reqStatusBekerja'=>$reqStatusBekerja
			, 'reqSuamiIstriId'=>$reqSuamiIstriId
			, 'reqNoInduk'=>$reqNoInduk
			, 'reqStatusNikah'=>$reqStatusNikah
			, 'reqTanggalMeninggal'=>$reqTanggalMeninggal
			, 'reqGelarDepan'=>$reqGelarDepan
			, 'reqGelarBelakang'=>$reqGelarBelakang
			, 'reqAktaKelahiran'=>$reqAktaKelahiran
			, 'reqJenisIdDokumen'=>$reqJenisIdDokumen
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
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("anak_json", $data);
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