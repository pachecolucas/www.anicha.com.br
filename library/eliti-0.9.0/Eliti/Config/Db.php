<?php

class Eliti_Config_Db extends Eliti_Config_Db_Abstract {
    
    public function __construct($host, $base, $user, $pass, $port, $type) {
        $this->host = $host;
        $this->base = $base;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
        $this->type = $type;
    }
    
}
