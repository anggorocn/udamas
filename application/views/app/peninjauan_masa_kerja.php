<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"peninjauan_masa_kerja"];
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

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Tambahan_masa_kerja_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
$arrDataValue = $set->rowResult;

$arrDataCount = count($set->rowCount);
$reqRowId = $arrDataValue[$arrDataCount]['temp_validasi_id'];

// pakem data validasi
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Tambahan_masa_kerja_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("TAMBAHAN_MASA_KERJA_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
// $reqRowId= $set->getField('TAMBAHAN_MASA_KERJA_ID');

$reqNoSK= $set->getField('NO_SK');$vNoSK= checkwarna($reqPerubahanData, 'NO_SK');

$reqTanggalSk= dateToPageCheck($set->getField('TANGGAL_SK'));$vTanggalSk= checkwarna($reqPerubahanData, 'TANGGAL_SK', [date]);

$reqTmtSk= dateToPageCheck($set->getField('TMT_SK'));$vTmtSk= checkwarna($reqPerubahanData, 'TMT_SK', [date]);

$reqTahunTambahan= $set->getField('TAHUN_TAMBAHAN');$vTahunTambahan= checkwarna($reqPerubahanData, 'TAHUN_TAMBAHAN');

$reqBulanTambahan= $set->getField('BULAN_TAMBAHAN');$vBulanTambahan= checkwarna($reqPerubahanData, 'BULAN_TAMBAHAN');

$reqTahunBaru= $set->getField('TAHUN_BARU');$vTahunBaru= checkwarna($reqPerubahanData, 'TAHUN_BARU');

$reqBulanBaru= $set->getField('BULAN_BARU');$vBulanBaru= checkwarna($reqPerubahanData, 'BULAN_BARU');

$reqStatus= $set->getField('STATUS');

$reqGolRuang= $set->getField('PANGKAT_ID');$vGolRuang= checkwarna($reqPerubahanData, 'PANGKAT_ID');

$reqNoNota= $set->getField('NO_NOTA');$vNoNota= checkwarna($reqPerubahanData, 'NO_NOTA');

$reqTglNota= dateToPageCheck($set->getField('TANGGAL_NOTA'));$vTglNota= checkwarna($reqPerubahanData, 'TANGGAL_NOTA', [date]);

$reqGajiPokok= $set->getField('GAJI_POKOK');$vGajiPokok= checkwarna($reqPerubahanData, 'GAJI_POKOK');

$reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');

$reqPejabatPenetap= $set->getField('PEJABAT_PENETAP');


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

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
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

      $.ajax({
        url:"api/Tambahan_masa_kerja_json/add"
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
                  // document.location.href = "app/index/<?=$linkfilename?>"+addurl;
                  window.location.reload();
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

  $("#reqTanggalSk, #reqTahunBaru").keyup(function(){
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
        urlAjax= "api/combo/pejabatpenetap";
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

});

function setGaji()
{
  var reqTglSk= reqPangkatId= reqMasaKerja= "";
  reqTglSk= $("#reqTanggalSk").val();
  reqPangkatId= $("#reqGolRuang").val();
  reqMasaKerja= $("#reqTahunBaru").val();

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
            <input placeholder="" class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTglNota" id="reqTglNota"  value="<?=$reqTglNota?>" maxlength="10" onKeyDown="return format_date(event,'reqTglNota');"/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqNoSK">
              No. SK
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
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqNoSK" id="reqNoSK" value="<?=$reqNoSK?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTanggalSk">
              Tanggal Sk
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
            <input placeholder="" required class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTanggalSk" id="reqTanggalSk"  value="<?=$reqTanggalSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalSk');"/>
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
            <label for="reqTmtSk">
              TMT Sk
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
            <input placeholder="" required class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" data-options="validType:'dateValidPicker'" type="text" name="reqTmtSk" id="reqTmtSk"  value="<?=$reqTmtSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtSk');"/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqTahunTambahan">
              Tambahan Masa Kerja Th
              <?
              $warnadata= $vTahunTambahan['data'];
              $warnaclass= $vTahunTambahan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqTahunTambahan" <?=$read?> value="<?=$reqTahunTambahan?>" id="reqTahunTambahan" />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqBulanTambahan">
              Tambahan Masa Kerja Bl
              <?
              $warnadata= $vBulanTambahan['data'];
              $warnaclass= $vBulanTambahan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqBulanTambahan" <?=$read?> value="<?=$reqBulanTambahan?>" id="reqBulanTambahan" />
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqTahunBaru">
              Masa Kerja Th
              <?
              $warnadata= $vTahunBaru['data'];
              $warnaclass= $vTahunBaru['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqTahunBaru" <?=$read?> value="<?=$reqTahunBaru?>" id="reqTahunBaru" />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqBulanBaru">
              Masa Kerja Bl
              <?
              $warnadata= $vBulanBaru['data'];
              $warnaclass= $vBulanBaru['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqBulanBaru" <?=$read?> value="<?=$reqBulanBaru?>" id="reqBulanBaru" />
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
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required id="reqGajiPokok" name="reqGajiPokok" OnFocus="FormatAngka('reqGajiPokok')" OnKeyUp="FormatUang('reqGajiPokok')" OnBlur="FormatUang('reqGajiPokok')" value="<?=numberToIna($reqGajiPokok)?>" />
          </div>
        </div>

        <div class="clearfix"></div><br/>

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
            <input placeholder="" type="text" id="reqPejabatPenetap"  name="reqPejabatPenetap" <?=$read?> value="<?=$reqPejabatPenetap?>" class="form-control <?=$warnaclass?> easyui-validatebox" required />
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
              <!-- <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'diklat_kursus', '', '<?=$linkfilenamekembali?>')">Batal</button> -->
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

    $("#reqbatal,#reqaktif").click(function() { 
      var id= $(this).attr('id');

      if(id == "reqbatal")
      {
        modeinfo= "Apakah Anda Yakin, batal peninjauan masa kerja?"
        mode= "tambahanmasakerja_0";
      }
      else
      {
        modeinfo= "Apakah Anda Yakin, aktifkan peninjauan masa kerja?"
        mode= "tambahanmasakerja_1";
      } 

      mbox.custom({
       message: modeinfo,
       options: {close_speed: 100},
       buttons: [
       {
         label: 'Ya',
         color: 'green darken-2',
         callback: function() {
           $.getJSON("tambahan_masa_kerja_json/delete/?reqMode="+mode+"&reqRowId=<?=$reqRowId?>",
            function(data){
              mbox.alert(data.PESAN, {open_speed: 500}, interval = window.setInterval(function() 
              {
                clearInterval(interval);
                document.location.href= "app/loadUrl/app/pegawai_add_tambahan_masa_kerja/?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>";
              }, 1000));
              $(".mbox > .right-align").css({"display": "none"});
            });
           mbox.close();
         }
       },
       {
         label: 'Tidak',
         color: 'grey darken-2',
         callback: function() {
             mbox.close();
           }
         }
         ]
       });

    });

  });

  $('.materialize-textarea').trigger('autoresize');

  $('#reqTahunTambahan,#reqBulanTambahan,#reqTahunBaru,#reqBulanBaru').bind('keyup paste', function(){
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