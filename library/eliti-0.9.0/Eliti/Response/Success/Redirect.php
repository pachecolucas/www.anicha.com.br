<?php

class Eliti_Response_Success_Redirect extends Eliti_Response_Success {
    
    public $link;

    public function __construct($link) {
        parent::__construct();
        $this->link = $link;
    }
    
}
