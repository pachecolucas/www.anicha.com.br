<?php

abstract class Eliti_Response_Error extends Eliti_Response {
    
    public function __construct() {
        parent::__construct();
        $this->type = Eliti_Response::TYPE_ERROR;
    }

}
