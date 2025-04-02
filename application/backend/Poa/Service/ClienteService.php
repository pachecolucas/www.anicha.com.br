<?php

class Poa_Service_ClienteService extends Eliti_Service_Crud_Rest {

    /**
     * CONFIGURAÇÕES
     */
    const TABLE = "cliente";
    const TABLE_AS = "cliente";
    const CLASSE = "Poa_Entity_Cliente";

    public static function select() {
        return array(
            self::TABLE_AS . ".id                   AS " . self::TABLE_AS . "_id",
            self::TABLE_AS . ".nome                 AS " . self::TABLE_AS . "_nome",
            self::TABLE_AS . ".cgc                  AS " . self::TABLE_AS . "_cgc",
            self::TABLE_AS . ".telefone1            AS " . self::TABLE_AS . "_telefone1",
            self::TABLE_AS . ".telefone2            AS " . self::TABLE_AS . "_telefone2",
            self::TABLE_AS . ".email                AS " . self::TABLE_AS . "_email",
            self::TABLE_AS . ".cep                  AS " . self::TABLE_AS . "_cep",
            self::TABLE_AS . ".rua                  AS " . self::TABLE_AS . "_rua",
            self::TABLE_AS . ".numeroComplemento    AS " . self::TABLE_AS . "_numeroComplemento",
            self::TABLE_AS . ".bairro               AS " . self::TABLE_AS . "_bairro",
            self::TABLE_AS . ".cidade               AS " . self::TABLE_AS . "_cidade",
            Poa_Service_CgcTipoService::select(),
        );
    }

    protected function getSearchColumns() {
        return self::TABLE_AS . ".nome," .
                self::TABLE_AS . ".cgc," .
                self::TABLE_AS . ".telefone1," .
                self::TABLE_AS . ".telefone2," .
                self::TABLE_AS . ".email," .
                self::TABLE_AS . ".id";
    }

    public static function join() {
        return "
            LEFT OUTER JOIN cgc_tipo ON cliente.cgc_tipo = cgc_tipo.id
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
        return self::TABLE_AS . ".nome," .
                self::TABLE_AS . ".id DESC";
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
        
        //Eliti::print_r($r);
        /**
         * VALIDAÇÃO
         */
        $ee = new Eliti_Exception();

        // id
        $id = $this->getParamInt(@$r["id"]);

        // nome
        $nome = $this->getParam(@$r["nome"]);
        !$nome ? $ee->addError("clienteNome", "Informe o nome do cliente") : null;

        // cgc_tipo
        $cgcTipo = $this->getParamInt(@$r["cgcTipo"]["id"]);
//        !$cgcTipo ? $ee->addError("clienteCgcTipo", "Escolha um tipo. CPF ou CNPJ?") : null;
        !$cgcTipo ? $cgcTipo = "NULL" : null;

        //cgc
        $cgc = $this->getParam(@$r["cgc"]);

        // telefone 1
        $telefone1 = $this->getParam(@$r["telefone1"]);
//        !$telefone1 ? $ee->addError("clienteTelefone", "Informe o telefone") : null;
        // telefone 2
        $telefone2 = $this->getParam(@$r["telefone2"]);
//        !$telefone2 ? $ee->addError("clienteTelefone", "Informe o telefone") : null;

        $email = $this->getParam(@$r["email"]);
        if ($email) {
            $validEmail = new Zend_Validate_EmailAddress();
            !$validEmail->isValid($email) ? $ee->addError("clienteEmail", "Email inválido") : null;
        } else {
            $ee->addError("clienteEmail", "Informe o email");
        }

        $cep = $this->getParam(@$r['cep']);

        $rua = $this->getParam(@$r['rua']);

        $numeroComplemento = $this->getParam(@$r['numeroComplemento']);

        $bairro = $this->getParam(@$r['bairro']);

        $cidade = $this->getParam(@$r['cidade']);

        $ee->throwExceptionIfErrorExists();

        /**
         * SALVAR
         */
        $this->db->conectar();

        if ($id > 0) {
            $query = "
			UPDATE " . self::TABLE . "
			SET
                            nome = '" . $this->db->escape($nome) . "',
                            cgc_tipo = " . $this->db->escape($cgcTipo) . ",
                            cgc = '" . $this->db->escape($cgc) . "',
                            telefone1 = '" . $this->db->escape($telefone1) . "',
                            telefone2 = '" . $this->db->escape($telefone2) . "',
                            email = '" . $this->db->escape($email) . "',
                            cep = '" . $this->db->escape($cep) . "',
                            rua = '" . $this->db->escape($rua) . "',
                            numeroComplemento = '" . $this->db->escape($numeroComplemento) . "',
                            bairro = '" . $this->db->escape($bairro) . "',
                            cidade = '" . $this->db->escape($cidade) . "'
			WHERE id = $id
                ";
        } else {
            $query = "
			INSERT INTO " . self::TABLE . " (nome, cgc_tipo, cgc, telefone1, telefone2, email, cep, rua, numeroComplemento, bairro, cidade)
			VALUES (
                            '" . $this->db->escape($nome) . "',
                            " . $this->db->escape($cgcTipo) . ",
                            '" . $this->db->escape($cgc) . "',
                            '" . $this->db->escape($telefone1) . "',
                            '" . $this->db->escape($telefone2) . "',
                            '" . $this->db->escape($email) . "',
                            '" . $this->db->escape($cep) . "',
                            '" . $this->db->escape($rua) . "',
                            '" . $this->db->escape($numeroComplemento) . "',
                            '" . $this->db->escape($bairro) . "',
                            '" . $this->db->escape($cidade) . "'    
                        )
                ";
        }

        $this->db->executar($query);

        $id = ($this->db->getLastId() > 0) ? $this->db->getLastId() : $id;

        return $id;
    }

    public function listar() {
        $this->db->conectar();
        $result = $this->db->executar("SELECT id, nome FROM cliente", false);

        $clientes = array();
        while ($linha = $result->fetch_array()) {
            $clientes[] = array(
                "id" => (int) $linha["id"],
                "nome" => $linha["nome"],
            );
        }
        return $clientes;
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

}
