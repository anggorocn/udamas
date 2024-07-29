<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Pangkat_json extends CI_Controller {

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

		$reqPeriode= $this->input->post('reqPeriode');

		$reqTglStlud= $this->input->post('reqTglStlud');
		$reqStlud= $this->input->post('reqStlud');
		$reqNoStlud= $this->input->post('reqNoStlud');
		$reqNoNota= $this->input->post('reqNoNota');
		$reqNoSk= $this->input->post('reqNoSk');
		$reqNoUrutCetak= $this->input->post('reqNoUrutCetak');
		$reqTh= $this->input->post('reqTh');
		$reqTempTh= $this->input->post('reqTempTh');
		$reqBl= $this->input->post('reqBl');
		$reqTempBl= $this->input->post('reqTempBl');
		$reqKredit= $this->input->post('reqKredit');
		$reqJenisKp= $this->input->post('reqJenisKp');
		$reqKeterangan= $this->input->post('reqKeterangan');
		$reqGajiPokok= $this->input->post('reqGajiPokok');
		$reqTglNota= $this->input->post('reqTglNota');
		$reqTglSk= $this->input->post('reqTglSk');
		$reqTmtGol= $this->input->post('reqTmtGol');
		$reqPejabatPenetapId= $this->input->post('reqPejabatPenetapId');
		$reqPejabatPenetap= $this->input->post('reqPejabatPenetap');
		$reqGolRuang= $this->input->post('reqGolRuang');
		
		//kalau pejabat tidak ada
		if($reqPejabatPenetapId == "")
		{
			$set_pejabat=new PejabatPenetap();
			$set_pejabat->setField('NAMA', strtoupper($reqPejabatPenetap));
			$set_pejabat->setField("LAST_USER", $this->LOGIN_USER);
			$set_pejabat->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_pejabat->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_pejabat->setField("LAST_DATE", "NOW()");
			$set_pejabat->insert();
			// echo $set_pejabat->query;exit();
			$reqPejabatPenetapId=$set_pejabat->id;
			unset($set_pejabat);
		}

		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken

			, 'reqTglStlud'=>$reqTglStlud
			, 'reqStlud'=>$reqStlud
			, 'reqNoStlud'=>$reqNoStlud
			, 'reqNoNota'=>$reqNoNota
			, 'reqNoSk'=>$reqNoSk
			, 'reqNoUrutCetak'=>$reqNoUrutCetak
			, 'reqTh'=>$reqTh
			, 'reqTempTh'=>$reqTempTh
			, 'reqBl'=>$reqBl
			, 'reqTempBl'=>$reqTempBl
			, 'reqKredit'=>$reqKredit
			, 'reqJenisKp'=>$reqJenisKp
			, 'reqKeterangan'=>$reqKeterangan
			, 'reqGajiPokok'=>$reqGajiPokok
			, 'reqTglNota'=>$reqTglNota
			, 'reqTglSk'=>$reqTglSk
			, 'reqTmtGol'=>$reqTmtGol
			, 'reqPejabatPenetapId'=>$reqPejabatPenetapId
			, 'reqPejabatPenetap'=>$reqPejabatPenetap
			, 'reqGolRuang'=>$reqGolRuang
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("pangkat_riwayat_json", $data);
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