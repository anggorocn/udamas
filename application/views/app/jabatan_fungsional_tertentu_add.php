<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');

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

  $reqKredit= dotToComma($set->getField('KREDIT'));

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


  $reqJenisJabatan= 3;

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

// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"jabatan"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);

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

if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}

$buttonsimpan=1;
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
        <a href="app/index/jabatan" style="text-decoration: none;">
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
             <select id="reqJenisJabatan" name="reqJenisJabatan" class="form-control " readonly disabled >
              <option value="" <? if($reqJenisJabatan=="") echo 'selected';?>></option>
                    <option value="1" <? if($reqJenisJabatan==1) echo 'selected';?>>Jabatan Struktural</option>
                    <option value="2" <? if($reqJenisJabatan==2) echo 'selected';?>>Jabatan Fungsional Umum</option>
                    <option value="3" <? if($reqJenisJabatan==3) echo 'selected';?>>Jabatan Fungsional Tertentu</option>
             </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Jenis JFT:
          
          </label>
          <div class="col-sm-4">
             <select id="reqTipePegawaiId" name="reqTipePegawaiId" class="form-control "  readonly >
              <option value="" <? if($reqJenisJabatan=="") echo 'selected';?>></option>
                    <option value="" <? if($reqTipePegawaiId == "") echo 'selected';?>></option>
                    <option value="21" <? if($reqTipePegawaiId == 21) echo 'selected';?>>Pendidikan</option>
                    <option value="22" <? if($reqTipePegawaiId == 22) echo 'selected';?>>Kesehatan</option>
                    <option value="23" <? if($reqTipePegawaiId == 23) echo 'selected';?>>Lain-Lain</option>
             </select>
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for="">No. SK:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox" id="reqNoSk" name="reqNoSk" placeholder="Isikan No. SK" value="<?=$reqNoSk?>">
          </div>

          <label class="control-label col-sm-2" for="">Tgl. SK:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqTglSk" onKeyDown="return format_date(event,'reqTglSk');" name="reqTglSk"  placeholder="Isikan Tgl. SK" value="<?=$reqTglSk?>">
          </div>
        </div>
         
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Nama Jabatan:</label>
          <div class="col-sm-4">
              <input placeholder="Isikan Nama Jabatan" type="text" id="reqNama" name="reqNama"  value="<?=$reqNama?>" class="easyui-validatebox form-control" required />
           
          </div>
          
        </div>
         <div class="form-group">
           <label class="control-label col-sm-2" for=""> <input type="checkbox" id="reqIsManual" name="reqIsManual" value="1" <? if($reqIsManual == 1) echo 'checked'?> /></label>
           <div class="col-sm-6">
            <b> *centang jika jabatan luar kab jombang / jabatan sebelum tahun 2012</b>
            </div>
          </div>
           <div class="form-group">
          <label class="control-label col-sm-2" for="">Angka Kredit:
          
          </label>
          <div class="col-sm-4">
             <input type="text" class="form-control " id="reqKredit" name="reqKredit" OnFocus="FormatAngka('reqKredit')" OnKeyUp="FormatUang('reqKredit')" OnBlur="FormatUang('reqKredit')" value="<?=numberToIna($reqKredit)?>" placeholder="Isikan Angka Kredit">
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for="">TMT Jabatan:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox" name="reqTmtJabatan" id="reqTmtJabatan" placeholder="Isikan NIK" value="<?=$reqTmtJabatan?>" placeholder="Isikan TMT Jabatan">
          </div>
 <div class="col-sm-1">
            <input type="checkbox" id="reqCheckTmtWaktuJabatan" name="reqCheckTmtWaktuJabatan" value="1" <? if($reqCheckTmtWaktuJabatan == 1) echo 'checked'?>/>
          </div>
          <div id="reqInfoCheckTmtWaktuJabatan">
          <label class="control-label col-sm-1" for="">Time:</label>
          <div class="col-sm-2">
              <input placeholder="00:00" id="reqTmtWaktuJabatan" name="reqTmtWaktuJabatan" type="text" class="form-control" value="<?=$reqTmtWaktuJabatan?>" placeholder="Isikan Time" />
          </div>
        </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Satuan Kerja:

          </label>
          <div class="col-sm-4">
               <input type="hidden" name="reqSatkerId" id="reqSatkerId" value="<?=$reqSatkerId?>" />
            <input type="text" id="reqSatker" name="reqSatker"  class="form-control"   value="<?=$reqSatker?>" placeholder="Isikan Satuan Kerja">
          </div>
        </div>
          <div class="form-group" id="reqinfoeselontext">
          <label class="control-label col-sm-2" for="">Eselon:</label>
          <div class="col-sm-4">
            <input type="hidden" name="reqEselonId" id="reqEselonId" value="<?=$reqEselonId?>" />
           <select id="reqSelectEselonId" class="form-control " >
              <option value=""></option>
               <?
               foreach ($arrEselon as $key => $value)
               {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqEselonId == $optionid)
                  $optionselected= "selected";
                ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
              }
              ?>       
             </select>
          </div>
          <label class="control-label col-sm-2" for="">TMT Eselon:</label>
          <div class="col-sm-4">
              <input type="text" class="form-control formattanggalnew" id="reqTmtEselon" placeholder="Isikan TMT Eselon" onKeyDown="return format_date(event,'reqTmtEselon');" name="reqTmtEselon"  placeholder="Isikan TMT Eselon" value="<?=$reqTmtEselon?>">
            
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">TMT SPMT:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control formattanggalnew" id="reqTmtSpmt" onKeyDown="return format_date(event,'reqTmtSpmt');" name="reqTmtSpmt"  placeholder="Isikan TMT SPMT" value="<?=$reqTmtSpmt?>">
            
          </div>
          <label class="control-label col-sm-2" for="">No. Pelantikan 
            <?
              $warnadata= $vNoPelantikan['data'];
              $warnaclass= $vNoPelantikan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control <?=$warnaclass?>" name="reqNoPelantikan"    placeholder="Isikan No. Pelantikan" id="reqNoPelantikan" value="<?=$reqNoPelantikan?>">
          </div>
          <label class="control-label col-sm-2" for="">Tgl. Pelantikan:</label>
          <div class="col-sm-2">
             <input type="text" class="form-control formattanggalnew" id="reqTglPelantikan" placeholder="Isikan Tgl. Pelantikan" onKeyDown="return format_date(event,'reqTglPelantikan');" name="reqTglPelantikan"  placeholder="Isikan Tanggal BPJS" value="<?=$reqTglPelantikan?>">
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for="">Tunjangan 
            <?
              $warnadata= $vTunjangan['data'];
              $warnaclass= $vTunjangan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
          <div class="col-sm-4">
           

             <input type="text" class="form-control <?=$warnaclass?>" id="reqTunjangan" name="reqTunjangan" OnFocus="FormatAngka('reqTunjangan')" OnKeyUp="FormatUang('reqTunjangan')" OnBlur="FormatUang('reqTunjangan')" value="<?=numberToIna($reqTunjangan)?>" placeholder="Isikan Tunjangan">

          </div>
          <label class="control-label col-sm-2" for="">Bln. Dibayar 
            <?
              $warnadata= $vBlnDibayar['data'];
              $warnaclass= $vBlnDibayar['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
          <div class="col-sm-4">
                <input type="text" class="form-control formattanggalnew <?=$warnaclass?>"  id="reqBlnDibayar" placeholder="Isikan Bln. Dibayar" onKeyDown="return format_date(event,'reqBlnDibayar');" name="reqBlnDibayar"  placeholder="Isikan Bln. Dibayar" value="<?=$reqBlnDibayar?>">
            
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Pejabat Penetap
            <?
              $warnadata= $vPejabatPenetap['data'];
              $warnaclass= $vPejabatPenetap['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>

          :</label>
          <div class="col-sm-4">
               <input type="hidden" name="reqPejabatPenetapId" id="reqPejabatPenetapId" value="<?=$reqPejabatPenetapId?>" /> 
                  <input placeholder="" type="text" id="reqPejabatPenetap" name="reqPejabatPenetap"  value="<?=$reqPejabatPenetap?>" class="easyui-validatebox form-control <?=$warnaclass?>" required />
          </div>
          <label class="control-label col-sm-2" for="">SK Dasar Jabatan:</label>
          <div class="col-sm-4">
               <select id="reqSkDasarJabatan" name="reqSkDasarJabatan"  class="form-control">
                <option value=""></option>
                <?
               foreach ($arrSkDasar as $key => $value)
               {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqSkDasarJabatan == $optionid)
                  $optionselected= "selected";
                ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
              }
              ?>       
               </select>
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for="">Tanggal Selesai Menjabat:</label>
          <div class="col-sm-4">
             <!--  <input type="hidden" name="reqTanggalSelesai" value="<?=$reqTanggalSelesai?>" />
            <input type="text" class="form-control easyui-validatebox" id="reqTanggalSelesai"   placeholder="Isikan Tanggal Selesai Menjabat" value="<?=$reqTanggalSelesai?>"> -->

            <input type="text" class="form-control formattanggalnew" id="reqTanggalSelesai" readonly  placeholder="Isikan Tanggal Selesai Menjabat" onKeyDown="return format_date(event,'reqTanggalSelesai');" name="reqTanggalSelesai"  placeholder="Isikan Tanggal BPJS" value="<?=$reqTanggalSelesai?>">


          </div>
          <label class="control-label col-sm-2" for="">Lama Menjabat (tahun):</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="reqLamaMenjabat" readonly name="reqLamaMenjabat" placeholder="Isikan Lama Menjabat" value="<?=$reqLamaMenjabat?>">
          </div>
        </div>
          <div class="form-group">
          <label class="control-label col-sm-2" for="">Nilai Rekam Jejak:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox" id="reqNilaiRekam" readonly  name="reqNilaiRekam"  placeholder="Isikan Nilai Rekam Jejak" value="<?=$reqNilaiRekam?>">
          </div>
          <label class="control-label col-sm-2" for="">Rumpun Jabatan:</label>
          <div class="col-sm-4">

             <div class="input-field col s12 m3" id="labelrumpunset">
                   
                    <input type="hidden" name="reqRumpunJabatan" id="reqRumpunJabatan"   value="<?=$reqRumpunJabatan?>" />
                    <input placeholder="" type="text" disabled class="easyui-validatebox form-control" readonly id="reqRumpunJabatanNama" value="<?=$reqRumpunJabatanNama?>" />
                </div>

            <div class="input-field col s12 m3" id="labelrumpunselect">
             <select id="reqRumpunJabatanSelect" class="form-control">
              <option value=""></option>
              <?
               foreach ($arrRumpun as $key => $value)
               {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqRumpunJabatan == $optionid)
                  $optionselected= "selected";
                ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
              }
              ?>       
             </select>
           </div>
           </div>
          
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">No SK Sertifikasi:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox" id="reqNoSkSertifikasi" name="reqNoSkSertifikasi"  placeholder="Isikan No SK Sertifikasi" value="<?=$reqNoSkSertifikasi?>">
          </div>
          <label class="control-label col-sm-2" for="">Tgl SK Sertifkasi:</label>
          <div class="col-sm-4">
         
              <input type="text" class="form-control formattanggalnew" id="reqTglSkSertifikasi" placeholder="Isikan Tgl SK Sertifkasi" onKeyDown="return format_date(event,'reqTglSkSertifikasi');" name="reqTglSkSertifikasi"  placeholder="Isikan Tanggal BPJS" value="<?=$reqTglSkSertifikasi?>">

          </div>
        </div>
          <div class="form-group">
          <label class="control-label col-sm-2" for="">Tgl Berlaku:</label>
          <div class="col-sm-4">
       
            <input type="text" class="form-control formattanggalnew" id="reqTglBerlaku" placeholder="Isikan Tgl Berlaku" onKeyDown="return format_date(event,'reqTglBerlaku');" name="reqTglBerlaku"  placeholder="Isikan Tanggal BPJS" value="<?=$reqTglBerlaku?>">


          </div>
          <label class="control-label col-sm-2" for="">Tanggal expired:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqTglExpired" placeholder="Isikan Tgl Berlaku" onKeyDown="return format_date(event,'reqTglExpired');" name="reqTglExpired"  placeholder="Isikan  Tanggal expired" value="<?=$reqTglExpired?>">
           
          </div>
        </div>
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="">Nama Jabatan Eoffice:
            </label>
            <div class="col-sm-4">
                  <input type="hidden" class="easyui-validatebox"  id="reqEofficeJabatanId" name="reqEofficeJabatanId" value="<?=$reqEofficeJabatanId?>" />
              <input type="text" name="reqEofficeJabatanNama"  id="reqEofficeJabatanNama" readonly class="form-control"   value="<?=$reqEofficeJabatanNama?>">
            </div>
          </div>
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="">Satuan Kerja Eoffice:
            </label>
            <div class="col-sm-4">
              <input type="hidden"  id="reqEofficeSatkerId" name="reqEofficeSatkerId" value="<?=$reqEofficeSatkerId?>" />
              <input type="text" name="reqEofficeSatkerNama"  id="reqEofficeSatkerNama" readonly class="form-control"   value="<?=$reqEofficeSatkerNama?>">
            </div>
          </div>
     

        <div class="row">
          <div class="col-md-12">
             <input type="hidden"  name="reqTipePegawaiId" value="<?=$reqTipePegawaiId?>" />
            <input type="hidden" name="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
            <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>" />
            <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
            <?
            // untuk hak akses menu
            // khusus a baru bisa tambah
            if(strtoupper($vaksesmenu) == strtoupper("A"))
            {
              if(!empty($buttonsimpan))
              {
            ?>
                <button class="btn btn-primary"  id="simpan" type="submit">Simpan</button>
            <?
                if(!empty($reqTempValidasiId))
                {
            ?>
                <!-- <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'diklat_kursus', '', '<?=$linkfilenamekembali?>')">Batal</button> -->
            <?
                }
              }
            }
            ?>
            <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='document.location.href="app/index/jabatan"' type="button">Kembali</button>
          </div>

        </div>
        <?
        // area untuk upload file
        ?>
        <div class="row"><div class="col-md-12"><br/></div></div>
        <div class="row">
          <div class="col-md-12">
          <?
          foreach ($arrsetriwayatfield as $key => $value)
          {
            $riwayatfield= $value["riwayatfield"];
            $riwayatfieldtipe= $value["riwayatfieldtipe"];
            $riwayatfieldinfo= $value["riwayatfieldinfo"];
            $riwayatfieldstyle= $value["riwayatfieldstyle"];
            // echo $riwayatfieldstyle;exit;
          ?>
            <button class="btn btn-info" style="font-size:9pt;<?=$riwayatfieldstyle?>" type="button" id='buttonframepdf<?=$riwayatfield?>'>
              <input type="hidden" id="labelvpdf<?=$riwayatfield?>" value="<?=$riwayatfieldinfo?>" />
              <span id="labelframepdf<?=$riwayatfield?>"><?=$riwayatfieldinfo?></span>
            </button>
          <?
          }
          ?>
          </div>
        </div>
        <div class="row"><div class="col-md-12"><br/></div></div>

        <?
        foreach ($arrsetriwayatfield as $key => $value)
        {
          $riwayatfield= $value["riwayatfield"];
          $riwayatfieldtipe= $value["riwayatfieldtipe"];
          $vriwayatfieldinfo= $value["riwayatfieldinfo"];
          $riwayatfieldinfo= " - ".$vriwayatfieldinfo;
          $riwayatfieldrequired= $value["riwayatfieldrequired"];
          $riwayatfieldrequiredinfo= $value["riwayatfieldrequiredinfo"];
          $vriwayattable= $value["vriwayattable"];
          $vriwayatid= "";
          $vpegawairowfile= $reqDokumenKategoriFileId."-".$vriwayattable."-".$riwayatfield."-".$vriwayatid;
        ?>
        <div class="row">
          <div class="input-field col-md-4">
            <input type="hidden" id="reqDokumenRequired<?=$riwayatfield?>" name="reqDokumenRequired[]" value="<?=$riwayatfieldrequired?>" />
            <input type="hidden" id="reqDokumenRequiredNama<?=$riwayatfield?>" name="reqDokumenRequiredNama[]" value="<?=$vriwayatfieldinfo?>" />
            <input type="hidden" id="reqDokumenRequiredTable<?=$riwayatfield?>" name="reqDokumenRequiredTable[]" value="<?=$vriwayattable?>" />
            <input type="hidden" id="reqDokumenRequiredTableRow<?=$riwayatfield?>" name="reqDokumenRequiredTableRow[]" value="<?=$vpegawairowfile?>" />
            <input type="hidden" id="reqDokumenFileId<?=$riwayatfield?>" name="reqDokumenFileId[]" />
            <input type="hidden" id="reqDokumenKategoriFileId<?=$riwayatfield?>" name="reqDokumenKategoriFileId[]" value="<?=$reqDokumenKategoriFileId?>" />
            <input type="hidden" id="reqDokumenKategoriField<?=$riwayatfield?>" name="reqDokumenKategoriField[]" value="<?=$riwayatfield?>" />
            <input type="hidden" id="reqDokumenPath<?=$riwayatfield?>" name="reqDokumenPath[]" value="" />
            <input type="hidden" id="reqDokumenTipe<?=$riwayatfield?>" name="reqDokumenTipe[]" value="<?=$riwayatfieldtipe?>" />

            <label for="reqDokumenPilih<?=$riwayatfield?>">
              File Dokumen<?=$riwayatfieldinfo?>
              <span id="riwayatfieldrequiredinfo<?=$riwayatfield?>" style="color: red;"><?=$riwayatfieldrequiredinfo?></span>
            </label>
            <select class="form-control" id="reqDokumenPilih<?=$riwayatfield?>" name="reqDokumenPilih[]">
              <?
              foreach ($arrpilihfiledokumen as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["nama"];
              ?>
                <option value="<?=$optionid?>" <? if($reqDokumenPilih[$riwayatfield] == $optionid) echo "selected";?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>

          <div class="input-field col-md-4">
            <label for="reqDokumenFileKualitasId<?=$riwayatfield?>">Kualitas Dokumen<?=$riwayatfieldinfo?></label>
            <select class="form-control" <?=$disabled?> name="reqDokumenFileKualitasId[]" id="reqDokumenFileKualitasId<?=$riwayatfield?>">
              <option value=""></option>
              <?
              foreach ($arrkualitasfile as $key => $value)
              {
                $optionid= $value["ID"];
                $optiontext= $value["TEXT"];
                $optionselected= "";
                if($reqDokumenFileKualitasId == $optionid)
                  $optionselected= "selected";

                $arrkecualitipe= [];
                $arrkecualitipe= kondisikategori($tipekondisikategori, $riwayatfieldtipe);
                if(!in_array($optionid, $arrkecualitipe))
                  continue;
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
             
          </div>

          <div id="labeldokumenfileupload<?=$riwayatfield?>" class="input-field col-md-4" style="margin-top: -25px; margin-bottom: 10px;">
            <div class="file_input_div">
              <div class="file_input input-field col s12 m4">
                <label class="labelupload">
                  <i class="mdi-file-file-upload" style="font-family: Roboto,sans-serif,Material-Design-Icons !important; font-size: 14px !important;">Upload</i>
                  <input id="file_input_file" name="reqLinkFile[]" class="none" type="file" />
                </label>
              </div>
              <div id="file_input_text_div" class=" input-field col s12 m8">
                <input class="file_input_text" type="text" disabled readonly id="file_input_text" />
                <label for="file_input_text"></label>
              </div>
            </div>
          </div>

          <div id="labeldokumendarifileupload<?=$riwayatfield?>" class="input-field col-md-4">
            <label for="reqDokumenIndexId<?=$riwayatfield?>">Nama e-File<?=$riwayatfieldinfo?></label>
            <select class="form-control" id="reqDokumenIndexId<?=$riwayatfield?>" name="reqDokumenIndexId[]">
              <option value="" selected></option>
              <?
              $arrlistpilihfilepegawai= $arrlistpilihfilefield[$riwayatfield];
              foreach ($arrlistpilihfilepegawai as $key => $value)
              {
                $optionid= $value["index"];
                $optiontext= $value["nama"];
                $optionselected= $value["selected"];
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>

        </div>
        <?
        }
        // area untuk upload file
        ?>

      

      </form>
    </div>
    
  </div>
</div>


<div style="display: none;">
  <button id="klikbuttoniframe" type="button" data-toggle="modal" data-target="#iframedetil" class="btn btn-primary"></button>
</div>
<div id="iframedetil" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="row">
        <div class="col-md-12">
          
          <div class="area-panel">
            <div class="judul-panel">Riwayat E-File</div>
            <div class="inner inner-pdf">
              <!-- <iframe id="infonewframe" style="width: 100%; height: 800px" src="http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf"></iframe> -->
              <input type="hidden" id="labelglobalvpdf" />
              <object id="infonewframe" data="" type="application/pdf" width="100%" height="800px">
               </object>
             </div>

           </div>
         </div>
       </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  function settimetmt(info)
  {
    $("#reqInfoCheckTmtWaktuJabatan").hide();
    if($("#reqCheckTmtWaktuJabatan").prop('checked')) 
    {
      $("#reqInfoCheckTmtWaktuJabatan").show();
    }
    else
    {
      if(info == 2)
      $("#reqTmtWaktuJabatan").val("");
    }
  }
  
  function seinfodatacentang()
  {
    $("#reqinfoeselontext,#reqinfoeselonselect").hide();
    if($("#reqIsManual").prop('checked')) 
    {
      $("#reqinfoeselonselect").show();
      $("#reqSatker").attr("readonly", false);
      // $("#reqSelectEselonId").material_select();
      // $("#reqNama,#reqNamaId").val("");
    }
    else
    {
      $("#reqSatker").attr("readonly", true);
      $("#reqinfoeselontext").show();
    }
  }
  
  function setcetang()
  {
    // console.log($("#reqIsManual").prop('checked'));return false;
    $("#reqinfoeselontext,#reqinfoeselonselect").hide();

    $("#labelrumpunset").show();
    $("#labelrumpunselect").hide();
    if($("#reqIsManual").prop('checked')) 
    {
      $("#reqinfoeselonselect").show();
      $("#reqSelectEselonId,#reqEselonId, #reqEselonText, #reqNama, #reqSatker, #reqSatkerId").val("");
      $("#reqSatker").attr("readonly", false);
      // $("#reqSelectEselonId").material_select();
      // $("#reqNama,#reqNamaId").val("");

      $("#labelrumpunset").hide();
      $("#labelrumpunselect").show();
    }
    else
    {
      $("#reqSatker").attr("readonly", true);
      $("#reqEselonId, #reqNama, #reqSatker, #reqSatkerId").val("");
      $("#reqinfoeselontext").show();
    }
  }
</script>
<!-- AUTO KOMPLIT -->
  <link rel="stylesheet" href="assets/autokomplit/jquery-ui.css">
  <script src="assets/autokomplit/jquery-ui.js"></script>

  <script type="text/javascript" src="assets/materializetemplate/js/plugins/formatter/jquery.formatter.min.js"></script> 

<script type="text/javascript">
    $(function(){

       $("#labelrumpunset").show();
    $("#labelrumpunselect").hide();
    reqIsManual= "<?=$reqIsManual?>";
    if(reqIsManual == "1")
    {
      $("#labelrumpunset").hide();
      $("#labelrumpunselect").show();
    }

    $("#reqRumpunJabatanSelect").change(function() { 
      var reqRumpunJabatan= $("#reqRumpunJabatanSelect").val();
      var reqRumpunJabatanNama= $("#reqRumpunJabatanSelect option:selected").text();
      // console.log(reqRumpunJabatanNama);

      $("#reqRumpunJabatan").val(reqRumpunJabatan);
      $("#reqRumpunJabatanNama").val(reqRumpunJabatanNama);
    });

    settimetmt(1);
    <?
    if($reqRowId == "")
    {
    ?>
     setcetang();
    <?
    }
    else
    {
    ?>
      seinfodatacentang();
    <?
    }
    ?>

   $("#reqCheckTmtWaktuJabatan").click(function () {
     settimetmt(2);
     
    });
   
    $("#reqIsManual").click(function () {
      setcetang();
    });
   
    $('#reqSelectEselonId').bind('change', function(ev) {
     $("#reqEselonId").val($(this).val());
    });

   //$('input[id^="reqPejabatPenetap"], input[id^="reqNama"], input[id^="reqSatker"]').autocomplete({
  //  $('input[id^="reqPejabatPenetap"], input[id^="reqNama"]').autocomplete({
       $('input[id^="reqPejabatPenetap"], input[id^="reqNama"]').each(function(){
        $(this).autocomplete({
      source:function(request, response){
        var id= this.element.attr('id');
      
        var replaceAnakId= replaceAnak= urlAjax=reqTanggalBatas= "";

        if (id.indexOf('reqNama') !== -1 || id.indexOf('reqSatker') !== -1)
        {
          if($("#reqIsManual").prop('checked')) 
          {
            return false;
          }
        }
    
        if (id.indexOf('reqNama') !== -1)
          {
            var element= id.split('reqNama');
            var indexId= "reqNamaId"+element[1];
            reqTanggalBatas= $("#reqTmtJabatan").val();
            // urlAjax= "satuan_kerja_json/auto?reqTanggalBatas="+reqTanggalBatas;
               urlAjax= "api/combo//satuankerja?reqTanggalBatas="+reqTanggalBatas;
            //urlAjax= "satuan_kerja_json/namajabatan";
          }
        $.ajax({
          url: urlAjax,
          type: "GET",
          dataType: "json",
          data: { term: request.term },
          success: function(responseData){
            if(responseData == null)
            {
              response(null);
            }
            else
            {
              var array = responseData.map(function(element) {
                return {desc: element['desc'], id: element['id'], label: element['label'], satuan_kerja: element['satuan_kerja'], eselon_id: element['eselon_id'], eselon_nama: element['eselon_nama'], rumpun_id: element['rumpun_id'], rumpun_nama: element['rumpun_nama']};
              });
              response(array);
            }
          }
        })
      },
      focus: function (event, ui) 
      { 
        var id= $(this).attr('id');
        if (id.indexOf('reqPejabatPenetap') !== -1)
        {
          var element= id.split('reqPejabatPenetap');
          var indexId= "reqPejabatPenetapId"+element[1];
        }
        else if (id.indexOf('reqNama') !== -1)
        {
          var element= id.split('reqNama');
          var indexId= "reqSatkerId"+element[1];
          $("#reqSatker").val(ui.item.satuan_kerja).trigger('change');
          $("#reqEselonId").val(ui.item.eselon_id).trigger('change');
          $("#reqEselonText").val(ui.item.eselon_nama).trigger('change');

          $("#reqRumpunJabatan").val(ui.item.rumpun_id).trigger('change');
          $("#reqRumpunJabatanNama").val(ui.item.rumpun_nama).trigger('change');
        }
        else if (id.indexOf('reqSatker') !== -1)
        {
          var element= id.split('reqSatker');
          var indexId= "reqSatkerId"+element[1];
          $("#reqNama").val("").trigger('change');
        }

        var statusht= "";
            //statusht= ui.item.statusht;
            $("#"+indexId).val(ui.item.id).trigger('change');
          },
          //minLength:3,
          autoFocus: true
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        //return
        return $( "<li>" )
        .append( "<a>" + item.desc + "</a>" )
        .appendTo( ul );
      };

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
    });

    });
</script>

<script type="text/javascript">
  function getMonthDifference(startDate, endDate) {
    return (
      endDate.getMonth() -
      startDate.getMonth() +
      12 * (endDate.getFullYear() - startDate.getFullYear())
      );
  }
  $(document).ready(function() {
   

  });

   $('#reqTmtSpmt').keyup(function() {
    var reqTanggalSelesai= $('#reqTmtSpmt').val();
    var reqTmtJabatan= $('#reqTmtJabatan').val();
    var checktanggalselesai= moment(reqTanggalSelesai , 'DD-MM-YYYY', true).isValid();
    var checktmtjabatan= moment(reqTmtJabatan , 'DD-MM-YYYY', true).isValid();
    // console.log(checktanggalselesai+'_'+checktmtjabatan);
    if(checktanggalselesai == true && checktmtjabatan == true)
    {
      var tglselesai = moment(reqTanggalSelesai, 'DD-MM-YYYY');  // format tanggal
      var tmtjabatan = moment(reqTmtJabatan, 'DD-MM-YYYY'); 

      if (tglselesai.isSameOrAfter(tmtjabatan)) {} 
      else 
      {
         $('#reqTmtSpmt').val(reqTmtJabatan);
      }
    }

  });

  $('#reqTanggalSelesai').keyup(function() {
    var reqTanggalSelesai= $('#reqTanggalSelesai').val();
    var reqTmtJabatan= $('#reqTmtJabatan').val();
    var checktanggalselesai= moment(reqTanggalSelesai , 'DD-MM-YYYY', true).isValid();
    var checktmtjabatan= moment(reqTmtJabatan , 'DD-MM-YYYY', true).isValid();
    // console.log(checktanggalselesai+'_'+checktmtjabatan);
    if(checktanggalselesai == true && checktmtjabatan == true)
    {
      var tglselesai = moment(reqTanggalSelesai, 'DD-MM-YYYY');  // format tanggal
      var tmtjabatan = moment(reqTmtJabatan, 'DD-MM-YYYY'); 

      if (tglselesai.isSameOrAfter(tmtjabatan)) {} 
      else 
      {
         $('#reqTanggalSelesai').val(reqTmtJabatan);
      }

      // hitung ulang
      tglselesai= reqTanggalSelesai.substring(6,10)+"-"+reqTanggalSelesai.substring(3,5)+"-"+reqTanggalSelesai.substring(0,2);
      tmtjabatan= reqTmtJabatan.substring(6,10)+"-"+reqTmtJabatan.substring(3,5)+"-"+reqTmtJabatan.substring(0,2);
      // console.log(tglselesai+";"+tmtjabatan)
      totalbulan= getMonthDifference(new Date(tmtjabatan), new Date(tglselesai));
      totalbulan= parseInt(totalbulan / 12);
      // console.log(totalbulan);
      tambahbulan= 0;
      if(totalbulan > 2)
        tambahbulan= 1;

      vlamajabatanhitung= (parseInt(reqTanggalSelesai.substring(6,10)) - reqTmtJabatan.substring(6,10)) + tambahbulan;
      $("#reqLamaMenjabatValue").val(vlamajabatanhitung);

      vnilairekam= 0;
      if(vlamajabatanhitung >= 5)
        vnilairekam= 100;
      else if(vlamajabatanhitung >= 4)
        vnilairekam= 80;
      else if(vlamajabatanhitung >= 3)
        vnilairekam= 60;
      else if(vlamajabatanhitung >= 2)
        vnilairekam= 40;
      else if(vlamajabatanhitung >= 1)
        vnilairekam= 20;

      $("#reqNilaiRekamValue").val(vnilairekam);
    }

    // $("#reqLamaMenjabatValue").val(10);

  });

  // tglselesai= '2022-05-19';
  // tmtjabatan= '2019-01-11';
  // totalbulan= getMonthDifference(new Date(tmtjabatan), new Date(tglselesai));
  // console.log(totalbulan);

  
  $('#reqTmtWaktuJabatan').formatter({
    'pattern': '{{99}}:{{99}}',
  });

  $('#reqNoUrutCetak,#reqTh,#reqBl').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });
</script>

<script type="text/javascript">
// untuk area untuk upload file
vbase_url= "<?=base_url()?>";
getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
vlinkurlapi= "http://192.168.88.100/jombang/siapasn/";
// console.log(getarrlistpilihfilefield);

$(document).ready( function () {

  /*$("#klikbuttoniframe").click();
  vurl= "http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf";
  $('#infonewframe').attr('data', vurl);*/

  $('[id^="buttonframepdf"]').click(function(){
    infoid= $(this).attr('id');
    infoid= infoid.replace("buttonframepdf", "");
    buttonframepdf(infoid);
  });

  $('#iframedetil').on('hidden.bs.modal', function () {
    infoid= $("#labelglobalvpdf").val();
    labelvpdf= $("#labelvpdf"+infoid).val();
    $("#labelframepdf"+infoid).text(labelvpdf);
    $("#vnewframe").val("");
  })

  function isgambar(vext)
  {
    vreturn= "";
    if(vext == "jpg")
        {
          vreturn= "1";
        }

        return vreturn;
  }

  // validasi jquery batas file
  $("input[type='file']").on("change", function () {
    // console.log("asd"+this.files[0].size);
    if(this.files[0].size > 2000000) {
      mbox.alert("check file upload harus di bawah 2 MB", {open_speed: 0});
      $(this).val('');
    }

    // if (window.parent && window.parent.document)
    // {
    //   if (typeof window.parent.iframeLoaded === 'function')
    //   {
    //     parent.iframeLoaded();
    //   }
    // }
  });

  // set foto default
  if(typeof getarrlistpilihfilefield == "undefined"){}
  else
  {
    arrdefaultfoto= getarrlistpilihfilefield["foto"];
    if(Array.isArray(arrdefaultfoto) && arrdefaultfoto.length)
    {
      varrdefaultfoto= arrdefaultfoto.filter(item => item.selected === "selected");
      // console.log(varrdefaultfoto);

      if(Array.isArray(varrdefaultfoto) && varrdefaultfoto.length)
      {
        vurl= varrdefaultfoto[0]["vurl"];
        vurl= vurl.replace("../", "");
        vext= varrdefaultfoto[0]["ext"];
        if(isgambar(vext) == "1")
        {
          $("#infoimage").attr("src", vurl);
        }
      }
    }
  }

  function buttonframepdf(infoid) {
    $('[id^="buttonframepdf"]').hide();

    reqDokumenIndexId= $("#reqDokumenIndexId"+infoid+" option:selected").val();
    if(typeof getarrlistpilihfilefield == "undefined"){}
    else
    {
      getarrlistpilihfilepegawai= getarrlistpilihfilefield[infoid];
      // console.log(getarrlistpilihfilepegawai);return false;

      if(Array.isArray(getarrlistpilihfilepegawai) && getarrlistpilihfilepegawai.length)
      {
        varrlistpilihfilepegawai= getarrlistpilihfilepegawai.filter(item => item.index === reqDokumenIndexId);
        // console.log(varrlistpilihfilepegawai);return false;

        vurl= varrlistpilihfilepegawai[0]["vurl"];
        vurl= vurl.replace("../", "");
        vext= varrlistpilihfilepegawai[0]["ext"];

        $("#vnewframe").val(infoid);

        labelvpdf= $("#labelvpdf"+infoid).val();
        $("#labelframepdf"+infoid).text("Tutup " + labelvpdf);
        $("#labelglobalvpdf").val(infoid);
        $("#buttonframepdf"+infoid).show();

        $("#infonewimage, #infonewframe").hide();
        if(isgambar(vext) == "1")
        {
          $("#infonewimage").show();
          $("#infonewimage").attr("src", vurl);
          // console.log(varrlistpilihfilepegawai);
        }
        else
        {
          $("#infonewframe").show();
          var infonewframe= $('#infonewframe');
          vnewframe= $("#vnewframe").val();
          if(vnewframe == ""){}
          else
          {
            infourl= vlinkurlapi+vurl;
            // console.log(infourl);
            infonewframe.attr('data', infourl);
            $("#klikbuttoniframe").click();
          }
        }
      }

    }

  }

  $('[id^="buttonframepdf"]').each(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("buttonframepdf", "");

    setdokumenpilih(vinfoid, "");
  });
      
  $('[id^="reqDokumenPilih"]').change(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("reqDokumenPilih", "");
    setdokumenpilih(vinfoid, "data");
  });

  $('[id^="reqDokumenIndexId"]').change(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("reqDokumenIndexId", "");
    setinfonewframe(vinfoid, "data");
  });

  function setdokumenpilih(vinfoid, infomode)
  {
    reqDokumenPilih= $("#reqDokumenPilih"+vinfoid).val();

    if(infomode == ""){}
    else
    {
      $("#reqDokumenFileKualitasId"+vinfoid).val("");

      if(vselectmaterial == "1")
      {
        $("#reqDokumenFileKualitasId"+vinfoid).material_select();
      }
    }

    $("#buttonframepdf"+vinfoid+", #labeldokumenfileupload"+vinfoid+", #labeldokumendarifileupload"+vinfoid).hide();
    if(reqDokumenPilih == "1")
    {
      $("#reqDokumenFileId"+vinfoid).val("");
      $("#labeldokumenfileupload"+vinfoid).show();
    }
    else if(reqDokumenPilih == "2")
    {
      $("#labeldokumendarifileupload"+vinfoid).show();
      $("#buttonframepdf"+vinfoid).show();
      setinfonewframe(vinfoid, infomode);
    }
  }

  function setinfonewframe(vinfoid, infomode)
  {
    reqDokumenIndexId= $("#reqDokumenIndexId"+vinfoid).val();

    infoid= reqDokumenIndexId;
    // console.log(infoid+"-"+vinfoid);
    if(typeof getarrlistpilihfilefield == "undefined"){}
    else
    {
      getarrlistpilihfilepegawai= getarrlistpilihfilefield[vinfoid];
      // console.log(getarrlistpilihfilepegawai);

      if(Array.isArray(getarrlistpilihfilepegawai) && getarrlistpilihfilepegawai.length)
      {
        varrlistpilihfilepegawai= getarrlistpilihfilepegawai.filter(item => item.index === infoid);
        // console.log(varrlistpilihfilepegawai);

        if(Array.isArray(varrlistpilihfilepegawai) && varrlistpilihfilepegawai.length)
        {
          vurl= varrlistpilihfilepegawai[0]["vurl"];
          vurl= vurl.replace("../", "");
          vext= varrlistpilihfilepegawai[0]["ext"];
          reqDokumenFileId= varrlistpilihfilepegawai[0]["id"];
          reqDokumenFileKualitasId= varrlistpilihfilepegawai[0]["filekualitasid"];
          // reqDokumenFileRiwayatId= varrlistpilihfilepegawai[0]["inforiwayatid"];

          // console.log(reqDokumenFileId);
          if(vurl == ""){}
          else
          {
            // console.log(varrlistpilihfilepegawai);
            $("#reqDokumenFileId"+vinfoid).val(reqDokumenFileId);
            $("#reqDokumenPath"+vinfoid).val(vurl);
            $("#reqDokumenFileKualitasId"+vinfoid).val(reqDokumenFileKualitasId);
            // $("#reqDokumenFileRiwayatId"+vinfoid).val(reqDokumenFileRiwayatId);

            if(infomode == ""){}
            else
            {
              $("#infonewimage, #infonewframe").hide();
              if(isgambar(vext) == "1")
              {
                $("#infonewimage").show();
                $("#infonewimage").attr("src", vurl);
                // console.log(varrlistpilihfilepegawai);
              }
              else
              {
                $("#infonewframe").show();
                var infonewframe= $('#infonewframe');
                vnewframe= $("#vnewframe").val();
                if(vnewframe == ""){}
                else
                {
                  infourl= vlinkurlapi+vurl;
                  // console.log(infourl);
                  infonewframe.attr('data', infourl);
                  $("#klikbuttoniframe").click();
                }
              }

            }
          }

        }

      }
    }
  }

});

function copytoclipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
</script>