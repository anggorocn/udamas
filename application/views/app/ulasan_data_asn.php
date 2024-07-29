<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$reqTanggal = date("t-m-Y", strtotime(date('d-m-Y')));

// $settingurlapi= $this->config->config["settingurlapi"];
$settingurlapi= $this->config->config["settingurlonlineapi"];
$url= $settingurlapi.'Dashboard_json?reqToken='.$sessPersonalToken;
// echo $url;

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
$html= file_get_contents($url, false, stream_context_create($arrContextOptions));
$arrData = json_decode($html,true);
$arrDataDasboard=$arrData['result'];
$arrDataUlasan = $arrDataDasboard['ULASAN_ASN'];
$arrDataUlasan = json_decode(json_encode($arrDataUlasan),true);

// print_r($arrDataUlasan);
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
      <h1>Ulasan Data ASN</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman ulasan data ASN</span>
      </h6>
    </div>
    

    <div class="area-panel">
      <div class="judul-panel">
        <!-- Bulan : 
        <select>
          <option>Oktober 2023</option>
          <option>September 2023</option>
          <option>Agustus 2023</option>
        </select> -->
        Ulasan Data ASN
      </div>
      <div class="area-ulasan-asn detil">
        <div class="inner">
          <?
           for($i=0;$i<count($arrDataUlasan);$i++){
            ?>
          <div class="item">
              <div class="title"><?=$arrDataUlasan[$i]['JUDUL']?></div>
                      <div class="tanggal"><?=$arrDataUlasan[$i]['TANGGAL']?></div>
                      <div class="isi"><?=$arrDataUlasan[$i]['KETERANGAN']?></div>
          </div>
          <?
           }
          ?>
       

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