<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$set= new DataCombo();

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pegawai_json"];
$set->selectdata($arrparam, "");
$arrDataPegawai= $set->rowResult;
$arrDataPegawai=$arrDataPegawai[0];
// // TEMPAT_LAHIR
// // TANGGAL_LAHIR
// NIP_BARU
// SATUAN_KERJA_NAMA_DETIL

// $arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Dashboard_json"];
$settingurlapi= $this->config->config["settingurlonlineapi"];
$url= $settingurlapi.'Dashboard_json?reqToken='.$sessPersonalToken;

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
$html= file_get_contents($url, false, stream_context_create($arrContextOptions));

$arrData = json_decode($html,true);
$arrDataDasboard=$arrData['result'];
// print_r($arrDataDasboard);

// $set->selectdata($arrparam, "");
// $arrDataDasboard= $set->rowResult;
$jamMasuk = $arrDataDasboard['LOG_MASUK'];
$jamKeluar = $arrDataDasboard['LOG_PULANG'];
$arrDataUlasan = $arrDataDasboard['ULASAN_ASN'];
$arrDataUlasan = json_decode(json_encode($arrDataUlasan),true);


$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"pangkat_riwayat_json", "id"=>$arrDataPegawai['pangkat_riwayat_id']];
$set->selectdata($arrparam, "");
$arrDataPangkat = $set->rowResult;
$arrDataPangkat=$arrDataPangkat[0];

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Jabatan_riwayat_json", "id"=>$arrDataPegawai['jabatan_riwayat_id']];
$set->selectdata($arrparam, "");
$arrDataJabatan = $set->rowResult;
$arrDataJabatan=$arrDataJabatan[0];

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pendidikan_riwayat_json", "id"=>$arrDataPegawai['pendidikan_riwayat_id']];
$set->selectdata($arrparam, "");
$arrDataPendidikan = $set->rowResult;
$arrDataPendidikan=$arrDataPendidikan[0];
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
  <div class="col-md-8">
    <div class="judul-halaman">
      <h1>Dashboard</h1>
      <h6>
        <span class="ikon"><i class="fa fa-home" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Selamat datang dihalaman portal pegawai</span>
      </h6>
    </div>

    <div class="alert alert-danger" style="display: none;">
      <strong><i class="fa fa-bell" aria-hidden="true"></i></strong> Anda belum ikut pendidikan Lorem ipsum dolor sit amet, consectetur ...
    </div>
    <div class="row">
    	<div class="col-md-12">
	    		<div class="area-data-check-clock">
            <div class="row">
  	    			<div class="col-md-2">
                <img src="images/img-mesin-absen.png" width="105">
              </div>
              <div class="col-md-2">
                <h3>Info kehadiran</h3>
    					</div>
    					<div class="col-md-3">
    						<div class="check-in">        
    							<div class="ikon"><img src="images/icon-checkin.png"></div>
    							<div class="data">
    								Check In, <br>
    								<?=date('d/m/Y');?><br>
    								<div class="jam"><?=$jamMasuk?></div>
    							</div>
    							<div class="clearfix"></div>
    						</div>
    					</div>
    					<div class="col-md-3">
    						<div class="check-out">        
    							<div class="ikon"><img src="images/icon-checkout.png"></div>
    							<div class="data">
    								Check Out,<br>
    								<?=date('d/m/Y');?><br>
    								<div class="jam"><?=$jamKeluar?></div>
    							</div>
    							<div class="clearfix"></div>
    						</div>
    					</div>
    					<div class="col-md-2 col-selengkapnya">
                <a class="selengkapnya" href="app/index/presensi">
                  <span>Cek Data Check Clock <i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                </a>
    					</div>
            </div>
  				</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-12">
    		<div class="area-ulasan-asn">
          <div class="row">
            <div class="col-md-2">
              <div class="header">
          			<div class="judul">Ulasan Data ASN</div>
                <div class="gambar"><img src="images/img-asn.png"></div>
              </div>
            </div>
            <div class="col-md-10">
        			<div class="inner">
                <section class="regular slider">
                  <?
                 for($i=0;$i<count($arrDataUlasan);$i++){
                  
                  ?>
                  <div>
                    <div class="item">
                      <div class="title"><?=$arrDataUlasan[$i]['JUDUL']?></div>
                      <div class="tanggal"><?=$arrDataUlasan[$i]['TANGGAL']?></div>
                      <div class="isi"><?=$arrDataUlasan[$i]['KETERANGAN']?></div>
                    </div>
                  </div>
                  <?
                  }
                  ?>
                 
                </section>
                <a class="btn btn-lihat pull-right" href="app/index/ulasan_data_asn">Lihat semua</a>
    	    		</div>
            </div>
    			</div>
    		</div>
    	</div>
    </div>
    <!-- <div class="row">
      <div class="col-md-8">
        <div class="area-panel">
          <div id="container"></div>
        </div>
        
      </div>
      <div class="col-md-4">
        
      </div>
    </div> -->
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
              <form >
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>NIP:</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['nip_baru']?>">
                    </div>
                    <div class="form-group">
                      <label>TTL:</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['tempat_lahir']?>, <?=getFormattedDate($arrDataPegawai['tanggal_lahir'])?>">
                    </div>
                    <div class="form-group">
                      <label>Status / Kedudukan:</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['pegawai_status_nama']?> / <?=$arrDataPegawai['kedudukan']?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Gol:</label>
                      <input type="text" class="form-control" value="<?=$arrDataPangkat['pangkat_kode']?> TMT <?=$arrDataPangkat['tmt_pangkat']?>">
                    </div>
                    <?
                    $arrJenisKelamin['P']='Perempuan';
                    $arrJenisKelamin['L']='Laki Laki';
                    ?>
                    <div class="form-group">
                      <label>Jenis Kelamin :</label>
                      <input type="text" class="form-control" value="<?=$arrJenisKelamin[$arrDataPegawai['jenis_kelamin']]?>">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>OPD :</label>
                      <textarea class="form-control"><?=$arrDataPegawai['satuan_kerja_nama_detil']?></textarea>
                    </div>
                  </div>
                </div>
              </form> 
            </div>
            <div id="menu1" class="tab-pane fade">
              <form >
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Jenis Jabatan :</label>
                      <input type="text" class="form-control" value="<?=$arrDataJabatan['jenis_jabatan_nama']?>">
                    </div>
                    <div class="form-group">
                      <label>Nama Jabatan :</label>
                      <input type="text" class="form-control" value="<?=$arrDataJabatan['nama']?>">
                    </div>
                    <div class="form-group">
                      <label>TMT Jabatan / Eselon :</label>
                      <?
                      $reqTmtJabatan = date("d-m-Y", strtotime($arrDataJabatan['tmt_jabatan']));
                      ?>
                      <input type="text" class="form-control" value="<?=getFormattedDateView($reqTmtJabatan)?>">
                    </div>
                  </div>
                   <div class="col-md-6">
                     <div class="form-group">
                      <label>Pendidikan Lain Yang Diakui :</label>
                      <input type="text" class="form-control" value="<?=$arrDataPendidikan['pendidikan_nama']?>">
                    </div>
                    <div class="form-group">
                      <label>Jurusan Pendidikan Diakui  :</label>
                      <input type="text" class="form-control" value="<?=$arrDataPendidikan['jurusan']?>">
                    </div>
                   </div>
                </div>
                
              </form> 
            </div>
            <div id="menu2" class="tab-pane fade">
             
             <form >
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Nik :</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['nik']?>">
                    </div>
                    <div class="form-group">
                      <label>No KK :</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['no_kk']?>">
                    </div>
                     <div class="form-group">
                      <label>Npwp :</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['npwp']?>">
                    </div>
                 </div>
                 <div class="col-md-6">
                   <div class="form-group">
                      <label>No HP:</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['hp']?>">
                    </div>
                    <div class="form-group">
                      <label>Telpon Rumah:</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['telepon']?>">
                    </div>
                     <div class="form-group">
                      <label>Email:</label>
                      <input type="text" class="form-control" value="<?=$arrDataPegawai['email']?>">
                    </div>
                 </div>
                  <div class="col-md-12">
                  <div class="form-group">
                      <label>Alamat :</label>
                      <textarea type="text" class="form-control" ><?=$arrDataPegawai['alamat']?> , RT :<?=$arrDataPegawai['rt']?> RW :<?=$arrDataPegawai['rw']?>  ,<?=$arrDataPegawai['desa_nama']?> <?=$arrDataPegawai['kecamatan_nama']?> , <?=$arrDataPegawai['kabupaten_nama']?> <?=$arrDataPegawai['propinsi_nama']?><?=$arrDataPegawai['kodepos']?>  </textarea>

                    </div>
                  </div>
                </div>
              </form> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="area-kanan">
      <div class="area-profil">
        <div class="nama"><?=$arrDataPegawai['nama']?><?=$arrDataPegawai['gelar_belakang']?> </div>
        <div class="jabatan"><?=$arrDataJabatan['nama']?></div>
        <a class="btn btn-logout" href="app/logout">Logout</a>
      </div> 
      <div class="area-kalender-home">
        <div id="demo"></div>
        <div id="bodyWaktu" class="area-keterangan-presensi">
         

         

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
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
          }
        }
      ]
    });
  });

</script>

 <!-- RANGE CALENDAR -->
  <script src="assets/Range-Calendar/js/jquery-ui.min.js"></script>
  <script src="assets/Range-Calendar/js/jquery.ui.touch-punch.min.js"></script>
  <script src="assets/Range-Calendar/js/moment-with-langs.min.js"></script>

  <script src="assets/Range-Calendar/js/jquery.rangecalendar.js"></script>
  <link rel="stylesheet" href="assets/Range-Calendar/css/rangecalendar.css">

  <script type="text/javascript">
     var maxdate = new Date();
        var lastMoth = new Date();
      maxdate.setDate(maxdate.getDate() +1 );
      lastMoth.setDate(lastMoth. getDate() - 30);
   var rangeCalendar =   $("#demo").rangeCalendar({
      lang: "indonesia",
      theme: "default-theme",
      themeContext: this,
      // startDate: moment(),
      startDate: lastMoth,
      endDate: maxdate,
      // start : "+7",
      start : "0",
      // startRangeWidth : 3, 
      startRangeWidth : 1, 
      minRangeWidth: 1,
      maxRangeWidth: 14,
      //weekends: true,
      autoHideMonths: false,
      visible: true,
      trigger: null,
      // changeRangeCallback : rangeChanged
      });


    $(document).ready(function(){
      
    var newDate = moment().add('months');
      rangeCalendar.setStartDate(newDate);
       rangeCalendar.changeRangeCallback=rangeChanged;
         detail_waktu('<?=date('d-m-Y')?>');
    });

    var nilai=0;
    function rangeChanged(target,range){
     if(nilai==1){return}
        nilai=1;

        vbulancheck= parseFloat(moment(range.start).add('months',-1).format('MM'));
        if(vbulancheck % 2 == 0)
          var startDay = moment(range.start).add('months',-1).format('DD-MM-YYYY');
        else
          var startDay = moment(range.start).add('months',-1).add('days',+1).format('DD-MM-YYYY');
        
        // console.log(startDay); nilai=0;
        detail_waktu(startDay);

      }
  </script>
  <script type="text/javascript">
  function detail_waktu(tanggal){
   
    $.get("api/Pegawai_info_absensi_json?reqTanggal="+tanggal, function(data) {
       $("#bodyWaktu").empty();
      var datas = JSON.parse(data);
       var  data = `
       <div class="item masuk">
       <div class="waktu">
       <div class="jam">`+datas['LOG_MASUK']+`</div>
       <div class="keterangan-jam"></div>
       </div>
       <div class="data">
       <div class="keterangan-presensi">Masuk</div>
       <div class="klarifikasi">`+datas['MASUK']+`</div>
       </div>
       <div class="clearfix"></div>
       </div>

       <div class="item pulang">
       <div class="waktu">
       <div class="jam">`+datas['LOG_PULANG']+`</div>
       <div class="keterangan-jam"></div>
       </div>
       <div class="data">
       <div class="keterangan-presensi">Pulang</div>
       <div class="klarifikasi">`+datas['PULANG']+`</div>
       </div>
       <div class="clearfix"></div>
       </div>

       <div class="item">
       <div class="waktu">
       <div class="jam">`+datas['TERLAMBAT']+`</div>
       <div class="keterangan-jam">`+datas['TERLAMBAT_A']+`</div>
       </div>
       <div class="data">
       <div class="keterangan-presensi">Terlambat</div>
       <div class="klarifikasi">-</div>
       </div>
       <div class="clearfix"></div>
       </div>
       <div class="item lembur">
       <div class="waktu">
       <div class="jam">`+datas['PULANG_CEPAT']+`</div>
       <div class="keterangan-jam">`+datas['PULANG_CEPAT_A']+`</div>
       </div>
       <div class="data">
       <div class="keterangan-presensi">Pulang Cepat</div>
       <div class="klarifikasi">-</div>
       </div>
       <div class="clearfix"></div>
       </div>
       `;
        $("#bodyWaktu").append(data);
        nilai=0;

    });
  }
</script>
