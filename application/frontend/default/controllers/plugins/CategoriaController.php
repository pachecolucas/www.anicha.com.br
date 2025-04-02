<?php

class CategoriaController extends Zend_Controller_Plugin_Abstract {
	
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
    	$cat = (int)$request->getParam("c");
    	$sub = (int)$request->getParam("s");
 		
    	if ($cat) {
    		Eliti_Backend::getInstance()->getSession()->c = $cat;
    	}
    	if ($sub) {
    		Eliti_Backend::getInstance()->getSession()->s = $sub;
    	}
    	if($cat && !$sub) {
    		Eliti_Backend::getInstance()->getSession()->s = null;
    	}
    	
    }
}
