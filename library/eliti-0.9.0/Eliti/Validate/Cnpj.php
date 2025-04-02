<?php

class Eliti_Validate_Cnpj extends Zend_Validate_Abstract {
    const INVALID = 'intInvalid';
    const NOT_INT = 'notInt';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "Invalid type given. CPF expected",
        self::NOT_INT => "'%value%' does not appear to be an CPF",
    );

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is a valid CPF
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($cnpj) {
    	if (strlen($cnpj) <> 18) return 0; 
	    $soma1 =	($cnpj[0] * 5) + 
	   			 	($cnpj[1] * 4) + 
	   			 	($cnpj[3] * 3) + 
					($cnpj[4] * 2) + 
					($cnpj[5] * 9) + 
					($cnpj[7] * 8) + 
					($cnpj[8] * 7) + 
					($cnpj[9] * 6) + 
					($cnpj[11] * 5) + 
					($cnpj[12] * 4) + 
					($cnpj[13] * 3) + 
					($cnpj[14] * 2); 
					
		$resto = $soma1 % 11; 
	    $digito1 = $resto < 2 ? 0 : 11 - $resto; 
	    $soma2 =	($cnpj[0] * 6) + 
					($cnpj[1] * 5) + 
					($cnpj[3] * 4) + 
					($cnpj[4] * 3) + 
					($cnpj[5] * 2) + 
					($cnpj[7] * 9) + 
					($cnpj[8] * 8) + 
					($cnpj[9] * 7) + 
					($cnpj[11] * 6) + 
					($cnpj[12] * 5) + 
					($cnpj[13] * 4) + 
					($cnpj[14] * 3) + 
					($cnpj[16] * 2); 
	    $resto = $soma2 % 11; 
	    $digito2 = $resto < 2 ? 0 : 11 - $resto; 
	    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2)); 
    }
    
    public function removeMask($cnpj) {
        return str_replace("/", "", str_replace(".", "",str_replace("-", "", $cnpj)));
    }
    
    public function addMask($cnpj) {
        if (strlen($cnpj) != 14 || !is_numeric($cnpj)) {
            return null;
        }
        $maskedCNPJ = substr($cnpj, 0, 2). ".";
        $maskedCNPJ .= substr($cnpj, 2, 3). ".";
        $maskedCNPJ .= substr($cnpj, 5, 3)."/";
        $maskedCNPJ .= substr($cnpj, 8, 4)."-";
        $maskedCNPJ .= substr($cnpj, 12, 2);
        
        return $maskedCNPJ;
    }
    
}
