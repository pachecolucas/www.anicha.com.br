<?php

abstract class Cotacao_Entity_Cotacao {

    const FISICA = 1;
    const JURIDICA = 2;

    public static $PRODUTOS_VEICULOS = array(
        74
    );
    public $produto;
    public $tipo; // tipo de seguro
    public $nome; // segurado (física) ou resposável (jurídica)
    public $telefone;
    public $veiculo;
    public $principalCondutor; // só para o caso de veículo

    /**
     *
     * @var Eliti_Exception
     */
    public $ee;

    public static function create($r, $produto) {
        switch ($produto->tipo->id) {
            case 1:
                return new Cotacao_Entity_Cotacao_Fisica($r, $produto);
            case 2:
                return new Cotacao_Entity_Cotacao_Juridica($r, $produto);
            default:
                throw new Exception("Tipo de pessoa inválido!");
        }
    }

    protected function __construct($r, $produto) {
        $this->ee = new Eliti_Exception();
        // produto
        $this->produto = $produto;
        // nome
        $this->nome = trim(@$r["nome"]);
        !$this->nome ? $this->ee->addError("cotacaoNome", "Qual o nome do segurado?") : null;
        // telefone
        $this->telefone = trim(@$r["telefone"]);
        !$this->telefone ? $this->ee->addError("cotacaoTelefone", "Informe um telefone.") : null;
        // tipo
        $this->tipo = $this->getTipo();
        // veículo
        if (in_array($this->produto->id, self::$PRODUTOS_VEICULOS)) {
            $seguradoEhPrincipalCondutor = (int) $r["condutor"]["id"] === 2 ? false : true;
            $this->veiculo = !$this->principalCondutor ? new Cotacao_Entity_Veiculo($r, $seguradoEhPrincipalCondutor, $this->ee) : null;
        }
    }

    abstract function getTipo();

    public function __toString() {
        return "
PRODUTO: #{$this->produto->id} {$this->produto->nome}
    
TIPO: {$this->tipo}

NOME: {$this->nome}
TELEFONE: {$this->telefone}
";
    }

}
