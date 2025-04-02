<?php

class Zend_View_Helper_Resumir extends Zend_View_Helper_Abstract
{

    public function resumir($texto, $maxLength = 100) {
        if (strlen($texto) > $maxLength) {
            return substr($texto, 0, $maxLength)."...";
        }
        return $texto;
    }
    
}