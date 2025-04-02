<?php
/**
 * Para o caso do formulário de login, por exemplo, onde os erros são listados 
 * todos juntos deve-se usar esta classe
 */
class Eliti_Response_Error_Validation_Special extends Eliti_Response_Error_Validation {
    
    public function __construct(Eliti_Exception $ee) {
        parent::__construct($ee);
    }
    
}
