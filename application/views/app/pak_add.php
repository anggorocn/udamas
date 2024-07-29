<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"pak"];
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
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"pak_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("PAK_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
$reqJabatanFtId= $set->getField('JABATAN_FT_ID');

$reqCheckPakAwal = $set->getField('PAK_AWAL');

$reqJabatanFt= $set->getField('JABATAN'); $vJabatanFt= checkwarna($reqPerubahanData, 'JABATAN');

$reqNoSK= $set->getField('NO_SK'); $vNoSK= checkwarna($reqPerubahanData, 'NO_SK');

$reqTglMulai= dateToPageCheck($set->getField('TANGGAL_MULAI')); $vTglMulai= checkwarna($reqPerubahanData, 'TANGGAL_MULAI', [date]);

$reqTglSelesai= dateToPageCheck($set->getField('TANGGAL_SELESAI')); $vTglSelesai= checkwarna($reqPerubahanData, 'TANGGAL_SELESAI', [date]);

$reqTglSK= dateToPageCheck($set->getField('TANGGAL_SK')); $vTglSK= checkwarna($reqPerubahanData, 'TANGGAL_SK', [date]);

$reqKreditUtama= dotToComma($set->getField('KREDIT_UTAMA')); $vKredit= checkwarna($reqPerubahanData, 'KREDIT_UTAMA', [numberformat]);

$reqKreditPenunjang= dotToComma($set->getField('KREDIT_PENUNJANG')); $vKreditPenunjang= checkwarna($reqPerubahanData, 'KREDIT_PENUNJANG', [numberformat]);

$reqTotalKredit= dotToComma($set->getField('TOTAL_KREDIT')); $vTotalKredit= checkwarna($reqPerubahanData, 'TOTAL_KREDIT', [numberformat]);

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

  $("#reqKreditUtama, #reqKreditPenunjang").keyup(function(){
    var reqKreditUtama= reqKreditPenunjang= "";
    reqKreditUtama= $("#reqKreditUtama").val();
    reqKreditUtama= String(reqKreditUtama);
    reqKreditUtama= reqKreditUtama.replace(",", ".");

    reqKreditPenunjang= $("#reqKreditPenunjang").val();
    reqKreditPenunjang= String(reqKreditPenunjang);
    reqKreditPenunjang= reqKreditPenunjang.replace(",", ".");

    reqTotalKredit= parseFloat(reqKreditUtama) + parseFloat(reqKreditPenunjang);
    reqTotalKredit= reqTotalKredit.toFixed(3);
    reqTotalKredit= String(reqTotalKredit);
    reqTotalKredit= reqTotalKredit.replace(".", ",");
    $("#reqTotalKredit").val(reqTotalKredit);
  });
  
  $('input[id^="reqJabatanFt"]').autocomplete({
    source:function(request, response){
      var id= this.element.attr('id');
      var replaceAnakId= replaceAnak= urlAjax= "";
  
      if (id.indexOf('reqJabatanFt') !== -1)
      {
        var element= id.split('reqJabatanFt');
        var indexId= "reqJabatanFtId"+element[1];
        urlAjax= "jabatan_ft_json/namajabatan";
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
      return {desc: element['desc'], id: element['id'], label: element['label'], satuan_kerja: element['satuan_kerja']};
            });
            response(array);
          }
        }
      })
    },
    focus: function (event, ui) 
    { 
      var id= $(this).attr('id');
      if (id.indexOf('reqJabatanFt') !== -1)
      {
        var element= id.split('reqJabatanFt');
        var indexId= "reqJabatanFtId"+element[1];
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
          <div class="col-md-3 mb-3">
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
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required name="reqNoSK" id="reqNoSK" <?=$read?> value="<?=$reqNoSK?>" />
          </div>

          <div class="col-md-3 mb-3">
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
            <input required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSK" id="reqTglSK"  value="<?=$reqTglSK?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSK');"/>
          </div>

          <div class="col-md-1 mb-1">
            <label for="reqCheckPakAwal">
              Pertama
              <?
              $warnadata= $vCheckPakAwal['data'];
              $warnaclass= $vCheckPakAwal['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="checkbox" id="reqCheckPakAwal" name="reqCheckPakAwal" value="1" <? if($reqCheckPakAwal == 1) echo 'checked'?>/>
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqTglMulai">
              Tgl. Mulai Penilaian
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
            <input required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglMulai" id="reqTglMulai"  value="<?=$reqTglMulai?>" maxlength="10" onKeyDown="return format_date(event,'reqTglMulai');"/>
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqTglSelesai">
              Tgl Selesai Penilaian
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
            <input required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglSelesai" id="reqTglSelesai"  value="<?=$reqTglSelesai?>" maxlength="10" onKeyDown="return format_date(event,'reqTglSelesai');"/>
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqKredit">
              Kredit Utama
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
            <input class="form-control <?=$warnaclass?>" type="text" id="reqKreditUtama" name="reqKreditUtama" <?=$read?>  value="<?=$reqKreditUtama?>" onkeypress='kreditvalidate(event, this)' />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqKreditPenunjang">
              Kredit Penunjang
              <?
              $warnadata= $vKreditPenunjang['data'];
              $warnaclass= $vKreditPenunjang['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqKreditPenunjang" name="reqKreditPenunjang" <?=$read?>  value="<?=$reqKreditPenunjang?>" onkeypress='kreditvalidate(event, this)' />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqTotalKredit">
              Total Kredit
              <?
              $warnadata= $vTotalKredit['data'];
              $warnaclass= $vTotalKredit['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" placeholder id="reqTotalKredit" name="reqTotalKredit" <?=$read?>  value="<?=$reqTotalKredit?>" onkeypress='kreditvalidate(event, this)' />
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <label for="reqJabatanFt">
              Nama Jabatan Fungsional Yang Diusulkan
              <?
              $warnadata= $vJabatanFt['data'];
              $warnaclass= $vJabatanFt['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="hidden" name="reqJabatanFtId" id="reqJabatanFtId" value="<?=$reqJabatanFtId?>" /> 
            <input class="form-control <?=$warnaclass?>" type="text" id="reqJabatanFt" name="reqJabatanFt" <?=$read?> value="<?=$reqJabatanFt?>" class="easyui-validatebox" required />
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
              <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'pak', '', '<?=$linkfilenamekembali?>')">Batal</button>
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

  // untuk area untuk upload file
  vbase_url= "<?=base_url()?>";
  getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
  // console.log(getarrlistpilihfilefield);

  // apabila butuh kualitas dokumen di ubah
  vselectmaterial= "1";
  // untuk area untuk upload file

</script>