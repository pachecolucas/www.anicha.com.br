<?php

class Poa_Entity_Cliente {

    public $id;
    public $nome;
    public $cgc;
    public $cgcTipo;
    public $telefone1;
    public $telefone2;
    public $email;
    public $cep;
    public $rua;
    public $numeroComplemento;
    public $bairro;
    public $cidade;
    public $novaOs = false; // exclusivo para a view

    public function __construct($r) {
        $this->id = (int) $r["cliente_id"];
        $this->nome = $r["cliente_nome"];
        $this->cgc = $r["cliente_cgc"];
        $this->cgcTipo = array_key_exists("cgc_tipo_id", $r) ? new Poa_Entity_CgcTipo($r) : null;
        $this->telefone1 = $r["cliente_telefone1"];
        $this->telefone2 = $r["cliente_telefone2"];
        $this->email = $r["cliente_email"];
        $this->cep = $r["cliente_cep"];
        $this->rua = $r["cliente_rua"];
        $this->numeroComplemento = $r["cliente_numeroComplemento"];
        $this->bairro = $r['cliente_bairro'];
        $this->cidade = $r['cliente_cidade'];
    }

}
