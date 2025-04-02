<?php

class Eliti_Date_1 {
    
    const BR = "d/m/Y";
    const SQL = "Y-m-d";
    
    public static $MESES = array (1 => "Jan", 2 => "Fev", 3 => "Mar", 4 => "Abr", 5 => "Mai", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Set", 10 => "Out", 11 => "Nov", 12 => "Dez");
    public static $DIAS_DA_SEMANA = array (1 => "Seg",2 => "Ter",3 => "Qua",4 => "Qui",5 => "Sex",6 => "Sáb",0 => "Dom");
    
    /**
     *
     * @var DateTime
     */
    private $date;
    
    public static function isValid($date, $format = self::BR) {
        if ($date == "0000-00-00" || DateTime::createFromFormat($format, $date) == false) {
            return false;
        }
        return true;
    }
    
    private function __construct($date, $format = self::BR) {
        $this->date = DateTime::createFromFormat($format, $date);
    }
    
    public static function today() {
        $date = date(Eliti_Date::BR);
        return self::create($date);
    }
    
    public static function create($date = null, $format = self::BR) {
        if (self::isValid($date, $format)) {
            return new self($date, $format);
        } else {
            return null;
        }
    }
    
    public static function sql($date) {
        if ($date instanceof Eliti_Date) {
            return "'{$date->format(self::SQL)}'";
        } else {
            return "NULL";
        }
    }
    
    public function format($format = self::BR) {
        return $this->date->format($format);
    }
    
    public function __toString() {
        return $this->format();
    }
    
    public function difDaysFrom(Eliti_Date $date = null) {
        $baseDate = $date;
        if (!$baseDate) {
            $baseDate = Eliti_Date::today();
        }
        $datediff = $baseDate->getTimestamp() - $this->getTimestamp();
        return floor($datediff/(60*60*24));
    }
    
    public function getTimestamp() {
        return (int)$this->date->getTimestamp();
    }
    
    public function mes() {
        return self::$MESES[$this->format("n")];
    }
    
    public function dia() {
        return self::$DIAS_DA_SEMANA[$this->format("w")];
    }
    
    public function ehMaiorQue(Eliti_Date $date = null, $equals = true) {
        $baseDate = $date;
        if (!$baseDate) {
            $baseDate = Eliti_Date::today();
        }
        if ($equals && $this->getTimestamp() >= $baseDate->getTimestamp()) {
            return true;
        } else if (!$equals &&  $this->getTimestamp() > $baseDate->getTimestamp()) { 
            return true;
        } else {
            return false;
        }
    }
    
    
    
}