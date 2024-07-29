<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"suami_istri"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//

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
$reqPendidikanId= $set->getField("PENDIDIKAN_ID");

$reqNama= $set->getField("NAMA");

$reqTempatLahir= $set->getField("TEMPAT_LAHIR");

$reqTanggalLahir= dateToPageCheck($set->getField("TANGGAL_LAHIR")); $vTanggalLahir= checkwarna($reqPerubahanData, 'TANGGAL_LAHIR', [date]);

$reqTanggalKawin= dateToPageCheck($set->getField("TANGGAL_KAWIN")); $vTanggalKawin= checkwarna($reqPerubahanData, 'TANGGAL_KAWIN', [date]);

$reqKartu= $set->getField("KARTU");

$reqStatusPns= $set->getField("STATUS_PNS");

$reqNipPns= $set->getField("NIP_PNS");

$reqPekerjaan= $set->getField("PEKERJAAN");

$reqStatusTunjangan= $set->getField("STATUS_TUNJANGAN");

$reqStatusBayar= $set->getField("STATUS_BAYAR");

$reqBulanBayar= $set->getField("BULAN_BAYAR");

$reqStatusSi= $set->getField("STATUS_S_I");

$reqSuratKawin= $set->getField("SURAT_NIKAH");

$reqNik= $set->getField("NIK");

$reqCeraiSurat= $set->getField("CERAI_SURAT");

$reqCeraiTanggal= dateToPageCheck($set->getField("CERAI_TANGGAL")); $vCeraiTanggal= checkwarna($reqPerubahanData, 'CERAI_TANGGAL', [date]);

$reqCeraiTmt= dateToPageCheck($set->getField("CERAI_TMT")); $vCeraiTmt= checkwarna($reqPerubahanData, 'CERAI_TMT', [date]);

$reqKematianSurat= $set->getField("KEMATIAN_SURAT");

$reqKematianTanggal= dateToPageCheck($set->getField("KEMATIAN_TANGGAL")); $vKematianTanggal= checkwarna($reqPerubahanData, 'KEMATIAN_TANGGAL', [date]);

$reqKematianTmt= dateToPageCheck($set->getField("KEMATIAN_TMT")); $vKematianTmt= checkwarna($reqPerubahanData, 'KEMATIAN_TMT', [date]);

$reqStatusHidup= $set->getField('STATUS_AKTIF');

$reqStatusBekerja= $set->getField('STATUS_BEKERJA');

$reqJenisKelamin= $set->getField('JENIS_KELAMIN');

// $reqNoInduk= $set->getField('NOMOR_INDUK');
$reqNoInduk= $set->getField("NIK");

$reqTanggalMeninggal= dateToPageCheck($set->getField('TANGGAL_MENINGGAL')); $vTanggalMeninggal= checkwarna($reqPerubahanData, 'TANGGAL_MENINGGAL', [date]);

$reqAktaKelahiran= $set->getField('AKTA_KELAHIRAN');

$reqJenisIdDokumen= $set->getField('JENIS_ID_DOKUMEN');

$reqAgamaId= $set->getField('AGAMA_ID');

$reqEmail= $set->getField('EMAIL');

$reqHp= $set->getField('HP');

$reqTelepon= $set->getField('TELEPON');

$reqAlamat= $set->getField('ALAMAT');

$reqBpjsNo= $set->getField('BPJS_NO');

$reqBpjsTanggal= dateToPageCheck($set->getField('BPJS_TANGGAL')); $vBpjsTanggal= checkwarna($reqPerubahanData, 'BPJS_TANGGAL', [date]);

$reqNpwpNo= $set->getField('NPWP_NO');

$reqNpwpTanggal= dateToPageCheck($set->getField('NPWP_TANGGAL')); $vNpwpTanggal= checkwarna($reqPerubahanData, 'NPWP_TANGGAL', [date]);

$reqStatusLulus= $set->getField('STATUS_LULUS');

$reqKematianNo= $set->getField('KEMATIAN_NO');

$reqKematianTanggal= dateToPageCheck($set->getField('KEMATIAN_TANGGAL')); $vKematianTanggal= checkwarna($reqPerubahanData, 'KEMATIAN_TANGGAL', [date]);

$reqJenisKawinId= $set->getField('JENIS_KAWIN_ID');

$reqAktaNikahNo= $set->getField('AKTA_NIKAH_NO');

$reqAktaNikahTanggal= dateToPageCheck($set->getField('AKTA_NIKAH_TANGGAL')); $vAktaNikahTanggal= checkwarna($reqPerubahanData, 'AKTA_NIKAH_TANGGAL', [date]);

$reqNikahTanggal= dateToPageCheck($set->getField('NIKAH_TANGGAL')); $vNikahTanggal= checkwarna($reqPerubahanData, 'NIKAH_TANGGAL', [date]);

$reqAktaCeraiNo= $set->getField('AKTA_CERAI_NO');

$reqAktaCeraiTanggal= dateToPageCheck($set->getField('AKTA_CERAI_TANGGAL')); $vAktaCeraiTanggal= checkwarna($reqPerubahanData, 'AKTA_CERAI_TANGGAL', [date]);

$reqCeraiTanggal= dateToPageCheck($set->getField('CERAI_TANGGAL')); $vCeraiTanggal= checkwarna($reqPerubahanData, 'CERAI_TANGGAL', [date]);

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

  // $("#reqsimpan").click(function() { 
  //   if($("#ff").form('validate') == false){
  //     return false;
  //   }

  //   var reqStatusHidup= reqStatusSi= reqRowId= reqTanggalKawin= "";
  //   reqStatusHidup= $("#reqStatusHidup").val();
  //   reqStatusSi= $("#reqStatusSi").val();
  //   reqRowId= $("#reqRowId").val();
  //   reqTanggalKawin= $("#reqTanggalKawin").val();

  //   if(reqStatusHidup == "")
  //   {
  //     mbox.alert('Data tidak bisa disimpan, karena Status Hidup belum diisi.', {open_speed: 0});
  //     return false;
  //   }

  //   if(reqStatusSi == "")
  //   {
  //     mbox.alert('Data tidak bisa disimpan, karena Status Pernikahan belum diisi.', {open_speed: 0});
  //     return false;
  //   }

  //   // if(reqStatusSi == "1")
  //   // {
  //     var s_url= "suami_istri_json/checkData?reqId=<?=$reqId?>&reqRowId="+reqRowId+"&reqStatusHidup="+reqStatusHidup+"&reqStatusSi="+reqStatusSi+"&reqTanggalKawin="+reqTanggalKawin;
  //     $.ajax({'url': s_url,'success': function(dataajax){
  //       // console.log(dataajax);return false;

  //       var tempStatusNikah= "";
  //       dataajax= String(dataajax);
  //       var element = dataajax.split('-'); 
  //       dataajax= element[0];
  //       tempStatusNikah= element[1];

  //       if(tempStatusNikah == "1")
  //       {
  //         mbox.alert('Data tidak bisa disimpan, karena ada data dengan status nikah lainnya', {open_speed: 0});
  //         return false;
  //       }

  //       if(dataajax == '1')
  //       {
  //         mbox.alert('Data tidak bisa disimpan, karena tanggal yang anda tulis lebih kecil dari pernikahan terakhir', {open_speed: 0});
  //         return false;
  //       }
  //       else
  //         $("#reqSubmit").click();
  //     }});
  //   // }
  //   // else
  //   // {
  //   //   $("#reqSubmit").click();
  //   // }
  // });

  // $('#ff').form({
  //   url:'suami_istri_json/add',
  //   onSubmit:function(){
  //     reqValidasiNoInduk= $("#reqValidasiNoInduk").val();
  //     if(reqValidasiNoInduk == ""){}
  //     else
  //     {
  //       mbox.alert(reqValidasiNoInduk, {open_speed: 0});
  //       return false;
  //     }

  //     if($(this).form('validate')){}
  //     else
  //     {
  //       $.messager.alert('Info', "Lengkapi data terlebih dahulu", 'info');
  //       return false;
  //     }
  //   },
  //   success:function(data){
  //     // console.log(data);return false;
  //     data = data.split("-");
  //     rowid= data[0];
  //     infodata= data[1];

  //     if(rowid == "xxx")
  //     {
  //       mbox.alert(infodata, {open_speed: 0});
  //     }
  //     else
  //     {
  //       mbox.alert(infodata, {open_speed: 500}, interval = window.setInterval(function() 
  //       {
  //        clearInterval(interval);
  //        mbox.close();

  //        <?
  //        if(!empty($pelayananid))
  //        {
  //        ?>
  //        vkembali= "app/loadUrl/app/pegawai_add_suami_istri_data?reqId=<?=$reqId?>&reqRowId="+rowid+"&pelayananid=<?=$pelayananid?>&pelayananjenis=<?=$pelayananjenis?>&pelayananrowid=<?=$pelayananrowid?>&pelayanankembali=<?=$pelayanankembali?>";
  //        <?
  //        }
  //        else
  //        {
  //        ?>
  //        vkembali= "app/loadUrl/app/pegawai_add_suami_istri_data?reqId=<?=$reqId?>&reqRowId="+rowid;
  //        <?
  //        }
  //        ?>
  //        document.location.href= vkembali;
         
  //       }, 1000));
  //       $(".mbox > .right-align").css({"display": "none"});
  //     }

  //   }
  // });

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
          <div class="col-md-4 mb-4">
            <label for="reqInfoFoto">Foto Suami/Istri</label>
            <?
            if($tempPath == "")
            {
              $tempPath= "images/foto-profile.jpg";
            }
            ?>
            <br/><br/>
            <img id="infoimage" src="<?=base_url().$tempPath?>" style="width:inherit; height: 150px" id="reqInfoFoto" />
          </div>

          <div class="col-md-8 mb-8">
            <div class="form-row">
              <div class="col-md-6 mb-6">
                <label for="reqNama">
                  Nama Suami/Istri
                  <?
                  $warnadata= $vNama['data'];
                  $warnaclass= $vNama['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required id="reqNama" name="reqNama" <?=$read?> value="<?=$reqNama?>" title="Nama harus diisi" />
              </div>

              <div class="col-md-3 mb-3">
                <label for="reqGelarDepan">
                  Gelar Depan
                  <?
                  $warnadata= $vGelarDepan['data'];
                  $warnaclass= $vGelarDepan['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" name="reqGelarDepan" id="reqGelarDepan" value="<?=$reqGelarDepan?>" />
              </div>

              <div class="col-md-3 mb-3">
                <label for="reqGelarBelakang">
                  Gelar Belakang
                  <?
                  $warnadata= $vGelarBelakang['data'];
                  $warnaclass= $vGelarBelakang['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input type="text" placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox" id="reqGelarBelakang" name="reqGelarBelakang" <?=$read?> value="<?=$reqGelarBelakang?>" />
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-5 mb-5">
                <label for="reqTempatLahir">
                  Tempat Lahir
                  <?
                  $warnadata= $vTempatLahir['data'];
                  $warnaclass= $vTempatLahir['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" id="reqTempatLahir" required name="reqTempatLahir" <?=$read?> value="<?=$reqTempatLahir?>" />
              </div>

              <div class="col-md-3 mb-3">
                <label class="active" for="reqTanggalLahir">
                  Tgl. Lahir
                  <?
                  $warnadata= $vTanggalLahir['data'];
                  $warnaclass= $vTanggalLahir['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <table>
                  <tr> 
                    <td style="padding: 0px;">
                      <input placeholder="" required class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTanggalLahir" id="reqTanggalLahir" value="<?=$reqTanggalLahir?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalLahir');" />
                    </td>
                    <td style="padding: 0px;">
                      <label class="input-group-btn" for="reqTanggalLahir" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                        <span class="mdi-notification-event-note"></span>
                      </label>
                    </td>
                  </tr>
                </table>
              </div>

              <div class="col-md-4 mb-4">
                <label for="reqAktaKelahiran">
                  Akta Kelahiran
                  <?
                  $warnadata= $vAktaKelahiran['data'];
                  $warnaclass= $vAktaKelahiran['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input type="text"  placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox" id="reqAktaKelahiran" name="reqAktaKelahiran" <?=$read?> value="<?=$reqAktaKelahiran?>" />
              </div>
            </div>

            <div class="clearfix"></div><br/>

            <div class="form-row">
              <div class="col-md-5 mb-5">
                <label for="reqSuratKawin">
                  Surat nikah
                  <?
                  $warnadata= $vSuratKawin['data'];
                  $warnaclass= $vSuratKawin['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input id="reqSuratKawin" placeholder=""  type="text" name="reqSuratKawin" class="form-control <?=$warnaclass?> easyui-validatebox" required <?=$disabled?>  value="<?=$reqSuratKawin?>" />
              </div>

              <div class="col-md-3 mb-3">
                <label class="active" for="reqTanggalKawin">
                  Tgl. nikah
                  <?
                  $warnadata= $vTanggalKawin['data'];
                  $warnaclass= $vTanggalKawin['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <table>
                  <tr> 
                    <td style="padding: 0px;">
                      <input placeholder="" required class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTanggalKawin" id="reqTanggalKawin" value="<?=$reqTanggalKawin?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalKawin');" />
                    </td>
                    <td style="padding: 0px;">
                      <label class="input-group-btn" for="reqTanggalKawin" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                        <span class="mdi-notification-event-note"></span>
                      </label>
                    </td>
                  </tr>
                </table>
              </div>

              <div class="col-md-3 mb-3">
                <label class="active" for="reqAktaNikahTanggal">
                  Tgl Akta Nikah
                  <?
                  $warnadata= $vAktaNikahTanggal['data'];
                  $warnaclass= $vAktaNikahTanggal['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <table>
                  <tr> 
                    <td style="padding: 0px;">
                      <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqAktaNikahTanggal" id="reqAktaNikahTanggal" value="<?=$reqAktaNikahTanggal?>" maxlength="10" onKeyDown="return format_date(event,'reqAktaNikahTanggal');" />
                    </td>
                    <td style="padding: 0px;">
                      <label class="input-group-btn" for="reqAktaNikahTanggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                        <span class="mdi-notification-event-note"></span>
                      </label>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-12 mb-12">
                <label for="reqKartu">
                  Karis/karsu
                  <?
                  $warnadata= $vKartu['data'];
                  $warnaclass= $vKartu['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input type="text" placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox" name="reqKartu" id="reqKartu" <?=$read?> value="<?=$reqKartu?>" />
              </div>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-8 mb-8">
            <div class="form-row">
              <div class="col-md-2 mb-2 mtmin">
                <label for="reqJenisIdDokumen">
                  Jenis Dok
                  <?
                  $warnadata= $vJenisIdDokumen['data'];
                  $warnaclass= $vJenisIdDokumen['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqJenisIdDokumen" id="reqJenisIdDokumen">
                  <option value="" selected></option>
                  <?
                  foreach ($arrjenisiddokumen as $key => $value)
                  {
                    $optionid= $value["ID"];
                    $optiontext= $value["TEXT"];
                    $optionselected= "";
                    if($reqJenisIdDokumen == $optionid)
                      $optionselected= "selected";
                  ?>
                    <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                  <?
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-4 mb-4 mtmin">
                <label for="reqNoInduk">
                  Nomor Identitas
                  <?
                  $warnadata= $vNoInduk['data'];
                  $warnaclass= $vNoInduk['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <input type="hidden" id="reqValidasiNoInduk" />
                <input placeholder="" name="reqNoInduk" class="form-control <?=$warnaclass?> easyui-validatebox" id="reqNoInduk" type="text" value="<?=$reqNoInduk?>" />
              </div>

              <div class="col-md-3 mb-3 mtmin">
                <label for="reqJenisKelamin">
                  Jenis Kel
                  <?
                  $warnadata= $vJenisKelamin['data'];
                  $warnaclass= $vJenisKelamin['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqJenisKelamin" id="reqJenisKelamin">
                  <option value="" selected></option>
                  <?
                  foreach ($arrjeniskelamin as $key => $value)
                  {
                    $optionid= $value["ID"];
                    $optiontext= $value["TEXT"];
                    $optionselected= "";
                    if($reqJenisKelamin == $optionid)
                      $optionselected= "selected";
                  ?>
                    <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                  <?
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-3 mb-3 mtmin">
                <label for="reqAgamaId">
                  Agama
                  <?
                  $warnadata= $vAgamaId['data'];
                  $warnaclass= $vAgamaId['warna'];
                  if(!empty($warnadata))
                  {
                  ?>
                  <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                  <?
                  }
                  ?>
                </label>
                <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqAgamaId" id="reqAgamaId">
                  <option value="" selected></option>
                  <?
                  foreach ($arragama as $key => $value)
                  {
                    $optionid= $value["ID"];
                    $optiontext= $value["TEXT"];
                    $optionselected= "";
                    if($reqAgamaId == $optionid)
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
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqEmail">
              Email
              <?
              $warnadata= $vEmail['data'];
              $warnaclass= $vEmail['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder name="reqEmail" id="reqEmail" class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'email'" type="text" value="<?=$reqEmail?>" />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqHp">
              No HP / WA
              <?
              $warnadata= $vHp['data'];
              $warnaclass= $vHp['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder name="reqHp" id="reqHp" class="form-control <?=$warnaclass?> easyui-validatebox validasiangka" type="text" value="<?=$reqHp?>" />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqTelepon">
              No Telp Rumah
              <?
              $warnadata= $vTelepon['data'];
              $warnaclass= $vTelepon['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder name="reqTelepon" id="reqTelepon" class="form-control <?=$warnaclass?> easyui-validatebox validasiangka" type="text" value="<?=$reqTelepon?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <label for="reqAlamat">
              Alamat
              <?
              $warnadata= $vAlamat['data'];
              $warnaclass= $vAlamat['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <textarea class="form-control <?=$warnaclass?> materialize-textarea" name="reqAlamat"><?=$reqAlamat?></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqBpjsNo">
              No BPJS
              <?
              $warnadata= $vBpjsNo['data'];
              $warnaclass= $vBpjsNo['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox validasiangka" name="reqBpjsNo" id="reqBpjsNo" <?=$read?> value="<?=$reqBpjsNo?>" />
          </div>

          <div class="col-md-3 mb-3">
            <label class="active" for="reqBpjsTanggal">
              Tanggal BPJS
              <?
              $warnadata= $vBpjsTanggal['data'];
              $warnaclass= $vBpjsTanggal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <table>
              <tr> 
                <td style="padding: 0px;">
                  <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqBpjsTanggal" id="reqBpjsTanggal" value="<?=$reqBpjsTanggal?>" maxlength="10" onKeyDown="return format_date(event,'reqBpjsTanggal');" />
                </td>
                <td style="padding: 0px;">
                  <label class="input-group-btn" for="reqBpjsTanggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                    <span class="mdi-notification-event-note"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqNpwpNo">
              No NPWP
              <?
              $warnadata= $vNpwpNo['data'];
              $warnaclass= $vNpwpNo['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox validasiangka" name="reqNpwpNo" id="reqNpwpNo" <?=$read?> value="<?=$reqNpwpNo?>" />
          </div>

          <div class="col-md-3 mb-3">
            <label class="active" for="reqNpwpTanggal">
              Tanggal NPWP
              <?
              $warnadata= $vNpwpTanggal['data'];
              $warnaclass= $vNpwpTanggal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <table>
              <tr> 
                <td style="padding: 0px;">
                  <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqNpwpTanggal" id="reqNpwpTanggal" value="<?=$reqNpwpTanggal?>" maxlength="10" onKeyDown="return format_date(event,'reqNpwpTanggal');" />
                </td>
                <td style="padding: 0px;">
                  <label class="input-group-btn" for="reqNpwpTanggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                    <span class="mdi-notification-event-note"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <input type="checkbox" id="reqStatusPns" name="reqStatusPns" value="1" <? if($reqStatusPns == 1) echo 'checked'?> />
            <label for="reqStatusPns"></label>
            PNS
          </div>

          <div class="col-md-3 mb-3" id="reqLabelNipBaru">
            <label for="reqNipPns">
              NIP Baru
              <?
              $warnadata= $vNipPns['data'];
              $warnaclass= $vNipPns['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" class="form-control <?=$warnaclass?> validasiangka" id="reqNipPns" type="text" name="reqNipPns" value="<?=$reqNipPns?>" />
          </div>
        </div>

        <div class="clearfix"></div><br/>

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
            <select class="form-control <?=$warnaclass?>"name="reqPendidikanId" id="reqPendidikanId" <?=$disabled?>>
              <?
              // while($pendidikan->nextRow())
              // {
              ?>
                
              <?
              // }
              ?>
            </select>
          </div>

          <div class="col-md-3 mb-3" id="labelstatuslulus">
            <input type="checkbox" id="reqStatusLulus" name="reqStatusLulus" value="1" <? if($reqStatusLulus == 1) echo 'checked'?> />
            <label for="reqStatusLulus"></label>
            Sudah Lulus
          </div>

          <div class="col-md-2 mb-2">
            <label for="reqStatusBekerja">
              Status Bekerja
              <?
              $warnadata= $vStatusBekerja['data'];
              $warnaclass= $vStatusBekerja['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqStatusBekerja" id="reqStatusBekerja">
              <option value="1" <? if($reqStatusBekerja == 1) echo 'selected';?>>Sudah</option>
              <option value="" <? if($reqStatusBekerja == "") echo 'selected';?>>Belum</option>
            </select>
          </div>

          <div class="col-md-4 mb-4 labelpekerjaan">
            <label for="reqPekerjaan">
              Pekerjaan
              <?
              $warnadata= $vPekerjaan['data'];
              $warnaclass= $vPekerjaan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" placeholder="" type="text" <?=$read?> name="reqPekerjaan" id="reqPekerjaan" value="<?=$reqPekerjaan?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-2 mb-2">
            <label for="reqStatusHidup">
              Status Hidup
              <?
              $warnadata= $vStatusHidup['data'];
              $warnaclass= $vStatusHidup['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqStatusHidup" id="reqStatusHidup">
              <option value="1" <? if($reqStatusHidup == 1) echo 'selected';?>>Hidup</option>
              <option value="2" <? if($reqStatusHidup == 2) echo 'selected';?>>Wafat</option>
            </select>
          </div>

          <div class="col-md-3 mb-3 reqLabelTanggalMeninggal">
            <label for="reqKematianNo">
              Surat Keterangan Kematian
              <?
              $warnadata= $vKematianNo['data'];
              $warnaclass= $vKematianNo['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" name="reqKematianNo" id="reqKematianNo" <?=$read?> value="<?=$reqKematianNo?>" />
          </div>

          <div class="col-md-3 mb-3 reqLabelTanggalMeninggal">
            <label class="active" for="reqKematianTanggal">
              Tanggal Surat Kematian
              <?
              $warnadata= $vKematianTanggal['data'];
              $warnaclass= $vKematianTanggal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <table>
              <tr> 
                <td style="padding: 0px;">
                  <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqKematianTanggal" id="reqKematianTanggal" value="<?=$reqKematianTanggal?>" maxlength="10" onKeyDown="return format_date(event,'reqKematianTanggal');" />
                </td>
                <td style="padding: 0px;">
                  <label class="input-group-btn" for="reqKematianTanggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                    <span class="mdi-notification-event-note"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-3 mb-3 reqLabelTanggalMeninggal">
            <label class="active" for="reqTanggalMeninggal">
              Tanggal Meninggal
              <?
              $warnadata= $vTanggalMeninggal['data'];
              $warnaclass= $vTanggalMeninggal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <table>
              <tr> 
                <td style="padding: 0px;">
                  <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTanggalMeninggal" id="reqTanggalMeninggal" value="<?=$reqTanggalMeninggal?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalMeninggal');" />
                </td>
                <td style="padding: 0px;">
                  <label class="input-group-btn" for="reqTanggalMeninggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                    <span class="mdi-notification-event-note"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-2 mb-2">
            <label for="reqStatusSi">
              Status Pernikahan
              <?
              $warnadata= $vStatusSi['data'];
              $warnaclass= $vStatusSi['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqStatusSi" id="reqStatusSi">
              <option value=""></option>
            </select>
          </div>

          <div class="col-md-3 mb-3 labelnikah">
            <label for="reqAktaNikahNo">
              No Akta Nikah
              <?
              $warnadata= $vAktaNikahNo['data'];
              $warnaclass= $vAktaNikahNo['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" name="reqAktaNikahNo" id="reqAktaNikahNo" <?=$read?> value="<?=$reqAktaNikahNo?>" />
          </div>

          <div class="col-md-3 mb-3 labelnikah">
            <label class="active" for="reqNikahTanggal">
              Tanggal Nikah
              <?
              $warnadata= $vNikahTanggal['data'];
              $warnaclass= $vNikahTanggal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <table>
              <tr> 
                <td style="padding: 0px;">
                  <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqNikahTanggal" id="reqNikahTanggal" value="<?=$reqNikahTanggal?>" maxlength="10" onKeyDown="return format_date(event,'reqNikahTanggal');" />
                </td>
                <td style="padding: 0px;">
                  <label class="input-group-btn" for="reqNikahTanggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                    <span class="mdi-notification-event-note"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-3 mb-3 labelcerai">
            <label for="reqAktaCeraiNo">
              Surat Pengadilan / Cerai
              <?
              $warnadata= $vAktaCeraiNo['data'];
              $warnaclass= $vAktaCeraiNo['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" name="reqAktaCeraiNo" id="reqAktaCeraiNo" <?=$read?> value="<?=$reqAktaCeraiNo?>" />
          </div>

          <div class="col-md-3 mb-3 labelcerai">
            <label class="active" for="reqAktaCeraiTanggal">
              Tanggal Akta Cerai
              <?
              $warnadata= $vAktaCeraiTanggal['data'];
              $warnaclass= $vAktaCeraiTanggal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <table>
              <tr> 
                <td style="padding: 0px;">
                  <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqAktaCeraiTanggal" id="reqAktaCeraiTanggal" value="<?=$reqAktaCeraiTanggal?>" maxlength="10" onKeyDown="return format_date(event,'reqAktaCeraiTanggal');" />
                </td>
                <td style="padding: 0px;">
                  <label class="input-group-btn" for="reqAktaCeraiTanggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                    <span class="mdi-notification-event-note"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md-3 mb-3 labelcerai">
            <label class="active" for="reqCeraiTanggal">
              Tanggal Cerai
              <?
              $warnadata= $vCeraiTanggal['data'];
              $warnaclass= $vCeraiTanggal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <table>
              <tr> 
                <td style="padding: 0px;">
                  <input placeholder="" class="form-control  <?=$warnaclass?>easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqCeraiTanggal" id="reqCeraiTanggal" value="<?=$reqCeraiTanggal?>" maxlength="10" onKeyDown="return format_date(event,'reqCeraiTanggal');" />
                </td>
                <td style="padding: 0px;">
                  <label class="input-group-btn" for="reqCeraiTanggal" style="display: inline-block;width: 90%;text-align: right;top: 0px;">
                    <span class="mdi-notification-event-note"></span>
                  </label>
                </td>
              </tr>
            </table>
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
  getarrjeniskawin= JSON.parse('<?=JSON_encode($arrjeniskawin)?>');

  $(document).ready(function() {
    // $('select').material_select();

    // untuk format date baru
    $('.formattanggalnew').datepicker({
      format: "dd-mm-yyyy"
    });
  });

  tanggalsekarang= "<?=$tanggalsekarang?>";
  $('#reqTanggalLahir').keyup(function() {
    var vold= $('#reqTanggalLahir').val();
    var vnew= tanggalsekarang;

    getparamyearoldnew("reqUsia", vold, vnew);
  });

  $("#reqTanggalLahir").change(function(){
    var vold= $('#reqTanggalLahir').val();
    var vnew= tanggalsekarang;

    getparamyearoldnew("reqUsia", vold, vnew);
  });

  setjenisiddokumen("");
  $("#reqJenisIdDokumen").change(function(){
    setjenisiddokumen("data");
  });

  $("#reqNoInduk").keyup(function(){
    setnoinduk("data");
  });

  function setjenisiddokumen(infomode)
  {
    reqJenisIdDokumen= $("#reqJenisIdDokumen").val();
    setnoinduk(infomode);

    // infomode
  }

  function setnoinduk(infomode)
  {
    reqJenisIdDokumen= $("#reqJenisIdDokumen").val();
    reqNoInduk= $("#reqNoInduk").val();
    reqNoIndukLength= reqNoInduk.length;

    // $("#reqNoInduk").validatebox({required: false});
    $("#reqNoInduk").removeClass('validatebox-invalid');

    $("#reqDokumenRequiredktp,#reqDokumenRequiredsim,#reqDokumenRequiredpasport").val("");
    $("#riwayatfieldrequiredinfoktp,#riwayatfieldrequiredinfosim,#riwayatfieldrequiredinfopasport").text("");
    reqValidasiNoInduk= "";
    // 1 KTP
    if(reqJenisIdDokumen == "1")
    {
      // 1111111111111111
      // console.log(reqNoIndukLength);
      if(!$.isNumeric(reqNoInduk) || reqNoIndukLength !== 16)
      {
        reqValidasiNoInduk= "KTP harus 16 digit angka, tanpa spasi dan tanda baca";
      }

      $("#riwayatfieldrequiredinfoktp").text(" *");
      $("#reqDokumenRequiredktp").val("1");
    }
    // 2 Pasport
    else if(reqJenisIdDokumen == "2")
    {
      if(reqNoIndukLength < 5 || reqNoIndukLength > 8)
      {
        reqValidasiNoInduk= "Passport minimal 5 char maksimal 8 char, bisa angka dan huruf";
      }

      $("#riwayatfieldrequiredinfopasport").text(" *");
      $("#reqDokumenRequiredpasport").val("1");
    }
    // 3 SIM
    else if(reqJenisIdDokumen == "3")
    {
      if(!$.isNumeric(reqNoInduk) || reqNoIndukLength !== 12)
      {
        reqValidasiNoInduk= "SIM harus 12 digit angkat, tanpa spasi dan tanda baca";
      }

      $("#riwayatfieldrequiredinfosim").text(" *");
      $("#reqDokumenRequiredsim").val("1");
    }
    else
    {
      reqValidasiNoInduk= "Isikan terlebih dahulu Jenis Dokumen Identitas";
      // $("#reqNoInduk").validatebox({required: true});
    }

    // console.log(reqValidasiNoInduk);
    $("#reqValidasiNoInduk").val(reqValidasiNoInduk);
    // reqJenisIdDokumen;reqNoInduk

  }

  setpendidikan("");
  $("#reqPendidikanId").change(function () {
    setpendidikan("data");
  });

  function setpendidikan(infomode)
  {
    reqPendidikanId= $("#reqPendidikanId").val();
    $("#labelstatuslulus").show();

    if(infomode == "data")
    {
      $("#reqStatusLulus").prop('checked', false);
    }

    if(reqPendidikanId == 0)
    {
      $("#labelstatuslulus").hide();
      $("#reqStatusLulus").prop('checked', false);
    }
  }

  setcetang();
  $("#reqStatusPns").click(function () {
    setcetang();
  });

  function setcetang()
  {
    if($("#reqStatusPns").prop('checked')) 
    {
      $("#reqLabelNipBaru").show();
    }
    else
    {
      $("#reqNipPns").val("");
      $("#reqLabelNipBaru").hide();
    }
  }

  setstatusbekerja("");
  $("#reqStatusBekerja").change(function() { 
    setstatusbekerja("data");
  });

  function setstatusbekerja(infomode)
  {
    $(".labelpekerjaan").hide();

    if(infomode == "")
      vinfodata= "<?=$reqStatusBekerja?>";
    else
      vinfodata= $("#reqStatusBekerja").val();

    if(vinfodata == "1")
    {
      $(".labelpekerjaan").show();
    }
  }

  setstatusaktif("");
  $("#reqStatusHidup").change(function() { 
    setstatusaktif("data");
  });

  function setstatusaktif(infomode)
  {
    var reqStatusHidup= $("#reqStatusHidup").val();
    $(".reqLabelTanggalMeninggal").hide();

    // kalau suratkematian, maka
    $("#reqDokumenRequiredsuratkematian").val("");
    $("#riwayatfieldrequiredinfosuratkematian").text("");
    if(reqStatusHidup == "2")
    {
      // $("#reqKematianTanggal, #reqKematianNo, #reqTanggalMeninggal").validatebox({required: true});
      $(".reqLabelTanggalMeninggal").show();

      $("#riwayatfieldrequiredinfosuratkematian").text(" *");
      $("#reqDokumenRequiredsuratkematian").val("1");
    }
    else
    {
      // $("#reqKematianTanggal, #reqKematianNo, #reqTanggalMeninggal").validatebox({required: false});
      $("#reqKematianTanggal, #reqKematianNo, #reqTanggalMeninggal").removeClass('validatebox-invalid');
      $("#reqKematianTanggal, #reqKematianNo, #reqTanggalMeninggal").val("");
    }

    setjeniskawinid(infomode);
  }
  
  setjeniskawinid("");
  $("#reqStatusSi").change(function() { 
    setjeniskawinid("data");
  });

  function setjeniskawinid(infomode)
  {
    reqStatusHidup= $("#reqStatusHidup").val();

    if(infomode == "")
      vinfodata= "<?=$reqStatusSi?>";
    else
      vinfodata= $("#reqStatusSi").val();

    vlabelid= "reqStatusSi";
    $("#"+vlabelid+" option").remove();
    // $("#"+vlabelid).material_select();
    var voption= "<option value=''></option>";

    if(Array.isArray(getarrjeniskawin) && getarrjeniskawin.length)
    {
      $.each(getarrjeniskawin, function( index, value ) {
        // console.log( index + ": " + value["id"] );
        infoid= value["ID"];
        infotext= value["TEXT"];
        setoption= "1";

        // 1:Hidup
        if(reqStatusHidup == "1")
        {
          // if(infoid == "3")
          // {
          //   setoption= "";
          // }
        }
        // 2:Wafat
        else if(reqStatusHidup == "2")
        {
          // setoption= "";
          if(infoid == "3")
          {
            // setoption= "1";
          }
        }
        else
        {
          // setoption= "";
          if(infoid == "4")
          {
            // setoption= "1";
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

    $("#"+vlabelid).html(voption);
    // $("#"+vlabelid).material_select();

    if(infomode == ""){}
    else
    {
      $("#reqAktaNikahNo, #reqxxxAktaNikahTanggal, #reqNikahTanggal, #reqAktaCeraiNo, #reqAktaCeraiTanggal, #reqCeraiTanggal").val("");
    }

    // $("#reqAktaNikahNo, #reqAktaNikahTanggal, #reqNikahTanggal, #reqAktaCeraiNo, #reqAktaCeraiTanggal, #reqCeraiTanggal").validatebox({required: false});
    $("#reqAktaNikahNo, #reqAktaNikahTanggal, #reqNikahTanggal, #reqAktaCeraiNo, #reqAktaCeraiTanggal, #reqCeraiTanggal").removeClass('validatebox-invalid');
    
    // kalau cerai, maka
    $("#reqDokumenRequiredaktacerai").val("");
    $("#riwayatfieldrequiredinfoaktacerai").text("");
    if(vinfodata == "2")
    {
      $("#riwayatfieldrequiredinfoaktacerai").text(" *");
      $("#reqDokumenRequiredaktacerai").val("1");
    }
    // kalau cerai, maka

    $(".labelnikah, .labelcerai").hide();
    if(reqStatusHidup == "2")
    {
      $(".infohidup").hide();
    }
    else
    {
      $(".infohidup").show();
      $(".labelnikah, .labelcerai").hide();
      if(vinfodata == "1")
      {
        // $("#reqAktaNikahNo, #reqAktaNikahTanggal, #reqNikahTanggal").validatebox({required: true});
        // $(".labelnikah").show();
      }
      // else if(vinfodata == "2" || vinfodata == "3")
      else if(vinfodata == "2")
      {
        // $("#reqAktaNikahNo, #reqAktaNikahTanggal, #reqNikahTanggal, #reqAktaCeraiNo, #reqAktaCeraiTanggal, #reqCeraiTanggal").validatebox({required: true});
        // $("#reqAktaCeraiNo, #reqAktaCeraiTanggal, #reqCeraiTanggal").validatebox({required: true});
        // $(".labelnikah, .labelcerai").show();
        $(".labelcerai").show();
      }
    }

    setfotorequired();
  }

  function setfotorequired()
  {
    reqStatusHidup= $("#reqStatusHidup").val();
    reqStatusSi= $("#reqStatusSi").val();

    // kalau hidup, dan menikah, maka
    $("#reqDokumenRequiredfoto").val("");
    $("#riwayatfieldrequiredinfofoto").text("");
    // if(reqStatusHidup == "1")
    if(reqStatusHidup == "1" && reqStatusSi == "1")
    {
      $("#riwayatfieldrequiredinfofoto").text(" *");
      $("#reqDokumenRequiredfoto").val("1");
    }
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