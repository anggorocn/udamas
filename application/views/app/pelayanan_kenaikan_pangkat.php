<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pelayanan_kenaikan_pangkat_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
$arrDataFile = $set->rowResult;
// $arrDataFile = $arrDataFile[0];

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
      <h1>Pelayanan</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman Pelayanan Kenaikan Pangkat</span>
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
        Data Pelayanan Kenaikan Pangkat
      </div>
      <div class="area-e-file">
        <div class="inner">
       
        <?
        foreach ($arrDataFile as $value) {
          // code...
        $log = explode('&&&', $value['log_keterangan']);
        ?>
          <div class="item">
           
            <table>
              <tr>
                <td>No. Usul BKPSDM</td>
                <td>:</td>
                <td><?=coalesce($value["nomor_usul_bkdpp"],"-")?></td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?=getFormattedDateTime($value["proses_tanggal"], false)?></td>
              </tr>
               <tr>
                <td>Status</td>
                <td>:</td>
                <td><?=coalesce($value["proses_status"],"-")?></td>
              </tr>
              <tr>
                <td valign="top">Keterangan turun status</td>
                <td valign="top">:</td>
                <td>
                  <?
                  if(!empty($value['log_keterangan'])){
                    $text ='<ol>';
                    foreach ( $log as $val) {
                      $text .='<li>'.$val.'</li>';
                    }
                     $text .='</ol>';
                     echo $text;
                  }else{
                    echo '-';
                  }
                  ?>

                </td>
              </tr>
            </table>
          </div>
        <?
        }
        ?>
       
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