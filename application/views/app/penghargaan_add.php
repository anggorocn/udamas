<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"penghargaan"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);

$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");

$arrpenghargaan= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "namapenghargaan", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("REF_PENGHARGAAN_ID");
  $arrdata["text"]= $set->getField("NAMA");
  $arrdata["INFO_DETIL"]= $set->getField("INFO_DETIL");
  array_push($arrpenghargaan, $arrdata);
}
// print_r($arrpenghargaan);exit;


$arrpenghargaanjenjang=[];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "penghargaanjenjang", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("REF_PENGHARGAAN_JENJANG_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrpenghargaanjenjang, $arrdata);
}
// print_r($arrpenghargaanjenjang);exit;

$arrstatuslulus= array(
    array("id"=>"", "text"=> "Belum")
    , array("id"=>"1", "text"=> "Ya")
);

// pakem data validasi
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"penghargaan_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("PENGHARGAAN_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
if($set->getField('PEJABAT_PENETAP_ID')==''){
  $reqStatus='baru';
  $reqDisplayBaru='';
  $reqDisplay='none';
}else{
  $reqDisplayBaru='none';
  $reqDisplay='';
}

$reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');

$reqPejabatPenetap= $set->getField('PEJABAT_PENETAP_NAMA');

$reqNamaPenghargaan= $set->getField('NAMA');

$reqTahun= $set->getField('TAHUN'); $vTahun= checkwarna($reqPerubahanData, 'TAHUN', [$reqTahun]);

$reqTglSK= dateToPageCheck($set->getField('TANGGAL_SK')); $vTglSK= checkwarna($reqPerubahanData, 'TANGGAL_SK', [date]);

$reqNoSK= $set->getField('NO_SK'); $vNoSK= checkwarna($reqPerubahanData, 'NO_SK');

$reqRefPenghargaanId= $set->getField('REF_PENGHARGAAN_ID'); $vNamaPenghargaan= checkwarna($reqPerubahanData, 'REF_PENGHARGAAN_ID', $arrpenghargaan, array("id", "text"), $reqTempValidasiHapusId);

$reqNamaDetil= $set->getField('NAMA_DETIL'); $vNamaDetil= checkwarna($reqPerubahanData, 'NAMA_DETIL');

$reqJenjangPeringkatDetil= $set->getField('INFO_DETIL');

$reqJenjangPeringkatId= $set->getField('JENJANG_PERINGKAT_ID'); $vJenjangPeringkatId= checkwarna($reqPerubahanData, 'JENJANG_PERINGKAT_ID', $arrpenghargaanjenjang, array("id", "text"), $reqTempValidasiHapusId);

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
          <div class="col-md-12 mb-12">
            <label for="reqNamaPenghargaan">
              Nama Penghargaan
              <?
              $warnadata= $vNamaPenghargaan['data'];
              $warnaclass= $vNamaPenghargaan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" name="reqRefPenghargaanId" id="reqRefPenghargaanId">
              <option value="" <? if($reqRefPenghargaanId == "") echo 'selected';?>>Belum di tentukan</option>
              <?
              foreach ($arrpenghargaan as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqRefPenghargaanId == $optionid)
                  $optionselected= "selected";
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-row penghargaandetil">
          <div class="col-md-12 mb-12">
            <label for="reqNamaDetil">
              Perihal Penghargaan
              <?
              $warnadata= $vNamaDetil['data'];
              $warnaclass= $vNamaDetil['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" type="text" class="form-control <?=$warnaclass?> easyui-validatebox" name="reqNamaDetil" id="reqNamaDetil" <?=$read?> value="<?=$reqNamaDetil?>" />
          </div>
        </div>

        <div class="form-row penghargaandetil">
          <div class="col-md-12 mb-12">
            <label for="reqJenjangPeringkatId">
              Jenjang Peringkat
              <?
              $warnadata= $vJenjangPeringkatId['data'];
              $warnaclass= $vJenjangPeringkatId['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" id="reqJenjangPeringkatDetil" value="<?=$reqJenjangPeringkatDetil?>" />
            <select class="form-control <?=$warnaclass?>" name="reqJenjangPeringkatId" id="reqJenjangPeringkatId">
              <option value="" <? if($reqJenjangPeringkatId == "") echo 'selected';?>>Belum di tentukan</option>
              <?
              foreach ($arrpenghargaanjenjang as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqJenjangPeringkatId == $optionid)
                  $optionselected= "selected";
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-5 mb-5">
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
            <input placeholder="" required type="text" class="form-control <?=$warnaclass?> easyui-validatebox" name="reqNoSK" id="reqNoSK" <?=$read?> value="<?=$reqNoSK?>" />
          </div>

          <div class="col-md-5 mb-5">
            <label for="reqTglSK">
              Tgl. SK
              <?
              $warnadata= $vTglSK['data'];
              $warnaclass= $vTglSK['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="" required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSK" id="reqTglSK"  value="<?=$reqTglSK?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSK');" />
          </div>

          <div class="col-md-2 mb-2">
            <input type="hidden" name="reqPegawaiId" value="<?=$reqPegawaiId?>">
            <label for="reqTahun">
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
              <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'penghargaan', '', '<?=$linkfilenamekembali?>')">Batal</button>
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
          $vriwayatid= "";
          $vpegawairowfile= $reqDokumenKategoriFileId."-".$vriwayattable."-".$riwayatfield."-".$vriwayatid;
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

  // ambil rating penggalian
  getarrpenghargaan= JSON.parse('<?=JSON_encode($arrpenghargaan)?>');
  // console.log(getarrpenghargaan);

  $("#reqRefPenghargaanId").change(function() { 

    setpenghargaan("data");
    // $("#reqJenjangPeringkatId, #reqNamaDetil").validatebox({required: false});
    // $("#reqJenjangPeringkatId, #reqNamaDetil").removeClass('validatebox-invalid');

    // $("#reqKematianTanggal, #reqKematianNo, #reqTanggalMeninggal").validatebox({required: true});
  });

  setpenghargaan("");
  function setpenghargaan(infomode)
  {
    if(infomode == "")
      vinfodata= "<?=$reqRefPenghargaanId?>";
    else
      vinfodata= $("#reqRefPenghargaanId").val();;

    infoid= vinfodata;
    valarrpenghargaan= getarrpenghargaan.filter(item => item.id === parseInt(infoid));

    if(Array.isArray(valarrpenghargaan) && valarrpenghargaan.length)
    {
      infodetil= valarrpenghargaan[0]["INFO_DETIL"];
      console.log(valarrpenghargaan);
      console.log(getarrpenghargaan);
      console.log(infodetil);

      $(".penghargaandetil").hide();
      if(infodetil == "1")
      {
        $(".penghargaandetil").show();

        if(infomode == ""){}
        else
        {
          $("#reqJenjangPeringkatDetil").val(infodetil);
        }
      }
      else
      {
        if(infomode == ""){}
        else
        {
          $("#reqJenjangPeringkatDetil, #reqJenjangPeringkatId, #reqNamaDetil").val("");
          // $("#reqJenjangPeringkatId").material_select();
        }
      }
    }
    else
    {
      $(".penghargaandetil").hide();
    }


  }

  $('#reqTglSK').keyup(function() {
    var vtanggalakhir= $('#reqTglSK').val();
    var checktanggalakhir= moment(vtanggalakhir , 'DD-MM-YYYY', true).isValid();

    if(checktanggalakhir == true)
    {
      vtanggalakhir= $('#reqTglSK').val();
      vtahun= vtanggalakhir.substring(6,10);
      $("#reqTahun, #reqTahunText").val(vtahun);
    }

  });

  $('.materialize-textarea').trigger('autoresize');

  // untuk area untuk upload file
  vbase_url= "<?=base_url()?>";
  getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
  // console.log(getarrlistpilihfilefield);

  // apabila butuh kualitas dokumen di ubah
  vselectmaterial= "1";
  // untuk area untuk upload file

</script>