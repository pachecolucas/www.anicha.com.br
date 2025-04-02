<?php

class Cotacao_Entity_Cotacao_Fisica extends Cotacao_Entity_Cotacao {

    public $cpf;
    public $nascimento;
    public $idade;
    public $civil;
    public $cep;

    protected function __construct($r, $produto) {
        parent::__construct($r, $produto);
        // cpf
        $this->cpf = trim(@$r["cpf"]);
        !$this->cpf ? $this->ee->addError("cotacaoCpf", "Qual o CPF do segurado?") : null;
        // nascimento
        $dia = (int) @$r["nascDia"];
        $mes = (int) @$r["nascMes"];
        $ano = (int) @$r["nascAno"];
        !$dia ? $this->ee->addError("cotacaoNascDia", "") : null;
        !$mes ? $this->ee->addError("cotacaoNascMes", "") : null;
        !$ano ? $this->ee->addError("cotacaoNascAno", "") : null;
        if (!$dia || !$mes || !$ano) {
            $this->ee->addError("cotacaoNascimento", "Qual a data de nascimento do segurado?");
        }
        $this->nascimento = $dia . "/" . $mes . "/" . $ano;
        // estado civil
        $this->civil = trim(@$r["civil"]);
        !$this->civil ? $this->ee->addError("cotacaoCivil", "Campo obrigatório.") : null;
        // cep
        $this->cep = trim(@$r["cep"]);
        !$this->cep ? $this->ee->addError("cotacaoCep", "Qual o CEP do segurado?") : null;
    }

    public function getTipo() {
        return "Pessoa Física";
    }

    public function __toString() {
        return parent::__toString() . "
NASCIMENTO: {$this->nascimento} ({$this->idade} anos)
ESTADO CIVIL: {$this->civil}
CPF: {$this->cpf}

{$this->veiculo}
";
    }

}
