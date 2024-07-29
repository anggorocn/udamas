<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"gaji"];
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

// pakem data validasi
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"gaji_riwayat_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("GAJI_RIWAYAT_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
$reqRowId = $set->getField('GAJI_RIWAYAT_ID');

$reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');

$reqPejabatPenetap= $set->getField('PEJABAT_PENETAP_NAMA'); $vPejabatPenetap= checkwarna($reqPerubahanData, 'PEJABAT_PENETAP_NAMA');

$reqNoSk = $set->getField('NO_SK'); $vNoSK= checkwarna($reqPerubahanData, 'NO_SK');

$reqGolRuang= $set->getField('PANGKAT_ID'); $vGolRuang= checkwarna($reqPerubahanData, 'PANGKAT_ID', $arrgolruang, array("id", "text"), $reqTempValidasiHapusId);

$reqTanggalSk= dateToPageCheck($set->getField('TANGGAL_SK')); $vTanggalSk= checkwarna($reqPerubahanData, 'TANGGAL_SK', [date]);

$reqTmtSk= dateToPageCheck($set->getField('TMT_SK')); $vTmtSk= checkwarna($reqPerubahanData, 'TMT_SK', [date]);

$reqGajiPokok = $set->getField('GAJI_POKOK'); $vGajiPokok= checkwarna($reqPerubahanData, 'GAJI_POKOK', [numberformat]);

// echo $reqGajiPokok;exit();
$reqTh= $set->getField('MASA_KERJA_TAHUN'); $vTh= checkwarna($reqPerubahanData, 'MASA_KERJA_TAHUN');

$reqBl= $set->getField('MASA_KERJA_BULAN'); $vBl= checkwarna($reqPerubahanData, 'MASA_KERJA_BULAN');

$reqJenis= $set->getField('JENIS_KENAIKAN');

$reqJenisNama= $set->getField('JENIS_KENAIKAN_NAMA');

$reqLastProsesUser= $set->getField('LAST_PROSES_USER');

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
  //     if($("#ff").form('validate') == false){
  //       return false;
  //     }

  //     var reqTanggal= "";
  //     reqTanggal= $("#reqTmtSk").val();
  //     var s_url= "hari_libur_json/hakentrigaji?reqMode=gaji&reqTanggal="+reqTanggal;
  //     $.ajax({'url': s_url,'success': function(dataajax){
  //       // return false;
  //       dataajax= dataajax.split(";");
  //       rowid= parseInt(dataajax[0]);
  //       infodata= dataajax[1];
  //       if(rowid == 1)
  //       {
  //         mbox.alert('Anda tidak berhak menambah data di atas tmt sk ' + infodata, {open_speed: 0});
  //         return false;
  //       }
  //       else
  //         $("#reqSubmit").click();
  //     }});

  //   });
    
  //   $('#ff').form({
  //     url:'gaji_riwayat_json/add',
  //     onSubmit:function(){

  //       var reqGolRuang= "";
  //       reqGolRuang= $("#reqGolRuang").val();

  //       if(reqGolRuang == "")
  //       {
  //         $.messager.alert('Info', "Lengkapi data golongan ruang terlebih dahulu", 'info');
  //         return false;
  //       }

  //       if($(this).form('validate')){}
  //       else
  //       {
  //         $.messager.alert('Info', "Lengkapi data terlebih dahulu", 'info');
  //         return false;
  //       }
  //     },
  //     success:function(data){
  //       // console.log(data);return false;
  //       data = data.split("-");
  //       rowid= data[0];
  //       infodata= data[1];

  //       if(rowid == "xxx")
  //       {
  //         mbox.alert(infodata, {open_speed: 0});
  //       }
  //       else
  //       {
  //         mbox.alert(infodata, {open_speed: 500}, interval = window.setInterval(function() 
  //         {
  //         clearInterval(interval);
  //         mbox.close();
  //         document.location.href= "app/loadUrl/app/pegawai_add_gaji_data/?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>&reqRowId="+rowid;
  //         }, 1000));
  //         $(".mbox > .right-align").css({"display": "none"});
  //       }
  //     }
  //   });

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

  $("#reqTanggalSk, #reqTh").keyup(function(){
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
        $("#"+indexId).val(ui.item.id).trigger('change');
      },
      autoFocus: true
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
    .append( "<a>" + item.desc + "</a>" )
    .appendTo( ul );
  };

});

function setGaji()
  {
    var reqTglSk= reqPangkatId= reqMasaKerja= "";
    reqTglSk= $("#reqTanggalSk").val();
    reqPangkatId= $("#reqGolRuang").val();
    reqMasaKerja= $("#reqTh").val();

    urlAjax= "gaji_pokok_json/gajipokok?reqPangkatId="+reqPangkatId+"&reqMasaKerja="+reqMasaKerja+"&reqTglSk="+reqTglSk;
    $.ajax({'url': urlAjax,'success': function(data){
      tempValueGaji= parseFloat(data);
      $("#reqGajiPokok").val(FormatCurrency(tempValueGaji));
    }});
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
            <label for="reqNoSk">
              No. SK
              <?
              $warnadata= $vNoSk['data'];
              $warnaclass= $vNoSk['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required id="reqNoSk" name="reqNoSk" <?=$read?> value="<?=$reqNoSk?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTanggalSk">
              Tgl. SK
              <?
              $warnadata= $vTanggalSk['data'];
              $warnaclass= $vTanggalSk['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTanggalSk" id="reqTanggalSk"  value="<?=$reqTanggalSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalSk');"/>
          </div>
        </div>

        <div class="form-row">
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
            <select class="form-control <?=$warnaclass?>" name="reqGolRuang" id="reqGolRuang">
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
            <label for="reqTmtSk">
              TMT SK
              <?
              $warnadata= $vTmtSk['data'];
              $warnaclass= $vTmtSk['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTmtSk" id="reqTmtSk"  value="<?=$reqTmtSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtSk');"/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
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
            <input type="text" id="reqPejabatPenetap"  name="reqPejabatPenetap" <?=$read?> value="<?=$reqPejabatPenetap?>" class="form-control <?=$warnaclass?> easyui-validatebox" required />
          </div>
        </div>

        <div class="clearfix"></div><br/>

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
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqTh" <?=$read?> value="<?=$reqTh?>" id="reqTh" title="Masa kerja tahun harus diisi" />
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
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqBl" <?=$read?> value="<?=$reqBl?>" id="reqBl" title="Masa kerja bulan diisi" />
          </div>

          <div class="col-md-6 mb-6">
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
            <input type="text" placeholder class="form-control <?=$warnaclass?> easyui-validatebox" required id="reqGajiPokok" name="reqGajiPokok" OnFocus="FormatAngka('reqGajiPokok')" OnKeyUp="FormatUang('reqGajiPokok')" OnBlur="FormatUang('reqGajiPokok')" value="<?=numberToIna($reqGajiPokok)?>" />
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <?
            if($reqJenis == "3")
            {
              ?>
              <label for="reqJenisNama">
                Jenis
                <?
                $warnadata= $vJenisNama['data'];
                $warnaclass= $vJenisNama['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input type="hidden" id="reqJenis" name="reqJenis" value="3" />
              <input class="form-control <?=$warnaclass?>" type="text" id="reqJenisNama" value="Gaji Berkala" disabled />
            <?
            }
            else
            {
            ?>
              <label for="reqJenisNama">
                Jenis
                <?
                $warnadata= $vJenisNama['data'];
                $warnaclass= $vJenisNama['warna'];
                if(!empty($warnadata))
                {
                ?>
                <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                <?
                }
                ?>
              </label>
              <input type="hidden" id="reqJenis" name="reqJenis" value="<?=$reqJenis?>" />
              <input class="form-control <?=$warnaclass?>" type="text" id="reqJenisNama" value="<?=$reqJenisNama?>" disabled />
              <?
            }
            ?>
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
              <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'gaji_riwayat', '', '<?=$linkfilenamekembali?>')">Batal</button>
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
  $(document).ready(function() {
    // $('select').material_select();
  });

  $('.materialize-textarea').trigger('autoresize');

  $('#reqTh,#reqBl').bind('keyup paste', function(){
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