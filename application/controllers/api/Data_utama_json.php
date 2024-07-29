<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Data_utama_json extends CI_Controller {

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
		
		$reqNipBaru = $this->input->post("reqNipBaru");
		$reqNipLama = $this->input->post("reqNipLama");
		$reqTempatLahir = $this->input->post("reqTempatLahir");
		$reqNama = $this->input->post("reqNama");
		$reqPegawaiKedudukanNama = $this->input->post("reqPegawaiKedudukanNama");
		$reqJenisKelamin = $this->input->post("reqJenisKelamin");
		$reqGolonganDarah = $this->input->post("reqGolonganDarah");
		$reqAgama = $this->input->post("reqAgama");
		$reqSukuBangsa = $this->input->post("reqSukuBangsa");
		$reqJenisPegawaiId = $this->input->post("reqJenisPegawaiId");
		$reqSatuanKerjaId = $this->input->post("reqSatuanKerjaId");
		$reqKartuPegawai = $this->input->post("reqKartuPegawai");
		$reqNik = $this->input->post("reqNik");
		$reqNoKk = $this->input->post("reqNoKk");
		$reqBpjs = $this->input->post("reqBpjs");
		$reqBpjsTanggal = $this->input->post("reqBpjsTanggal");
		$reqNpwp = $this->input->post("reqNpwp");
		$reqNpwpTanggal = $this->input->post("reqNpwpTanggal");
		$reqSkKonversiNip = $this->input->post("reqSkKonversiNip");
		$reqUrut = $this->input->post("reqUrut");
		$reqNoRakBerkas = $this->input->post("reqNoRakBerkas");
		$reqPropinsiId = $this->input->post("reqPropinsiId");
		$reqKabupatenId = $this->input->post("reqKabupatenId");
		$reqKecamatanId = $this->input->post("reqKecamatanId");
		$reqDesaId = $this->input->post("reqDesaId");
		$reqRt = $this->input->post("reqRt");
		$reqRw = $this->input->post("reqRw");
		$reqAlamat = $this->input->post("reqAlamat");
		$reqAlamatKeterangan = $this->input->post("reqAlamatKeterangan");
		$reqHp = $this->input->post("reqHp");
		$reqTeleponKantor = $this->input->post("reqTeleponKantor");
		$reqTelepon = $this->input->post("reqTelepon");
		$reqEmail = $this->input->post("reqEmail");
		$reqEmailKantor = $this->input->post("reqEmailKantor");
		$reqFacebook = $this->input->post("reqFacebook");
		$reqTwitter = $this->input->post("reqTwitter");
		$reqWhatsApp = $this->input->post("reqWhatsApp");
		$reqTelegram = $this->input->post("reqTelegram");
		$reqBank = $this->input->post("reqBank");
		$reqNoRekening = $this->input->post("reqNoRekening");
		$reqRekeningNama = $this->input->post("reqRekeningNama");
		$reqGajiPokok = $this->input->post("reqGajiPokok");
		$reqTunjanganKeluarga = $this->input->post("reqTunjanganKeluarga");
		$reqTunjangan = $this->input->post("reqTunjangan");
		$reqGajiBersih = $this->input->post("reqGajiBersih");
		$reqStatusMutasi = $this->input->post("reqStatusMutasi");
		$reqKeterangan1 = $this->input->post("reqKeterangan1");
		$reqKeterangan2 = $this->input->post("reqKeterangan2");

	
		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

		, 'reqNipBaru'=>$reqNipBaru
		, 'reqTempatLahir'=>$reqTempatLahir
		, 'reqKartuPegawai'=>$reqKartuPegawai
		, 'reqNipLama'=>$reqNipLama
		, 'reqNama'=>$reqNama
		, 'reqPegawaiKedudukanNama'=>$reqPegawaiKedudukanNama
		, 'reqJenisKelamin'=>$reqJenisKelamin
		, 'reqGolonganDarah'=>$reqGolonganDarah
		, 'reqAgama'=>$reqAgama
		, 'reqSukuBangsa'=>$reqSukuBangsa
		, 'reqJenisPegawaiId'=>$reqJenisPegawaiId
		, 'reqSatuanKerjaId'=>$reqSatuanKerjaId
		, 'reqNik'=>$reqNik
		, 'reqNoKk'=>$reqNoKk
		, 'reqBpjs'=>$reqBpjs
		, 'reqBpjsTanggal'=>$reqBpjsTanggal
		, 'reqNpwp'=>$reqNpwp
		, 'reqNpwpTanggal'=>$reqNpwpTanggal
		, 'reqSkKonversiNip'=>$reqSkKonversiNip
		, 'reqUrut'=>$reqUrut
		, 'reqNoRakBerkas'=>$reqNoRakBerkas
		, 'reqPropinsiId'=>$reqPropinsiId
		, 'reqKabupatenId'=>$reqKabupatenId
		, 'reqKecamatanId'=>$reqKecamatanId
		, 'reqDesaId'=>$reqDesaId
		, 'reqRt'=>$reqRt
		, 'reqRw'=>$reqRw
		, 'reqAlamat'=>$reqAlamat
		, 'reqAlamatKeterangan'=>$reqAlamatKeterangan
		, 'reqHp'=>$reqHp
		, 'reqTeleponKantor'=>$reqTeleponKantor
		, 'reqTelepon'=>$reqTelepon
		, 'reqEmail'=>$reqEmail
		, 'reqEmailKantor'=>$reqEmailKantor
		, 'reqFacebook'=>$reqFacebook
		, 'reqTwitter'=>$reqTwitter
		, 'reqWhatsApp'=>$reqWhatsApp
		, 'reqTelegram'=>$reqTelegram
		, 'reqBank'=>$reqBank
		, 'reqNoRekening'=>$reqNoRekening
		, 'reqRekeningNama'=>$reqRekeningNama
		, 'reqGajiPokok'=>$reqGajiPokok
		, 'reqTunjanganKeluarga'=>$reqTunjanganKeluarga
		, 'reqTunjangan'=>$reqTunjangan
		, 'reqGajiBersih'=>$reqGajiBersih
		, 'reqStatusMutasi'=>$reqStatusMutasi
		, 'reqKeterangan1'=>$reqKeterangan1
		, 'reqKeterangan2'=>$reqKeterangan2
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("Pegawai_json", $data);
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