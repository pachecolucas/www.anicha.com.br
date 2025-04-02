<?php

class Zend_View_Helper_Real extends Zend_View_Helper_Abstract
{

    public function real($valor, $showSymbol = false) {
    	$money = ($showSymbol)?"R$ ":"";
    	return $money.number_format($valor,2,',','.');
    }
    
}