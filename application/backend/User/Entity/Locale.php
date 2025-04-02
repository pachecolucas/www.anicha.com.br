<?php

class User_Entity_Locale {

    const PT = 1;
    const ES = 2;
    const EN = 3;
    const FR = 4;
    const IT = 5;

    public static $LOCALES = array(
        self::PT => "pt",
        self::ES => "es",
        self::EN => "en",
        self::FR => "fr",
        self::IT => "it",
    );

    public $id;
    public $nome;
    public $sigla;
    public $icon;

    public function __construct(array $r, $suffix = "") {
        $this->id = (int) $r["locale_id$suffix"];
        $this->nome = $r["locale_nome$suffix"];
        $this->sigla = $r["locale_sigla$suffix"];
        $this->icon = "/user/locale/{$this->sigla}.png";
    }
    
    public function __toString() {
        return $this->sigla;
    }

}
