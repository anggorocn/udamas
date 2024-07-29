<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class File_content extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('kauth');

		$CI =& get_instance();

        $configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];
        $settingurl= $configdata->config["settingurl"];
        $settingurlupload= $configdata->config["settingurlupload"];
        $replaceurlupload= $configdata->config["replaceurlupload"];

		if($this->session->userdata("PERSONAL_TOKEN".$configvlxsessfolder) == "")
		{
			redirect('login');
		}

		$this->MD5KEY = $this->config->item('md5key');
		$this->settingurl= $settingurl;
		$this->settingurlupload= $settingurlupload;
		$this->replaceurlupload= $replaceurlupload;

		$this->PERSONAL_TOKEN= $this->session->userdata("PERSONAL_TOKEN".$configvlxsessfolder);
		// $this->db->query("SET DATESTYLE TO PostgreSQL,European;");

		$this->arrContextOptions=array(
		  "ssl"=>array(
		    "verify_peer"=>false,
		    "verify_peer_name"=>false,
		  ),
		);
	}

	function content()
	{
		$reqUrl= $this->input->get("reqUrl");
        // print_r($this->arrContextOptions);

        $urllink= $reqUrl;
        $urllink= str_replace($this->settingurlupload, "", $urllink);
      	// echo $urllink;exit;
      	
      	$vblob= file_get_contents($urllink, false, stream_context_create($this->arrContextOptions));
      	$vblob= "data:application/pdf;base64,".base64_encode($vblob);
      	// print_r($vblob);exit;

        echo $vblob;
	}

}