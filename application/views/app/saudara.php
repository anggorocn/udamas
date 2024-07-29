<?
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
$linkfilenamelabel= ucwords(str_replace("_", " ", $linkfilename));
$linkfilenameadd= $linkfilename."_add";

$arrtabledata= array(
    array("label"=>"Nama", "field"=> "NAMA", "display"=>"",  "width"=>"")
    , array("label"=>"Tempat Lahir", "field"=> "TEMPAT_LAHIR", "display"=>"", "width"=>"")
    , array("label"=>"Tanggal Lahir", "field"=> "TANGGAL_LAHIR", "display"=>"", "width"=>"")
    , array("label"=>"Jenis Kelamin", "field"=> "JENIS_KELAMIN", "display"=>"", "width"=>"")
    , array("label"=>"Status Saudara", "field"=> "STATUS_SDR_NAMA", "display"=>"", "width"=>"")
    , array("label"=>"Status Aktif", "field"=> "STATUS_HIDUP_NAMA", "display"=>"", "width"=>"")
    , array("label"=>"Last Create/Update", "field"=> "LAST_DATE", "display"=>"", "width"=>"")
    , array("label"=>"Last User Access", "field"=> "LAST_USER", "display"=>"", "width"=>"")
    , array("label"=>"Status", "field"=> "STATUS", "display"=>"", "width"=>"")

    , array("label"=>"Aksi", "field"=> "AKSI", "display"=>"", "width"=>"")
);

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"saudara_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");

  /*$.confirm({
    title: 'Aksi Data',
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
      <h1>Data <?=$linkfilenamelabel?></h1>
    </div>

    <div class="area-panel">
      <div class="judul-panel"><?=$linkfilenamelabel?></div>
      <div class="inner">
        <?
          if(strtoupper($vaksesmenu) == strtoupper("A"))
       {
        ?>
        <button type="button" onclick='document.location.href="app/index/<?=$linkfilenameadd?>?reqId=baru"' class="btn btn-xs btn-info">Tambah</button>
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
              $reqId= $set->getField("SAUDARA_ID");
              $reqRowId= $set->getField("TEMP_VALIDASI_ID");
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
                      <button class="btn btn-xs btn-danger" type="button" onclick="hapusdata('<?=$reqRowId?>', 'saudara', '', '<?=$linkfilename?>')">Batal</button>
                    <?
                    }
                    if(!empty($reqHapusId))
                    {
                    ?>
                      <button class="btn btn-xs btn-danger" type="button" onclick="hapusdata('<?=$reqHapusId?>', 'saudara', '2', '<?=$linkfilename?>')">Batal</button>
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