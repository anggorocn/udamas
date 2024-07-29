<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');



$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$sessPersonalToken= $this->PERSONAL_TOKEN;
$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));
$arrdataField= [];
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Jabatan_riwayat_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// print_r($set);exit;
 $reqMode = 'insert';
while($set->nextRow())
{
  $reqMode = 'update';
$reqRowId= $set->getField('JABATAN_RIWAYAT_ID');
  $reqIsManual= $set->getField('IS_MANUAL');
  $reqPejabatPenetap= $set->getField('PEJABAT_PENETAP');
  $reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');
  $reqSatkerId= $set->getField('SATKER_ID');
  $reqNoSk= $set->getField('NO_SK');
  $reqEselonId= $set->getField('ESELON_ID');
  $reqEselonNama= $set->getField('ESELON_NAMA');
  $reqNama= $set->getField('NAMA');

  $reqTipePegawaiId= $set->getField('TIPE_PEGAWAI_ID');
  $reqSatkerId= $set->getField('SATKER_ID');
  $reqSatker= $set->getField('SATUAN_KERJA_NAMA_DETIL');
  $reqNoPelantikan= $set->getField('NO_PELANTIKAN');
  $reqTunjangan= $set->getField('TUNJANGAN');
  $reqTglSk= dateTimeToPageCheck($set->getField('TANGGAL_SK'));
  $reqTmtJabatan= dateTimeToPageCheck($set->getField('TMT_JABATAN'));
  $reqTmtEselon= dateTimeToPageCheck($set->getField('TMT_ESELON'));
  $reqTglPelantikan= dateToPageCheck($set->getField('TANGGAL_PELANTIKAN'));
  $reqBlnDibayar= dateToPageCheck($set->getField('BULAN_DIBAYAR'));
  $reqKeteranganBUP= $set->getField('KETERANGAN_BUP');
  $reqLastLevel= $set->getField('LAST_LEVEL');

  $reqSkDasarJabatan= $set->getField('STATUS_SK_DASAR_JABATAN');
  $reqTanggalSelesai= dateTimeToPageCheck($set->getField('TMT_SELESAI_JABATAN'));
  $reqLamaMenjabat= $set->getField('LAMA_JABATAN_HITUNG');
  $reqNilaiRekam= $set->getField('NILAI_REKAM_JEJAK_HITUNG');
  $reqRumpunJabatan= $set->getField('RUMPUN_ID');
  $reqRumpunJabatanNama= $set->getField('RUMPUN_NAMA');
  $reqNoSkSertifikasi= $set->getField('SERTIFIKASI_NO_SK');
  $reqTglSkSertifikasi= dateTimeToPageCheck($set->getField('SERTIFIKASI_TGL_SK'));
  $reqTglBerlaku= dateTimeToPageCheck($set->getField('SERTIFIKASI_TGL_BERLAKU'));
  $reqTglExpired= dateTimeToPageCheck($set->getField('SERTIFIKASI_TGL_EXPIRED'));
  // $reqFileUpload= $set->getField('FILE_UPLOAD');

  $reqTmtSpmt= dateTimeToPageCheck($set->getField('TMT_SPMT'));

  $infodatahukuman= $set->getField('DATA_HUKUMAN');
  $infodatastatus= $set->getField('STATUS');

  $reqTmtWaktuJabatan= substr(datetimeToPage($set->getField('TMT_JABATAN'), "time"),0,5);
  if($reqTmtWaktuJabatan == "" || $reqTmtWaktuJabatan == "00:00"){}
  else
  $reqCheckTmtWaktuJabatan= "1";



  $reqJabatanFuId= $set->getField('JABATAN_FU_ID');
  $reqJabatanFtId= $set->getField('JABATAN_FT_ID');

  $reqJenisJabatan= $set->getField('JENIS_JABATAN_ID');
  $reqTipePegawaiId=  $set->getField('TIPE_PEGAWAI_ID');


   $reqJenisJabatan= 1;
   $reqTipePegawaiId= 11;

  if($reqJenisJabatan==2){
  if($reqJabatanFuId == "")
    $reqNama= "";
  }

  if($reqJenisJabatan==3){
  if($reqJabatanFuId == "")
    $reqNama= "";
  }

  if($reqJenisJabatan==1){
    if($reqJabatanFuId !== "" || $reqJabatanFtId !== "")
    {
      if($reqTipePegawaiId == "11" && $reqSatkerId !== ""){}
        else
          $reqNama= "";
    }
  }

  $reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
  $reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
  $reqValidasi= $set->getField("VALIDASI");
  $reqPerubahanData= $set->getField("PERUBAHAN_DATA");
  $reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
  $reqValRowId= $set->getField("JABATAN_RIWAYAT_ID");

}
// $reqJenisJabatan= 1;
// $reqTipePegawaiId= 11;


$arrEselon= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "eselon", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("ESELON_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrEselon, $arrdata);
}

$arrRumpun= [];
$set->selectby($sessPersonalToken, "rumpun", $arrdata);

while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("RUMPUN_ID");
  $arrdata["text"]= $set->getField("KETERANGAN");
  array_push($arrRumpun, $arrdata);
}

$arrSkDasar= [];
$set->selectby($sessPersonalToken, "skdasar", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("SK_DASAR_JABATAN_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrSkDasar, $arrdata);
}



$vNoPelantikan= checkwarna($reqPerubahanData, 'NO_PELANTIKAN');
$vBlnDibayar = checkwarna($reqPerubahanData, 'BULAN_DIBAYAR',[date]);
$vTunjangan = checkwarna($reqPerubahanData, 'TUNJANGAN');
$vPejabatPenetap = checkwarna($reqPerubahanData, 'PEJABAT_PENETAP');


$fileRowId= $reqValRowId;
if(empty($reqValRowId))
  $fileRowId= "baru";





$riwayattable= "JABATAN_RIWAYAT";
$reqDokumenKategoriFileId= "25"; // ambil dari table KATEGORI_FILE, cek sesuai mode
$arrsetriwayatfield= $set->selectby($sessPersonalToken, "setriwayatfield", ["riwayattable"=>$riwayattable], "", "json");

// print_r($arrsetriwayatfield);exit;

$arrlistriwayatfilepegawai= $set->selectby($sessPersonalToken, "listpilihfilepegawai", ["riwayattable"=>$riwayattable, "reqId"=>$reqId, "reqRowId"=>$fileRowId, "reqTempValidasiId"=>$reqRowId], "", "file");
// print_r($arrlistriwayatfilepegawai);exit;

$reqDokumenPilih= $arrlistriwayatfilepegawai["reqDokumenPilih"];
$arrlistpilihfilefield= $arrlistriwayatfilepegawai["arrlistpilihfilefield"];
// print_r($reqDokumenPilih);exit;
// print_r($arrlistpilihfilefield);exit;

$arrkualitasfile= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "kualitasfile", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["ID"]= $set->getField("KUALITAS_FILE_ID");
  $arrdata["TEXT"]= $set->getField("NAMA");
  array_push($arrkualitasfile, $arrdata);
}
$set= new DataCombo();
$tipekondisikategori= $set->selectby($sessPersonalToken, "kondisikategori", [], "", "json");
// print_r(kondisikategori($tipekondisikategori, "1"));
$arrpilihfiledokumen= $set->selectby($sessPersonalToken, "pilihfiledokumen", [], "", "json");


$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || (!empty($reqTempValidasiHapusId)) && $reqId !== "baru"))
{
  $buttonsimpan= "";
}





 

?>
<script type="text/javascript">
$(function(){
  let validator = $('#ff').jbvalidator({
    errorMessage: true
    , successClass: true
  });

  $(document).on('submit', '#ff', function(){
       var dataform = $('#ff')[0];
    var formData = new FormData(dataform); 
      $.ajax({
        url:"api/Jabatan_riwayat_json/add"
        , type: 'POST'
        , data:formData
        , dataType: 'json'
        ,processData: false
        ,contentType: false
        , success: function (response){
          // console.log(response);return false;
          $.alert({
            title: 'Info Simpan !!!',
            content: response.message,
            buttons: {
              ok: {
                keys: [
                'enter'
                ],
                action: function(){
                  addurl= "";
                  <?
                  if(!empty($reqId))
                  {
                  ?>
                  addurl= "?reqId=<?=$reqId?>";
                  <?
                  }
                  elseif(!empty($reqRowId))
                  {
                  ?>
                  addurl= "?reqRowId=<?=$reqRowId?>";
                  <?
                  }
                  ?>
                  document.location.href = "app/index/<?=$linkfilename?>"+addurl;
                }
              },
            },
          });
        }
        ,
        error: function(xhr, status, error) {
          var err = JSON.parse(xhr.responseText);
          $.alert(err.message);
        }
      })
      return false;
    });
 });
 
</script>
<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1><?=$linkfilenamelabel?></h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <a href="app/index/<?=$linkfilenamekembali?>" style="text-decoration: none;">
          <span>Halaman data monitoring</span>
        </a>
      </h6>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Data <?=$linkfilenamelabel?></div>

      <form class="needs-validation form-horizontal" id="ff" method="post" novalidate enctype="multipart/form-data">
        
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Jenis Jabatan:
          
          </label>
          <div class="col-sm-4">
             <select id="reqJenisJabatan" name="reqJenisJabatan" class="form-control "  readonly >
              <option value="" <? if($reqJenisJabatan=="") echo 'selected';?>></option>
                    <option value="1" <? if($reqJenisJabatan==1) echo 'selected';?>>Jabatan Struktural</option>
                    <option value="2" <? if($reqJenisJabatan==2) echo 'selected';?>>Jabatan Fungsional Umum</option>
                    <option value="3" <? if($reqJenisJabatan==3) echo 'selected';?>>Jabatan Fungsional Tertentu</option>
             </select>
          </div>
        </div>
         
            <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='document.location.href="app/index/<?=$linkfilenamekembali?>"' type="button">Kembali</button>
          </div>

        </div>
      

      

      </form>
    </div>
    
  </div>
</div>
<script type="text/javascript">
  $("#reqJenisJabatan").change(function() { 
        var jenis_jabatan = $("#reqJenisJabatan").val();
        if(jenis_jabatan=="")
        {
          // document.location.href = "app/loadUrl/app/pegawai_add_jabatan?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqJenisJabatan=<?=$reqJenisJabatan?>";
        }
        else if(jenis_jabatan==1)
        {
          document.location.href = "app/index/jabatan_add?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqJenisJabatan=<?=$reqJenisJabatan?>";
        }
        else if(jenis_jabatan==2)
        {
           document.location.href = "app/index/jabatan_fungsional_umum_add?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqJenisJabatan=<?=$reqJenisJabatan?>";
        }
        else if(jenis_jabatan==3)
        {
           document.location.href = "app/index/jabatan_fungsional_tertentu_add?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>&reqJenisJabatan=<?=$reqJenisJabatan?>";
        }
      });
</script>






