<?
include_once("functions/personal.func.php");
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");


 

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

       <div class="row">
         <div class="form-group">
          <label class="control-label col-sm-2" for="">Tahun:</label>
          <div class="col-sm-3">
            <select id="reqTahun" name="reqTahun" class="form-control" >
             <?
             $arrTahun[0] =array("id"=>2023,"text"=>2023);
             foreach ($arrTahun as $key => $value)
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
     </div>
      <div class="row">
         <div class="form-group">
          <label class="control-label col-sm-2" for="">Triwulan
:</label>
          <div class="col-sm-3">
            <select id="reqTahun" name="reqTahun" class="form-control" >
             <?
             $arrTahun[0] =array("id"=>2023,"text"=>2023);
             foreach ($arrTahun as $key => $value)
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
                <label class="control-label col-sm-2" for="">NIP: </label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control easyui-validatebox "  id="reqPenilaianSkpDinilaiNama" name="reqPenilaianSkpDinilaiNama" readonly placeholder="Isikan Nama" value="<?=$reqPenilaianSkpDinilaiNama?>">
                </div>
              </div> 
            </li>
            <li> 
             <div class="form-group">
                <label class="control-label col-sm-2" for="">Jenis Jabatan PNS Yang Dinilai: </label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control easyui-validatebox "  id="reqPenilaianSkpDinilaiNama" name="reqPenilaianSkpDinilaiNama" readonly placeholder="Isikan Nama" value="<?=$reqPenilaianSkpDinilaiNama?>">
                </div>
              </div> 
            </li>
             <li> 
             <div class="form-group">
                <label class="control-label col-sm-2" for="">Unit Kerja PNS Yang Dinilai: </label>
                <div class="col-sm-8">
                  <input type="text"  class="form-control easyui-validatebox "  id="reqPenilaianSkpDinilaiNama" name="reqPenilaianSkpDinilaiNama" readonly placeholder="Isikan Nama" value="<?=$reqPenilaianSkpDinilaiNama?>">
                </div>
              </div> 
            </li>
          </ol>
          </div>
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


