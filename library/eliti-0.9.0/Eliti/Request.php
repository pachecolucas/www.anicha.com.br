<?php

class Eliti_Request implements Eliti_Request_Interface {

    /**
     *
     * @var Zend_Controller_Action
     */
    private $controller;
    private static $paramKeys;

    public function __construct(Zend_Controller_Action $controller, Zend_Layout $layout) {
        // desabilita layout se for uma solicitação ajax

        $this->controller = $controller;

        $request = $this->controller->getRequest();

        $controller->view->P = $request->getModuleName();
        $controller->view->PP = $request->getControllerName();
        $controller->view->PPP = $request->getActionName();
        $controller->view->locale = Eliti::getInstance()->getLocale();
        if (Eliti::getInstance()->hasUser()) {
            $controller->view->user = Eliti::getInstance()->getUser();
        }

        if (isset($_GET["efStatus"])) {
            $controller->view->efStatus = true;
            $controller->view->efStatusTitle = $_GET["efStatusTitle"];
            $controller->view->efStatusClass = $_GET["efStatusClass"];
            $controller->view->efStatusMsg = $_GET["efStatusMsg"];
        }

        if ($this->isAjaxRequest()) {
            header("Content-Type: text/html; charset=utf-8", true);
            $layout->disableLayout();
        }

//	$this->getResponse()->appendBody('<script type="text/javascript">$(function() {init()})</script>');
    }

    public function isAjaxRequest() {
        return Eliti::isAjaxRequest($this->controller->getRequest());
        /*
         * Verificação de strpos foi adicionada porque solitações ajax via $http do AngularJS não estavam sendo identificadas como AJAX.
         */
//        return $this->controller->getRequest()->isXmlHttpRequest() || strpos($_SERVER['HTTP_ACCEPT'], "application/json") !== false;
    }

    /*
     * Função que retorna parâmetros
     */

    public function getParam($key) {
        $param = $this->controller->getRequest()->getParam($key);
        return is_string($param) ? trim($param) : $param;
    }

    public function getParamFloat($key, $convert = true) {
        if ($convert) {
            return (float) str_replace(",", ".", str_replace(".", "", $this->getParam($key)));
        } else {
            return (float) str_replace(",", "", $this->getParam($key));
        }
    }

    public function getParamInt($key) {
        return (int) str_replace(".", "", $this->getParam($key));
    }

    public function getParamDate($key) {
        return Eliti_Date::create($this->getParam($key), Eliti_Date::SQL);
//        return Eliti_Date::create($this->getParam($key), Eliti_Date::BR_SHORT_YEAR);
    }

    public function getParamDateTime($key) {
        $param = str_replace("T", " ", $this->getParam($key));
        return Eliti_Date::create($param, Eliti_Date::SQL_DATE_TIME);
//        return Eliti_Date::create($this->getParam($key), Eliti_Date::BR_SHORT_YEAR);
    }

    public function getParamBool($key) {
        $param = $this->getParam($key);
        return $param == "1" || $param == "true";
    }

    public function getParamArray($key) {
        $params = $this->controller->getRequest()->getParam($key);
        if (!is_array($params)) {
            return array();
        } else {
            foreach ($params as $key => $value) {
                $params[$key] = trim($value);
            }
            return $params;
        }
    }

    public function getParamArrayInt($key) {
        $params = $this->controller->getRequest()->getParam($key);
        if (!is_array($params)) {
            return array();
        } else {
            foreach ($params as $key => $value) {
                $params[$key] = (int) trim($value);
            }
            return $params;
        }
    }

    public function getParamKey($key) {
        if (!self::$paramKeys) {
            self::$paramKeys = json_decode(stripslashes($this->getParam("keys")));
        }
        if (self::$paramKeys) {
            foreach (self::$paramKeys as $keyAndValue) {
                if ($keyAndValue->key === $key) {
                    return $keyAndValue->value;
                }
            }
        }
        return false;
    }

    public function getParams() {
        $params = $this->controller->getRequest()->getParams();
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
    public function getModel($name) {
        return Eliti::getInstance()->getModel($name);
    }

    public function ip() {
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
        $erro = "Olá, <strong>" . $user->getName() . "</strong>. Esta operação que você tentou realizar não está disponível para <strong>" . $user->tipo() . "</strong>.";
        if ($this->controller->getRequest()->isXmlHttpRequest()) {
            $this->ajaxHttpError($erro);
        }

        $this->_redirect("/" . MODULE_ADMIN . "/error/access");
    }

    public function showImage(array $img) {
        //EXIBE IMAGEM
        header("Content-type: " . "image/jpeg" . "");

        // RESOLVENDO O PROBLEMA DO CACHE (Forçando para que ele aconteça)
        // calc an offset of 24 hours
        $offset = 3600 * 24;
        // calc the string in GMT not localtime and add the offset
        $expire = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
        //output the HTTP header
        header($expire);
        header("Pragma: cache");
        header("Cache-Control: public");

        echo $img["img_blob"];
        die;
    }

}
