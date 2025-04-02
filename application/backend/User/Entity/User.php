<?php

class User_Entity_User implements Eliti_User {

    /**
     * @var Zend_Locale
     */
    public $locale;
    public $id;
    public $nome;
    public $email;
    public $img;
    public $telefones;
    public $tipo;
    public $admin = false;
    public $codigo;
    public $codigoData;
    public $blocked;

    public function getName() {
        return $this->nome;
    }

    public function getId() {
        return $this->id;
    }

    public function __construct(array $r) {
        $this->id = $r["u_id"];
        $this->nome = $r["u_nome"];
        $this->email = $r["u_email"];
        $this->img = $r["u_img"];
        $this->telefones = $r["u_telefones"];
        $this->tipo = $r["u_tipo"];
        $this->admin = ($r["u_tipo"] == 900) ? true : false;

        $this->codigo = $r["u_codigo"];
        $this->codigoData = $r["u_codigo_data"];
        $locale = $r["u_locale"];
        if (!LocaleController::isValidLocale($locale)) {
            throw new Exception("User_Entity_User->__construct(): locale inválido - " . $locale . ".");
        }
        $this->locale = new Zend_Locale($locale);

        $blocked = (int) $r["u_blocked"];
        $this->blocked = $blocked === 1 ? true : false;
    }

    public function admin() {
        return $this->admin;
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
