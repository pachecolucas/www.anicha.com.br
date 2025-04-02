<?php

class Email_Facade extends Cbtec_Model_Facade {
	
	public function send($toName, $toEmail, $msgTitle, $msgSubTitle, $msgBody, $subject) {
		return $this->getService("Html")->send($toName, $toEmail, $msgTitle, $msgSubTitle, $msgBody, $subject);
	}
	
}