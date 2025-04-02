<?php

class Ambiente_Service_OsService extends Eliti_Service_Crud_Rest {

    /**
     * CONFIGURAÇÕES
     */
    const TABLE = "os";
    const TABLE_AS = "os";
    const CLASSE = "Ambiente_Entity_Os";

    public static function select() {
        return array(
            self::TABLE_AS . ".id                   AS " . self::TABLE_AS . "_id",
            self::TABLE_AS . ".num_os               AS " . self::TABLE_AS . "_numOs",
            self::TABLE_AS . ".num_serie            AS " . self::TABLE_AS . "_numSerie",
            self::TABLE_AS . ".modelo               AS " . self::TABLE_AS . "_modelo",
            self::TABLE_AS . ".fabricante           AS " . self::TABLE_AS . "_fabricante",
            self::TABLE_AS . ".has_w                AS " . self::TABLE_AS . "_hasW",
            self::TABLE_AS . ".has_l                AS " . self::TABLE_AS . "_hasL",
            self::TABLE_AS . ".has_m                AS " . self::TABLE_AS . "_hasM",
            self::TABLE_AS . ".sintomas             AS " . self::TABLE_AS . "_sintomas",
            self::TABLE_AS . ".servicos             AS " . self::TABLE_AS . "_servicos",
            self::TABLE_AS . ".observacoes          AS " . self::TABLE_AS . "_obs",
            self::TABLE_AS . ".fechada              AS " . self::TABLE_AS . "_fechada",
            self::TABLE_AS . ".created              AS " . self::TABLE_AS . "_created",
            self::TABLE_AS . ".updated              AS " . self::TABLE_AS . "_updated",
            "osCliente.id                           AS osCliente_id",
            "osCliente.nome                         AS osCliente_nome",
        );
    }

    protected function getSearchColumns() {
        return self::TABLE_AS . ".id," .
                self::TABLE_AS . ".num_os," .
                self::TABLE_AS . ".modelo," .
                self::TABLE_AS . ".fabricante," .
                "osCliente.nome";
    }

    public static function join() {
        return "
            INNER JOIN cliente AS osCliente ON os.cliente = osCliente.id
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
        return self::TABLE_AS . ".num_os," .
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
        /**
         * VALIDAÇÃO
         */
        $ee = new Eliti_Exception();

        // id
        $id = $this->getParamInt(@$r["id"]);
        // Número de série
        $numSerie = $this->getParam(@$r["numSerie"]);
        // Modelo
        $modelo = $this->getParam(@$r["modelo"]);
        // Fabricante
        $fabricante = $this->getParam(@$r["fabricante"]);
        // Has Windows
        $hasW = $this->getParamBool(@$r['hasW']) ? 1 : 0;
        // Has Linux
        $hasL = $this->getParamBool(@$r['hasL']) ? 1 : 0;
        // Has Mac
        $hasM = $this->getParamBool(@$r['hasM']) ? 1 : 0;
        // Sintomas
        $sintomas = $this->getParam(@$r['sintomas']);
        // Serviços
        $servicos = $this->getParam(@$r['servicos']);
        // Observações
        $obs = $this->getParam(@$r['obs']);

        $ee->throwExceptionIfErrorExists();

        /**
         * SALVAR
         */
        $this->db->conectar();

        if ($id > 0) {
            $query = "
			UPDATE " . self::TABLE . "
			SET
                            num_serie = '" . $this->db->escape($numSerie) . "',
                            modelo = '" . $this->db->escape($modelo) . "',
                            fabricante = '" . $this->db->escape($fabricante) . "',
                            has_w = " . $this->db->escape($hasW) . ",
                            has_l = " . $this->db->escape($hasL) . ",
                            has_m = " . $this->db->escape($hasM) . ",
                            sintomas = '" . $this->db->escape($sintomas) . "',
                            servicos = '" . $this->db->escape($servicos) . "',
                            observacoes = '" . $this->db->escape($obs) . "',
                            updated = NOW()
			WHERE id = $id
                ";
        } else {
            $query = "
			INSERT INTO " . self::TABLE . " (num_os, num_serie, modelo, fabricante, has_w, has_l, has_m, sintomas, servicos, observacoes, fechada, created, updated)
			VALUES (
                            '" . $this->db->escape(date("ymd.Hi")) . "',
                            " . $this->db->escape($numSerie) . ",
                            '" . $this->db->escape($modelo) . "',
                            '" . $this->db->escape($fabricante) . "',
                            " . $this->db->escape($hasM) . ",
                            " . $this->db->escape($hasL) . ",
                            " . $this->db->escape($hasM) . ",
                            '" . $this->db->escape($sintomas) . "',
                            '" . $this->db->escape($servicos) . "',
                            '" . $this->db->escape($obs) . "',
                            " . $this->db->escape(0) . ",
                            NOW(),
                            NOW()
                        )
                ";
        }

//        die($query);

        $this->db->executar($query);

        $id = ($this->db->getLastId() > 0) ? $this->db->getLastId() : $id;

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
