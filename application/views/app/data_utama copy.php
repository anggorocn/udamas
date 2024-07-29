<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
?>

<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>Data Utama</h1>
      <h6>
        <span class="ikon"><i class="fa fa-home" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman data utama</span>
      </h6>
    </div>

    <div class="area-panel">
      <div class="judul-panel">Data Pribadi</div>
      <form class="form-horizontal" action="/action_page.php">

        <div class="form-group">
          <label class="control-label col-sm-2" for="">NIP Baru:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="" placeholder="Enter email">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">NIP Lama:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="" placeholder="Enter email">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Nama:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="" placeholder="Enter email">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="">Status Pegawai:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="" placeholder="Enter email">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="Enter email">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Password:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="pwd" placeholder="Enter password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label><input type="checkbox"> Remember me</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form> 
    </div>
    
  </div>
</div>