<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");


$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_PLNNP_presens1'.date("dmyH"));
$this->load->library("crfs_protect"); $csrf_log = new crfs_protect('_crfs_PLNNP_presens1_log'.date("dmyH"));

$PEGAWAI_ID = md5($reqPegawaiId.$this->MD5KEY);

?>


<script>

    $(document).ready(function() {

        reloadData('all');

        $("#locationData").html("Latitude: <?=$reqLatitude?><br>Longitude: <?=$reqLongitude?>");
        
        $('#spinner').hide();
        
        /*if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(locationSuccess);

        } else {

            $('#spinner').hide();

            $("#locationData").html('Your browser does not support location data retrieval.');

        }

        function locationSuccess(position) {

            $('#spinner').hide();

            var latitude = position.coords.latitude;

            var longitude = position.coords.longitude;

            $("#locationData").html("Latitude: " + latitude + "<br>Longitude: " + longitude);

            $("#LONGITUDE").val(longitude);
            $("#LATITUDE").val(latitude);

        }*/

    });

</script>


<!-- SERVER TIME -->
<script type="text/javascript">
    <?

    $sekarang = $this->db->query("SELECT TO_CHAR(CURRENT_TIMESTAMP, 'YYYY-MM-DD HH24:MI:SS') JAM")->row()->jam;
    $time = strtotime($sekarang);
    $jam = date("F d, Y H:i:s", $time);
    ?>
    var currenttime = '<?=$jam?>' 
    var montharray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember")
    var serverdate=new Date(currenttime)

    function padlength(what){
    var output=(what.toString().length==1)? "0"+what : what
    return output
    }

    function displaytime(){
    serverdate.setSeconds(serverdate.getSeconds()+1)
    var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
    var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())

    var hari= padlength(serverdate.getDate())
    var bulan=montharray[serverdate.getMonth()]
    var tahun=serverdate.getFullYear()+" "

    var pukul=padlength(serverdate.getHours())+" : "
    var menit=padlength(serverdate.getMinutes())+" : "
    var detik=padlength(serverdate.getSeconds())

    //document.getElementById("servertime").innerHTML=datestring+" "+timestring

    document.getElementById("varhari").innerHTML=hari
    document.getElementById("varbulan").innerHTML=bulan
    document.getElementById("vartahun").innerHTML=tahun

    document.getElementById("varpukul").innerHTML=pukul
    document.getElementById("varmenit").innerHTML=menit
    document.getElementById("vardetik").innerHTML=detik
    }

    window.onload=function(){
    setInterval("displaytime()", 1000)
    }
</script>


<div class="row">
    <div class="col-md-12">
        <div class="area-konten">


            <div id="spinner">
                <div class="inner-spinner">
                    <div class="lds-spinner">
                        <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                    </div>
                </div>
            </div> 

            <div class="area-banner">
                <img src="images/img-pltu.jpg">
            </div>

            <div class="inner">
                <div class="area-profil">
                    <div class="foto"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
                    <div class="data">
                        <div class="nama"><?=$reqPegawai?></div>
                        <div class="nik"><?=$reqPegawaiId?></div>
                        <div id="locationData"></div>
                        <input type="hidden" id="LONGITUDE" value="<?=$reqLongitude?>">
                        <input type="hidden" id="LATITUDE" value="<?=$reqLatitude?>">
                    </div>
                    <div class="waktu-sekarang">
                        <div><i class="fa fa-calendar" aria-hidden="true"></i>
                            <span id="varhari"></span>
                            <span id="varbulan"></span>
                            <span id="vartahun"></span></div>
                        <div><i class="fa fa-clock-o" aria-hidden="true"></i> <span id="varpukul"></span><span id="varmenit"></span><span id="vardetik"></span></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="item-absensi datang">
                            <div class="waktu">
                                <div class="ikon"><img src="images/icon-log.png"></div>
                                <div class="data">
                                    <div class="title">Daftar Checklog</div>
                                    <!-- <div class="pukul" id="PRESENSI_AWAL"><?=$PRESENSI_AWAL?></div> -->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="waktu-selisih data-checklog" id="logChecklog">
                                
                            </div>
                            <!-- <div class="waktu-selisih">
                                <div class="data">
                                    <div class="title">Test Log</div>
                                    <div class="pukul">12:00</div>
                                </div>
                                <div class="ikon">
                                    <i class="fa fa-circle fa-hijau" aria-hidden="true"></i>
                                    <i class="fa fa-circle fa-merah" aria-hidden="true"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div> -->

                            <!-- <div class="waktu-selisih">
                                <div class="title">Test Log</div>
                                <div class="pukul">12:00</div>
                            </div>
                            <div class="waktu-selisih">
                                <div class="title">Pulang</div>
                                <div class="pukul">16:17</div>
                            </div> -->
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="item-absensi pulang">
                            <div class="waktu">
                                <div class="ikon"><img src="images/icon-pulang.png"></div>
                                <div class="data">
                                    <div class="title">PRESENSI AKHIR</div>
                                    <div class="pukul" id="PRESENSI_AKHIR"><?=$PRESENSI_AKHIR?></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="waktu-selisih">
                                <div class="title">Data Kemarin</div>
                                <div class="pukul" id="PRESENSI_AKHIR_KEMARIN">--:--</div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="area-hasil-assesmen">
                            <div class="title">Klik tombol di bawah ini untuk melakukan Presensi</div>
                            <div class="data risiko-rendah" align="center">
                                <button class="btn" onclick="presensi()" style="width:80%">
                                    <!-- <div class="ikon" id="demo"><img src="images/fingerprints.png"></div> -->
                                    <div class="keterangan">Submit</div>
                                    <div class="clearfix"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" type="text/css" href="lib/jconfirm/css/jquery-confirm.css"/>
<script type="text/javascript" src="lib/jconfirm/js/jquery-confirm.js"></script>
<script type="text/javascript">

    function presensi()
    {
 
        

        $.confirm({
            title: 'Konfirmasi',
            content: `<div class="form-group">
                            <label class="control-label">Apakah anda ingin melanjutkan proses?</label>
                        </div>`,
            buttons: {
                sayMyName: {
                    text: 'Submit',
                    btnClass: 'btn-orange',
                    action: function(){
                        
                        $("#spinner").show();

                        var LONGITUDE = $("#LONGITUDE").val();
                        var LATITUDE  = $("#LATITUDE").val();
                        
                        $.post( "app/presensi", { "PEGAWAI_ID": "<?=$PEGAWAI_ID?>", "TOKEN": "<?=$csrf->getToken()?>", "LONGITUDE": LONGITUDE, "LATITUDE": LATITUDE })
                          .done(function( data ) {
                                
                                data = JSON.parse(data);

                                $("#spinner").hide();

                                $.alert({
                                    title: 'Pesan',
                                    content: data.message,
                                    type: data.color
                                });    

                                reloadData('refresh');
                                if(data.status == 'success')
                                {
                                    /*PRESENSI_AWAL = $('#PRESENSI_AWAL').text();
                                    PRESENSI_AKHIR = $('#PRESENSI_AKHIR').text();

                                    if(PRESENSI_AWAL == '--:--')
                                        $('#PRESENSI_AWAL').text(data.jam);
                                    else
                                        $('#PRESENSI_AKHIR').text(data.jam);*/
                                }

                                return false;
                          });

                        


                    }
                },
                Nanti: function(){
                    // do nothing.
                }
            }
        });

    }


    function reloadData(mode)
    {
           $.post( "app/log_presensi", { "PEGAWAI_ID": "<?=$PEGAWAI_ID?>", "TOKEN": "<?=$csrf_log->getToken()?>", "MODE": mode })
           .done(function( data ) {
                
                data = JSON.parse(data);

                if(data.status == 'success')
                {

                    arr = data.result;

                    arr.forEach(function(item){

                        div = `
                            <div class="item">
                                <div class="data">
                                    <div class="title">`+item.tanggal+`</div>
                                    <div class="pukul">`+item.jam+`</div>
                                </div>
                                <div class="ikon">
                                    <i class="fa fa-circle fa-`+item.indikator+`" aria-hidden="true"></i>
                                </div>
                                <div class="clearfix"></div>
                            </div>        
                        `;
    
                        if(mode == 'all')
                            $('#logChecklog').append(div);
                        else
                            $('#logChecklog').prepend(div);


                    });
                    
                    $('#divInfoHistori').hide();

                }

                if(data.rownum == 0 && mode == 'all')
                {
                    div = `
                            <div class="item" id="divInfoHistori">
                                    <div class="title"></div>
                                    <div class="pukul" style="color:#50110F !important; text-align: center;">Belum ada histori data...</div>
                            </div>
                          `;
                    $('#logChecklog').append(div);
                }

                return false;
          });
    }
</script>

