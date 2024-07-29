<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('kauth');

		$CI =& get_instance();
		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];
	}

	public function test()
	{
		echo 'TEST';
	}

	public function index()
	{
		$reqUser = $this->input->get("reqUser");
		$reqPasswd = $this->input->get("reqPasswd");
		//if submitted
		if(!empty($reqUser) AND !empty($reqPasswd))
		{
			$respon = $this->kauth->localAuthenticate($reqUser,$reqPasswd);
			
			echo $respon; exit;
			
			if($respon == "1")
			{
				redirect('app');			
			}
			else
			{
				$data['pesan']=$respon;
				$this->load->view('login/login', $data);
			}
		}
		else
		{
			$data['pesan']= "";
			$this->load->view('login/login');
		}
	}

	public function login()
	{
		$reqUser= $this->input->post("reqUser");
		$reqPasswd= $this->input->post("reqPasswd");


		// $this->kauth->localToken("d156dcfa36b6226e9b4cd5e781addddd");
		// exit;

		if(!empty($reqUser) AND !empty($reqPasswd))
		{
			$result= $this->sendLogin($reqUser, $reqPasswd);
			// print_r($result);exit;

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
			CURLOPT_POST => count($fields),
			CURLOPT_POSTFIELDS => $fields_string,
		));

		$response = curl_exec($curl);
		$res = json_decode($response);
		// print_r($res);exit();

		$err = curl_error($curl);
		// print_r($err);exit();
		curl_close($curl);
	
		return $res;
	}

	public function multi()
	{
		
		$respon = $this->kauth->multiAkses($_POST['reqGroupId']);
		
		if($respon == "1")
			redirect('app');
	}


	public function loadUrl()
	{
		
		$reqFolder = $this->uri->segment(3, "");
		$reqFilename = $this->uri->segment(4, "");
		$reqParse1 = $this->uri->segment(5, "");
		$reqParse2 = $this->uri->segment(6, "");
		$reqParse3 = $this->uri->segment(7, "");
		$reqParse4 = $this->uri->segment(8, "");
		$reqParse5 = $this->uri->segment(9, "");
		$data = array(
			'reqParse1' => urldecode($reqParse1),
			'reqParse2' => urldecode($reqParse2),
			'reqParse3' => urldecode($reqParse3),
			'reqParse4' => urldecode($reqParse4),
			'reqParse5' => urldecode($reqParse5)
		);
		$this->load->view("email".'/'.$reqFilename, $data);
	}	

	public function logout()
	{
		$this->kauth->unsettoken();
		redirect ('login');
	}
			
}