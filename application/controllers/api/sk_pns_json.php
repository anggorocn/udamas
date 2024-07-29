<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class sk_pns_json extends CI_Controller {

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

		$reqPeriode= $this->input->post('reqPeriode');

		$reqPejabatPenetapId= $this->input->post("reqPejabatPenetapId");
		$reqPejabatPenetap= $this->input->post("reqPejabatPenetap");
		$reqNamaPejabatPenetap= $this->input->post("reqNamaPejabatPenetap");
		$reqNipPejabatPenetap= $this->input->post("reqNipPejabatPenetap");
		$reqNoSuratKeputusan= $this->input->post("reqNoSuratKeputusan");
		$reqTanggalSuratKeputusan= $this->input->post("reqTanggalSuratKeputusan");
		$reqTerhitungMulaiTanggal= $this->input->post("reqTerhitungMulaiTanggal");
		$reqGolRuang= $this->input->post("reqGolRuang");
		$reqTanggalTugas= $this->input->post("reqTanggalTugas");
		$reqNoDiklatPrajabatan= $this->input->post("reqNoDiklatPrajabatan");
		$reqTanggalDiklatPrajabatan= $this->input->post("reqTanggalDiklatPrajabatan");
		$reqNoSuratUjiKesehatan= $this->input->post("reqNoSuratUjiKesehatan");
		$reqTanggalSuratUjiKesehatan= $this->input->post("reqTanggalSuratUjiKesehatan");
		$reqPengambilanSumpah= $this->input->post("reqPengambilanSumpah");
		$reqSkPnsId= $this->input->post("reqSkPnsId");
		$reqTanggalSumpah= $this->input->post("reqTanggalSumpah");
		$reqTh= $this->input->post("reqTh");
		$reqBl= $this->input->post("reqBl");
		
		$reqNoBeritaAcara= $this->input->post("reqNoBeritaAcara");
		$reqTanggalBeritaAcara= $this->input->post("reqTanggalBeritaAcara");
		$reqKeteranganLpj= $this->input->post("reqKeteranganLpj");
		
		$reqGajiPokok= $this->input->post("reqGajiPokok");

		$reqJenisJabatanId= $this->input->post("reqJenisJabatanId");
		$reqStatusCalonJft= $this->input->post("reqStatusCalonJft");
		$reqJabatanTugas= $this->input->post("reqJabatanTugas");
		$reqJabatanFuId= $this->input->post("reqJabatanFuId");
		$reqJabatanFtId= $this->input->post("reqJabatanFtId");
		$reqJalurPengangkatan= $this->input->post("reqJalurPengangkatan");
	
		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken
			, 'reqMode'=>$reqMode

		, 'reqPeriode'=>$reqPeriode
		, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
		, 'reqPejabatPenetap'=>$reqPejabatPenetap
		, 'reqNamaPejabatPenetap'=>$reqNamaPejabatPenetap
		, 'reqNipPejabatPenetap'=>$reqNipPejabatPenetap
		, 'reqNoSuratKeputusan'=>$reqNoSuratKeputusan
		, 'reqTanggalSuratKeputusan'=>$reqTanggalSuratKeputusan
		, 'reqTerhitungMulaiTanggal'=>$reqTerhitungMulaiTanggal
		, 'reqGolRuang'=>$reqGolRuang
		, 'reqTanggalTugas'=>$reqTanggalTugas
		, 'reqNoDiklatPrajabatan'=>$reqNoDiklatPrajabatan
		, 'reqTanggalDiklatPrajabatan'=>$reqTanggalDiklatPrajabatan
		, 'reqNoSuratUjiKesehatan'=>$reqNoSuratUjiKesehatan
		, 'reqTanggalSuratUjiKesehatan'=>$reqTanggalSuratUjiKesehatan
		, 'reqPengambilanSumpah'=>$reqPengambilanSumpah
		, 'reqSkPnsId'=>$reqSkPnsId
		, 'reqTanggalSumpah'=>$reqTanggalSumpah
		, 'reqTh'=>$reqTh
		, 'reqBl'=>$reqBl
			, 'reqNoBeritaAcara'=>$reqNoBeritaAcara
		, 'reqTanggalBeritaAcara'=>$reqTanggalBeritaAcara
		, 'reqKeteranganLpj'=>$reqKeteranganLpj
		, 'reqGajiPokok'=>$reqGajiPokok
		, 'reqJenisJabatanId'=>$reqJenisJabatanId
		, 'reqStatusCalonJft'=>$reqStatusCalonJft
		, 'reqJabatanTugas'=>$reqJabatanTugas
			, 'reqJabatanFuId'=>$reqJabatanFuId
			, 'reqJabatanFtId'=>$reqJabatanFtId
			, 'reqJalurPengangkatan'=>$reqJalurPengangkatan
		
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("Sk_pns_json", $data);

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