<?
//include_once 'class.phpmailer.php';
require 'mail/PHPMailerAutoload.php';

class KMail extends PHPMailer{
    function __construct($exceptions = false) {
        parent::__construct($exceptions);
        
        $this->IsSMTP();
		$this->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);		
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
						
		
		$this->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
        $this->Host     = "smtp.gmail.com";
        $this->Port     = 587;
        $this->SMTPAuth = TRUE;   
        $this->Username = "no.reply.presensipjb@gmail.com";  
        $this->Password = "P3lindoDaya"; 

        $this->From     = "no.reply.presensipjb@gmail.com";
        $this->FromName = "AIMS - PT. Pelabuhan Indonesia III (Persero)";
        $this->SMTPSecure  = "tls";

        $this->WordWrap = 50;			
        $this->Priority = 1;
        $this->CharSet = "UTF-8";
        $this->IsHTML(TRUE);
        $this->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		
/*
		$this->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
        $this->Host     = "mail.apsupports.com";
        $this->Port     = 465;
        $this->SMTPAuth = TRUE;   
        $this->Username = "eproc@apsupports.com";  
        $this->Password = "Apsupports2018"; 

        $this->From     = "eproc@apsupports.com";
        $this->FromName = "e-Procurement - PT. APS";
        $this->SMTPSecure  = "ssl";

        $this->WordWrap = 50;			
        $this->Priority = 1;
        $this->CharSet = "UTF-8";
        $this->IsHTML(TRUE);
        $this->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		*/
		
    }
}

?>