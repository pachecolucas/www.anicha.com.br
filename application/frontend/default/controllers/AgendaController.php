<?php

include_once 'AbstractController.php';

class AgendaController extends AbstractController {

    public function indexAction() {
        $eventos = $this->getEventos();
        $this->view->eventos = $this->prepararEventos($eventos);
    }
    
    public function participarAction() {
        $id = $this->getParamInt("id");
        $this->view->evento = $this->getEventoNoCalendario($id);
//        Eliti::print_r($this->view->evento);
    }

}
