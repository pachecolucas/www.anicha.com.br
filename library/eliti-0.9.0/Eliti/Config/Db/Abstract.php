<?php

abstract class Eliti_Config_Db_Abstract {
    
    public function getHost() {
        return $this->host;
    }
    
    public function getBase() {
        return $this->base;
    }
    
    public function getUser() {
        return $this->user;
    }
    
    public function getPass() {
        return $this->pass;
    }
    
    public function getPort() {
        return $this->port;
    }
    
    public function getType() {
        return $this->type;
    }
    
}
