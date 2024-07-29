<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Penilaian_kinerja_json extends CI_Controller {

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

	function comboNilaiKuadran(){
		$this->load->model('base-curl/DataCombo');
		$reqId = $this->input->get('reqId');
		$sessPersonalToken= $this->PERSONAL_TOKEN;
		$arrNilaiKuadran= [];
		$set= new DataCombo();
		$arrdata = array("reqId"=>$reqId);
		$set->selectby($sessPersonalToken, "nilaikuadran", $arrdata);
		$arrNilaiKuadran = $set->rowResult;
		$arrNilaiKuadran = array_change_key_case_recursive_upper($arrNilaiKuadran);
		echo json_encode($arrNilaiKuadran);
		
	}

}