<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Diklat_struktural_json extends CI_Controller {

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
		
		$reqDiklat= $this->input->post('reqDiklat');
		$reqTahun= $this->input->post('reqTahun');
		$reqNoSttpp= $this->input->post('reqNoSttpp');
		$reqPenyelenggara= $this->input->post('reqPenyelenggara');
		$reqAngkatan= $this->input->post('reqAngkatan');
		$reqTglMulai= $this->input->post('reqTglMulai');
		$reqTglSelesai= $this->input->post('reqTglSelesai');
		$reqTahun= $this->input->post('reqTahun');
		$reqTglSttpp= $this->input->post('reqTglSttpp');
		$reqTempat= $this->input->post('reqTempat');
		$reqJumlahJam= $this->input->post('reqJumlahJam');

		$reqJabatanRiwayatId= $this->input->post('reqJabatanRiwayatId');
		$reqRumpunJabatan= $this->input->post('reqRumpunJabatan');
		$reqNilaiKompentensi= $this->input->post('reqNilaiKompentensi');

		// $vpost= $this->input->post();
		$vpost= array(
			"reqDokumenRequired"=>$this->input->post('reqDokumenRequired')
			, "reqDokumenRequiredNama"=>$this->input->post('reqDokumenRequiredNama')
			, "reqDokumenRequiredTable"=>$this->input->post('reqDokumenRequiredTable')
			, "reqDokumenRequiredTableRow"=>$this->input->post('reqDokumenRequiredTableRow')
			, "reqDokumenFileId"=>$this->input->post('reqDokumenFileId')
			, "reqDokumenKategoriFileId"=>$this->input->post('reqDokumenKategoriFileId')
			, "reqDokumenKategoriField"=>$this->input->post('reqDokumenKategoriField')
			, "reqDokumenPath"=>$this->input->post('reqDokumenPath')
			, "reqDokumenTipe"=>$this->input->post('reqDokumenTipe')
			, "reqDokumenPilih"=>$this->input->post('reqDokumenPilih')
			, "reqDokumenFileKualitasId"=>$this->input->post('reqDokumenFileKualitasId')
			, "reqDokumenIndexId"=>$this->input->post('reqDokumenIndexId')
		);

		$vLinkFile= $_FILES['reqLinkFile'];
		// print_r($vLinkFile);exit;

		$reqLinkFile= "";
		if(!empty($vLinkFile))
		{
			$reqLinkFile= $this->kauth->setcekfile($vLinkFile);
		}
		// print_r($reqLinkFile);exit;
	
		$data= array(
			"vpost"=>$vpost
			, "reqLinkFile"=>$reqLinkFile
			, "cekfile"=>1
			, 'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken
			, 'reqMode'=>$reqMode
			, 'reqDiklat'=>$reqDiklat
			, 'reqTahun'=>$reqTahun
			, 'reqNoSttpp'=>$reqNoSttpp
			, 'reqPenyelenggara'=>$reqPenyelenggara
			, 'reqAngkatan'=>$reqAngkatan
			, 'reqTglMulai'=>$reqTglMulai
			, 'reqTglSelesai'=>$reqTglSelesai
			, 'reqTglSttpp'=>$reqTglSttpp
			, 'reqGolRuang'=>$reqGolRuang
			, 'reqTempat'=>$reqTempat
			, 'reqJumlahJam'=>$reqJumlahJam
			, 'reqJabatanRiwayatId'=>$reqJabatanRiwayatId
			, 'reqRumpunJabatan'=>$reqRumpunJabatan
			, 'reqNilaiKompentensi'=>$reqNilaiKompentensi
		);
		$data= urldecode(http_build_query($data));

		$set= new DataCombo();
		$response= $set->updatepersonal("Diklat_struktural_json", $data, "");
		// print_r($response);exit;
		$returnStatus= $response->status;
		$returnId= $response->id;

		$simpan="";
		if($returnStatus == "success")
		{
			$reqId= $returnId;

			if(empty($reqTempValidasiId))
			{
				$reqTempValidasiId= $reqId;
			}
			$simpan=1;
		}
		else if($returnStatus == "cekfile")
		{
			echo json_response(400, $response->message);
			exit;
		}

		if($simpan == "1")
		{
			$arrparam= ["reqToken"=>$sessPersonalToken, "reqRowId"=>$reqRowId, "reqTempValidasiId"=>$reqTempValidasiId];
			$this->kauth->setfile($vpost, $vLinkFile, $arrparam);
			
			echo json_response(200, $reqId.'-Data berhasil disimpan');
		}
		else
		{
			echo json_response(400, 'Data gagal disimpan');
		}
	}

}