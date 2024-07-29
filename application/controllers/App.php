<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class App extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('Kauth');

		$CI =& get_instance();

		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];
        $settingurl= $configdata->config["settingurl"];
        $settingurlupload= $configdata->config["settingurlupload"];
        $replaceurlupload= $configdata->config["replaceurlupload"];

		if($this->session->userdata("PERSONAL_TOKEN".$configvlxsessfolder) == "")
		{
			// echo 'token habis';exit;
			redirect('login');
		}

		$this->MD5KEY = $this->config->item('md5key');
		$this->settingurl= $settingurl;
		$this->settingurlupload= $settingurlupload;
		$this->replaceurlupload= $replaceurlupload;

		$this->PERSONAL_TOKEN= $this->session->userdata("PERSONAL_TOKEN".$configvlxsessfolder);
		// $this->db->query("SET DATESTYLE TO PostgreSQL,European;");

		$this->STATUS_DATA_UTAMA= $this->session->userdata("STATUS_DATA_UTAMA".$configvlxsessfolder);
		$this->ICON_DATA_UTAMA= $this->session->userdata("ICON_DATA_UTAMA".$configvlxsessfolder);
		$this->STATUS_SK_CPNS= $this->session->userdata("STATUS_SK_CPNS".$configvlxsessfolder);
		$this->ICON_SK_CPNS= $this->session->userdata("ICON_SK_CPNS".$configvlxsessfolder);
		$this->STATUS_SK_PNS= $this->session->userdata("STATUS_SK_PNS".$configvlxsessfolder);
		$this->ICON_SK_PNS= $this->session->userdata("ICON_SK_PNS".$configvlxsessfolder);
		$this->STATUS_SK_PPPK= $this->session->userdata("STATUS_SK_PPPK".$configvlxsessfolder);
		$this->ICON_SK_PPPK= $this->session->userdata("ICON_SK_PPPK".$configvlxsessfolder);
		$this->STATUS_PANGKAT= $this->session->userdata("STATUS_PANGKAT".$configvlxsessfolder);
		$this->ICON_PANGKAT= $this->session->userdata("ICON_PANGKAT".$configvlxsessfolder);
		$this->STATUS_GAJI= $this->session->userdata("STATUS_GAJI".$configvlxsessfolder);
		$this->ICON_GAJI= $this->session->userdata("ICON_GAJI".$configvlxsessfolder);
		$this->STATUS_JABATAN= $this->session->userdata("STATUS_JABATAN".$configvlxsessfolder);
		$this->ICON_JABATAN= $this->session->userdata("ICON_JABATAN".$configvlxsessfolder);
		$this->STATUS_TUGAS= $this->session->userdata("STATUS_TUGAS".$configvlxsessfolder);
		$this->ICON_TUGAS= $this->session->userdata("ICON_TUGAS".$configvlxsessfolder);
		$this->STATUS_PENDIDIKAN= $this->session->userdata("STATUS_PENDIDIKAN".$configvlxsessfolder);
		$this->ICON_PENDIDIKAN= $this->session->userdata("ICON_PENDIDIKAN".$configvlxsessfolder);
		$this->STATUS_DIKLAT_STRUKTURAL= $this->session->userdata("STATUS_DIKLAT_STRUKTURAL".$configvlxsessfolder);
		$this->ICON_DIKLAT_STRUKTURAL= $this->session->userdata("ICON_DIKLAT_STRUKTURAL".$configvlxsessfolder);
		$this->STATUS_DIKLAT_KURSUS= $this->session->userdata("STATUS_DIKLAT_KURSUS".$configvlxsessfolder);
		$this->ICON_DIKLAT_KURSUS= $this->session->userdata("ICON_DIKLAT_KURSUS".$configvlxsessfolder);
		$this->STATUS_CUTI= $this->session->userdata("STATUS_CUTI".$configvlxsessfolder);
		$this->ICON_CUTI= $this->session->userdata("ICON_CUTI".$configvlxsessfolder);
		$this->STATUS_SKP_PPK= $this->session->userdata("STATUS_SKP_PPK".$configvlxsessfolder);
		$this->ICON_SKP_PPK= $this->session->userdata("ICON_SKP_PPK".$configvlxsessfolder);
		$this->STATUS_PAK= $this->session->userdata("STATUS_PAK".$configvlxsessfolder);
		$this->ICON_PAK= $this->session->userdata("ICON_PAK".$configvlxsessfolder);
		$this->STATUS_KOMPETENSI= $this->session->userdata("STATUS_KOMPETENSI".$configvlxsessfolder);
		$this->ICON_KOMPETENSI= $this->session->userdata("ICON_KOMPETENSI".$configvlxsessfolder);
		$this->STATUS_PENGHARGAAN= $this->session->userdata("STATUS_PENGHARGAAN".$configvlxsessfolder);
		$this->ICON_PENGHARGAAN= $this->session->userdata("ICON_PENGHARGAAN".$configvlxsessfolder);
		$this->STATUS_PENINJAUAN_MASA_KERJA= $this->session->userdata("STATUS_PENINJAUAN_MASA_KERJA".$configvlxsessfolder);
		$this->ICON_PENINJAUAN_MASA_KERJA= $this->session->userdata("ICON_PENINJAUAN_MASA_KERJA".$configvlxsessfolder);
		$this->STATUS_SURAT_TANDA_LULUS= $this->session->userdata("STATUS_SURAT_TANDA_LULUS".$configvlxsessfolder);
		$this->ICON_SURAT_TANDA_LULUS= $this->session->userdata("ICON_SURAT_TANDA_LULUS".$configvlxsessfolder);
		$this->STATUS_SUAMI_ISTRI= $this->session->userdata("STATUS_SUAMI_ISTRI".$configvlxsessfolder);
		$this->ICON_SUAMI_ISTRI= $this->session->userdata("ICON_SUAMI_ISTRI".$configvlxsessfolder);
		$this->STATUS_ANAK= $this->session->userdata("STATUS_ANAK".$configvlxsessfolder);
		$this->ICON_ANAK= $this->session->userdata("ICON_ANAK".$configvlxsessfolder);
		$this->STATUS_ORANG_TUA_ADD= $this->session->userdata("STATUS_ORANG_TUA_ADD".$configvlxsessfolder);
		$this->ICON_ORANG_TUA_ADD= $this->session->userdata("ICON_ORANG_TUA_ADD".$configvlxsessfolder);
		$this->STATUS_SAUDARA= $this->session->userdata("STATUS_SAUDARA".$configvlxsessfolder);
		$this->ICON_SAUDARA= $this->session->userdata("ICON_SAUDARA".$configvlxsessfolder);
		$this->STATUS_MERTUA_ADD= $this->session->userdata("STATUS_MERTUA_ADD".$configvlxsessfolder);
		$this->ICON_MERTUA_ADD= $this->session->userdata("ICON_MERTUA_ADD".$configvlxsessfolder);
		$this->STATUS_BAHASA= $this->session->userdata("STATUS_BAHASA".$configvlxsessfolder);
		$this->ICON_BAHASA= $this->session->userdata("ICON_BAHASA".$configvlxsessfolder);
	}

	public function index()
	{
		$reqToken = $this->uri->segment(3);
		$userdata = $this->input->get("userdata");
	
		$arrData = $this->_mypower_decrypt($userdata);

		$jmlData = count($arrData);

		if($jmlData == 0)
		{
			// redirect("app/notifikasi");
			// exit;
		}
				

		/* sementara */
		$reqPegawaiId 	= $arrData["nid"];
		$reqPegawai 	= $arrData["nid"];
		$reqLongitude 	= $arrData["lon"];
		$reqLatitude 	= $arrData["lat"];

		// tambahan untuk abd
		$pg = $this->uri->segment(3, "home");
		// echo $pg;exit;

		$view = array(
			'pg' => $pg,
			'reqPegawaiId' 	=> $reqPegawaiId,
			'reqPegawai' 	=> $reqPegawai,
			'reqLongitude' 	=> $reqLongitude,
			'reqLatitude' 	=> $reqLatitude
		);	
		
		$data = array(
			'breadcrumb' 	=> $breadcrumb,
			// tambahan untuk abd
			// 'content' 		=> $this->load->view("app/home",$view,TRUE),
			'content' => $this->load->view("app/".$pg,$view,TRUE),
			'reqPegawaiId' 	=> $reqPegawaiId,
			'reqPegawai' 	=> $reqPegawai,
			'reqLongitude' 	=> $reqLongitude,
			'reqLatitude' 	=> $reqLatitude
		);	
		
		$this->load->view('app/index', $data);
	}

	public function logout()
	{
		$this->kauth->unsettoken();
		redirect ('login');
	}

	public function notifikasi()
	{
		$pg = $this->uri->segment(3, "pesan");

		$pesan = "Mohon Maaf, sesi anda telah berakhir. Silahkan cek kembali token Anda.";

		$view = array(
			'pg' => "notifikasi",
			'pesan' => ($pesan)
		);	
		
		$data = array(
			'breadcrumb' => $breadcrumb,
			'content' => $this->load->view("app/pesan",$view,TRUE),
			'pg' => "notifikasi",
			'pesan' => ($pesan)
		);	
		
		$this->load->view('app/index', $data);

	
	}

	function _mypower_decrypt($encdata)
	{
	    $encdata = str_replace(" ","+",$encdata);
	    define('AES_256_CBC', 'aes-256-cbc');
	    $encryption_key = 'eightghaxonly'; //openssl_random_pseudo_bytes(32);
	    $hasil = @openssl_decrypt($encdata, AES_256_CBC, str_pad($encryption_key,32), 0, openssl_cipher_iv_length(AES_256_CBC));
	    parse_str($hasil, $userdata);
	    // echo "<pre>".print_r($userdata,true);exit;
	    return $userdata;
	}

	public function loadUrl()
	{

		$reqFolder = $this->uri->segment(3, "");
		$reqFilename = $this->uri->segment(4, "");
		$reqParse1 = $this->uri->segment(5, "");
		$reqParse2 = $this->uri->segment(6, "");
		$reqParse3 = $this->uri->segment(7, "");
		$reqParse4 = $this->uri->segment(8, "");
		$reqParse5 = $this->uri->segment(9, "");
		$data = array(
			'reqParse1' => urldecode($reqParse1),
			'reqParse2' => urldecode($reqParse2),
			'reqParse3' => urldecode($reqParse3),
			'reqParse4' => urldecode($reqParse4),
			'reqParse5' => urldecode($reqParse5)
		);
		$this->load->view($reqFolder.'/'.$reqFilename, $data);
	}

	function presensi()
	{

		$TOKEN 		= $this->input->post("TOKEN");
		$PEGAWAI_ID = $this->input->post("PEGAWAI_ID");
		$LONGITUDE 	= $this->input->post("LONGITUDE");
		$LATITUDE 	= $this->input->post("LATITUDE");
		$JAM_ABSEN  = $this->db->query(" select to_char(current_timestamp, 'dd-mm-yyyy hh24:mi:ss') jam_absen ")->first_row()->jam_absen;

		$JAM_ABSEN_INFO = explode(" ", $JAM_ABSEN);
		$JAM_ABSEN_INFO = $JAM_ABSEN_INFO[1];
		$JAM_ABSEN_INFO = substr($JAM_ABSEN_INFO, 0, 5);


		$sql = " select pegawai_id from pegawai where md5(pegawai_id || '".$this->MD5KEY."') = '$PEGAWAI_ID' ";
		$PEGAWAI_ID = $this->db->query($sql)->first_row()->pegawai_id;

		$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_PLNNP_presens1'.date("dmyH"));


		if (!$csrf->isTokenValid($TOKEN) || empty($PEGAWAI_ID))
		{

			$result["color"] 	= "red";
			$result["status"] 	= "failed";
			$result["message"] 	= "Token Failed.";
			echo json_encode($result);
			return;

		}
		
		$arrHasil = $this->get_presensi_radius($PEGAWAI_ID, $LATITUDE, $LONGITUDE);

		$hasilStatus 		= $arrHasil["status"];
		$jarakTerdekat 		= $arrHasil["jarak_terdekat"];
		$radiusAbsen 		= $arrHasil["radius"];
		$CABANG_ID_ABSEN 	= $arrHasil["cabang_id"];


		if($hasilStatus == "T")
		{

			if($jarakTerdekat == "")
			{
				$result["color"] 	= "red";
				$result["status"] 	= "failed";
				$result["message"] 	= "Titik lokasi presensi tidak ditemukan. Hubungi administrator.";
			}
			else
			{
				$komparasiJarak = round($jarakTerdekat);

				if($komparasiJarak >= 1000)
				{	
					$komparasiJarak = $komparasiJarak / 1000;
					$komparasiJarak = round($komparasiJarak, 2);
					$pesanJarak = numberToIna($komparasiJarak)." kilometer";
				}
				else
					$pesanJarak = numberToIna($komparasiJarak)." meter";


				$sql = "  
							INSERT INTO absensi(
							    pegawai_id, cabang_id_absen, jam, 
							    status, validasi, jarak, alat, 
							    latitude, longitude, 
							    last_create_user, last_create_date)
							VALUES(
							    '$PEGAWAI_ID', '$CABANG_ID_ABSEN', TO_TIMESTAMP('$JAM_ABSEN', 'dd-mm-yyyy hh24:mi:ss'), 
							    '1', '0', '$jarakTerdekat', 'CLOUD', 
							    '$LATITUDE', '$LONGITUDE', 
							    'CLOUD', current_timestamp)
					   ";
				$this->db->query($sql);

				$result["color"] 	= "red";
				$result["status"] 	= "failed";
				$result["message"] 	= "Presensi gagal. Anda berada ".$pesanJarak." dari lokasi presensi terdekat (toleransi radius : ".$radiusAbsen." meter).";
				$result["jam"] 		= "";
			}

			echo json_encode($result);
			return;
		}


		$sql = "  
					INSERT INTO absensi(
					    pegawai_id, cabang_id_absen, jam, 
					    status, validasi, jarak, alat, 
					    latitude, longitude, 
					    last_create_user, last_create_date)
					VALUES(
					    '$PEGAWAI_ID', '$CABANG_ID_ABSEN', TO_TIMESTAMP('$JAM_ABSEN', 'dd-mm-yyyy hh24:mi:ss'), 
					    '1', '1', '$jarakTerdekat', 'CLOUD', 
					    '$LATITUDE', '$LONGITUDE', 
					    'CLOUD', current_timestamp)
			   ";
		$this->db->query($sql);



		$result["color"] 	= "green";
		$result["status"] 	= "success";
		$result["message"] 	= "Presensi berhasil disimpan.";
		$result["jam"] 		= $JAM_ABSEN_INFO;

		echo json_encode($result);

	}

	function get_presensi_radius($pegawai_id, $pegawai_lat, $pegawai_long)
	{

		$sql = " SELECT cabang_id, latitude, longitude, radius FROM titik_absen WHERE pegawai_id = '$pegawai_id' ";

		$rowResult = $this->db->query($sql)->result_array();


		$jarakTerdekat = 99999999999;
		
		$adaData = 0;

		foreach($rowResult as $row)
		{
			$latitude 	= $row["latitude"];
			$longitude 	= $row["longitude"];
			$radius 	= $row["radius"];
			$cabang_id 	= $row["cabang_id"];

			$jarakMeter 	= $this->distance($pegawai_lat, $pegawai_long, $latitude, $longitude);



			if($jarakMeter < $jarakTerdekat)
				$jarakTerdekat = $jarakMeter;


			if($jarakMeter <= $radius)
			{
				$result["status"] = "Y";
				$result["jarak_terdekat"] = $jarakTerdekat;
				$result["radius"] = $radius;
				$result["cabang_id"] = $cabang_id;

				return $result;

			}

			$adaData++;

		}

		if($adaData == 0)
		{

			$result["status"] = "T";
			$result["jarak_terdekat"] = "";
			$result["radius"] = "";
			$result["cabang_id"] = "";
			return $result;

		}

		$result["status"] = "T";
		$result["jarak_terdekat"] = $jarakTerdekat;
		$result["radius"] = $radius;
		$result["cabang_id"] = $cabang_id;
		return $result;


	}

	function distance($lat1, $lon1, $lat2, $lon2, $unit="M") {

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
		  return ($miles * 1.609344);
		} else if ($unit == "M") {
		  return ($miles * 1.609344 * 1000);;
		} else {
		  return $miles;
		}


	}


	function log_presensi()
	{

		$TOKEN 		= $this->input->post("TOKEN");
		$PEGAWAI_ID = $this->input->post("PEGAWAI_ID");
		$MODE 		= $this->input->post("MODE");

		$sql = " select pegawai_id from pegawai where md5(pegawai_id || '".$this->MD5KEY."') = '$PEGAWAI_ID' ";
		$PEGAWAI_ID = $this->db->query($sql)->first_row()->pegawai_id;

		$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_PLNNP_presens1_log'.date("dmyH"));

		if (!$csrf->isTokenValid($TOKEN) || empty($PEGAWAI_ID))
		{

			$result["status"] 	= "failed";
			$result["message"] 	= "Token Failed.";
			$result["rownum"] 	= 0;
			echo json_encode($result);
			return;

		}

		$LIMIT = "10";
		if($MODE == "refresh")
			$LIMIT = "1";

		$sql = " SELECT * FROM (
					SELECT TO_CHAR(JAM, 'DD Mon YYYY') TANGGAL, TO_CHAR(JAM, 'HH24:MI') JAM, 
						CASE WHEN VALIDASI = '1' THEN 'hijau' ELSE 'merah' END INDIKATOR 
					FROM ABSENSI A WHERE PEGAWAI_ID = '$PEGAWAI_ID' AND JAM >= CURRENT_TIMESTAMP - INTERVAL '7' DAY
				 	ORDER BY A.JAM DESC 
				 ) A LIMIT ".$LIMIT;

		$rowResult = $this->db->query($sql)->result_array();



		$result["status"] 	= "success";
		$result["message"] 	= "success";
		$result["result"] 	= $rowResult;
		$result["rownum"] 	= count($rowResult);
		echo json_encode($result);
		return;

	}

}

