<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");

$arrtipekursus= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "tipekursus", $arrdata);
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
// print_r($arrrumpun);exit;

$arrinfonilairumpun= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "rumpunnilai", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["ID"]= $set->getField("ID");
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
$reqRowId= $set->getField('PANGKAT_RIWAYAT_ID');

// $reqNoDiklatPrajabatan = $set->getField('PEJABAT_PENETAP_ID');
$reqTglStlud= dateToPageCheck($set->getField('TANGGAL_STLUD')); $vTglStlud= checkwarna($reqPerubahanData, 'TANGGAL_STLUD', [date]);

if($reqTglStlud == "01-01-0001")
  $reqTglStlud= "";
// echo $reqTglStlud;exit();

$reqStlud= $set->getField('STLUD');

$reqNoStlud= $set->getField('NO_STLUD');

$reqNoNota= $set->getField('NO_NOTA');

$reqNoSk= $set->getField('NO_SK');

$reqTh= $set->getField('MASA_KERJA_TAHUN');

$reqBl= $set->getField('MASA_KERJA_BULAN');

$reqKredit= dotToComma($set->getField('KREDIT'));

$reqJenisKp= $set->getField('JENIS_RIWAYAT');

$reqJenisKpNama= $set->getField('JENIS_RIWAYAT_NAMA');

$reqKeterangan= $set->getField('KETERANGAN');

$reqGajiPokok= $set->getField('GAJI_POKOK');

$reqTglNota= dateToPageCheck($set->getField('TANGGAL_NOTA')); $vTglNota= checkwarna($reqPerubahanData, 'TANGGAL_NOTA', [date]);

$reqTglSk= dateToPageCheck($set->getField('TANGGAL_SK')); $vTglSk= checkwarna($reqPerubahanData, 'TANGGAL_SK', [date]);

$reqTmtGol= dateToPageCheck($set->getField('TMT_PANGKAT')); $vTmtGol= checkwarna($reqPerubahanData, 'TMT_PANGKAT', [date]);

$reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');

$reqPejabatPenetap= $set->getField('PEJABAT_PENETAP_NAMA');

$reqGolRuang= $set->getField('PANGKAT_ID');

$reqNoUrutCetak= $set->getField('NO_URUT_CETAK');

$LastLevel= $set->getField('LAST_LEVEL');

$buttonsimpan= "1";
/*if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}*/
?>
<script type="text/javascript">
$(function(){
  let validator = $('#ff').jbvalidator({
    errorMessage: true
    , successClass: true
  });

  $(document).on('submit', '#ff', function(){

      $.ajax({
        url:"api/<?=$linkfilenamekembali?>_json/add"
        , type: 'POST'
        , data: $(this).serialize()
        , dataType: 'json'
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

  $("#reqPropinsiAyah, #reqKabupatenAyah, #reqKecamatanAyah, #reqDesaAyah, #reqPropinsiIbu, #reqKabupatenIbu, #reqKecamatanIbu, #reqDesaIbu").autocomplete({ 
      source:function(request, response){
        var id= this.element.attr('id');
        var replaceAnakId= replaceAnak= urlAjax= "";
        
        if (id.indexOf('reqPropinsiAyah') !== -1)
        {
          var element= id.split('reqPropinsiAyah');
          var indexId= "reqPropinsiAyahId"+element[1];
          urlAjax= "api/Combo/propinsi";
          replaceAnakId= "reqKabupatenAyahId";
          replaceAnak= "reqKabupatenAyah";
          $("#reqKabupatenAyahId, #reqKecamatanAyahId, #reqDesaAyahId").val("");
          $("#reqKabupatenAyah, #reqKecamatanAyah, #reqDesaAyah").val("");
        }
        else if (id.indexOf('reqKabupatenAyah') !== -1)
        {
          var element= id.split('reqKabupatenAyah');
          var indexId= "reqKabupatenAyahId"+element[1];
          var idPropVal= $("#reqPropinsiAyahId").val();
          urlAjax= "api/Combo/kabupaten?reqPropinsiId="+idPropVal;
          replaceAnakId= "reqKecamatanAyahId";
          replaceAnak= "reqKecamatanAyah";
          $("#reqKecamatanAyahId, #reqDesaAyahId").val("");
          $("#reqKecamatanAyah, #reqDesaAyah").val("");
        }
        else if (id.indexOf('reqKecamatanAyah') !== -1)
        {
          var element= id.split('reqKecamatanAyah');
          var indexId= "reqKecamatanAyahId"+element[1];
          var idPropVal= $("#reqPropinsiAyahId").val();
          var idKabVal= $("#reqKabupatenAyahId").val();
          urlAjax= "api/Combo/kecamatan?reqPropinsiId="+idPropVal+"&reqKabupatenId="+idKabVal;
          replaceAnakId= "reqDesaAyahId";
          replaceAnak= "reqDesaAyah";
          $("#reqDesaAyahId").val("");
          $("#reqDesaAyah").val("");
        }
        else if (id.indexOf('reqDesaAyah') !== -1)
        {
          var element= id.split('reqDesaAyah');
          var indexId= "reqDesaAyahId"+element[1];
          var idPropVal= $("#reqPropinsiAyahId").val();
          var idKabVal= $("#reqKabupatenAyahId").val();
          var idKecVal= $("#reqKecamatanAyahId").val();
          urlAjax= "api/Combo/kelurahan?reqPropinsiId="+idPropVal+"&reqKabupatenId="+idKabVal+"&reqKecamatanId="+idKecVal;
        }
        else if (id.indexOf('reqPropinsiIbu') !== -1)
        {
          var element= id.split('reqPropinsiIbu');
          var indexId= "reqPropinsiIbuId"+element[1];
          urlAjax= "api/Combo/propinsi";
          replaceAnakId= "reqKabupatenIbuId";
          replaceAnak= "reqKabupatenIbu";
          $("#reqKabupatenIbuId, #reqKecamatanIbuId, #reqDesaIbuId").val("");
          $("#reqKabupatenIbu, #reqKecamatanIbu, #reqDesaIbu").val("");
        }
        else if (id.indexOf('reqKabupatenIbu') !== -1)
        {
          var element= id.split('reqKabupatenIbu');
          var indexId= "reqKabupatenIbuId"+element[1];
          var idPropVal= $("#reqPropinsiIbuId").val();
          urlAjax= "api/Combo/kabupaten?reqPropinsiId="+idPropVal;
          replaceAnakId= "reqKecamatanIbuId";
          replaceAnak= "reqKecamatanIbu";
          $("#reqKecamatanIbuId, #reqDesaIbuId").val("");
          $("#reqKecamatanIbu, #reqDesaIbu").val("");
        }
        else if (id.indexOf('reqKecamatanIbu') !== -1)
        {
          var element= id.split('reqKecamatanIbu');
          var indexId= "reqKecamatanIbuId"+element[1];
          var idPropVal= $("#reqPropinsiIbuId").val();
          var idKabVal= $("#reqKabupatenIbuId").val();
          urlAjax= "api/Combo/kecamatan?reqPropinsiId="+idPropVal+"&reqKabupatenId="+idKabVal;
          replaceAnakId= "reqDesaIbuId";
          replaceAnak= "reqDesaIbu";
          $("#reqDesaIbuId").val("");
          $("#reqDesaIbu").val("");
        }
        else if (id.indexOf('reqDesaIbu') !== -1)
        {
          var element= id.split('reqDesaIbu');
          var indexId= "reqDesaIbuId"+element[1];
          var idPropVal= $("#reqPropinsiIbuId").val();
          var idKabVal= $("#reqKabupatenIbuId").val();
          var idKecVal= $("#reqKecamatanIbuId").val();
          urlAjax= "api/Combo/kelurahan?reqPropinsiId="+idPropVal+"&reqKabupatenId="+idKabVal+"&reqKecamatanId="+idKecVal;
        }
        
        var field= "";
        
        field= "NAMA_ORDER";
        
        $.ajax({
          url: urlAjax,
          type: "GET",
          dataType: "json",
          data: { term: request.term },
          success: function(responseData){
            $("#"+indexId).val("").trigger('change');
            if(replaceAnakId == ""){}
            else
            {
            $("#"+replaceAnakId).val("").trigger('change');
            $("#"+replaceAnak).val("").trigger('change');
            }
            
            if(responseData == null)
            {
              response(null);
            }
            else
            {
              var array = responseData.map(function(element) {
                return {desc: element['desc'], id: element['id'], label: element['label']};
              });
              response(array);
            }
          }
        })
      },
      focus: function (event, ui) 
      { 
        var id= $(this).attr('id');
        var replaceAnakId= replaceAnak= "";
        
        if (id.indexOf('reqPropinsiAyah') !== -1)
        {
          var element= id.split('reqPropinsiAyah');
          var indexId= "reqPropinsiAyahId"+element[1];
          replaceAnakId= "reqKabupatenAyahId";
          replaceAnak= "reqKabupatenAyah";
          $("#reqKabupatenAyahId, #reqKecamatanAyahId, #reqDesaAyahId").val("");
          $("#reqKabupatenAyah, #reqKecamatanAyah, #reqDesaAyah").val("");
        }
        else if (id.indexOf('reqKabupatenAyah') !== -1)
        {
          var element= id.split('reqKabupatenAyah');
          var indexId= "reqKabupatenAyahId"+element[1];
          replaceAnakId= "reqKecamatanAyahId";
          replaceAnak= "reqKecamatanAyah";
          $("#reqKecamatanAyahId, #reqDesaAyahId").val("");
          $("#reqKecamatanAyah, #reqDesaAyah").val("");
        }
        else if (id.indexOf('reqKecamatanAyah') !== -1)
        {
          var element= id.split('reqKecamatanAyah');
          var indexId= "reqKecamatanAyahId"+element[1];
          replaceAnakId= "reqDesaAyahId";
          replaceAnak= "reqDesaAyah";
          $("#reqDesaAyahId").val("");
          $("#reqDesaAyah").val("");
        }
        else if (id.indexOf('reqDesaAyah') !== -1)
        {
          var element= id.split('reqDesaAyah');
          var indexId= "reqDesaAyahId"+element[1];
        }
        else if (id.indexOf('reqPropinsiIbu') !== -1)
        {
          var element= id.split('reqPropinsiIbu');
          var indexId= "reqPropinsiIbuId"+element[1];
          replaceAnakId= "reqKabupatenIbuId";
          replaceAnak= "reqKabupatenIbu";
          $("#reqKabupatenIbuId, #reqKecamatanIbuId, #reqDesaIbuId").val("");
          $("#reqKabupatenIbu, #reqKecamatanIbu, #reqDesaIbu").val("");
        }
        else if (id.indexOf('reqKabupatenIbu') !== -1)
        {
          var element= id.split('reqKabupatenIbu');
          var indexId= "reqKabupatenIbuId"+element[1];
          replaceAnakId= "reqKecamatanIbuId";
          replaceAnak= "reqKecamatanIbu";
          $("#reqKecamatanIbuId, #reqDesaIbuId").val("");
          $("#reqKecamatanIbu, #reqDesaIbu").val("");
        }
        else if (id.indexOf('reqKecamatanIbu') !== -1)
        {
          var element= id.split('reqKecamatanIbu');
          var indexId= "reqKecamatanIbuId"+element[1];
          replaceAnakId= "reqDesaIbuId";
          replaceAnak= "reqDesaIbu";
          $("#reqDesaIbuId").val("");
          $("#reqDesaIbu").val("");
        }
        else if (id.indexOf('reqDesaIbu') !== -1)
        {
          var element= id.split('reqDesaIbu');
          var indexId= "reqDesaIbuId"+element[1];
        }
        
        $("#"+indexId).val(ui.item.id).trigger('change');
      }, 
      //minLength:3,
      autoFocus: true
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
      .append( "<a>" + item.desc + "</a>" )
      .appendTo( ul );
  };

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

      <form class="needs-validation" id="ff" method="post" novalidate enctype="multipart/form-data">
        
        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label>AYAH</label>
            
          </div>

          <div class="col-md-6 mb-6" id="labelpppkstatus">
            <label>IBU</label>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqNamaAyah">
              Nama Ayah
              <?
              $warnadata= $vNamaAyah['data'];
              $warnaclass= $vNamaAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
              <input class="form-control <?=$warnaclass?>" type="text" id="reqNamaAyah" name="reqNamaAyah" value="<?=$reqNamaAyah?>" class="required" title="Nama ayah harus diisi" />
              <input type="hidden"  name="reqIdAyah" value="<?=$reqIdAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqNamaIbu">
              Nama Ibu
              <?
              $warnadata= $vNamaIbu['data'];
              $warnaclass= $vNamaIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
              <input class="form-control <?=$warnaclass?>" type="text" id="reqNamaIbu" name="reqNamaIbu" value="<?=$reqNamaIbu?>" class="required" title="Nama ibu harus diisi"/>
              <input type="hidden"  name="reqIdIbu" value="<?=$reqIdIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqTmptLahirAyah">
              Tempat Lahir Ayah
              <?
              $warnadata= $vTmptLahirAyah['data'];
              $warnaclass= $vTmptLahirAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text"  name="reqTmptLahirAyah" id="reqTmptLahirAyah" value="<?=$reqTmptLahirAyah?>" <?php /*?>class="required" title="Tempat lahir ayah harus diisi"<?php */?>/>
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTmptLahirIbu">
              Tempat Lahir Ibu
              <?
              $warnadata= $vTmptLahirIbu['data'];
              $warnaclass= $vTmptLahirIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text"  name="reqTmptLahirIbu" id="reqTmptLahirIbu" value="<?=$reqTmptLahirIbu?>" <?php /*?>class="required" title="Tempat lahir ibu harus diisi"<?php */?>/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqTglLahirAyah">
              Tgl Lahir Ayah
              <?
              $warnadata= $vTglLahirAyah['data'];
              $warnaclass= $vTglLahirAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" name="reqTglLahirAyah" id="reqTglLahirAyah"  value="<?=$reqTglLahirAyah?>" maxlength="10" onKeyDown="return format_date(event,'reqTglLahirAyah');"/>
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTglLahirIbu">
              Tgl Lahir Ibu
              <?
              $warnadata= $vTglLahirIbu['data'];
              $warnaclass= $vTglLahirIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" name="reqTglLahirIbu" id="reqTglLahirIbu"  value="<?=$reqTglLahirIbu?>" maxlength="10" onKeyDown="return format_date(event,'reqTglLahirIbu');"/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqPekerjaanAyah">
              Pekerjaan Ayah
              <?
              $warnadata= $vPekerjaanAyah['data'];
              $warnaclass= $vPekerjaanAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqPekerjaanAyah" name="reqPekerjaanAyah" value="<?=$reqPekerjaanAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqPekerjaanIbu">
              Pekerjaan Ibu
              <?
              $warnadata= $vPekerjaanIbu['data'];
              $warnaclass= $vPekerjaanIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqPekerjaanIbu" name="reqPekerjaanIbu" value="<?=$reqPekerjaanIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqAlamatAyah">
              Alamat Ayah
              <?
              $warnadata= $vAlamatAyah['data'];
              $warnaclass= $vAlamatAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <textarea  name = "reqAlamatAyah" class="form-control <?=$warnaclass?> materialize-textarea" id="reqAlamatAyah" value="<?=$reqAlamatAyah?>"><?=$reqAlamatAyah?></textarea>
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqAlamatIbu">
              Alamat Ibu
              <?
              $warnadata= $vAlamatIbu['data'];
              $warnaclass= $vAlamatIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <textarea name = "reqAlamatIbu" id="reqAlamatIbu" class="form-control <?=$warnaclass?> materialize-textarea" value="<?=$reqAlamatIbu?>"><?=$reqAlamatIbu?></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqPropinsiAyah">
              Propinsi Ayah
              <?
              $warnadata= $vPropinsiAyah['data'];
              $warnaclass= $vPropinsiAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqPropinsiAyahId" id="reqPropinsiAyahId" value="<?=$reqPropinsiAyahId?>" /> 
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqPropinsiAyah" data-options="validType:['sameAutoLoder[\'reqPropinsiAyah\', \'\']']" value="<?=$reqPropinsiAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqPropinsiIbu">
              Propinsi Ibu
              <?
              $warnadata= $vPropinsiIbu['data'];
              $warnaclass= $vPropinsiIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqPropinsiIbuId" id="reqPropinsiIbuId" value="<?=$reqPropinsiIbuId?>" /> 
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqPropinsiIbu" data-options="validType:['sameAutoLoder[\'reqPropinsiIbu\', \'\']']" value="<?=$reqPropinsiIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqKabupatenAyah">
              Kabupaten Ayah
              <?
              $warnadata= $vKabupatenAyah['data'];
              $warnaclass= $vKabupatenAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqKabupatenAyahId" id="reqKabupatenAyahId" value="<?=$reqKabupatenAyahId?>" />
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqKabupatenAyah" data-options="validType:['sameAutoLoder[\'reqKabupatenAyah\', \'\']']" value="<?=$reqKabupatenAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqKabupatenIbu">
              Kabupaten Ibu
              <?
              $warnadata= $vKabupatenIbu['data'];
              $warnaclass= $vKabupatenIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqKabupatenIbuId" id="reqKabupatenIbuId" value="<?=$reqKabupatenIbuId?>" />
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqKabupatenIbu" data-options="validType:['sameAutoLoder[\'reqKabupatenIbu\', \'\']']" value="<?=$reqKabupatenIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqKecamatanAyah">
              Kecamatan Ayah
              <?
              $warnadata= $vKecamatanAyah['data'];
              $warnaclass= $vKecamatanAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqKecamatanAyahId" id="reqKecamatanAyahId" value="<?=$reqKecamatanAyahId?>" />
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqKecamatanAyah" data-options="validType:['sameAutoLoder[\'reqKecamatanAyah\', \'\']']" value="<?=$reqKecamatanAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqKecamatanIbu">
              Kecamatan Ibu
              <?
              $warnadata= $vKecamatanIbu['data'];
              $warnaclass= $vKecamatanIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqKecamatanIbuId" id="reqKecamatanIbuId" value="<?=$reqKecamatanIbuId?>" /> 
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqKecamatanIbu" data-options="validType:['sameAutoLoder[\'reqKecamatanIbu\', \'\']']" value="<?=$reqKecamatanIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqDesaAyah">
              Desa Ayah
              <?
              $warnadata= $vDesaAyah['data'];
              $warnaclass= $vDesaAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqDesaAyahId" id="reqDesaAyahId" value="<?=$reqDesaAyahId?>" /> 
            <input type="text" <?=$disabled?> class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqDesaAyah" data-options="validType:['sameAutoLoder[\'reqDesaAyah\', \'\']']" value="<?=$reqDesaAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqDesaIbu">
              Desa Ibu
              <?
              $warnadata= $vDesaIbu['data'];
              $warnaclass= $vDesaIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqDesaIbuId" id="reqDesaIbuId" value="<?=$reqDesaIbuId?>" /> 
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" style="width:100%" id="reqDesaIbu" data-options="validType:['sameAutoLoder[\'reqDesaIbu\', \'\']']" value="<?=$reqDesaIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqKodePosAyah">
              Kode Pos Ayah
              <?
              $warnadata= $vKodePosAyah['data'];
              $warnaclass= $vKodePosAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqKodePosAyah" name="reqKodePosAyah" value="<?=$reqKodePosAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqKodePosIbu">
              Kode Pos Ibu
              <?
              $warnadata= $vKodePosIbu['data'];
              $warnaclass= $vKodePosIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqKodePosIbu" name="reqKodePosIbu" value="<?=$reqKodePosIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqTeleponAyah">
              Telepon Ayah
              <?
              $warnadata= $vTeleponAyah['data'];
              $warnaclass= $vTeleponAyah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqTeleponAyah" name="reqTeleponAyah" value="<?=$reqTeleponAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTeleponIbu">
              Telepon Ibu
              <?
              $warnadata= $vTeleponIbu['data'];
              $warnaclass= $vTeleponIbu['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqTeleponIbu" name="reqTeleponIbu" value="<?=$reqTeleponIbu?>" />
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
            ?>
            <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='document.location.href="app/index/<?=$linkfilenamekembali?>"' type="button">Kembali</button>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <?
            // area untuk upload file
            foreach ($arrsetriwayatfield as $key => $value)
            {
              $riwayatfield= $value["riwayatfield"];
              $riwayatfieldtipe= $value["riwayatfieldtipe"];
              $riwayatfieldinfo= $value["riwayatfieldinfo"];
              $riwayatfieldstyle= $value["riwayatfieldstyle"];
              // echo $riwayatfieldstyle;exit;
            ?>
              <button class="btn blue waves-effect waves-light" style="font-size:9pt;<?=$riwayatfieldstyle?>" type="button" id='buttonframepdf<?=$riwayatfield?>'>
                <input type="hidden" id="labelvpdf<?=$riwayatfield?>" value="<?=$riwayatfieldinfo?>" />
                <span id="labelframepdf<?=$riwayatfield?>"><?=$riwayatfieldinfo?></span>
              </button>
            <?
            }
            ?>
          </div>
        </div>

        <?
        // area untuk upload file
        foreach ($arrsetriwayatfield as $key => $value)
        {
          $riwayatfield= $value["riwayatfield"];
          $riwayatfieldtipe= $value["riwayatfieldtipe"];
          $vriwayatfieldinfo= $value["riwayatfieldinfo"];
          $riwayatfieldinfo= " - ".$vriwayatfieldinfo;
          $riwayatfieldrequired= $value["riwayatfieldrequired"];
          $riwayatfieldrequiredinfo= $value["riwayatfieldrequiredinfo"];
          $vriwayattable= $value["vriwayattable"];
          $vriwayatid= $vriwayatfield= "";
          $vpegawairowfile= $reqDokumenKategoriFileId."-".$vriwayattable."-".$vriwayatfield."-".$vriwayatid;
        ?>

        <div class="form-row">
          <div class="col-md-4 mb-4">
            <label for="reqDokumenPilih<?=$riwayatfield?>">
              File Dokumen<?=$riwayatfieldinfo?>
              <span id="riwayatfieldrequiredinfo<?=$riwayatfield?>" style="color: red;"><?=$riwayatfieldrequiredinfo?></span>
            </label>
            <input type="hidden" id="reqDokumenRequired<?=$riwayatfield?>" name="reqDokumenRequired[]" value="<?=$riwayatfieldrequired?>" />
            <input type="hidden" id="reqDokumenRequiredNama<?=$riwayatfield?>" name="reqDokumenRequiredNama[]" value="<?=$vriwayatfieldinfo?>" />
            <input type="hidden" id="reqDokumenRequiredTable<?=$riwayatfield?>" name="reqDokumenRequiredTable[]" value="<?=$vriwayattable?>" />
            <input type="hidden" id="reqDokumenRequiredTableRow<?=$riwayatfield?>" name="reqDokumenRequiredTableRow[]" value="<?=$vpegawairowfile?>" />
            <input type="hidden" id="reqDokumenFileId<?=$riwayatfield?>" name="reqDokumenFileId[]" />
            <input type="hidden" id="reqDokumenKategoriFileId<?=$riwayatfield?>" name="reqDokumenKategoriFileId[]" value="<?=$reqDokumenKategoriFileId?>" />
            <input type="hidden" id="reqDokumenKategoriField<?=$riwayatfield?>" name="reqDokumenKategoriField[]" value="<?=$riwayatfield?>" />
            <input type="hidden" id="reqDokumenPath<?=$riwayatfield?>" name="reqDokumenPath[]" value="" />
            <input type="hidden" id="reqDokumenTipe<?=$riwayatfield?>" name="reqDokumenTipe[]" value="<?=$riwayatfieldtipe?>" />

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

          <div class="col-md-4 mb-4">
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
                $arrkecualitipe= $vfpeg->kondisikategori($riwayatfieldtipe);
                if(!in_array($optionid, $arrkecualitipe))
                  continue;
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>

          <div class="col-md-4 mb-4" id="labeldokumenfileupload<?=$riwayatfield?>">
            <div class="file_input_div">
              <div class="file_input input-field col s12 m4">
                <label class="labelupload">
                  <i class="mdi-file-file-upload" style="font-family: "Roboto",sans-serif,Material-Design-Icons !important; font-size: 14px !important;">Upload</i>
                  <input id="file_input_file" name="reqLinkFile[]" class="none" type="file" />
                </label>
              </div>
              <div id="file_input_text_div" class=" input-field col s12 m8">
                <input class="file_input_text" type="text" disabled readonly id="file_input_text" />
                <label for="file_input_text"></label>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-4" id="labeldokumendarifileupload<?=$riwayatfield?>">
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

<script type="text/javascript">
  $(document).ready(function() {
    // $('select').material_select();
  });

  $('.materialize-textarea').trigger('autoresize');

</script>