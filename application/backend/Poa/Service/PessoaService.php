<?php

class Empresa_Service_PessoaService extends Eliti_Service_Crud_Rest {

    /**
     * CONFIGURAÇÕES
     */
    const TABLE = "pessoa";
    const TABLE_AS = "pessoa";
    const CLASSE = "Empresa_Entity_Pessoa";

    public static function select() {
        return array(
            self::TABLE_AS . ".id           AS " . self::TABLE_AS . "_id",
            self::TABLE_AS . ".nome         AS " . self::TABLE_AS . "_nome",
            self::TABLE_AS . ".email        AS " . self::TABLE_AS . "_email",
            self::TABLE_AS . ".telefone     AS " . self::TABLE_AS . "_telefone",
            self::TABLE_AS . ".cpf          AS " . self::TABLE_AS . "_cpf",
            self::TABLE_AS . ".nascimento   AS " . self::TABLE_AS . "_nascimento",
            self::TABLE_AS . ".time         AS " . self::TABLE_AS . "_time",
            self::TABLE_AS . ".obs          AS " . self::TABLE_AS . "_obs",
        );
    }

    protected function getSearchColumns() {
        return self::TABLE_AS . ".nome," .
                self::TABLE_AS . ".email," .
                self::TABLE_AS . ".telefone," .
                self::TABLE_AS . ".cpf," .
                self::TABLE_AS . ".nascimento," .
                self::TABLE_AS . ".obs," .
                self::TABLE_AS . ".id";
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
        return self::TABLE_AS . ".nome," .
                self::TABLE_AS . ".nascimento DESC";
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
        /**
         * VALIDAÇÃO
         */
        $ee = new Eliti_Exception();

        // id
        $id = $this->getParamInt(@$r["id"]);

        // nome
        $nome = $this->getParam(@$r["nome"]);
        !$nome ? $ee->addError("pessoaNome", "Qual o nome?") : null;

        // email
        $email = $this->getParam(@$r["email"]);
        if ($email) {
            $validEmail = new Zend_Validate_EmailAddress();
            !$validEmail->isValid($email) ? $ee->addError("pessoaEmail", "Email inválido") : null;
        } else {
            $ee->addError("pessoaEmail", "Informe o email");
        }

        $telefone = $this->getParam(@$r["telefone"]);
        !$telefone ? $ee->addError("pessoaTelefone", "Informe telefone") : null;

        $cpf = $this->getParam(@$r["cpf"]);
        if ($cpf) {
            $validCpf = new Eliti_Validate_Cpf();
            !$validCpf->isValid($cpf) ? $ee->addError("pessoaCpf", "CPF inválido") : null;
        } else {
            $ee->addError("pessoaCpf", "Informe o cpf");
        }

        $nascimento = $this->getParamDate(@$r["nascimento"]);
        !$nascimento ? $ee->addError("pessoaNascimento", "Informe a data de nascimento") : null;

        $ee->throwExceptionIfErrorExists();

        // imagem
        $imagem = $this->getParam(@$r["imagem"]);
        $delFoto = $this->getParamBool(@$r["delFoto"]);

        //obs
        $obs = $this->getParam(@$r["obs"]);
        
        /**
         * SALVAR
         */
        $this->db->conectar();

        if ($id > 0) {
            $query = "
			UPDATE " . self::TABLE . "
			SET
                            nome = '" . $this->db->escape($nome) . "',
                            email = '" . $this->db->escape($email) . "',
                            telefone = '" . $this->db->escape($telefone) . "',
                            cpf = '" . $this->db->escape($cpf) . "',
                            nascimento = " . Eliti_Date::sql($nascimento) . ",
                            obs = '" . $this->db->escape($obs) . "'    
			WHERE id = $id
                ";
        } else {
            $query = "
			INSERT INTO " . self::TABLE . " (nome, email, telefone, cpf, nascimento, obs)
			VALUES (
                            '" . $this->db->escape($nome) . "',
                            '" . $this->db->escape($email) . "',
                            '" . $this->db->escape($telefone) . "',
                            '" . $this->db->escape($cpf) . "',
                            " . Eliti_Date::sql($nascimento) .",
                            '" . $this->db->escape($obs) ."'    
                        )
                ";
        }

        $this->db->executar($query);

        $id = ($this->db->getLastId() > 0) ? $this->db->getLastId() : $id;

        /**
         * IMAGEM
         */
        if (@$imagem["file"]) {

            $extensao = $imagem["type"];
            $caminho_completo = PUBLIC_PATH . "/uploads/pessoa/$id.$extensao";
            $caminho_completoJPG = PUBLIC_PATH . "/uploads/pessoa/$id.jpg";

            $data = $r["imagem"]["file"];

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents($caminho_completo, $data);

            /**
             * Convert to JPG
             */
            if ($extensao === 'png') { // from png
                $image = imagecreatefrompng($caminho_completo);
                imagejpeg($image, $caminho_completoJPG, 90);
                imagedestroy($image);
                unlink($caminho_completo);
            }
//            else if ($extensao === 'gif') { // from gif
//                $image = imagecreatefromgif($caminho_completo);
//                imagejpeg($image, $caminho_completoJPG, 90);
//                imagedestroy($image);
////                unlink($caminho_completo);
//            }

            $this->db->executar("UPDATE pessoa SET time = '" . time() . "' WHERE id = $id");
        } else if ($delFoto) {
            $caminho_completoJPG = PUBLIC_PATH . "/uploads/pessoa/$id.jpg";
            @unlink($caminho_completoJPG);
        }

        return $id;
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
