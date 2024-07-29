<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit","800M");

class Integrasi extends CI_Controller {

	function __construct() {
		parent::__construct();

		if($this->session->userdata("HAK_AKSES") == "")
		{
		}

		$this->ID = $this->session->userdata('ID');
		$this->db->query("SET DATESTYLE TO PostgreSQL,European;");

	}


	public function pegawai()
	{

		/* API */
		$ch = curl_init();
		$data = array();

		$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjAzOjgwODAiLCJzdWIiOiJlZWQ1ODEzYy0xZGQ4LTUzYzEtODg4Mi0yY2NkNGM2ZWRkZTMiLCJpYXQiOjE2ODAxNDQxMDAsImV4cCI6MTY4MDMxNjkwMCwibmFtZSI6ImNvbnN1bWVyLnByZXNlbnNpIn0.M32XKynUDuUrzjVogiLzfzf0AI4-FTY_wy28x3ZYE88";

		
		curl_setopt($ch, CURLOPT_URL, $this->config->item("base_api_ellipse")."pegawai");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response, true);

		$totalResults 	= $response["totalResults"];
		$itemsPerPage 	= $response["itemsPerPage"];
		$startIndex 	= $response["startIndex"];
		$rowResult  	= $response["entry"];

		$jumlah = 0;


		$sql = " TRUNCATE TABLE INTEGRASI_PEGAWAI ";
		$this->db->query($sql);

		foreach($rowResult as $row)
		{

			$PEGAWAI_ID = $row["PEGAWAI_ID"];
			$CABANG_ID 	= $row["CABANG_ID"];
			$STATUS_WFH = $row["STATUS_WFH"];

			$sql = " INSERT INTO INTEGRASI_PEGAWAI(PEGAWAI_ID, CABANG_ID, STATUS_WFH) VALUES('$PEGAWAI_ID', '$CABANG_ID', '$STATUS_WFH') ";
			$this->db->query($sql);


			$jumlah++;
		}

		$sql =  " SELECT sinkronisasi_pegawai() hasil ";
		$hasilSinkronisasi = $this->db->query($sql)->first_row()->hasil; 

		$result["status"]  = "success";
		$result["message"] = $jumlah." data pegawai berhasil disinkronisasi.";

		echo json_encode($result);


	}



	public function titikabsen()
	{

		/* API */
		$ch = curl_init();
		$data = array();

		$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjAzOjgwODAiLCJzdWIiOiJlZWQ1ODEzYy0xZGQ4LTUzYzEtODg4Mi0yY2NkNGM2ZWRkZTMiLCJpYXQiOjE2ODAxNDQxMDAsImV4cCI6MTY4MDMxNjkwMCwibmFtZSI6ImNvbnN1bWVyLnByZXNlbnNpIn0.M32XKynUDuUrzjVogiLzfzf0AI4-FTY_wy28x3ZYE88";

		
		curl_setopt($ch, CURLOPT_URL, $this->config->item("base_api_ellipse")."titikabsen");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response, true);

		$totalResults 	= $response["totalResults"];
		$itemsPerPage 	= $response["itemsPerPage"];
		$startIndex 	= $response["startIndex"];
		$rowResult  	= $response["entry"];

		$jumlah = 0;


		$sql = " TRUNCATE TABLE INTEGRASI_TITIK_ABSEN ";
		$this->db->query($sql);

		foreach($rowResult as $row)
		{

			$PEGAWAI_ID = $row["PEGAWAI_ID"];
			$CABANG_ID 	= $row["CABANG_ID"];
			$LATITUDE 	= $row["LATITUDE"];
			$LONGITUDE 	= $row["LONGITUDE"];
			$RADIUS 	= $row["RADIUS"];

			$sql = " INSERT INTO INTEGRASI_TITIK_ABSEN(PEGAWAI_ID, CABANG_ID, LATITUDE, LONGITUDE, RADIUS) VALUES('$PEGAWAI_ID', '$CABANG_ID', '$LATITUDE', '$LONGITUDE', '$RADIUS') ";
			$this->db->query($sql);


			$jumlah++;
		}


		$sql =  " SELECT sinkronisasi_titik_absen() hasil ";
		$hasilSinkronisasi = $this->db->query($sql)->first_row()->hasil; 


		$result["status"]  = "success";
		$result["message"] = $jumlah." data titik absen berhasil disinkronisasi.";

		echo json_encode($result);


	}



}

