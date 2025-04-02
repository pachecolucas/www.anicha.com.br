<?php

class Poa_Entity_CgcTipo {

    const CPF = 1;
    const CNPJ = 2;

    public $id;
    public $nome;

    public function __construct($r) {
        $this->id = (int) $r["cgc_tipo_id"];
        $this->nome = $r["cgc_tipo_nome"];
    }

}
