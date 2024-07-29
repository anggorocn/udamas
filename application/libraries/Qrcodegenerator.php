<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kauth
 *
 * @author user
 */

class qrcodegenerator{
	
	var $NIP;
	
    /******************** CONSTRUCTOR **************************************/
    function __construct(){
	
		 $this->emptyProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
    }
		
    function generateQr($arrparam=[]){
    	include_once("functions/image.func.php");
		include_once("functions/string.func.php");
		include_once("functions/encrypt.func.php");
		/* GENERATE QRCODE */
		include_once("functions/phpqrcode/qrlib.php");
		$CI =& get_instance();
		
		$reqPegawaiId= $arrparam["reqPegawaiId"];
		$reqNip= $arrparam["reqPegawaiNipBaru"];
		$reqToken= $arrparam["reqToken"];

 		$reqLokasiParaf = $CI->config->item('base_url').'loginqrcode'.'/index/'.$reqToken;
 		// echo $reqLokasiParaf;exit;
 		$folderupload= "uploads";
 		$folderqr= $folderupload."/qr/";

 		chmod($folderupload, 0777);
 		$FILE_DIR= $folderqr;
 		if (!file_exists($FILE_DIR)) {
			makedirs($FILE_DIR, 0777, true);
		}
		chmod($folderqr, 0777);

		$filename= $FILE_DIR.$reqNip.'.png';
		$filepath=  $filename;
		
		if(file_exists($filename))
			return;

		$errorCorrectionLevel = 'H';   
		$matrixPointSize = 3.78;

		QRcode::png($reqLokasiParaf, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   
		
		// Apabila mengunakan logo Kecil di tengah
		$logoThumps = "images/logo_jombang_trans.png";
		$QR = imagecreatefrompng($filepath);
		$logo = imagecreatefromstring(file_get_contents($logoThumps));
		imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
		imagealphablending($logo , false);
		imagesavealpha($logo , true);

		$QR_width = imagesx($QR);
		$QR_height = imagesy($QR);

		$logo_width = imagesx($logo);
		$logo_height = imagesy($logo);
		// Scale logo to fit in the QR Code

		$logo_qr_width = $QR_width/3;
		$scale = ($logo_width/$logo_qr_width);
		$logo_qr_height = $logo_height/$scale;
		imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
		
		// Save QR code again, but with logo on it
		imagepng($QR,$filepath);

		chmod($folderqr, 0555);
		chmod($folderupload, 0555);

    }
    
			   
}
	
  /***** INSTANTIATE THE GLOBAL OBJECT */
  $qrCode = new qrcodegenerator();

?>
