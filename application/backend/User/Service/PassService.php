<?php

class User_Service_PassService extends Eliti_Service {

    private function generateCode() {
        return sha1(time() * rand(2, 100));
    }

    public function sendRecoveryEmail($login) {
        // validando email
        try {
            $srvUser = $this->getService("User");
            $user = $srvUser->getByEmail($login);
            
            $this->db->conectar();

            // verifica se usuário já possui um código para novo e-mail, caso contrário, define um.
            if (!$user->codigo) {
                $codigo = $this->generateCode();
                $this->db->executar("UPDATE user SET codigo = '$codigo', codigo_data = now() WHERE id = " . $user->id);
                // carrega usuário novamente para puxar novos dados
                $user = $srvUser->get($user->id);
            }

            // envia email com link para criar nova senha
            new User_Entity_Email_Password($user);
        } catch (Exception $e) {
            $ee = new Eliti_Exception();
            $ee->addError("email", $e->getMessage());
            throw $ee;
        }
    }

    public function defineNewPass($userId, $codigo, $pass1, $pass2) {
        
        $this->db->conectar();
        
        $srvUser = $this->getService("User");
        $user = $srvUser->getByIdCode($userId, $codigo);

        $ee = new Eliti_Exception();

        /**
         * VALIDA SENHA
         */
        // deve ter sido informada
        !$pass1 ? $ee->addError("pass1", "Escolha uma nova senha") : null;
        $ee->throwExceptionIfErrorExists();

        // Não pode conter apenas letras ou números
//        !preg_match('/[A-Z]+[a-z]+[0-9]+/', $pass1) ? $ee->addError("pass1", "Senha deve conter letras e números") : null;
//        $ee->throwExceptionIfErrorExists();
        
        // deve ter um tamanho mínimo
        strlen($pass1) < 8?$ee->addError("pass1", "A senha deve ter um mínimo de 8 caracteres") : null;
        $ee->throwExceptionIfErrorExists();

        // deve ter sido repetida
        !$pass2 ? $ee->addError("pass2", "Repita sua nova senha") : null;
        $ee->throwExceptionIfErrorExists();

        // devem ser iguais
        if ($pass1 !== $pass2) {
            $ee->addError("pass1", "Senhas não conferem");
            $ee->addError("pass2", "");
        }
        
        $ee->throwExceptionIfErrorExists();

        // Grava nova senha
        $senha = sha1($pass1);
        $this->db->executar("UPDATE user SET senha = '$senha', codigo = NULL, codigo_data = NULL WHERE id = " . $user->id);

        // loga usuário
        Eliti::getInstance()->setUser($srvUser->get($user->id));
    }

    public function changePass($senhaAtual, $senhaNova, $senhaNovaRepetida) {

        $ee = new Eliti_Exception();
        if (empty($senhaAtual)) {
            $ee->addError("x", "Informe sua senha atual");
            throw $ee;
        }
        if (!$this->checkPass($senhaAtual)) {
            $ee->addError("x", "Senha atual não confere");
            throw $ee;
        }
        if (empty($senhaNova)) {
            $ee->addError("y", "Informe sua nova senha");
            throw $ee;
        }
        if (empty($senhaNovaRepetida)) {
            $ee->addError("z", "Repita sua nova senha");
            throw $ee;
        }
        if ($senhaNova != $senhaNovaRepetida) {
            $ee->addError("z", "Nova senha não confere");
            throw $ee;
        }
        if ($ee->hasErrors()) {
            throw $ee;
        }

        $user = Eliti::getInstance()->getUser();
        $sha1SenhaNova = sha1($senhaNova);
        $query = "UPDATE user SET senha = '$sha1SenhaNova' WHERE id = " . $user->id;
        $this->db->executar($query);
    }

    public function checkPass($senhaAtual) {
        $this->db->conectar();

        if (!Eliti::getInstance()->hasUser()) {
            throw new Exception("User_Service_PassService::checkPass() - Usuário deveria estar logado.");
        }
        $user = Eliti::getInstance()->getUser();
        $sha1SenhaAtual = sha1($senhaAtual);
        $query = "
                    SELECT id
                    FROM user
                    WHERE
                        id = " . $user->id . " AND
                        email = '" . $user->email . "' AND
                        senha = '$sha1SenhaAtual'
                ";

        $result = $this->db->executar($query);

        return array_key_exists(0, $result);
    }

}
