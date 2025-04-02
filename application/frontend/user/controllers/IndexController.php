<?php

class User_IndexController extends Eliti_Controller {

    public function indexAction() {
        if (Eliti::getInstance()->hasUser()) {
            Eliti::print_r(Eliti::getInstance()->getUser());
        } else {
            die("Usuário não está logado!");
        }
    }

    public function esqueciAction() {
        
    }

    public function loginAction() {
        
    }

    public function entrarAction() {
        try {
            $email = $this->getParam("email");
            $senha = $this->getParam("xyz");
            $this->getModel("User")->login($email, $senha);
            die("/" . MODULE_ADMIN);
        } catch (Eliti_Backend_Exception $e) {
            $this->ajaxHttpSuccess($e->toJson());
        } catch (Exception $e) {
            $this->ajaxHttpError($e->getMessage(), 501);
        }
    }

    public function sairAction() {
        $this->getModel("User")->getService("Login")->logout();
        $this->_redirect("/sucar");
    }

}