<?php

class Ambiente_Entity_Os {

    public $id;
    public $numOs;
    public $numSerie;
    public $modelo;
    public $fabricante;
    public $hasW;
    public $hasL;
    public $hasM;
    public $sintomas;
    public $servicos;
    public $obs;
    public $fechada;
    public $cliente;
    
    public $created;
    public $updated;

    public function __construct($r) {
        $this->id = (int) $r["os_id"];
        $this->numOs = $r["os_numOs"];
        $this->numSerie = $r["os_numSerie"];
        $this->modelo = $r["os_modelo"];
        $this->fabricante = $r["os_fabricante"];
        $this->hasW = $r["os_hasW"];
        $this->hasL = $r["os_hasL"];
        $this->hasM = $r["os_hasM"];
        $this->sintomas = $r["os_sintomas"];
        $this->servicos = $r["os_servicos"];
        $this->obs = $r["os_obs"];
        $this->fechada = (int) $r["os_fechada"] ? true : false;
        $this->cliente = array(
            "id" => (int)$r["osCliente_id"],
            "nome" => $r['osCliente_nome'],
        );
        
        $this->created = str_replace(" ", "T", $r["os_created"]);
        $this->updated = str_replace(" ", "T", $r["os_updated"]);
    }

}
