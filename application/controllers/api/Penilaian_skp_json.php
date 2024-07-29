<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Penilaian_skp_json extends CI_Controller {

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
		
		$reqPenilaianSkpDinilaiNama = $this->input->post('reqPenilaianSkpDinilaiNama');
		$reqPenilaianSkpDinilaiNip = $this->input->post('reqPenilaianSkpDinilaiNip');
		$reqSatkerAtasan = $this->input->post('reqSatkerAtasan');
		$reqPenilaianSkpDinilaiId = $this->input->post('reqPenilaianSkpDinilaiId');

		$reqTahun = $this->input->post('reqTahun');
		$reqPegawaiJenisJabatan = $this->input->post('reqPegawaiJenisJabatan');
		$reqPegawaiUnorNama = $this->input->post('reqPegawaiUnorNama');
		$reqPegawaiUnorId = $this->input->post('reqPegawaiUnorId');

		$reqPenilaianSkpPenilaiId = $this->input->post('reqPenilaianSkpPenilaiId');
		$reqPenilaianSkpPenilaiNama = $this->input->post('reqPenilaianSkpPenilaiNama');
		$reqPenilaianSkpPenilaiNip = $this->input->post('reqPenilaianSkpPenilaiNip');
		$reqPenilaianSkpPenilaiJabatanNama = $this->input->post('reqPenilaianSkpPenilaiJabatanNama');
		$reqPenilaianSkpPenilaiUnorNama = $this->input->post('reqPenilaianSkpPenilaiUnorNama');
		$reqPenilaianSkpPenilaiPangkatId = $this->input->post('reqPenilaianSkpPenilaiPangkatId');


		$reqPenilaianSkpAtasanId = $this->input->post('reqPenilaianSkpAtasanId');
		$reqPenilaianSkpAtasanNama = $this->input->post('reqPenilaianSkpAtasanNama');
		$reqPenilaianSkpAtasanNip = $this->input->post('reqPenilaianSkpAtasanNip');
		$reqPenilaianSkpAtasanJabatanNama = $this->input->post('reqPenilaianSkpAtasanJabatanNama');
		$reqPenilaianSkpAtasanUnorNama = $this->input->post('reqPenilaianSkpAtasanUnorNama');
		$reqPenilaianSkpAtasanPangkatId = $this->input->post('reqPenilaianSkpAtasanPangkatId');

		$reqSkpNilai = $this->input->post('reqSkpNilai');
		$reqSkpHasil = $this->input->post('reqSkpHasil');
		$reqOrientasiNilai = $this->input->post('reqOrientasiNilai'); 
		$reqIntegritasNilai = $this->input->post('reqIntegritasNilai');
		$reqKomitmenNilai = $this->input->post('reqKomitmenNilai'); 
		$reqDisiplinNilai = $this->input->post('reqDisiplinNilai'); 
		$reqKerjasamaNilai = $this->input->post('reqKerjasamaNilai'); 
		$reqKepemimpinanNilai = $this->input->post('reqKepemimpinanNilai'); 
		$reqJumlahNilai = $this->input->post('reqJumlahNilai');
		$reqRataNilai = $this->input->post('reqRataNilai'); 
		$reqPerilakuNilai = $this->input->post('reqPerilakuNilai'); 
		$reqPerilakuHasil = $this->input->post('reqPerilakuHasil'); 
		$reqPrestasiNilai = $this->input->post('reqPrestasiNilai'); 
		$reqPrestasiHasil = $this->input->post('reqPrestasiHasil'); 
		$reqKeberatan = $this->input->post('reqKeberatan');
		$reqTanggalKeberatan = $this->input->post('reqTanggalKeberatan'); 
		$reqTanggapan = $this->input->post('reqTanggapan'); 
		$reqTanggalTanggapan = $this->input->post('reqTanggalTanggapan'); 
		$reqKeputusan = $this->input->post('reqKeputusan'); 
		$reqTanggalKeputusan = $this->input->post('reqTanggalKeputusan');
		$reqRekomendasi = $this->input->post('reqRekomendasi'); 

		
		$reqPegawaiJenisJabatan2 = $this->input->post('reqPegawaiJenisJabatan2');
		$reqPegawaiUnorNama2 = $this->input->post('reqPegawaiUnorNama2');
		$reqPegawaiUnorId2 = $this->input->post('reqPegawaiUnorId2');
		
		$reqPenilaianSkpPenilaiId2 = $this->input->post("reqPenilaianSkpPenilaiId2");
		$reqPenilaianSkpPenilaiNama2 = $this->input->post('reqPenilaianSkpPenilaiNama2');
		$reqPenilaianSkpPenilaiNip2 = $this->input->post('reqPenilaianSkpPenilaiNip2');
		$reqPenilaianSkpPenilaiJabatanNama2 = $this->input->post('reqPenilaianSkpPenilaiJabatanNama2');
		$reqPenilaianSkpPenilaiUnorNama2 = $this->input->post('reqPenilaianSkpPenilaiUnorNama2');
		$reqPenilaianSkpPenilaiPangkatId2 = $this->input->post('reqPenilaianSkpPenilaiPangkatId2');

		$reqPenilaianSkpAtasanId2 = $this->input->post("reqPenilaianSkpAtasanId2");
		$reqPenilaianSkpAtasanNama2 = $this->input->post('reqPenilaianSkpAtasanNama2');
		$reqPenilaianSkpAtasanNip2 = $this->input->post('reqPenilaianSkpAtasanNip2');
		$reqPenilaianSkpAtasanJabatanNama2 = $this->input->post('reqPenilaianSkpAtasanJabatanNama2');
		$reqPenilaianSkpAtasanUnorNama2 = $this->input->post('reqPenilaianSkpAtasanUnorNama2');
		$reqPenilaianSkpAtasanPangkatId2 = $this->input->post('reqPenilaianSkpAtasanPangkatId2');

		$reqSkpNilai2 = $this->input->post('reqSkpNilai2');
		$reqSkpHasil2 = $this->input->post('reqSkpHasil2');
		$reqOrientasiNilai2 = $this->input->post('reqOrientasiNilai2'); 
		$reqKomitmenNilai2 = $this->input->post('reqKomitmenNilai2'); 
		$reqKerjasamaNilai2 = $this->input->post('reqKerjasamaNilai2'); 
		$reqKepemimpinanNilai2 = $this->input->post('reqKepemimpinanNilai2');
		$reqInisiatifkerjaNilai2 = $this->input->post('reqInisiatifkerjaNilai2');
		$reqJumlahNilai2= $this->input->post('reqJumlahNilai2'); 
		$reqRataNilai2= $this->input->post('reqRataNilai2');
		
		$reqNilaiHasilKerja= $this->input->post('reqNilaiHasilKerja'); 
		$reqNilaiPerilakuKerja= $this->input->post('reqNilaiPerilakuKerja');
		

	
		$data= array(
			'reqId'=>$reqId
			, 'reqRowId'=>$reqRowId
			, 'reqTempValidasiId'=>$reqTempValidasiId
			, 'reqToken'=>$sessPersonalToken
			, 'reqMode'=>$reqMode

		, 'reqPenilaianSkpDinilaiNama'=>$reqPenilaianSkpDinilaiNama
		, 'reqPenilaianSkpDinilaiNip'=>$reqPenilaianSkpDinilaiNip
		, 'reqSatkerAtasan'=>$reqSatkerAtasan
		, 'reqPenilaianSkpDinilaiId'=>$reqPenilaianSkpDinilaiId
		, 'reqTahun'=>$reqTahun
		, 'reqPegawaiJenisJabatan'=>$reqPegawaiJenisJabatan
		, 'reqPegawaiUnorNama'=>$reqPegawaiUnorNama
		, 'reqPegawaiUnorId'=>$reqPegawaiUnorId
		, 'reqPenilaianSkpPenilaiId'=>$reqPenilaianSkpPenilaiId
		, 'reqPenilaianSkpPenilaiNama'=>$reqPenilaianSkpPenilaiNama
		, 'reqPenilaianSkpPenilaiNip'=>$reqPenilaianSkpPenilaiNip
		, 'reqPenilaianSkpPenilaiJabatanNama'=>$reqPenilaianSkpPenilaiJabatanNama
		, 'reqPenilaianSkpPenilaiUnorNama'=>$reqPenilaianSkpPenilaiUnorNama
		, 'reqPenilaianSkpPenilaiPangkatId'=>$reqPenilaianSkpPenilaiPangkatId
		, 'reqPenilaianSkpAtasanId'=>$reqPenilaianSkpAtasanId
		, 'reqPenilaianSkpAtasanNama'=>$reqPenilaianSkpAtasanNama
		, 'reqPenilaianSkpAtasanNip'=>$reqPenilaianSkpAtasanNip
		, 'reqPenilaianSkpAtasanJabatanNama'=>$reqPenilaianSkpAtasanJabatanNama
		, 'reqPenilaianSkpAtasanUnorNama'=>$reqPenilaianSkpAtasanUnorNama
		, 'reqPenilaianSkpAtasanPangkatId'=>$reqPenilaianSkpAtasanPangkatId
		, 'reqSkpNilai'=>$reqSkpNilai
		, 'reqSkpHasil'=>$reqSkpHasil
		, 'reqOrientasiNilai'=>$reqOrientasiNilai
		, 'reqIntegritasNilai'=>$reqIntegritasNilai
		, 'reqKomitmenNilai'=>$reqKomitmenNilai
		, 'reqDisiplinNilai'=>$reqDisiplinNilai
		, 'reqKerjasamaNilai'=>$reqKerjasamaNilai
		, 'reqKepemimpinanNilai'=>$reqKepemimpinanNilai
		, 'reqJumlahNilai'=>$reqJumlahNilai
		, 'reqRataNilai'=>$reqRataNilai
		, 'reqPerilakuNilai'=>$reqPerilakuNilai
		, 'reqPerilakuHasil'=>$reqPerilakuHasil
		, 'reqPrestasiNilai'=>$reqPrestasiNilai
		, 'reqPrestasiHasil'=>$reqPrestasiHasil
		, 'reqKeberatan'=>$reqKeberatan
		, 'reqTanggalKeberatan'=>$reqTanggalKeberatan
		, 'reqTanggapan'=>$reqTanggapan
		, 'reqTanggalTanggapan'=>$reqTanggalTanggapan
		, 'reqKeputusan'=>$reqKeputusan
		, 'reqTanggalKeputusan'=>$reqTanggalKeputusan
		, 'reqRekomendasi'=>$reqRekomendasi
		, 'reqPegawaiJenisJabatan2'=>$reqPegawaiJenisJabatan2
		, 'reqPegawaiUnorNama2'=>$reqPegawaiUnorNama2
		, 'reqPegawaiUnorId2'=>$reqPegawaiUnorId2
		, 'reqPenilaianSkpPenilaiId2'=>$reqPenilaianSkpPenilaiId2
		, 'reqPenilaianSkpPenilaiNama2'=>$reqPenilaianSkpPenilaiNama2
		, 'reqPenilaianSkpPenilaiNip2'=>$reqPenilaianSkpPenilaiNip2
		, 'reqPenilaianSkpPenilaiJabatanNama2'=>$reqPenilaianSkpPenilaiJabatanNama2
		, 'reqPenilaianSkpPenilaiUnorNama2'=>$reqPenilaianSkpPenilaiUnorNama2
		, 'reqPenilaianSkpPenilaiPangkatId2'=>$reqPenilaianSkpPenilaiPangkatId2
		, 'reqPenilaianSkpAtasanId2'=>$reqPenilaianSkpAtasanId2
		, 'reqPenilaianSkpAtasanNama2'=>$reqPenilaianSkpAtasanNama2
		, 'reqPenilaianSkpAtasanNip2'=>$reqPenilaianSkpAtasanNip2
		, 'reqPenilaianSkpAtasanJabatanNama2'=>$reqPenilaianSkpAtasanJabatanNama2
		, 'reqPenilaianSkpAtasanUnorNama2'=>$reqPenilaianSkpAtasanUnorNama2
		, 'reqPenilaianSkpAtasanPangkatId2'=>$reqPenilaianSkpAtasanPangkatId2
		, 'reqSkpNilai2'=>$reqSkpNilai2
		, 'reqSkpHasil2'=>$reqSkpHasil2
		, 'reqOrientasiNilai2'=>$reqOrientasiNilai2
		, 'reqKomitmenNilai2'=>$reqKomitmenNilai2
		, 'reqKerjasamaNilai2'=>$reqKerjasamaNilai2
		, 'reqKepemimpinanNilai2'=>$reqKepemimpinanNilai2
		, 'reqInisiatifkerjaNilai2'=>$reqInisiatifkerjaNilai2
		, 'reqJumlahNilai2'=>$reqJumlahNilai2
		, 'reqRataNilai2'=>$reqRataNilai2
		, 'reqNilaiHasilKerja'=>$reqNilaiHasilKerja
		, 'reqNilaiPerilakuKerja'=>$reqNilaiPerilakuKerja
		

		
		
		);

		$set= new DataCombo();
		$response= $set->updatepersonal("Penilaian_skp_json", $data);
		// print_r($response);exit;
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