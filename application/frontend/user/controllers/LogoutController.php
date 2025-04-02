<?php

class User_LogoutController extends Eliti_Controller {

    public function indexAction() {
        $this->getModel("User")->getService("Login")->logout();
        $this->_redirect("/epanel");
    }

}