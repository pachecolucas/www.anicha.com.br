<?php

class Cotacao_Entity_Veiculo {

    public $seguradoEhPrincipalCondutor;
    // veiculo
    public $modelo;
    public $ano;
    public $placa;
    // condutor principal (diferente do segurado)
    public $nome;
    public $cpf;
    public $civil;
    public $nascimento; // tipo de seguro
    public $idade; // tipo de seguro

    public function __construct($r, $seguradoEhPrincipalCondutor, Eliti_Exception &$ee) {
        $this->ee = new Eliti_Exception();
        $this->seguradoEhPrincipalCondutor = $seguradoEhPrincipalCondutor;

        // modelo
        $this->modelo = trim(@$r["veiculoModelo"]);
        !$this->modelo ? $ee->addError("cotacaoVeiculoModelo", "Qual o veículo?") : null;

        // ano
        $this->ano = trim(@$r["veiculoAno"]);
        !$this->ano ? $ee->addError("cotacaoVeiculoAno", "Qual ano/modelo?") : null;

        // placa
        $this->placa = trim(@$r["veiculoPlaca"]);
        !$this->placa ? $ee->addError("cotacaoVeiculoPlaca", "Qual a placa?") : null;

        if (!$seguradoEhPrincipalCondutor) {
            // nome
            $this->nome = trim(@$r["veiculoNome"]);
            !$this->nome ? $ee->addError("cotacaoVeiculoNome", "Qual o nome do principal condutor?") : null;
            // telefone
            $this->cpf = trim(@$r["veiculoCpf"]);
            !$this->cpf ? $ee->addError("cotacaoVeiculoCpf", "Qual o CPF do principal condutor?") : null;
            // estado civil
            $this->civil = trim(@$r["veiculoCivil"]);
            !$this->civil ? $ee->addError("cotacaoVeiculoCivil", "Campo obrigatório.") : null;
            // nascimento
            $dia = (int) @$r["veiculoNascDia"];
            $mes = (int) @$r["veiculoNascMes"];
            $ano = (int) @$r["veiculoNascAno"];
            !$dia ? $ee->addError("cotacaoVeiculoNascDia", "") : null;
            !$mes ? $ee->addError("cotacaoVeiculoNascMes", "") : null;
            !$ano ? $ee->addError("cotacaoVeiculoNascAno", "") : null;
            if (!$dia || !$mes || !$ano) {
                $ee->addError("cotacaoVeiculoNascimento", "Qual a data de nascimento do principal condutor?");
            }
            $this->nascimento = $dia . "/" . $mes . "/" . $ano;
        }
    }

    public function __toString() {
        $str = "VEICULO: #{$this->modelo}
ANO: {$this->ano}
PLACA: {$this->placa}
";

        if (!$this->seguradoEhPrincipalCondutor) {
            $str .= "
                
CONDUTOR PRINCIPAL:
  NOME: {$this->nome}
  NASCIMENTO: {$this->nascimento} ( anos)
  ESTADO CIVIL: {$this->civil}
  CPF: {$this->cpf}";
        }

        return $str;
    }

}
