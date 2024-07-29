<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pegawai_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
$set->firstRow();

$reqLoginUser= $set->getField('NIP_BARU');
$reqRowId= $set->getField('PEGAWAI_ID');
$reqNama= $set->getField('NAMA_LENGKAP');
$reqSatkerId= $set->getField('SATUAN_KERJA_ID');
// print_r($arrData);
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
        url:"api/Ganti_password_json/add"
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
                  document.location.href = "app/index/ganti_password";
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
      <h1>Kelola Password</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman Kelola Password</span>
      </h6>
    </div>
    <div class="area-panel">
      <div class="judul-panel">
        Kelola Password
      </div>
      <div class="area-presensi ">
 <form class="needs-validation" id="ff" method="post" novalidate enctype="multipart/form-data">
  <div class="row">
     <div class="col-md-6 mb-6">
      <label for="reqNoSk">Masukan Password Lama </label>
        <input type="Password" class="form-control  easyui-validatebox" required id="reqPasswordLama" name="reqPasswordLama" value="" />
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-6">
      <label for="reqNoSk">Masukan Password Baru </label>
        <input type="Password" class="form-control  easyui-validatebox" required id="reqPasswordBaru" name="reqPasswordBaru" value="" />
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-6">
      <label for="reqNoSk">Ulangi Password Baru </label>
        <input type="Password" class="form-control  easyui-validatebox" required id="reqPasswordUlangi" name="reqPasswordUlangi" value="" />
    </div>
  </div>

   <div class="clearfix"></div><br/>

        <div class="row">
          <div class="col-md-12">
            <input type="hidden" name="reqId" value="<?=$reqId?>" />
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
            <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
            <input type="hidden" name="reqNama" value="<?=$reqNama?>" />
            <input type="hidden" name="reqSatkerId" value="<?=$reqSatkerId?>" />
            <input type="hidden" name="reqLoginUser" value="<?=$reqLoginUser?>" />
              <button class="btn btn-primary" type="submit">Simpan</button>
               <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='window.history.back()' type="button">Kembali</button>
          </div>
        </div>

 </form>

      </div>
    </div>
  </div>
</div>

