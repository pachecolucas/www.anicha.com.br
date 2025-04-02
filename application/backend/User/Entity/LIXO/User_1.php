<?php

class User_Entity_User implements Eliti_User {
    
    /**
     * @var Zend_Locale
     */
    public $locale;

    public $id;
    public $nome;
    public $email;
    public $telefones;
    
    public $tipo;
    public $admin = false;
    
    public $codigo;
    public $codigoData;
    
    /**
     * @var User_Entity_Company 
     */
    private $defaultCompanyId;
    public $companies = array();
    
    public function getName() {
        return $this->nome;
    }
    
    public function getId() {
        return $this->id;
    }

    public function __construct(array $r) {
        $this->id           = $r["u_id"];
        $this->nome         = $r["u_nome"];
        $this->email        = $r["u_email"];
        $this->telefones    = $r["u_telefones"];
        $this->tipo         = $r["u_tipo"];
        $this->admin        = ($r["u_tipo"] == 900) ? true : false;
        
        $this->codigo       = $r["u_codigo"];
        $this->codigoData   = $r["u_codigo_data"];
        $locale             = $r["u_locale"];
        if (!LocaleController::isValidLocale($locale)) {
            throw new Exception("User_Entity_User->__construct(): locale inválido - ".$locale.".");
        }
        $this->locale       = new Zend_Locale($locale);
    }

    public function admin() {
        return $this->admin;
    }
    
    public function addCompany(User_Entity_Company $c) {
        $this->companies[$c->id] = $c;
        if ($c->isDefault()) {
            $this->defaultCompanyId = $c->id;
        }
    }
    
    public function hasCompany($idCompany) {
        return array_key_exists($idCompany, $this->companies);
    }
    
    /**
     * 
     * @return User_Entity_Company
     * @throws Exception
     */
    public function getCompanyDefault() {
        if (!array_key_exists($this->defaultCompanyId, $this->companies)) {
            throw new Exception("Empresa padrão deste usuário não foi definida.");
        }
        return $this->companies[$this->defaultCompanyId];
    }
    
    /**
     * 
     * @return boolean
     */
    public function hasLocale() {
        return $this->locale instanceof Zend_Locale;
    }
    
    /**
     * 
     * @return Zend_Locale
     * @throws Exception
     */
    public function getLocale() {
        if (!$this->hasLocale()) {
            throw new Exception("User_Entity_User->getLocale() - locale não definido");
        }
        return $this->locale;
    }

}