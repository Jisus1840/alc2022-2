<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../lib/PHPMailer-master/src/Exception.php';
require '../lib/PHPMailer-master/src/PHPMailer.php';
require '../lib/PHPMailer-master/src/SMTP.php';

class correo{
	function enviarcorreo($correo,$namecorreo,$cc='',$titulo,$asunto,$doc=array()){
		$mail = new PHPMailer;       
		$mail->isSMTP(); 
		$mail->Host = $GLOBALS['global_correohost'];
		$mail->Port       = $GLOBALS['global_correoPort'];
        $mail ->SMTPSecure = $GLOBALS['global_correoSMTPSecure'];
		$mail->SMTPAuth = true;
		$mail->Username = $GLOBALS['global_correo']; //aqui va el usuario del correo electrónico
		$mail->Password = $GLOBALS['global_correopwd']; //aqui va la contraseña del usuario de correo electrónico
		$mail->CharSet = 'UTF-8';
		$mail->setFrom($GLOBALS['global_correo'], $GLOBALS['global_correofrom']);  //el correo debe ser igual a mail->Username, si no el correo no es autenticado correctamente
		$mail->addReplyTo($GLOBALS['global_correo'], $GLOBALS['global_correofrom']);  // esta línea es opcional
		$mail->addAddress($correo, $namecorreo);    
		$mail->addCC($cc);  //opcional, solo se usa si se va a enviar copias
		$mail->addBCC($GLOBALS['global_correo']); //opcional, solo se usa si se va a enviar copias ocultas
		$mail->Subject = $titulo;
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Body = $asunto;
		$mail->isHTML(true);
		//si doc es diferente a nada entonces
        foreach ($doc as $file){
            $url = $file;
            $fichero = file_get_contents($url);
            $mail->addStringAttachment($fichero, basename($file));
        }
        //$mail->addAttachment('archivo_adjunto.pdf'); // opcional, solo si se van a anexar archivos al correo
		if (!$mail->send()) {
			$bitacora = new bitacora();
		    $bitacora->guardar('CORREO','Respuesta de correo <b>'.$mail->ErrorInfo.'</b>','');
            return 'Mailer Error: '.$correo.' '.$mail->ErrorInfo;
        } else {
            $bitacora = new bitacora();
		    $bitacora->guardar('CORREO','Respuesta de correo <b>Mensaje Enviado a '.$correo.'</b>','');
			return 'Mensaje Enviado a '.$correo;
        } 
	}
}
?>