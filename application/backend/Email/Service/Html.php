<?php

class Email_Service_Html extends Eliti_Backend_Service  {
	
	public function send($toName, $toEmail, $msgTitle, $msgSubTitle, $msgBody, $subject) {
		
		$body = "
<html>
	<body style='margin:0; background:#F3F3F3;'>
		<div style='background:#F3F3F3; text-align:center; padding:20px 0 20px 0; font-family:Arial, sans-serif; color:grey'>
			<a style='color:#E05424; font-size:22px; font-weight:bold; text-decoration:none;' href='".SITE."'><img border='0' style='border:none;' src='".SITE."img/logo3.png' alt='Markapreco' /></a>
			<div style='width:500px; margin:10px auto 0 auto; background:white; border:1px solid #DDD; padding:25px 10px 10px 10px;'>
					<h1 style='font-size:20px; padding-bottom:20px; margin:0; color:#E05424'>$msgTitle</h1>
					<p style='margin:0; padding-bottom:20px; font-size:14px;'>
						<span style='font-weight:bold;'>$msgSubTitle</span>
						<br><br>
						$msgBody
					</p>
			</div>
			<div style='font-size:10px; color:#E05424; margin-top:30px;'>
				<p>acesse o site:<br><b><a href='".SITE."' style='color:#E05424;'>www.markapreco.com.br</a></b></p>
			</div>
		</div>
	</body>
</html>
		";
		
		// Resposta Autom�tica para Cliente
		$mail = new Cbtec_Mail_Smtp("contato@worldinf.com.br", "jd84yf75");
		$mail->setBodyHtml($body);
		$mail->setFrom('contato@worldinf.com.br', 'World Informática');
		$mail->addTo($toEmail, $toName);
		$mail->addBcc("pachecoteixeira@gmail.com", "Lucas Pacheco Teixeira");
		$mail->addBcc("worldinf@worldinf.com.br", "World Informática");
		$mail->setSubject($subject);
		$mail->send();
		
	}
	
}