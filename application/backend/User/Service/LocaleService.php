<?php

class User_Service_LocaleService extends Eliti_Service_Crud_Rest {

    /**
     * CONFIGURAÇÕES
     */
    const TABLE = "locale";
    const TABLE_AS = "locale";
    const CLASSE = "User_Entity_Locale";

    public static function select($suffix = "") {
        return array(
            /**
             * USER
             */
            "locale$suffix.id                   AS locale_id$suffix",
            "locale$suffix.nome                 AS locale_nome$suffix",
            "locale$suffix.sigla                AS locale_sigla$suffix",
        );
    }

    protected function getSearchColumns() {
        return "locale.id, locale.nome, locale.sigla";
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
        return "locale.id";
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
