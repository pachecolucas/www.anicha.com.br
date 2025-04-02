<?php

class Eliti_Response_Success_Html extends Eliti_Response_Success {
    
    /**
     * Normalmente o id com a # indicando o componente html que deverá
     * desaparecer para dar lugar ao novo conteudo enviado no atributo html.
     */
    public $target;
    
    /**
     *
     * Conteúdo HTML que será injetado na página
     */
    public $html;

    public function __construct($target, $html) {
        parent::__construct();
        $this->target = $target;
        $this->html = $html;
    }
    
}
