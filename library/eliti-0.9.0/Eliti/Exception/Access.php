<?php

class Eliti_Exception_Access extends Exception {
    
    const ERRO_NAO_MAPEADA = 1;
    const ERRO_BLOQUEIO = 2;
    
    public static $ERROS = array(
        self::ERRO_NAO_MAPEADA => "Não Mapeada",
        self::ERRO_BLOQUEIO => "Bloqueio",
    );

    public $method;
    public $module;
    public $controller;
    public $action;
    
    public $tipo;
    public $tipoId;
    
    public function __construct($method, $module, $controller, $action, $tipo) {
        parent::__construct("Exceção do Eliti Framework");
        $this->method       = $method;
        $this->module       = $module;
        $this->controller   = $controller;
        $this->action       = $action;
        
        if (!array_key_exists($tipo, self::$ERROS)) {
            throw new Exception("Eliti_Exception_Access(): Tipo inválido ($tipo).");
        }
        
        $this->tipo = self::$ERROS[$tipo];
        $this->tipoId = $tipo;
    }
}
