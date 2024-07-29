<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');
$sessPersonalToken= $this->PERSONAL_TOKEN;
$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Dashboard_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
$arrDataDasboard= $set->rowResult;
$jamMasuk = $arrDataDasboard[0];
$jamKeluar = $arrDataDasboard[1];
?>

<div class="row">
  <div class="col-md-8">
    <div class="judul-halaman">
      <h1>Dashboard</h1>
      <h6>
        <span class="ikon"><i class="fa fa-home" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Selamat datang dihalaman portal pegawai</span>
      </h6>
    </div>

    <div class="alert alert-danger">
      <strong><i class="fa fa-bell" aria-hidden="true"></i></strong> Anda belum ikut pendidikan Lorem ipsum dolor sit amet, consectetur ...
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="area-panel">
          <div id="container"></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="area-data-check-clock">
          <h3>
            Info kehadiran <br>
            terakhir tanggal <br>
            <i class="fa fa-calendar" aria-hidden="true"></i>  <?=date('d/m/Y');?>
          </h3>

          <div class="check-in">        
            <div class="ikon"><img src="images/icon-checkin.png"></div>
            <div class="data">
              Check In, <br>
              <?=date('d/m/Y');?><br>
              <div class="jam"><?=$jamMasuk?></div>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="check-out">        
            <div class="ikon"><img src="images/icon-checkout.png"></div>
            <div class="data">
              Check Out,<br>
              <?=date('d/m/Y');?><br>
              <div class="jam"><?=$jamKeluar?></div>
            </div>
            <div class="clearfix"></div>
          </div>
          <a class="selengkapnya" href="#">Cek Data Check Clock <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="area-data-pegawai">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Data Pegawai</a></li>
            <li><a data-toggle="tab" href="#menu1">Data ASN</a></li>
            <li><a data-toggle="tab" href="#menu2">Data Pribadi</a></li>
          </ul>

          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <form action="/action_page.php">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>NIP:</label>
                      <input type="text" class="form-control" value="198305022011011001">
                    </div>
                    <div class="form-group">
                      <label>TTL:</label>
                      <input type="text" class="form-control" value="JEMBER, 02 Mei 1983">
                    </div>
                    <div class="form-group">
                      <label>Status / Kedudukan:</label>
                      <input type="text" class="form-control" value="JEMBER, 02 Mei 1983">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Gol:</label>
                      <input type="text" class="form-control" value="III/b TMT 01 April 2015">
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin :</label>
                      <input type="text" class="form-control" value="Laki-laki">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>OPD :</label>
                      <textarea class="form-control">Badan Kepegawaian dan Pengembangan Sumber Daya Manusia - Bidang Pengadaan, Pemberhentian dan Informasi Kepegawaian - Sub Bidang Data dan Informasi Kepegawaian</textarea>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
            <div id="menu1" class="tab-pane fade">
              <h3>Data ASN</h3>
              <p>Some content in menu 1.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
              <h3>Data Pribadi</h3>
              <p>Some content in menu 2.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="area-kanan">
      <div class="area-profil">
        <div class="nama">RENDYANTOKO RINALDI, S.Kom., M.KP.</div>
        <div class="jabatan">Pranata Komputer Pertama</div>
        <a class="btn btn-logout" href="app/logout">Logout</a>
      </div> 
      <div class="area-kalender-home">
        <div id="demo"></div>
        <div class="area-keterangan-presensi">
          <div class="item masuk">
            <div class="waktu">
              <div class="jam">07:40</div>
              <div class="keterangan-jam">am</div>
            </div>
            <div class="data">
              <div class="keterangan-presensi">Masuk</div>
              <div class="klarifikasi">Klarifikasi</div>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="item pulang">
            <div class="waktu">
              <div class="jam">16:05</div>
              <div class="keterangan-jam">pm</div>
            </div>
            <div class="data">
              <div class="keterangan-presensi">Pulang</div>
              <div class="klarifikasi">Klarifikasi</div>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="item">
            <div class="waktu">
              <div class="jam">16:05</div>
              <div class="keterangan-jam">pm</div>
            </div>
            <div class="data">
              <div class="keterangan-presensi">Kegiatan</div>
              <div class="klarifikasi">Klarifikasi</div>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="item lembur">
            <div class="waktu">
              <div class="jam">16:05</div>
              <div class="keterangan-jam">pm</div>
            </div>
            <div class="data">
              <div class="keterangan-presensi">Lembur</div>
              <div class="klarifikasi">Klarifikasi</div>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="item lembur">
            <div class="waktu">
              <div class="jam">16:05</div>
              <div class="keterangan-jam">pm</div>
            </div>
            <div class="data">
              <div class="keterangan-presensi">Lembur</div>
              <div class="klarifikasi">Klarifikasi</div>
            </div>
            <div class="clearfix"></div>
          </div>

        </div>
      </div> 
    </div>

  </div>
</div>