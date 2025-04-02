<?php

class Eliti_Controller_Plugin_Lang extends Zend_Controller_Plugin_Abstract  {
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$this->setLang($request);
	}
	
	private function setLang(Zend_Controller_Request_Abstract $request) {
		$localeSession = new Zend_Session_Namespace('Eliti_Application_Session');
		
		// Setando Locale...
		if($this->getRequest()->getParam('lang')) {
			$lang = $this->getRequest()->getParam('lang');
			if(Zend_Locale::isLocale($lang)) {
				$localeSession->locale = new Zend_Locale($lang);
			}
		}
		
		if(!$localeSession->locale instanceof Zend_Locale) {
			$localeSession->locale = new Zend_Locale('pt');
		}
	}
}