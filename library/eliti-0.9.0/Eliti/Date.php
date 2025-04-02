<?php

class Eliti_Date {

    const BR = "d/m/Y";
    const SQL = "Y-m-d";
    const SQL_DATE_TIME = "Y-m-d H:i:s";
    const BR_SHORT_YEAR = "d/m/y";

    public static $MESES = array(1 => "Jan", 2 => "Fev", 3 => "Mar", 4 => "Abr", 5 => "Mai", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Set", 10 => "Out", 11 => "Nov", 12 => "Dez");
    public static $DIAS_DA_SEMANA = array(1 => "Seg", 2 => "Ter", 3 => "Qua", 4 => "Qui", 5 => "Sex", 6 => "Sáb", 0 => "Dom");

    /**
     *
     * @var DateTime
     */
    private $date;

    public static function isValid($date, $format = self::BR) {
        if ($date == "0000-00-00" || $date == "0000-00-00 00:00:00" || empty($date)) {
            return false;
        }
        return self::isValidDateTimeString($date, $format);
//        switch ($format) {
//            case self::BR:
//                $splitedDate = explode("/", $date);
//                if (is_int($splitedDate[1]))
//                    return checkdate($splitedDate[1], $splitedDate[0], $splitedDate[2]);
//            case self::SQL:
//                $splitedDate = explode("-", $date);
//                return checkdate($splitedDate[1], $splitedDate[2], $splitedDate[0]);
//            default:
//                throw new Exception("Eliti_Date::isValid() Tentou validar uma data de tipo desconhecido ($format)");
//        }
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
    
    public function formatDbDate() {
        return $this->date->format(self::SQL);
    }
    
    public function formatDbDateTime() {
        return $this->date->format(self::SQL_DATE_TIME);
    }

    public static function sql($date) {
        if ($date instanceof Eliti_Date) {
            return "'{$date->format(self::SQL)}'";
        } else {
            return "NULL";
        }
    }
    
    public static function sqlDateTime($date) {
        if ($date instanceof Eliti_Date) {
            return "'{$date->format(self::SQL_DATE_TIME)}'";
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
        return floor($datediff / (60 * 60 * 24));
    }

    public function getTimestamp() {
        return (int) $this->date->getTimestamp();
    }

    public function mes() {
        return self::$MESES[$this->format("n")];
    }

    public function dia() {
        return self::$DIAS_DA_SEMANA[$this->format("w")];
    }

    public function isBiggerThan(Eliti_Date $baseDate = null, $okIfEquals = true) {
        if (!$baseDate) {
            $baseDate = Eliti_Date::today();
        }
        $thisDateTimestamp = $this->getTimestamp();
        $baseDateTimestamp = $baseDate->getTimestamp();

        return ($thisDateTimestamp > $baseDateTimestamp) || ($okIfEquals && $thisDateTimestamp == $baseDateTimestamp);
    }

    /**
     * Check if a string is a valid date(time)
     *
     * DateTime::createFromFormat requires PHP >= 5.3
     *
     * @param string $str_dt
     * @param string $str_dateformat
     * @param string $str_timezone (If timezone is invalid, php will throw an exception)
     * @return bool
     */
    private static function isValidDateTimeString($str_dt, $str_dateformat) {
        $str_timezone = date_default_timezone_get();
        $date = DateTime::createFromFormat($str_dateformat, $str_dt, new DateTimeZone($str_timezone));
        $lastErrors = DateTime::getLastErrors();
        return $date && $lastErrors["warning_count"] == 0 && $lastErrors["error_count"] == 0;
    }

}
