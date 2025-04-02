<?php

class Poa_Service_CgcTipoService extends Eliti_Service_Crud_Rest {

    /**
     * CONFIGURAÇÕES
     */
    const TABLE = "cgc_tipo";
    const TABLE_AS = "cgc_tipo";
    const CLASSE = "Poa_Entity_CgcTipo";

    public static function select() {
        return array(
            self::TABLE_AS . ".id                   AS " . self::TABLE_AS . "_id",
            self::TABLE_AS . ".nome                 AS " . self::TABLE_AS . "_nome",
        );
    }

    protected function getSearchColumns() {
        return self::TABLE_AS . ".nome," .
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
        return self::TABLE_AS . ".id," .
                self::TABLE_AS . ".nome";
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

