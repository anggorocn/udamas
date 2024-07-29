<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$this->load->library('globalmenu');
// untuk hak akses menu
$gmenu= new globalmenu();
$arrgetaksesmenu= ["key"=>"skp_ppk_detil"];
$vaksesmenu= $gmenu->getaksesmenu($arrgetaksesmenu);
//-----------------//

$sessPersonalToken= $this->PERSONAL_TOKEN;

$linkfilename= $this->uri->segment(3, "");
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilename));
$linkfilenameadd= $linkfilename."_add";

$arrtabledata= array(
    array("label"=>"Tahun", "field"=> "TAHUN", "display"=>"",  "width"=>"")
    , array("label"=>"Periode", "field"=> "NAMA_TRIWULAN", "display"=>"", "width"=>"")
   
    
    , array("label"=>"Status", "field"=> "STATUS", "display"=>"", "width"=>"")

    , array("label"=>"Aksi", "field"=> "AKSI", "display"=>"", "width"=>"")
);


$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Penilaian_detail_skp_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");

  /*$.confirm({
    title: 'Aksi Data',skp_ppk
    content: 'Yakin hapus?',
    buttons: {
      yakin: function () {

      },
      batal: function () {
      }
    }
  });*/
?>
<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>Data Kinerja Detil</h1>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Kinerja Detil</div>
      <div class="inner">
        <?
         if(strtoupper($vaksesmenu) == strtoupper("A"))
       {
        ?>
        <button type="button" onclick='document.location.href="app/index/skp_ppk_detil_add?reqId=baru"' class="btn btn-xs btn-info">Tambah</button>
        <?
        } 
        ?>
        <table class="table">
          <thead>
            <tr>
              <?php
              foreach($arrtabledata as $valkey => $valitem) 
              {
                  echo "<th>".$valitem["label"]."</th>";
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?


            while($set->nextRow())
            {
              $reqId= $set->getField("PENILAIAN_SKP_DETIL_ID");
              $reqRowId= $set->getField("TEMP_VALIDASI_ID");
                $reqJenisJabatan= $set->getField('JENIS_JABATAN_ID');
              // var_dump($reqRowId);
              $reqHapusId= $set->getField("TEMP_VALIDASI_HAPUS_ID");
          

            ?>
            <tr>
              <?php
              foreach($arrtabledata as $valkey => $valitem) 
              {
              ?>
                <td>
              <?
                  $field= $valitem["field"];
                  if($field == "TANGGAL_SELESAI")
                    $vtext= dateToPageCheck($set->getField($field));
                  else if($field == "AKSI")
                  {
                     if(strtoupper($vaksesmenu) == strtoupper("D")){}
                    else
                    {
                    if(!empty($reqId) && empty($reqRowId) && empty($reqHapusId))
                    {
                    ?>
                      <button type="button" onclick='document.location.href="app/index/<?=$linkfilenameadd?>?reqId=<?=$reqId?>"' class="btn btn-xs btn-primary">Ubah</button>
                    <?
                    }
                    elseif(!empty($reqRowId))
                    {
                    ?>
                      <button type="button" onclick='document.location.href="app/index/<?=$linkfilenameadd?>?reqRowId=<?=$reqRowId?>"' class="btn btn-xs btn-primary">Ubah</button>
                    <?
                    }
                    if(!empty($reqRowId))
                    {
                    ?>
                      <button class="btn btn-xs btn-danger" type="button" onclick="hapusdata('<?=$reqRowId?>', 'jabatan_riwayat', '', '<?=$linkfilename?>')">Batal</button>
                    <?
                    }
                    if(!empty($reqHapusId))
                    {
                    ?>
                      <button class="btn btn-xs btn-danger" type="button" onclick="hapusdata('<?=$reqHapusId?>', 'jabatan_riwayat', '2', '<?=$linkfilename?>')">Batal</button>
                    <?
                    }
                  }
                  }
                  else
                    $vtext= $set->getField($field);

                  if($field == "AKSI"){}
                  else
                  {
                    echo $vtext;
                  }
              ?>
                </td>
              <?
              }
              ?>
            </tr>
            <?
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    
  </div>
</div>