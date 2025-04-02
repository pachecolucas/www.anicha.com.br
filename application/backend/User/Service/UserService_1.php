<?php

class User_Service_UserService extends Eliti_Service {
    
    public static $TS = array(
        LocaleController::es => array(
                "Informe seu nome" => "Introduzca su nombre",
                "Informe, pelo menos, um telefone" => "Introduzca ao menos un teléfono",
            ),
        LocaleController::en => array(
                "Informe seu nome" => "Enter your name",
                "Informe, pelo menos, um telefone" => "Enter at least one phone number",
            ),
    );

    public function save($id, $nome, $telefones) {
        $user = Eliti::getInstance()->getUser();
        if ($user->id != $id) {
            throw new Exception("Como assim você está tentando alterar uma outra conta, {$user->nome}!?");
        }
        $ee = new Eliti_Exception();
        
        if (empty($nome))       { $ee->addError("nome", $this->locale(self::$TS, "Informe seu nome")); }
        if (empty($telefones))  { $ee->addError("telefones", $this->locale(self::$TS, "Informe, pelo menos, um telefone")); }
        
        if ($ee->hasErrors()) {
            throw $ee;
        }
        
        $this->db->conectar();
        
        $query = "
                UPDATE user
                SET
                    nome = '".mysql_real_escape_string($nome)."',
                    telefones = '".mysql_real_escape_string($telefones)."'
                WHERE
                    id = $id
                ";
        $this->db->executar($query);
        
        // pede para atualizar o usuário que está na sessão
        Eliti::getInstance()->getModel("User")->getService("Login")->reloadUser();
        
        return $this->db->getLastId();
    }
    
    public function changeLocale($locale) {
        
        $this->db->conectar();
        
        $locale = mysql_real_escape_string($locale);
        
        if (!LocaleController::isValidLocale($locale)) {
            throw new Exception("User_Service_UserService->changeLanguage(): Locale - $locale - inválido!");
        }
        
        $userId = Eliti::getInstance()->getUser()->getId();
        
        $query = "UPDATE user SET locale = '".$locale."' WHERE id = $userId";
        
        $this->db->executar($query);
        
        // pede para atualizar o usuário que está na sessão
        Eliti::getInstance()->getModel("User")->getService("Login")->reloadUser();
        
        return true;
    }

}
