<?php

class Eliti_Service {

    /**
     * Database Manager
     * @var Eliti_Db
     */
    protected $db;
    protected $lang;

    public function __construct() {
        $config = $this->getBdConfig();
        $dbClassName = Eliti_Db::getType($config->getType());
        $this->db = new $dbClassName($config);
        $this->init();
    }

    /**
     * 
     * @return Eliti_Config_Db_Abstract
     */
    protected function getBdConfig() {
        $dbConfigName = $this->getModelName() . "_Config_Db";
        return new $dbConfigName;
    }

    protected function init() {
        
    }

    protected function getModelName() {
        $array = explode("_", get_class($this));
        return $array[0];
    }

    /**
     * Retorna o Locale da Aplicação
     *
     * @return Zend_Locale
     */
    protected function getLocale() {
        $localeSession = new Zend_Session_Namespace('Eliti_Application_Session');
        return $localeSession->locale;
    }

    protected function getLang() {
        return $this->getLocale()->getLanguage();
    }

    protected function getSession() {
        $class = explode("_", get_class($this));
        return Eliti::getInstance()->getModel($class[0])->getSession();
    }

    /**
     * Método criado em 13/02/2012 para facilitar a chamada de um service
     * 
     * @return Eliti_Backend_Service
     */
    protected function getService($serviceName, $modelName = null) {
        if ($modelName) { // retorne um servive de um model específico
            return Eliti::getInstance()->getModel($modelName)->getService($serviceName);
        } else { // retorne um service desse model
            $class = explode("_", get_class($this));
            return Eliti::getInstance()->getModel($class[0])->getService($serviceName);
        }
    }

    public function locale($ts, $string) {
        if (LOCALE == LocaleController::pt_BR) {
            return $string;
        } else {
            return $ts[LOCALE][$string];
        }
    }

    public function getParam($param) {
        return is_string($param) ? trim($param) : $param;
    }

    public function getParamFloat($param, $convert = false) {
        if ($convert) {
            return (float) str_replace(",", ".", str_replace(".", "", $param));
        } else {
            return (float) str_replace(",", "", $param);
        }
    }

    public function getParamInt($param) {
        return (int) str_replace(".", "", $this->getParam($param));
    }

    public function getParamDate($param) {
        return Eliti_Date::create($param, Eliti_Date::SQL);
//        return Eliti_Date::create($this->getParam($key), Eliti_Date::BR_SHORT_YEAR);
    }

    public function getParamDateTime($param) {
        $param = str_replace("T", " ", $param);
        return Eliti_Date::create($param, Eliti_Date::SQL_DATE_TIME);
//        return Eliti_Date::create($this->getParam($key), Eliti_Date::BR_SHORT_YEAR);
    }

    public function getParamBool($param) {
        return $param == "1" || $param == "true";
    }

    /**
     * Método criado em 09/01/2013 para facilitar a paginação
     * Desta forma quando há um LEFT JOIN é possível selecionar a quantidade correta de registros
     * sem considerar ids repetidos devido a utilização do JOIN
     * 
     * @param string $tableName
     * @param string $tableNameAs
     * @param string $columnBaseName
     * @param int $pagina
     * @return string
     */
//    protected function defineLimit($tableName, $tableNameAs, $columnBaseName, $pagina, $where = "", $join = "", $orderBy = null) {
//        $idKey = $tableNameAs . "." . $columnBaseName;
//        $inicio = ($pagina > 0) ? ceil(($pagina - 1) * EF_EXIBIR) : 0;
//        $orderBy = $orderBy?$orderBy:$idKey;
//        $WHERE = $where?" WHERE 1 AND $where ":"";
//        return " AND $idKey IN (
//                                    SELECT $idKey 
//                                    FROM (
//                                          SELECT $idKey 
//                                          FROM $tableName AS $tableNameAs
//                                          $join
//                                          $WHERE
//                                          GROUP BY $idKey
//                                          ORDER BY $orderBy LIMIT $inicio, " . EF_EXIBIR . "
//                                    ) AS $tableNameAs
//                                )";
//    }
}
