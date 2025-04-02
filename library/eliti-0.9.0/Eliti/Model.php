<?php

class Eliti_Model {

    private $_moduleName;
    private $_session;

    public function __construct() {
        $array = explode("_", get_class($this));
        $this->moduleName = $array[0];
        if (!isset($this->_session)) {
            $this->_session = new Zend_Session_Namespace($this->moduleName);
        }
        $this->init();
    }

    protected function init() {
        
    }

    /**
     * Retorna um Eliti_Backend_Service
     *
     * @return Eliti_Backend_Service
     */
    public function getService($name) {
    	$exploded = explode("_", get_class($this));
        $modelName = $exploded[0];
        $serviceClass = "{$modelName}_Service_{$name}Service";
        return new $serviceClass;
    }

    /**
     * Retorna a Sessão de um Modelo (backend)
     *
     * @return Zend_Session_Namespace
     */
    public function getSession() {
        return $this->_session;
    }

}