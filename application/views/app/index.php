<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->library('globalmenu');

$gmenu= new globalmenu();
$arrgetmenu= $gmenu->getmenu();
// print_r($arrgetmenu);exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <base href="<?=base_url()?>">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Pegawai</title>

  <script src="assets/js/jquery.min.js"></script>
  <link href="assets/jbvalidator/bootstrap.min.css" rel="stylesheet">
  <link href="assets/bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="assets/bootstrap-3.3.7/docs/examples/starter-template/starter-template.css" rel="stylesheet">
  <script src="assets/bootstrap-3.3.7/docs/assets/js/ie-emulation-modes-warning.js"></script>

  <script type="text/javascript">
    vclosed= true;

    $(document).ready(function () {

      var trigger = $('.hamburger'),
      overlay = $('.overlay'),
      isClosed = vclosed;

      const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
      if (isMobile) {
        vclosed= false;
        $("#wrapper").removeClass("toggled");
      } else { 
        vclosed= true;
        $("#wrapper").addClass("toggled");
      }

      hamburger_cross();
      trigger.click(function () {
        hamburger_cross();
      });

      function hamburger_cross() {
        if (isClosed == true) {          
          overlay.hide();
          trigger.removeClass('is-open');
          trigger.addClass('is-closed');
        } else {   
          overlay.show();
          trigger.removeClass('is-closed');
          trigger.addClass('is-open');
        }
      }
      
      $('[data-toggle="offcanvas"]').click(function () {
          $('#wrapper').toggleClass('toggled');
      });  
    });
  </script>

  <link href="css/balloon.css" rel="stylesheet">
  <link href="css/gaya.css?ver=1.0.1" rel="stylesheet">

  <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.css" type="text/css">

  <link rel="stylesheet" href="assets/jquery-confirm/jquery-confirm.min.css">

</head>
<style type="text/css">
  .modal-title{
    width: 100% !important;
    text-align: right !important;
  }
</style>
<body>

  <div id="wrapper">

    <div class="overlay"></div>
    
        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
          <div class="sidebar-brand">
            <a href="app/index/home">
              <img src="images/logo.png">
            </a>
          </div>
          <ul class="nav sidebar-nav">
            <li>
              <a href="app/index/home"><span><i class="fa fa-home" aria-hidden="true"></i></span> Home</a>
            </li>
            <li>
              <a data-toggle="modal" data-target="#myModal"><span><i class="fa fa-id-badge" aria-hidden="true"></i></span> Data PNS</a>
            </li>
            <li>
              <a data-toggle="modal" data-target="#myModalPelayanan"><span><i class="fa fa-cogs" aria-hidden="true"></i></span> Pelayanan</a>
            </li>
            <li>
              <a href="app/index/e_file"><span><i class="fa fa-file-text" aria-hidden="true"></i></span> E-File</a>
            </li>
            <li>
              <a href="app/index/presensi"><span><i class="fa fa-hand-o-up" aria-hidden="true"></i></span> Presensi</a>
            </li>
            <li>
              <a href="app/index/profil"><span><i class="fa fa-key" aria-hidden="true"></i></span> Profil</a>
            </li>
            <li>
              <a href="javascript:void(0)"><span><i class="fa fa-globe" aria-hidden="true"></i></span> Portal</a>
            </li>
          </ul>
        </nav>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger" data-toggle="offcanvas">
              
              <span class="hamb-top"></span>
              <span class="hamb-middle"></span>
              <span class="hamb-bottom"></span>
            </button>
            <div class="container-fluid container-utama">
              <?=($content ? $content:'')?>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

  <script>window.jQuery || document.write('<script src="assets/bootstrap-3.3.7/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
  <script src="assets/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  <script src="assets/bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>

  <script src="assets/js/jquery.js"></script>
  <script src="assets/jbvalidator/jbvalidator.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/confirm/css/jquery-confirm.css"/>
  <script type="text/javascript" src="assets/confirm/js/jquery-confirm.js"></script>
  <script type="text/javascript" src="assets/easyui-mobile/globalfunction.js"></script>

  <link rel="stylesheet" href="assets/autokomplit/jquery-ui.css">
  <script src="assets/autokomplit/jquery-ui.js"></script>

  <!-- HIGHCHART -->
  <script src="assets/highcharts/highcharts.js"></script>
  <script src="assets/highcharts/highcharts-more.js"></script>
  <script src="assets/highcharts/exporting.js"></script>
  <script src="assets/highcharts/export-data.js"></script>
  <script src="assets/highcharts/accessibility.js"></script>

    <script src="assets/Range-Calendar/js/jquery-ui.min.js"></script>
  <script src="assets/Range-Calendar/js/jquery.ui.touch-punch.min.js"></script>
  <script src="assets/Range-Calendar/js/moment-with-langs.min.js"></script>

  <?
  if($pg == "home" || $pg == "")
  {
  ?>
  <script type="text/javascript">
    Highcharts.chart('container', {
      chart: {
        polar: true,
        type: 'line',
        backgroundColor: null
      }
      , exporting: {
        enabled: false
      }
      , accessibility: {
        description: 'A spiderweb chart compares the allocated budget against actual spending within an organization. The spider chart has six spokes. Each spoke represents one of the 6 departments within the organization: sales, marketing, development, customer support, information technology and administration. The chart is interactive, and each data point is displayed upon hovering. The chart clearly shows that 4 of the 6 departments have overspent their budget with Marketing responsible for the greatest overspend of $20,000. The allocated budget and actual spending data points for each department are as follows: Sales. Budget equals $43,000; spending equals $50,000. Marketing. Budget equals $19,000; spending equals $39,000. Development. Budget equals $60,000; spending equals $42,000. Customer support. Budget equals $35,000; spending equals $31,000. Information technology. Budget equals $17,000; spending equals $26,000. Administration. Budget equals $10,000; spending equals $14,000.'
      }
      , title: {
        text: 'Budget vs spending',
        x: -80
      }
      , pane: {
        size: '80%'
      }
      , xAxis: {
        categories: ['Sales', 'Marketing', 'Development', 'Customer Support',
        'Information Technology', 'Administration'],
        tickmarkPlacement: 'on',
        lineWidth: 0
      }
      , yAxis: {
        gridLineInterpolation: 'polygon',
        lineWidth: 0,
        min: 0
      }
      , tooltip: {
        shared: true,
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
      }
      , legend: {
        align: 'right',
        verticalAlign: 'middle',
        layout: 'vertical'
      }
      , series: [{
        name: 'Allocated Budget',
        data: [43000, 19000, 60000, 35000, 17000, 10000],
        pointPlacement: 'on'
      }, {
        name: 'Actual Spending',
        data: [50000, 39000, 42000, 31000, 26000, 14000],
        pointPlacement: 'on'
      }]
      , responsive: {
        rules: [{
          condition: {
            maxWidth: 500
          },
          chartOptions: {
            legend: {
              align: 'center',
              verticalAlign: 'bottom',
              layout: 'horizontal'
            },
            pane: {
              size: '70%'
            }
          }
        }]
      }

    });
  </script>
  <?
  }
  ?>

 

  <script src="assets/moment/moment-with-locales.js"></script>


  <script type="text/javascript">
  
    $(document).ready(function(){
      $('.formattanggalnew').datepicker({
        dateFormat: "dd-mm-yy"
        , changeMonth: true
        , changeYear: true
        , inline: true
        // , showOn: "button"
        // , buttonImage: 'assets/Range-Calendar/images/calender.png'
        // , icons: {
        //   time: 'glyphicon glyphicon-time',
        //   date: 'glyphicon glyphicon-calendar',
        //   up: 'glyphicon glyphicon-chevron-up',
        //   down: 'glyphicon glyphicon-chevron-down',
        //   previous: 'glyphicon glyphicon-backward',
        //   next: 'glyphicon glyphicon-chevron-right',
        //   today: 'glyphicon glyphicon-screenshot',
        //   clear: 'glyphicon glyphicon-trash',
        //   close: 'glyphicon glyphicon-remove'
        // }
      });
      $('.formatperiode').datepicker({
           changeMonth: true,
            changeYear: true,
            regional:'id',
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            },
              onSelect: function(dateText, inst) { 
                // alert(dateText); 
               pilihan_periode(inst.selectedMonth,inst.selectedYear);
              }
      });
    
    $.datepicker.setDefaults($.datepicker.regional['id']);
    });
    $.datepicker.regional['id'] = {
        monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
        dayNamesShort:  ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
        dayNamesMin:  ["Mn", "Sn", "Sl", "Rb", "Km", "Jm", "Sb"],
    }


    function hapusdata(varrowid, vartable, status, vreturn)
    {
        $.confirm({
            title: 'Aksi Data',
            content: 'Yakin hapus?',
            buttons: {
                yakin: function () {
                    urlAjax= "api/combo/hapusdata?reqRowId="+varrowid+"&reqTable="+vartable+"&reqStatus="+status;
                    // console.log(urlAjax);return false;
                    $.ajax({'url': urlAjax,'success': function(data){
                        document.location.href = "app/index/"+vreturn;
                    }});
                },
                batal: function () {
                }
            }
        });
    }
  </script>

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data ASN </h4>
        </div>
        <div class="modal-body">
          <div class="area-submenu row">

            <?
            foreach ($arrgetmenu as $key => $value) 
            {
              $vlabel= $value["label"];
              $vlink= $value["link"];
              $vicon= $value["icon"];
              $vaksi= $value["aksi"];

              if($vaksi == "D")
              {
                continue;
              }
            ?>
            <div class="col-md-3">
              <div class="item"><a href="<?=$vlink?>"><i class="<?=$vicon?>" aria-hidden="true"></i> <?=$vlabel?></a></div>
            </div>
            <?
            }
            ?>

          </div>
        </div>
        
      </div>

    </div>
  </div>
  <div id="myModalPelayanan" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data Pelayanan </h4>
        </div>
        <div class="modal-body">
          <div class="area-submenu row">
           
                    <div class="col-md-3">
              <div class="item"><a href="app/index/pelayanan_karis_karsu"><i class="<?=$vicon?>" aria-hidden="true"></i>Karis / Karsu</a></div>
                </div>
                   
                    <div class="col-md-3">
               <div class="item"><a href="app/index/pelayanan_kenaikan_pangkat"><i class="<?=$vicon?>" aria-hidden="true"></i>Kenaikan Pangkat</a></div>
                 </div>
                   
            </div>
          </div>
        </div>
        
      </div>

    </div>
   <!-- EMODAL -->
    <script src="assets/emodal/eModal.js?v=1.0.2"></script>
  
    
    <script>
    function openAdd(pageUrl,title,filenama) {
        eModal.iframe(pageUrl, title,filenama)
    }
    function openCabang(pageUrl) {
        eModalCabang.iframe(pageUrl, title)
    }
    function closePopup() {
        eModal.close();
    }
    
    function windowOpener(windowHeight, windowWidth, windowName, windowUri)
    {
        var centerWidth = (window.screen.width - windowWidth) / 2;
        var centerHeight = (window.screen.height - windowHeight) / 2;
    
        newWindow = window.open(windowUri, windowName, 'resizable=0,width=' + windowWidth + 
            ',height=' + windowHeight + 
            ',left=' + centerWidth + 
            ',top=' + centerHeight);
    
        newWindow.focus();
        return newWindow.name;
    }
    
    function windowOpenerPopup(windowHeight, windowWidth, windowName, windowUri)
    {
        var centerWidth = (window.screen.width - windowWidth) / 2;
        var centerHeight = (window.screen.height - windowHeight) / 2;
    
        newWindow = window.open(windowUri, windowName, 'resizable=1,scrollbars=yes,width=' + windowWidth + 
            ',height=' + windowHeight + 
            ',left=' + centerWidth + 
            ',top=' + centerHeight);
    
        newWindow.focus();
        return newWindow.name;
    }

    function downloadDialogFile(){          

      
     var url = '<?=$this->config->item('settingurl').'berkas/download_file'?>'; 
     var link = document.createElement('a');
     link.href = url+'?url='+ifile+"&reqName="+ifilename;
     link.dispatchEvent(new MouseEvent('click'));

    

    }
        
    
    </script>

</body>
</html>