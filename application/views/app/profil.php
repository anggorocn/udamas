<?
include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");
$this->load->model('base-curl/DataCombo');

$sessPersonalToken= $this->PERSONAL_TOKEN;

$arrparam= ["token"=>$sessPersonalToken, "vurl"=>"Pegawai_json"];
$set= new DataCombo();
$set->selectdata($arrparam, "");
$arrDataPegawai= $set->rowResult;
$arrDataPegawai=$arrDataPegawai[0];
// print_r($arrDataPegawai);
$set->firstRow();

$reqLoginUser= $set->getField('NIP_BARU');
$reqRowId= $set->getField('PEGAWAI_ID');
$reqNama= $set->getField('NAMA_LENGKAP');
$reqSatkerId= $set->getField('SATUAN_KERJA_ID');

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

$vurlbase= $this->config->item('base_url');

$urlBarcode= $vurlbase.$arrDataPegawai['barcode'];
// echo $urlBarcode;exit;
$urlFoto = $this->config->item('settingurl').$arrDataPegawai['path'];
$urlBarcode2= 'https://bkpsdm.jombangkab.go.id/uploads/qr'.$reqLoginUser.'.png';
if(!file_get_contents($urlBarcode)){
  $iRl= $vurlbase.'autobarcode/barcode?id='.$reqRowId.'&nip='.$reqLoginUser;
  // echo $iRl;exit;
  $ch = curl_init();    
  curl_setopt($ch, CURLOPT_URL, $iRl);    
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
  $output = curl_exec($ch); 
  curl_close($ch);      
}

$arrDataJenisKelamin['L']='Laki - Laki';
$arrDataJenisKelamin['P']='Perempuan';

$b64image = base64_encode(file_get_contents($urlBarcode));

$reqPasswordBaru= $reqPasswordLama= "";

// if($reqRowId == "8423")
// {
//   $reqPasswordLama= "YATI ( ALM )12051934";
//   $reqPasswordBaru= "Umiati69";
// }
?>
<script type="text/javascript">
$(function(){
  let validator = $('#ff').jbvalidator({
    errorMessage: true
    , successClass: true
  });



  $(document).on('submit', '#ff', function(){


     var dataform = $('#ff')[0];
    var formData = new FormData(dataform);
      $.ajax({
        url:"api/Ganti_password_json/add"
        , type: 'POST'
        , data:formData
        , dataType: 'json'
        , processData: false
        , contentType: false
        , success: function (response){
          // console.log(response);return false;
          $.alert({
            title: 'Info Simpan !!!',
            content: response.message,
            buttons: {
              ok: {
                keys: [
                'enter'
                ],
                action: function(){
                  addurl= "";
                  <?
                  if(!empty($reqId))
                  {
                  ?>
                  addurl= "?reqId=<?=$reqId?>";
                  <?
                  }
                  elseif(!empty($reqRowId))
                  {
                  ?>
                  addurl= "?reqRowId=<?=$reqRowId?>";
                  <?
                  }
                  ?>
                  document.location.href = "app/index/profil";
                }
              },
            },
          });
        }
        ,
        error: function(xhr, status, error) {
          var err = JSON.parse(xhr.responseText);
          $.alert(err.message);
        }
      })
      return false;
    });
    });
</script>
<div class="row">
  <div class="col-md-12">
    <div class="judul-halaman">
      <h1>Profil</h1>
      <h6>
        <span class="ikon"><i class="fa fa-arrow-right" aria-hidden="true"></i></span>&nbsp;&nbsp;
        <span>Halaman Profil &amp; Kelola Password</span>
      </h6>
    </div>
    <div class="area-panel">
      <div class="judul-panel">
        Profil &amp; Kelola Password
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="area-data-pegawai kelola-password">
            <form class="needs-validation" id="ff" method="post" novalidate enctype="multipart/form-data">
              <div class="area-foto">
                <div class="row">
                  <div class="col-md-2">
                    <div class="foto">
                      <img src="<?=$urlFoto?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div style="font-size: 20px; font-family: 'Poppins 600';"><?=$arrDataPegawai['gelar_depan']?><?=$arrDataPegawai['nama']?><?=$arrDataPegawai['gelar_belakang']?></div>
                    </div>
                    <div class="form-group">
                      <label>NIP</label>
                      <input type="text" class="form-control data-inline" value="<?=$arrDataPegawai['nip_baru']?>" disabled="" />
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control data-inline" value="<?=$arrDataPegawai['email']?>" disabled="" />
                    </div>
                  </div>
                  <div class="col-md-4" align="center">
                    <div class="area-qr-code">
                      <div><img src="data:image/png;base64,<?=$b64image?>" name="anImage" height="120" id="barcode"></div>
                      <a  href="data:image/png;base64,<?=$b64image?>"   download  class="btn btn-danger btn-download-qrcode" title="Download QR Code" >
                        <i class="fa fa-arrow-down" aria-hidden="true"></i><br>
                      </a>
                    </div>
                  </div>
                </div>  
              </div>
              
              <div class="row">
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" class="form-control" value="<?=$arrDataPegawai['tempat_lahir']?>" disabled="" />
                      </div>
                    </div>
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="text" class="form-control" value="<?=getFormattedDate($arrDataPegawai['tanggal_lahir'])?>" disabled="" />
                      </div>
                    </div>
                  
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <input type="text" class="form-control" value="<?=$arrDataJenisKelamin[$arrDataPegawai['jenis_kelamin']]?>" disabled="" />
                      </div>
                    </div>
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>Golongan Darah</label>
                        <input type="text" class="form-control" value="<?=$arrDataPegawai['golongan_darah']?>" disabled="" />
                      </div>
                    </div>
                  
                    <!-- <div class="col-md-12 mb-12">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="rendyantoko.rinaldi@gmail.com" disabled="" />
                      </div>
                    </div> -->
                  
                    <div class="col-md-12 mb-12">
                      <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" value="<?=$arrDataPegawai['alamat']?>" disabled="" />
                      </div>
                    </div>
                  
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>Telpon</label>
                        <input type="text" class="form-control" value="<?=$arrDataPegawai['telepon']?>" disabled="" />
                      </div>
                    </div>
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>HP</label>
                        <input type="text" class="form-control" value="<?=$arrDataPegawai['hp']?>" disabled="" />
                      </div>
                    </div>
                  
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-control" value="<?=$arrDataPegawai['nik']?>" disabled="" />
                      </div>
                    </div>
                    <div class="col-md-6 mb-6">
                      <div class="form-group">
                        <label>NPWP</label>
                        <input type="text" class="form-control" value="<?=$arrDataPegawai['npwp']?>" disabled="" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="area-kelola-password">
                    <h4 class="judul-panel">Kelola Password</h4>
                    <div class="row">
                      <div class="col-md-12 mb-12">
                        <div class="form-group">
                          <label for="reqNoSk">Masukan Password Lama </label>
                          <input type="Password" class="form-control  easyui-validatebox" required id="reqPasswordLama" name="reqPasswordLama" value="<?=$reqPasswordLama?>" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-12">
                        <div class="form-group">
                          <label for="reqNoSk">Masukan Password Baru </label>
                          <input type="Password" class="form-control  easyui-validatebox" required id="reqPasswordBaru" name="reqPasswordBaru" value="<?=$reqPasswordBaru?>" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-12">
                        <div class="form-group">
                          <label for="reqNoSk">Ulangi Password Baru </label>
                          <input type="Password" class="form-control  easyui-validatebox" required id="reqPasswordUlangi" name="reqPasswordUlangi" value="<?=$reqPasswordBaru?>" />
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div><br/>

                    <div class="row">
                      <div class="col-md-12">
                      <input type="hidden" name="reqId" value="<?=$reqId?>" />
                      <input type="hidden" name="reqRowId" value="<?=$reqRowId?>" />
                      <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                      <input type="hidden" name="reqNama" value="<?=$reqNama?>" />
                      <input type="hidden" name="reqSatkerId" value="<?=$reqSatkerId?>" />
                      <input type="hidden" name="reqLoginUser" value="<?=$reqLoginUser?>" />
                        <button class="btn btn-primary" type="submit">Simpan</button>
                         <button class="btn btn-primary" style="background-color: #ffff66 !important; color: black !important " onclick='window.history.back()' type="button">Kembali</button>
                      </div>
                    </div>
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
