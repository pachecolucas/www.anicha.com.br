<?php

interface Eliti_Request_Interface {

    public function isAjaxRequest();
    public function getParam($key);
    public function getParamFloat($key, $convert = true);
    public function getParamInt($key);
    public function getParamDate($key);
    public function getParamBool($key);
    public function getParamArray($key);
    public function getParamArrayInt($key);
    public function getParamKey($key);
    
    public function getParams();

    /**
     * Retorna uma Fachada de Modelo
     *
     * @param  string $name
     * @return Eliti_Model_Facade
     */
    public function getModel($name);
//    public function ajaxHttpError($mensage, $status = null);
//    public function ajaxHttpSuccess($mensage);
//    public function prepareJsonResult($values);
    public function ip();
    
    public function showImage(array $img);

    /**
     * Implementa regras de acesso
     * @return void
     */
    public function allow(array $roles);
}