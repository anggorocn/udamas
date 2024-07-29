<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$cekquery= $this->input->get("c");

$arrtipekursus= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "tipekursus", $arrdata,'');
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("TIPE_KURSUS_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrtipekursus, $arrdata);
}

$arrrumpun= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "rumpun", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("RUMPUN_ID");
  $arrdata["text"]= $set->getField("KETERANGAN");
  array_push($arrrumpun, $arrdata);
}

$arrrBidangTerkait= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "bidangterkait", $arrdata,'');
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("BIDANG_TERKAIT_ID");
  $arrdata["text"]= $set->getField("NAMA");
   $arrdata["rumpunid"]= $set->getField("RUMPUN_ID");
  $arrdata["rumpun"]= $set->getField("RUMPUN_NAMA");
  array_push($arrrBidangTerkait, $arrdata);
}
// print_r($arrrBidangTerkait);exit;

$arrinfonilairumpun= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "rumpunnilai", $arrdata, "");
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["ID"]= $set->getField("INFOID");
  $arrdata["NILAI"]= $set->getField("NILAI");
  array_push($arrinfonilairumpun, $arrdata);
}
// print_r($arrinfonilairumpun);exit;

$arrstatuslulus= array(
    array("id"=>"", "text"=> "Belum")
    , array("id"=>"1", "text"=> "Ya")
);

// pakem data validasi
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"diklat_kursus_json", "id"=>$reqId, "rowid"=>$reqRowId];
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
$reqValRowId= $set->getField("DIKLAT_KURSUS_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
$reqTipeKursus= $set->getField('TIPE_KURSUS_ID'); $vTipeKursus= checkwarna($reqPerubahanData, 'TIPE_KURSUS_ID', $arrtipekursus, array("id", "text"), $reqTempValidasiHapusId);
$reqJenisKursus= $set->getField('JENIS_KURSUS_NAMA');
$reqJenisKursusId= $set->getField('REF_JENIS_KURSUS_ID');
$reqJenisKursusData= $set->getField('REF_JENIS_KURSUS_DATA');
$reqTahun= $set->getField('TAHUN'); $vTahun= checkwarna($reqPerubahanData, 'TAHUN', [$reqTahun]);
$reqRefInstansiId = $set->getField('REF_INSTANSI_ID');
$reqRefInstansi= $set->getField('REF_INSTANSI_INFO'); $vRefInstansi= checkwarna($reqPerubahanData, 'REF_INSTANSI_NAMA');  
$reqPenyelenggara = $set->getField('PENYELENGGARA'); $vPenyelenggara= checkwarna($reqPerubahanData, 'PENYELENGGARA');
$reqNamaKursus= $set->getField('NAMA'); $vNamaKursus= checkwarna($reqPerubahanData, 'NAMA');
$reqBidangTerkaitId = $set->getField('BIDANG_TERKAIT_ID'); $vBidangTerkaitId= checkwarna($reqPerubahanData, 'BIDANG_TERKAIT_ID');
$reqTglSertifikat= dateToPageCheck($set->getField('TANGGAL_SERTIFIKAT')); $vTglSertifikat= checkwarna($reqPerubahanData, 'TANGGAL_SERTIFIKAT', [date]);
$reqNoSertifikat= $set->getField('NO_SERTIFIKAT'); $vNoSertifikat= checkwarna($reqPerubahanData, 'NO_SERTIFIKAT');
$reqAngkatan= $set->getField('ANGKATAN'); $vAngkatan= checkwarna($reqPerubahanData, 'ANGKATAN');
$reqRumpunJabatan= $set->getField('RUMPUN_ID'); $vRumpunJabatan= checkwarna($reqPerubahanData, 'RUMPUN_ID', $arrrumpun, array("id", "text"), $reqTempValidasiHapusId);
$reqRumpunJabatanNama= $set->getField('RUMPUN_NAMA');
$reqTglMulai= dateToPageCheck($set->getField('TANGGAL_MULAI')); $vTglMulai= checkwarna($reqPerubahanData, 'TANGGAL_MULAI', [date]);
$reqTglSelesai= dateToPageCheck($set->getField('TANGGAL_SELESAI')); $vTglSelesai= checkwarna($reqPerubahanData, 'TANGGAL_SELESAI', [date]);
$reqJumlahJam= $set->getField('JUMLAH_JAM'); $vJumlahJam= checkwarna($reqPerubahanData, 'JUMLAH_JAM');
$reqNilaiKompentensi= $set->getField('NILAI_REKAM_JEJAK'); $vNilaiKompentensi= checkwarna($reqPerubahanData, 'NILAI_REKAM_JEJAK');
$reqTempat= $set->getField('TEMPAT'); $vTempat= checkwarna($reqPerubahanData, 'TEMPAT');
$reqStatusLulus= $set->getField('STATUS_LULUS'); $vStatusLulus= checkwarna($reqPerubahanData, 'STATUS_LULUS', $arrstatuslulus, array("id", "text"), $reqTempValidasiHapusId);

// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"diklat_kursus"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);

// untuk kondisi file
$set= new DataCombo();
$tipekondisikategori= $set->selectby($sessPersonalToken, "kondisikategori", [], "", "json");
// print_r(kondisikategori($tipekondisikategori, "1"));
$arrpilihfiledokumen= $set->selectby($sessPersonalToken, "pilihfiledokumen", [], "", "json");
// print_r($arrpilihfiledokumen);exit;

$riwayattable= "DIKLAT_KURSUS";
$reqDokumenKategoriFileId= "25"; // ambil dari table KATEGORI_FILE, cek sesuai mode
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
// print_r($arrkualitasfile);exit;
?>
<script type="text/javascript">
  
  
</script>
<script type="text/javascript">
$(function(){
  let validator = $('#ff').jbvalidator({
    errorMessage: true
    , successClass: true
  });
  

  $('#reqJumlahJam').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $(document).on('submit', '#ff', function(){
      var dataform = $('#ff')[0];
      var formData = new FormData(dataform);
    
      $.ajax({
        url:"api/<?=$linkfilenamekembali?>_json/add"
        , type: 'POST'
        , data:formData
        , dataType: 'json'
         ,processData: false
        ,contentType: false
        , success: function (response){
          <?
          if(!empty($cekquery))
          {
          ?>
          console.log(response);return false;
          <?
          }
          ?>
          
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
                  // addurl= "?reqId=<?=$reqId?>";
                  addurl= "?reqRowId="+rowid;
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

  $("#labelrumpunset").show();
  $("#labelrumpunselect").hide();
  reqJenisKursusId= "<?=$reqJenisKursusId?>";
  if(reqJenisKursusId == "")
  {
    $("#labelrumpunset").hide();
    $("#labelrumpunselect").show();
  }

  $("#reqTglSelesai").datepicker({
    dateFormat: "dd-mm-yy"
    , changeMonth: true
    , changeYear: true
    , inline: true
    
  });

  // $('#reqTglSelesai').keyup(function() {
  //   settahun();
  // });

  getarrinfonilairumpun= JSON.parse('<?=JSON_encode($arrinfonilairumpun)?>');
  // console.log(getarrinfonilairumpun);

  $("#reqTipeKursus").change(function() { 
    var reqTipeKursus= $("#reqTipeKursus").val();

    reqNilaiKompentensiText= 0;
    infoid= reqTipeKursus;
    valarrinfonilairumpun= getarrinfonilairumpun.filter(item => item.ID === infoid);
    // console.log(valarrinfonilairumpun);
    if(Array.isArray(valarrinfonilairumpun) && valarrinfonilairumpun.length)
    {
      reqNilaiKompentensiText= valarrinfonilairumpun[0]["NILAI"];
    }

    $("#reqNilaiKompentensi, #reqNilaiKompentensiText").val(reqNilaiKompentensiText);
  });

  $("#reqRumpunJabatanSelect").change(function() { 
    var reqRumpunJabatan= $("#reqRumpunJabatanSelect").val();
    var reqRumpunJabatanNama= $("#reqRumpunJabatanSelect option:selected").text();
    // console.log(reqRumpunJabatanNama);

    $("#reqRumpunJabatan").val(reqRumpunJabatan);
    $("#reqRumpunJabatanNama").val(reqRumpunJabatanNama);
  });

  $('#reqJenisKursusCari').keyup(function() {
    reqJenisKursusCari= $(this).val();
    // console.log(reqJenisKursusCari);

    if(reqJenisKursusCari == "")
    {
      $("#reqJenisKursusData, #reqJenisKursusId, #reqRumpunJabatan, #reqRumpunJabatanNama").val("");
      $("#labelrumpunset").hide();
      $("#labelrumpunselect").show();
    }
  });

  $('#reqRefInstansiCari').keyup(function() {
    reqRefInstansiCari= $(this).val();
    // console.log(reqRefInstansiCari);

    if(reqRefInstansiCari == "")
    {
      $("#reqRefInstansiId").val("");
    }
  });

  $("#reqJenisKursusCari, #reqRefInstansiCari").each(function() {
      $(this).autocomplete({
          source:function(request, response) {
              var id= this.element.attr('id');
              var urlAjax= "";

              if(id=="reqJenisKursusCari")
              {
                urlAjax= "api/combo/jeniskursus";
              }
              else if (id=="reqRefInstansiCari")
              {
                urlAjax= "api/combo/instansi";  
              }

              $.ajax({
                  url: urlAjax,
                  type: "GET",
                  dataType: "json",
                  data: { term: request.term },
                  success: function(responseData) {
                    // console.log(responseData);

                    if(Array.isArray(responseData) && responseData.length)
                    {
                      var array = responseData.map(function(element) {
                        return {desc: element['desc'], id: element['id'], label: element['label'], rumpun_id: element['rumpun_id'], rumpun_nama: element['rumpun_nama']};
                      });
                      response(array);
                    }
                    else
                    { 
                      if (id=="reqRefInstansiCari")
                      {
                        $("#reqRefInstansiId").val("");
                      }
                      response(null);
                    }
                  }
                })
          },
          focus: function (event, ui) 
          {
              var id= $(this).attr('id');
              var infoid= infolabel= "";
              infoid= ui.item.id;
              infolabel= ui.item.label;
              if(id=="reqJenisKursusCari")
              {
                  $("#reqJenisKursusId").val(infoid);
                  $("#reqJenisKursusData").val(infolabel);
                  $("#reqRumpunJabatan").val(ui.item.rumpun_id).trigger('change');
                  $("#reqRumpunJabatanNama").val(ui.item.rumpun_nama).trigger('change');

                  $("#labelrumpunset").show();
                  $("#labelrumpunselect").hide();
              }
              else if (id=="reqRefInstansiCari")
              {
                 $("#reqRefInstansiId").val(infoid);
              }
          },
          autoFocus: true
      })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
      .append( "<a>" + item.desc  + "</a>" )
      .appendTo( ul );
    }
    ;
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
  }else{
     $("#reqTahun, #reqTahunText").val('');
  }
}

function check_before_tanggal(){
  $('#reqTglSertifikat,#reqTglMulai,#reqTglSelesai').on("keyup change", function() {
      var vtanggalawal = $(this).val(); 
     
      var vtanggalakhir = moment().add(1, 'days').format("DD-MM-YYYY");

      var checktanggalakhir= moment(vtanggalakhir , 'DD-MM-YYYY', true).isValid();
      var checktanggalawal= moment(vtanggalawal , 'DD-MM-YYYY', true).isValid();

       var tglakhir = moment(vtanggalakhir, 'DD-MM-YYYY');  // format tanggal
       var tglawal = moment(vtanggalawal, 'DD-MM-YYYY'); 
           if(checktanggalawal == true ){
            if (tglawal.isSameOrAfter(tglakhir)) {
              $.alert('Tidak boleh melebihi tanggal waktu entry');
               $(this).val(''); 
            }
            else 
            {
              settahun();
            }
     }
  });
}
$( document ).ready(function() {
  check_before_tanggal();
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

      <form class="needs-validation"  id="ff" method="post" novalidate enctype="multipart/form-data">
        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqTipeKursus">
              Tipe Kursus
              <?
              $warnadata= $vTipeKursus['data'];
              $warnaclass= $vTipeKursus['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select name="reqTipeKursus" id="reqTipeKursus" class="form-control <?=$warnaclass?>" required>
              <option value=""></option>
              <?
              foreach ($arrtipekursus as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqTipeKursus == $optionid)
                  $optionselected= "selected";
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-row" style="display: none;">
          <div class="col-md-12 mb-12">
            <label for="reqJenisKursusCari">Jenis Diklat/Kursus/Seminar/Workshop</label>
            <input type="hidden" name="reqJenisKursusId" id="reqJenisKursusId" value="<?=$reqJenisKursusId?>" />
            <input type="hidden" name="reqJenisKursusData" id="reqJenisKursusData" value="<?=$reqJenisKursusData?>" />
            <input type="text" class="form-control" placeholder="" name="reqJenisKursus" id="reqJenisKursusCari" <?=$read?> value="<?=$reqJenisKursus?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <label for="reqNamaKursus">
              Nama Diklat/Kursus/Seminar/Workshop
              <?
              $warnadata= $vNamaKursus['data'];
              $warnaclass= $vNamaKursus['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" class="form-control <?=$warnaclass?>" placeholder="" name="reqNamaKursus" id="reqNamaKursus" <?=$read?> value="<?=$reqNamaKursus?>" required />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqNoSertifikat">
              No Sertifikat / Piagam
              <?
              $warnadata= $vNoSertifikat['data'];
              $warnaclass= $vNoSertifikat['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" required class="form-control <?=$warnaclass?>" placeholder="" name="reqNoSertifikat" id="reqNoSertifikat" <?=$read?> value="<?=$reqNoSertifikat?>" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqTglSertifikat">
              Tgl Sertifikat / Piagam
              <?
              $warnadata= $vTglSertifikat['data'];
              $warnaclass= $vTglSertifikat['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" required class="form-control formattanggalnew <?=$warnaclass?>" placeholder="" name="reqTglSertifikat" id="reqTglSertifikat" <?=$read?> maxlength="10" onKeyDown="return format_date(event,'reqTglSertifikat');" value="<?=$reqTglSertifikat?>" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqTglMulai">
              Tgl Mulai
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
            </label>
            <input type="text" class="form-control formattanggalnew <?=$warnaclass?>" placeholder="" name="reqTglMulai" id="reqTglMulai" <?=$read?> maxlength="10" onKeyDown="return format_date(event,'reqTglMulai');" value="<?=$reqTglMulai?>" required />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqTglSelesai">
              Tgl Selesai
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
            </label>
            <input type="text" class="form-control formattanggalnew <?=$warnaclass?>" placeholder="" name="reqTglSelesai" id="reqTglSelesai" <?=$read?> maxlength="10" onKeyDown="return format_date(event,'reqTglSelesai');" value="<?=$reqTglSelesai?>" required />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqJumlahJam">
              Jumlah Jam
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
            </label>
            <input type="text" required class="form-control <?=$warnaclass?>" placeholder="" name="reqJumlahJam" id="reqJumlahJam" <?=$read?> value="<?=$reqJumlahJam?>" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqTahunText">
              Tahun
              <?
              $warnadata= $vTahun['data'];
              $warnaclass= $vTahun['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqTahun" id="reqTahun" value="<?=$reqTahun?>" />
            <input class="form-control <?=$warnaclass?>" placeholder="" type="text" id="reqTahunText" disabled value="<?=$reqTahun?>" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqAngkatan">
              Angkatan
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
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder="" type="text" name="reqAngkatan" id="reqAngkatan" <?=$read?> value="<?=$reqAngkatan?>" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqTempat">
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
            <input class="form-control <?=$warnaclass?>" placeholder="" type="text" name="reqTempat" id="reqTempat" <?=$read?> value="<?=$reqTempat?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqStatusLulus">
              Lulus
              <?
              $warnadata= $vStatusLulus['data'];
              $warnaclass= $vStatusLulus['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" id="reqStatusLulus" name="reqStatusLulus">
              <option value="">Belum</option>
              <option value="1" <? if($reqStatusLulus == "1") echo "selected";?>>Ya</option>
            </select>
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqNilaiKompentensi">
              Nilai Kompetensi
              <?
              $warnadata= $vNilaiKompentensi['data'];
              $warnaclass= $vNilaiKompentensi['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqNilaiKompentensi" id="reqNilaiKompentensi" value="<?=$reqNilaiKompentensi?>" />
            <input class="form-control <?=$warnaclass?>" placeholder="" disabled type="text" id="reqNilaiKompentensiText" value="<?=$reqNilaiKompentensi?>" />
          </div>
           <div class="col-md-3 mb-3">
            <label for="reqBidangTerkaitId">
              Bidang Terkait
              <?
              $warnadata= $vBidangTerkaitId['data'];
              $warnaclass= $vBidangTerkaitId['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>"  id="reqBidangTerkaitId" name="reqBidangTerkaitId">
                <option value=""></option>
                <?
                foreach ($arrrBidangTerkait as $key => $value)
                {
                  $optionid= $value["id"];
                  $optiontext= $value["text"];
                  $optionselected= "";
                  if($reqBidangTerkaitId == $optionid)
                    $optionselected= "selected";
                ?>
                  <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
                }
                ?>
            </select>
            
          </div>
        
          <div class="col-md-3 mb-3" id="labelrumpunselect">
            <label for="reqRumpunJabatan">
              Rumpun Kompetensi
              <?
              $warnadata= $vRumpunJabatan['data'];
              $warnaclass= $vRumpunJabatan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqRumpunJabatan" id="reqRumpunJabatan" value="<?=$reqRumpunJabatan?>" />
            <input placeholder="" type="text" disabled class="form-control <?=$warnaclass?>" id="reqRumpunNamaKompetensi" value="<?=$reqRumpunJabatanNama?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <label for="reqRefInstansiCari">
              Instansi Penyelenggara
              <?
              $warnadata= $vRefInstansi['data'];
              $warnaclass= $vRefInstansi['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqRefInstansiId" id="reqRefInstansiId" value="<?=$reqRefInstansiId?>" />
            <input type="text" required class="form-control <?=$warnaclass?>" placeholder="" name="reqRefInstansi" id="reqRefInstansiCari" <?=$read?> value="<?=$reqRefInstansi?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <label for="reqPenyelenggara">
              OPD/Unit Kerja Penyelenggara
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
            </label>
            <input type="text" class="form-control <?=$warnaclass?>" placeholder="" name="reqPenyelenggara" id="reqPenyelenggara" <?=$read?> value="<?=$reqPenyelenggara?>" />
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="row">
          <div class="col-md-12">
            <input type="hidden" name="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqRowId" value="<?=$reqValRowId?>" />
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
                <button class="btn btn-primary" type="submit">Simpan</button>
            <?
                if(!empty($reqTempValidasiId))
                {
            ?>
                <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'diklat_kursus', '', '<?=$linkfilenamekembali?>')">Batal</button>
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
arrbidangterkait= JSON.parse('<?=JSON_encode($arrrBidangTerkait)?>');
$("#reqBidangTerkaitId").change(function() { 
  var reqBidangTerkaitId= $("#reqBidangTerkaitId").val();

  reqNilaiKompentensiText= 0;
  infoid= reqBidangTerkaitId;
  varrbidangterkait= arrbidangterkait.filter(item => item.id === infoid);
  // console.log(varrbidangterkait);
  vtextid= vtext= "";
  if(Array.isArray(varrbidangterkait) && varrbidangterkait.length)
  {
    vtextid= varrbidangterkait[0]["rumpunid"];
    vtext= varrbidangterkait[0]["rumpun"];
  }
 
  $("#reqRumpunJabatan").val(vtextid);
  $("#reqRumpunNamaKompetensi").val(vtext);
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