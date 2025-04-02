<?php

class Eliti_Response_Success_Objects extends Eliti_Response_Success {
    
    public $objects;

    public function __construct($objects) {
        parent::__construct();
        $this->objects = $objects;
    }
    
}
