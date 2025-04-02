<?php

include_once 'AbstractController.php';

class HolopraxisController extends AbstractController {

    public function indexAction() {
        $objServicos = new Servicos();
        $this->view->servicos = $this->getEventosByIds($objServicos->getHolopraxis());
    }

//     public function meditacaoAction() {
//         $this->view->evento = $this->getEvento(31);
// //        Eliti::print_r($this->view->evento);
//     }

    public function meditacaoAction() {
        $this->view->evento = $this->getEvento(31);
    }

    public function meditacaoPleiadianaAction() {
        $this->view->evento = $this->getEvento(135);
    }

    public function dancasCircularesAction() {
        $this->view->evento = $this->getEvento(27);
//        Eliti::print_r($this->view->evento);
    }

    public function yogaAction() {
        $this->view->evento = $this->getEvento(32);
//        Eliti::print_r($this->view->evento);
    }

}
