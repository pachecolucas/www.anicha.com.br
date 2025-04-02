<?php

class Eliti_Controller extends Zend_Controller_Action implements Eliti_Request_Interface {
    /**
     *
     * @var Eliti_Request_Interface 
     */
    protected $request;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
        parent::__construct($request, $response, $invokeArgs);        
        // desabilita layout se for uma solicitação ajax
        $this->request = new Eliti_Request($this, $this->_helper->layout());
//	$this->getResponse()->appendBody('<script type="text/javascript">$(function() {init()})</script>');
    }

    public function isAjaxRequest() {
        return $this->request->isAjaxRequest();
    }

    public function getParam($key) {
        return $this->request->getParam($key);
    }

    public function getParamFloat($key, $convert = true) {
        return $this->request->getParamFloat($key, $convert = true);
    }

    public function getParamInt($key) {
        return $this->request->getParamInt($key);
    }

    public function getParamDate($key) {
        return $this->request->getParamDate($key);
    }
    
    public function getParamBool($key) {
        return $this->request->getParamBool($key);
    }
    
    public function getParamArray($key) {
        return $this->request->getParamArray($key);
    }
    
    public function getParamArrayInt($key) {
        return $this->request->getParamArrayInt($key);
    }
    
    public function getParamKey($key) {
        return $this->request->getParamKey($key);
    }

    public function getParams() {
        return $this->request->getParams();
    }

    /**
     * Retorna uma Fachada de Modelo
     *
     * @param  string $name
     * @return Eliti_Model_Facade
     */
    public function getModel($name) {
        return $this->request->getModel($name);
    }

//    public function ajaxHttpError($mensage, $status = null) {
//        $this->request->ajaxHttpError($mensage, $status = null);
//    }
//
//    public function ajaxHttpSuccess($mensage) {
//        $this->request->ajaxHttpSuccess($mensage);
//    }
//    
//    public function prepareJsonResult($values) {
//        return $this->request->prepareJsonResult($values);
//    }

    public function ip() {
        return $this->request->ip();
    }

    /**
     * Implementa regras de acesso
     * @return void
     */
    public function allow(array $roles) {
        return $this->request->allow($roles);
    }
    
    public function showImage(array $img) {
        $this->request->showImage($img);
    }

}
