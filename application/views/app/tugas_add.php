<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"tugas"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);

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
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Jabatan_tambahan_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// echo $set->query;exit;
$set->firstRow();

$reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
$reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
$reqValidasi= $set->getField("VALIDASI");
$reqPerubahanData= $set->getField("PERUBAHAN_DATA");
$reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
$reqValRowId= $set->getField("JABATAN_TAMBAHAN_ID");

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}
// pakem data validasi
$reqRowId= $set->getField('JABATAN_TAMBAHAN_ID');

$reqNamaTugas= $set->getField('NAMA');

$reqPejabatPenetapId= $set->getField('PEJABAT_PENETAP_ID');

$reqPejabatPenetap= $set->getField('PEJABAT_PENETAP');

$reqNoSk= $set->getField('NO_SK');$vNoSk= checkwarna($reqPerubahanData, 'NO_SK');

$reqTanggalSk= dateTimeToPageCheck($set->getField('TANGGAL_SK')); $vTanggalSk= checkwarna($reqPerubahanData, 'TANGGAL_SK', [date]);

$reqTmtTugas= dateTimeToPageCheck($set->getField('TMT_JABATAN')); $vTmtTugas= checkwarna($reqPerubahanData, 'TMT_JABATAN', [date]);

$reqTmtJabatanAkhir= dateTimeToPageCheck($set->getField('TMT_JABATAN_AKHIR')); $vTmtJabatanAkhir= checkwarna($reqPerubahanData, 'TMT_JABATAN_AKHIR', [date]);

$reqTugasTambahanId= $set->getField('TUGAS_TAMBAHAN_ID');

$reqStatusPlt= $set->getField('STATUS_PLT');

$reqSatker= $set->getField('SATKER_NAMA');

$reqSatkerId= $set->getField('SATKER_ID');

$reqIsManual= $set->getField('IS_MANUAL');

$reqNoPelantikan= $set->getField('NO_PELANTIKAN');

$reqTanggalPelantikan= dateToPageCheck($set->getField('TANGGAL_PELANTIKAN')); $vTanggalPelantikan= checkwarna($reqPerubahanData, 'TANGGAL_PELANTIKAN', [date]);

$reqTunjangan= $set->getField('TUNJANGAN');

$reqBulanDibayar= dateToPageCheck($set->getField('BULAN_DIBAYAR')); $vBlnDibayar= checkwarna($reqPerubahanData, 'BULAN_DIBAYAR', [date]);

//$reqTmtTugas= $set->getField('SATKER_ID');
//$reqTmtWaktuTugas= $set->getField('SATKER_ID');
$reqTmtWaktuTugas= substr(datetimeToPage($set->getField('TMT_JABATAN'), "time"),0,5);

if($reqTmtWaktuTugas == "" || $reqTmtWaktuTugas == "00:00"){}
else
$reqCheckTmtWaktuTugas= "1";

if($reqTmtJabatanAkhir == ""){}
else
$reqIsAktif= "1";

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
        url:"api/Jabatan_tambahan_json/add"
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

  settimetmt(1);
  <?
  if($reqRowId == "")
  {
  ?>
  setcetang();
  <?
  }
  else
  {
  ?>
  seinfodatacentang();
  <?
  }
  ?>

  $("#reqCheckTmtWaktuTugas").click(function () {
   settimetmt(2);
  });
   
  $("#reqIsManual").click(function () {
    setcetang();
  });

  setaktif();
  $("#reqIsAktif").click(function () {
    setaktif();
  });
    
  $("#reqStatusPlt").change(function() { 
    //var reqStatusPlt= $("#reqStatusPlt").val();
  $("#reqNamaTugas,#reqTugasTambahanId,#reqSatker,#reqSatkerId").val("");
  });

      //$('input[id^="reqPejabatPenetap"], input[id^="reqNamaTugas"], input[id^="reqSatker"]').autocomplete({
  $('input[id^="reqPejabatPenetap"], input[id^="reqNamaTugas"], input[id^="reqSatker"]').each(function(){
    
    $(this).autocomplete({
      source:function(request, response){
        var id= this.element.attr('id');
        var replaceAnakId= replaceAnak= urlAjax= "";
      
        if (id.indexOf('reqNamaTugas') !== -1 || id.indexOf('reqSatker') !== -1)
        {
          if($("#reqIsManual").prop('checked')) 
          {
            $("#reqSatker").attr("readonly", false);
            return false;
          }
        }

        if (id.indexOf('reqPejabatPenetap') !== -1)
        {
          var element= id.split('reqPejabatPenetap');
          var indexId= "reqPejabatPenetapId"+element[1];
          urlAjax= "pejabat_penetap_json/combo";
        }
        //else if (id.indexOf('reqNamaTugas') !== -1)
        else if (id.indexOf('reqNamaTugas') !== -1) 
        {
          var reqStatusPlt= $("#reqStatusPlt").val();
          var element= id.split('reqNamaTugas');
          reqTanggalBatas= $("#reqTanggalSk").val();
          urlAjax= "jabatan_tambahan_json/namajabatan?reqTanggalBatas="+reqTanggalBatas+"&reqStatusPlt="+reqStatusPlt;
        }
        else if (id.indexOf('reqSatker') !== -1)
        {
          var element= id.split('reqSatker');
          var indexId= "reqSatkerId"+element[1];
          reqTanggalBatas= $("#reqTmtTugas").val();
          urlAjax= "satuan_kerja_json/auto?reqTanggalBatas="+reqTanggalBatas;
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
                return {desc: element['desc'], id: element['id'], label: element['label'], satuan_kerja: element['satuan_kerja'], satuan_kerja_id: element['satuan_kerja_id'], satuan_kerja_validasi: element['satuan_kerja_validasi']};
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
        else if (id.indexOf('reqNamaTugas') !== -1)
        {
          var element= id.split('reqNamaTugas');
          var indexId= "reqTugasTambahanId";
        }
        else if (id.indexOf('reqSatker') !== -1)
        {
          var element= id.split('reqSatker');
          var indexId= "reqSatkerId"+element[1];
          //$("#reqNama").val("").trigger('change');
        }

        var statusht= "";
        //statusht= ui.item.statusht;
        $("#"+indexId).val(ui.item.id).trigger('change');
        if (id.indexOf('reqNamaTugas') !== -1)
        {
          var reqStatusPlt= $("#reqStatusPlt").val();
          
          $("#reqSatker").attr("readonly", true);
          if(reqStatusPlt == "plt"){}
          else
          {
            if(ui.item.satuan_kerja_validasi == "1")
            {
              $("#reqSatker").attr("readonly", false);
            }
          }
        
          $("#reqSatkerId").val(ui.item.satuan_kerja_id).trigger('change');
          $("#reqSatker").val(ui.item.satuan_kerja).trigger('change');
        }
    
      },
        //minLength:3,
        autoFocus: true
    })
    /*.data( "autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li></li>" )
      .data( "item.autocomplete", item )
      .append( "<a>" + item.label + "</a>" )
      .appendTo( ul );
      }*/
      /*.data('ui-autocomplete')._renderItem = function(ul, item) {
        return $('<li>')
        .append('<a>' + item.label  + '<br>' + item.label  + '</a><br><br>')
        .appendTo(ul);
    
      }*/
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      //return
      return $( "<li>" )
      .append( "<a>" + item.desc  + "</a>" )
      .appendTo( ul );
    };
  });

});

function settimetmt(info)
{
  $("#reqInfoCheckTmtWaktuTugas").hide();
  if($("#reqCheckTmtWaktuTugas").prop('checked')) 
  {
    $("#reqInfoCheckTmtWaktuTugas").show();
  }
  else
  {
    if(info == 2)
    $("#reqTmtWaktuTugas").val("");
  }
}

function setcetang()
{
  //alert($("#reqIsManual").prop('checked'));return false;
  //$("#reqinfoeselontext,#reqinfoeselonselect").hide();
  if($("#reqIsManual").prop('checked')) 
  {
    $("#reqNamaTugas, #reqTugasTambahanId, #reqSatker, #reqSatkerId").val("");
    $("#reqSatker").attr("readonly", false);
    //$("#reqinfoeselonselect").show();
    //$("#reqSelectEselonId,#reqEselonId, #reqEselonText, #reqNama, #reqSatker, #reqSatkerId").val("");
    //$("#reqSelectEselonId").material_select();
    //$("#reqNama,#reqNamaId").val("");
  }
  else
  {
    $("#reqNamaTugas, #reqTugasTambahanId, #reqSatker, #reqSatkerId").val("");
    // $("#reqSatker").attr("readonly", true);
    //$("#reqEselonId, #reqNama, #reqSatker, #reqSatkerId").val("");
    //$("#reqinfoeselontext").show();
  }
}

function seinfodatacentang()
{
  if($("#reqIsManual").prop('checked')) 
  {
    $("#reqSatker").attr("readonly", false);
  }
  else
  {
    // $("#reqSatker").attr("readonly", true);
  }
}

function setaktif()
{
  if($("#reqIsAktif").prop('checked')) 
  {
    $("#reqInfoCheckTmtSelesai").show();
  }
  else
  {
    $("#reqInfoCheckTmtSelesai").hide();
    $("#reqTmtJabatanAkhir").val('');
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
            <label for="reqJenisTugas">
              Jenis Tugas
              <?
              $warnadata= $vJenisTugas['data'];
              $warnaclass= $vJenisTugas['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <select class="form-control <?=$warnaclass?>" name="reqStatusPlt" id="reqStatusPlt">
              <option value="" <? if($reqStatusPlt == "") echo "selected"?>></option>
              <option value="plt" <? if($reqStatusPlt == "plt") echo "selected"?>>Plt.</option>
              <option value="plh" <? if($reqStatusPlt == "plh") echo "selected"?>>Plh.</option>
              <option value="21" <? if($reqStatusPlt == "21") echo "selected"?>>Pendidikan</option>
              <option value="22" <? if($reqStatusPlt == "22") echo "selected"?>>Kesehatan</option>
              <option value="23" <? if($reqStatusPlt == "23") echo "selected"?>>Lainnya</option>
            </select>
          </div>
        </div>

        <div class="clearfix"></div><br/>

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
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox"  id="reqNoSk" name="reqNoSk" <?=$disabled?> value="<?=$reqNoSk?>" />
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
            <input class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew"  type="text" name="reqTanggalSk" id="reqTanggalSk"  value="<?=$reqTanggalSk?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalSk');"/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <input type="checkbox" id="reqIsManual" name="reqIsManual" value="1" <? if($reqIsManual == 1) echo 'checked'?> />
            <label for="reqIsManual"></label>
            *centang jika nama Tugas luar kab jombang / Tugas sebelum tahun 2012
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqNamaTugas">
              Nama Tugas
              <?
              $warnadata= $vNamaTugas['data'];
              $warnaclass= $vNamaTugas['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox"  id="reqNamaTugas" name="reqNamaTugas" <?=$disabled?> value="<?=$reqNamaTugas?>" />
            <input type="hidden" name="reqTugasTambahanId" id="reqTugasTambahanId" value="<?=$reqTugasTambahanId?>" />
          </div>

          <div class="col-md-2 mb-2">
            <label for="reqTmtTugas">
              TMT Tugas
              <?
              $warnadata= $vTmtTugas['data'];
              $warnaclass= $vTmtTugas['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input required class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTmtTugas" id="reqTmtTugas"  value="<?=$reqTmtTugas?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtTugas');"/>
          </div>

          <div class="col-md-1 mb-1">
            <input type="checkbox" id="reqCheckTmtWaktuTugas" name="reqCheckTmtWaktuTugas" value="1" <? if($reqCheckTmtWaktuTugas == 1) echo 'checked'?>/>
            <label for="reqCheckTmtWaktuTugas"></label>
          </div>

          <div class="col-md-1 mb-1" id="reqInfoCheckTmtWaktuTugas">
            <label for="reqTmtWaktuTugas">
              Time
              <?
              $warnadata= $vTmtWaktuTugas['data'];
              $warnaclass= $vTmtWaktuTugas['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input placeholder="00:00" id="reqTmtWaktuTugas" name="reqTmtWaktuTugas" type="text" class="form-control <?=$warnaclass?>" value="<?=$reqTmtWaktuTugas?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <label for="reqSatker">
              Satuan Kerja
              <?
              $warnadata= $vSatker['data'];
              $warnaclass= $vSatker['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" id="reqSatker" name="reqSatker" <?=$read?> <?php /*?>readonly<?php */?> value="<?=$reqSatker?>" class="form-control <?=$warnaclass?> easyui-validatebox" required />
            <input type="hidden" name="reqSatkerId" id="reqSatkerId" value="<?=$reqSatkerId?>" />
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqNoPelantikan">
              No. Pelantikan
              <?
              $warnadata= $vNoPelantikan['data'];
              $warnaclass= $vNoPelantikan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox"  id="reqNoPelantikan" name="reqNoPelantikan" <?=$disabled?> value="<?=$reqNoPelantikan?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqTanggalPelantikan">
              Tgl. Pelantikan
              <?
              $warnadata= $vTanggalPelantikan['data'];
              $warnaclass= $vTanggalPelantikan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew"  type="text" name="reqTanggalPelantikan" id="reqTanggalPelantikan"  value="<?=$reqTanggalPelantikan?>" maxlength="10" onKeyDown="return format_date(event,'reqTanggalPelantikan');"/>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <label for="reqTunjangan">
              Tunjangan
              <?
              $warnadata= $vTunjangan['data'];
              $warnaclass= $vTunjangan['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input type="text" class="form-control <?=$warnaclass?> easyui-validatebox" required id="reqTunjangan" name="reqTunjangan" OnFocus="FormatAngka('reqTunjangan')" OnKeyUp="FormatUang('reqTunjangan')" OnBlur="FormatUang('reqTunjangan')" value="<?=numberToIna($reqTunjangan)?>" />
          </div>

          <div class="col-md-6 mb-6">
            <label for="reqBlnDibayar">
              Bln. Dibayar
              <?
              $warnadata= $vBlnDibayar['data'];
              $warnaclass= $vBlnDibayar['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?> easyui-validatebox formattanggalnew" type="text" name="reqBulanDibayar" id="reqBulanDibayar"  value="<?=$reqBulanDibayar?>" maxlength="10" onKeyDown="return format_date(event,'reqBulanDibayar');"/>

            
          </div>
        </div>

        <div class="form-row">
          <div class="col-md-12 mb-12">
            <label for="reqPejabatPenetap">
              Pejabat Penetap
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

        <div class="form-row">
          <div class="col-md-6 mb-6">
            <input type="checkbox" id="reqIsAktif" name="reqIsAktif" value="1" <? if($reqIsAktif == 1) echo 'checked'?> />
            <label for="reqIsAktif"></label>
            *centang jika sudah tidak aktif
          </div>

          <div class="col-md-2 mb-2" id="reqInfoCheckTmtSelesai">
            <label for="reqTmtJabatanAkhir">
              TMT Selesai Tugas
              <?
              $warnadata= $vTmtJabatanAkhir['data'];
              $warnaclass= $vTmtJabatanAkhir['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>
            </label>
            <input class="form-control <?=$warnaclass?> easyui-validatebox" data-options="validType:'dateValidPicker'" type="text" name="reqTmtJabatanAkhir" id="reqTmtJabatanAkhir"  value="<?=$reqTmtJabatanAkhir?>" maxlength="10" onKeyDown="return format_date(event,'reqTmtJabatanAkhir');"/>
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
  $(document).ready(function() {
    // $('select').material_select();
  });

  $('#reqKredit').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
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