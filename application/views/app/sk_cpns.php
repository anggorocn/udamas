<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"sk_pns"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//


$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$sessPersonalToken= $this->PERSONAL_TOKEN;
$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));
$arrdataField= [];
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Sk_cpns_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
while($set->nextRow())
{
$reqRowId= $set->getField('SK_CPNS_ID');
$reqNoNotaBakn= $set->getField('NO_NOTA');
$reqTanggalNotaBakn= dateToPageCheck($set->getField('TANGGAL_NOTA'));
$reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');
$reqPejabatPenetap= $set->getField('PEJABAT_PENETAP');

$reqNamaPejabatPenetap= $set->getField('NAMA_PENETAP');
$reqNipPejabatPenetap= $set->getField('NIP_PENETAP');
$reqNoSuratKeputusan= $set->getField('NO_SK');
$reqTanggalSuratKeputusan= dateToPageCheck($set->getField('TANGGAL_SK'));
$reqTerhitungMulaiTanggal= dateToPageCheck($set->getField('TMT_CPNS'));
$reqGolRuang= $set->getField('PANGKAT_ID');
$reqPangkatNama= $set->getField('PANGKAT_KODE');
$reqTanggalTugas= dateToPageCheck($set->getField('TANGGAL_TUGAS'));
$reqTh= $set->getField('MASA_KERJA_TAHUN');
$reqBl= $set->getField('MASA_KERJA_BULAN');

$reqGajiPokok= $set->getField('GAJI_POKOK');
$reqTanggalPersetujuanNip= dateToPageCheck($set->getField("TANGGAL_PERSETUJUAN_NIP"));
$reqNoPersetujuanNip= $set->getField("NO_PERSETUJUAN_NIP");
$reqPendidikan= $set->getField("PENDIDIKAN_NAMA");
$reqJurusan= $set->getField("PENDIDIKAN_JURUSAN_NAMA");

$reqFormasiCpnsId= $set->getField("FORMASI_CPNS_ID");
$reqJabatanTugas= $set->getField("JABATAN_TUGAS");

$reqJenisFormasiTugasId= $set->getField("JENIS_FORMASI_TUGAS_ID");
$reqJabatanFuId= $set->getField("JABATAN_FU_ID");
$reqJabatanFtId= $set->getField("JABATAN_FT_ID");
$reqStatusSkCpns= $set->getField("STATUS_SK_CPNS");
$reqSpmtNomor= $set->getField("SPMT_NOMOR");
$reqSpmtTanggal= dateToPageCheck($set->getField("SPMT_TANGGAL"));
$reqSpmtTmt= dateToPageCheck($set->getField("SPMT_TMT"));

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("SK_CPNS_ID");


$vNoSuratKeputusan= checkwarna($reqPerubahanData, 'NO_SK');


}  

$arrPangkat= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "pangkat", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("PANGKAT_ID");
  $arrdata["text"]= $set->getField("KODE");
  array_push($arrPangkat, $arrdata);
}

$arrFormasiCPNS= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "formasicpns", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("FORMASI_CPNS_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrFormasiCPNS, $arrdata);
}

if($reqRowId == ""){
  $reqMode = "insert";
}
else
{
  $reqMode = "update";
}


$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || (!empty($reqTempValidasiHapusId)) && $reqId !== "baru"))
{
  $buttonsimpan= "";
}




$riwayattable= "PANGKAT_RIWAYAT";
$reqDokumenKategoriFileId= "1"; // ambil dari table KATEGORI_FILE, cek sesuai mode
$arrsetriwayatfield= $set->selectby($sessPersonalToken, "setriwayatfield", ["riwayattable"=>$riwayattable], "", "json");

// print_r($arrsetriwayatfield);exit;

$arrlistriwayatfilepegawai= $set->selectby($sessPersonalToken, "listpilihfilepegawai", ["riwayattable"=>$riwayattable, "reqId"=>$reqId, "reqRowId"=>$fileRowId, "reqTempValidasiId"=>$reqRowId], "", "file");
// print_r($arrlistriwayatfilepegawai);exit;

$reqDokumenPilih= $arrlistriwayatfilepegawai["reqDokumenPilih"];
$arrlistpilihfilefield= $arrlistriwayatfilepegawai["arrlistpilihfilefield"];
// print_r($reqDokumenPilih);exit;
// print_r($arrlistpilihfilefield);exit;

$arrkualitasfile= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "kualitasfile", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["ID"]= $set->getField("KUALITAS_FILE_ID");
  $arrdata["TEXT"]= $set->getField("NAMA");
  array_push($arrkualitasfile, $arrdata);
}


$tipekondisikategori= $set->selectby($sessPersonalToken, "kondisikategori", [], "", "json");
// print_r(kondisikategori($tipekondisikategori, "1"));
$arrpilihfiledokumen= $set->selectby($sessPersonalToken, "pilihfiledokumen", [], "", "json");


?>
<!-- AUTO KOMPLIT -->
  <link rel="stylesheet" href="assets/autokomplit/jquery-ui.css">
  <script src="assets/autokomplit/jquery-ui.js"></script>
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
        url:"api/sk_cpns_json/add"
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
 
</script>
<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1><?=$linkfilenamelabel?></h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <a href="javascript:void(0)" style="text-decoration: none;">
          <span>Halaman data monitoring</span>
        </a>
      </h6>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Data <?=$linkfilenamelabel?></div>

      <form class="needs-validation form-horizontal" id="ff" method="post" novalidate enctype="multipart/form-data">
        
       
        <div class="form-group">
          <label class="control-label col-sm-2" for="">No. Surat Keputusan
           <?
           $warnadata= $vNoSuratKeputusan['data'];
           $warnaclass= $vNoSuratKeputusan['warna'];
           if(!empty($warnadata))
           {
            ?>
            <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
            <?
          }
        ?>:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox <?=$warnaclass?>" id="reqNoSuratKeputusan" name="reqNoSuratKeputusan"  required placeholder="Isikan No. Surat Keputusan" value="<?=$reqNoSuratKeputusan?>">
          </div>

          <label class="control-label col-sm-2" for="">Tanggal Surat Keputusan</label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqTanggalSuratKeputusan" onKeyDown="return format_date(event,'reqTanggalSuratKeputusan');" name="reqTanggalSuratKeputusan"  placeholder="Isikan Tanggal Surat Keputusan" value="<?=$reqTanggalSuratKeputusan?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">No. Nota BAKN:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox" id="reqNoNotaBakn" name="reqNoNotaBakn" placeholder="Isikan No. Nota BAKN" value="<?=$reqNoNotaBakn?>">
          </div>

          <label class="control-label col-sm-2" for="">Tanggal Nota BAKN</label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqTanggalNotaBakn" onKeyDown="return format_date(event,'reqTanggalNotaBakn');" name="reqTanggalNotaBakn"  placeholder="Isikan Tanggal Nota BAKN" value="<?=$reqTanggalNotaBakn?>">
          </div>
        </div>

           <div class="form-group">
          <label class="control-label col-sm-2" for="">No. Persetujuan NIP:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox" id="reqNoPersetujuanNip" name="reqNoPersetujuanNip" placeholder="Isikan No. Persetujuan NIP" value="<?=$reqNoPersetujuanNip?>">
          </div>

          <label class="control-label col-sm-2" for="">Tanggal Persetujuan NIP</label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqTanggalPersetujuanNip" onKeyDown="return format_date(event,'reqTanggalPersetujuanNip');" name="reqTanggalPersetujuanNip"  placeholder="Isikan Tanggal Persetujuan NIP" value="<?=$reqTanggalPersetujuanNip?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Gol/Ruang: </label>
          <div class="col-sm-4">
             <select id="reqGolRuang" name="reqGolRuang" class="form-control "   >
              <option value="" <? if($reqGolRuang=="") echo 'selected';?>></option>
              <?
              foreach ($arrPangkat as $key => $value)
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
          <label class="control-label col-sm-2" for="">Terhitung Mulai Tanggal: </label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqTerhitungMulaiTanggal" onKeyDown="return format_date(event,'reqTerhitungMulaiTanggal');" name="reqTerhitungMulaiTanggal"  placeholder="Isikan Terhitung Mulai Tanggal" value="<?=$reqTerhitungMulaiTanggal?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Masa Kerja Tahun:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control easyui-validatebox" id="reqTh" name="reqTh" placeholder="Isikan Masa Kerja Tahun" value="<?=$reqTh?>">
          </div>
          <label class="control-label col-sm-2" for="">Masa Kerja Bulan</label>
          <div class="col-sm-2">
            <input type="text" class="form-control easyui-validatebox" id="reqBl" name="reqBl" placeholder="Isikan Masa Kerja Bulan" value="<?=$reqBl?>">
          </div>
          <label class="control-label col-sm-2" for="">Gaji Pokok (80%)</label>
          <div class="col-sm-2">
       
                <input type="text" class="form-control " id="reqGajiPokok" name="reqGajiPokok" OnFocus="FormatAngka('reqGajiPokok')" OnKeyUp="FormatUang('reqGajiPokok')" OnBlur="FormatUang('reqGajiPokok')" value="<?=numberToIna($reqGajiPokok)?>" placeholder="Isikan Gaji Pokok (80%)">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Jalur Pengadaan (Formasi):</label>
          <div class="col-sm-2">
           <select id="reqFormasiCpnsId" name="reqFormasiCpnsId" class="form-control "   >
              <option value="" <? if($reqFormasiCpnsId=="") echo 'selected';?>></option>
              <?
              foreach ($arrFormasiCPNS as $key => $value)
              {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqFormasiCpnsId == $optionid)
                  $optionselected= "selected";
                ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
              }
              ?>       
             </select>
          </div>
          <label class="control-label col-sm-2" for="">Pendidikan</label>
          <div class="col-sm-2">
            <input type="text" class="form-control easyui-validatebox" id="reqPendidikan" name="reqPendidikan" readonly placeholder="Isikan Pendidikan" value="<?=$reqPendidikan?>">
          </div>
          <label class="control-label col-sm-2" for="">Jurusan</label>
          <div class="col-sm-2">
            <input type="text" class="form-control easyui-validatebox" id="reqJurusan" name="reqJurusan" readonly placeholder="Isikan Jurusan" value="<?=$reqJurusan?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Jenis Formasi Tugas / Jab:</label>
          <div class="col-sm-4">
             <select  name="reqJenisFormasiTugasId" id="reqJenisFormasiTugasId" class="form-control">
              <option value="" <? if($reqJenisFormasiTugasId == "") echo 'selected';?>></option>
              <option value="1" <? if($reqJenisFormasiTugasId == "1") echo 'selected';?>>Pelaksana</option>
              <option value="2" <? if($reqJenisFormasiTugasId == "2") echo 'selected';?>>Fungsional Tertentu</option>
             </select>
          </div>

          <label class="control-label col-sm-2" for="">Tugas</label>
          <div class="col-sm-4">
               <input type="hidden" name="reqJabatanFuId" id="reqJabatanFuId" value="<?=$reqJabatanFuId?>" />
                    <input type="hidden" name="reqJabatanFtId" id="reqJabatanFtId" value="<?=$reqJabatanFtId?>" />
                    <input type="hidden" name="reqJabatanTugas" id="reqJabatanTugas" value="<?=$reqJabatanTugas?>" />
     
              <input type="text" class="form-control easyui-validatebox" id="reqJabatanTugas" name="reqJabatanTugas" placeholder="Isikan Tugas" value="<?=$reqJabatanTugas?>">
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for="">SK CPNS Kab Jombang?:</label>
          <div class="col-sm-4">
             <select  name="reqStatusSkCpns" id="reqStatusSkCpns" class="form-control">
               <option value="" <? if($reqStatusSkCpns == "") echo 'selected';?>></option>
               <option value="1" <? if($reqStatusSkCpns == "1") echo 'selected';?>>Ya</option>
               <option value="2" <? if($reqStatusSkCpns == "2") echo 'selected';?>>Tidak</option>
             </select>
          </div>

          <label class="control-label col-sm-2" for="">Pejabat Penetap</label>
          <div class="col-sm-4">
                  <input type="hidden" name="reqPejabatPenetapId" id="reqPejabatPenetapId" value="<?=$reqPejabatPenetapId?>" /> 
              <input type="text" class="form-control easyui-validatebox" id="reqPejabatPenetap" name="reqPejabatPenetap" placeholder="Isikan Pejabat Penetap" value="<?=$reqPejabatPenetap?>">
          </div>
        </div>

                 <div class="form-group">
          <label class="control-label col-sm-2" for="">No. SPMT:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control easyui-validatebox" id="reqNoSk" name="reqNoSk" placeholder="Isikan No. SK" value="<?=$reqNoSk?>">
          </div>
          <label class="control-label col-sm-2" for="">Tanggal SPMT</label>
          <div class="col-sm-2">
            <input type="text" class="form-control easyui-validatebox" id="reqNoSk" name="reqNoSk" placeholder="Isikan No. SK" value="<?=$reqNoSk?>">
          </div>
          <label class="control-label col-sm-2" for="">TMT SPMT</label>
          <div class="col-sm-2">
            <input type="text" class="form-control easyui-validatebox" id="reqNoSk" name="reqNoSk" placeholder="Isikan No. SK" value="<?=$reqNoSk?>">
          </div>
        </div>
        <input type="hidden"  name="reqTipePegawaiId" value="<?=$reqTipePegawaiId?>" />
        <input type="hidden" name="reqId" value="<?=$reqId?>" />
        <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
        <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>" />
        <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
          <?
              if(strtoupper($vaksesmenu) == strtoupper("A"))
            {
            ?>
           <?
            if(!empty($buttonsimpan))
            {
            ?>
              <button class="btn btn-primary"  id="simpan" type="submit">Simpan</button>
            <?
              if(!empty($reqTempValidasiId))
              {
            ?>
              <!-- <button class="btn btn-danger" type="button" onclick="hapusdata('<?=$reqTempValidasiId?>', 'diklat_kursus', '', '<?=$linkfilenamekembali?>')">Batal</button> -->
            <?
              }
            }
          }
            ?>
           <!--  <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='document.location.href="app/index/<?=$linkfilenamekembali?>"' type="button">Kembali</button> -->

             <?
        // area untuk upload file
        ?>
        <div class="row"><div class="col-md-12"><br/></div></div>
        <div class="row">
          <div class="col-md-12">
          <?
          foreach ($arrsetriwayatfield as $key => $value)
          {
            $riwayatfield= $value["riwayatfield"];
            $riwayatfieldtipe= $value["riwayatfieldtipe"];
            $riwayatfieldinfo= $value["riwayatfieldinfo"];
            $riwayatfieldstyle= $value["riwayatfieldstyle"];
            // echo $riwayatfieldstyle;exit;
          ?>
            <button class="btn btn-info" style="font-size:9pt;<?=$riwayatfieldstyle?>" type="button" id='buttonframepdf<?=$riwayatfield?>'>
              <input type="hidden" id="labelvpdf<?=$riwayatfield?>" value="<?=$riwayatfieldinfo?>" />
              <span id="labelframepdf<?=$riwayatfield?>"><?=$riwayatfieldinfo?></span>
            </button>
          <?
          }
          ?>
          </div>
        </div>
        <div class="row"><div class="col-md-12"><br/></div></div>

        <?
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
        <div class="row">
          <div class="input-field col-md-4">
            <input type="hidden" id="reqDokumenRequired<?=$riwayatfield?>" name="reqDokumenRequired[]" value="<?=$riwayatfieldrequired?>" />
            <input type="hidden" id="reqDokumenRequiredNama<?=$riwayatfield?>" name="reqDokumenRequiredNama[]" value="<?=$vriwayatfieldinfo?>" />
            <input type="hidden" id="reqDokumenRequiredTable<?=$riwayatfield?>" name="reqDokumenRequiredTable[]" value="<?=$vriwayattable?>" />
            <input type="hidden" id="reqDokumenRequiredTableRow<?=$riwayatfield?>" name="reqDokumenRequiredTableRow[]" value="<?=$vpegawairowfile?>" />
            <input type="hidden" id="reqDokumenFileId<?=$riwayatfield?>" name="reqDokumenFileId[]" />
            <input type="hidden" id="reqDokumenKategoriFileId<?=$riwayatfield?>" name="reqDokumenKategoriFileId[]" value="<?=$reqDokumenKategoriFileId?>" />
            <input type="hidden" id="reqDokumenKategoriField<?=$riwayatfield?>" name="reqDokumenKategoriField[]" value="<?=$riwayatfield?>" />
            <input type="hidden" id="reqDokumenPath<?=$riwayatfield?>" name="reqDokumenPath[]" value="" />
            <input type="hidden" id="reqDokumenTipe<?=$riwayatfield?>" name="reqDokumenTipe[]" value="<?=$riwayatfieldtipe?>" />

            <label for="reqDokumenPilih<?=$riwayatfield?>">
              File Dokumen<?=$riwayatfieldinfo?>
              <span id="riwayatfieldrequiredinfo<?=$riwayatfield?>" style="color: red;"><?=$riwayatfieldrequiredinfo?></span>
            </label>
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

          <div class="input-field col-md-4">
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
                $arrkecualitipe= kondisikategori($tipekondisikategori, $riwayatfieldtipe);
                if(!in_array($optionid, $arrkecualitipe))
                  continue;
              ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
              <?
              }
              ?>
            </select>
             
          </div>

          <div id="labeldokumenfileupload<?=$riwayatfield?>" class="input-field col-md-4" style="margin-top: -25px; margin-bottom: 10px;">
            <div class="file_input_div">
              <div class="file_input input-field col s12 m4">
                <label class="labelupload">
                  <i class="mdi-file-file-upload" style="font-family: Roboto,sans-serif,Material-Design-Icons !important; font-size: 14px !important;">Upload</i>
                  <input id="file_input_file" name="reqLinkFile[]" class="none" type="file" />
                </label>
              </div>
              <div id="file_input_text_div" class=" input-field col s12 m8">
                <input class="file_input_text" type="text" disabled readonly id="file_input_text" />
                <label for="file_input_text"></label>
              </div>
            </div>
          </div>

          <div id="labeldokumendarifileupload<?=$riwayatfield?>" class="input-field col-md-4">
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

          </div>


        </div>
         
      

      </form>
    </div>
    
  </div>
</div>

<div style="display: none;">
  <button id="klikbuttoniframe" type="button" data-toggle="modal" data-target="#iframedetil" class="btn btn-primary"></button>
</div>
<div id="iframedetil" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="row">
        <div class="col-md-12">
          
          <div class="area-panel">
            <div class="judul-panel">Riwayat E-File</div>
            <div class="inner inner-pdf">
              <!-- <iframe id="infonewframe" style="width: 100%; height: 800px" src="http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf"></iframe> -->
              <input type="hidden" id="labelglobalvpdf" />
              <object id="infonewframe" data="" type="application/pdf" width="100%" height="800px">
               </object>
             </div>

           </div>
         </div>
       </div>

    </div>
  </div>
</div>




<script type="text/javascript">
// untuk area untuk upload file
vbase_url= "<?=base_url()?>";
getarrlistpilihfilefield= JSON.parse('<?=JSON_encode($arrlistpilihfilefield)?>');
vlinkurlapi= "http://192.168.88.100/jombang/siapasn/";
// console.log(getarrlistpilihfilefield);

$(document).ready( function () {

  /*$("#klikbuttoniframe").click();
  vurl= "http://192.168.88.100/jombang/siapasn/uploads/8300/rcMxO0Jlrz.pdf?SK_JABATAN_01092017_198305022011011001.pdf";
  $('#infonewframe').attr('data', vurl);*/

  $('[id^="buttonframepdf"]').click(function(){
    infoid= $(this).attr('id');
    infoid= infoid.replace("buttonframepdf", "");
    buttonframepdf(infoid);
  });

  $('#iframedetil').on('hidden.bs.modal', function () {
    infoid= $("#labelglobalvpdf").val();
    labelvpdf= $("#labelvpdf"+infoid).val();
    $("#labelframepdf"+infoid).text(labelvpdf);
    $("#vnewframe").val("");
  })

  function isgambar(vext)
  {
    vreturn= "";
    if(vext == "jpg")
        {
          vreturn= "1";
        }

        return vreturn;
  }

  // validasi jquery batas file
  $("input[type='file']").on("change", function () {
    // console.log("asd"+this.files[0].size);
    if(this.files[0].size > 2000000) {
      mbox.alert("check file upload harus di bawah 2 MB", {open_speed: 0});
      $(this).val('');
    }

    // if (window.parent && window.parent.document)
    // {
    //   if (typeof window.parent.iframeLoaded === 'function')
    //   {
    //     parent.iframeLoaded();
    //   }
    // }
  });

  // set foto default
  if(typeof getarrlistpilihfilefield == "undefined"){}
  else
  {
    arrdefaultfoto= getarrlistpilihfilefield["foto"];
    if(Array.isArray(arrdefaultfoto) && arrdefaultfoto.length)
    {
      varrdefaultfoto= arrdefaultfoto.filter(item => item.selected === "selected");
      // console.log(varrdefaultfoto);

      if(Array.isArray(varrdefaultfoto) && varrdefaultfoto.length)
      {
        vurl= varrdefaultfoto[0]["vurl"];
        vurl= vurl.replace("../", "");
        vext= varrdefaultfoto[0]["ext"];
        if(isgambar(vext) == "1")
        {
          $("#infoimage").attr("src", vurl);
        }
      }
    }
  }

  function buttonframepdf(infoid) {
    $('[id^="buttonframepdf"]').hide();

    reqDokumenIndexId= $("#reqDokumenIndexId"+infoid+" option:selected").val();
    if(typeof getarrlistpilihfilefield == "undefined"){}
    else
    {
      getarrlistpilihfilepegawai= getarrlistpilihfilefield[infoid];
      // console.log(getarrlistpilihfilepegawai);return false;

      if(Array.isArray(getarrlistpilihfilepegawai) && getarrlistpilihfilepegawai.length)
      {
        varrlistpilihfilepegawai= getarrlistpilihfilepegawai.filter(item => item.index === reqDokumenIndexId);
        // console.log(varrlistpilihfilepegawai);return false;

        vurl= varrlistpilihfilepegawai[0]["vurl"];
        vurl= vurl.replace("../", "");
        vext= varrlistpilihfilepegawai[0]["ext"];

        $("#vnewframe").val(infoid);

        labelvpdf= $("#labelvpdf"+infoid).val();
        $("#labelframepdf"+infoid).text("Tutup " + labelvpdf);
        $("#labelglobalvpdf").val(infoid);
        $("#buttonframepdf"+infoid).show();

        $("#infonewimage, #infonewframe").hide();
        if(isgambar(vext) == "1")
        {
          $("#infonewimage").show();
          $("#infonewimage").attr("src", vurl);
          // console.log(varrlistpilihfilepegawai);
        }
        else
        {
          $("#infonewframe").show();
          var infonewframe= $('#infonewframe');
          vnewframe= $("#vnewframe").val();
          if(vnewframe == ""){}
          else
          {
            infourl= vlinkurlapi+vurl;
            // console.log(infourl);
            infonewframe.attr('data', infourl);
            $("#klikbuttoniframe").click();
          }
        }
      }

    }

  }

  $('[id^="buttonframepdf"]').each(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("buttonframepdf", "");

    setdokumenpilih(vinfoid, "");
  });
      
  $('[id^="reqDokumenPilih"]').change(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("reqDokumenPilih", "");
    setdokumenpilih(vinfoid, "data");
  });

  $('[id^="reqDokumenIndexId"]').change(function(){
    vinfoid= $(this).attr('id');
    vinfoid= vinfoid.replace("reqDokumenIndexId", "");
    setinfonewframe(vinfoid, "data");
  });

  function setdokumenpilih(vinfoid, infomode)
  {
    reqDokumenPilih= $("#reqDokumenPilih"+vinfoid).val();

    if(infomode == ""){}
    else
    {
      $("#reqDokumenFileKualitasId"+vinfoid).val("");

      if(vselectmaterial == "1")
      {
        $("#reqDokumenFileKualitasId"+vinfoid).material_select();
      }
    }

    $("#buttonframepdf"+vinfoid+", #labeldokumenfileupload"+vinfoid+", #labeldokumendarifileupload"+vinfoid).hide();
    if(reqDokumenPilih == "1")
    {
      $("#reqDokumenFileId"+vinfoid).val("");
      $("#labeldokumenfileupload"+vinfoid).show();
    }
    else if(reqDokumenPilih == "2")
    {
      $("#labeldokumendarifileupload"+vinfoid).show();
      $("#buttonframepdf"+vinfoid).show();
      setinfonewframe(vinfoid, infomode);
    }
  }

  function setinfonewframe(vinfoid, infomode)
  {
    reqDokumenIndexId= $("#reqDokumenIndexId"+vinfoid).val();

    infoid= reqDokumenIndexId;
    // console.log(infoid+"-"+vinfoid);
    if(typeof getarrlistpilihfilefield == "undefined"){}
    else
    {
      getarrlistpilihfilepegawai= getarrlistpilihfilefield[vinfoid];
      // console.log(getarrlistpilihfilepegawai);

      if(Array.isArray(getarrlistpilihfilepegawai) && getarrlistpilihfilepegawai.length)
      {
        varrlistpilihfilepegawai= getarrlistpilihfilepegawai.filter(item => item.index === infoid);
        // console.log(varrlistpilihfilepegawai);

        if(Array.isArray(varrlistpilihfilepegawai) && varrlistpilihfilepegawai.length)
        {
          vurl= varrlistpilihfilepegawai[0]["vurl"];
          vurl= vurl.replace("../", "");
          vext= varrlistpilihfilepegawai[0]["ext"];
          reqDokumenFileId= varrlistpilihfilepegawai[0]["id"];
          reqDokumenFileKualitasId= varrlistpilihfilepegawai[0]["filekualitasid"];
          // reqDokumenFileRiwayatId= varrlistpilihfilepegawai[0]["inforiwayatid"];

          // console.log(reqDokumenFileId);
          if(vurl == ""){}
          else
          {
            // console.log(varrlistpilihfilepegawai);
            $("#reqDokumenFileId"+vinfoid).val(reqDokumenFileId);
            $("#reqDokumenPath"+vinfoid).val(vurl);
            $("#reqDokumenFileKualitasId"+vinfoid).val(reqDokumenFileKualitasId);
            // $("#reqDokumenFileRiwayatId"+vinfoid).val(reqDokumenFileRiwayatId);

            if(infomode == ""){}
            else
            {
              $("#infonewimage, #infonewframe").hide();
              if(isgambar(vext) == "1")
              {
                $("#infonewimage").show();
                $("#infonewimage").attr("src", vurl);
                // console.log(varrlistpilihfilepegawai);
              }
              else
              {
                $("#infonewframe").show();
                var infonewframe= $('#infonewframe');
                vnewframe= $("#vnewframe").val();
                if(vnewframe == ""){}
                else
                {
                  infourl= vlinkurlapi+vurl;
                  // console.log(infourl);
                  infonewframe.attr('data', infourl);
                  $("#klikbuttoniframe").click();
                }
              }

            }
          }

        }

      }
    }
  }

});

function copytoclipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
</script>
