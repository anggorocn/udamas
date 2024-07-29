<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");

class globalmenu
{
	function __construct() {
		// parent::__construct();

		$CI =& get_instance();
		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];


        
        $this->STATUS_DATA_UTAMA= $CI->session->userdata("STATUS_DATA_UTAMA".$configvlxsessfolder);
		$this->ICON_DATA_UTAMA= $CI->session->userdata("ICON_DATA_UTAMA".$configvlxsessfolder);
		$this->STATUS_SK_CPNS= $CI->session->userdata("STATUS_SK_CPNS".$configvlxsessfolder);
		$this->ICON_SK_CPNS= $CI->session->userdata("ICON_SK_CPNS".$configvlxsessfolder);
		$this->STATUS_SK_PNS= $CI->session->userdata("STATUS_SK_PNS".$configvlxsessfolder);
		$this->ICON_SK_PNS= $CI->session->userdata("ICON_SK_PNS".$configvlxsessfolder);
		$this->STATUS_SK_PPPK= $CI->session->userdata("STATUS_SK_PPPK".$configvlxsessfolder);
		$this->ICON_SK_PPPK= $CI->session->userdata("ICON_SK_PPPK".$configvlxsessfolder);
		$this->STATUS_PANGKAT= $CI->session->userdata("STATUS_PANGKAT".$configvlxsessfolder);
		$this->ICON_PANGKAT= $CI->session->userdata("ICON_PANGKAT".$configvlxsessfolder);
		$this->STATUS_GAJI= $CI->session->userdata("STATUS_GAJI".$configvlxsessfolder);
		$this->ICON_GAJI= $CI->session->userdata("ICON_GAJI".$configvlxsessfolder);
		$this->STATUS_JABATAN= $CI->session->userdata("STATUS_JABATAN".$configvlxsessfolder);
		$this->ICON_JABATAN= $CI->session->userdata("ICON_JABATAN".$configvlxsessfolder);
		$this->STATUS_TUGAS= $CI->session->userdata("STATUS_TUGAS".$configvlxsessfolder);
		$this->ICON_TUGAS= $CI->session->userdata("ICON_TUGAS".$configvlxsessfolder);
		$this->STATUS_PENDIDIKAN= $CI->session->userdata("STATUS_PENDIDIKAN".$configvlxsessfolder);
		$this->ICON_PENDIDIKAN= $CI->session->userdata("ICON_PENDIDIKAN".$configvlxsessfolder);
		$this->STATUS_DIKLAT_STRUKTURAL= $CI->session->userdata("STATUS_DIKLAT_STRUKTURAL".$configvlxsessfolder);
		$this->ICON_DIKLAT_STRUKTURAL= $CI->session->userdata("ICON_DIKLAT_STRUKTURAL".$configvlxsessfolder);
		$this->STATUS_DIKLAT_KURSUS= $CI->session->userdata("STATUS_DIKLAT_KURSUS".$configvlxsessfolder);
		$this->ICON_DIKLAT_KURSUS= $CI->session->userdata("ICON_DIKLAT_KURSUS".$configvlxsessfolder);
		$this->STATUS_CUTI= $CI->session->userdata("STATUS_CUTI".$configvlxsessfolder);
		$this->ICON_CUTI= $CI->session->userdata("ICON_CUTI".$configvlxsessfolder);
		$this->STATUS_SKP_PPK= $CI->session->userdata("STATUS_SKP_PPK".$configvlxsessfolder);
		$this->ICON_SKP_PPK= $CI->session->userdata("ICON_SKP_PPK".$configvlxsessfolder);
		$this->STATUS_PAK= $CI->session->userdata("STATUS_PAK".$configvlxsessfolder);
		$this->ICON_PAK= $CI->session->userdata("ICON_PAK".$configvlxsessfolder);
		$this->STATUS_KOMPETENSI= $CI->session->userdata("STATUS_KOMPETENSI".$configvlxsessfolder);
		$this->ICON_KOMPETENSI= $CI->session->userdata("ICON_KOMPETENSI".$configvlxsessfolder);
		$this->STATUS_PENGHARGAAN= $CI->session->userdata("STATUS_PENGHARGAAN".$configvlxsessfolder);
		$this->ICON_PENGHARGAAN= $CI->session->userdata("ICON_PENGHARGAAN".$configvlxsessfolder);
		$this->STATUS_PENINJAUAN_MASA_KERJA= $CI->session->userdata("STATUS_PENINJAUAN_MASA_KERJA".$configvlxsessfolder);
		$this->ICON_PENINJAUAN_MASA_KERJA= $CI->session->userdata("ICON_PENINJAUAN_MASA_KERJA".$configvlxsessfolder);
		$this->STATUS_SURAT_TANDA_LULUS= $CI->session->userdata("STATUS_SURAT_TANDA_LULUS".$configvlxsessfolder);
		$this->ICON_SURAT_TANDA_LULUS= $CI->session->userdata("ICON_SURAT_TANDA_LULUS".$configvlxsessfolder);
		$this->STATUS_SUAMI_ISTRI= $CI->session->userdata("STATUS_SUAMI_ISTRI".$configvlxsessfolder);
		$this->ICON_SUAMI_ISTRI= $CI->session->userdata("ICON_SUAMI_ISTRI".$configvlxsessfolder);
		$this->STATUS_ANAK= $CI->session->userdata("STATUS_ANAK".$configvlxsessfolder);
		$this->ICON_ANAK= $CI->session->userdata("ICON_ANAK".$configvlxsessfolder);
		$this->STATUS_ORANG_TUA_ADD= $CI->session->userdata("STATUS_ORANG_TUA_ADD".$configvlxsessfolder);
		$this->ICON_ORANG_TUA_ADD= $CI->session->userdata("ICON_ORANG_TUA_ADD".$configvlxsessfolder);
		$this->STATUS_SAUDARA= $CI->session->userdata("STATUS_SAUDARA".$configvlxsessfolder);
		$this->ICON_SAUDARA= $CI->session->userdata("ICON_SAUDARA".$configvlxsessfolder);
		$this->STATUS_MERTUA_ADD= $CI->session->userdata("STATUS_MERTUA_ADD".$configvlxsessfolder);
		$this->ICON_MERTUA_ADD= $CI->session->userdata("ICON_MERTUA_ADD".$configvlxsessfolder);
		$this->STATUS_BAHASA= $CI->session->userdata("STATUS_BAHASA".$configvlxsessfolder);
		$this->ICON_BAHASA= $CI->session->userdata("ICON_BAHASA".$configvlxsessfolder);
		  // print_r( $CI->session->userdata);
	}

	function getmenu()
	{
		$arrfield= array(
          array("key"=>"data_utama", "label"=>"Data Utama", "link"=> "app/index/data_utama", "aksi"=>$this->STATUS_DATA_UTAMA, "icon"=>$this->ICON_DATA_UTAMA)
          , array("key"=>"sk_cpns", "label"=>"SK CPNS", "link"=> "app/index/sk_cpns", "aksi"=>$this->STATUS_SK_CPNS, "icon"=>$this->ICON_SK_CPNS)
          , array("key"=>"sk_pns", "label"=>"SK PNS", "link"=> "app/index/sk_pns", "aksi"=>$this->STATUS_SK_PNS, "icon"=>$this->ICON_SK_PNS)
          , array("key"=>"sk_pppk", "label"=>"SK PPPK", "link"=> "javascript:void(0)", "aksi"=>$this->STATUS_SK_PPPK, "icon"=>$this->ICON_SK_PPPK)
          // , array("key"=>"sk_pppk", "label"=>"SK PPPK", "link"=> "app/index/sk_pppk", "aksi"=>$this->STATUS_SK_PPPK, "icon"=>$this->ICON_SK_PPPK)
          , array("key"=>"pangkat", "label"=>"Pangkat", "link"=> "app/index/pangkat", "aksi"=>$this->STATUS_PANGKAT, "icon"=>$this->ICON_PANGKAT)
          , array("key"=>"gaji", "label"=>"Gaji", "link"=> "app/index/gaji", "aksi"=>$this->STATUS_GAJI, "icon"=>$this->ICON_GAJI)
          , array("key"=>"jabatan", "label"=>"Jabatan", "link"=> "app/index/jabatan", "aksi"=>$this->STATUS_JABATAN, "icon"=>$this->ICON_JABATAN)
          , array("key"=>"tugas", "label"=>"Tugas", "link"=> "app/index/tugas", "aksi"=>$this->STATUS_TUGAS, "icon"=>$this->ICON_TUGAS)
          , array("key"=>"pendidikan", "label"=>"Pendidikan", "link"=> "app/index/pendidikan", "aksi"=>$this->STATUS_PENDIDIKAN, "icon"=>$this->ICON_PENDIDIKAN)
          , array("key"=>"diklat_struktural", "label"=>"Diklat Struktural", "link"=> "app/index/diklat_struktural", "aksi"=>$this->STATUS_DIKLAT_STRUKTURAL, "icon"=>$this->ICON_DIKLAT_STRUKTURAL)
          , array("key"=>"diklat_kursus", "label"=>"Diklat/Kursus", "link"=> "app/index/diklat_kursus", "aksi"=>$this->STATUS_DIKLAT_KURSUS, "icon"=>$this->ICON_DIKLAT_KURSUS)
          , array("key"=>"cuti", "label"=>"Cuti", "link"=> "javascript:void(0)", "aksi"=>$this->STATUS_CUTI, "icon"=>$this->ICON_CUTI)
          // , array("key"=>"cuti", "label"=>"Cuti", "link"=> "app/index/cuti", "aksi"=>$this->STATUS_CUTI, "icon"=>$this->ICON_CUTI)
          , array("key"=>"skp_ppk", "label"=>"Kinerja ( SKP/PPK )", "link"=> "app/index/skp_ppk_detil", "aksi"=>$this->STATUS_SKP_PPK, "icon"=>$this->ICON_SKP_PPK)
          , array("key"=>"pak", "label"=>"PAK", "link"=>"app/index/pak", "aksi"=>$this->STATUS_PAK, "icon"=>$this->ICON_PAK)
          , array("key"=>"kompetensi", "label"=>"Kompetensi", "link"=> "javascript:void(0)", "aksi"=>$this->STATUS_KOMPETENSI, "icon"=>$this->ICON_KOMPETENSI)
          // , array("key"=>"kompetensi", "label"=>"Kompetensi", "link"=> "app/index/kompetensi", "aksi"=>$this->STATUS_KOMPETENSI, "icon"=>$this->ICON_KOMPETENSI)
          , array("key"=>"penghargaan", "label"=>"Penghargaan", "link"=> "app/index/penghargaan", "aksi"=>$this->STATUS_PENGHARGAAN, "icon"=>$this->ICON_PENGHARGAAN)
          , array("key"=>"peninjauan_masa_kerja", "label"=>"Peninjauan Masa Kerja", "link"=> "app/index/peninjauan_masa_kerja", "aksi"=>$this->STATUS_PENINJAUAN_MASA_KERJA, "icon"=>$this->ICON_PENINJAUAN_MASA_KERJA)
          , array("key"=>"surat_tanda_lulus", "label"=>"STL UD/PI", "link"=> "app/index/surat_tanda_lulus", "aksi"=>$this->STATUS_SURAT_TANDA_LULUS, "icon"=>$this->ICON_SURAT_TANDA_LULUS)
          , array("key"=>"suami_istri", "label"=>"Suami/Istri", "link"=> "app/index/suami_istri", "aksi"=>$this->STATUS_SUAMI_ISTRI, "icon"=>$this->ICON_SUAMI_ISTRI)
          , array("key"=>"anak", "label"=>"Anak", "link"=> "app/index/anak", "aksi"=>$this->STATUS_ANAK, "icon"=>$this->ICON_ANAK)
          , array("key"=>"orang_tua", "label"=>"Orang Tua", "link"=> "app/index/orang_tua_add", "aksi"=>$this->STATUS_ORANG_TUA_ADD, "icon"=>$this->ICON_ORANG_TUA_ADD)
          , array("key"=>"saudara", "label"=>"Saudara", "link"=> "app/index/saudara", "aksi"=>$this->STATUS_SAUDARA, "icon"=>$this->ICON_SAUDARA)
          , array("key"=>"mertua", "label"=>"Mertua", "link"=> "app/index/mertua_add", "aksi"=>$this->STATUS_MERTUA_ADD, "icon"=>$this->ICON_MERTUA_ADD)
          , array("key"=>"bahasa", "label"=>"Penguasaan Bahasa", "link"=> "javascript:void(0)", "aksi"=>$this->STATUS_BAHASA, "icon"=>$this->ICON_BAHASA)
          // , array("key"=>"bahasa", "label"=>"Penguasaan Bahasa", "link"=> "app/index/bahasa", "aksi"=>$this->STATUS_BAHASA, "icon"=>$this->ICON_BAHASA)
        );

        return $arrfield;
	}

	function getaksesmenu($arrparam)
	{
		$key= $arrparam["key"];
		// echo $key;exit;

		$arrgetmenu= $this->getmenu();
		// print_r($arrgetmenu);
		$infocari= $key;
		$arraycari= in_array_column($infocari, "key", $arrgetmenu);
		// print_r($arraycari);exit;

		$vaksi= "";
		if(!empty($arraycari))
		{
			$vaksi= $arrgetmenu[$arraycari[0]]["aksi"];
		}
		// echo $vaksi;exit;
		return $vaksi;
	}

}