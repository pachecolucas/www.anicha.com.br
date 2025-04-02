<?php

/**
 * Por enquanto, esta classe está preparada para tratar apenas casos como os do Portal IONICS
 */
class Eliti_Response_Error_Access extends Eliti_Response_Error {
    
    public $module;
    public $controller;
    public $action;
    public $method;
    public $tipo;
    public $tipoId;
    
    /**
     * @var User_Entity_User 
     */
    public $user = array();
    
    public function __construct(Eliti_Exception_Access $e, User_Entity_User $user) {
        parent::__construct();
        $this->module       = $e->module;
        $this->controller   = $e->controller;
        $this->action       = $e->action;
        $this->method       = $e->method;
        $this->tipo         = $e->tipo;
        $this->tipoId       = $e->tipoId;
        
        $this->user = $user;
        
    }
    
}
