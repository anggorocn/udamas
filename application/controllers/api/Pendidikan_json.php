<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Pendidikan_json extends CI_Controller {

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

		$reqNamaSekolah= $this->input->post('reqNamaSekolah');
		$reqNamaFakultas= $this->input->post('reqNamaFakultas');
		$reqPendidikanId= $this->input->post('reqPendidikanId');
		$reqTglSttb= $this->input->post('reqTglSttb');
		$reqJurusan= $this->input->post('reqJurusan');
		$reqJurusanId= $this->input->post('reqJurusanId');
		$reqAlamatSekolah= $this->input->post('reqAlamatSekolah');
		$reqKepalaSekolah= $this->input->post('reqKepalaSekolah');
		$reqNoSttb= $this->input->post('reqNoSttb');
		$reqStatusTugasIjinBelajar= $this->input->post('reqStatusTugasIjinBelajar');
		$reqStatusPendidikan= $this->input->post('reqStatusPendidikan');
		$reqNoSuratIjin= $this->input->post('reqNoSuratIjin');
		$reqTglSuratIjin= $this->input->post('reqTglSuratIjin');
		$reqGelarTipe= $this->input->post('reqGelarTipe');
		$reqGelarNamaDepan= $this->input->post('reqGelarNamaDepan');
		$reqGelarNama= $this->input->post('reqGelarNama');
		$reqPppkStatus= $this->input->post('reqPppkStatus');

		$reqSkDasarPengakuan= $this->input->post('reqSkDasarPengakuan');
		$reqCantumGelarTgl= $this->input->post('reqCantumGelarTgl');
		$reqCantumGelarNoSk= $this->input->post('reqCantumGelarNoSk');
		$reqDasarPangkatRiwayatId= $this->input->post('reqDasarPangkatRiwayatId');
		$reqNilaiKualifikasi= $this->input->post('reqNilaiKualifikasi');
		$reqRumpunJabatan= $this->input->post('reqRumpunJabatan');

		// $statement= " AND A.STATUS IS NULL AND UPPER(A.NAMA) LIKE '%".strtoupper($reqJurusan)."%'  AND A.PENDIDIKAN_ID = ".$reqPendidikanId;

		if($reqPendidikanId < 6){}
		else
		{

			$arrdata=array("reqJurusan"=>$reqJurusan,"reqPendidikanId"=>$reqPendidikanId);
			$set= new DataCombo();
			$set->selectby($sessPersonalToken, "pendidikanJurusan", $arrdata);
			$set->firstRow();
			$reqJurusanId= $set->getField("PENDIDIKAN_JURUSAN_ID");
			$reqJurusan= $set->getField("NAMA");
		


			// $statement= " AND A.STATUS IS NULL AND UPPER(A.NAMA) = '".strtoupper($reqJurusan)."' AND A.PENDIDIKAN_ID = ".$reqPendidikanId;
			// $set_detil= new PendidikanJurusan();
			// $set_detil->selectByParams(array(), -1,-1, $statement);
			// // echo $set_detil->query;exit();
			// $set_detil->firstRow();
			// $reqJurusanId= $set_detil->getField("PENDIDIKAN_JURUSAN_ID");
			// $reqJurusan= $set_detil->getField("NAMA");
			// unset($set_detil);

			if($reqJurusanId == "")
			{
				echo "xxx-Jurusan tidak ada dalam sistem, hubungi admin untuk menambahkan data jurusan.";
				exit();
			}
		}
		// echo 'TEST';
		// exit;

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqNamaSekolah'=>$reqNamaSekolah
			, 'reqNamaFakultas'=>$reqNamaFakultas
			, 'reqPendidikanId'=>$reqPendidikanId
			, 'reqTglSttb'=>$reqTglSttb
			, 'reqJurusan'=>$reqJurusan
			, 'reqJurusanId'=>$reqJurusanId
			, 'reqAlamatSekolah'=>$reqAlamatSekolah
			, 'reqKepalaSekolah'=>$reqKepalaSekolah
			, 'reqNoSttb'=>$reqNoSttb
			, 'reqStatusTugasIjinBelajar'=>$reqStatusTugasIjinBelajar
			, 'reqStatusPendidikan'=>$reqStatusPendidikan
			, 'reqNoSuratIjin'=>$reqNoSuratIjin
			, 'reqTglSuratIjin'=>$reqTglSuratIjin
			, 'reqGelarTipe'=>$reqGelarTipe
			, 'reqGelarNamaDepan'=>$reqGelarNamaDepan
			, 'reqGelarNama'=>$reqGelarNama
			, 'reqPppkStatus'=>$reqPppkStatus
			, 'reqSkDasarPengakuan'=>$reqSkDasarPengakuan
			, 'reqCantumGelarTgl'=>$reqCantumGelarTgl
			, 'reqCantumGelarNoSk'=>$reqCantumGelarNoSk
			, 'reqDasarPangkatRiwayatId'=>$reqDasarPangkatRiwayatId
			, 'reqNilaiKualifikasi'=>$reqNilaiKualifikasi
			, 'reqRumpunJabatan'=>$reqRumpunJabatan
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("pendidikan_riwayat_json", $data);
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