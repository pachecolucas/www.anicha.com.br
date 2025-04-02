<?php

class Empresa_Entity_Pessoa {

    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $cpf;
    public $nascimento;
    public $foto;
    public $hasFoto;
    public $obs;

    public function __construct($r) {
        $this->id = (int) $r["pessoa_id"];
        $this->nome = $r["pessoa_nome"];
        $this->email = $r["pessoa_email"];
        $this->telefone = $r["pessoa_telefone"];
        $this->cpf = $r["pessoa_cpf"];
        $this->nascimento = $r["pessoa_nascimento"];
        $this->setFoto($r["pessoa_time"]);
        $this->obs = $r["pessoa_obs"];
    }

    public function setFoto($time) {
        $full_path = PUBLIC_PATH . "/uploads/pessoa/{$this->id}.jpg";
        if (!file_exists($full_path)) {
            $this->foto = "/uploads/pessoa/0.jpg";
            $this->hasFoto = false;
        } else {
            $this->foto = "/uploads/pessoa/{$this->id}.jpg?$time";
            $this->hasFoto = true;
        }
    }

}
