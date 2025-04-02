<?php

class Poa_Entity_Produto {

    public $id;
    public $nome;
    public $desc;
    public $ordem;

    public function __construct($r) {
        $this->id = (int) $r["produto_id"];
        $this->nome = $r["produto_nome"];
        $this->desc = $r["produto_desc"];
        $this->ordem = (int) $r["produto_ordem"];
    }

//    public function addFoto(Poa_Entity_Produto_Foto $o) {
//        $this->fotos[] = $o;
//    }
//
//    public function hasFoto($idObject) {
//        foreach ($this->fotos as $o) {
//            if ($o->id === $idObject) {
//                return true;
//            }
//        }
//        return false;
//    }

}
