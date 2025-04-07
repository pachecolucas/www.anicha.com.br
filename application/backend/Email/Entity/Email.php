<?php

// EMAIL CLASS
require_once('class.phpmailer.php');

class Email_Entity_Email {

    public $body;
    public $subject;
    public $fromName;
    public $fromEmail;

    public function __construct($fromName, $fromEmail, $body, $subject) {
        $this->fromName = utf8_decode($fromName);
        $this->fromEmail = $fromEmail;
        $this->body = utf8_decode($body);
        $this->subject = utf8_decode($subject);
    }

    public function send() {
        try {
            $mail = new PHPMailer(true); // defaults to using php "Sendmail" (or Qmail, depending on availability)
            $mail->IsMail(); // telling the class to use native PHP mail()
            // DESTINATÁRIOS
            $mail->AddAddress("nilma@anicha.com.br", utf8_decode("Nilma"));
            $mail->AddAddress("jorg@anicha.com.br", utf8_decode("Joerg"));
            $mail->AddBCC("pachecoteixeira@gmail.com", utf8_decode("Lucas Pacheco Teixeira"));

            // REMETENTE
            if ($this->fromEmail == "" || $this->fromEmail == null)
                throw new Exception("Erro ao enviar email. Faltou informar email do remetente");
            if ($this->fromName == "" || $this->fromName == null)
                throw new Exception("Erro ao enviar email. Faltou informar nome do remetente");
            $mail->SetFrom($this->fromEmail, $this->fromName);

            // ASSUNTO
            $mail->Subject = $this->subject;

            // BODY
            $this->body = nl2br($this->body);
            $mail->MsgHTML($this->body);

            // ANEXO
// 		$mail->AddAttachment("logo.gif");      // attachment
            $mail->Send();
        } catch (phpmailerException $e) {
            throw new Exception("<strong>Erro ao enviar e-mail:</strong><br/>" . $e->errorMessage()); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            throw new Exception("<strong>Erro ao enviar e-mail:</strong><br/>" . $e->getMessage()); //Boring error messages from anything else!
        }
    }

    public function __toString() {
        return $this->body;
    }

}
