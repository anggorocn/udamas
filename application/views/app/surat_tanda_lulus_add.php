<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"surat_tanda_lulus"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//
$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");


// pakem data validasi
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Surat_tanda_lulus_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// print_r($set);
// echo $set->query;exit;
$set->firstRow();

  $reqTglStlud= dateToPageCheck($set->getField('TANGGAL_STLUD'));
  $reqTanggalMulai= dateToPageCheck($set->getField('TANGGAL_MULAI'));
  $reqTanggalAkhir= dateToPageCheck($set->getField('TANGGAL_AKHIR'));
  $reqJenisId= $set->getField('JENIS_ID');
  $reqNoStlud= $set->getField('NO_STLUD');
  

  $reqPendidikanRiwayatId= $set->getField('PENDIDIKAN_RIWAYAT_ID');
  // echo $reqPendidikanRiwayatId;exit();
  $reqPendidikanId= $set->getField('PENDIDIKAN_ID');
  $reqNilaiNpr= dotToComma($set->getField('NILAI_NPR'));
  $reqNilaiNt= dotToComma($set->getField('NILAI_NT'));
  $LastLevel= $set->getField('LAST_LEVEL');



$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("SURAT_TANDA_LULUS_ID");


$vNoStlud= checkwarna($reqPerubahanData, 'NO_STLUD');
$vTglStlud= checkwarna($reqPerubahanData, 'TANGGAL_STLUD', [date]);
$vTanggalMulai= checkwarna($reqPerubahanData, 'TANGGAL_MULAI', [date]);
$vTanggalAkhir= checkwarna($reqPerubahanData, 'TANGGAL_AKHIR', [date]);
$vNilaiNpr= checkwarna($reqPerubahanData, 'NILAI_NPR');
$vNilaiNt= checkwarna($reqPerubahanData, 'NILAI_NT');
$vJenisId= checkwarna($reqPerubahanData, 'JENIS_ID');


// print_r($reqPerubahanData);exit;
$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
// $reqRowId= $set->getField('PANGKAT_RIWAYAT_ID');

// $reqNoDiklatPrajabatan = $set->getField('PEJABAT_PENETAP_ID');


/*if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}*/
?>

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
            <label for="reqPejabatPenetap">Surat Tanda Lulus 
              <?
              $arrDataText[1]='STL Ujian Dinas I';
              $arrDataText[2]='STL Ujian Dinas II';
              $arrDataText[3]='STL Ujian Kenaikan Pangkat Penyesuaian Ijazah SMA';
              $arrDataText[4]='STL Ujian Kenaikan Pangkat Penyesuaian Ijazah D-4/S-1';
              $arrDataText[5]='STL Ujian Kenaikan Pangkat Penyesuaian Ijazah S-2';
              $warnadata=  $arrDataText[$vJenisId['data']];
              $warnaclass= $vJenisId['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            :</label>
           
             <select name="reqJenisId" id="reqJenisId" class="form-control <?=$warnaclass?>" >
                    <option value="" <? if($reqJenisId == "") echo 'selected'?>></option>
                    <option value="1" <? if($reqJenisId == 1) echo 'selected'?>>STL Ujian Dinas I</option>
                    <option value="2" <? if($reqJenisId == 2) echo 'selected'?>>STL Ujian Dinas II</option>
                    <option value="3" <? if($reqJenisId == 3) echo 'selected'?>>STL Ujian Kenaikan Pangkat Penyesuaian Ijazah SMA</option>
                    <option value="4" <? if($reqJenisId == 4) echo 'selected'?>>STL Ujian Kenaikan Pangkat Penyesuaian Ijazah D-4/S-1</option>
                    <option value="5" <? if($reqJenisId == 5) echo 'selected'?>>STL Ujian Kenaikan Pangkat Penyesuaian Ijazah S-2</option>
                  </select>

          
          </div>
        </div>
         <div class="clearfix"></div><br/>
        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqNoPelantikan"> No STL 
            <?
              $warnadata= $vNoStlud['data'];
              $warnaclass= $vNoStlud['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
            <input type="text" class="form-control  <?=$warnaclass?> "  placeholder="Isikan No STL"  id="reqNoStlud" name="reqNoStlud" value="<?=$reqNoStlud?>" />
          </div>

          <div class="col-md-2 mb-6">
            <label for="reqTanggalPelantikan"> Tgl STL 
             <?
              $warnadata= $vTglStlud['data'];
              $warnaclass= $vTglStlud['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
            <input class="form-control  easyui-validatebox formattanggalnew <?=$warnaclass?>"  type="text" name="reqTglStlud" id="reqTglStlud"  value="<?=$reqTglStlud?>" maxlength="10" onKeyDown="return format_date(event,'reqTglStlud');" placeholder="Isikan Tgl STL"  />
          </div>
        </div>
       <div class="clearfix"></div><br/>
          <div class="form-row">
          <div class="col-md-2 mb-6">
            <label for="reqNoPelantikan"> Tanggal Mulai 
             <?
              $warnadata= $vTanggalMulai['data'];
              $warnaclass= $vTanggalMulai['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
            <input type="text" class="form-control  easyui-validatebox formattanggalnew <?=$warnaclass?>"  id="reqTanggalMulai" name="reqTanggalMulai" <?=$disabled?> value="<?=$reqTanggalMulai?>" placeholder="Isikan Tanggal Mulai"  maxlength="10" onKeyDown="return format_date(event,'reqTanggalMulai');"/>
          </div>

          <div class="col-md-2 mb-6">
            <label for="reqTanggalPelantikan"> Tanggal Akhir  
              <?
              $warnadata= $vTanggalAkhir['data'];
              $warnaclass= $vTanggalAkhir['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
            <input class="form-control  easyui-validatebox formattanggalnew <?=$warnaclass?>"  type="text" name="reqTanggalAkhir" id="reqTanggalAkhir"  value="<?=$reqTanggalAkhir?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalAkhir');"
            placeholder="Isikan Tanggal Akhir"
            />
          </div>
        </div>
       <div class="clearfix"></div><br/>
          <div class="form-row">
          <div class="col-md-3 mb-6">
            <label for="reqNoPelantikan">Nilai Persentasi (NPR) 
              <?
              $warnadata= $vNilaiNpr['data'];
              $warnaclass= $vNilaiNpr['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            : </label>
            <input type="text" class="form-control  easyui-validatebox <?= $warnaclass?>"  id="reqNilaiNpr" name="reqNilaiNpr" <?=$disabled?> value="<?=$reqNilaiNpr?>" onkeypress='kreditvalidate(event, this)'  placeholder="Isikan Nilai Persentasi (NPR)" />
          </div>

          <div class="col-md-3 mb-6">
            <label for="reqTanggalPelantikan"> Nilai Terbilang (NT) 
              <?
              $warnadata= $vNilaiNt['data'];
              $warnaclass= $vNilaiNt['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            :</label>
             <input type="text" class="form-control  easyui-validatebox <?=$warnaclass?>"  id="reqNilaiNt" name="reqNilaiNt" <?=$disabled?> value="<?=$reqNilaiNt?>" onkeypress='kreditvalidate(event, this)' placeholder="Isikan Nilai Terbilang (NT)"/>
          </div>
        </div>
       <div class="clearfix"></div><br/>
         <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqPejabatPenetap">
            Pendidikan
             
            </label>
           
             <input type="hidden" name="reqPendidikanRiwayatId" id="reqPendidikanRiwayatId" value="<?=$reqPendidikanRiwayatId?>" />
                    <input type="hidden" name="reqPendidikanId" id="reqPendidikanId" value="<?=$reqPendidikanId?>" />
                    <select id="reqPendidikan" class="form-control"></select>
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
        ?>
            if(!empty($buttonsimpan))
            {
            ?>
              <button class="btn btn-primary" type="submit">Simpan</button>
            <?
              if(!empty($reqTempValidasiId))
              {
            ?>
              <!-- <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'pangkat_riwayat', '', '<?=$linkfilenamekembali?>')">Batal</button> -->
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
  $(function(){
    $("#reqJenisId").change(function() { 
    var reqJenisId= "";
    reqJenisId= $("#reqJenisId").val();

    if(reqJenisId == 3 || reqJenisId == 4 || reqJenisId == 5)
    {
      setpendidikan();
      setinfopendidikan();
    }
    else
    {
      $("#reqinfopendidikan").hide();
      $("#reqPendidikanRiwayatId, #reqPendidikanId").val("");
      $("#reqPendidikan option").remove();
      // $("#reqPendidikan").material_select();
    }

  });

  $("#reqPendidikan").change(function() { 
    var reqPendidikan= reqPendidikanRiwayatId= reqPendidikanId= "";
    reqPendidikan= $("#reqPendidikan").val();
    reqPendidikan= String(reqPendidikan);
    reqPendidikan= reqPendidikan.split('-');
    reqPendidikanRiwayatId= reqPendidikan[0];
    reqPendidikanId= reqPendidikan[1];

    $("#reqPendidikanRiwayatId").val(reqPendidikanRiwayatId);
    $("#reqPendidikanId").val(reqPendidikanId);
  });

  setinfopendidikan();

  <?
  if($reqPendidikanRiwayatId == ""){}
  else
  {
  ?>
  setpendidikan();
  <?
  }
  ?>
  });
</script>

<script type="text/javascript">
  function setinfopendidikan()
{
  var reqJenisId= "";
  reqJenisId= $("#reqJenisId").val();
  // alert(reqJenisId);
  if(reqJenisId == 3 || reqJenisId == 4 || reqJenisId == 5)
  {
    $("#reqinfopendidikan").show();
  }
  else
  {
    $("#reqPendidikanRiwayatId, #reqPendidikanId").val("");
    $("#reqPendidikan option").remove();
    // $("#reqPendidikan").material_select();
    $("#reqinfopendidikan").hide();
  }
}

function setpendidikan()
{
    var reqJenisId= reqJenisPendidikanId= "";
    reqJenisId= $("#reqJenisId").val();
    // alert(reqJenisId);

    if(reqJenisId == 3)
    {
      reqJenisPendidikanId= "4";
    }
    else if(reqJenisId == 4)
    {
      reqJenisPendidikanId= "10,11";
    }
    else if(reqJenisId == 5)
    {
      reqJenisPendidikanId= "12";
    }

    $("#reqPendidikan option").remove();
    // $("#reqPendidikan").material_select();

    $("<option value=''></option>").appendTo("#reqPendidikan");
    $.ajax({'url': "api/combo/pendidikanpppk/?reqId="+reqJenisPendidikanId,'success': function(dataJson) {
      var data= JSON.parse(dataJson);
     

      var items = "";
      items += "<option></option>";
      $.each(data, function (i, SingleElement) {

        <?
        if($reqPendidikanRiwayatId == "")
        {
        ?>
          items += "<option value='" + SingleElement.id + "'>" + SingleElement.label + "</option>";
        <?
        }
        else
        {
        ?>
          if('<?=$reqPendidikanRiwayatId?>-<?=$reqPendidikanId?>' == SingleElement.id)
          items += "<option value='" + SingleElement.id + "' selected>" + SingleElement.label + "</option>";
          else
          items += "<option value='" + SingleElement.id + "'>" + SingleElement.label + "</option>";
        <?
        }
        ?>

      });
      $("#reqPendidikan").html(items);
      // $("#reqPendidikan").material_select();
    }});

}
</script>
<script type="text/javascript">
  $(document).on('submit', '#ff', function(){
      var dataform = $('#ff')[0];
    var formData = new FormData(dataform); 
      $.ajax({
        url:"api/Surat_tanda_lulus_json/add"
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
                  // window.location.reload();
                  return;
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
</script>