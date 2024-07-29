<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class sk_cpns_json extends CI_Controller {

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

		$reqMode= $this->input->post("reqMode");
		$reqTempValidasiId= $this->input->post("reqTempValidasiId");
		$reqId= $this->input->post("reqId");
		$reqRowId= $this->input->post("reqRowId");

		$reqNoNotaBakn= $this->input->post("reqNoNotaBakn");
		$reqTanggalNotaBakn= $this->input->post("reqTanggalNotaBakn");
		$reqPejabatPenetapId= $this->input->post("reqPejabatPenetapId");
		$reqPejabatPenetap= $this->input->post("reqPejabatPenetap");
		$reqNamaPejabatPenetap= $this->input->post("reqNamaPejabatPenetap");
		$reqNipPejabatPenetap= $this->input->post("reqNipPejabatPenetap");
		$reqNoSuratKeputusan= $this->input->post("reqNoSuratKeputusan");
		$reqTanggalSuratKeputusan= $this->input->post("reqTanggalSuratKeputusan");
		$reqTerhitungMulaiTanggal= $this->input->post("reqTerhitungMulaiTanggal");
		$reqGolRuang= $this->input->post("reqGolRuang");
		$reqTanggalTugas= $this->input->post("reqTanggalTugas");
		$reqSkcpnsId= $this->input->post("reqSkcpnsId");
		$reqTh= $this->input->post("reqTh");
		$reqBl= $this->input->post("reqBl");
		$reqNoPersetujuanNip= $this->input->post("reqNoPersetujuanNip");
		$reqTanggalPersetujuanNip= $this->input->post("reqTanggalPersetujuanNip");
		$reqPendidikan= $this->input->post("reqPendidikan");
		$reqJurusan= $this->input->post("reqJurusan");
		$reqGajiPokok= $this->input->post("reqGajiPokok");
		$reqFormasiCpnsId= $this->input->post("reqFormasiCpnsId");
		$reqJabatanTugas= $this->input->post("reqJabatanTugas");

		$reqJenisFormasiTugasId= $this->input->post("reqJenisFormasiTugasId");
		$reqJabatanFuId= $this->input->post("reqJabatanFuId");
		$reqJabatanFtId= $this->input->post("reqJabatanFtId");
		$reqStatusSkCpns= $this->input->post("reqStatusSkCpns");
		$reqSpmtNomor= $this->input->post("reqSpmtNomor");
		$reqSpmtTanggal= $this->input->post("reqSpmtTanggal");
		$reqSpmtTmt= $this->input->post("reqSpmtTmt");

	
		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken
			, 'reqMode'=>$reqMode

		, 'reqNoNotaBakn'=>$reqNoNotaBakn
		, 'reqTanggalNotaBakn'=>$reqTanggalNotaBakn
		, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
		, 'reqPejabatPenetap'=>$reqPejabatPenetap
		, 'reqNamaPejabatPenetap'=>$reqNamaPejabatPenetap
		, 'reqNipPejabatPenetap'=>$reqNipPejabatPenetap
		, 'reqNoSuratKeputusan'=>$reqNoSuratKeputusan
		, 'reqTanggalSuratKeputusan'=>$reqTanggalSuratKeputusan
		, 'reqTerhitungMulaiTanggal'=>$reqTerhitungMulaiTanggal
		, 'reqGolRuang'=>$reqGolRuang
		, 'reqTanggalTugas'=>$reqTanggalTugas
		, 'reqSkcpnsId'=>$reqSkcpnsId
		, 'reqTh'=>$reqTh
		, 'reqBl'=>$reqBl
		, 'reqNoPersetujuanNip'=>$reqNoPersetujuanNip
		, 'reqTanggalPersetujuanNip'=>$reqTanggalPersetujuanNip
		, 'reqPendidikan'=>$reqPendidikan
		, 'reqJurusan'=>$reqJurusan
		, 'reqGajiPokok'=>$reqGajiPokok
		, 'reqFormasiCpnsId'=>$reqFormasiCpnsId
			, 'reqJabatanTugas'=>$reqJabatanTugas
		, 'reqJenisFormasiTugasId'=>$reqJenisFormasiTugasId
		, 'reqJabatanFuId'=>$reqJabatanFuId
		, 'reqJabatanFtId'=>$reqJabatanFtId
		, 'reqStatusSkCpns'=>$reqStatusSkCpns
		, 'reqSpmtNomor'=>$reqSpmtNomor
		, 'reqSpmtTanggal'=>$reqSpmtTanggal
			, 'reqSpmtTmt'=>$reqSpmtTmt
		
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("Sk_cpns_json", $data);

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