<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"pangkat"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//

$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");

$arrgolruang= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "pangkat", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("PANGKAT_ID");
  $arrdata["text"]= $set->getField("KODE");
  array_push($arrgolruang, $arrdata);
}

$arrjenisrwypangkat= [];
$arrdata= [];
$arrdata["id"]= 4;
$arrdata["text"]= "Reguler";
array_push($arrjenisrwypangkat, $arrdata);
$arrdata["id"]= 11;
$arrdata["text"]= "Kenaikan Pangkat Pengabdian";
array_push($arrjenisrwypangkat, $arrdata);
$arrdata["id"]= 5;
$arrdata["text"]= "Pilihan Struktural";
array_push($arrjenisrwypangkat, $arrdata);
$arrdata["id"]= 6;
$arrdata["text"]= "Pilihan JFT";
array_push($arrjenisrwypangkat, $arrdata);
$arrdata["id"]= 7;
$arrdata["text"]= "Pilihan PI/UD";
array_push($arrjenisrwypangkat, $arrdata);
$arrdata["id"]= 10;
$arrdata["text"]= "Penambahan Masa Kerja";
array_push($arrjenisrwypangkat, $arrdata);
$arrdata["id"]= 8;
$arrdata["text"]= "Hukuman disiplin";
array_push($arrjenisrwypangkat, $arrdata);
$arrdata["id"]= 9;
$arrdata["text"]= "Pemulihan hukuman disiplin";
array_push($arrjenisrwypangkat, $arrdata);


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
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"pangkat_riwayat_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("PANGKAT_RIWAYAT_ID");
// print_r($reqPerubahanData);exit;
$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
// $reqRowId= $set->getField('PANGKAT_RIWAYAT_ID');

// $reqNoDiklatPrajabatan = $set->getField('PEJABAT_PENETAP_ID');
$reqTglStlud= dateToPageCheck($set->getField('TANGGAL_STLUD')); $vTglStlud= checkwarna($reqPerubahanData, 'TANGGAL_STLUD', [date]);

if($reqTglStlud == "01-01-0001")
  $reqTglStlud= "";
// echo $reqTglStlud;exit();

$reqStlud= $set->getField('STLUD');

$reqNoStlud= $set->getField('NO_STLUD');

$reqNoNota= $set->getField('NO_NOTA'); $vNoNota= checkwarna($reqPerubahanData, 'NO_NOTA');

$reqTh= $set->getField('MASA_KERJA_TAHUN'); $vTh= checkwarna($reqPerubahanData, 'MASA_KERJA_TAHUN', [numberformat]);

$reqBl= $set->getField('MASA_KERJA_BULAN'); $vBl= checkwarna($reqPerubahanData, 'MASA_KERJA_BULAN', [numberformat]);

$reqKredit= dotToComma($set->getField('KREDIT'));

$reqJenisKp= $set->getField('JENIS_RIWAYAT'); $vJenisKp= checkwarna($reqPerubahanData, 'JENIS_RIWAYAT', $arrjenisrwypangkat, array("id", "text"), $reqTempValidasiHapusId);

$reqJenisKpNama= $set->getField('JENIS_RIWAYAT_NAMA');

$reqKeterangan= $set->getField('KETERANGAN'); $vKeterangan= checkwarna($reqPerubahanData, 'KETERANGAN');

$reqGajiPokok= $set->getField('GAJI_POKOK'); $vGajiPokok= checkwarna($reqPerubahanData, 'GAJI_POKOK', [numberformat]);

$reqTglNota= dateToPageCheck($set->getField('TANGGAL_NOTA')); $vTglNota= checkwarna($reqPerubahanData, 'TANGGAL_NOTA', [date]);

$reqTglSk= dateToPageCheck($set->getField('TANGGAL_SK')); $vTglSk= checkwarna($reqPerubahanData, 'TANGGAL_SK', [date]);

$reqTmtGol= dateToPageCheck($set->getField('TMT_PANGKAT')); $vTmtGol= checkwarna($reqPerubahanData, 'TMT_PANGKAT', [date]);

$reqNoSk= $set->getField('NO_SK'); $vNoSK= checkwarna($reqPerubahanData, 'NO_SK');
// print_r($vNoSK);exit;

$reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');

$reqPejabatPenetap= $set->getField('PEJABAT_PENETAP_NAMA');

$reqGolRuang= $set->getField('PANGKAT_ID'); $vGolRuang= checkwarna($reqPerubahanData, 'PANGKAT_ID', $arrgolruang, array("id", "text"), $reqTempValidasiHapusId);

$reqNoUrutCetak= $set->getField('NO_URUT_CETAK'); $vNoUrutCetak= checkwarna($reqPerubahanData, 'NO_URUT_CETAK');

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

  // $("#reqsimpan").click(function() { 
  //   if($("#ff").form('validate') == false){
  //     return false;
  //   }

  //   var reqTanggal= "";
  //   reqTanggal= $("#reqTmtGol").val();
  //   var s_url= "hari_libur_json/hakentrigaji?reqTanggal="+reqTanggal;
  //   $.ajax({'url': s_url,'success': function(dataajax){
  //     // return false;
  //     dataajax= dataajax.split(";");
  //     rowid= parseInt(dataajax[0]);
  //     infodata= dataajax[1];
  //     if(rowid == 1)
  //     {
  //       mbox.alert('Hubungi Sub Bidang Kepangkatan, Anda tidak berhak menambah data di atas TMT ' + infodata, {open_speed: 0});
  //       return false;
  //     }
  //     else
  //       $("#reqSubmit").click();
  //   }});
          
  // });

  // $('#ff').form({
  //   url:'pangkat_riwayat_json/add',
  //   onSubmit:function(){
  //     var reqJenisKp= $("#reqJenisKp").val();

  //     if(reqJenisKp == "")
  //     {
  //       mbox.alert("Lengkapi data Jenis Riwayat Pangkat terlebih dahulu", {open_speed: 0});
  //       return false;
  //     }
        
  //     var reqGolRuang= "";
  //     reqGolRuang= $("#reqGolRuang").val();

  //     if(reqGolRuang == "")
  //     {
  //       mbox.alert("Lengkapi data golongan ruang terlebih dahulu", {open_speed: 0});
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
  //         clearInterval(interval);
  //         mbox.close();
  //         document.location.href= "app/loadUrl/app/pegawai_add_pangkat_data/?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>&reqRowId="+rowid;
  //       }, 1000));
  //       $(".mbox > .right-align").css({"display": "none"});
  //     }
         
  //   }
  // });

  <?
  if($reqGajiPokok == "")
  {
  ?>
    setGaji();
  <?
  }
  ?>
     
  $("#reqGolRuang").change(function(){
    setGaji();
  });

  $("#reqTglSk, #reqTh").keyup(function(){
    setGaji();
  });

  $('input[id^="reqPejabatPenetap"]').autocomplete({
    source:function(request, response){
      var id= this.element.attr('id');
      var replaceAnakId= replaceAnak= urlAjax= "";

      if (id.indexOf('reqPejabatPenetap') !== -1)
      {
        var element= id.split('reqPejabatPenetap');
        var indexId= "reqPejabatPenetapId"+element[1];
        urlAjax= "pejabat_penetap_json/combo";
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
              return {desc: element['desc'], id: element['id'], label: element['label'], statusht: element['statusht']};
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
    
  setJenisKenaikanPangkat();
  $('#reqJenisKp').bind('change', function(ev) {
    setJenisKenaikanPangkat();
  });

});

function setGaji()
{
  var reqTglSk= reqPangkatId= reqMasaKerja= "";
  reqTglSk= $("#reqTglSk").val();
  reqPangkatId= $("#reqGolRuang").val();
  reqMasaKerja= $("#reqTh").val();

  urlAjax= "gaji_pokok_json/gajipokok?reqPangkatId="+reqPangkatId+"&reqMasaKerja="+reqMasaKerja+"&reqTglSk="+reqTglSk;
  $.ajax({'url': urlAjax,'success': function(data){
    tempValueGaji= parseFloat(data);
    $("#reqGajiPokok").val(FormatCurrency(tempValueGaji));
  }});
}

function setJenisKenaikanPangkat()
{
  console.log("asas");
  var reqJenisKp= "";
  reqJenisKp= $("#reqJenisKp").val();
  // $("#reqinfobkn,#reqinfokredit").hide();
  $("#reqinfostlud,#reqinfokredit").hide();
  $("#reqinfobkn,#setinfopangkat").show();
  // $('#reqKredit').validatebox({required: false});
  $('#reqKredit').removeClass('validatebox-invalid');
  
  if(reqJenisKp == "")
  {
   // document.location.href = "app/index/pangkat_add?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>&reqRowId=<?=$reqRowId?>";
  }
  else if(reqJenisKp == "7")
  {
    //$("#reqinfobkn").show();
    $("#reqinfostlud").show();
    $("#reqKredit").val("");
  }
  else if(reqJenisKp == "6")
  {
    $("#reqinfokredit").show();
    // $('#reqKredit').validatebox({required: true});
    // console.log("s");
  }
  else
  {
    $("#reqStlud,#reqNoStlud,#reqTglStlud,#reqKredit").val("");
    // $("#reqStlud").material_select();
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
          <div class="col-md-6 mb-6">
            <?
            if($reqJenisKp == 1 || $reqJenisKp == 2)
            {
            ?>
              <label for="reqJenisKpNama">
                Jenis Riwayat Pangkat
                <?
                $warnadata= $vJenisKpNama['data'];
                $warnaclass= $vJenisKpNama['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input type="hidden" id="reqJenisKp" name="reqJenisKp" value="<?=$reqJenisKp?>" />
              <input class="form-control <?=$warnaclass?>" type="text" id="reqJenisKpNama" value="<?=$reqJenisKpNama?>" disabled />
            <?
            }
            else
            {
            ?>
              <label for="reqJenisKp" class="active">
                Jenis Riwayat Pangkat
                <?
                $warnadata= $vJenisKp['data'];
                $warnaclass= $vJenisKp['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqJenisKp" id="reqJenisKp" >
                <option value=""></option>
                <?
                foreach ($arrjenisrwypangkat as $key => $value)
                {
                  $optionid= $value["id"];
                  $optiontext= $value["text"];
                  $optionselected= "";
                  if($reqJenisKp == $optionid)
                    $optionselected= "selected";
                ?>
                  <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
                }
                ?>
              </select>
            <?
            }
            ?>
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <span id="setinfopangkat">
          <div class="form-row">
            <div class="col-md-4 mb-4">
              <label for="reqNoSk">
                No SK 
                 <?
               
                $warnadata= $vNoSK['data'];
                $warnaclass= $vNoSK['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" type="text" class="form-control  easyui-validatebox <?=$warnaclass?>" required id="reqNoSk" name="reqNoSk" <?=$read?> value="<?=$reqNoSk?>" title="No SK harus diisi"  />
            </div>

            <div class="col-md-4 mb-4">
              <label for="reqTglSk">
                Tgl SK
                <?
               
                $warnadata= $vTglSk['data'];
                $warnaclass= $vTglSk['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSk" id="reqTglSk"  value="<?=$reqTglSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSk');"/>
            </div>

            <div class="col-md-4 mb-4">
              <label for="reqNoUrutCetak">
                No. Urut Cetak
                <?
                $warnadata= $vNoUrutCetak['data'];
                $warnaclass= $vNoUrutCetak['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" id="reqNoUrutCetak" name="reqNoUrutCetak" <?=$read?> value="<?=$reqNoUrutCetak?>" />
            </div>
          </div>

          <div class="form-row" id="reqinfostlud">
            <div class="col-md-4 mb-4">
              <label for="reqStlud">
                STLUD
                <?
                $warnadata= $vStlud['data'];
                $warnaclass= $vStlud['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <select class="form-control <?=$warnaclass?>" name="reqStlud" id="reqStlud">
                <option value=""></option>
                <option value="1" <? if($reqStlud == 1) echo 'selected'?>>Tingkat I</option>
                <option value="2" <? if($reqStlud == 2) echo 'selected'?>>Tingkat II</option>
                <option value="3" <? if($reqStlud == 3) echo 'selected'?>>Tingkat III</option>
              </select>
            </div>

            <div class="col-md-4 mb-4">
              <label for="reqNoStlud">
                No. STLUD
                <?
                $warnadata= $vNoStlud['data'];
                $warnaclass= $vNoStlud['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input class="form-control <?=$warnaclass?>" placeholder="" type="text" id="reqNoStlud" name="reqNoStlud" <?=$read?> value="<?=$reqNoStlud?>" />
            </div>

            <div class="col-md-4 mb-4">
              <label for="reqTglStlud">
                Tgl. STLUD
                <?
                $warnadata= $vTglStlud['data'];
                $warnaclass= $vTglStlud['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglStlud" id="reqTglStlud"  value="<?=$reqTglStlud?>" maxlength="10" onKeyDown="return format_date(event,'reqTglStlud');"/>
            </div>
          </div>

          <div class="form-row" id="reqinfobkn">
            <div class="col-md-6 mb-6">
              <label for="reqNoNota">
                No Nota BKN
                <?
                $warnadata= $vNoNota['data'];
                $warnaclass= $vNoNota['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input class="form-control <?=$warnaclass?>" placeholder="" type="text" name="reqNoNota" id="reqNoNota" <?=$read?> value="<?=$reqNoNota?>" />
            </div>

            <div class="col-md-6 mb-6">
              <label for="reqTglNota">
                Tgl Nota BKN
                <?
                $warnadata= $vTglNota['data'];
                $warnaclass= $vTglNota['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglNota" id="reqTglNota"  value="<?=$reqTglNota?>" maxlength="10" onKeyDown="return format_date(event,'reqTglNota');"/>
            </div>
          </div>

          <div class="form-row" id="reqinfobkn">
            <div class="col-md-6 mb-6">
              <label for="reqGolRuang">
                Gol/Ruang
                <?
                $warnadata= $vGolRuang['data'];
                $warnaclass= $vGolRuang['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <select class="form-control <?=$warnaclass?>" name="reqGolRuang" <?=$disabled?> id="reqGolRuang" >
                <option value=""></option>
                <?
                foreach ($arrgolruang as $key => $value)
                {
                  $optionid= $value["id"];
                  $optiontext= $value["text"];
                  $optionselected= "";
                  if($reqGolRuang == $optionid)
                    $optionselected= "selected";
                ?>
                  <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
                }
                ?>
              </select>
            </div>

            <div class="col-md-6 mb-6">
              <label for="reqTmtGol">
                TMT SK
                <?
                $warnadata= $vTmtGol['data'];
                $warnaclass= $vTmtGol['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTmtGol" id="reqTmtGol"  value="<?=$reqTmtGol?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtGol');"/>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-3 mb-3">
              <label for="reqTh">
                Masa Kerja Tahun
                <?
                $warnadata= $vTh['data'];
                $warnaclass= $vTh['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input type="hidden" name="reqTempTh" value="<?=$reqTh?>" />
              <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqTh" <?=$read?> value="<?=$reqTh?>" id="reqTh" title="Masa kerja tahun harus diisi" />
            </div>

            <div class="col-md-3 mb-3">
              <label for="reqBl">
                Masa Kerja Bulan
                <?
                $warnadata= $vBl['data'];
                $warnaclass= $vBl['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input type="hidden" name="reqTempBl" value="<?=$reqBl?>" />
              <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqBl" <?=$read?> value="<?=$reqBl?>" id="reqBl" title="Masa kerja bulan diisi" />
            </div>

            <div class="col-md-3 mb-3">
              <label for="reqGajiPokok">
                Gaji Pokok
                <?
                $warnadata= $vGajiPokok['data'];
                $warnaclass= $vGajiPokok['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required id="reqGajiPokok" name="reqGajiPokok" OnFocus="FormatAngka('reqGajiPokok')" OnKeyUp="FormatUang('reqGajiPokok')" OnBlur="FormatUang('reqGajiPokok')" value="<?=numberToIna($reqGajiPokok)?>" />
            </div>

            <div class="col-md-3 mb-3" id="reqinfokredit">
              <label for="reqKredit">
                Angka Kredit
                <?
                $warnadata= $vKredit['data'];
                $warnaclass= $vKredit['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input placeholder="" type="text" id="reqKredit" name="reqKredit" <?=$read?>  class="form-control <?=$warnaclass?> easyui-validatebox" value="<?=$reqKredit?>" onkeypress='kreditvalidate(event, this)' />
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-12 mb-12">
              <label for="reqPejabatPenetap">
                Pejabat Penetapan
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
              </label>
              <input type="hidden" name="reqPejabatPenetapId" id="reqPejabatPenetapId" value="<?=$reqPejabatPenetapId?>" /> 
              <input placeholder="" type="text" id="reqPejabatPenetap"  name="reqPejabatPenetap" <?=$read?> value="<?=$reqPejabatPenetap?>" class="form-control <?=$warnaclass?> easyui-validatebox" required />
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-12 mb-12">
              <label for="reqKeterangan">
                Keterangan
                <?
                $warnadata= $vKeterangan['data'];
                $warnaclass= $vKeterangan['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <textarea <?=$disabled?> name="reqKeterangan" id="reqKeterangan" class="form-control <?=$warnaclass?> required materialize-textarea"><?=$reqKeterangan?></textarea>
            </div>
          </div>
        </span>

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
              <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'pangkat_riwayat', '', '<?=$linkfilenamekembali?>')">Batal</button>
            <?
              }
            }
            }
            ?>
            <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='document.location.href="app/index/<?=$linkfilenamekembali?>"' type="button">Kembali</button>
          </div>
        </div>

      </form>
    </div>
    
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    // $('select').material_select();
  });

  $('.materialize-textarea').trigger('autoresize');
  
  $('#reqNoUrutCetak,#reqTh,#reqBl').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // untuk area untuk upload file
  vbase_url= "<?=base_url()?>";
  getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
  // console.log(getarrlistpilihfilefield);

  // apabila butuh kualitas dokumen di ubah
  vselectmaterial= "1";
  // untuk area untuk upload file

</script>