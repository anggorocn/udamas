<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;
$reqPeriode = $this->input->get('reqPeriode');
$cekquery= $this->input->get('c');

$tanggalsekarang= $reqTanggal= date("d-m-Y", strtotime(date('d-m-Y')));
if(!empty($reqPeriode)){
  $reqPeriode= '15-'.$reqPeriode;
  $reqTanggal= date("t-m-Y", strtotime($reqPeriode));
}

$vbulan= getMonth($tanggalsekarang);
$vtahun= getYear($tanggalsekarang);
$vtahunmundur= $vtahun-1;
$setdefaulttanggal= getMonth($reqTanggal)."-".getYear($reqTanggal);
// echo $setdefaulttanggal."<br>";
// echo $reqTanggal;exit;

$arrperiode= [];
for($b=$vbulan; $b>=1 ; $b--)
{
  $vperiode= generateZeroDate($b,2).$vtahun;
  $arrdata= [];
  $arrdata["id"]= generateZeroDate($b,2)."-".$vtahun;
  $arrdata["text"]= getNamePeriode($vperiode);
  array_push($arrperiode, $arrdata);
}

for($b=12; $b>= $vbulan; $b--)
{
  $vperiode= generateZeroDate($b,2).$vtahunmundur;
  $arrdata= [];
  $arrdata["id"]= generateZeroDate($b,2)."-".$vtahunmundur;
  $arrdata["text"]= getNamePeriode($vperiode);
  array_push($arrperiode, $arrdata);
}
// print_r($arrperiode);exit;

// $arrTanggals = explode("-",$reqTanggal);
// $reqValTanggal = getSelectFormattedDate($arrTanggals[1])." ".$arrTanggals[2];
// echo $reqTanggal;exit;

$arrContextOptions=array(
  "ssl"=>array(
    "verify_peer"=>false,
    "verify_peer_name"=>false,
  ),
);
// $settingurlapi= $this->config->config["settingurlapi"];
$settingurlapi="https://siapasn.jombangkab.go.id/api/api-baru/";
$url= $settingurlapi.'Info_absensi_json?reqToken='.$sessPersonalToken.'&tanggalmulai='.$reqTanggal.'&tanggalakhir='.$reqTanggal;
if(!empty($cekquery))
{
  echo $url;exit;
}
$html= file_get_contents($url, false, stream_context_create($arrContextOptions));
$arrData = json_decode($html,true);
$arrData= $arrData['result'];

// print_r($arrData);
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
    </div>
    <div class="area-panel">
      <div class="judul-panel">
        <table >
          <tr>
            <td style="padding: 10px;">Bulan</td>
            <td style="padding: 10px;">:</td>
            <td style="padding: 10px;">
              <select id="reqPeriode" class="form-control">
                <?
                foreach ($arrperiode as $key => $value)
                {
                  $optionid= $value["id"];
                  $optiontext= $value["text"];
                  $optionselected= "";
                  if($setdefaulttanggal == $optionid)
                    $optionselected= "selected";
                ?>
                  <option value="<?=$optionid?>" <?=$optionselected?>><?=$optiontext?></option>
                <?
                }
                ?>
              </select>
              <!-- <input  class="form-control formatperiode" id="reqPilihPeriode" value="<?=$reqValTanggal?>"> -->
            </td>
          </tr>
        </table>
      </div>
      <div class="area-presensi ">
        <?
        for($i=0;$i<count($arrData);$i++){
          $tanggal = $arrData[$i]['TANGGAL'];
          $arrTanggal = explode('-', $tanggal);
          $reqNamaTanggal = $arrTanggal[0].' '.getSelectFormattedDate($arrTanggal[1]);
          $reqNamaHari = getNamaHari($arrTanggal[0],$arrTanggal[1],$arrTanggal[2]);
          $reqLogDatang = $arrData[$i]['LOG_MASUK'];
          $reqDatang = $arrData[$i]['MASUK'];
          $reqLogPulang = $arrData[$i]['LOG_PULANG'];
          $reqPulang = $arrData[$i]['PULANG'];
          $reqLogSemua = $arrData[$i]['LOG_SEMUA'];
        ?>
        <div class="row item">
          <div class="col-sm-3">
            <div class="tanggal">
             <?=$reqNamaTanggal?>
              <div class="hari"><?=$reqNamaHari?></div>
            </div>  
          </div>
          <div class="col-sm-2 col-datang">
            <div class="datang">
              <div class="title">Datang : </div>
              <div class="waktu"><?=$reqLogDatang?> </div>
              <div class="keterangan"><?=$reqDatang?>
                <?
                 if( $reqLogDatang=='--:--'|| $reqLogDatang=='-' || empty($reqLogDatang)){}else{
                ?>
                 <button class="btn btn-warning btn-sm" style="display: none;">Absen Masuk <i class="fa fa-hand-o-up" aria-hidden="true"></i></button>
                 <?
                  }
                 ?>
              </div>
            </div>
          </div>
          <div class="col-sm-2 col-pulang">
            <div class="pulang">
              <div class="title">Pulang : </div>
              <div class="waktu"><?=$reqLogPulang?> </div>
              <div class="keterangan"><?=$reqPulang?>
              <?
              if( $reqLogPulang=='--:--'|| $reqLogPulang=='-' || empty($reqLogPulang)){}else{
              ?>
                 <button class="btn btn-warning btn-sm" style="display: none;">Absen Pulang <i class="fa fa-hand-o-up" aria-hidden="true"></i></button>
              <?
                }
              ?>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="data-log">
              <div class="title">Data Log :</div>
              <?=$reqLogSemua?>
            </div>
          </div>
        </div>
        <?
        }
        ?>
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
 <script src="assets/moment/moment-with-locales.js"></script>
<script type="text/javascript">
  $('#reqPeriode').change(function() {
    window.location.href='app/index/presensi?reqPeriode='+$(this).val();
  });
  
  /*function pilihan_periode(bulan,tahun){
  var iBulan = bulan+1;
    window.location.href='app/index/presensi?reqPeriode='+iBulan+'-'+tahun;
  }*/
</script>
