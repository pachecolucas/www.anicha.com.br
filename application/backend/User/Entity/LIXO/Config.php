<?php

class User_Entity_Config {

    public $host;
    public $base;
    public $port;
    public $user;
    public $pass;
    
    public function __construct($r) {
        $this->host = $r["config_host"];
        $this->base = $r["config_base"];
        $this->port = $r["config_port"];
        $this->user = $r["config_user"];
        $this->pass = $r["config_pass"];
        $this->type = Eliti_Db::PgSQL;
    }
    
}
