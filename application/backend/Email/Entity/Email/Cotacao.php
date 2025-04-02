<?php

class Email_Entity_Email_Cotacao extends Email_Entity_Email {

    public function __construct($dados, $produto) {

        /**
         * Validação
         */
        $ee = new Eliti_Exception();

        $cotacao = Cotacao_Entity_Cotacao::create($dados, $produto);

        $cotacao->ee->throwExceptionIfErrorExists();

        $body = "

		Olá, Equipe Madri Seguros!
		{$cotacao->nome} solicitou uma Cotação Rápida no seu site.

		$cotacao

		";

        $subject = 'MADRI - Cotação Rápida de ' . strtoupper($cotacao->nome);

        parent::__construct($cotacao->nome, "contato@madricorretora.com.br", $body, $subject);
    }

}
