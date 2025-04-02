<?php

class Poa_Entity_Produto_Foto {

    public $id;
    public $mini;
    public $foto;
    
    const PATH = "/poa/produto/";

    public function __construct($r) {
        $this->id = (int) $r["produto_foto_id"];
        $this->mini = $r["produto_foto_mini"];
        $this->foto = $r["produto_foto_foto"];
    }

}
