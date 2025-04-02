<?php

require_once('class.phpmailer.php');

//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

class User_Entity_Email {

    public function send($toName, $toEmail, $msgTitle, $msgSubTitle, $msgBody, $subject) {
        $body = "
<html>
	<body style='margin:0; background:#53A1D7;'>
		<div style='background:#53A1D7; text-align:center; padding:20px 0 20px 0; font-family:Arial, sans-serif; color:grey'>
			<a style='color:#FFF; font-size:22px; font-weight:bold; text-decoration:none;' href='" . SITE . "'><img border='0' style='border:none;' src='cid:logo' alt='" . SITENAME . "' /></a>
			<div style='width:500px; margin:10px auto 0 auto; background:white; border:1px solid #DDD; padding:25px 10px 10px 10px;'>
					<h1 style='font-size:20px; padding-bottom:20px; margin:0; color:#E05424'>$msgTitle</h1>
					<div style='margin:0; padding-bottom:20px; font-size:14px;'>
						<span style='font-weight:bold;'>$msgSubTitle</span>
						<br><br>
						$msgBody
					</div>
			</div>
			<div style='font-size:10px; color:#FFF; margin-top:30px;'>
				<p>acesse o site:<br><b><a href='" . SITE . "' style='color:white;'>escolatecnicaprosaude.com</a></b></p>
			</div>
		</div>
	</body>
</html>
		";


        try {
            $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

            $mail->IsSMTP(); // telling the class to use SMTP
//            $mail->SMTPDebug = 1;

            $mail->SMTPAuth = true;                  // enable SMTP authentication
//            $mail->SMTPSecure = "tls";                // sets the prefix to the servier
            $mail->Host = "mail.escolatecnicaprosaude.com";      // sets GMAIL as the SMTP server
            $mail->Port = 587;              // set the SMTP port for the GMAIL server
            $mail->Username = "naoresponder@escolatecnicaprosaude.com";  // GMAIL username
            $mail->Password = "1hr74g943";        // GMAIL password
            $mail->Subject = utf8_decode($subject);
            $mail->AltBody = "Para ver esta mensagem utilize um visualizador de e-mail compatível com HTML."; // optional - MsgHTML will create an alternate automatically

            $mail->AddAddress($toEmail, $toName);
            $mail->SetFrom('naoresponder@escolatecnicaprosaude.com', utf8_decode('Pró-Saúde'));
            $mail->AddBCC("pachecoteixeira@gmail.com", "Lucas Pacheco");
//            $mail->AddReplyTo("naoresponder@ionics.com.br", utf8_decode("IONICS Mobile"));

            $mail->AddEmbeddedImage(dirname(__FILE__) . '/logo.png', "logo", "logo.png");
            $mail->MsgHTML($body);
            //$mail->AddAttachment(dirname( __FILE__ ).'/logo.png');      // attachment

            $mail->Send();
        } catch (phpmailerException $e) {
            throw new Exception("Erro ao enviar e-mail: " . $e->errorMessage()); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            throw new Exception("Erro ao enviar e-mail de validação: " . $e->getMessage()); //Boring error messages from anything else!
        }
    }

}
