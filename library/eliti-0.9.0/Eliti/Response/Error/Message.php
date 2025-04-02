<?php

class Eliti_Response_Error_Message extends Eliti_Response_Error {
    
    public $message;

    public function __construct($message) {
        parent::__construct();
        $this->message = $message;
    }
    
}
