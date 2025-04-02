<?php

include_once 'AbstractController.php';

class ServicosController extends AbstractController {

    public function indexAction() {
        $objServicos = new Servicos();
        $this->view->servicos = $this->getEventosByIds($objServicos->getAll());
//        Eliti::print_r($this->view->servicos);
    }

}
