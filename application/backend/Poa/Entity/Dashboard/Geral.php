<?php

class Ambiente_Entity_Dashboard_Geral {

    public $numClientes = 0;
    public $numOs = 0;
    public $numOsAberta = 0;
    
    public function __construct($r) {
        $this->numClientes = (int) $r["clientes"];
        $this->numOs = (int) $r["os"];
        $this->numOsAberta = (int) $r["os_aberta"];
    }

}
