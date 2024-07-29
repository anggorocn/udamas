<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pegawai_efile_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
$arrDataFile = $set->rowResult;
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
      <h1>E-File</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman E-File</span>
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
        Data E-File
      </div>
      <div class="area-e-file">
        <div class="inner">
        <?
        $no=1;
        foreach ($arrDataFile as  $value) {
          $reqRowId= $value["pegawai_file_enkrip_id"];
          $tempUrlFile= $value["path"];
          $namaasli= $value["path_asli"];
          $tempNamaUrlFile= pathinfo($tempUrlFile, PATHINFO_BASENAME);
          if(empty($namaasli))
            $namaasli= $tempNamaUrlFile;
          $urlLink = $this->config->item('settingurl').$tempUrlFile;
          $adaFile ="YA";
          if(file_get_contents($urlLink)){  
        ?>  
        
          <div class="item">
            <a 
             <?
             if($adaFile=='YA'){
             ?>
             href="javascript:void(0)"
             onclick="openAdd('<?=$urlLink?>','E-FILE','<?=$namaasli?>')"
             <?
             }
             ?>
             ><?=$namaasli?>  </a>
            <table>
              <tr>
                <td>Jenis Dokumen</td>
                <td>:</td>
                <td><?=$value['info_group_data']?></td>
              </tr>
              <tr>
                <td>Kualitas Dokumen</td>
                <td>:</td>
                <td><?=$value['file_kualitas_nama']?></td>
              </tr>
            </table>
          </div>
       
        <?
           }
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