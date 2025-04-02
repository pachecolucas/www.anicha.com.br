<?php

class Cotacao_Entity_Cotacao_Juridica extends Cotacao_Entity_Cotacao {

    public $razao;
    public $cnpj;

    protected function __construct($r, $produto) {
        parent::__construct($r, $produto);
        // razao
        $this->razao = trim(@$r["razao"]);
        !$this->razao ? $this->ee->addError("cotacaoRazao", "Qual a sua empresa?") : null;
        // cnpj
        $this->cnpj = trim(@$r["cnpj"]);
        !$this->cnpj ? $this->ee->addError("cotacaoCnpj", "Qual o CNPJ?") : null;
    }

    public function getTipo() {
        return "Pessoa Jurídica";
    }

    public function __toString() {
        return parent::__toString() . "
EMPRESA: {$this->razao}
CNPJ: {$this->cnpj}

{$this->veiculo}
";
    }

}
