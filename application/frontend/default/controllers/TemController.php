<?php

include_once 'AbstractController.php';

class TemController extends AbstractController
{

    public function indexAction()
    {
        $this->_forward("tem", "formacao");
    }

}
