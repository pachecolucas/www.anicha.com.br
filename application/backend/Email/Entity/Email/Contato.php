<?php

class Email_Entity_Email_Contato extends Email_Entity_Email {

    public function __construct($contato) {

        /**
         * Validação
         */
        $ee = new Eliti_Exception();

        // nome
        $nome = trim(@$contato["nome"]);
        !$nome ? $ee->addError("contatoNome", "Informe seu nome") : null;

        // email
        $email = trim(@$contato["email"]);
        if (!$email) {
            $ee->addError("contatoEmail", "Informe seu e-mail");
        } else {
            $validEmail = new Zend_Validate_EmailAddress();
            $validEmail->isValid($email) ? null : $ee->addError("contatoEmail", "Por favor, verifique seu e-mail");
        }

        // telefone
        $telefone = trim(@$contato["telefone"]);
        !$telefone ? $ee->addError("contatoTelefone", "Informe seu telefone") : null;

        // mensagem
        $mensagem = trim(@$contato["mensagem"]);
        !$mensagem ? $ee->addError("contatoMensagem", "Escreva uma mensagem") : null;

        $ee->throwExceptionIfErrorExists();

        $body = "

		Olá, Equipe Anicha!
		$nome deixou uma mensagem no seu site.

		Nome: $nome
		E-mail: $email
		Telefone: $telefone
		Mensagem:
		$mensagem

		";
        $subject = 'ANICHA - Mensagem de ' . strtoupper($nome);

        parent::__construct($nome, $email, $body, $subject);
    }

}
