<?

class Eliti_Mail_Smtp extends Zend_Mail {
	
		private $transp;
		
		public function __construct($email, $senha) {
			// Configuraçães para envio de e-mail
			$config = array('auth' => 'login', 'username' => $email, 'password' => $senha, 'ssl' => 'ssl', 'port' => 465);
			
			// Instancia da classe para autenticar
			$this->transp = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
		}
		
		public function send($transport = null) {
			return parent::send($this->transp);
		}
}