<?php

/*
 * Solucaoo para utilizacao conjunta de Zend_Acl e Zend_Auth
 * inspirada em: http://devzone.zend.com/node/view/id/1665
 * 
 */

/**
 * Regra para cPanel
 */
class AccessController extends Zend_Controller_Plugin_Abstract {
    
    private static $ACL = array (
                    "default" => array(
                        "*" => array(),
                    ),
                    "user" => array(
                        "login" => array(
                            "authenticate",
                        ),
                        "theme" => array(
                            "*",
                        ),
                        "pass" => array(
                            "forgot",
                            "recovery",
                            "recovery-success",
                            "new",
                            "new-failed",
                            "save",
                            "save-success",
                        ),
                    ),
                    "prosaude" => array(
                        "*" => array(),
                    ),
                );
	
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
    	if ($this->ehPermitidoPelaACL($request)) {
            // Não é obrigatório estar logado para usar estes recursos, simplesmente deixa passar
    	} else if (!Eliti::getInstance()->hasUser()) { // verifica se está logado...
            // Não está logado, mas deveria estar!
            // leva o cara para tela de login
            $request->setModuleName("user");
            $request->setControllerName("login");
            $request->setActionName("index");
        }
    }
    
    private function ehPermitidoPelaACL(Zend_Controller_Request_Abstract $request) {
        
        // VERIFICANDO MODULE
        // permitir caso todos os modules etejam liberados
        if (array_key_exists("*", self::$ACL)) { return true; }
        // Negar se módulo em questão está não está liberado
        if (!array_key_exists($request->getModuleName(), self::$ACL)) { return false; }
        
        // VERIFICANDO CONTROLLER
        // Pega os controllers da ACL
        $controllesACL = self::$ACL[$request->getModuleName()];
        // Permitir caso todos os controllers desde module estejam liberados
        if (array_key_exists("*", $controllesACL)) { return true; }
        // Negar se o controller em questão não estiver liberado
        if (!array_key_exists($request->getControllerName(), $controllesACL)) { return false; }
        
        // VERIFICANDO ACTION
        // Pega as actions da ACL
        $actionsACL = $controllesACL[$request->getControllerName()];
        // Permitir caso todas as actions desde controller estejam liberadas
        if (in_array("*", $actionsACL)) { return true; }
        // Negar se a action em questão não estiver liberada
        if (!in_array($request->getActionName(), $actionsACL)) { return false; }
        
        // Se passou pela ACL sem ser bloqueado então também libera
        return true;
    } 
}
