<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$reqTanggal = date("t-m-Y", strtotime(date('d-m-Y')));

// $settingurlapi= $this->config->config["settingurlapi"];
$settingurlapi="https://siapasn.jombangkab.go.id/api/api-baru/";
$url =  $settingurlapi.'Info_absensi_json?reqToken='.$sessPersonalToken.'&tanggalmulai='.$reqTanggal.'&tanggalakhir='.$reqTanggal;
$html= file_get_contents($url, false, stream_context_create($arrContextOptions));
$arrData = json_decode($html,true);
$arrData=$arrData['result'];
print_r($arrData);
// print_r(expression);
?>

<!-- SLICK -->
<link rel="stylesheet" type="text/css" href="assets/slick-1.8.1/slick/slick.css">
<link rel="stylesheet" type="text/css" href="assets/slick-1.8.1/slick/slick-theme.css">
<style type="text/css">
    .slider {
        width: 100%;
        margin: 0px auto;
    }

    .slick-slide {
      margin: 0px 5px;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
      color: black;
    }


    .slick-slide {
      transition: all ease-in-out .3s;
      opacity: 1;
    }
    
    .slick-active {
      opacity: 1;
    }

    .slick-current {
      opacity: 1;
    }
  </style>

<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>Data Presensi</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman data presensi</span>
      </h6>
      <!-- <h6>
        <span class="ikon"><i class="fa fa-home" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Selamat datang dihalaman portal pegawai</span>
      </h6> -->
    </div>
    <!-- <div class="row">
      <div class="col-md-12">
        

      </div>
    </div> -->

    <div class="area-panel">
      <div class="judul-panel">
        Bulan : 
        <select>
          <option>Oktober 2023</option>
          <option>September 2023</option>
          <option>Agustus 2023</option>
        </select>
      </div>

      <div class="area-presensi">
        <div class="row item">
          <div class="col-sm-3">
            <div class="tanggal">
              01 Oktober
              <div class="hari">Minggu</div>
            </div>  
          </div>
          <div class="col-sm-2">
            <div class="datang">
              <div class="title">Datang : </div>
              <div class="waktu">07:10:08 </div>
              <div class="keterangan">HM</div>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="pulang">
              <div class="title">Pulang : </div>
              <div class="waktu">00:00:00 </div>
              <div class="keterangan">PTSK</div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="data-log">
              <div class="title">Data Log :</div>
              07:10:08, 07:10:08, 07:10:08
            </div>
          </div>
        </div>

        <div class="row item">
          <div class="col-sm-3">
            <div class="tanggal">
              02 Oktober
              <div class="hari">Senin</div>
            </div>  
          </div>
          <div class="col-sm-2">
            <div class="datang">
              <div class="title">Datang : </div>
              <div class="waktu">07:10:08 </div>
              <div class="keterangan"><button class="btn btn-warning btn-sm">Absen Masuk <i class="fa fa-hand-o-up" aria-hidden="true"></i></button></div>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="pulang">
              <div class="title">Pulang : </div>
              <div class="waktu">00:00:00 </div>
              <div class="keterangan">PTSK</div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="data-log">
              <div class="title">Data Log :</div>
              07:10:08, 07:10:08, 07:10:08
            </div>
          </div>
        </div>

        <div class="row item">
          <div class="col-sm-3">
            <div class="tanggal">
              03 Oktober
              <div class="hari">Selasa</div>
            </div>  
          </div>
          <div class="col-sm-2">
            <div class="datang">
              <div class="title">Datang : </div>
              <div class="waktu">07:10:08 </div>
              <div class="keterangan">HM</div>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="pulang">
              <div class="title">Pulang : </div>
              <div class="waktu">00:00:00 </div>
              <div class="keterangan">PTSK</div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="data-log">
              <div class="title">Data Log :</div>
              07:10:08, 07:10:08, 07:10:08
            </div>
          </div>
        </div>

        <div class="row item">
          <div class="col-sm-3">
            <div class="tanggal">
              04 Oktober
              <div class="hari">Rabu</div>
            </div>  
          </div>
          <div class="col-sm-2">
            <div class="datang">
              <div class="title">Datang : </div>
              <div class="waktu">07:10:08 </div>
              <div class="keterangan">HM</div>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="pulang">
              <div class="title">Pulang : </div>
              <div class="waktu">00:00:00 </div>
              <div class="keterangan"><button class="btn btn-warning btn-sm">Absen Masuk <i class="fa fa-hand-o-up" aria-hidden="true"></i></button></div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="data-log">
              <div class="title">Data Log :</div>
              07:10:08, 07:10:08, 07:10:08
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- SLICK -->
<!-- <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script> -->
<script src="assets/slick-1.8.1/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  $(document).on('ready', function() {
    
    $(".regular").slick({
      dots: false,
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
    });
  });
</script>