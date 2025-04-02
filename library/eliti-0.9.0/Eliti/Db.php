<?php

abstract class Eliti_Db {
    
    const MySQL = 1;
    const PgSQL = 2;
    const MsSQL = 3;
    
    public static $TYPES = array(
        self::MySQL => "Eliti_Db_Mysql",
        self::PgSQL => "Eliti_Db_Pgsql",
        self::MsSQL => "Eliti_Db_Mssql",
    );

    /**
     * @var Eliti_Config_Db
     */
    protected $config;

    public function __construct(Eliti_Config_Db_Abstract $config) {
        $this->config = $config;
    }

    abstract public function conectar();

    abstract public function executar($query, $returnArray = true);

    abstract public function desconectar();

    abstract public function getLastId();
    
    public function getConfig() {
        return $this->config;
    }
    
    public static function typeExists($type) {
        return array_key_exists($type, self::$TYPES);
    }
    
    public static function getType($type) {
        if(!self::typeExists($type)) {
            throw new Exception("Eliti_Db::getType() - Type ({$type}) não existe!");
        }
        return self::$TYPES[$type];
    }
    
    abstract function isEmpty($query);
}
