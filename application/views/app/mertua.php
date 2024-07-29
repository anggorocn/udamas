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
$reqTipeKursus= $set->getField('TIPE_KURSUS_ID'); $vTipeKursus= checkwarna($reqPerubahanData, 'TIPE_KURSUS_ID', $arrtipekursus, array("id", "text"), $reqTempValidasiHapusId);
$reqJenisKursus= $set->getField('JENIS_KURSUS_NAMA');
$reqJenisKursusId= $set->getField('REF_JENIS_KURSUS_ID');
$reqJenisKursusData= $set->getField('REF_JENIS_KURSUS_DATA');
$reqTahun= $set->getField('TAHUN'); $vTahun= checkwarna($reqPerubahanData, 'TAHUN', [$reqTahun]);
$reqRefInstansiId = $set->getField('REF_INSTANSI_ID');
$reqRefInstansi= $set->getField('REF_INSTANSI_INFO'); $vRefInstansi= checkwarna($reqPerubahanData, 'REF_INSTANSI_NAMA');
$reqPenyelenggara = $set->getField('PENYELENGGARA'); $vPenyelenggara= checkwarna($reqPerubahanData, 'PENYELENGGARA');
$reqNamaKursus= $set->getField('NAMA'); $vNamaKursus= checkwarna($reqPerubahanData, 'NAMA');
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
    , onSelect: function() {
      settahun();
    }
  });

  $('#reqTglSelesai').keyup(function() {
    settahun();
  });

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
            <label for="reqNamaAyah">Nama Ayah</label>
              <input class="form-control" type="text" id="reqNamaAyah" name="reqNamaAyah" value="<?=$reqNamaAyah?>" class="required" title="Nama ayah harus diisi" />
              <input type="hidden"  name="reqIdAyah" value="<?=$reqIdAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqNamaIbu">Nama Ibu</label>
              <input class="form-control" type="text" id="reqNamaIbu" name="reqNamaIbu" value="<?=$reqNamaIbu?>" class="required" title="Nama ibu harus diisi"/>
              <input type="hidden"  name="reqIdIbu" value="<?=$reqIdIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqPekerjaanAyah">Pekerjaan Ayah</label>
            <input class="form-control" type="text" id="reqPekerjaanAyah" name="reqPekerjaanAyah" value="<?=$reqPekerjaanAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqPekerjaanIbu">Pekerjaan Ibu</label>
            <input class="form-control" type="text" id="reqPekerjaanIbu" name="reqPekerjaanIbu" value="<?=$reqPekerjaanIbu?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqAlamatAyah">Alamat Ayah</label>
            <textarea  name = "reqAlamatAyah" class="form-control materialize-textarea" id="reqAlamatAyah" value="<?=$reqAlamatAyah?>"><?=$reqAlamatAyah?></textarea>
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqAlamatIbu">Alamat Ibu</label>
            <textarea name = "reqAlamatIbu" id="reqAlamatIbu" class="form-control materialize-textarea" value="<?=$reqAlamatIbu?>"><?=$reqAlamatIbu?></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqTeleponAyah">Telepon Ayah</label>
            <input class="form-control" type="text" id="reqTeleponAyah" name="reqTeleponAyah" value="<?=$reqTeleponAyah?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTeleponIbu">Telepon Ibu</label>
            <input class="form-control" type="text" id="reqTeleponIbu" name="reqTeleponIbu" value="<?=$reqTeleponIbu?>" />
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