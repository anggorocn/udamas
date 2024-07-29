<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"saudara"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//

$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");

$arrstatussdr= array(
    array("id"=>"1", "text"=> "Kandung")
    , array("id"=>"2", "text"=> "Tiri")
    , array("id"=>"3", "text"=> "Angkat")
);

$arrjenkel= array(
    array("id"=>"L", "text"=> "L")
    , array("id"=>"P", "text"=> "P")
);

$arrstatushdp= array(
    array("id"=>"1", "text"=> "Aktif")
    , array("id"=>"2", "text"=> "Meninggal")
);


// pakem data validasi
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"saudara_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("SAUDARA_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
// $reqPegawaiId= $set->getField("PEGAWAI_ID");

$reqNama= $set->getField("NAMA"); $vNama= checkwarna($reqPerubahanData, 'NAMA');

$reqTmpLahir= $set->getField("TEMPAT_LAHIR"); $vTmpLahir= checkwarna($reqPerubahanData, 'TEMPAT_LAHIR');

$reqTglLahir= dateToPageCheck($set->getField("TANGGAL_LAHIR")); $vTglLahir= checkwarna($reqPerubahanData, 'TANGGAL_LAHIR', [date]);

$reqJenisKelamin= $set->getField("JENIS_KELAMIN"); $vJenisKelamin= checkwarna($reqPerubahanData, 'JENIS_KELAMIN', $arrjenkel, array("id", "text"), $reqTempValidasiHapusId);

$reqPekerjaan= $set->getField("PEKERJAAN"); $vPekerjaan= checkwarna($reqPerubahanData, 'PEKERJAAN');

$reqAlamat= $set->getField("ALAMAT"); $vAlamat= checkwarna($reqPerubahanData, 'ALAMAT');

$reqKodePos= $set->getField("KODEPOS"); $vKodePos= checkwarna($reqPerubahanData, 'KODEPOS');

$reqTelepon= $set->getField("TELEPON"); $vTelepon= checkwarna($reqPerubahanData, 'TELEPON');

$reqPropinsi= $set->getField("PROPINSI_ID");

$reqKabupaten= $set->getField("KABUPATEN_ID");

$reqKecamatan= $set->getField("KECAMATAN_ID");

$reqKelurahan= $set->getField("KELURAHAN_ID");

$reqStatusHidup= $set->getField("STATUS_HIDUP"); $vStatusHidup= checkwarna($reqPerubahanData, 'STATUS_HIDUP', $arrstatushdp, array("id", "text"), $reqTempValidasiHapusId);

$reqStatusSdr= $set->getField("STATUS_SDR"); $vStatusSdr= checkwarna($reqPerubahanData, 'STATUS_SDR', $arrstatussdr, array("id", "text"), $reqTempValidasiHapusId);

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
            <label for="reqNama">
              Nama
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
            <input type="text" id="reqNama" name="reqNama" <?=$read?> value="<?=$reqNama?>" title="Nama harus diisi" class="form-control <?=$warnaclass?> required" />
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqTmpLahir">
              Tmp. Lahir
              <?
              $warnadata= $vTmpLahir['data'];
              $warnaclass= $vTmpLahir['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text" id="reqTmpLahir" name="reqTmpLahir" <?=$read?> value="<?=$reqTmpLahir?>" <?php /*?>title="Tempat lahir harus diisi" class="required"<?php */?> />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqTglLahir">
              Tgl. Lahir  
              <?
              $warnadata= $vTglLahir['data'];
              $warnaclass= $vTglLahir['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTglLahir" id="reqTglLahir"  value="<?=$reqTglLahir?>" maxlength="10" onKeyDown="return format_date(event,'reqTglLahir');"/>
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqStatusSdr">
              Status
              <?
              $warnadata= $vStatusSdr['data'];
              $warnaclass= $vStatusSdr['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqStatusSdr" id="reqStatusSdr">
              <option value=""></option>
                <?
                foreach ($arrstatussdr as $key => $value)
                {
                  $optionid= $value["id"];
                  $optiontext= $value["text"];
                  $optionselected= "";
                  if($reqStatusSdr == $optionid)
                    $optionselected= "selected";
                ?>
                  <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
                }
                ?>
            </select>
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqJenisKelamin">
              L/P
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
              <option value=""></option>
              <?
              foreach ($arrjenkel as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
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

          <div class="col-md-6 mb-6">
            <label for="reqStatusHidup">
              Status Aktif
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
              <option value=""></option>
              <?
              foreach ($arrstatushdp as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqStatusHidup == $optionid)
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
          <div class="col-md-6 mb-6">
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
            <input class="form-control <?=$warnaclass?>" type="text" id="reqPekerjaan" name="reqPekerjaan" <?=$read?> value="<?=$reqPekerjaan?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqPropinsi">
              Propinsi
              <?
              $warnadata= $vPropinsi['data'];
              $warnaclass= $vPropinsi['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> name="reqPropinsi" id="reqPropinsi">
              <option value=""></option>

            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
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
            <textarea <?=$disabled?> name="reqAlamat" id="reqAlamat" class="form-control <?=$warnaclass?> materialize-textarea"><?=$reqAlamat?></textarea>
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqKabupaten">
              Kabupaten
              <?
              $warnadata= $vKabupaten['data'];
              $warnaclass= $vKabupaten['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> id="reqKabupaten" name="reqKabupaten">
              <option value=""></option>

            </select>
          </div>
        </div>

        <div class="clearfix"></div><br/>

        <div class="form-row">
          <div class="col-md-3 mb-3">
            <label for="reqKodePos">
              Kode Pos
              <?
              $warnadata= $vKodePos['data'];
              $warnaclass= $vKodePos['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?>" type="text"  name="reqKodePos" id="reqKodePos" <?=$read?> value="<?=$reqKodePos?>" />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqTelepon">
              Telepon 
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
            <input class="form-control <?=$warnaclass?>" type="text"  name="reqTelepon" id="reqTelepon" <?=$read?> value="<?=$reqTelepon?>" />
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqKecamatan">
              Kecamatan
              <?
              $warnadata= $vKecamatan['data'];
              $warnaclass= $vKecamatan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> id="reqKecamatan" name="reqKecamatan">
              <option value=""></option>

            </select>
          </div>

          <div class="col-md-3 mb-3">
            <label for="reqKelurahan">
              Kelurahan
              <?
              $warnadata= $vKelurahan['data'];
              $warnaclass= $vKelurahan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" <?=$disabled?> id="reqKelurahan" name="reqKelurahan">
              <option value=""></option>

            </select>
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
              <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'saudara', '', '<?=$linkfilenamekembali?>')">Batal</button>
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