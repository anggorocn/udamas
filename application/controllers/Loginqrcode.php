<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// include_once("functions/image.func.php");i
include_once("functions/string.func.php");
// include_once("functions/browser.func.php");
include_once("functions/date.func.php");
include_once("functions/encrypt.func.php");
class Loginqrcode extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->library('kauth');

		$CI =& get_instance();
		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];
	}
	
	public function login()
	{
		$reqToken= $this->input->post("reqToken");
		$reqPasswd= $this->input->post("reqPasswd");

		// $arrData = mdecrypt($reqToken,'siapasn02052018');
		// $arrData = explode('-',$arrData);
		// $reqUser = str_replace(" ","",$arrData[1]);
		// print_r($arrData);exit;
		
		$settingurlapi= $this->config->config["settingurlapi"];
		$url =  $settingurlapi.'api-baru/Pegawai_baru_json/?reqToken='.$reqToken;
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
        
        $arrData = json_decode($html,true);
        $arrData =  $arrData['result'];
		$reqUser = $arrData[0]['NIP_BARU'];
		//redirect('app');exit;
		// echo $reqUser." - ".$reqPasswd;exit;
		if(!empty($reqUser) AND !empty($reqPasswd))
		{
			$result= $this->sendLogin($reqUser, $reqPasswd);
			// 502
			// print_r($result);exit();

			$tempCheckLogin= $tempCheckToken= "";
			if ($result) {
				foreach ($result as $key=>$value) {
					if($key == "code")
					{
						if($value == "502")
						{
							$tempCheckLogin= "1";
						}
						elseif ($value == "503")
						{
							$tempCheckLogin= "2";
						}
						elseif($value == "504")
						{
							$tempCheckLogin= "3";
						}
						elseif($value == "505")
						{
							$tempCheckLogin= "4";
						}
					}
					elseif($key == "token")
					{
						$tempCheckToken= $value;
					}
					// echo $key."-".$value."<br/>";
				} 
			}

			if($tempCheckLogin == "1")
			{
				$respon= "Anda Gagal Login, Cobalah Beberapa Saat Lagi.";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
			elseif ($tempCheckLogin == "2")
			{
				$newline= '\r\n';
				$respon = "Password yang Anda masukkan SALAH.";
				$respon.=$newline;
				$respon.="Data yang telah Anda isikan :";
				$respon.=$newline;
				$respon.="Password `".$reqPasswd."`";
				$respon.=$newline;
				$respon.= "Ulangi dan cek kembali isian Anda atau hubungi Admin OPD untuk cek data.";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
			elseif ($tempCheckLogin == "3")
			{
				$respon= "Masukkan  Password untuk login. Hubungi Admin OPD untuk cek data";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
			elseif ($tempCheckLogin == "4")
			{
				$newline= '\r\n';
				$respon = "Data Anda masukkan SALAH atau tidak sesuai format.";
				$respon.=$newline;
				$respon.="Data yang telah Anda isikan :";
				$respon.=$newline;
			
				$respon.="Password `".$reqPasswd."`";
				$respon.=$newline;
				$respon.= "Ulangi dan cek kembali isian Anda atau hubungi Admin OPD untuk cek data.";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
		}
		else
		{
			echo "Asd";exit;
			redirect('loginqrcode/index'.$reqToken);
		}	
	}

	
	public function logout()
	{
		$reqToken = $_SESSION["token"];
		$this->kauth->getInstance()->clearIdentity();
		redirect('loginqrcode/'.$reqToken);
	}
	
	public function index()
	{
		$reqToken= $this->uri->segment(3, "");
		$settingurlapi= $this->config->config["settingurlapi"];
		$url=  $settingurlapi.'Pegawai_baru_json/?reqToken='.$reqToken;
		// echo $url;exit;
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
        $arrData= json_decode($html,true);
        $arrData=  $arrData['result'];
		$reqUser= $arrData[0]['NIP_BARU'];
		// print_r($html);exit;

		if(!empty($reqUser))
		{
			$reqPasswd= "onepass";
			$result= $this->sendLogin($reqUser, $reqPasswd);

			if ($result) {
				foreach ($result as $key=>$value) {
					if($key == "code")
					{
						if($value == "502")
						{
							$tempCheckLogin= "1";
						}
						elseif ($value == "503")
						{
							$tempCheckLogin= "2";
						}
						elseif($value == "504")
						{
							$tempCheckLogin= "3";
						}
						elseif($value == "505")
						{
							$tempCheckLogin= "4";
						}
					}
					elseif($key == "token")
					{
						$tempCheckToken= $value;
					}
					// echo $key."-".$value."<br/>";
				} 
			}

			if($tempCheckLogin == "1")
			{
				$respon= "Anda Gagal Login, Cobalah Beberapa Saat Lagi.";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
			elseif ($tempCheckLogin == "2")
			{
				$newline= '\r\n';
				$respon = "Password yang Anda masukkan SALAH.";
				$respon.=$newline;
				$respon.="Data yang telah Anda isikan :";
				$respon.=$newline;
				$respon.="Password `".$reqPasswd."`";
				$respon.=$newline;
				$respon.="Username `".$reqUser."`";
				$respon.=$newline;
				$respon.= "Ulangi dan cek kembali isian Anda atau hubungi Admin OPD untuk cek data.";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
			elseif ($tempCheckLogin == "3")
			{
				$respon= "Masukkan Username dan Password untuk login. Hubungi Admin OPD untuk cek data";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
			elseif ($tempCheckLogin == "4")
			{
				$newline= '\r\n';
				$respon = "NIP Baru yang Anda masukkan SALAH atau tidak sesuai format.";
				$respon.=$newline;
				$respon.="Data yang telah Anda isikan :";
				$respon.=$newline;
				$respon.="Username `".$reqUser."`";
				$respon.=$newline;
				$respon.="Password `".$reqPasswd."`";
				$respon.=$newline;
				$respon.= "Ulangi dan cek kembali isian Anda atau hubungi Admin OPD untuk cek data.";
				?>
                <script language="javascript">
					alert('<?=$respon?>');
					document.location.href = 'logout';
				</script>
          		<?
				exit;
			}
			else
			{
				// $this->session->set_userdata('sessinfopesan'.$configvlxsessfolder, "Username dan password tidak sesuai.");
				$this->kauth->localToken($result->token);
				redirect('app/index');
			}
		}
		else
		{
			redirect('login');
		}
	}
	
	function sendLogin($username, $password) {
		$settingurlapi= $this->config->config["settingurlapi"];
		// echo $settingurlapi;exit;

		$curl = curl_init();
		// $url = '192.168.88.31/simpeg/jombang-allnew/api/login_json';
		// $url = 'https://siapasn.jombangkab.go.id/api/login_json';
		//$url = 'http://siapasn.jombangkab.go.id/api-dev/login_json';

		$url= $settingurlapi.'login_json';
		// echo $url;exit;

		// set post fields
		$fields = array(
			'reqUser' => urlencode($username),
		    'reqPasswd' => urlencode($password)
		);

		//url-ify the data for the POST
		foreach($fields as $key=>$value) 
		{ 
			$fields_string .= $key.'='.$value.'&'; 
		}
		rtrim($fields_string, '&');

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 500,
			CURLOPT_SSL_VERIFYPEER => false,
  			 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
  			// CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POST => count($fields),
			CURLOPT_POSTFIELDS => $fields_string,
			/*CURLOPT_HTTPHEADER => array(
				"authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImYyNGI0YjQ0ODQ4ZjA0M2QyMzQ3OGFjOWIzMDBmZmRhZDgyYjBjMDYyMmViZGNmNWE5NmU4ZmRiOTkwMGNjZWEwZGM1NDRmYThkNDQyZWNlIn0.eyJhdWQiOiIxIiwianRpIjoiZjI0YjRiNDQ4NDhmMDQzZDIzNDc4YWM5YjMwMGZmZGFkODJiMGMwNjIyZWJkY2Y1YTk2ZThmZGI5OTAwY2NlYTBkYzU0NGZhOGQ0NDJlY2UiLCJpYXQiOjE1NDgzMTE5NzQsIm5iZiI6MTU0ODMxMTk3NCwiZXhwIjoxNTc5ODQ3OTc0LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.FPIX2boy-8UjUfo-Ie514fPnF-gRi0gn2k4qViNplDmozqJ49oU9fpBZsWX6Jw8aXWXUFnOfXOC4ZUHkMY4EMlQF-fSUvOBLp_9Ni2mpnc6QCN7i6CnWyhAc5fFVWDKrW_KCWb-Hd-xUCymh_sgQ0h2CMVcROQZY9oUjj2RQIGCsk_rmSoIxB9UigqUDGFE5X-m-n1hhZJ-feI_vesE1O0hZwWjT_wm6B8oklhQSUzxO-NrVhSj-GKs4JC2WQMQlsw1UQCRKyH-Y-0OZZIk1aCRWIEAKfQcUAYN_ZteMG9fNd9e4kzuQL-2nrnrf3rvUSY1KzpSd-i88R4vJH74KHqtCNnWDB11zyHRdznxGfz6IvABvBzj102M_9cGZagC-CcNu-igc8oHmMhUnZoTWTTgGtWQOMImRAikHZ7uknuf0ZhYZKXAnO7mRfxJfLOMO853Mhv05iUmHMAxbZFoTo283_SoTlAt0g6t2YUlVK4M9hoaxsi2E5opMeVuFaA30v08JXDFrR9z3JsLSO0aLs5t0UL2Jo6asqvzp9UY5LDfTnoXMT_jqmp_B382v2BbU8GDQE83NA9cnIqUQP0LyF1gP3qruz-c3ABvcUsHNSJTVMoebXQHCzpXNiL0hqA2XOJxugw64XveZ9xYJd0nlL1EJtnlUdL5eGfwD3C5G4JU",
				"cache-control: no-cache"
			),*/
		));

		$response = curl_exec($curl);
		$res = json_decode($response);
		// print_r($res);exit();
		// echo "s"; print_r($response);exit();

		$err = curl_error($curl);
		// echo "s"; print_r($err);exit();
		curl_close($curl);
	
		return $res;
	}

}