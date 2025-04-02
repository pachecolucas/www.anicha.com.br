<?php

class Eliti_Response_Success_Object extends Eliti_Response_Success {
    
    public $object;

    public function __construct($object) {
        parent::__construct();
        $this->object = $object;
    }
    
}
