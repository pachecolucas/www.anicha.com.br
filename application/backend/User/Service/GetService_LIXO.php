<?php

class User_Service_GetService extends Eliti_Service {

    public function get($id) {
        $id = (int) $id;
        $this->db->conectar();

        $results = $this->db->executar("
                    SELECT
                        user.id                 AS u_id, 
                        user.nome               AS u_nome,
                        user.email              AS u_email, 
                        user.telefones          AS u_telefones, 
                        user.tipo               AS u_tipo,
                        user.codigo             AS u_codigo,
                        user.codigo_data        AS u_codigo_data,
                        user.locale             AS u_locale
                    FROM user
                    WHERE user.id = $id
                ");

        if (sizeof($results) < 1) {
            throw new Exception("Nenhum usuário encontrado com este id - $id.");
        }

        return new User_Entity_User($results[0]);
    }

//    public function getByEmail($email) {
//        $this->db->conectar();
//
//        // validando email
//        if ($email == "") {
//            throw new Exception("Informe seu e-mail");
//        } else {
//            $valid = new Zend_Validate_EmailAddress();
//            if (!$valid->isValid($email)) {
//                throw new Exception("Este não parece ser um e-mail válido");
//            }
//        }
//
//        // verificando se há este email no banco
//        $this->db->conectar();
//        $result = $this->db->executar("SELECT id FROM user WHERE email = '$email'");
//        if (sizeof($result) < 1)
//            throw new Exception("Este e-mail não está cadastrado no " . SITENAME . ".");
//        $userId = $result[0]["id"];
//
//        return $this->get($userId);
//    }

//    public function getByIdCode($userId, $codigo) {
//
//        $this->db->conectar();
//
//        $userId = (int) $userId;
//        $codigo = mysql_real_escape_string($codigo);
//
//        // verificando se há este id e código no banco
//        $this->db->conectar();
//        $result = $this->db->executar("SELECT id FROM user WHERE id = $userId AND codigo = '$codigo'");
//        if (sizeof($result) < 1)
//            throw new Exception("Código inválido. Por favor, tente novamente.");
//
//        return $this->get($userId);
//    }

}
