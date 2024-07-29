<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Ganti_password_json extends CI_Controller {

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
		$reqMode= "reset_password";
		$reqId = $this->input->post("reqId");
		$reqRowId= $this->input->post("reqRowId");
		$reqPasswordBaru = $this->input->post("reqPasswordBaru");
		$reqPasswordUlangi = $this->input->post("reqPasswordUlangi");
		$reqNama = $this->input->post("reqNama");
		$reqLoginUser = $this->input->post("reqLoginUser");	
		$reqSatkerId = $this->input->post("reqSatkerId");		
		$reqPasswordLama = $this->input->post('reqPasswordLama');

		if($reqPasswordBaru==$reqPasswordUlangi){}else{
				echo json_response(400, 'Data gagal disimpan pastikan isian kedua password baru sama.');
				exit;
		}
		// print_r($reqBpjs);exit;

		$data= array(
			'reqId'=>$reqId
			, 'reqMode'=>$reqMode
			, 'reqRowId'=>$reqRowId
			, 'reqPasswordBaru'=>$reqPasswordBaru
			, 'reqPasswordLama'=>$reqPasswordLama

			, 'reqNama'=>$reqNama
			, 'reqLoginUser'=>$reqLoginUser
			, 'reqSatkerId'=>$reqSatkerId
			, 'reqToken'=>$sessPersonalToken
		);


	
		$set= new DataCombo();
		$response= $set->updatepersonal("Ganti_password_json", $data, "");
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
			echo json_response(200, 'Data berhasil disimpan');
		}
		else
		{
			echo json_response(400, 'Data gagal disimpan '.$response->message);
		}
	}

}