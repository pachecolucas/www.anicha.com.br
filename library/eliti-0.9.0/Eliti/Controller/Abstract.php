<?php

abstract class Eliti_Controller_Abstract extends Zend_Controller_Action {
    
    protected function isAjaxRequest() {
        /*
         * Verificação de strpos foi adicionada porque solitações ajax via $http do AngularJS não estavam sendo identificadas como AJAX.
         */
        return $this->getRequest()->isXmlHttpRequest() || strpos($_SERVER['HTTP_ACCEPT'], "application/json") !== false;
    }

    /*
     * Função que retorna parâmetros
     */

    protected function getParam($key) {
        return trim($this->getRequest()->getParam($key));
    }

    protected function getParamFloat($key, $convert = true) {
        if ($convert) {
            return (float) str_replace(",", ".", str_replace(".", "", $this->getParam($key)));
        } else {
            return (float) str_replace(",", "", $this->getParam($key));
        }
    }

    protected function getParamInt($key) {
        return (int) str_replace(".", "", $this->getParam($key));
    }

    protected function getParamDate($key) {
        return Eliti_Date::create($this->getParam($key));
    }
    
    protected function getParamBool($key) {
        if ($this->getParam($key) === "true" || $this->getParam($key) == "1") {
            return true;
        }
        return false;
    }

    protected function getParams() {
        $params = $this->getRequest()->getParams();
        foreach ($params as $key => $value) {
            $params[$key] = $this->getParam($value);
        }
        return $params;
    }

    /**
     * Retorna uma Fachada de Modelo
     *
     * @param  string $name
     * @return Eliti_Model_Facade
     */
    protected function getModel($name) {
        return Eliti::getInstance()->getModel($name);
    }

    protected function getAppSession() {
        return new Zend_Session_Namespace('Eliti_Application_Session');
    }

    protected function getControllerSession() {
        return new Zend_Session_Namespace('Eliti_Application_Session' . get_class($this));
    }

    protected function ajaxHttpError($mensage, $status = null) {
        $status = ($status > 0) ? "$status" : "500";
        header("HTTP/1.0 $status");
        echo $mensage;
        exit();
    }

    protected function ajaxHttpSuccess($mensage) {
        echo $mensage;
        exit();
    }

    protected function ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Implementa regras de acesso
     * @return void
     */
    public function allow(array $roles) {
        if (!Eliti::getInstance()->hasUser()) {
            throw new Exception("Usuário não está logado.");
        }

        foreach ($roles as $role) {
            if ($role == Eliti::getInstance()->getUser()->tipo) {
                return true;
            }
        }
        
        $user = Eliti::getInstance()->getUser();
        $erro = "Olá, <strong>".$user->getName()."</strong>. Esta operação que você tentou realizar não está disponível para <strong>".$user->tipo()."</strong>.";
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->ajaxHttpError($erro);
        }
        
        $this->_redirect("/" . MODULE_ADMIN . "/error/access");
    }

}