<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class Combo extends CI_Controller {

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

	function jeniskursus()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "jeniskursus", $arrdata, "");
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("REF_JENIS_KURSUS_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$arr_json[$i]['rumpun_id'] = $set->getField("RUMPUN_ID");
			$arr_json[$i]['rumpun_nama'] = $set->getField("RUMPUN_NAMA");
			$i++;
		}
		if($i == 0)
		{
			$arr_json[$j]['id'] = "";
			$arr_json[$j]['label'] = "";
			$arr_json[$j]['desc'] = "";
			$arr_json[$j]['rumpun_id'] = "";
			$arr_json[$j]['rumpun_nama'] = "";
		}
        echo json_encode($arr_json);
	}

	function instansi()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "instansi", $arrdata,'');
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("REF_INSTANSI_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
		if($i == 0)
		{
			$arr_json[$j]['id'] = "";
			$arr_json[$j]['label'] = "";
			$arr_json[$j]['desc'] = "";
		}
        echo json_encode($arr_json);
	}

	function gajipokok() 
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;
		$reqPangkatId= $this->input->get("reqPangkatId");
		$reqMasaKerja= $this->input->get("reqMasaKerja");
		$reqTglSk= $this->input->get("reqTglSk");

		$tempPeriode= str_replace("-","",$reqTglSk);
		$arrdata= array(
			"reqPeriode"=>$tempPeriode
			, "reqMasaKerja"=>$reqMasaKerja
			, "reqPangkatId"=>$reqPangkatId
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "gajipokok", $arrdata);
		$set->firstRow();
		$tempGajiPokok= $set->getField("data");
		if($tempGajiPokok == "")
			$tempGajiPokok= 0;

		echo $tempGajiPokok;
	}

	function jabatanfu()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "jabatanfu", $arrdata);

		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("JABATAN_FU_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['satuan_kerja'] = $set->getField("SATUAN_KERJA_NAMA_DETIL");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
		/*foreach ($arrdata as $obj)
        {
        	$arr_json[$i]['id'] = $obj->id;
			$arr_json[$i]['label'] = $obj->label;
			$arr_json[$i]['satuan_kerja'] = $obj->satuan_kerja;
			$arr_json[$i]['desc'] = $obj->desc;
			$i++;
        }
        print_r($arrdata);exit;*/
        echo json_encode($arr_json);
	}

	function jabatanft()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "jabatanft", $arrdata);
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("JABATAN_FT_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['satuan_kerja'] = $set->getField("SATUAN_KERJA_NAMA_DETIL");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
        echo json_encode($arr_json);
	}

	function pejabatpenetap()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "pejabatpenetap", $arrdata);
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PEJABAT_PENETAP_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
        echo json_encode($arr_json);
	}

	function suamiistri()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");
		$reqId= $this->input->get("reqId");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
			, "reqId"=>$reqId
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "suamiistri", $arrdata);
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("SUAMI_ISTRI_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
        echo json_encode($arr_json);
	}

	function jurusan()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "jurusan", $arrdata);
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PENDIDIKAN_JURUSAN_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
        echo json_encode($arr_json);
	}

	function jurusanpppk()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");
		$reqId= $this->input->get("reqId");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
			,"reqId"=>$reqId
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "jurusan_pppk", $arrdata);
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PENDIDIKAN_RIWAYAT_ID");
			$arr_json[$i]['label'] = $set->getField("PENDIDIKAN_JURUSAN_NAMA");
			$arr_json[$i]['desc'] = $set->getField("PENDIDIKAN_JURUSAN_NAMA");
			$i++;
		}
        echo json_encode($arr_json);
	}

	function pendidikanpppk()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");
		$reqId= $this->input->get("reqId");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
			,"reqId"=>$reqId
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "surat_tanda_lulus_combo", $arrdata,'');
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PENDIDIKAN_RIWAYAT_ID")."-".$set->getField("PENDIDIKAN_ID");
			$arr_json[$i]['label'] = $set->getField("PENDIDIKAN_NAMA")." - Tgl STTB ".dateToPageCheck($set->getField("TANGGAL_STTB"));
			$arr_json[$i]['desc'] = $set->getField("PENDIDIKAN_NAMA")." - Tgl STTB ".dateToPageCheck($set->getField("TANGGAL_STTB"));
			$i++;
		}
        echo json_encode($arr_json);
	}

	function caripegawai()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "caripegawai", $arrdata);
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PEGAWAI_ID");
			$arr_json[$i]['label'] = $set->getField("NIP_BARU");
			$arr_json[$i]['desc'] = $set->getField("NIP_BARU")."<br/><label style='font-size:12px'>".$set->getField("NAMA_LENGKAP")."</label>";
			$arr_json[$i]['namapegawai'] = $set->getField("NAMA_LENGKAP");
			$i++;
		}
        echo json_encode($arr_json);
	}

	function satuankerja()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "satuankerja", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("SATUAN_KERJA_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA")."<br/><label style='font-size:12px'>".$set->getField("SATUAN_KERJA_NAMA_DETIL")."</label>";
			$i++;
		}
        echo json_encode($arr_json);
	}

	function namajabatan()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "namajabatan", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("TUGAS_TAMBAHAN_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['satuan_kerja'] = $set->getField("SATKER_NAMA");
			$arr_json[$i]['satuan_kerja_id'] = $set->getField("SATKER_ID");
			$arr_json[$i]['satuan_kerja_validasi'] = $tempReadonly;
			$arr_json[$i]['desc'] = $set->getField("NAMA")."<br/><label style='font-size:12px'>".$set->getField("SATUAN_KERJA_NAMA_DETIL")."</label>";
			$i++;
		}
        echo json_encode($arr_json);
	}

	function skpNamajabatan()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);
		// print_r($arrdata);
		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "skpNamajabatan", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['satuan_kerja'] = $set->getField("NAMA");
			$arr_json[$i]['satuan_kerja_id'] = $set->getField("ID");
			$arr_json[$i]['satuan_kerja_validasi'] = $tempReadonly;
			$arr_json[$i]['desc'] = $set->getField("NAMA")."<br/><label style='font-size:12px'>".$set->getField("NAMA_DETAIL")."</label>";
			$i++;
		}
        echo json_encode($arr_json);
	}

	function skpNamaUnor()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "skpNamaUnor", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['satuan_kerja'] = $set->getField("NAMA");
			$arr_json[$i]['satuan_kerja_id'] = $set->getField("ID");
			$arr_json[$i]['satuan_kerja_validasi'] = $tempReadonly;
			$arr_json[$i]['desc'] = $set->getField("NAMA")."<br/><label style='font-size:12px'>".$set->getField("NAMA_DETAIL")."</label>";
			$i++;
		}
        echo json_encode($arr_json);
	}

	function propinsi()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "propinsi", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PROPINSI_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
		if($i == 0)
		{
			$arr_json[$j]['id'] = "";
			$arr_json[$j]['label'] = "";
			$arr_json[$j]['desc'] = "";
		}
        echo json_encode($arr_json);
	}

	function kabupaten()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");
		$reqPropinsiId= $this->input->get('reqPropinsiId');

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
			, "reqPropinsiId"=>$reqPropinsiId
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "kabupaten", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("KABUPATEN_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
		if($i == 0)
		{
			$arr_json[$j]['id'] = "";
			$arr_json[$j]['label'] = "";
			$arr_json[$j]['desc'] = "";
		}
        echo json_encode($arr_json);
	}

	function kecamatan()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");
		$reqPropinsiId= $this->input->get('reqPropinsiId');
		$reqKabupatenId= $this->input->get('reqKabupatenId');

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
			, "reqPropinsiId"=>$reqPropinsiId
			, "reqKabupatenId"=>$reqKabupatenId
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "kecamatan", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("KECAMATAN_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
		if($i == 0)
		{
			$arr_json[$j]['id'] = "";
			$arr_json[$j]['label'] = "";
			$arr_json[$j]['desc'] = "";
		}
        echo json_encode($arr_json);
	}

	function kelurahan()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$term= $this->input->get("term");
		$reqPropinsiId= $this->input->get('reqPropinsiId');
		$reqKabupatenId= $this->input->get('reqKabupatenId');
		$reqKecamatanId= $this->input->get('reqKecamatanId');

		$search_term = isset($term) ? $term : "";
		
		$set = new DataCombo();
		$arrdata= array(
			"term"=>$term
			, "reqPropinsiId"=>$reqPropinsiId
			, "reqKabupatenId"=>$reqKabupatenId
			, "reqKecamatanId"=>$reqKecamatanId
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "kelurahan", $arrdata);
		// print_r ($set);exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("KELURAHAN_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['desc'] = $set->getField("NAMA");
			$i++;
		}
		if($i == 0)
		{
			$arr_json[$j]['id'] = "";
			$arr_json[$j]['label'] = "";
			$arr_json[$j]['desc'] = "";
		}
        echo json_encode($arr_json);
	}

	function jabatandiklatstruktural()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$reqId= $this->input->get("reqId");
		$reqTanggal= $this->input->get("reqTanggal");

		$set = new DataCombo();
		$arrdata= array(
			"reqId"=>$reqId
			, "reqTanggal"=>$reqTanggal
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "jabatandiklatstruktural", $arrdata, "");
		$set->firstRow();
		$inforeturn= $set->getField("data");

		$arrdatainfo=[];
		if(!empty($inforeturn))
		{
			$inforeturn= $inforeturn[0];
			$infoid= $inforeturn->infoid;

			if(!empty($infoid))
			{
				$arrdata= [];
				$arrdata["infoid"]= $infoid;
				$arrdata["infonama"]= $inforeturn->infonama;
				$arrdata["infoeselonnama"]= $inforeturn->infoeselonnama;
				$arrdata["infosatkernama"]= $inforeturn->infosatkernama;
				$arrdata["inforumpunid"]= $inforeturn->inforumpunid;
				$arrdata["inforumpunnama"]= $inforeturn->inforumpunnama;
				array_push($arrdatainfo, $arrdata);
			}
		}
		
		echo json_encode($arrdatainfo);
	}

	function hapusdata()
	{
		$this->load->model('base-curl/DataCombo');

		$sessPersonalToken= $this->PERSONAL_TOKEN;

		$reqRowId= $this->input->get("reqRowId");
		$reqTable= $this->input->get("reqTable");
		$reqStatus= $this->input->get("reqStatus");

		$set = new DataCombo();
		$arrdata= array(
			"reqRowId"=>$reqRowId
			, "reqTable"=>$reqTable
			, "reqStatus"=>$reqStatus
		);

		$set= new DataCombo();
		$set->selectby($sessPersonalToken, "hapusdata", $arrdata, "");
		$set->firstRow();
		$inforeturn= $set->getField("data");
		echo $inforeturn;
	}

}