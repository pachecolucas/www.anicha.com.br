<?php

include_once 'AbstractController.php';

class AtendimentoController extends AbstractController {

    public function indexAction() {
        $objServicos = new Servicos();
        $this->view->servicos = $this->getEventosByIds($objServicos->getAtentimentos());
    }
    
    public function amanaeAction() {
        $this->view->evento = $this->getEvento(23);
//        Eliti::print_r($this->view->evento);
    }

    public function reikiAction() {
        $this->view->evento = $this->getEvento(24);
//        Eliti::print_r($this->view->evento);
    }

    public function barraDeAccessAction() {
        $this->view->evento = $this->getEvento(25);
//        Eliti::print_r($this->view->evento);
    }

    public function respiracaoIntegrativaAction() {
        $this->view->evento = $this->getEvento(26);
//        Eliti::print_r($this->view->evento);
    }

    public function coachingDeVidaAction() {
        $this->view->evento = $this->getEvento(28);
//        Eliti::print_r($this->view->evento);
    }
    
    public function frequenciasDeBrilhoAction() {
        $this->view->evento = $this->getEvento(22);
//        Eliti::print_r($this->view->evento);
    }

    public function apometriaAction() {
        $this->view->evento = $this->getEvento(136);
//        Eliti::print_r($this->view->evento);
    }
    public function polaridadeSistemicaAction() {
        $this->view->evento = $this->getEvento(137);
//        Eliti::print_r($this->view->evento);
    }
    public function pteAction() {
        $this->view->evento = $this->getEvento(138);
//        Eliti::print_r($this->view->evento);
    }

}
