<?php

class Eliti_Exception extends Exception {
    
    /*
     * @var Eliti_Backend_Errors
     */    
    protected $errors = array();
    
    public function __construct() {
        parent::__construct("Exceção do Eliti Framework");
    }
    
    public function addError($key, $message) {
        $this->errors[$key] = new Eliti_Error($key, $message);
    }
    
    public function hasErrors() {
        return sizeof($this->errors);
    }
    
    public function getErrors() {
        return $this->errors;
    }

    public function toJson() {
        return json_encode($this->errors);
    }
    
    public function throwExceptionIfErrorExists() {
        if ($this->hasErrors()) {
            throw $this;
        }
    }
}
