<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"data_utama"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//


$sessPersonalToken= $this->PERSONAL_TOKEN;
$linkfilename= $this->uri->segment(3, "");
$linkfilenamekembali= str_replace("_add", "", $linkfilename);
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilenamekembali));
$arrdataField= [];
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pegawai_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
// print_r($set);exit;
while($set->nextRow())
{

  $reqStatus= $set->getField("STATUS");
  $reqSatuanKerjaNamaDetil= $set->getField("SATUAN_KERJA_NAMA_DETIL");
  $reqSatuanKerjaId= $set->getField("SATUAN_KERJA_ID");

  $reqJenisPegawaiId= $set->getField("JENIS_PEGAWAI_ID");
  $reqJenisPegawaiNama= $set->getField("JENIS_PEGAWAI_NAMA");

  $reqBpjs= $set->getField("BPJS");
  $reqBpjsTanggal= dateToPageCheck($set->getField("BPJS_TANGGAL"));
  $reqNpwpTanggal= dateToPageCheck($set->getField("NPWP_TANGGAL"));

  $reqEmailKantor= $set->getField("EMAIL_KANTOR");
  $reqRekeningNama= $set->getField("REKENING_NAMA");
  $reqGajiPokok= $set->getField("GAJI_POKOK");
  $reqTunjangan= $set->getField("TUNJANGAN");
  $reqTunjanganKeluarga= $set->getField("TUNJANGAN_KELUARGA");
  $reqGajiBersih= $set->getField("GAJI_BERSIH");
  $reqStatusMutasi= $set->getField("STATUS_MUTASI");
  $reqTmtMutasi= dateToPageCheck($set->getField("TMT_MUTASI"));
  $reqInstansiSebelum= $set->getField("INSTANSI_SEBELUM");

  $reqJenisPegawai= $set->getField("JENIS_PEGAWAI_ID");
  $reqTipePegawai= $set->getField("TIPE_PEGAWAI_ID");
  $reqStatusPegawai= $set->getField("STATUS_PEGAWAI");
  $reqPegawaiStatusNama= $set->getField("PEGAWAI_STATUS_NAMA");
  $reqPegawaiKedudukanTmt= dateToPageCheck($set->getField("PEGAWAI_KEDUDUKAN_TMT"));
  $reqPegawaiKedudukanNama= $set->getField("PEGAWAI_KEDUDUKAN_NAMA");
  $reqNipLama= $set->getField("NIP_LAMA");
  $reqNipBaru= $set->getField("NIP_BARU");
  $reqNama= $set->getField("NAMA");
  $reqGelarDepan= $set->getField("GELAR_DEPAN");
  $reqGelarBelakang= $set->getField("GELAR_BELAKANG");
  $reqTempatLahir= $set->getField("TEMPAT_LAHIR");
  $reqTanggalLahir= $set->getField("TANGGAL_LAHIR");
  $reqJenisKelamin= $set->getField("JENIS_KELAMIN");
  $reqStatusKawin= $set->getField("STATUS_KAWIN");
  $reqSukuBangsa= $set->getField("SUKU_BANGSA");
  $reqGolonganDarah= $set->getField("GOLONGAN_DARAH");
  $reqEmail= $set->getField("EMAIL");
  $reqAlamat= $set->getField("ALAMAT");
  $reqAlamatKeterangan= $set->getField("ALAMAT_KETERANGAN");
  $reqRt= $set->getField("RT");
  $reqRw= $set->getField("RW");
  $reqKodePos= $set->getField("KODEPOS");
  $reqTelepon= $set->getField("TELEPON");
  $reqHp= $set->getField("HP");
  $reqKartuPegawai= $set->getField("KARTU_PEGAWAI");
  $reqAskes= $set->getField("ASKES");
  $reqTaspen= $set->getField("TASPEN");
  $reqNpwp= $set->getField("NPWP");
  $reqNik= $set->getField("NIK");
  $reqNoRekening= $set->getField("NO_REKENING");
  $reqSkKonversiNip= $set->getField("SK_KONVERSI_NIP");
  $reqBank= $set->getField("BANK_ID");
  $reqAgama= $set->getField("AGAMA_ID");
  $reqUrut= $set->getField("NO_URUT");
  $reqNoKk= $set->getField("NO_KK");
  $reqNoRakBerkas= $set->getField("NO_RAK_BERKAS");
  $reqTeleponKantor= $set->getField("TELEPON_KANTOR");
  $reqFacebook= $set->getField("FACEBOOK");
  $reqTwitter= $set->getField("TWITTER");
  $reqWhatsApp= $set->getField("WHATSAPP");
  $reqTelegram= $set->getField("TELEGRAM");
  $reqKeterangan1= $set->getField("KETERANGAN_1");
  $reqKeterangan2= $set->getField("KETERANGAN_2");

  $reqPropinsiId= $set->getField("PROPINSI_ID");
  $reqPropinsi= $set->getField("PROPINSI_NAMA");
  $reqKabupatenId= $set->getField("KABUPATEN_ID");
  $reqKabupaten= $set->getField("KABUPATEN_NAMA");
  $reqKecamatanId= $set->getField("KECAMATAN_ID");
  $reqKecamatan= $set->getField("KECAMATAN_NAMA");
  $reqDesaId= $set->getField("DESA_ID");
  $reqDesa= $set->getField("DESA_NAMA");

  $reqTempValidasiId= $set->getField("TEMP_VALIDASI_ID");
  $reqTempValidasiHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
  $reqValidasi= $set->getField("VALIDASI");
  $reqPerubahanData= $set->getField("PERUBAHAN_DATA");
  $reqCheckPegawaiId= $set->getField("PEGAWAI_ID");
  $reqValRowId= $set->getField("PANGKAT_RIWAYAT_ID");

}  


$arrAgama= [];
$set= new DataCombo();
$set->selectby($sessPersonalToken, "agama", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("AGAMA_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrAgama, $arrdata);
}
$arrJenisPegawai= [];
$set->selectby($sessPersonalToken, "jenis_pegawai", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("JENIS_PEGAWAI_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrJenisPegawai, $arrdata);
} 

$arrBank= [];
$set->selectby($sessPersonalToken, "bank", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("BANK_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrBank, $arrdata);
} 
$arrListFile= [];
$set->selectby($sessPersonalToken, "listpilihfilepegawai", $arrdata);
while($set->nextRow())
{
  $arrdata= [];
  $arrdata["id"]= $set->getField("BANK_ID");
  $arrdata["text"]= $set->getField("NAMA");
  array_push($arrListFile, $arrdata);
} 

$arrparam= ["token"=>$sessPersonalToken,"", "vurl"=>"Pegawai_file_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
$arrDataFile = $set->rowResult;
$arrDatPathFile =  in_array_column('PEGAWAI', "riwayat_table", $arrDataFile);

$arrDatPathFileNama = array();
foreach($arrDatPathFile as $value){
  $stringId = $arrDataFile[$value]['riwayat_id'];
  $stringPath = $arrDataFile[$value]['path'];
  $arrDatPathFileNama[$stringId]=  $stringPath ;
}

$tempPathKarpeg= $arrDatPathFileNama[3];
$tempPathTaspen=  $arrDatPathFileNama[4];
$tempPathSkKonversiNip= $arrDatPathFileNama[2];
$tempPathNik=$arrDatPathFileNama[5];
$tempPathKartuKeluarga=$arrDatPathFileNama[6];
$tempPathNpwp= $arrDatPathFileNama[7];
$reqPathBpjs= $arrDatPathFileNama[9];

$vNama= checkwarna($reqPerubahanData, 'NAMA');
$vTempatLahir = checkwarna($reqPerubahanData, 'TEMPAT_LAHIR');
$vKartuPegawai = checkwarna($reqPerubahanData, 'KARTU_PEGAWAI');
$vBpjs = checkwarna($reqPerubahanData, 'BPJS');
$vAlamatKeterangan = checkwarna($reqPerubahanData, 'ALAMAT_KETERANGAN');
$vEmailKantor = checkwarna($reqPerubahanData, 'EMAIL_KANTOR');
$vRekeningNama = checkwarna($reqPerubahanData, 'REKENING_NAMA');
$vAgama =checkwarna($reqPerubahanData, 'AGAMA_ID', $arrAgama, array("id", "text"), $reqTempValidasiHapusId);
$vJenisKelamin =checkwarna($reqPerubahanData, 'JENIS_KELAMIN', $arrAgama, array("id", "text"), $reqTempValidasiHapusId);

?>





<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>Data Utama</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman data utama</span>
      </h6>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Data Pribadi</div>
      <form class="form-horizontal "  id="ff" method="post" novalidate enctype="multipart/form-data">

        <div class="form-group">
          <label class="control-label col-sm-2" for="">NIP Baru:
          
          </label>
          <div class="col-sm-4">
            <input type="text" name="reqNipBaru"  id="reqNipBaru" readonly class="form-control"   value="<?=$reqNipBaru?>">
          </div>
          <label class="control-label col-sm-2" for="">NIP Lama:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control"   name="reqNipLama" readonly id="reqNipLama" value="<?=$reqNipLama?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">
          Nama <?
              $warnadata= $vNama['data'];
              $warnaclass= $vNama['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control <?=$warnaclass?>"   name="reqNama" id="reqNama"  readonly value="<?=$reqNama?>" >
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Status Pegawai:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="reqStatusPegawai"  readonly  value="<?=$reqPegawaiStatusNama?>">
          </div>
          <label class="control-label col-sm-2" for="">Kedudukan:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="reqPegawaiKedudukanNama"  readonly id="reqPegawaiKedudukanNama" value="<?=$reqPegawaiKedudukanNama?>">
          </div>
          <label class="control-label col-sm-2" for="">TMT Kedudukan:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="reqPegawaiKedudukanTmt" readonly value="<?=$reqPegawaiKedudukanTmt?> ">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">
            
          Tempat Lahir <?
            $warnadata= $vTempatLahir['data'];
            $warnaclass= $vTempatLahir['warna'];
            if(!empty($warnadata))
            {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
            }
            ?>:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control <?=$warnaclass?>" id="reqTempatLahir" name="reqTempatLahir" class="easyui-validatebox" value="<?=$reqTempatLahir?>">
          </div>
          <label class="control-label col-sm-2" for="">Jenis Kelamin 
            <?
              $warnadata= $vJenisKelamin['data'];
              $warnaclass= $vJenisKelamin['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
          <div class="col-sm-2">
            <select id="reqJenisKelamin" name="reqJenisKelamin" class="form-control <?=$warnaclass?>" >
              <option value=""></option>
              <option value="L" <? if($reqJenisKelamin == "L") echo "selected"?>>Laki-laki</option>
              <option value="P" <? if($reqJenisKelamin == "P") echo "selected"?>>Perempuan</option>
            </select>
          </div>
          <label class="control-label col-sm-2" for="">Gol Darah:</label>
          <div class="col-sm-2">
            <select  name="reqGolonganDarah" id="reqGolonganDarah">
              <option value="" <? if($reqGolonganDarah=="")echo "selected"?>></option>
              <option value="A" <? if($reqGolonganDarah=='A') echo ' selected'?>>A</option>
              <option value="B" <? if($reqGolonganDarah=='B') echo ' selected'?>>B</option>
              <option value="AB" <? if($reqGolonganDarah=='AB') echo ' selected'?>>AB</option>
              <option value="O" <? if($reqGolonganDarah=='O') echo ' selected'?>>O</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Agama 
            <?
              $warnadata= $vAgama['data'];
              $warnaclass= $vAgama['warna'];
              if(!empty($warnadata))
              {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
              }
              ?>:</label>
          <div class="col-sm-4">
            <select name="reqAgama" id="reqAgama" class="form-control <?=$warnaclass?>" >
               <?
               foreach ($arrAgama as $key => $value)
               {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqAgama == $optionid)
                  $optionselected= "selected";
                ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
              }
              ?>
            </select>
          </div>
          <label class="control-label col-sm-2" for="">Suku Bangsa:</label>
          <div class="col-sm-4">
            <input name="reqSukuBangsa" id="reqSukuBangsa"  type="text" class="form-control"type="text" value="<?=$reqSukuBangsa?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Jenis Pegawai:</label>
          <div class="col-sm-6">
            <select name="reqJenisPegawaiId" id="reqJenisPegawaiId" class="form-control ">
              <?
               foreach ($arrJenisPegawai as $key => $value)
               {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqJenisPegawaiId == $optionid)
                  $optionselected= "selected";
                ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
              }
              ?>
            </select>
          </div>
          
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Satuan Kerja:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" readonly  value="<?=$reqSatuanKerjaNamaDetil?>">
            <input type="hidden" name="reqSatuanKerjaId" readonly id="reqSatuanKerjaId" value="<?=$reqSatuanKerjaId?>" />
          </div>
          
        </div>

        

        <!-- <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="Isikan email">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Password:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="pwd" placeholder="Isikan password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label><input type="checkbox"> Remember me</label>
            </div>
          </div>
        </div> -->
        <!-- <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div> -->
      

      <div class="judul-panel">Dokumen Pribadi</div>
      
        
        <div class="form-group">
          <label class="control-label col-sm-2" for="">NIK:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control easyui-validatebox" id="reqNik" name="reqNik" data-options="validType:'length[16,16]'" maxlength="16" minlength="16" placeholder="Isikan NIK" value="<?=$reqNik?>">
          </div>

          <label class="control-label col-sm-2" for="">No. KK:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Isikan No. KK" value="<?=$reqNoKk?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Kartu Pegawai 
            <?
            $warnadata= $vKartuPegawai['data'];
            $warnaclass= $vKartuPegawai['warna'];
            if(!empty($warnadata))
            {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
            }
            ?>:</label>
          <div class="col-sm-4">
            <div class="row">
              <div class="col-sm-8">
                <input type="text" class="form-control <?=$warnaclass?>" id="reqKartuPegawai" name="reqKartuPegawai" placeholder="Isikan Kartu Pegawai" value="<?=$reqKartuPegawai?>">
              </div>
              <div class="col">
                <?
                if($tempPathKarpeg == "")
                {
                  ?>
                  &nbsp;
                  <?
                }
                else
                {
                  ?>
                  <a href="<?=base_url().$tempPathKarpeg?>" target="_new" class="btn-floating green"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 25px;"></i></a>
                  <?
                }
                ?>
              </div>
             </div> 
          </div>
          

          <!-- <label class="control-label col-sm-2" for="">No. KK:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Isikan No. KK" value="<?=$reqNoKk?>">
          </div> -->
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">BPJS  
            <?
            $warnadata= $vBpjs['data'];
            $warnaclass= $vBpjs['warna'];
            if(!empty($warnadata))
            {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
            }
            ?>:</label>
          <div class="col-sm-4">
             <div class="row">
              <div class="col-sm-8">
               <input type="text" class="form-control <?=$warnaclass?>" id="reqBpjs" name="reqBpjs" placeholder="Isikan BPJS" value="<?=$reqBpjs?>">
             </div>
              <div class="col">
                <?
                if($reqPathBpjs == "")
                {
                  ?>
                  &nbsp;
                  <?
                }
                else
                {
                  ?>
                  <a href="<?=base_url().$reqPathBpjs?>" target="_new" class="btn-floating btn-small waves-effect waves-light green"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 25px;"></i></a>
                  <?
                }
                ?>
              </div>
              </div>
          </div>


          <label class="control-label col-sm-2" for="">Tanggal BPJS:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqBpjsTanggal" onKeyDown="return format_date(event,'reqBpjsTanggal');" name="reqBpjsTanggal"  placeholder="Isikan Tanggal BPJS" value="<?=$reqBpjsTanggal?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">NPWP:</label>
          <div class="col-sm-4">
            <div class="row">
              <div class="col-sm-8">
                <input type="text" class="form-control " id="reqNpwp" name="reqNpwp" placeholder="Isikan NPWP" value="<?=$reqNpwp?>">
              </div>
              <div class="col">
                <?
                if($tempPathNpwp == "")
                {
                  ?>
                  &nbsp;
                  <?
                }
                else
                {
                  ?>
                  <a href="<?=base_url().$tempPathNpwp?>" target="_new" class="btn-floating btn-small waves-effect waves-light green"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 25px;"></i></a>
                  <?
                }
                ?>
              </div>
            </div>
          </div>

          <label class="control-label col-sm-2" for="">Tanggal NPWP:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control formattanggalnew" id="reqNpwpTanggal" maxlength="10" onKeyDown="return format_date(event,'reqNpwpTanggal');"  name="reqNpwpTanggal" placeholder="Isikan Tanggal NPWP" value="<?=$reqNpwpTanggal?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">SK Konversi NIP:</label>
          <div class="col-sm-4">
            <div class="row">
              <div class="col-sm-8">
                <input type="text" class="form-control" id="reqSkKonversiNip" name="reqSkKonversiNip" placeholder="Isikan SK Konversi NIP" value="<?=$reqSkKonversiNip?>">
              </div>
              <div class="col">
               <?
               if($tempPathSkKonversiNip == "")
               {
                ?>
                &nbsp;
                <?
              }
              else
              {
                ?>
                <a href="<?=base_url().$tempPathSkKonversiNip?>" target="_new" class="btn-floating btn-small waves-effect waves-light green"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 25px;"></i></a>
                <?
              }
              ?>
              </div>
            </div>
          </div>

          <label class="control-label col-sm-2" for="">No. Urut SK Konversi NIP:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="reqUrut" name="reqUrut" placeholder="Isikan No. Urut SK Konversi NIP" value="<?=$reqUrut?>">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">No. Rak Berkas Arsip:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="reqNoRakBerkas" name="reqNoRakBerkas" placeholder="Isikan No. Rak Berkas Arsip" value="<?=$reqNoRakBerkas?>">
          </div>

          <!-- <label class="control-label col-sm-2" for="">No. Urut SK Konversi NIP:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Isikan No. KK" value="<?=$reqNoKk?>">
          </div> -->
        </div>

        <!-- <div class="form-group">
          <label class="control-label col-sm-2" for="">File:</label>
          <div class="col-sm-4">
            <input type="file" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Radio Button:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
          <label class="control-label col-sm-2" for="">Check Box:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
        </div> -->
        
    

      <div class="judul-panel">Alamat</div>
   
        
        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Propinsi:</label>
            <div class="col-sm-4">
              
              <input type="hidden" name="reqPropinsiId" id="reqPropinsiId" value="<?=$reqPropinsiId?>" /> 
              <input type="text" class="easyui-validatebox" id="reqPropinsi" 
              data-options="validType:['sameAutoLoder[\'reqPropinsi\', \'\']']"
              value="<?=$reqPropinsi?>" />
            </div>

            <label class="control-label col-sm-2" for="">Kabupaten:</label>
            <div class="col-sm-4">
              <input type="hidden" name="reqKabupatenId" id="reqKabupatenId" value="<?=$reqKabupatenId?>" /> 
              <input type="text" class="easyui-validatebox" id="reqKabupaten" 
              data-options="validType:['sameAutoLoder[\'reqKabupaten\', \'\']']"
              value="<?=$reqKabupaten?>" />
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Kecamatan:</label>
            <div class="col-sm-4">
              <input type="hidden" name="reqKecamatanId" id="reqKecamatanId" value="<?=$reqKecamatanId?>" /> 
                              <input type="text" class="easyui-validatebox" id="reqKecamatan" 
                              data-options="validType:['sameAutoLoder[\'reqKecamatan\', \'\']']"
                              value="<?=$reqKecamatan?>" />
            </div>

            <label class="control-label col-sm-2" for="">Desa:</label>
            <div class="col-sm-4">
              <input type="hidden" name="reqDesaId" id="reqDesaId" value="<?=$reqDesaId?>" /> 
                              <input type="text" class="easyui-validatebox" id="reqDesa" 
                              data-options="validType:['sameAutoLoder[\'reqDesa\', \'\']']"
                              value="<?=$reqDesa?>" />
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">RT:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control"  name="reqRt" id="reqRt" placeholder="Isikan RT"  value="<?=$reqRt?>">
            </div>

            <label class="control-label col-sm-2" for="">RW:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="reqRw" id="reqRw" placeholder="Isikan RW" value="<?=$reqRw?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Alamat:</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="reqAlamat" id="reqAlamat"  rows="4" placeholder="Isikan Alamat" cols="30"><?=$reqAlamat?></textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Keterangan
             <?
            $warnadata= $vAlamatKeterangan['data'];
            $warnaclass= $vAlamatKeterangan['warna'];
            if(!empty($warnadata))
            {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
            }
            ?>:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control <?=$warnaclass?>" name="reqAlamatKeterangan" id="reqAlamatKeterangan" placeholder="Isikan Keterangan" value="<?=$reqAlamatKeterangan?>">
            </div>

            <!-- <label class="control-label col-sm-2" for="">No. Urut SK Konversi NIP:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Isikan No. KK" value="<?=$reqNoKk?>">
            </div> -->
          </div>
        </div>    
   

      <div class="judul-panel">Kontak</div>
      
        
        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">No. HP:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="reqHp" id="reqHp" placeholder="Isikan Kontak" value="<?=$reqHp?>">
            </div>

            <label class="control-label col-sm-2" for="">No. Telepon Kantor:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="reqTeleponKantor" id="reqTeleponKantor" placeholder="Isikan No. Telepon Kantor" value="<?=$reqTeleponKantor?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">No. Telepon Rumah:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="reqTelepon" id="reqTelepon" placeholder="Isikan No. Telepon Rumah" value="<?=$reqTelepon?>" >
            </div>

            <!-- <label class="control-label col-sm-2" for="">Desa:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Isikan No. KK" value="<?=$reqNoKk?>">
            </div> -->
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Email Pribadi:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="reqEmail" id="reqEmail" placeholder="Isikan Email Pribadi" value="<?=$reqEmail?>" >
            </div>

            <label class="control-label col-sm-2" for="">Email go.id
              <?
            $warnadata= $vEmailKantor['data'];
            $warnaclass= $vEmailKantor['warna'];
            if(!empty($warnadata))
            {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
            }
            ?>:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control <?=$warnaclass?>" name="reqEmailKantor" id="reqEmailKantor" placeholder="Isikan Email go.id" value="<?=$reqEmailKantor?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Facebook:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="reqFacebook" id="reqFacebook"  placeholder="Isikan Facebook" value="<?=$reqFacebook?>">
            </div>

            <label class="control-label col-sm-2" for="">Twitter:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="reqTwitter" id="reqTwitter" placeholder="Isikan Twitter"  value="<?=$reqTwitter?>" >
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">WhatsApp:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="reqWhatsApp" id="reqWhatsApp"  placeholder="Isikan WhatsApp" value="<?=$reqWhatsApp?>">
            </div>

            <label class="control-label col-sm-2" for="">Telegram:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="reqTelegram" id="reqTelegram" placeholder="Isikan Telegram"  value="<?=$reqTelegram?>">
            </div>
          </div>
        </div>    
     

      <div class="judul-panel">Finansial</div>
     
        
        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Bank:</label>
            <div class="col-sm-4">
            <select name="reqBank" id="reqBank" class="form-control ">
              <?
               foreach ($arrBank as $key => $value)
               {
                $optionid= $value["id"];
                $optiontext= $value["text"];
                $optionselected= "";
                if($reqBank == $optionid)
                  $optionselected= "selected";
                ?>
                <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
              }
              ?>
            </select>
            </div>

            <label class="control-label col-sm-2" for="">No. Rekening:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="reqNoRekening" id="reqNoRekening" placeholder="Isikan No. Rekening" value="<?=$reqNoRekening?>" >
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Nama Pemilik Rekening (Sesuai Buku Rekening)
              <?
            $warnadata= $vRekeningNama['data'];
            $warnaclass= $vRekeningNama['warna'];
            if(!empty($warnadata))
            {
              ?>
              <span aria-label="<?=$warnadata?>" class="tooltip-red" data-balloon-pos="up"><i class="fa fa-question-circle"></i></span>
              <?
            }
            ?>:</label>
            <div class="col-sm-9">
              <input type="text" class="form-control <?=$warnaclass?>" name="reqRekeningNama" id="reqRekeningNama" placeholder="Isikan Nama Pemilik Rekening" value="<?=$reqRekeningNama?>">
            </div>

            <!-- <label class="control-label col-sm-2" for="">Desa:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Isikan No. KK" value="<?=$reqNoKk?>">
            </div> -->
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Gaji Pokok:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqGajiPokok" name="reqGajiPokok" OnFocus="FormatAngka('reqGajiPokok')" OnKeyUp="FormatUang('reqGajiPokok')" OnBlur="FormatUang('reqGajiPokok')" value="<?=numberToIna($reqGajiPokok)?>" placeholder="Isikan Gaji Pokok">
            </div>

            <label class="control-label col-sm-2" for="">Tunjangan Keluarga:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control"  id="reqTunjanganKeluarga" name="reqTunjanganKeluarga" OnFocus="FormatAngka('reqTunjanganKeluarga')" OnKeyUp="FormatUang('reqTunjanganKeluarga')" OnBlur="FormatUang('reqTunjanganKeluarga')" value="<?=numberToIna($reqTunjanganKeluarga)?>" placeholder="Isikan Tunjangan Keluarga">
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Tunjangan / Penghasilan Lainnya:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqTunjangan" name="reqTunjangan" OnFocus="FormatAngka('reqTunjangan')" OnKeyUp="FormatUang('reqTunjangan')" OnBlur="FormatUang('reqTunjangan')" value="<?=numberToIna($reqTunjangan)?>" placeholder="Isikan Tunjangan / Penghasilan Lainnya" >
            </div>

            <label class="control-label col-sm-2" for="">Gaji Bersih:</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="reqGajiBersih" name="reqGajiBersih" OnFocus="FormatAngka('reqGajiBersih')" OnKeyUp="FormatUang('reqGajiBersih')" OnBlur="FormatUang('reqGajiBersih')" value="<?=numberToIna($reqGajiBersih)?>" placeholder="Isikan Gaji Bersih">
            </div>
          </div>
        </div>
      

      <div class="judul-panel">Lainnya</div>
      
        
        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Mutasi Masuk Daerah:</label>
            <div class="col-sm-4">
             

            <?
            $stringYaTidak = "Tidak";
            if($reqStatusMutasi=='1'){ $stringYaTidak = "Ya";}
            ?>
             <input type="text" class="form-control" readonly="" value="<?=$stringYaTidak?>" >
             <input type="hidden" class="form-control" name="reqStatusMutasi" value="<?=$reqStatusMutasi?>" >

            </div>

            <!-- <label class="control-label col-sm-2" for="">No. Rekening:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="reqNoKk" name="reqNoKk" placeholder="Isikan No. KK" value="<?=$reqNoKk?>">
            </div> -->
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Keterangan 1:</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="reqKeterangan1" id="reqKeterangan1" placeholder="Isikan Keterangan 1" readonly rows="4" cols="30"><?=$reqKeterangan1?></textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-group">
            <label class="control-label col-sm-2" for="">Keterangan 2:</label>
            <div class="col-sm-9">
              <textarea class="form-control" name="reqKeterangan2" id="reqKeterangan2" placeholder="Isikan Keterangan 2" readonly  rows="4" cols="30"><?=$reqKeterangan2?></textarea>
            </div>
          </div>
        </div>

        <div class="form-group">
          <input type="hidden" name="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqRowId" value="<?=$reqValRowId?>" />
            <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>" />
            <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-4">
            <?
              if(strtoupper($vaksesmenu) == strtoupper("A"))
            {
            ?>
            <button type="submit" id="simpan" class="btn btn-primary">Submit</button>
            <?
            }
            ?>
           <!--  <button type="reset" class="btn btn-default">Reset</button> -->
          </div>
        </div>
      </form>

        

      <!-- <div class="judul-panel">Contoh Data Lain</div>
      <form class="form-horizontal" action="/action_page.php">
        
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Textarea:</label>
          <div class="col-sm-4">
            <textarea class="form-control" name="message" rows="4" cols="30">
              The cat was playing in the garden.
            </textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">File:</label>
          <div class="col-sm-4">
            <input type="file" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="">Radio Button:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="radio" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
          <label class="control-label col-sm-2" for="">Check Box:</label>
          <div class="col-sm-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio1" name="optradio" value="option1" checked> Option 1
              <label class="form-check-label" for="radio1"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="radio2" name="optradio" value="option2"> Option 2
              <label class="form-check-label" for="radio2"></label>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" disabled> Option 3
              <label class="form-check-label"></label>
            </div> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-sm-2" for=""></label>
          <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-default">Reset</button>
          </div>
        </div>

        
      </form> -->



    </div>
    
  </div>
</div>


  
<!-- AUTO KOMPLIT -->
  <link rel="stylesheet" href="assets/autokomplit/jquery-ui.css">
  <script src="assets/autokomplit/jquery-ui.js"></script>

<script type="text/javascript">
  $('input[id^="reqPropinsi"], input[id^="reqKabupaten"], input[id^="reqKecamatan"], input[id^="reqDesa"]').each(function(){
        $(this).autocomplete({
          source:function(request, response){
            var id= this.element.attr('id');
            var replaceAnakId= replaceAnak= urlAjax= "";

            if (id.indexOf('reqPropinsi') !== -1)
            {
              var element= id.split('reqPropinsi');
              var indexId= "reqPropinsiId"+element[1];
              urlAjax= "api/combo/propinsi";
              replaceAnakId= "reqKabupatenId";
              replaceAnak= "reqKabupaten";
              $("#reqKabupatenId, #reqKecamatanId, #reqDesaId").val("");
              $("#reqKabupaten, #reqKecamatan, #reqDesa").val("");
            }
            else if (id.indexOf('reqKabupaten') !== -1)
            {
              var element= id.split('reqKabupaten');
              var indexId= "reqKabupatenId"+element[1];
              var idPropVal= $("#reqPropinsiId").val();
              urlAjax= "api/combo/kabupaten?reqPropinsiId="+idPropVal;
              replaceAnakId= "reqKecamatanId";
              replaceAnak= "reqKecamatan";
              $("#reqKecamatanId, #reqDesaId").val("");
              $("#reqKecamatan, #reqDesa").val("");
            }
            else if (id.indexOf('reqKecamatan') !== -1)
            {
              var element= id.split('reqKecamatan');
              var indexId= "reqKecamatanId"+element[1];
              var idPropVal= $("#reqPropinsiId").val();
              var idKabVal= $("#reqKabupatenId").val();
              urlAjax= "api/combo/kecamatan/?reqPropinsiId="+idPropVal+"&reqKabupatenId="+idKabVal;
              replaceAnakId= "reqDesaId";
              replaceAnak= "reqDesa";
              $("#reqDesaId").val("");
              $("#reqDesa").val("");
            }
            else if (id.indexOf('reqDesa') !== -1)
            {
              var element= id.split('reqDesa');
              var indexId= "reqDesaId"+element[1];
              var idPropVal= $("#reqPropinsiId").val();
              var idKabVal= $("#reqKabupatenId").val();
              var idKecVal= $("#reqKecamatanId").val();
              urlAjax= "api/combo/kelurahan?reqPropinsiId="+idPropVal+"&reqKabupatenId="+idKabVal+"&reqKecamatanId="+idKecVal;
            }

            $.ajax({
              url: urlAjax,
              type: "GET",
              dataType: "json",
              data: { term: request.term },
              success: function(responseData){
                $("#"+indexId).val("").trigger('change');
                if(replaceAnakId == ""){}
                else
                {
                  $("#"+replaceAnakId).val("").trigger('change');
                  $("#"+replaceAnak).val("").trigger('change');
                }

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
          focus: function (event, ui) 
          { 
            var id= $(this).attr('id');

            var replaceAnakId= replaceAnak= "";
            
            if (id.indexOf('reqPropinsi') !== -1)
            {
              var element= id.split('reqPropinsi');
              var indexId= "reqPropinsiId"+element[1];
              replaceAnakId= "reqKabupatenId";
              replaceAnak= "reqKabupaten";
              $("#reqKabupatenId, #reqKecamatanId, #reqDesaId").val("");
              $("#reqKabupaten, #reqKecamatan, #reqDesa").val("");
            }
            else if (id.indexOf('reqKabupaten') !== -1)
            {
              var element= id.split('reqKabupaten');
              var indexId= "reqKabupatenId"+element[1];
              replaceAnakId= "reqKecamatanId";
              replaceAnak= "reqKecamatan";
              $("#reqKecamatanId, #reqDesaId").val("");
              $("#reqKecamatan, #reqDesa").val("");
            }
            else if (id.indexOf('reqKecamatan') !== -1)
            {
              var element= id.split('reqKecamatan');
              var indexId= "reqKecamatanId"+element[1];
              replaceAnakId= "reqDesaId";
              replaceAnak= "reqDesa";
              $("#reqDesaId").val("");
              $("#reqDesa").val("");
            }
            else if (id.indexOf('reqDesa') !== -1)
            {
              var element= id.split('reqDesa');
              var indexId= "reqDesaId"+element[1];
            }

            $("#"+indexId).val(ui.item.id).trigger('change');
          },
          autoFocus: true
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
          .append( "<a>" + item.desc  + "</a>" )
          .appendTo( ul );
        };
      });
</script>
<script type="text/javascript">
 
$(function(){
  $('#reqNoKk,#reqNik,#reqHp,#reqTeleponKantor,#reqTelepon').bind('keyup paste', function(){
      this.value = this.value.replace(/[^0-9]/g, '');
    });

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
  });
</script>