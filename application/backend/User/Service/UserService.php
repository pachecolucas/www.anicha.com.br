<?php

class User_Service_UserService extends Eliti_Service_Crud_Rest {

    /**
     * CONFIGURAÇÕES
     */
    const TABLE = "user";
    const TABLE_AS = "u";
    const CLASSE = "User_Entity_User";

    public static function select() {
        return array(
            /**
             * USER
             */
            "u.id            AS u_id",
            "u.nome          AS u_nome",
            "u.email         AS u_email",
            "u.img           AS u_img",
            "u.tipo          AS u_tipo",
            "u.telefones     AS u_telefones",
            "u.codigo        AS u_codigo",
            "u.codigo_data   AS u_codigo_data",
            "u.locale        AS u_locale",
            "u.blocked       AS u_blocked",
        );
    }

    protected function getSearchColumns() {
        return "u.id, u.nome";
    }

    public static function join() {
        return "
            ";
    }

    public static function selectExtra() { // para tabelas relacionadas
        return array(
        );
    }

    public static function joinExtra() {
        return "
            ";
    }

    public static function order() {
        return "u.id";
    }

    public static function lineToObject($linha, &$objetos) {
        if (!array_key_exists($linha[self::TABLE_AS . "_id"], $objetos)) {
            $className = self::CLASSE;
            $objetos[$linha[self::TABLE_AS . "_id"]] = new $className($linha);
        }
    }

    /**
     * VALIDAÇÃO E PERSISTÊNCIA
     */
    public function save($r) {
        throw new Exception("Criação de usuário ainda manual");
    }

    /**
     * NÃO ALTERAR
     */
    public function getConfig() {
        return $CONFIG = array("TABLE" => self::TABLE, "TABLE_AS" => self::TABLE_AS, "CLASSE" => self::CLASSE);
    }

    public function getSelect() {
        return self::select();
    }

    public function getSelectExtra() {
        return self::selectExtra();
    }

    public function getJoin() {
        return self::join();
    }

    public function getJoinExtra() {
        return self::joinExtra();
    }

    public function getOrder() {
        return self::order();
    }

    public function getClassName() {
        return get_class($this);
    }

    /**
     * MÉTODO ESPECIAIS
     */
    public function getByEmail($email) {
        $this->db->conectar();

        // validando email
        if ($email == "") {
            throw new Exception("Informe seu e-mail");
        } else {
            $valid = new Zend_Validate_EmailAddress();
            if (!$valid->isValid($email)) {
                throw new Exception("Este não parece ser um e-mail válido");
            }
        }

        $result = $this->db->executar("SELECT id FROM user WHERE email = '$email'");
        if (sizeof($result) < 1) {
            throw new Exception("Este e-mail não está cadastrado no " . SITENAME . ".");
        }
        $userId = (int) $result[0]["id"];

        return $this->get($userId);
    }
    
    public function getByIdCode($userId, $codigo) {

        $this->db->conectar();

        $userId = (int) $userId;
        $codigo = $this->db->escape($codigo);

        // verificando se há este id e código no banco
        $result = $this->db->executar("SELECT id FROM user WHERE id = $userId AND codigo = '$codigo'");
        if (sizeof($result) < 1) {
            throw new Exception("Código inválido. Por favor, tente novamente.");
        }

        return $this->get($userId);
    }

}
