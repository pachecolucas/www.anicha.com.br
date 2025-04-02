<?php

class User_Entity_Company {

    public $id;
    public $nome;
    private $isDefault = false;
    
    /**
     * @var User_Entity_Config 
     */
    public $config;
    
    public function __construct(array $r) {
        $this->id       = $r["company_id"];
        $this->nome     = $r["company_nome"];
        $this->config   = new User_Entity_Config($r);
        
        $this->isDefault = ($r["default_company_id"] == 1)?true:false;
    }
    
    public function isDefault() {
        return $this->isDefault;
    }

}