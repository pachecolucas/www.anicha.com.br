<?php

class User_LoginController extends Eliti_Controller {

    public function indexAction() {
    }

    public function authenticateAction() {
        try {
            $email = $this->getParam("email");
            $senha = $this->getParam("xyz");
            $this->getModel("User")->login($email, $senha);
            $response = new Eliti_Response_Success_Redirect("/epanel");
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation_Special($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }
    
}