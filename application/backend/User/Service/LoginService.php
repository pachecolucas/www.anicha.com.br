<?php

class User_Service_LoginService extends Eliti_Service {

    public function login($email, $senha) {

        $this->db->conectar();

        // Início validação
        $exception = new Eliti_Exception();

        // verifica email
        $this->validaEmail($email, $exception);
        
        // Se o email passou, então verifica senha
        if (!$exception->hasErrors()) {
            // quando correto, retorna id do usuário
            $id = (int)$this->validaPassword($senha, $email, $exception);
        }
        
        $exception->throwExceptionIfErrorExists();
        
        // se autenticou coloca usuário na sessão
        $this->setUserById($id);
    }
    
    private function setUserById($id) {
        $ee = new Eliti_Exception();
        $user = Eliti::getInstance()->getModel("User")->getService("User")->get($id);
        
        // verifica se não está bloqueado
        $user->blocked ? $ee->addError("bloqueio", "Sua conta no CASHIMBO foi desativada. Entre em contato com os responsáveis para reestabelecer seu acesso.") : null;
        $ee->throwExceptionIfErrorExists();
        
        Eliti::getInstance()->setUser($user);
    }
    
    public function reloadUser() {
        $oldUser = Eliti::getInstance()->getUser();
        $user = Eliti::getInstance()->getModel("User")->getService("Get")->get($oldUser->id);
        Eliti::getInstance()->setUser($user);
    }

    private function validaEmail($email, Eliti_Exception $e) {
        if ($email == "") {
            $e->addError("email", "Informe seu e-mail cadastrado no " . SITENAME);
            return false;
        } else {
            $valid = new Zend_Validate_EmailAddress();
            if (!$valid->isValid($email)) {
                $e->addError("email", "Este não parece ser um e-mail válido");
                return false;
            }
        }
        
        // Verifica se existe conta com este endereço de email
        $resultEmail = $this->db->executar("SELECT email FROM user WHERE email = '$email'");
        if (!array_key_exists(0, $resultEmail)) {
            $e->addError("email", "Não encontramos nenhuma conta associada a este email");
            return false;
        }
        return true;

    }

    private function validaPassword($senha, $email, Eliti_Exception $e) {
        if ($senha == "") {
            $e->addError("xyz", "Informe sua senha no " . SITENAME);
            return false;
        }

        // Verifica se a senha está correta
        $senha = sha1($senha);
        $result = $this->db->executar("SELECT id FROM user WHERE email = '$email' AND senha = '$senha'");
        if (!array_key_exists(0, $result)) {
            $e->addError("xyz", "SENHA INCORRETA!");
            return false;
        } else {
            return $result[0]["id"];
        }
    }

    public function logout() {
        Eliti::getInstance()->unsetUser();
    }

    public function getUser() {
        $user = Eliti::getInstance()->getUser();

        if ($user instanceof Eliti_User)
            return $user;

        throw new Exception("Usuário não está logado!");
    }

}