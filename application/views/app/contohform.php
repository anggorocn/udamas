<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

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

$buttonsimpan= "1";
/*if( (empty($reqCheckPegawaiId) || !empty($reqValidasi) || !empty($reqTempValidasiHapusId)) && $reqId !== "baru")
{
  $buttonsimpan= "";
}*/
?>
<script type="text/javascript">
$(function(){
  /*let validator = $('#ff').jbvalidator({
    validFeedBackClass: 'valid-feedbak',
    invalidFeedBackClass: 'invalid-feedback',
    validClass: 'is-valid',
    invalidClass: 'is-invalid'
  });*/

  let validator = $('#ff').jbvalidator({
    errorMessage: true
    , successClass: true
  });

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

});
</script>
<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>Diklat Kursus</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <a href="" style="text-decoration: none;">
          <span>Halaman data monitoring</span>
        </a>
      </h6>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Data Diklat Kursus</div>

      <form class="needs-validation" id="ff" method="post" novalidate enctype="multipart/form-data">
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="validationDefault01">First name</label>
            <input type="text" class="form-control" id="validationDefault01" placeholder="First name" value="Mark" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="validationDefault02">Last name</label>
            <input type="text" class="form-control" id="validationDefault02" placeholder="Last name" value="" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="validationDefaultUsername">Username</label>
            <div class="input-group">
              <input type="text" class="form-control" id="validationDefaultUsername" placeholder="Username" aria-describedby="inputGroupPrepend2" required>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
          </div>
        </div>

      </form>
    </div>
    
  </div>
</div>