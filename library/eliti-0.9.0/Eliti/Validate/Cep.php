<?php

class Eliti_Validate_Cep extends Zend_Validate_Abstract {

    const INVALID = 'intInvalid';
    const NOT_INT = 'notInt';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "Invalid type given. CEP expected",
        self::NOT_INT => "'%value%' does not appear to be an CEP",
    );

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is a valid CPF
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($cep) {
        // expressao regular para avaliar o cep
        return preg_match("^([0-9]){5}-([0-9]){3}$^", $cep)?true:false;
    }
    
    public function removeMask($cep) {
        return str_replace("-", "", $cep);
    }
    
    public function addMask($cep) {
        if (strlen($cep) != 8 || !is_numeric($cep)) {
            return null;
        }
        $maskedCEP = substr($cep, 0, 5). "-";
        $maskedCEP .= substr($cep, 5, 3);
        
        return $maskedCEP;
    }

}
