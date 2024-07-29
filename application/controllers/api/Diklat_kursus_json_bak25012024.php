<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Diklat_kursus_json extends CI_Controller {

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
		// $files = $_FILES["reqLinkFile"];
		// print_r($files);
		// print_r($this->input->post());exit;

		$reqTempValidasiId= $this->input->post("reqTempValidasiId");
		$reqId = $this->input->post("reqId");
		$reqRowId= $this->input->post("reqRowId");

		$reqTipeKursus= $this->input->post('reqTipeKursus');
		$reqJenisKursusId= $this->input->post('reqJenisKursusId');
		$reqNamaKursus= $this->input->post('reqNamaKursus');
		$reqNoSertifikat= $this->input->post('reqNoSertifikat');
		$reqTglSertifikat= $this->input->post('reqTglSertifikat');
		$reqTglMulai= $this->input->post('reqTglMulai');
		$reqTglSelesai= $this->input->post('reqTglSelesai');
		$reqTahun= $this->input->post('reqTahun');
		$reqTempat= $this->input->post('reqTempat');
		$reqJumlahJam= $this->input->post('reqJumlahJam');
		$reqAngkatan= $this->input->post('reqAngkatan');
		$reqRumpunJabatan= $this->input->post('reqRumpunJabatan');
		$reqRefInstansiId= $this->input->post('reqRefInstansiId');
		$reqRefInstansi= $this->input->post('reqRefInstansi');
		$reqPenyelenggara= $this->input->post('reqPenyelenggara');
		$reqNilaiKompentensi= $this->input->post('reqNilaiKompentensi');
		$reqStatusLulus = $this->input->post('reqStatusLulus');
		$reqBidangTerkaitId = $this->input->post('reqBidangTerkaitId');

		$reqJenisKursus= $this->input->post('reqJenisKursus');
		$reqJenisKursusData= $this->input->post('reqJenisKursusData');
		if(!empty($reqJenisKursusId) && $reqJenisKursus !== $reqJenisKursusData)
		{
			$reqJenisKursusId= "";
		}

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
		// print_r($vpost);exit;
		/*

		$postfields = array();
		foreach ($reqLinkFile as $index => $file) {
		  if (function_exists('curl_file_create')) 
		  {
		    $file = curl_file_create($file);
		  } 
		  else 
		  {
		    $file = '@' . realpath($file);
		  }
		  $postfields["file_$index"] = $file;
		}
		print_r($postfields);exit;*/

		$data= array(
			"vpost"=>$vpost
			, "reqLinkFile"=>$reqLinkFile
			, "cekfile"=>1
			, 'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken
			, 'reqTipeKursus'=>$reqTipeKursus
			, 'reqJenisKursusId'=>$reqJenisKursusId
			, 'reqNamaKursus'=>$reqNamaKursus
			, 'reqNoSertifikat'=>$reqNoSertifikat
			, 'reqTglSertifikat'=>$reqTglSertifikat
			, 'reqTglMulai'=>$reqTglMulai
			, 'reqTglSelesai'=>$reqTglSelesai
			, 'reqTahun'=>$reqTahun
			, 'reqTempat'=>$reqTempat
			, 'reqJumlahJam'=>$reqJumlahJam
			, 'reqAngkatan'=>$reqAngkatan
			, 'reqRumpunJabatan'=>$reqRumpunJabatan
			, 'reqRefInstansiId'=>$reqRefInstansiId
			, 'reqRefInstansi'=>$reqRefInstansi
			, 'reqPenyelenggara'=>$reqPenyelenggara
			, 'reqNilaiKompentensi'=>$reqNilaiKompentensi
			, 'reqStatusLulus'=>$reqStatusLulus
			, 'reqJenisKursus'=>$reqJenisKursus
			, 'reqJenisKursusData'=>$reqJenisKursusData
			, 'reqBidangTerkaitId'=>$reqBidangTerkaitId
		);
		// print_r($data["vpost"]["reqDokumenRequired"][0]);exit;
		// print_r($data);exit;
		$data= urldecode(http_build_query($data));
		// $data= http_build_query($data);
		// print_r($data);exit;

		$set= new DataCombo();
		$response= $set->updatepersonal("diklat_kursus_json", $data, "");
		// print_r($response);exit();
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