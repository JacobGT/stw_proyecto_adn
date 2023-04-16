<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class correoController extends Controller{
	
	public function __construct(){
		parent::__construct();
		$this->modelo=$this->loadModel('correo','correos');
		$this->view->template = 'main';
	}
	
	public function index(){
		
	}
	
	public function enviar_correo($attachment){
		/*use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\SMTP;
		use PHPMailer\PHPMailer\Exception;
		
		require_once LIB_PATH . 'PHPMailer' . DS .'src' . DS . 'PHPMailer.php';
		require_once LIB_PATH . 'PHPMailer' . DS .'src' . DS . 'Exception.php';
		require_once LIB_PATH . 'PHPMailer' . DS .'src' . DS . 'SMTP.php';*/
		
		//$registry->mail = new PHPMailer(true);
		
		$mail = $this->registry->mail;
		
		$mail = new PHPMailer(true);
		
		try {
			/*$asunto = str_replace('spc', ' ', $asunto);
			$asunto = str_replace('pntcma', ';', $asunto);
			$asunto = str_replace('cln', ':', $asunto);
			$asunto = str_replace('pnt', '.', $asunto);
			$asunto = str_replace('cma', ',', $asunto);
			$asunto = str_replace('qst', '?', $asunto);
			$asunto = str_replace('excl', '!', $asunto);
			$asunto = str_replace('lohyph', '_', $asunto);
			$asunto = str_replace('hyph', '-', $asunto);
			$asunto = str_replace('nuul', '0', $asunto);
			$asunto = str_replace('odin', '1', $asunto);
			$asunto = str_replace('dva', '2', $asunto);
			$asunto = str_replace('tri', '3', $asunto);
			$asunto = str_replace('cetyre', '4', $asunto);
			$asunto = str_replace('pjat', '5', $asunto);
			$asunto = str_replace('sest', '6', $asunto);
			$asunto = str_replace('sem', '7', $asunto);
			$asunto = str_replace('vosem', '8', $asunto);
			$asunto = str_replace('devjat', '9', $asunto);
			
			
			
			$mensaje = str_replace('spc', ' ', $message);
			$mensaje = str_replace('pntcma', ';', $mensaje);
			$mensaje = str_replace('cln', ':', $mensaje);
			$mensaje = str_replace('pnt', '.', $mensaje);
			$mensaje = str_replace('cma', ',', $mensaje);
			$mensaje = str_replace('qst', '?', $mensaje);
			$mensaje = str_replace('excl', '!', $mensaje);
			$mensaje = str_replace('lohyph', '_', $mensaje);
			$mensaje = str_replace('hyph', '-', $mensaje);
			$mensaje = str_replace('nuul', '0', $mensaje);
			$mensaje = str_replace('odin', '1', $mensaje);
			$mensaje = str_replace('dva', '2', $mensaje);
			$mensaje = str_replace('tri', '3', $mensaje);
			$mensaje = str_replace('cetyre', '4', $mensaje);
			$mensaje = str_replace('pjat', '5', $mensaje);
			$mensaje = str_replace('sest', '6', $mensaje);
			$mensaje = str_replace('sem', '7', $mensaje);
			$mensaje = str_replace('vosem', '8', $mensaje);
			$mensaje = str_replace('devjat', '9', $mensaje);*/
			
			
		    $mail->SMTPOptions = array(
		    	'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    ));
		    $mail->SMTPDebug = 0;                      
		    $mail->isSMTP();                                            
		    $mail->Host       = 'syswebgroup.online';                     
		    $mail->SMTPAuth   = true;                                   
		    $mail->Username   = 'kevin.secay@syswebgroup.online';                    
		    $mail->Password   = 'zsPDN$mS%,MS';                               

		    $mail->SMTPSecure = $mail::ENCRYPTION_SMTPS;
    		$mail->Port       = 465;            
			
		    
		    $mail->setFrom('kevin.secay@syswebgroup.online', 'Aduana SysWebGroup');
		    $mail->addAddress('polizas@aduana.yapasenosinge.syswebgroup.online');
		    $mail->addAddress('kevin.secay@syswebgroup.online', 'Aduana SysWebGroup');   

		    
		    $mail->isHTML(true);                              
		    $mail->Subject = 'Poliza';
		    $mail->Body    = 'Mensaje automatico con archivo pdf adjunto de poliza.';
		    $mail->AltBody = 'Mensjae automatico con archivo pdf adjunto de poliza.';
			$mail->CharSet = 'UTF-8';
			$mail->AddAttachment('application/modules/aduanas/poliza/reportes/' . $attachment.'[VERDE].pdf', $attachment.'[VERDE].pdf');
			$mail->AddAttachment('application/modules/aduanas/poliza/reportes/' . $attachment.'[ROJO].pdf', $attachment.'[ROJO].pdf');
		    $mail->send();
		    echo '<script>
		    alert("Se ha enviado correctamente el correo");
		    window.close();
		    </script>';
		    
		} catch (Exception $e) {
			$error = $mail->ErrorInfo;
			echo '<script>
		    alert("No se ha podido mandar el correo. Mailer Error: ' . $error . '");
		    window.close();
		    </script>';
		}			
	}
}
?>