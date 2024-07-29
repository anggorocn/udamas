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

$arrDiklat= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "diklat_struktural", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("DIKLAT_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrDiklat, $arrdata);
}

$arrdataField= [];
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Diklat_struktural_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// print_r($set);exit;
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("DIKLAT_STRUKTURAL_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}

// pakem data validasi
$reqDiklat= $set->getField('DIKLAT_ID'); $vDiklat= checkwarna($reqPerubahanData, 'DIKLAT_ID', $arrDiklat, array("id", "text"), $reqTempValidasiHapusId);
$reqTahun= $set->getField('TAHUN');
$reqNoSttpp= $set->getField('NO_STTPP'); $vNoSttpp= checkwarna($reqPerubahanData, 'NO_STTPP');
$reqPenyelenggara= $set->getField('PENYELENGGARA'); $vPenyelenggara= checkwarna($reqPerubahanData, 'PENYELENGGARA');
$reqAngkatan= $set->getField('ANGKATAN'); $vAngkatan= checkwarna($reqPerubahanData, 'ANGKATAN');
$reqTglMulai= dateToPageCheck($set->getField('TANGGAL_MULAI')); $vTglMulai = checkwarna($reqPerubahanData, 'TANGGAL_MULAI',[date]);
$reqTglSelesai= dateToPageCheck($set->getField('TANGGAL_SELESAI')); $vTglSelesai = checkwarna($reqPerubahanData, 'TANGGAL_SELESAI',[date]);
$reqTglSttpp= dateToPageCheck($set->getField('TANGGAL_STTPP')); $vTglSttpp = checkwarna($reqPerubahanData, 'TANGGAL_STTPP',[date]);
$reqTempat= $set->getField('TEMPAT'); $vTempat= checkwarna($reqPerubahanData, 'TEMPAT');
$reqJumlahJam= $set->getField('JUMLAH_JAM'); $vJumlahJam= checkwarna($reqPerubahanData, 'JUMLAH_JAM');

$reqNilaiKompentensi= $set->getField('NILAI_REKAM_JEJAK');
$reqRumpunJabatan= $set->getField('RUMPUN_ID');
$reqRumpunJabatanNama= $set->getField('RUMPUN_NAMA');

$reqJabatanRiwayatId= $set->getField("JABATAN_RIWAYAT_ID");
$reqJabatanRiwayatNama= $set->getField("JABATAN_RIWAYAT_NAMA");
$reqJabatanRiwayatEselon= $set->getField("JABATAN_RIWAYAT_ESELON");
$reqJabatanRiwayatSatkerNama= $set->getField("JABATAN_RIWAYAT_SATKER");

if(empty($reqNilaiKompentensi))
  $reqNilaiKompentensi= "15";

if(empty($reqCheckPegawaiId))
{
  $arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pegawai_json"];
  $set= new DataCombo();
  $set->selectdata($arrparam, "");
  $set->firstRow();
  $reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
}

// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"diklat_struktural"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);

// untuk kondisi file
$arrinfonilairumpun= [];
$set= new DataCombo();
$tipekondisikategori= $set->selectby($sessPersonalToken, "kondisikategori", [], "", "json");
// print_r(kondisikategori($tipekondisikategori, "1"));
$arrpilihfiledokumen= $set->selectby($sessPersonalToken, "pilihfiledokumen", [], "", "json");
// print_r($arrpilihfiledokumen);exit;

$riwayattable= "DIKLAT_STRUKTURAL";
$reqDokumenKategoriFileId= "11"; // ambil dari table KATEGORI_FILE, cek sesuai mode
$arrsetriwayatfield= $set->selectby($sessPersonalToken, "setriwayatfield", ["riwayattable"=>$riwayattable], "", "json");
// print_r($arrsetriwayatfield);exit;

$fileRowId= $reqValRowId;
if(empty($reqValRowId))
  $fileRowId= "baru";

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
?>
<script type="text/javascript">
$(function(){
  let validator = $('#ff').jbvalidator({
    errorMessage: true
    , successClass: true
  });

  $(document).on('submit', '#ff', function(){

      reqJabatanRiwayatId= $("#reqJabatanRiwayatId").val();
      if(reqJabatanRiwayatId == "")
      {
        $.alert("Isikan nama jabatan terlebih dahulu.");
        return false;
      }

      var dataform = $('#ff')[0];
      var formData = new FormData(dataform);
      
      $.ajax({
        url:"api/Diklat_struktural_json/add"
        , type: 'POST'
        , data:formData
        , dataType: 'json'
        ,processData: false
        ,contentType: false
        // , type: 'POST'
        // , data: $(this).serialize()
        // , dataType: 'json'
        , success: function (response){
          // console.log(response);return false;

          data= response.message;
          data= data.split("-");
          rowid= data[0];
          infodata= data[1];

          $.alert({
            title: 'Info Simpan !!!',
            content: infodata,
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
                  // window.location.reload();
                  return;
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

  $("#reqTglSelesai").datepicker({
    dateFormat: "dd-mm-yy"
    , changeMonth: true
    , changeYear: true
    , inline: true
    , onSelect: function() {
      settahun();
    }
  });

  $('#reqTglSelesai').keyup(function() {
    settahun();
  });

  $('#reqTglMulai').keyup(function() {
    var vtanggalawal= $('#reqTglMulai').val();
    var checktanggalawal= moment(vtanggalawal , 'DD-MM-YYYY', true).isValid();
    if(checktanggalawal == true)
    {
      ajaxurl= "api/combo/jabatandiklatstruktural?reqId=<?=$reqCheckPegawaiId?>&reqTanggal="+vtanggalawal;
      $.ajax({
        cache: false,
        url: ajaxurl,
        processData: false,
        contentType: false,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          if(Array.isArray(response) && response.length)
          {
            response= response[0];
            // console.log(response); return false;
            jabatanriwayatid= response.infoid;
            jabatanriwayatnama= response.infonama;
            jabatanriwayateselon= response.infoeselonnama;
            jabatanriwayatsatker= response.infosatkernama;
            jabatanriwayatrumpunid= response.inforumpunid;
            jabatanriwayatrumpunnama= response.inforumpunnama;

            $("#reqJabatanRiwayatId").val(jabatanriwayatid);
            $("#reqJabatanRiwayatNama").val(jabatanriwayatnama);
            $("#reqJabatanRiwayatEselon").val(jabatanriwayateselon);
            $("#reqJabatanRiwayatSatkerNama").val(jabatanriwayatsatker);
            $("#reqRumpunJabatan").val(jabatanriwayatrumpunid);
            $("#reqRumpunJabatanNama").val(jabatanriwayatrumpunnama);
          }
          else
          {
            // console.log("a");
          }
        },
        error: function(xhr, status, error) {
        },
        complete: function () {
        }
      });
    }
  });

});

function settahun()
{
  var vtanggalakhir= $('#reqTglSelesai').val();
  var vtanggalawal= $('#reqTglMulai').val();
  var checktanggalakhir= moment(vtanggalakhir , 'DD-MM-YYYY', true).isValid();
  var checktanggalawal= moment(vtanggalawal , 'DD-MM-YYYY', true).isValid();
  // console.log(checktanggalakhir+'_'+checktanggalawal);
  if(checktanggalakhir == true && checktanggalawal == true)
  {
    var tglakhir = moment(vtanggalakhir, 'DD-MM-YYYY');  // format tanggal
    var tglawal = moment(vtanggalawal, 'DD-MM-YYYY'); 

    if (tglakhir.isSameOrAfter(tglawal)) {} 
    else 
    {
       $('#reqTglSelesai').val(vtanggalawal);
    }

    vtanggalakhir= $('#reqTglSelesai').val();
    vtahun= vtanggalakhir.substring(6,10);
    $("#reqTahun, #reqTahunText").val(vtahun);
  }
}
 
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
          <label class="control-label col-sm-2" for="">Jenjang Diklat Struktural 
          <?
          $warnadata= $vDiklat['data'];
          $warnaclass= $vDiklat['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-4">
             <select id="reqDiklat" name="reqDiklat" class="form-control <?=$warnaclass?> " required>
                <option value="" <? if($reqDiklat=="") echo 'selected';?>></option>
                <?
                foreach ($arrDiklat as $key => $value)
                {
                  $optionid= $value["id"];
                  $optiontext= $value["text"];
                  $optionselected= "";
                  if($reqDiklat == $optionid)
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
          <label class="control-label col-sm-2" for="">No Sertifikat / Piagam 
          <?
          $warnadata= $vNoSttpp['data'];
          $warnaclass= $vNoSttpp['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-2">
            <input type="text" required class="form-control easyui-validatebox <?=$warnaclass?>" id="reqNoSttpp" name="reqNoSttpp" placeholder="Isikan No Sertifikat / Piagam" value="<?=$reqNoSttpp?>">
          </div>
          <label class="control-label col-sm-2" for="">Tgl Sertifikat / Piagam 
          <?
          $warnadata= $vTglSttpp['data'];
          $warnaclass= $vTglSttpp['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-2">
            <input type="text" class="form-control formattanggalnew <?=$warnaclass?>" id="reqTglSttpp" onKeyDown="return format_date(event,'reqTglSttpp');" name="reqTglSttpp"  required placeholder="Isikan Tgl Sertifikat / Piagam" value="<?=$reqTglSttpp?>">
          </div>
          <label class="control-label col-sm-2" for="">Tahun</label>
          <div class="col-sm-2">
             <input type="hidden" name="reqTahun" id="reqTahun" value="<?=$reqTahun?>" />
            <input type="text" required class="form-control easyui-validatebox" id="reqTahunText" name="reqTahunText" placeholder="Isikan Tahun" disabled value="<?=$reqTahun?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Tgl Mulai
          <?
          $warnadata= $vTglMulai['data'];
          $warnaclass= $vTglMulai['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-2">
             <input type="text" class="form-control formattanggalnew <?=$warnaclass?>" id="reqTglMulai" onKeyDown="return format_date(event,'reqTglMulai');" name="reqTglMulai"  required  placeholder="Isikan Tgl Mulai" value="<?=$reqTglMulai?>">
          </div>
          <label class="control-label col-sm-2" for="">Tgl Selesai 
          <?
          $warnadata= $vTglSelesai['data'];
          $warnaclass= $vTglSelesai['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-2">
             <input type="text" class="form-control formattanggalnew <?=$warnaclass?>" id="reqTglSelesai" onKeyDown="return format_date(event,'reqTglSelesai');" name="reqTglSelesai"  required  placeholder="Isikan Tgl Mulai" value="<?=$reqTglSelesai?>">
          </div>
          <label class="control-label col-sm-2" for="">Jam 
          <?
          $warnadata= $vJumlahJam['data'];
          $warnaclass= $vJumlahJam['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-2">
            <input type="text" required class="form-control easyui-validatebox <?=$warnaclass?>" id="reqJumlahJam" name="reqJumlahJam" placeholder="Isikan Jam" value="<?=$reqJumlahJam?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Nama Jabatan:
          </label>
          <div class="col-sm-8">
             <input type="hidden" name="reqJabatanRiwayatId" id="reqJabatanRiwayatId" value="<?=$reqJabatanRiwayatId?>" />
              <input placeholder="Isikan Nama Jabatan" type="text" id="reqJabatanRiwayatNama" class="form-control" disabled value="<?=$reqJabatanRiwayatNama?>" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Eselon:</label>
          <div class="col-sm-4">
            <input placeholder="Isikan Eselon " class="form-control"  type="text" id="reqJabatanRiwayatEselon" disabled value="<?=$reqJabatanRiwayatEselon?>" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">OPD Unit Kerja:</label>
          <div class="col-sm-10">
            <input placeholder="Isikan OPD Unit Kerja "  class="form-control" type="text" id="reqJabatanRiwayatSatkerNama" disabled value="<?=$reqJabatanRiwayatSatkerNama?>" />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Angkatan
          <?
          $warnadata= $vAngkatan['data'];
          $warnaclass= $vAngkatan['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox <?=$warnaclass?>" id="reqAngkatan" required name="reqAngkatan" placeholder="Isikan Angkatan" value="<?=$reqAngkatan?>">
          </div>

          <label class="control-label col-sm-2" for="">
            Tempat
            <?
            $warnadata= $vTempat['data'];
            $warnaclass= $vTempat['warna'];
            if(!empty($warnadata))
            {
            ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
            <?
            }
            ?>
          </label>
          <div class="col-sm-4">
             <input type="text" class="form-control easyui-validatebox <?=$warnaclass?>" id="reqTempat" name="reqTempat" placeholder="Isikan Tempat" value="<?=$reqTempat?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Nilai Kompetensi:</label>
          <div class="col-sm-4">
             <input type="hidden" name="reqNilaiKompentensi" id="reqNilaiKompentensi" value="<?=$reqNilaiKompentensi?>" />
            <input type="text" disabled class="form-control easyui-validatebox" id="reqNilaiKompentensiText" name="reqNilaiKompentensiText" placeholder="Isikan Nilai Kompetensi" value="<?=$reqNilaiKompentensi?>">
          </div>

          <label class="control-label col-sm-2" for="">Rumpun Jabatan</label>
          <div class="col-sm-4">
             <input type="hidden" name="reqRumpunJabatan" id="reqRumpunJabatan" value="<?=$reqRumpunJabatan?>" />
              <input type="text" disabled class="form-control easyui-validatebox" id="reqRumpunJabatanNama" name="reqRumpunJabatanNama" placeholder="Isikan Rumpun Jabatan" value="<?=$reqRumpunJabatanNama?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Penyelenggara
          <?
          $warnadata= $vPenyelenggara['data'];
          $warnaclass= $vPenyelenggara['warna'];
          if(!empty($warnadata))
          {
          ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
          <?
          }
          ?>
          :</label>
          <div class="col-sm-8">
              <input type="text" required class="form-control easyui-validatebox <?=$warnaclass?>" id="reqPenyelenggara" name="reqPenyelenggara" placeholder="Isikan Penyelenggara" value="<?=$reqPenyelenggara?>">
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="row">
          <div class="col-md-12">
            <input type="hidden"  name="reqTipePegawaiId" value="<?=$reqTipePegawaiId?>" />

            <input type="hidden" name="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqRowId" value="<?=$reqValRowId?>" />
            <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>" />
            <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

            <!-- <input type="hidden" name="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
            <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>" />
            <input type="hidden" name="reqMode" value="<?=$reqMode?>" /> -->

            <?
            // untuk hak akses menu
            // khusus a baru bisa tambah
            if(strtoupper($vaksesmenu) == strtoupper("A"))
            {
              if(!empty($buttonsimpan))
              {
            ?>
                <button class="btn btn-primary" type="submit">Simpan</button>
            <?
                if(!empty($reqTempValidasiId))
                {
            ?>
                <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'diklat_struktural', '', '<?=$linkfilenamekembali?>')">Batal</button>
            <?
                }
              }
            }
            ?>
            <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='document.location.href="app/index/<?=$linkfilenamekembali?>"' type="button">Kembali</button>
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

          <div id="labeldokumenfileupload<?=$riwayatfield?>" class="input-field col-md-4">
            <div class="file_input_div">
              <div class="file_input input-field col s12 m4">
                <label class="labelupload form-control">
                  <i class="mdi-file-file-upload" style="font-family: Roboto,sans-serif,Material-Design-Icons !important; font-size: 14px !important;">Upload</i>
                  <input id="file_input_file" name="reqLinkFile[]" class="none" type="file" />
                </label>
              </div>
              <div id="file_input_text_div" class=" input-field col s12 m8" style="display: none;">
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
              <input type="hidden" id="labelglobalvpdf" />
              <iframe style="width: 100%; height: calc(100vh - 100px)" id="infonewframe"></iframe>
              <!-- <object id="infonewframe" data="" type="application/pdf" width="100%" height="800px"></object> -->
             </div>

           </div>
         </div>
       </div>

    </div>
  </div>
</div>

<script type="text/javascript">
$("#reqJumlahJam, #reqTahun").keypress(function(e) {
  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
  {
    return false;
  }
});

// untuk area untuk upload file
vbase_url= "<?=base_url()?>";
getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
if(getarrlistpilihfilefield==null){
getarrlistpilihfilefield=[];
}
vlinkurlapi= "<?=$this->settingurl?>";
vsettingurlupload= "<?=$this->settingurlupload?>";
vreplaceurlupload= "<?=$this->replaceurlupload?>";
// console.log(getarrlistpilihfilefield);
</script>

<script type="text/javascript" src="assets/easyui/pelayanan-pegawai-efile.js"></script>