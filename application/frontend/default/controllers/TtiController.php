<?php

include_once 'AbstractController.php';

class TtiController extends AbstractController
{

    public function indexAction()
    {
        $this->_forward("tti", "formacao");
    }

    public function turma2018Action()
    {
        $this->_forward("tti1", "formacao");
    }

}
