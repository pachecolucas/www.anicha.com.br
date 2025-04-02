<?php

class Eliti_Response_Success_Message extends Eliti_Response_Success {
    
    public $message;

    public function __construct($message) {
        parent::__construct();
        $this->message = $message;
    }
    
}
