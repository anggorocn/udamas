<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"pendidikan"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//

$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");

$arrpendidikan= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "pendidikan", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("PENDIDIKAN_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrpendidikan, $arrdata);
}


$arrstatusijinblajar= array(
    array("id"=>"1", "text"=> "Ijin Belajar")
    , array("id"=>"2", "text"=> "Tugas Belajar")
);

$arrtipegelar= array(
    array("id"=>"", "text"=> "Tanpa gelar")
    , array("id"=>"1", "text"=> "Depan")
    , array("id"=>"2", "text"=> "Belakang")
    , array("id"=>"3", "text"=> "Depan Belakang")
);

$arrstatuspendidikan= array(
    array("id"=>"1", "text"=> "Pendidikan CPNS")
    , array("id"=>"2", "text"=> "Diakui")
    , array("id"=>"3", "text"=> "Belum Diakui")
    , array("id"=>"4", "text"=> "Riwayat")
);

// pakem data validasi
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pendidikan_riwayat_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("PENDIDIKAN_RIWAYAT_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
// $reqRowId= $set->getField('PENDIDIKAN_RIWAYAT_ID');

$reqNamaSekolah= $set->getField('NAMA'); $vNamaSekolah= checkwarna($reqPerubahanData, 'NAMA');

$reqNamaFakultas= $set->getField('NAMA_FAKULTAS');

$reqPendidikanId= $set->getField('PENDIDIKAN_ID');

$reqPendidikan= $set->getField('PENDIDIKAN_NAMA');

$reqTglSttb= dateToPageCheck($set->getField('TANGGAL_STTB')); $vTglSttb= checkwarna($reqPerubahanData, 'TANGGAL_STTB', [date]);

$reqJurusan= $set->getField('JURUSAN'); $vJurusan= checkwarna($reqPerubahanData, 'JURUSAN');

$reqJurusanId= $set->getField('PENDIDIKAN_JURUSAN_ID');

$reqAlamatSekolah= $set->getField('TEMPAT');

$reqKepalaSekolah= $set->getField('KEPALA'); $vJurusan= checkwarna($reqPerubahanData, 'JURUSAN');

$reqNoSttb= $set->getField('NO_STTB'); $vNoSttb= checkwarna($reqPerubahanData, 'NO_STTB');

// $reqPegawaiId= $set->getField('PEGAWAI_ID');

$reqStatus= $set->getField('STATUS');

$reqStatusTugasIjinBelajar= $set->getField('STATUS_TUGAS_IJIN_BELAJAR');

$reqStatusPendidikan= $set->getField('STATUS_PENDIDIKAN');

$reqStatusPendidikanNama= $set->getField('STATUS_PENDIDIKAN_NAMA');

$reqNoSuratIjin= $set->getField('NO_SURAT_IJIN'); $vNoSuratIjin= checkwarna($reqPerubahanData, 'NO_SURAT_IJIN');

$reqTglSuratIjin= dateToPageCheck($set->getField('TANGGAL_SURAT_IJIN')); $vTglSuratIjin= checkwarna($reqPerubahanData, 'TANGGAL_SURAT_IJIN', [date]);

$reqGelarTipe= $set->getField('GELAR_TIPE');

$reqGelarNamaDepan= $set->getField('GELAR_DEPAN'); $vGelarNamaDepan= checkwarna($reqPerubahanData, 'GELAR_DEPAN');

$reqGelarNama= $set->getField('GELAR_NAMA'); $vGelarNama= checkwarna($reqPerubahanData, 'GELAR_NAMA');

$reqPppkStatus= $set->getField('PPPK_STATUS');

$reqSkDasarPengakuan= $set->getField('STATUS_SK_DASAR_PENGAKUAN');

$reqCantumGelarTgl= dateToPageCheck($set->getField('CANTUM_GELAR_TANGGAL')); $vCantumGelarTgl= checkwarna($reqPerubahanData, 'CANTUM_GELAR_TANGGAL', [date]);

$reqCantumGelarNoSk= $set->getField('CANTUM_GELAR_NO_SK'); $vCantumGelarNoSk= checkwarna($reqPerubahanData, 'CANTUM_GELAR_NO_SK');

$reqDasarPangkatRiwayatId= $set->getField('DASAR_PANGKAT_RIWAYAT_ID');

$reqNilaiKualifikasi= $set->getField('NILAI_REKAM_JEJAK'); $vNilaiKualifikasi= checkwarna($reqPerubahanData, 'NILAI_REKAM_JEJAK');

$reqRumpunJabatan= $set->getField('RUMPUN_ID');


// $reqRumpunJabatanNama= "";
// if(!empty($reqRumpunJabatan))
// {
//   $setdetil= new Rumpun();
//   $setdetil->selectByParams(array(), -1,-1, " AND A.RUMPUN_ID IN (".$reqRumpunJabatan.")");
//   while($setdetil->nextRow())
//   {
//     if(empty($reqRumpunJabatanNama))
//       $reqRumpunJabatanNama= $setdetil->getField("KETERANGAN");
//     else
//       $reqRumpunJabatanNama.= ", ".$setdetil->getField("KETERANGAN");
//   }
// }

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

  $('input[id^="reqxPendidikan"], input[id^="reqJurusan"]').autocomplete({
    source:function(request, response){
      var id= this.element.attr('id');
      var replaceAnakId= replaceAnak= urlAjax= "";

      if (id.indexOf('reqJurusan') !== -1)
      {
        var reqPendidikanId= "";
        reqPendidikanId= $("#reqPendidikanId").val();
        var element= id.split('reqJurusan');
        var indexId= "reqJurusanId"+element[1];
        urlAjax= "pendidikan_jurusan_json/combo?reqId="+reqPendidikanId;
      }
      else if (id.indexOf('reqPendidikan') !== -1)
      {
        var element= id.split('reqPendidikan');
        var indexId= "reqPendidikanId"+element[1];
        urlAjax= "pendidikan_riwayat_json/auto";
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
              return {desc: element['desc'], id: element['id'], label: element['label'], statusht: element['statusht'], nilai_rumpun: element['nilai_rumpun'], rumpun_id: element['rumpun_id'], rumpun_nama: element['rumpun_nama']};
            });
            response(array);
          }
        }
      })
    },
    focus: function (event, ui) 
    { 
      var id= $(this).attr('id');
      if (id.indexOf('reqJurusan') !== -1)
      {
        var element= id.split('reqJurusan');
        var indexId= "reqJurusanId"+element[1];

        $("#reqRumpunJabatan").val(ui.item.rumpun_id).trigger('change');
        $("#reqRumpunJabatanNama").val(ui.item.rumpun_nama).trigger('change');
      }
      else if (id.indexOf('reqPendidikan') !== -1)
      {
        var element= id.split('reqPendidikan');
        var indexId= "reqPendidikanId"+element[1];

        vnilairumpun= ui.item.nilai_rumpun;

        if(parseFloat(vnilairumpun) >= 0)
        {
          $("#labelrumpunset").show();
        }
        else
        {
          $("#labelrumpunset").hide();
        }
        $("#reqNilaiKualifikasi, #reqNilaiKualifikasiText").val(vnilairumpun);
      }

      var statusht= "";
        //statusht= ui.item.statusht;
        $("#"+indexId).val(ui.item.id).trigger('change');
      },
      //minLength:3,
      autoFocus: true
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
    //
    return $( "<li>" )
    .append( "<a>" + item.desc + "</a>" )
    .appendTo( ul );
  };

  setGelarTipe();
  $('#reqGelarTipe').bind('change', function(ev) {
    setGelarTipe();
  });

  $("#reqPendidikanId").change(function(){
    $("#reqJurusan, #reqJurusanId").val("");

    var reqPendidikanId= $("#reqPendidikanId").val();
    reqNilaiKualifikasiText= 0;
    infoid= reqPendidikanId;
    valarrpendidikan= getarrpendidikan.filter(item => item.ID === infoid);
    // console.log(valarrpendidikan);
    if(Array.isArray(valarrpendidikan) && valarrpendidikan.length)
    {
      reqNilaiKualifikasiText= valarrpendidikan[0]["nilai_rumpun"];
    }
    $("#reqNilaiKualifikasi, #reqNilaiKualifikasiText").val(reqNilaiKualifikasiText);

  });

});

function setGelarTipe()
{
  var reqGelarTipe= "";
  reqGelarTipe= $("#reqGelarTipe").val();
  $("#reqInfoNamaGelarDepan,#reqInfoNamaGelarBelakang").hide();

  // $('#reqGelarNamaDepan,#reqGelarNama').validatebox({required: false});
  $('#reqGelarNamaDepan,#reqGelarNama').removeClass('validatebox-invalid');

  if(reqGelarTipe == "")
  {
    $("#reqGelarNamaDepan,#reqGelarNama").val("");
  }
  else if(reqGelarTipe == "1")
  {
    $("#reqInfoNamaGelarDepan").show();
    $("#reqGelarNama").val("");
    // $('#reqGelarNamaDepan').validatebox({required: true});
  }
  else if(reqGelarTipe == "2")
  {
    $("#reqInfoNamaGelarBelakang").show();
    $("#reqGelarNamaDepan").val("");
    // $('#reqGelarNama').validatebox({required: true});
  }
  else
  {
    $("#reqInfoNamaGelarDepan,#reqInfoNamaGelarBelakang").show();
    // $('#reqGelarNamaDepan,#reqGelarNama').validatebox({required: true});
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

      <form class="needs-validation" id="ff" method="post" novalidate enctype="multipart/form-data">
        
        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqStatusPendidikan">
              Status Pendidikan
              <?
              $warnadata= $vStatusPendidikan['data'];
              $warnaclass= $vStatusPendidikan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <?
            if($tempKondisiCpns == "1" && $reqStatusPendidikan == "1")
            {
            ?>
              <select class="form-control <?=$warnaclass?>" name="reqStatusPendidikan" id="reqStatusPendidikan" <?=$disabled?>>
                <option value="1" <? if($reqStatusPendidikan == 1) echo 'selected'?>>Pendidikan CPNS</option>
                <option value="2" <? if($reqStatusPendidikan == 2) echo 'selected'?>>Diakui</option>
                <option value="3" <? if($reqStatusPendidikan == 3) echo 'selected'?>>Belum Diakui</option>
                <option value="4" <? if($reqStatusPendidikan == 4) echo 'selected'?>>Riwayat</option>
              </select>
            <?
            }
            elseif($tempKondisiCpns == "1")
            {
            ?>
              <select class="form-control <?=$warnaclass?>" name="reqStatusPendidikan" id="reqStatusPendidikan" <?=$disabled?>>
                <option value="2" <? if($reqStatusPendidikan == 2) echo 'selected'?>>Diakui</option>
                <option value="3" <? if($reqStatusPendidikan == 3) echo 'selected'?>>Belum Diakui</option>
                <option value="4" <? if($reqStatusPendidikan == 4) echo 'selected'?>>Riwayat</option>
              </select>
            <?
            }
            else
            {
              ?>
              <select class="form-control <?=$warnaclass?>" name="reqStatusPendidikan" id="reqStatusPendidikan" <?=$disabled?>>
                <option value="1" <? if($reqStatusPendidikan == 1) echo 'selected'?>>Pendidikan CPNS</option>
                <option value="2" <? if($reqStatusPendidikan == 2) echo 'selected'?>>Diakui</option>
                <option value="3" <? if($reqStatusPendidikan == 3) echo 'selected'?>>Belum Diakui</option>
                <option value="4" <? if($reqStatusPendidikan == 4) echo 'selected'?>>Riwayat</option>
              </select>
            <?
            }
            ?>
          </div>

          <div class="col-md-3 mb-3" id="labelpppkstatus">
            <label for="reqPppkStatus">Sebagai Ijazah PPPK</label>
            <input type="checkbox" id="reqPppkStatus" name="reqPppkStatus" value="1" <? if($reqPppkStatus == 1) echo 'checked'?>/>
          </div>

          <div class="col-md-3 mb-3" id="labelskdasarpengakuan">
            <label for="reqSkDasarPengakuan">
              SK Dasar Jabatan
              <?
              $warnadata= $vSkDasarPengakuan['data'];
              $warnaclass= $vSkDasarPengakuan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" id="reqSkDasarPengakuan" name="reqSkDasarPengakuan" >
              <option value=""></option>
            </select>
          </div>

          <div class="col-md-3 mb-3" id="labeldasarpangkatriwayatid">
            <label for="reqDasarPangkatRiwayatId">
              Mulai Golongan
              <?
              $warnadata= $vDasarPangkatRiwayatId['data'];
              $warnaclass= $vDasarPangkatRiwayatId['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" id="reqDasarPangkatRiwayatId" name="reqDasarPangkatRiwayatId" >
              <option value=""></option>
            </select>
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row" id="labeltugasbelajar">
          <div class="col-md-6 mb-6">
            <label for="reqNoSuratIjin">
              No. Surat Ijin / Tugas Belajar
              <?
              $warnadata= $vNoSuratIjin['data'];
              $warnaclass= $vNoSuratIjin['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" id="reqNoSuratIjin" name="reqNoSuratIjin" <?=$read?> value="<?=$reqNoSuratIjin?>"  />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTglSuratIjin">
              Tgl. Surat Ijin / Tugas Belajar
              <?
              $warnadata= $vTglSuratIjin['data'];
              $warnaclass= $vTglSuratIjin['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSuratIjin" id="reqTglSuratIjin" value="<?=$reqTglSuratIjin?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSuratIjin');" />
          </div>
        </div>

        <div class="form-row" id="labelpencantumangelar">
          <div class="col-md-6 mb-6">
            <label for="reqCantumGelarNoSk">
              No SK Pencatuman Gelar
              <?
              $warnadata= $vTglSuratIjin['data'];
              $warnaclass= $vTglSuratIjin['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" id="reqCantumGelarNoSk" name="reqCantumGelarNoSk" value="<?=$reqCantumGelarNoSk?>" />
          </div>
          <div class="col-md-6 mb-6">
            <label for="reqCantumGelarTgl">
              Tgl. SK Pencatuman Gelar
              <?
              $warnadata= $vCantumGelarTgl['data'];
              $warnaclass= $vCantumGelarTgl['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqCantumGelarTgl" id="reqCantumGelarTgl" value="<?=$reqCantumGelarTgl?>" maxlength="10" onKeyDown="return format_date(event,'reqCantumGelarTgl');" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqNoSttb">
              No. Ijazah
              <?
              $warnadata= $vNoSttb['data'];
              $warnaclass= $vNoSttb['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" class="easyui-validatebox" required id="reqNoSttb" name="reqNoSttb" <?=$read?> value="<?=$reqNoSttb?>" />
          </div>
          <div class="col-md-6 mb-6">
            <label for="reqTglSttb">
              Tgl. Kelulusan
              <?
              $warnadata= $vTglSttb['data'];
              $warnaclass= $vTglSttb['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder required class="easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSttb" id="reqTglSttb" value="<?=$reqTglSttb?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSttb');"/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqPendidikanId">
              Pendidikan
              <?
              $warnadata= $vPendidikanId['data'];
              $warnaclass= $vPendidikanId['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select <?=$disabled?> class="form-control <?=$warnaclass?>" name="reqPendidikanId" id="reqPendidikanId">
              <option value=""></option>
              <?
              foreach ($arrpendidikan as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";

                // if($optionid == 4)
                //   continue;

                if($reqPendidikanId == $optionid)
                  $optionselected= "selected";
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>
          <div class="col-md-6 mb-6">
            <label for="reqJurusan">
              Jurusan
              <?
              $warnadata= $vJurusan['data'];
              $warnaclass= $vJurusan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqJurusanId" id="reqJurusanId" value="<?=$reqJurusanId?>" /> 
            <input class="form-control <?=$warnaclass?>" placeholder type="text" name="reqJurusan" id="reqJurusan" value="<?=$reqJurusan?>" title="Jurusan harus diisi" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqNilaiKualifikasi">
              Nilai Kualifikasi Pendidikan
              <?
              $warnadata= $vNilaiKualifikasi['data'];
              $warnaclass= $vNilaiKualifikasi['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqNilaiKualifikasi" id="reqNilaiKualifikasi" value="<?=$reqNilaiKualifikasi?>" /> 
            <input class="form-control <?=$warnaclass?>" placeholder disabled type="text" id="reqNilaiKualifikasiText" value="<?=$reqNilaiKualifikasi?>" />
          </div>
        </div>

        <div class="form-row">
          <?
          // if($reqStatus == "3")
          // {
          ?>
          
        <!--   <div class="col-md-3 mb-3" style="">
            <label for="reqStatusTugasIjinBelajar">
              Status
              <?
              $warnadata= $vStatusTugasIjinBelajar['data'];
              $warnaclass= $vStatusTugasIjinBelajar['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" name="reqStatusTugasIjinBelajar" id="reqStatusTugasIjinBelajar">
              <option value=""></option>
              <?
              foreach ($arrstatusijinblajar as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";

                // if($optionid == 4)
                //   continue;

                if($reqStatusTugasIjinBelajar == $optionid)
                  $optionselected= "selected";
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div> -->
          <?
          // }
          ?>
          <div class="col-md-3 mb-3">
            <label for="reqGelarTipe">
              Tipe Gelar
              <?
              $warnadata= $vGelarTipe['data'];
              $warnaclass= $vGelarTipe['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" name="reqGelarTipe" id="reqGelarTipe" <?=$disabled?>>
              <?
              foreach ($arrtipegelar as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";

                // if($optionid == 4)
                //   continue;

                if($reqGelarTipe == $optionid)
                  $optionselected= "selected";
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>
          <div class="col-md-3 mb-3" id="reqInfoNamaGelarDepan">
            <label for="reqGelarNamaDepan">
              Gelar Depan
              <?
              $warnadata= $vGelarNamaDepan['data'];
              $warnaclass= $vGelarNamaDepan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" class="easyui-validatebox" name="reqGelarNamaDepan" id="reqGelarNamaDepan" <?=$read?> value="<?=$reqGelarNamaDepan?>"/>
          </div>
          <div class="col-md-3 mb-3" id="reqInfoNamaGelarBelakang">
            <label for="reqGelarNama">
              Gelar Belakang
              <?
              $warnadata= $vGelarNama['data'];
              $warnaclass= $vGelarNama['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" class="easyui-validatebox" name="reqGelarNama" id="reqGelarNama" <?=$read?> value="<?=$reqGelarNama?>"/>
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqNamaSekolah">
              Nama Sekolah / PT
              <?
              $warnadata= $vNamaSekolah['data'];
              $warnaclass= $vNamaSekolah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" class="easyui-validatebox" required id="reqNamaSekolah" name="reqNamaSekolah" <?=$read?> value="<?=$reqNamaSekolah?>" title="Nama sekolah harus diisi" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqKepalaSekolah">
              Kepala Sekolah / PT
              <?
              $warnadata= $vKepalaSekolah['data'];
              $warnaclass= $vKepalaSekolah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" class="easyui-validatebox" required id="reqKepalaSekolah" name="reqKepalaSekolah" <?=$read?> value="<?=$reqKepalaSekolah?>" />
          </div>
          <div class="col-md-3 mb-3">
            <label for="reqAlamatSekolah">
              Kota Sekolah / PT
              <?
              $warnadata= $vAlamatSekolah['data'];
              $warnaclass= $vAlamatSekolah['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder type="text" class="easyui-validatebox" id="reqAlamatSekolah" name="reqAlamatSekolah" <?=$read?> value="<?=$reqAlamatSekolah?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12" id="labelrumpunset">
            <label for="reqRumpunJabatanNama">
              Rumpun Kualifikasi
              <?
              $warnadata= $vRumpunJabatanNama['data'];
              $warnaclass= $vRumpunJabatanNama['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqRumpunJabatan" id="reqRumpunJabatan" value="<?=$reqRumpunJabatan?>" />
            <input placeholder="" type="text" disabled class="form-control <?=$warnaclass?> easyui-validatebox" id="reqRumpunJabatanNama" value="<?=$reqRumpunJabatanNama?>" />
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
  // ambil rating penggalian
  getarrinfonilairumpun= JSON.parse('<?=JSON_encode($arrinfonilairumpun)?>');
  getarrpangkatriwayat= JSON.parse('<?=JSON_encode($arrpangkatriwayat)?>');

  $(document).ready(function() {
    // $('select').material_select();

    setstatuspendidikan("");
    $("#reqStatusPendidikan").change(function(){
      setstatuspendidikan("data");
    });

    setskdasarpengakuan("");
    $("#reqSkDasarPengakuan").change(function(){
      setskdasarpengakuan("data");
    });

    $('#reqCantumGelarTgl').keyup(function() {
      var vtanggalakhir= $('#reqCantumGelarTgl').val();
      var vtanggalawal= $('#reqTglSttb').val();
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
           $('#reqCantumGelarTgl').val(vtanggalawal);
        }
      }

    });

  });

  function setstatuspendidikan(infomode)
  {
    reqStatusPendidikan= $("#reqStatusPendidikan").val();

    // khusus status cpns, maka muncul
    if(infomode == "")
      vinfodata= "<?=$reqPppkStatus?>";
    else
      vinfodata= $("#reqPppkStatus").val();

    $("#labelpppkstatus").hide();
    $("#reqPppkStatus").prop('checked', false);
    if(reqStatusPendidikan == "1")
    {
      if(vinfodata == "1")
      {
        $("#reqPppkStatus").prop('checked', true);
      }

      $("#labelpppkstatus").show();
    }

    // setting untuk sk dasar pengakuan
    if(infomode == "")
      vinfodata= "<?=$reqSkDasarPengakuan?>";
    else
      vinfodata= $("#reqSkDasarPengakuan").val();

    vlabelid= "reqSkDasarPengakuan";
    $("#"+vlabelid+" option").remove();
    // $("#"+vlabelid).material_select();

    var voption= "<option value=''></option>";
    if(reqStatusPendidikan == "1" || reqStatusPendidikan == "2")
    {
      if(Array.isArray(getarrinfonilairumpun) && getarrinfonilairumpun.length)
      {
        $.each(getarrinfonilairumpun, function( index, value ) {
          // console.log( index + ": " + value["id"] );
          infoid= value["id"];
          infotext= value["text"];
          setoption= "";

          if(reqStatusPendidikan == "1")
          {
            if(infoid == "1")
            {
              setoption= "1";
            }
          }
          else if(reqStatusPendidikan == "2")
          {
            if(infoid == "1"){}
            else
            {
              setoption= "1";
            }
          }

          if(setoption == "1")
          {
            vselected= "";
            if(infoid == vinfodata)
            {
              vselected= "selected";
            }

            voption+= "<option value='"+infoid+"' "+vselected+" >"+infotext+"</option>";
          }
        });
      }
    }
    $("#"+vlabelid).html(voption);
    // $("#"+vlabelid).material_select();

    $("#labelskdasarpengakuan").hide();
    if(reqStatusPendidikan == "1" || reqStatusPendidikan == "2")
    {
      $("#labelskdasarpengakuan").show();
    }

    setskdasarpengakuan("data");
  }

  function setskdasarpengakuan(infomode)
  {
    reqSkDasarPengakuan= $("#reqSkDasarPengakuan").val();

    // setting untuk sk dasar pengakuan
    if(infomode == "")
      vinfodata= "<?=$reqDasarPangkatRiwayatId?>";
    else
      vinfodata= $("#reqDasarPangkatRiwayatId").val();

    vlabelid= "reqDasarPangkatRiwayatId";
    $("#"+vlabelid+" option").remove();
    // $("#"+vlabelid).material_select();

    var voption= "<option value=''></option>";
    if(reqSkDasarPengakuan == "2")
    {
      if(Array.isArray(getarrpangkatriwayat) && getarrpangkatriwayat.length)
      {
        $.each(getarrpangkatriwayat, function( index, value ) {
          // console.log( index + ": " + value["id"] );
          infoid= value["id"];
          infotext= value["text"];
          setoption= "1";

          if(setoption == "1")
          {
            vselected= "";
            if(infoid == vinfodata)
            {
              vselected= "selected";
            }

            voption+= "<option value='"+infoid+"' "+vselected+" >"+infotext+"</option>";
          }
        });
      }
    }
    $("#"+vlabelid).html(voption);
    // $("#"+vlabelid).material_select();

    $("#labeldasarpangkatriwayatid").hide();
    $("#labelpencantumangelar, #labeltugasbelajar").show();
    if(reqSkDasarPengakuan == "1") // kalau sk cpns / pns
    {
      $("#labelpencantumangelar, #labeltugasbelajar").hide();
    }
    else if(reqSkDasarPengakuan == "2") // kalau kenaikan pangkat
    {
      $("#labeldasarpangkatriwayatid").show();
      $("#labelpencantumangelar").hide();
    }
    else if(reqSkDasarPengakuan == "3") // kalau sk pencatuman gelar
    {
      $("#labelpencantumangelar").show();
    }
    else
    {
      $("#labelpencantumangelar").hide();
    }
    // labelpencantumangelar;reqNoSuratIjin;reqTglSuratIjin;labeltugasbelajar;reqCantumGelarNoSk;reqCantumGelarTgl

  }

  $('.materialize-textarea').trigger('autoresize');

  // untuk area untuk upload file
  vbase_url= "<?=base_url()?>";
  getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
  // console.log(getarrlistpilihfilefield);

  // apabila butuh kualitas dokumen di ubah
  vselectmaterial= "1";
  // untuk area untuk upload file

</script>