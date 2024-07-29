<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$reqId= $this->input->get("reqId");
$reqRowId= $this->input->get("reqRowId");
$sessPersonalToken= $this->PERSONAL_TOKEN;
$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));
$arrdataField= [];
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Penilaian_skp_json", "id"=>$reqId, "rowid"=>$reqRowId];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// print_r($set);exit;
 $reqMode = 'insert';
while($set->nextRow())
{

  $reqMode = 'update';
  $reqRowId= $set->getField('PENILAIAN_SKP_ID');
  $reqPegawaiJenisJabatan = $set->getField('JENIS_JABATAN_DINILAI');
  $reqPegawaiUnorNama = $set->getField('PEGAWAI_UNOR_NAMA');
  $reqPegawaiUnorId = $set->getField('PEGAWAI_UNOR_ID');

  $reqTahunSkp22 = $set->getField("TAHUN");
  $reqTahun = $set->getField("TAHUN");
    $reqTahun =   $reqTahun?  $reqTahun:date('Y');

  $reqPenilaianSkpPenilaiId = $set->getField("PEGAWAI_PEJABAT_PENILAI_ID");
  $reqPenilaianSkpPenilaiNama = $set->getField('PEGAWAI_PEJABAT_PENILAI_NAMA');
  $reqPenilaianSkpPenilaiNip = $set->getField('PEGAWAI_PEJABAT_PENILAI_NIP');
  $reqPenilaianSkpPenilaiJabatanNama = $set->getField('PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA');
  $reqPenilaianSkpPenilaiUnorNama = $set->getField('PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA');
  $reqPenilaianSkpPenilaiPangkatId = $set->getField('PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID');

  $reqPenilaianSkpAtasanId = $set->getField("PEGAWAI_ATASAN_PEJABAT_ID");
  $reqPenilaianSkpAtasanNama = $set->getField('PEGAWAI_ATASAN_PEJABAT_NAMA');
  $reqPenilaianSkpAtasanNip = $set->getField('PEGAWAI_ATASAN_PEJABAT_NIP');
  $reqPenilaianSkpAtasanJabatanNama = $set->getField('PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA');
  $reqPenilaianSkpAtasanUnorNama = $set->getField('PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA');
  $reqPenilaianSkpAtasanPangkatId = $set->getField('PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID');

//Semester 2
  $reqPegawaiJenisJabatan2 = $set->getField('JENIS_JABATAN_DINILAI2');
  $reqPegawaiUnorNama2 = $set->getField('PEGAWAI_UNOR_NAMA2');
  $reqPegawaiUnorId2 = $set->getField('PEGAWAI_UNOR_ID2');

  $reqPenilaianSkpPenilaiId2 = $set->getField("PEGAWAI_PEJABAT_PENILAI_ID2");
  $reqPenilaianSkpPenilaiNama2 = $set->getField('PEGAWAI_PEJABAT_PENILAI_NAMA2');
  $reqPenilaianSkpPenilaiNip2 = $set->getField('PEGAWAI_PEJABAT_PENILAI_NIP2');
  $reqPenilaianSkpPenilaiJabatanNama2 = $set->getField('PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA2');
  $reqPenilaianSkpPenilaiUnorNama2 = $set->getField('PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA2');
  $reqPenilaianSkpPenilaiPangkatId2 = $set->getField('PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID2');

  $reqPenilaianSkpAtasanId2 = $set->getField("PEGAWAI_ATASAN_PEJABAT_ID2");
  $reqPenilaianSkpAtasanNama2 = $set->getField('PEGAWAI_ATASAN_PEJABAT_NAMA2');
  $reqPenilaianSkpAtasanNip2 = $set->getField('PEGAWAI_ATASAN_PEJABAT_NIP2');
  $reqPenilaianSkpAtasanJabatanNama2 = $set->getField('PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA2');
  $reqPenilaianSkpAtasanUnorNama2 = $set->getField('PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA2');
  $reqPenilaianSkpAtasanPangkatId2 = $set->getField('PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID2');

  if($reqPenilaianSkpPenilaiId == "")
  {
  // $reqPejabatPenilaiIsManual= "1";
  }
  if($reqPenilaianSkpPenilaiId2 == "")
  {
  // $reqPejabatPenilaiIsManual2= "1";
  }
// echo $reqPenilaianSkpPenilaiId."--".$reqPenilaianSkpAtasanId;exit();
  if($reqPenilaianSkpAtasanId == "")
  {
  // $reqAtasanPejabatPenilaiIsManual= "1";
  }
  if($reqPenilaianSkpAtasanId2 == "")
  {
  // $reqAtasanPejabatPenilaiIsManual2= "1";
  }

//semester I
  $reqSkpNilai = dotToComma($set->getField('SKP_NILAI'));
  $reqSkpHasil = dotToComma($set->getField('SKP_HASIL'));
  $reqOrientasiNilai = dotToComma($set->getField('ORIENTASI_NILAI')); 
  $reqIntegritasNilai = dotToComma($set->getField('INTEGRITAS_NILAI'));
  $reqKomitmenNilai = dotToComma($set->getField('KOMITMEN_NILAI')); 
  $reqDisiplinNilai = dotToComma($set->getField('DISIPLIN_NILAI')); 
  $reqKerjasamaNilai = dotToComma($set->getField('KERJASAMA_NILAI')); 
  $reqKepemimpinanNilai = dotToComma($set->getField('KEPEMIMPINAN_NILAI')); 
  $reqJumlahNilai= dotToComma(setLebihNol($set->getField('JUMLAH_NILAI'))); 
  $reqRataNilai= dotToComma(setLebihNol($set->getField('RATA_NILAI'))); 
  $reqPerilakuNilai= dotToComma(setLebihNol($set->getField('PERILAKU_NILAI'))); 
  $reqPerilakuHasil= dotToComma(setLebihNol($set->getField('PERILAKU_HASIL')));
  $reqPrestasiNilai = $set->getField('PRESTASI_NILAI'); 
  $reqPrestasiHasil= dotToComma(setLebihNol($set->getField('PRESTASI_HASIL'))); 

//semester II
  $reqSkpNilai2 = dotToComma($set->getField('SKP_NILAI2'));
  $reqSkpHasil2 = dotToComma($set->getField('SKP_HASIL2'));
  $reqOrientasiNilai2 = dotToComma($set->getField('ORIENTASI_NILAI2')); 
  $reqKomitmenNilai2 = dotToComma($set->getField('KOMITMEN_NILAI2')); 
  $reqKerjasamaNilai2 = dotToComma($set->getField('KERJASAMA_NILAI2')); 
  $reqKepemimpinanNilai2 = dotToComma($set->getField('KEPEMIMPINAN_NILAI2'));
  $reqInisiatifkerjaNilai2 = dotToComma($set->getField('INISIATIFKERJA_NILAI2'));
  $reqJumlahNilai2= dotToComma(setLebihNol($set->getField('JUMLAH_NILAI2'))); 
  $reqRataNilai2= dotToComma(setLebihNol($set->getField('RATA_NILAI2'))); 

//Nilai SKP Tahun > 2022

  $reqNilaiHasilKerja= $set->getField('NILAI_HASIL_KERJA'); 
  $reqNilaiPerilakuKerja= $set->getField('NILAI_HASIL_PERILAKU'); 

  $reqKeberatan = $set->getField('KEBERATAN');
  $reqTanggalKeberatan = dateToPageCheck($set->getField('KEBERATAN_TANGGAL')); 
  $reqTanggapan = $set->getField('TANGGAPAN'); 
  $reqTanggalTanggapan = dateToPageCheck($set->getField('TANGGAPAN_TANGGAL')); 
  $reqKeputusan = $set->getField('KEPUTUSAN'); 
  $reqTanggalKeputusan = dateToPageCheck($set->getField('KEPUTUSAN_TANGGAL'));
  $reqRekomendasi = $set->getField('REKOMENDASI'); 

//   $vidsapk= $set->getField("ID_SAPK");

//   $pegawai_dinilai->selectByParams(array("A.PEGAWAI_ID" => $reqId)); 
//   $pegawai_dinilai->firstRow();
// //echo $pegawai_dinilai->query;exit;

//   $reqPenilaianSkpDinilaiNama = $pegawai_dinilai->getField('NAMA_LENGKAP');
//   $reqPenilaianSkpDinilaiNip = $pegawai_dinilai->getField('NIP_BARU');
//   $reqSatkerAtasan = $pegawai_dinilai->getField('SATKER_ID_ATASAN');


 $reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
 $reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
 $reqValidasi= $set->getField("VALIDASI");
 $reqPerubahanData= $set->getField("PERUBAHAN_DATA");
 $reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
 $reqValRowId= $set->getField("PENILAIAN_SKP_ID");

}
$arrdata = array("reqPegawaiId"=>$reqCheckPegawaiId);
$set->selectby($sessPersonalToken, "pegawai", $arrdata);
$set->firstRow();
$reqPenilaianSkpDinilaiNama = $set->getField('NAMA_LENGKAP');
$reqPenilaianSkpDinilaiNip = $set->getField('NIP_BARU');
$reqSatkerAtasan = $set->getField('SATKER_ID_ATASAN');

$arrPangkat= [];
$set->selectby($sessPersonalToken, "pangkat", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("PANGKAT_ID");
  $arrdata["text"]= $set->getField("KODE");
  array_push($arrPangkat, $arrdata);
}




$vPenilaianSkpAtasanNama = checkwarna($reqPerubahanData, 'PEGAWAI_ATASAN_PEJABAT_NAMA');

$buttonsimpan= "1";
if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || (!empty($reqTempValidasiHapusId)) && $reqId !== "baru"))
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
        var dataform = $('#ff')[0];
    var formData = new FormData(dataform); 
      $.ajax({
        url:"api/Penilaian_skp_json/add"
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
                  elseif(!empty($reqTempValidasiId))
                  {
                  ?>
                  addurl= "?reqRowId=<?=$reqTempValidasiId?>";
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
<style type="text/css">
  ol {
    counter-reset: list;
    
}
ol > li {
    list-style: none;
    position: relative;

}
ol > li:before {
    counter-increment: list;
    content: counter(list, lower-alpha) ".";
    position: absolute;
    left: -1.4em;
      padding-top: 7px;
}
</style>
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

      <form class="needs-validation form-horizontal" id="ff" method="post" novalidate enctype="multipart/form-data">
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Tahun: </label>
          <div class="col-sm-4">
            <input type="text" readonly class="form-control easyui-validatebox " id="reqTahun" name="reqTahun" placeholder="Isikan Tahun" value="<?=$reqTahun?>">
          </div>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for="">1.</label>
           <label class="control-label col-sm-2" for="" style="text-align: left;">Yang dinilai </label>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-10">
          <ol>
            <li>   
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Nama: </label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control easyui-validatebox "  id="reqPenilaianSkpDinilaiNama" name="reqPenilaianSkpDinilaiNama" readonly placeholder="Isikan Nama" value="<?=$reqPenilaianSkpDinilaiNama?>">
                </div>
              </div>
            </li>
            <li> 
               <div class="form-group">
                <label class="control-label col-sm-2" for="">Nip: </label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control easyui-validatebox" id="reqPenilaianSkpDinilaiNip" name="reqPenilaianSkpDinilaiNip" placeholder="Isikan Nip" readonly value="<?=$reqPenilaianSkpDinilaiNip?>">
                </div>
              </div>
            </li>
            <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Jenis Jabatan PNS Yang Dinilai: </label>
                <div class="col-sm-8">
                  <select id="reqPegawaiJenisJabatan" name="reqPegawaiJenisJabatan" class="form-control" >
                     <option value="" <? if($reqPegawaiJenisJabatan=="") echo 'selected';?>></option>
                    <option value="1" <? if($reqPegawaiJenisJabatan==1) echo 'selected';?>>Struktural (pejabat yang memiliki Eselon)</option>
                    <option value="2" <? if($reqPegawaiJenisJabatan==2) echo 'selected';?>>Fungsional (Penyuluh, Guru, Tenaga Kesehatan, Kepala Sekolah, Kepala Puskesmas, Koorwil dll)</option>
                    <option value="4" <? if($reqPegawaiJenisJabatan==4) echo 'selected';?>>Pelaksana / Staf / Fungsional Umum</option>
                  </select>
                </div>
              </div>
            </li>
            <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Unit Kerja PNS Yang Dinilai: </label>
                <div class="col-sm-8">
                  <input type="hidden" id="reqPegawaiUnorId" name="reqPegawaiUnorId" value="<?=$reqPegawaiUnorId?>" />
                  <input type="text" required class="form-control easyui-validatebox " id="reqPegawaiUnorNama" name="reqPegawaiUnorNama" placeholder="Isikan Unit Kerja PNS Yang Dinilai" value="<?=$reqPegawaiUnorNama?>">
                </div>
              </div>
            </li>
          </ol>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <label class="control-label col-sm-6" for="" style="text-align: left;"><input type="checkbox" id="reqPejabatPenilaiIsManual" name="reqPejabatPenilaiIsManual" value="1" <? if($reqPejabatPenilaiIsManual == 1) echo 'checked'?> />
            <label for="reqPejabatPenilaiIsManual" style="font-weight: normal;"> *centang jika Pejabat Penilai Non-PNS</label>   
          </div>


        <div class="form-group">
          <label class="control-label col-sm-2" for="">2.</label>
           <label class="control-label col-sm-2" for="" style="text-align: left;">Pejabat Penilai  </label>
            <input type="hidden" id="reqPenilaianSkpPenilaiId" name="reqPenilaianSkpPenilaiId" value="<?=$reqPenilaianSkpPenilaiId?>">
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-10">
          <ol>
            <li>   
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Nip: </label>
                <div class="col-sm-8">
                  <input type="text" required class="form-control easyui-validatebox " id="reqPenilaianSkpPenilaiNip" name="reqPenilaianSkpPenilaiNip" placeholder="Isikan Nip" value="<?=$reqPenilaianSkpPenilaiNip?>">
                </div>
              </div>
            </li>
            <li> 
               <div class="form-group">
                <label class="control-label col-sm-2" for="">Nama: </label>
                <div class="col-sm-8">
                  <input type="text" readonly class="form-control easyui-validatebox " id="reqPenilaianSkpPenilaiNama" name="reqPenilaianSkpPenilaiNama" placeholder="Isikan Nama" value="<?=$reqPenilaianSkpPenilaiNama?>">
                </div>
              </div>
            </li>
            <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Jabatan Ketika Menilai: </label>
                <div class="col-sm-8">
                  <input type="hidden" id="reqPenilaianSkpPenilaiJabatanId" name="reqPenilaianSkpPenilaiJabatanId" value="" />
                  <input type="text" required class="form-control easyui-validatebox " id="reqPenilaianSkpPenilaiJabatanNama" name="reqPenilaianSkpPenilaiJabatanNama" placeholder="Isikan Jabatan Ketika Menilai" value="<?=$reqPenilaianSkpPenilaiJabatanNama?>">
                </div>
              </div>
            </li>
            <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Unit Kerja Ketika Menilai: </label>
                <div class="col-sm-8">
                  <input type="text" required class="form-control easyui-validatebox " id="reqPenilaianSkpPenilaiUnorNama" name="reqPenilaianSkpPenilaiUnorNama" placeholder="Isikan Unit Kerja Ketika Menilai" value="<?=$reqPenilaianSkpPenilaiUnorNama?>">
                </div>
              </div>
            </li>
             <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Gol/Ruang Ketika Menilai: </label>
                <div class="col-sm-8">
                  <select name="reqPenilaianSkpPenilaiPangkatId" id="reqPenilaianSkpPenilaiPangkatId" class="form-control" >
                    <option value=""></option>
                    <?
                    foreach ($arrPangkat as $key => $value)
                    {
                      $optionid= $value["id"];
                      $optiontext= $value["text"];
                      $optionselected= "";
                      if($reqPenilaianSkpPenilaiPangkatId == $optionid)
                        $optionselected= "selected";
                      ?>
                      <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                      <?
                    }
                    ?>       
                  </select>
                </div>
              </div>
            </li>
          </ol>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <label class="control-label col-sm-6" for="" style="text-align: left;"><input type="checkbox" id="reqPejabatPenilaiIsManual" name="reqPejabatPenilaiIsManual" value="1" <? if($reqPejabatPenilaiIsManual == 1) echo 'checked'?> />
            <label for="reqPejabatPenilaiIsManual" style="font-weight: normal;"> *centang jika Atasan Pejabat Penilai Non-PNS</label>   
        </div>


        <div class="form-group">
          <label class="control-label col-sm-2" for="">3.</label>
           <label class="control-label col-sm-2" for="" style="text-align: left;">Atasan Pejabat Penilai  </label>
           <input type="hidden" name="reqPenilaianSkpAtasanId" id="reqPenilaianSkpAtasanId" value="<?=$reqPenilaianSkpAtasanId?>"/>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-10">
          <ol>
            <li>   
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Nip: </label>
                <div class="col-sm-8">
                  <input type="text" required class="form-control easyui-validatebox " id="reqPenilaianSkpAtasanNip" name="reqPenilaianSkpAtasanNip" placeholder="Isikan Nip" value="<?=$reqPenilaianSkpAtasanNip?>">
                </div>
              </div>
            </li>
            <li> 
               <div class="form-group">
                <label class="control-label col-sm-2" for="">Nama
                  <?
                  $warnadata= $vPenilaianSkpAtasanNama['data'];
                  $warnaclass= $vPenilaianSkpAtasanNama['warna'];
                  if(!empty($warnadata))
                  {
                    ?>
                    <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
                    <?
                  }
                ?>: </label>
                <div class="col-sm-8">
                  <input type="text" readonly  class="form-control easyui-validatebox <?=$warnaclass?>" id="reqPenilaianSkpAtasanNama" name="reqPenilaianSkpAtasanNama" placeholder="Isikan Nama" value="<?=$reqPenilaianSkpAtasanNama?>">
                </div>
              </div>
            </li>
            <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Jabatan Ketika Menandatangani: </label>
                <div class="col-sm-8">
                  <input type="text" required class="form-control easyui-validatebox " id="reqPenilaianSkpAtasanJabatanNama" name="reqPenilaianSkpAtasanJabatanNama" placeholder="Isikan Jabatan Ketika Menandatangani" value="<?=$reqPenilaianSkpAtasanJabatanNama?>">
                </div>
              </div>
            </li>
            <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Unit Kerja Ketika Menandatangani: </label>
                <div class="col-sm-8">
                  <input type="text" required class="form-control easyui-validatebox " id="reqPenilaianSkpAtasanUnorNama" name="reqPenilaianSkpAtasanUnorNama" placeholder="Isikan Unit Kerja Ketika Menandatangani" value="<?=$reqPenilaianSkpAtasanUnorNama?>">
                </div>
              </div>
            </li>
             <li> 
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Gol/Ruang Ketika Menandatangani: </label>
                <div class="col-sm-8">
                   <select name="reqPenilaianSkpAtasanPangkatId" id="reqPenilaianSkpAtasanPangkatId" class="form-control" >
                    <option value=""></option>
                     <?
                    foreach ($arrPangkat as $key => $value)
                    {
                      $optionid= $value["id"];
                      $optiontext= $value["text"];
                      $optionselected= "";
                      if($reqPenilaianSkpAtasanPangkatId == $optionid)
                        $optionselected= "selected";
                      ?>
                      <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                      <?
                    }
                    ?>       
                  </select>
                </div>
              </div>
            </li>
          </ol>
          </div>
        </div>
      

        <div class="form-group">
          <label class="control-label col-sm-2" for="">4.</label>
           <label class="control-label col-sm-2" for="" style="text-align: left;">Unsur Yang Dinilai   </label>
        </div>
         <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-10">
          <ol>
            <li>   
              <div class="form-group">
                <label class="control-label col-sm-2" for="">Nilai Hasil Kerja : </label>
                <div class="col-sm-8">
                <select id="reqNilaiHasilKerja" name="reqNilaiHasilKerja" class="form-control">
                     <option value="" <? if($reqNilaiHasilKerja=="") echo 'selected';?>></option>
                    <option value="1" <? if($reqNilaiHasilKerja==1) echo 'selected';?>>DIATAS EKSPEKTASI</option>
                    <option value="2" <? if($reqNilaiHasilKerja==2) echo 'selected';?>>SESUAI EKSPEKTASI</option>
                    <option value="3" <? if($reqNilaiHasilKerja==3) echo 'selected';?>>DIBAWAH EKSPEKTASI</option>
                  </select>
                </div>
              </div>
            </li>
            <li> 
               <div class="form-group">
                <label class="control-label col-sm-2" for="">Nilai Perilaku Kerja: </label>
                <div class="col-sm-8">
                   <select id="reqNilaiPerilakuKerja" name="reqNilaiPerilakuKerja" class="form-control" >
                    <option value="" <? if($reqNilaiPerilakuKerja=="") echo 'selected';?>></option>
                    <option value="1" <? if($reqNilaiPerilakuKerja==1) echo 'selected';?>>DIATAS EKSPEKTASI</option>
                    <option value="2" <? if($reqNilaiPerilakuKerja==2) echo 'selected';?>>SESUAI EKSPEKTASI</option>
                    <option value="3" <? if($reqNilaiPerilakuKerja==3) echo 'selected';?>>DIBAWAH EKSPEKTASI</option>
                  </select>
                </div>
              </div>
            </li>
            
          </ol>
          </div>
        </div>
      


         <input type="hidden"  name="reqTipePegawaiId" value="<?=$reqTipePegawaiId?>" />
        <input type="hidden" name="reqId" value="<?=$reqId?>" />
        <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
        <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>" />
        <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
         <?
            if(!empty($buttonsimpan))
            {
            ?>
              <button class="btn btn-primary"  id="simpan" type="submit">Simpan</button>
            <?
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
  function setpejabatpenilaicetang(vinfo)
{
  if(vinfo == "1")
  {
    $("#reqPenilaianSkpPenilaiId,#reqPenilaianSkpPenilaiNip,#reqPenilaianSkpPenilaiNama").val("");
  }

  if($("#reqPejabatPenilaiIsManual").prop('checked')) 
  {
    $("#reqPenilaianSkpPenilaiNip").attr("readonly", true);
    $("#reqPenilaianSkpPenilaiNip").addClass('color-disb');
    // $('#reqPenilaianSkpPenilaiNip').validatebox({required: false});
    $('#reqPenilaianSkpPenilaiNip').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpPenilaiNama").attr("readonly", false);
    $("#reqPenilaianSkpPenilaiNama").removeClass('color-disb');
    // $('#reqPenilaianSkpPenilaiNama').validatebox({required: true});
  }
  else
  { 
    $("#reqPenilaianSkpPenilaiNama").attr("readonly", true);
    $("#reqPenilaianSkpPenilaiNama").addClass('color-disb');
    // $('#reqPenilaianSkpPenilaiNama').validatebox({required: false});
    $('#reqPenilaianSkpPenilaiNama').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpPenilaiNip").attr("readonly", false);
    $("#reqPenilaianSkpPenilaiNip").removeClass('color-disb');
    // $('#reqPenilaianSkpPenilaiNip').validatebox({required: true});
  }
}
function setpejabatpenilaicetang2(vinfo)
{
  if(vinfo == "1")
  {
    $("#reqPenilaianSkpPenilaiId2,#reqPenilaianSkpPenilaiNip2,#reqPenilaianSkpPenilaiNama2").val("");
  }

  if($("#reqPejabatPenilaiIsManual2").prop('checked')) 
  {
    $("#reqPenilaianSkpPenilaiNip2").attr("readonly", true);
    $("#reqPenilaianSkpPenilaiNip2").addClass('color-disb');
   // $('#reqPenilaianSkpPenilaiNip2').validatebox({required: false});
    $('#reqPenilaianSkpPenilaiNip2').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpPenilaiNama2").attr("readonly", false);
    $("#reqPenilaianSkpPenilaiNama2").removeClass('color-disb');
   // $('#reqPenilaianSkpPenilaiNama2').validatebox({required: true});
  }
  else
  { 
    $("#reqPenilaianSkpPenilaiNama2").attr("readonly", true);
    $("#reqPenilaianSkpPenilaiNama2").addClass('color-disb');
    //$('#reqPenilaianSkpPenilaiNama2').validatebox({required: false});
    $('#reqPenilaianSkpPenilaiNama2').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpPenilaiNip2").attr("readonly", false);
    $("#reqPenilaianSkpPenilaiNip2").removeClass('color-disb');
 //   $('#reqPenilaianSkpPenilaiNip2').validatebox({required: true});
  }
}
function setatasanpejabatpenilaicetang(vinfo)
{
  if(vinfo == "1")
  {
    $("#reqPenilaianSkpAtasanId,#reqPenilaianSkpAtasanNip,#reqPenilaianSkpAtasanNama").val("");
  }

  if($("#reqAtasanPejabatPenilaiIsManual").prop('checked')) 
  {
    $("#reqPenilaianSkpAtasanNip").attr("readonly", true);
    $("#reqPenilaianSkpAtasanNip").addClass('color-disb');
  //  $('#reqPenilaianSkpAtasanNip').validatebox({required: false});
    $('#reqPenilaianSkpAtasanNip').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpAtasanNama").attr("readonly", false);
    $("#reqPenilaianSkpAtasanNama").removeClass('color-disb');
    //$('#reqPenilaianSkpAtasanNama').validatebox({required: true});
  }
  else
  { 
    $("#reqPenilaianSkpAtasanNama").attr("readonly", true);
    $("#reqPenilaianSkpAtasanNama").addClass('color-disb');
    //$('#reqPenilaianSkpAtasanNama').validatebox({required: false});
    $('#reqPenilaianSkpAtasanNama').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpAtasanNip").attr("readonly", false);
    $("#reqPenilaianSkpAtasanNip").removeClass('color-disb');
   // $('#reqPenilaianSkpAtasanNip').validatebox({required: true});
  }
}
function setatasanpejabatpenilaicetang2(vinfo)
{
  if(vinfo == "1")
  {
    $("#reqPenilaianSkpAtasanId2,#reqPenilaianSkpAtasanNip2,#reqPenilaianSkpAtasanNama2").val("");
  }
  
  if($("#reqAtasanPejabatPenilaiIsManual2").prop('checked')) 
  {
    $("#reqPenilaianSkpAtasanNip2").attr("readonly", true);
    $("#reqPenilaianSkpAtasanNip2").addClass('color-disb');
  //  $('#reqPenilaianSkpAtasanNip2').validatebox({required: false});
    $('#reqPenilaianSkpAtasanNip2').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpAtasanNama2").attr("readonly", false);
    $("#reqPenilaianSkpAtasanNama2").removeClass('color-disb');
    //$('#reqPenilaianSkpAtasanNama2').validatebox({required: true});
  }
  else
  { 
    $("#reqPenilaianSkpAtasanNama2").attr("readonly", true);
    $("#reqPenilaianSkpAtasanNama2").addClass('color-disb');
   // $('#reqPenilaianSkpAtasanNama2').validatebox({required: false});
    $('#reqPenilaianSkpAtasanNama2').removeClass('validatebox-invalid');

    $("#reqPenilaianSkpAtasanNip2").attr("readonly", false);
    $("#reqPenilaianSkpAtasanNip2").removeClass('color-disb');
    //$('#reqPenilaianSkpAtasanNip2').validatebox({required: true});
  }
}
</script>
<script type="text/javascript">
  $(function(){
     <?
  if($reqMode == 'insert')
  {
  ?>
  <?
  }
  else
  {
    if($reqPenilaianSkpPenilaiId == "")
    {
    ?>
      $("#reqPenilaianSkpPenilaiNip").attr("readonly", true);
      $("#reqPenilaianSkpPenilaiNip").addClass('color-disb');
     // $('#reqPenilaianSkpPenilaiNip').validatebox({required: false});
      $('#reqPenilaianSkpPenilaiNip').removeClass('validatebox-invalid');

      $("#reqPenilaianSkpPenilaiNama").attr("readonly", false);
      $("#reqPenilaianSkpPenilaiNama").removeClass('color-disb');
      //$('#reqPenilaianSkpPenilaiNama').validatebox({required: true});
    <?
    }
    ?>

    <?
    if($reqPenilaianSkpPenilaiId2 == "")
    {
    ?>
      $("#reqPenilaianSkpPenilaiNip2").attr("readonly", true);
      $("#reqPenilaianSkpPenilaiNip2").addClass('color-disb');
     // $('#reqPenilaianSkpPenilaiNip2').validatebox({required: false});
      $('#reqPenilaianSkpPenilaiNip2').removeClass('validatebox-invalid');

      $("#reqPenilaianSkpPenilaiNama2").attr("readonly", false);
      $("#reqPenilaianSkpPenilaiNama2").removeClass('color-disb');
      //$('#reqPenilaianSkpPenilaiNama2').validatebox({required: true});
    <?
    }
    ?>

    <?
    if($reqPenilaianSkpAtasanId == "")
    {
    ?>
      $("#reqPenilaianSkpAtasanNip").attr("readonly", true);
      $("#reqPenilaianSkpAtasanNip").addClass('color-disb');
      //$('#reqPenilaianSkpAtasanNip').validatebox({required: false});
      $('#reqPenilaianSkpAtasanNip').removeClass('validatebox-invalid');

      $("#reqPenilaianSkpAtasanNama").attr("readonly", false);
      $("#reqPenilaianSkpAtasanNama").removeClass('color-disb');
     // $('#reqPenilaianSkpAtasanNama').validatebox({required: true});
    <?
    }


    if($reqPenilaianSkpAtasanId2 == "")
    {
    ?>
      $("#reqPenilaianSkpAtasanNip2").attr("readonly", true);
      $("#reqPenilaianSkpAtasanNip2").addClass('color-disb');
    //  $('#reqPenilaianSkpAtasanNip2').validatebox({required: false});
      $('#reqPenilaianSkpAtasanNip2').removeClass('validatebox-invalid');

      $("#reqPenilaianSkpAtasanNama2").attr("readonly", false);
      $("#reqPenilaianSkpAtasanNama2").removeClass('color-disb');
   //   $('#reqPenilaianSkpAtasanNama2').validatebox({required: true});
    <?
    }
  }
  ?>
   setpejabatpenilaicetang("");
  $("#reqPejabatPenilaiIsManual").click(function () {
    setpejabatpenilaicetang("1");
  });

  setatasanpejabatpenilaicetang("");
  $("#reqAtasanPejabatPenilaiIsManual").click(function () {
    setatasanpejabatpenilaicetang("1");
  });

  setpejabatpenilaicetang2("");
  $("#reqPejabatPenilaiIsManual2").click(function () {
    setpejabatpenilaicetang2("1");
  });

  setatasanpejabatpenilaicetang2("");
  $("#reqAtasanPejabatPenilaiIsManual2").click(function () {
    setatasanpejabatpenilaicetang2("1");
  });
  });
</script>
<!-- AUTO KOMPLIT -->
  <link rel="stylesheet" href="assets/autokomplit/jquery-ui.css">
  <script src="assets/autokomplit/jquery-ui.js"></script>
<script type="text/javascript">
 $(function(){

      $('#reqPenilaianSkpPenilaiJabatanNama, #reqPenilaianSkpAtasanJabatanNama, #reqPenilaianSkpPenilaiJabatanNama2, #reqPenilaianSkpAtasanJabatanNama2').each(function(){
  $(this).autocomplete({
    source:function(request, response){
      $(".preloader-wrapper").show();
      var id= this.element.attr('id');
      var replaceAnakId= replaceAnak= urlAjax= "";

      // if (id.indexOf('reqPenilaianSkpPenilaiJabatanNama') !== -1)
      if (id == 'reqPenilaianSkpPenilaiJabatanNama')
      {
        var element= id.split('reqPenilaianSkpPenilaiJabatanNama');
        var indexId= "reqPenilaianSkpPenilaiJabatanNama"+element[1];
        urlAjax= "api/combo/skpNamajabatan";
      }
      else if (id == 'reqPenilaianSkpAtasanJabatanNama')
      {
        var element= id.split('reqPenilaianSkpAtasanJabatanNama');
        var indexId= "reqPenilaianSkpAtasanJabatanNama"+element[1];
        urlAjax= "api/combo/skpNamajabatan";
      }      
      else if (id == 'reqPenilaianSkpPenilaiJabatanNama2')
      {
        var element= id.split('reqPenilaianSkpPenilaiJabatanNama2');
        var indexId= "reqPenilaianSkpPenilaiJabatanNama2"+element[1];
        urlAjax= "api/combo/skpNamajabatan";
      }
      else if (id == 'reqPenilaianSkpAtasanJabatanNama2')
      {
        var element= id.split('reqPenilaianSkpAtasanJabatanNama2');
        var indexId= "reqPenilaianSkpAtasanJabatanNama2"+element[1];
        urlAjax= "api/combo/skpNamajabatan";
      }    

      $.ajax({
        url: urlAjax,
        type: "GET",
        dataType: "json",
        data: { term: request.term },
        success: function(responseData){
          $(".preloader-wrapper").hide();

          if(responseData == null)
          {
            response(null);
          }
          else
          {
            var array = responseData.map(function(element) {
              return {desc: element['desc'], id: element['id'], label: element['label']};
            });
            response(array);
          }
        }
      })
    },
    // focus: function (event, ui) 
    select: function (event, ui) 
    { 
      var id= $(this).attr('id');
      
      if (id == 'reqPenilaianSkpPenilaiJabatanNama')
      {
        // console.log(ui.item);
        $("#reqPenilaianSkpPenilaiJabatanId").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpAtasanJabatanNama')
      {
        // console.log(ui.item);
        $("#reqPenilaianSkpAtasanJabatanNama").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpPenilaiJabatanNama2')
      {
        // console.log(ui.item);
        $("#reqPenilaianSkpPenilaiJabatanId2").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpAtasanJabatanNama2')
      {
        //  console.log(ui.item);
        $("#reqPenilaianSkpAtasanJabatanId2").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
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

  $('input[id^="reqPenilaianSkpPenilaiNip"], input[id^="reqPenilaianSkpAtasanNip"], input[id^="reqPenilaianSkpPenilaiNip2"], input[id^="reqPenilaianSkpAtasanNip2"]').each(function(){
  $(this).autocomplete({
    source:function(request, response){
      $(".preloader-wrapper").show();
      var id= this.element.attr('id');
      var replaceAnakId= replaceAnak= urlAjax= "";

      urlAjax= "api/combo/caripegawai";

      $.ajax({
        url: urlAjax,
        type: "GET",
        dataType: "json",
        data: { term: request.term },
        success: function(responseData){
          $(".preloader-wrapper").hide();

          if(responseData == null)
          {
            response(null);
          }
          else
          {
            var array = responseData.map(function(element) {
              return {desc: element['desc'], id: element['id'], label: element['label'], namapegawai: element['namapegawai']};
            });
            response(array);
          }
        }
      })
    },
    // focus: function (event, ui) 
    select: function (event, ui) 
    { 
      var id= $(this).attr('id');
      var indexId= "reqPegawaiId";
      var idrow= namapegawai= "";
      idrow= ui.item.id;
      namapegawai= ui.item.namapegawai;
      
      //if (id.indexOf('reqPenilaianSkpPenilaiNip') !== -1)

      if (id =='reqPenilaianSkpPenilaiNip')
      {
        $("#reqPenilaianSkpPenilaiId").val(idrow);
        $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id =='reqPenilaianSkpAtasanNip')
      {
        $("#reqPenilaianSkpAtasanId").val(idrow);
        $("#reqPenilaianSkpAtasanNama").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpPenilaiNip2')
      {
        $("#reqPenilaianSkpPenilaiId2").val(idrow);
        $("#reqPenilaianSkpPenilaiNama2").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpAtasanNip2')
      {
        $("#reqPenilaianSkpAtasanId2").val(idrow);
        $("#reqPenilaianSkpAtasanNama2").val(namapegawai);
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

  $('#reqPenilaianSkpPenilaiUnorNama, #reqPenilaianSkpAtasanUnorNama, #reqPenilaianSkpPenilaiUnorNama2, #reqPenilaianSkpAtasanUnorNama2, #reqPegawaiUnorNama, #reqPegawaiUnorNama2').each(function(){
  $(this).autocomplete({
    source:function(request, response){
      $(".preloader-wrapper").show();
      var id= this.element.attr('id');
      var replaceAnakId= replaceAnak= urlAjax= "";

      // if (id.indexOf('reqPenilaianSkpPenilaiUnorNama') !== -1)
      if (id == 'reqPenilaianSkpPenilaiUnorNama')
      {
        var element= id.split('reqPenilaianSkpPenilaiUnorNama');
        var indexId= "reqPenilaianSkpPenilaiUnorNama"+element[1];
        urlAjax= "api/combo/skpNamaUnor";
      }
      else if (id == 'reqPenilaianSkpAtasanUnorNama')
      {
        var element= id.split('reqPenilaianSkpAtasanUnorNama');
        var indexId= "reqPenilaianSkpAtasanUnorNama"+element[1];
        urlAjax="api/combo/skpNamaUnor";
      }      
      else if (id == 'reqPenilaianSkpPenilaiUnorNama2')
      {
        var element= id.split('reqPenilaianSkpPenilaiUnorNama2');
        var indexId= "reqPenilaianSkpPenilaiUnorNama2"+element[1];
        urlAjax= "api/combo/skpNamaUnor";
      }
      else if (id == 'reqPenilaianSkpAtasanUnorNama2')
      {
        var element= id.split('reqPenilaianSkpAtasanUnorNama2');
        var indexId= "reqPenilaianSkpAtasanUnorNama2"+element[1];
        urlAjax= "api/combo/skpNamaUnor";
      }
      else if (id == 'reqPegawaiUnorNama')
      {
        var element= id.split('reqPegawaiUnorNama');
        var indexId= "reqPegawaiUnorNama"+element[1];
        urlAjax="api/combo/skpNamaUnor";
      }
      else if (id == 'reqPegawaiUnorNama2')
      {
        var element= id.split('reqPegawaiUnorNama2');
        var indexId= "reqPegawaiUnorNama2"+element[1];
        urlAjax= "api/combo/skpNamaUnor";
      }

      $.ajax({
        url: urlAjax,
        type: "GET",
        dataType: "json",
        data: { term: request.term },
        success: function(responseData){
          $(".preloader-wrapper").hide();

          if(responseData == null)
          {
            response(null);
          }
          else
          {
            var array = responseData.map(function(element) {
              return {desc: element['desc'], id: element['id'], label: element['label']};
            });
            response(array);
          }
        }
      })
    },
    // focus: function (event, ui) 
    select: function (event, ui) 
    { 
      var id= $(this).attr('id');
      
      if (id == 'reqPenilaianSkpPenilaiUnorNama')
      {
        // console.log(ui.item);
        $("#reqPenilaianSkpPenilaiUnorId").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpAtasanUnorNama')
      {
        // console.log(ui.item);
        $("#reqPenilaianSkpAtasanUnorNama").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpPenilaiUnorNama2')
      {
        // console.log(ui.item);
        $("#reqPenilaianSkpPenilaiUnorId2").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPenilaianSkpAtasanUnorNama2')
      {
         // console.log(ui.item);
        $("#reqPenilaianSkpAtasanUnorId2").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPegawaiUnorNama')
      {
         // console.log(ui.item);
        $("#reqPegawaiUnorId").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
      }
      else if (id == 'reqPegawaiUnorNama2')
      {
         // console.log(ui.item);
        $("#reqPegawaiUnorId2").val(ui.item.id);
        // $("#reqPenilaianSkpPenilaiNama").val(namapegawai);
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
</script>


